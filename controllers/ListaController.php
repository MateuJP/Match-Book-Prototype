<?php

namespace Controllers;

use Model\Libro;
use Model\LibroLista;
use Model\Lista;

use MVC\Router;

class ListaController{
    public static function ver(Router $router){
        isAuth();
        $d=$_GET['d'];
        $idUsuario=$_SESSION['idUsuario'];
        //$hidenPag=true;
        //$numPaginas=0;
        //$librosPagina=6;
        $idLibros=null;
        if($d==1){
            //Buscamos la Lista de Deseos del Usuario
            $lista=Lista::whereAnd('idUsuario','deseo',$idUsuario,$d);
        }else{
            //Buscamos la Lista de Compartir del Usuario
            $lista=Lista::whereAnd('idUsuario','deseo',$idUsuario,"0");
        }
        if($lista){
            $idLibros=LibroLista::where('idLista',$lista->idLista,true);
            //$numPaginas=ceil(count($Libros)/$librosPagina);
            //$limitInf=($_GET['pagina']-1)*$librosPagina;
            //$hidenPag=false;
        }
        $router->render('/lista/ver',[
            'lista'=>$lista,
            'd'=>$d,
            'idLibros'=>$idLibros,
            'idUsuario'=>$idUsuario

            //'hidenPag'=>$hidenPag,
            //'numPaginas'=>$numPaginas

        ]);
    }

    public static function crear(Router $router){
        isAuth();
        $idUsuario=$_SESSION['idUsuario'];
        $d=$_GET['d'];
        $alertas=[];
        $resultado=null;
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $lista=new Lista($_POST);
            $lista->idUsuario=$idUsuario;
            $lista->deseo=$d;
            $alertas=$lista->validarLista();
            if(empty($alertas)){
                $resultado=$lista->guardar($lista->idLista);

            }
        }

        $router->render('/lista/crear',[
            'alertas'=>$alertas,
            'resultado'=>$resultado,
            'd'=>$d,
            'idUsuario'=>$idUsuario
        ]);
    }

    public static function añadir(Router $router){
        isAuth();
        $resultado=null;
        $idUsuario=$_SESSION['idUsuario'];
        $alertas=[];
        $idLista=$_GET['idLista'];
        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $libro=new Libro();
            $libro->titulo=strtoupper($_POST['titulo']);
            $libro->autor=strtoupper($_POST['autor']);
            $categoria=$_POST['categoria'];
            $libro->idCategoria=$categoria['opciones'];

            $estado=$_POST['estado']??'';

            //Comprobamos si el libro existe
            $libroAuth=$libro->whereTitulo('titulo',$libro->titulo);
            if($libroAuth!=Null){
                //El Libro ya esta en Alguna Lista

                $libroLista=new LibroLista();
                $libroLista->idLibro=$libroAuth->idLibro;
                $libroLista->idLista=$idLista;
                $libroLista->idEstado=$estado['opciones']??4;
                $idLibro=$libroAuth->idLibro;
                $libroLista->URL="?idLista=${idLista}&idLibro=${idLibro}";
                $resultado=$libroLista->muchos();
                
            }else{
                //El Libro no estaba en ninguna Lista,lo Guardamos
                $resultado=$libro->guardar($libro->idLibro);
                $idLibro=$resultado['idLibro'];
                $libroLista=new LibroLista();
                $libroLista->idLibro=$idLibro;
                $libroLista->idLista=$idLista;
                $libroLista->idEstado=$estado['opciones']??4;
                $libroLista->URL="?idLista=${idLista}&idLibro=${idLibro}";
                $resultado=$libroLista->muchos();

            }

        }
        $router->render('/lista/añadir',[
            'resultado'=>$resultado,
            'idLista'=>$idLista
        ]);
    }

    public static function eliminarLibro(Router $router){
        $idLista=$_GET['idLista'];
        $idLibro=$_GET['idLibro'];

        LibroLista::eliminarMuchos('idLista',$idLista,'idLibro',$idLibro);
        $listaD=Lista::where('idLista',$idLista);
        $d=$listaD->getD();
        header('Location:/lista/ver?d=${d}');


    }





    public static function verBusqueda(Router $router){
        $idusuario=$_GET['idUsuario'];
        $idProvincia=$_GET['Provincia'];
        $listaD=Lista::whereAnd('idUsuario','deseo',$idusuario,"1");
        $listaC=Lista::whereAnd('idUsuario','deseo',$idusuario,"0");

        $router->render('lista/resultado',[
            'idProvincia'=>$idProvincia,
            'listaD'=>$listaD,
            'listaC'=>$listaC,
            'idUsuario'=>$idusuario
        ]);
    }
}