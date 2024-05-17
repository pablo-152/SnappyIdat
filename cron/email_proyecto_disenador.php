<?php
    include 'conexion.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $list_disenador = mysqli_query($conexion, "SELECT id_usuario,usuario_email FROM users WHERE id_nivel=3 AND estado=2");

    while ($fila = mysqli_fetch_assoc($list_disenador)) {
        $proyectos_terminados = mysqli_query($conexion, "SELECT id_proyecto FROM proyecto 
                                WHERE id_tipo NOT IN (7,12) AND user_termino=".$fila['id_usuario']." AND 
                                DATE(fec_termino)=DATE_SUB(CURDATE(),INTERVAL 1 DAY)");

        $total = mysqli_num_rows($proyectos_terminados);

        if($total<3){ 
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
                $mail->setFrom('no-reply@gllg.edu.pe', 'Falta Cerrar Artes'); //desde donde se envia

                $mail->addAddress($fila['usuario_email']);
                $mail->addAddress('dcomunicacion@gllg.edu.pe');
                
                $mail->isHTML(true);                                  // Set email format to HTML
        
                $mail->Subject = 'Falta Cerrar Artes';
        
                $mail->Body =  '<p style="font-size:14px;margin-bottom:20px;">¡Hola!</p>
                                El día de ayer no has cerrado artes suficientes.<br>
                                Si has estado trabajando tienes que cerrar artes diariamente.
                                <p style="font-size:14px;margin-top:20px;">Esta atento.</p>';
        
                $mail->CharSet = 'UTF-8';
                $mail->send();
        
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }
?>