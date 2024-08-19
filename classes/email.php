<?php


namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function sendEmail()
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b2fd55ae7a503f';
        $mail->Password = '6db64bcfa899fd';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email, 'Salon.com');
        $mail->Subject = 'Confirma tu cuenta';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p>Hola ' . $this->nombre . '</p>';
        $contenido .= '<p>Para confirmar tu cuenta haz click en el siguiente enlace</p>';
        $contenido .= '<a href="http://localhost:3000/confirm?token=' . $this->token . '">Click aquí</a>';
        $contenido .= '<p>Si no has solicitado este correo, puedes ignorarlo</p>';
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();
    }

    public function sendRecoveryEmail()
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b2fd55ae7a503f';
        $mail->Password = '6db64bcfa899fd';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email, 'Salon.com');
        $mail->Subject = 'Confirma tu cuenta';
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p>Hola ' . $this->nombre . '</p>';
        $contenido .= '<p>Para recuperar la contraseña de tu cuenta, haz click en el siguiente enlace</p>';
        $contenido .= '<a href="http://localhost:3000/recovery?token=' . $this->token . '">Click aquí</a>';
        $contenido .= '<p>Si no has solicitado este correo, puedes ignorarlo</p>';
        $contenido .= '</html>';

        $mail->Body = $contenido;
        $mail->send();
    }
}
?>