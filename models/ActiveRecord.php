<?php
namespace Model;

use mysqli;

class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];
    protected static $columnaId='';
    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = mysqli_query(self::$db,$query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna ===static::$columnaId) continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar($id) {
        $resultado = '';
        if(!is_null($id)) {
            // actualizar
            $resultado = $this->actualizar($id);
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE". static::$columnaId ." = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $atributos[static::$columnaId]=self::$db->insert_id;
        //debuguear($atributos);
        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        //debuguear($query);

        // Resultado de la consulta
        $resultado = mysqli_query(self::$db,$query);
        return [
           'resultado' =>  $resultado,
           static::$columnaId => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar($id) {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE ".static::$columnaId." = '" . self::$db->escape_string($id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = mysqli_query(self::$db,$query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar($id) {
        $query = "DELETE FROM "  . static::$tabla . " WHERE ".static::$columnaId." = '${id}'  LIMIT 1";
        $resultado=mysqli_query(self::$db,$query);
        return $resultado;
    }
    public static function eliminarMuchos($columna1,$valor1,$columna2,$valor2) {
        $query = "DELETE FROM "  . static::$tabla . " WHERE ${columna1} = '${valor1}'";
        $query.="AND ${columna2}='${valor2}' LIMIT 1";
    
        $resultado=mysqli_query(self::$db,$query);
        return $resultado;
    }


    public static function where($columna,$valor,$all=false){
        $query="SELECT * FROM ".static::$tabla ." WHERE ${columna} = '${valor}'";

        $resultado=self::consultarSQL($query);
        if(!$all){
            return array_shift($resultado);
        }else{
            return $resultado;
        }

    }
    public static function whereTitulo($columna,$valor,$all=false){
        $query="SELECT * FROM ".static::$tabla ." WHERE ${columna} LIKE _utf8'%${valor}%'";
        $resultado=self::consultarSQL($query);
        if(!$all){
            return array_shift($resultado);
        }else{
            return $resultado;
        }

    }

    public static function whereAnd($columna1,$columna2,$valor1,$valor2,$all=false){
        $query="SELECT * FROM ".static::$tabla ." WHERE ${columna1} = '${valor1}'";
        $query.="and ${columna2}='${valor2}'";
        $resultado=self::consultarSQL($query);
        if(!$all){
            return array_shift($resultado);
        }else{
            return $resultado;
        }

    }
    public function muchos(){
        $atributos=$this->sanitizarAtributos();

        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        $resultado=mysqli_query(self::$db,$query);
        return $resultado;


    }

    public static function WhereLimit($columna,$valor,$limitInf,$max){
        $query="SELECT * FROM ".static::$tabla ." WHERE ${columna} = '${valor}' LIMIT $limitInf,$max";

        $resultado=self::consultarSQL($query);

        return ($resultado);
      

    }

    public static function getEstado($columna1,$columna2,$valor1,$valor2){
        $query="SELECT idEstado FROM ".static::$tabla ." WHERE ${columna1} = '${valor1}'";
        $query.="AND ${columna2}='${valor2}' LIMIT 1";
        $resultado=self::consultarSQL($query);
        $resultado=($resultado[0]);
        return ($resultado->idEstado);

    }

    public static function buscarMatch($idListaD,$idListaC,$idProvincia){

        $query="SELECT USUARIO.idUsuario  ";
        $query.="FROM ";
        $query.="USUARIO ";
        $query.="JOIN ";
        $query.="(SELECT LISTAC.idLista as idLista,LISTAC.idUsuario as idUsuario ";
        $query.="FROM USUARIO ";
        $query.="JOIN ";
        $query.="(SELECT LISTA.idLista as idLista ,LISTA.idUsuario as idUsuario ";
        $query.="FROM LISTA join "; 
        $query.="(LIBRO_LISTA JOIN (SELECT LIBRO_LISTA.idLibro as idLibro ";
        $query.="FROM LIBRO_LISTA WHERE LIBRO_LISTA.idLista=${idListaC}) as NLeidos ";
        $query.="on LIBRO_LISTA.idLibro=NLeidos.idLibro and LIBRO_LISTA.idLista!=${idListaC}) ";
        $query.="on LISTA.idLista=LIBRO_LISTA.idLista AND LISTA.deseo=1 ";
        $query.="GROUP by idLista) AS LISTAC ";
        $query.="on USUARIO.idUsuario=LISTAC.idUsuario and USUARIO.idProvincia=${idProvincia}) AS LD ";
        $query.="JOIN";
        $query.="(SELECT LISTADESEOS.idLista as idLista,LISTADESEOS.idUsuario as idUsuario ";
        $query.="FROM USUARIO ";
        $query.="JOIN";
        $query.="(SELECT LISTA.idLista as idLista ,LISTA.idUsuario as idUsuario ";
        $query.="FROM LISTA join "; 
        $query.="(LIBRO_LISTA JOIN (SELECT LIBRO_LISTA.idLibro as idLibro ";
        $query.="FROM LIBRO_LISTA WHERE LIBRO_LISTA.idLista=${idListaD}) as Leidos ";
        $query.="on LIBRO_LISTA.idLibro=Leidos.idLibro and LIBRO_LISTA.idLista!=${idListaD}) ";
        $query.="on LISTA.idLista=LIBRO_LISTA.idLista AND LISTA.deseo=0 ";
        $query.="GROUP by idLista) AS LISTADESEOS ";
        $query.="on USUARIO.idUsuario=LISTADESEOS.idUsuario and USUARIO.idProvincia=${idProvincia}) AS LC ";
        $query.="on LD.idUsuario=USUARIO.idUsuario AND USUARIO.idUsuario=LC.idUsuario ";
        
        //$resultado=mysqli_query(self::$db,$query);
        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    }
    public static function tituloProvincia($idLibro,$idProvincia,$idUsuario){

        $query="SELECT LU.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="USUARIO "; 
        $query.="JOIN ";
        $query.="(SELECT LISTA.idLista as idLista,Lista.idUsuario ";
        $query.="FROM ";
        $query.="LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO_LISTA.idLista as idLista ";
        $query.="FROM LIBRO_LISTA WHERE idLibro=${idLibro})as ListaLibro ";
        $query.="on LISTA.idLista=ListaLibro.idLista and LISTA.deseo=0)as LU ";
        $query.="on USUARIO.idUsuario=LU.idUsuario and USUARIO.idProvincia=${idProvincia} and USUARIO.idUsuario!=${idUsuario}";
        
        //$resultado=mysqli_query(self::$db,$query);
        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    }
    public static function titulo($idLibro,$idUsuario){

        $query="SELECT USUARIO.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="USUARIO ";
        $query.="JOIN ";
        $query.="(SELECT LISTA.idUsuario as idUsuario ";
        $query.="FROM LISTA JOIN (SELECT LIBRO_LISTA.idLista as idLista FROM LIBRO_LISTA WHERE idLibro=${idLibro}) as LibroLista on LISTA.idLista=LibroLista.idLista)as LD ";
        $query.="on LD.idUsuario=USUARIO.idUsuario and USUARIO.idUsuario!=${idUsuario} ";
        //$resultado=mysqli_query(self::$db,$query);
        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    }
    public static function categoria($idCategoria,$idUsuario){
        $query="SELECT LISTA.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO_LISTA.idLista as idLista ";
        $query.="FROM LIBRO_LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO.idLibro as idLibro ";
        $query.="FROM LIBRO WHERE LIBRO.idCategoria=${idCategoria})AS Libros ";
        $query.="on LIBRO_LISTA.idLibro=Libros.idLibro ";
        $query.="GROUP BY LIBRO_LISTA.idLista) AS LD ";
        $query.="ON LISTA.idLista=LD.idLista and LISTA.idUsuario!=${idUsuario} ";
        $query.="GROUP BY idUsuario ";



       
        //$resultado=mysqli_query(self::$db,$query);
        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    }
    public static function categoriaProvincia($idCategoria,$idUsuario,$idProvincia){
        $query="SELECT USUARIO.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="USUARIO ";
        $query.="JOIN ";
        $query.="(SELECT LISTA.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO_LISTA.idLista as idLista ";
        $query.="FROM LIBRO_LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO.idLibro as idLibro ";
        $query.="FROM LIBRO WHERE LIBRO.idCategoria=${idCategoria})AS Libros ";
        $query.="on LIBRO_LISTA.idLibro=Libros.idLibro ";
        $query.="GROUP BY LIBRO_LISTA.idLista) AS LD ";
        $query.="ON LISTA.idLista=LD.idLista and LISTA.idUsuario!=${idUsuario} ";
        $query.="GROUP BY idUsuario)as UL ";
        $query.="on USUARIO.idUsuario=UL.idUsuario and USUARIO.idProvincia=${idProvincia} ";



       
        //$resultado=mysqli_query(self::$db,$query);
        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    }   
    public static function autor($autor,$idUsuario){
        $query="SELECT LISTA.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO_LISTA.idLista as idLista ";
        $query.="FROM ";
        $query.="LIBRO_LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO.idLibro as idLibro ";
        $query.="FROM LIBRO ";
        $query.="WHERE upper(autor) like _utf8'%${autor}%') as Autor ";
        $query.="on LIBRO_LISTA.idLibro=Autor.idLibro) as LD ";
        $query.="on LISTA.idLista=LD.idLista and LISTA.idUsuario!=${idUsuario} ";
        $query.="GROUP by idUsuario ";
        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    } 
    public static function autorCategoria($autor,$idCategoria,$idUsuario){
        $query="SELECT LISTA.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO_LISTA.idLista as idLista ";
        $query.="FROM ";
        $query.="LIBRO_LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO.idLibro as idLibro ";
        $query.="FROM LIBRO ";
        $query.="WHERE upper(autor) like _utf8'%${autor}%') as Autor and idCategoria=${idCategoria}";
        $query.="on LIBRO_LISTA.idLibro=Autor.idLibro) as LD ";
        $query.="on LISTA.idLista=LD.idLista and LISTA.idUsuario!=${idUsuario} ";
        $query.="GROUP by idUsuario ";
        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    } 
    public static function autorCategoriaProvincia($autor,$idCategoria,$idProvincia,$idUsuario){
        $query="SELECT USUARIO.idUsuario as idUsuario ";
        $query.="FROM USUARIO ";
        $query.="JOIN ";
        $query.="(SELECT LISTA.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO_LISTA.idLista as idLista ";
        $query.="FROM ";
        $query.="LIBRO_LISTA JOIN ";
        $query.="(SELECT LIBRO.idLibro as idLibro ";
        $query.="FROM LIBRO ";
        $query.="WHERE upper(autor) like _utf8'%${autor}%' and LIBRO.idCategoria=${idCategoria})as libroC ";
        $query.="on LIBRO_LISTA.idLibro=libroC.idLibro)as LD ";
        $query.="on LISTA.idLista=LD.idLista)as LU ";
        $query.="on LU.idUsuario=USUARIO.idUsuario and USUARIO.idProvincia=${idProvincia} and USUARIO.idUsuario!=${idUsuario}; ";


        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    } 
    public static function autorProvincia($autor,$idProvincia,$idUsuario){
        $query="SELECT USUARIO.idUsuario as idUsuario ";
        $query.="FROM USUARIO ";
        $query.="JOIN ";
        $query.="(SELECT LISTA.idUsuario as idUsuario ";
        $query.="FROM ";
        $query.="LISTA ";
        $query.="JOIN ";
        $query.="(SELECT LIBRO_LISTA.idLista as idLista ";
        $query.="FROM ";
        $query.="LIBRO_LISTA JOIN ";
        $query.="(SELECT LIBRO.idLibro as idLibro ";
        $query.="FROM LIBRO ";
        $query.="WHERE upper(autor) like _utf8'%${autor}%')as libroC ";
        $query.="on LIBRO_LISTA.idLibro=libroC.idLibro)as LD ";
        $query.="on LISTA.idLista=LD.idLista)as LU ";
        $query.="on LU.idUsuario=USUARIO.idUsuario and USUARIO.idProvincia=${idProvincia} and USUARIO.idUsuario!=${idUsuario}; ";


        $resultados=self::consultarSQL($query);
        $idUsuarios=[];
        $i=0;
        foreach($resultados as $resultado){
            $idUsuarios[$i]=$resultado->idUsuario;
            $i+=1;
        }
        return $idUsuarios;

    } 

}