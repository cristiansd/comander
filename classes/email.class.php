<?php

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that

class email {
    
    var $emailDirection;

    function send() {

        date_default_timezone_set('Etc/UTC');

        require 'PHPMailer-master\PHPMailer-master\PHPMailerAutoload.php';

        $correo = new PHPMailer();

        $correo->IsSMTP();

        $correo->SMTPAuth = true;

        $correo->SMTPSecure = 'tls';

        $correo->Host = "smtp.gmail.com";

        $correo->Port = 587;

        $correo->Username = "comandersoftware@gmail.com";

        $correo->Password = "comandercp";

        $correo->SetFrom("comandersoftware@gmail.com", "Backup Completa");

        $correo->AddReplyTo("comandersoftware@gmail.com", "Backup Completa");

        $correo->AddAddress("comandersoftware@gmail.com", "Sangar Software");

        $correo->Subject = "Backup completa";

//$correo->MsgHTML("Mi Mensaje en <strong>HTML</strong>");
        $correo->IsHTML(false);
        $correo->Body = "Backup completa del dia " . date('d-m-Y');

//$correo->AddAttachment("../Backups/compress_Backups/".date('Y-m-d')."_BackupArchivos.zip");

        /* if(!$correo->Send()) {
          echo "Hubo un error: " . $correo->ErrorInfo;
          } else {
          echo "Mensaje enviado con exito.";
          } */
    }

}

?>