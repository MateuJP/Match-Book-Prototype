<?php

namespace Model;

class LibroLista extends ActiveRecord{
    protected static $tabla='LIBRO_LISTA';
    protected static $columnasDB=['idLibro','idLista','idEstado','URL'];
    public $idLibro;
    public $idLista;
    public $idEstado;
    public $URL;



    public function __construct($args=[])
    {
        $this->idLista=$args['idLibro']??null;
        $this->idLista=$args['idLista']??'';
        $this->idEstado=$args['idEstado']??'';
        $this->URL=$args['URL']??'';   

    }

}