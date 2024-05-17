<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';
require 'vendor/autoload.php';

$nombre = $_POST["nombre"];
$email = $_POST["email"];
$telefono = $_POST["telefono"];
$message = $_POST["message"];



    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Timeout = 50;
    $mail->Host = 'mail.geoanalyticsperu.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'superuser@geoanalyticsperu.com';
    $mail->Password = '/superuser/2020/';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom("superuser@geoanalyticsperu.com", "ONE PAGE BIENVENIDO");
    $mail->addAddress('anderlygp@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'cliente : '.$nombre.'';
    $mail->Body    = 'cliente : '.$nombre.' correo '.$email.' telefono '.$telefono.' mensaje: '.$message.'';
    $mail->AltBody = 'atte.';
    if(!$mail->send()) {
    echo 'no ok '.$mail->ErrorInfo;
    } else {
    echo "ok";
    }
    $mail->SmtpClose();

?>