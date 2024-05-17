<?php
    include 'conexion.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require_once ('tcpdf/tcpdf.php');

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $query_a = mysqli_query($conexion, "UPDATE producto_interes SET estado=5 WHERE fecha_fin=CURDATE() AND estado=2");

?>