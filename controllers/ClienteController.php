<?php

namespace Controllers;

use Model\ActiveRecord;
use Model\Categoria;
use Model\Libro;
use Model\LibroLista;
use Model\Lista;
use Model\Provincia;
use Model\Usuario;
use MVC\Router;

use function PHPSTORM_META\elementType;

class ClienteController{
    public static function index(Router $router){
        $idusuario=$_SESSION['idUsuario'];
        isAuth();
        
        if($idusuario!=$_GET['usuario']){
            header('Location:/');
        }
        
        $alertas=[];
        $usuario=Usuario::where('idUsuario',$idusuario);
        $provincias=Provincia::all();
        $categorias=Categoria::all();
        $provinciaCliente=Provincia::where('id',$usuario->idProvincia);
        $listaD=Lista::whereAnd('idUsuario','deseo',$idusuario,"1");
        $listaC=Lista::whereAnd('idUsuario','deseo',$idusuario,"0");
        $router->render('/cliente/miCuenta',[
            'usuario'=>$usuario,
            'provincias'=>$provincias,
            'provinciaCliente'=>$provinciaCliente,
            'categorias'=>$categorias,
            'listaD'=>$listaD,
            'listaC'=>$listaC
        ]);
    }

    public static function actualizar(Router $router){
        isAuth();
        $provincias=Provincia::all();
        $usuario=Usuario::where('idUsuario',$_SESSION['idUsuario']);
        $alertas=[];
        $resultado=null;
        $provinciaCliente=Provincia::where('id',$usuario->idProvincia);

        $passwordViejo= $usuario->password;
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $usuario->sincronizar($_POST);
            $provincia=($_POST['Provincia']);
            $idProvincia=$provincia['opciones'];
            $usuario->idProvincia=$idProvincia;
            if($_POST['password']==''){
                $usuario->password=$passwordViejo;
                $alertas=$usuario->validarCuenta();
                if(empty($alertas)){
                    $resultado=$usuario->guardar($usuario->idUsuario);
                }
            }else{
                $alertas=$usuario->validarCuenta();
                if(empty($alertas)){
                    $usuario->hashPassword();
                    $resultado=$usuario->guardar($usuario->idUsuario);


                }
            }        
        }
        $router->render('/cliente/actualizarCuenta',[
            'usuario'=>$usuario,
            'alertas'=>$alertas,
            'resultado'=>$resultado,
            'provincias'=>$provincias,
            'provinciaCliente'=>$provinciaCliente
        ]);

    }

    
    

    public static function buscar(Router $router){
        $idusuario=$_SESSION['idUsuario'];
        $listaD=Lista::whereAnd('idUsuario','deseo',$idusuario,"1");
        $listaC=Lista::whereAnd('idUsuario','deseo',$idusuario,"0");
        $alertas=[];
        $hidenPag=true;
        $numPaginas=0;
        $librosPagina=1;
       
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $provincia=($_POST['Provincia']);
            $opcion=$_POST['opcion']; //Nos dice si la busqueda es de un match o no;
            if(strcmp($opcion,'match')==0){
                //Es un match
                if(!$listaD or !$listaC){
                    $alertas['error'][]='Para Buscar un Match no puedes tener listas bacias';
                }else{
                    $idProvincia=$provincia['opciones'];

                    header('Location:/cliente/buscar/match?Provincia='.$idProvincia);

                    /*
                    $idListaC=$listaC->idLista;
                    $idListaD=$listaD->idLista;
                    $idProvincia=$provincia['opciones'];
                    $resultado=Usuario::buscarMatch($idListaD,$idListaC,$idProvincia);
                    $numPaginas=ceil(count($resultado)/$librosPagina);
                    $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                    $idUsuarios=[];
                    $hidenPag=false;
                    $j=0;
                    $k=0;
                    
                    for($i=$limitInf;$i<$librosPagina;$i++){
                        $idUsuarios[$j]=$resultado[$i];
                        $j+=1;
                    }
                    */
                    
                }
                
            }else{
                $idProvincia=$provincia['opciones'];
                $categoria=$_POST['categoria'];
                $idCategoria=$categoria['opciones'];
                $autor=$_POST['autor'];
                $titulo=$_POST['titulo'];
                header('Location:/cliente/buscar/titulo?Provincia='.$idProvincia.'&Categoria='.$idCategoria.'&titulo='.$titulo.'&autor='.$autor);
            }
            
        }
        $router->render('/cliente/buscar',[
            'numPaginas'=>$numPaginas,
            'idUsuario'=>$idusuario,
            //'idUsuarios'=>$idUsuarios,
            //'alertas'=>$alertas,
            //'hidenPag'=>$hidenPag,
            //'idProvincia'=>$idProvincia

        ]);

    }
    public static function resultadoMatch(Router $router){
        $idusuario=$_SESSION['idUsuario'];
        $listaD=Lista::whereAnd('idUsuario','deseo',$idusuario,"1");
        $listaC=Lista::whereAnd('idUsuario','deseo',$idusuario,"0");
        $alertas=[];
        $hidenPag=true;
        $numPaginas=0;
        $librosPagina=1;
        $idProvincia=($_GET['Provincia']);
            
        $idListaC=$listaC->idLista;
        $idListaD=$listaD->idLista;
        $resultado=Usuario::buscarMatch($idListaD,$idListaC,$idProvincia);
        $numPaginas=ceil(count($resultado)/$librosPagina);
        $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
        $idUsuarios=[];
        $hidenPag=false;
        $j=0;
        $k=$limitInf+$librosPagina;
        for($i=$limitInf;$i<$k;$i++){
            $idUsuarios[$j]=$resultado[$k-1];
            $j+=1;
        }
                    
        $router->render('/cliente/buscar',[
            'numPaginas'=>$numPaginas,
            'idUsuario'=>$idusuario,
            'idUsuarios'=>$idUsuarios,
            'alertas'=>$alertas,
            'hidenPag'=>$hidenPag,
            'match'=>'0'

        ]);

    }

    public static function resultadoTitulo(Router $router){
        $idusuario=$_SESSION['idUsuario'];
        $alertas=[];
        $hidenPag=true;
        $numPaginas=0;
        $librosPagina=1;
        $idProvincia=($_GET['Provincia']);
        $idCategoria=($_GET['Categoria']);
        $titulo=($_GET['titulo']);
        $autor=$_GET['autor'];
        $idUsuarios=null;

        if($titulo){
            //Buscamos Por titulo,la categoria y el autor no importan
            if(strcmp($idProvincia,'-1')!=0){
                $libro=Libro::whereTitulo('titulo',strtoupper($titulo));
                $idLibro=$libro->idLibro;

                $resultado=Usuario::tituloProvincia($idLibro,$idProvincia,$idusuario);
                $numPaginas=ceil(count($resultado)/$librosPagina);
                $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                $idUsuarios=[];
                $hidenPag=false;
                $j=0;
                $k=$limitInf+$librosPagina;
                for($i=$limitInf;$i<$k;$i++){
                    $idUsuarios[$j]=$resultado[$k-1];
                    $j+=1;
                }
            
            }else{
                //solo buscamos por titulo
                $libro=Libro::whereTitulo('titulo',strtoupper($titulo));
                $idLibro=$libro->idLibro;

                $resultado=Usuario::titulo($idLibro,$idusuario);
                $numPaginas=ceil(count($resultado)/$librosPagina);
                $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                $idUsuarios=[];
                $hidenPag=false;
                $j=0;
                $k=$limitInf+$librosPagina;
                for($i=$limitInf;$i<$k;$i++){
                    $idUsuarios[$j]=$resultado[$k-1];
                    $j+=1;
                }
            }
                
        }else if(strcmp($idCategoria,'mantener')!=0){
            //Buscamos por categoria
            if(strcmp($idProvincia,'-1')!=0){
                //Buscamos por categoria y provincia
                $resultado=Usuario::categoriaProvincia($idCategoria,$idusuario,$idProvincia);
                $numPaginas=ceil(count($resultado)/$librosPagina);
                $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                $idUsuarios=[];
                $hidenPag=false;
                $j=0;
                $k=$limitInf+$librosPagina;
                if($resultado){
                    for($i=$limitInf;$i<$k;$i++){
                        $idUsuarios[$j]=$resultado[$k-1];
                        $j+=1;
                    }
                }    

                
            }else{
                $resultado=Usuario::categoria($idCategoria,$idusuario);
                $numPaginas=ceil(count($resultado)/$librosPagina);
                $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                $idUsuarios=[];
                $hidenPag=false;
                $j=0;
                $k=$limitInf+$librosPagina;
                for($i=$limitInf;$i<$k;$i++){
                    $idUsuarios[$j]=$resultado[$k-1];
                    $j+=1;
                }
            }
                
        }else if($autor){
            //Buscamos por autor
            if(strcmp($idCategoria,'mantener')!=0){
                if(strcmp($idProvincia,'-1')!=0){
                    //Buscamos por Autor,categoria Provincia
                    $resultado=Usuario::autorCategoriaProvincia(strtoupper($autor),$idCategoria,$idProvincia,$idusuario);
                    $numPaginas=ceil(count($resultado)/$librosPagina);
                    $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                    $idUsuarios=[];
                    $hidenPag=false;
                    $j=0;
                    $k=$limitInf+$librosPagina;
                    for($i=$limitInf;$i<$k;$i++){
                        $idUsuarios[$j]=$resultado[$k-1];
                        $j+=1;
                    }
                }else{
                    //Buscamos por autor y categoria
                    $resultado=Usuario::autorCategoria(strtoupper($autor),$idCategoria,$idusuario);
                    $numPaginas=ceil(count($resultado)/$librosPagina);
                    $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                    $idUsuarios=[];
                    $hidenPag=false;
                    $j=0;
                    $k=$limitInf+$librosPagina;
                    for($i=$limitInf;$i<$k;$i++){
                        $idUsuarios[$j]=$resultado[$k-1];
                        $j+=1;
                    }

                }
            }else{
                
                if(strcmp($idProvincia,'-1')!=0){
                    //Buscamos por autor y Provincia
                    $resultado=Usuario::autorProvincia(strtoupper($autor),$idProvincia,$idusuario);
                    $numPaginas=ceil(count($resultado)/$librosPagina);
                    $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                    $idUsuarios=[];
                    $hidenPag=false;
                    $j=0;
                    $k=$limitInf+$librosPagina;
                    for($i=$limitInf;$i<$k;$i++){
                        $idUsuarios[$j]=$resultado[$k-1];
                        $j+=1;
                    }
                }else{
                    //Buscamos por autor
                    $resultado=Usuario::autor(strtoupper($autor),$idusuario);
                    $numPaginas=ceil(count($resultado)/$librosPagina);
                    $limitInf=(($_GET['pagina']??1)-1)*$librosPagina;
                    $idUsuarios=[];
                    $hidenPag=false;
                    $j=0;
                    $k=$limitInf+$librosPagina;
                    for($i=$limitInf;$i<$k;$i++){
                        $idUsuarios[$j]=$resultado[$k-1];
                        $j+=1;
                    }
                }

                }

               
            }
        
                    
        $router->render('/cliente/buscarTitulo',[
            'numPaginas'=>$numPaginas,
            'idUsuario'=>$idusuario,
            'idUsuarios'=>$idUsuarios,
            'alertas'=>$alertas,
            'hidenPag'=>$hidenPag,
            'match'=>'0'

        ]);

    }
    
}