<?php
namespace Model;

use mysqli;

class Categoria extends ActiveRecord{
    protected static $tabla='CATEGORIA';
    protected static $columnasDB=['idCategoria','nombreCategoria'];
    protected static $columnaId='idCategoria';
    public $idCategoria;
    public $nombreCategoria;

    public function __construct($args=[])
    {
        $this->idCategoria=$args['idCategoria']??null;
        $this->nombreCategoria=$args['nombreCategoria']??'';
        
        
    }

}