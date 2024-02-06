<?php

namespace Controllers;

use Model\Estado;
use Model\Libro;
use Model\LibroLista;
use Model\Lista;
use Model\Usuario;
use MVC\Router;

class LibroController{
    public static function index(Router $router){
        $idUsuarioP=$_SESSION['idUsuario'];
        $idLista=$_GET['idLista'];
        $idLibro=$_GET['idLibro'];
        $lista=Lista::where('idLista',$idLista);
        $idUsuario=$lista->idUsuario; //Propietario de la Lista que estoy consultando
        $idEstado=LibroLista::getEstado('idLista','idLibro',$idLista,$idLibro);
        $usuario=Usuario::where('idUsuario',$idUsuario);
        $libro=Libro::where('idLibro',$idLibro);
        $estado=Estado::where('idEstado',$idEstado);


        $router->render('/libro/ver',[
            'idUsuarioP'=>$idUsuarioP,
            'libro'=>$libro,
            'usuario'=>$usuario,
            'estado'=>$estado,
            'lista'=>$lista
        ]);

    }
}