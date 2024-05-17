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

    if(date('l')=="Friday"){
        $list_retirado = mysqli_query($conexion, "SELECT Id FROM todos_l20 
                        WHERE Alumno='Retirado' AND Matricula='Retirado' AND Grupo>='22/1' AND (SELECT COUNT(*) FROM alumno_retirado al
                        WHERE al.id_empresa=6 AND al.Id=todos_l20.Id AND al.estado=2)=0");
        $cantidad = mysqli_num_rows($list_retirado);

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
            $mail->setFrom('noreplay@ifv.edu.pe', 'Alumnos Retirados FV'); //desde donde se envia

            $mail->addAddress('pedro.vieira@gllg.edu.pe');
            $mail->addAddress('rosanna.apolaya@gllg.edu.pe');
            $mail->addAddress('dtecnologia@gllg.edu.pe');

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Alumnos Retirados FV';

            $mail->Body = '<FONT SIZE=4>
                        ¡Hola!<br>
                        A la fecha existen '.$cantidad.' alumnos en retirados pendientes de hacer el tramite correspondiente.<br>
                        Un saludo.
                        </FONT SIZE>';

            $mail->CharSet = 'UTF-8';
            $mail->send();

        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
?>