<?php

namespace Model;

class Libro extends ActiveRecord
{
    protected static $tabla = 'LIBRO';
    protected static $columnasDB = ['idLibro', 'titulo', 'autor', 'idCategoria'];
    protected static $columnaId = 'idLibro';
    public $idLibro;
    public $titulo;
    public $autor;
    public $idCategoria;
    public $idLista; // Se añade la propiedad idLista



    public function __construct($args = [])
    {
        $this->idLista = $args['idLibro'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->autor = $args['autor'] ?? '';
        $this->idCategoria = $args['idCategoria'] ?? '';
    }
}
