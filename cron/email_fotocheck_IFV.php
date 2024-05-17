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

    $list_fotocheck = mysqli_query($conexion, "SELECT Email FROM tmp2_fotocheck t2 LEFT JOIN todos_l20 tl on tl.Id=t2.Id");

    while ($fila = mysqli_fetch_assoc($list_fotocheck)) {
            $mail = new PHPMailer(true);
            
            try {
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'noreplay@ifv.edu.pe';                     // usuario de acceso
                $mail->Password   = 'ifvc2022';                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('noreplay@ifv.edu.pe', 'Proceso de Fotocheck'); //desde donde se envia

                $mail->addAddress($fila['Email']);
                //$mail->addAddress('dcomunicacion@gllg.edu.pe');
                
                $mail->isHTML(true);                                  // Set email format to HTML
        
                $mail->Subject = 'Proceso de Fotocheck';
        
                $mail->Body = '<FONT SIZE=4>Hola<br>
                El pago de tu fotocheck se encuentra validado, el siguiente paso es realizar el trámite ,
                 si aún no lo haz hecho por favor acércate al área de  informes  lo antes posible para tomar la foto. <br>
                
                Recuerda que para registrar tu ingreso es obligatorio presentar el fotocheck. <br>              

                Te esperamos. <br>
            
                (*)Importante:  El pago solo tiene vigencia de 30 días , posterior a ello se anula y no hay derecho a reclamo. No existe reembolso.<br>
                </FONT SIZE>';
        
                $mail->CharSet = 'UTF-8';
                $mail->send();
        
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        
    }
?>