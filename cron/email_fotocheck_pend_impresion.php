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

    $list_foto_pendiente = mysqli_query($conexion, "SELECT fo.id_fotocheck FROM fotocheck fo
                            LEFT JOIN todos_l20 td ON fo.Id=td.Id
                            WHERE fo.esta_fotocheck=1 AND td.Alumno='Matriculado'"); 
    $total = mysqli_num_rows($list_foto_pendiente);                             

    if($total>0){
        $mail = new PHPMailer(true);
    
        try {
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'noreply@snappy.org.pe';                     // usuario de acceso
            $mail->Password   = 'gllg2023@';                                // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->setFrom('noreply@snappy.org.pe', "SNAPPY"); //desde donde se envia
    
            $mail->addAddress('dtecnologia@gllg.edu.pe');
    
            $mail->isHTML(true);                                  // Set email format to HTML
    
            $mail->Subject = "Pendiente impresión de Fotocheck";
        
            $mail->Body = '<FONT SIZE=3>
                                ¡Hola!<br><br>
                                Tienes '.$total.' fotochecks pendientes de impresion.<br><br>
                                Puedes usar el link abajo para aceder directamente:<br>
                                https://www.snappy.org.pe/index.php?/AppIFV/Fotocheck_Alumnos <br><br>
                                Agradecemos tu pronta accion.<br>
                                Que tengas un excelente dia.<br>
                                Snappy<br>
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
?>