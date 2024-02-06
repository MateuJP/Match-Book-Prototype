<?php

namespace Model;

class Lista extends ActiveRecord{
    protected static $tabla='LISTA';
    protected static $columnasDB=['idLista','nombre','deseo','idUsuario'];
    protected static $columnaId='idLista';
    public $idLista;
    public $nombre;
    public $deseo;
    public $idUsuario;



    public function __construct($args=[])
    {
        $this->idLista=$args['idLista']??null;
        $this->nombre=$args['nombre']??'';
        $this->deseo=$args['deseo']??'';
        $this->idUsuario=$args['idUsuario']??'';   
    }

    public function validarLista(){
        if(!$this->nombre){
            self::$alertas['error'][]='El nombre és Obligatorio';
        }
        return self::$alertas;
    }

    public function getD(){
        return $this->deseo;
    }

}