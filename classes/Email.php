<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email,$nombre,$token){
        $this->email=$email;
        $this->nombre=$nombre;
        $this->token=$token;

    }

    public function enviarConfirmacion(){

        //Crear Objecto Email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '3372007a4c2f9d';
        $mail->Password = '4aff67e9c4e36d';


        $mail->setFrom('cuentas@forndepa.com');
        $mail->addAddress('cuentas@forndepa.com','ForndePa.com');
        $mail->Subject='Confirma Tu Cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';
        $contenido="<html>";
        $contenido .="<p><strong> Hola ".$this->nombre. "</strong> Has Creado tu 
        cuenta en Forn de Pa,solo debes confirmarla presionando el Siguiente enlace</p>";
        $contenido.="<p>Presiona Aquí: <a href='http://localhost:3000/confirmar-cuenta?token=".$this->token ."'>Confirmar Cuenta</a> </p>";
        $contenido.="<p>Si tu no Solicitaste esta cuenta puedes ignorar el mensaje </p>";
        $contenido.="</html>";
        $mail->Body=$contenido;

        $mail->send();

    }

    public function enviarInstrucciones(){

        //Crear Objecto Email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '3372007a4c2f9d';
        $mail->Password = '4aff67e9c4e36d';


        $mail->setFrom('cuentas@forndepa.com');
        $mail->addAddress('cuentas@forndepa.com','ForndePa.com');
        $mail->Subject='Confirma Tu Cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';
        $contenido="<html>";
        $contenido .="<p><strong> Hola ".$this->nombre. "</strong> Has Solicitado Reestablecer
        tu password,sigue el siguiente enlace</p>";
        $contenido.="<p>Presiona Aquí: <a href='http://localhost:3000/recuperar/password?token=".$this->token ."'>Reestablecer Password</a> </p>";
        $contenido.="<p>Si tu no Solicitaste esta cuenta puedes ignorar el mensaje </p>";
        $contenido.="</html>";
        $mail->Body=$contenido;

        $mail->send();

    }


    public function enviarConfirmacionPedido($admin=false,$idPedido=''){

        //Crear Objecto Email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '3372007a4c2f9d';
        $mail->Password = '4aff67e9c4e36d';


        $mail->setFrom('cuentas@forndepa.com');
        $mail->addAddress('cuentas@forndepa.com','ForndePa.com');
        $mail->Subject='Confirma Tu Cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';
        $contenido="<html>";
        if(!$admin){
            $contenido .="<p><strong> Hola ".$this->nombre. "</strong>  tu 
            Pedido en Forn de Pa,ha sido Creado Correctamente</p>";
            $contenido.="Si hay algún incidente nos pondremos en contacto con usted, </p>";
            $contenido.="<p>tambíen puede ver el estado de su pedido desde la pagina web Mi-cuenta->ver Pedidos </p>";
            $contenido.="</html>";
            $mail->Body=$contenido;

        }else{
            $contenido .="<p><strong> Hola admin se ha realizado un Pedido en Forn de Pa </strong></p>";
            $contenido.=" <p> el Numero de Pedido es ".$idPedido.",lo puede Consultar desde el Panel de Administración</p>"; 
        
            $contenido.="</html>";
            $mail->Body=$contenido;
        }
        

        $mail->send();

    }
    
        
    

}