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

    $query_ep = mysqli_query($conexion, "UPDATE curso SET estado=5 WHERE fin_curso<=CURDATE() AND estado IN (2,3)");
    $query_bl = mysqli_query($conexion, "UPDATE curso_bl SET estado=5 WHERE fin_curso<=CURDATE() AND estado IN (2,3)");

    $query_ep2 = mysqli_query($conexion, "SELECT * FROM curso WHERE tipo_ceba=1 AND estado=2");
    $query_ep1 = mysqli_query($conexion, "SELECT * FROM curso WHERE tipo_ceba=2 AND estado=2");
    $query_bl1 = mysqli_query($conexion, "SELECT * FROM curso_bl WHERE estado=2");

    $totalRows_ep2 = mysqli_num_rows($query_ep2); 
    $totalRows_ep1 = mysqli_num_rows($query_ep1);
    $totalRows_bl1 = mysqli_num_rows($query_bl1); 

    if($totalRows_ep2==0){
        $mail = new PHPMailer(true);
            
        try {
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'eventos@gllg.edu.pe';                     // usuario de acceso
            $mail->Password   = 'GLLG2022';                                // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->setFrom('no-reply@gllg.edu.pe', 'No hay Cursos Activos'); //desde donde se envia
    
            $mail->addAddress('dtecnologia@gllg.edu.pe');

            $mail->isHTML(true);                                  // Set email format to HTML
    
            $mail->Subject = 'No hay Cursos Activos';
    
            $mail->Body =  '<p style="font-size:14px;">¡Hola!</p>
                            <p style="font-size:14px;">No hay Cursos Activos en la empresa EP2. Revisar por favor.</p>';
    
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    if($totalRows_ep1==0){
        $mail = new PHPMailer(true);
            
        try {
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'eventos@gllg.edu.pe';                     // usuario de acceso
            $mail->Password   = 'GLLG2022';                                // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->setFrom('no-reply@gllg.edu.pe', 'No hay Cursos Activos'); //desde donde se envia
    
            $mail->addAddress('dtecnologia@gllg.edu.pe');

            $mail->isHTML(true);                                  // Set email format to HTML
    
            $mail->Subject = 'No hay Cursos Activos';
    
            $mail->Body =  '<p style="font-size:14px;">¡Hola!</p>
                            <p style="font-size:14px;">No hay Cursos Activos en la empresa EP1. Revisar por favor.</p>';
    
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    if($totalRows_bl1==0){
        $mail = new PHPMailer(true);
            
        try {
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'eventos@gllg.edu.pe';                     // usuario de acceso
            $mail->Password   = 'GLLG2022';                                // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->setFrom('no-reply@gllg.edu.pe', 'No hay Cursos Activos'); //desde donde se envia
    
            $mail->addAddress('dtecnologia@gllg.edu.pe');

            $mail->isHTML(true);                                  // Set email format to HTML
    
            $mail->Subject = 'No hay Cursos Activos';
    
            $mail->Body =  '<p style="font-size:14px;">¡Hola!</p>
                            <p style="font-size:14px;">No hay Cursos Activos en la empresa BL1. Revisar por favor.</p>';
    
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
?>