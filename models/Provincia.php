<?php
namespace Model;

use mysqli;

class Provincia extends ActiveRecord{
    protected static $tabla='PROVINCIA';
    protected static $columnasDB=['id','nombre'];
    protected static $columnaId='id';
    public $id;
    public $nombre;

    public function __construct($args=[])
    {
        $this->id=$args['id']??null;
        $this->nombre=$args['nombre']??'';
        
        
    }

    public function verificarExistencia(){
        $query="SELECT FROM ".self::$tabla ." WHERE id='".$this->id."'LIMIT 1";
        $resultado=mysqli_query(self::$db,$query);
        return $resultado;
    }
}