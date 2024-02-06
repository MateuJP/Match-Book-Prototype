<?php

namespace Model;

use mysqli;

class Estado extends ActiveRecord
{
    protected static $tabla = 'ESTADO';
    protected static $columnasDB = ['idEstado', 'nombreEstado'];
    protected static $columnaId = 'idEstado';
    public $idEstado;
    public $nombreEstado;
    public $nombreCategoria;


    public function __construct($args = [])
    {
        $this->idEstado = $args['idEstado'] ?? null;
        $this->nombreCategoria = $args['nombreEstado'] ?? '';
    }
}
