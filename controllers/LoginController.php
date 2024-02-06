<?php

namespace Controllers;

use Classes\Email;
use Model\Provincia;
use Model\Usuario;
use MVC\Router;

class LoginController{
    
    public static function login(Router $router){
        $alertas=[];
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //auth es un objeto Usuario con todos los campos null excepto e-mail y password que se llenaran 
            //con los datos del formulario
            $auth=new Usuario($_POST); 
            $alertas=$auth->validarLogin();
            if(empty($alertas)){
                //Sabemos que tenemos un email y una contraseña lo vamos a buscar en la base de datos
                $usuario=Usuario::where('email',$auth->email);
                if($usuario){
                    //El Usuario Existe,comprobamos que esta confirmado
                    if($usuario->verificarConfirmado()){
                        if($usuario->verificarPassword($auth->password)){
                            //INICIAMOS SESIÓN
                            session_start();
                            $_SESSION['idUsuario']=$usuario->idUsuario;
                            $_SESSION['nombre']=$usuario->nombre." " .$usuario->apellido;
                            $_SESSION['email']=$usuario->email;
                            $_SESSION['login']=true;
                            

                            //Comporbamos si es admin
                            if($usuario->admin=="1"){
                                $_SESSION['admin']=$usuario->admin ?? null;
                                //REDIRECCIONAR A PANEL ADMINISTRACION
                                header('Location: /admin');
                            }
                            else{
                                //ES UN CLIENTE
                                $_SESSION['admin']=$usuario->admin ?? null;
                                $idUsuario=$usuario->idUsuario;
                                header('Location: /cliente/cuenta?usuario='.$idUsuario);
                            } 
                        }
                    }   
                }
                else{
                    Usuario::setAlerta('error','El e-mail no Corresponde a ningúna cuenta');
                }    
            }
        }
        $alertas=Usuario::getAlertas();
        $router->renderLogin('auth/login',[
            'alertas'=>$alertas
        ]);
        
    }

    public static function crear(Router $router){
        $provincias=Provincia::all();
        $usuario=new Usuario($_POST);
        $alertas=[];

        
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $usuario->sincronizar($_POST);
            $provincia=($_POST['Provincia']);
            $idProvincia=$provincia['opciones'];
            $usuario->idProvincia=$idProvincia;
            $alertas=$usuario->validarCuenta();
            if(empty($alertas)){
                //No hay Campos bacios ahora comprobamos si ya existe
                $resultado=$usuario->comprobarExistencia();
                if($resultado->num_rows){
                    //Ya Existe
                    $alertas=Usuario::setAlerta('error','El Usuario ya está Registrado');

                }
                else{
                    //El Usuario no existe,lo guardamos

                    //Hasear el Password
                    $usuario->hashPassword();
                    //Generamos el token de autenticacion
                    $usuario->creartoken();
                    
                    //Enviamos el email
                    $email=new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarConfirmacion();

                    //Guardamos el Usuario en la Base de Datos
                    $resultado=$usuario->guardar($usuario->idUsuario);
                    if($resultado){
                        header('Location:/mensaje');
                    }
                }
            }
        }
        $alertas=Usuario::getAlertas();
        $router->renderLogin('/auth/crear',[
            'provincias'=>$provincias,
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->renderLogin('/auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas=[];

        $token=s($_GET['token']);
        $usuario=Usuario::where('token',$token);
        if(empty($usuario)){
            Usuario::setAlerta('error','La Cuenta no ha Podido ser Confirmada');
        }else{
            //Confirmamos el Usuario en la Base de Datos
            $usuario->confirmado="1";
            $usuario->token='';
            //Actualizamos el Usuario
            $usuario->guardar($usuario->idUsuario);
            Usuario::setAlerta('exito','Cuenta Creada Correctamente');
        }
        $alertas=Usuario::getAlertas();
        $router->renderLogin('/auth/confirmar',[
            'alertas'=>$alertas
        ]);
    }

    public static function olvide(Router $router){
        $alertas=[];

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $auth=new Usuario($_POST); //Instanciamos un Usuario y le pasamos los datos de POST

            $alertas=$auth-> validarEmail();

            if(empty($alertas)){
                $usuario=Usuario::where('email',$auth->email);
                if($usuario && $usuario->confirmado==1){
                    //Existe y esta confirmado

                    //Generamos Token
                    $usuario->crearToken();
                    $usuario->guardar($usuario->idUsuario); //Actualizamos en la Base de Datos

                    //Enviar el Email
                    $email=new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito','Revisa tu e-mail');
                }
                else{
                    //No existe o no esta Confirmado
                    Usuario::setAlerta('error','El usuario No existe o no Está Confirmado');

                }
            }
        }
        $alertas=Usuario::getAlertas();

        $router->renderLogin('auth/olvide',[
            'alertas'=>$alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas=[];
        $error=false;
        //obtenemos el token de la URL
        $token=s($_GET['token']);
        //Busacmos si Hay algun usuario con este token
        $usuario=USUARIO::where('token',$token); //Busamos en la BD el usuario con ese token
        if(empty($usuario)){
             //No existe
             Usuario::setAlerta('error','Token No Válido');
             $error=true;     
        }
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $password=new Usuario($_POST);
            $alertas=$password->validarPassword();
            if(empty($alertas)){
                $usuario->password=null;
                $usuario->password=$password->password;
                $usuario->hashPassword();
                $usuario->token=null;
                $resultado=$usuario->guardar($usuario->idUsuario);
                if($resultado){
                    header('Location: /');
                }
            }
        }
        $alertas=Usuario::getAlertas();
        $router->renderLogin('auth/recuperar-password',[
            'alertas'=>$alertas,
            'error'=>$error
        ]);
    }

    public static function logout(){
        $_SESSION=[];
        header('Location:/');
    }

}