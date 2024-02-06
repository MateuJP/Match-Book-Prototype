<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla='USUARIO';
    protected static $columnasDB=['idUsuario','nombre','apellido','email','password','TW','INS','FB','idProvincia','token','confirmado','admin'];
    protected static $columnaId='idUsuario';

    public $idUsuario;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $TW;
    public $INS;
    public $FB;
    public $idProvincia;
    public $token;
    public $confirmado;
    public $admin;

    public function __construct($args=[]){
        $this->idUsuario=$args['idUsuario'] ?? null;
        $this->nombre=$args['nombre']?? '';
        $this->apellido=$args['apellido']?? '';
        $this->email=$args['email']?? '';
        $this->password=$args['password']?? '';
        $this->TW=$args['TW']?? '';
        $this->INS=$args['INS']?? '';
        $this->FB=$args['FB']?? '';
        $this->idProvincia=$args['idProvincia']?? '';
        $this->token=$args['token']?? '';
        $this->confirmado=$args['confirmado']?? 0;
        $this->admin=$args['admin']?? 0;
    }
    //Funcíon Para Válidar el Formulario de Creación de la Cuenta

    public function validarCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][]='El nombre es Obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][]='El apellido es Obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][]='El e-mail es Obligatorio';
        }
        if(!$this->idProvincia or $this->idProvincia=="mantener"){
            self::$alertas['error'][]='La Provincia es Obligatoria';
        }
        if(!$this->password){
            self::$alertas['error'][]='La Contraseña es Obligatoria';
        }
        if($this->password  && strlen($this->password)<8){
            self::$alertas['error'][]='La Contraseña tiene que tener almenos 8 carácteres';
        }
        return self::$alertas;

    }

    //Función Encargada de Hashear los Password

    public function hashPassword(){
        $this->password=password_hash($this->password,PASSWORD_BCRYPT);
    }

    //Función encargada de Generar el token de autenticación;
    public function crearToken(){
        $this->token=uniqid();
    }

    public function comprobarExistencia(){
        $query="SELECT * FROM ".self::$tabla. " WHERE email ='".$this->email." ' LIMIT 1 ";
        //debuguear($query);
        $resultado=mysqli_query(self::$db,$query);
        /*
        if($resultado->num_rows){
            self::$alertas['error'][]='El Usuario Ya Existe';
        }
        */
        return $resultado;
    }

    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][]='El e-mail es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][]='La Contraseña es obligatoria';
        }
        return self::$alertas;

    }
    public function verificarPassword($password){
        //comprobamos que el password es correcto
        $correcto=password_verify($password,$this->password);

        if(!$correcto ){
            self::$alertas['error'][]='La Contraseña no es Correcta';
        }
        
        else{
            return true;
        }
    }
    
    public  function verificarConfirmado(){
        if(!$this->confirmado){
            self::$alertas['error'][]='La cuenta no Esta Confirmada';
        }
        
        else{
            return true;
        }
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][]='El email es Obligatorio';
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]='El Password es Obligatorio';
        }
        if(strlen($this->password)<8){
            self::$alertas['error'][]='El Password tiene que tener 8 carácteres como mínimo';
        }

        return self::$alertas;
    }
}