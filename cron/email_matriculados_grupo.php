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

    $list_grupo = mysqli_query($conexion, "SELECT (SELECT SUM(promovidos) FROM vista_grupo_matriculados_promovidos) AS total_promovidos, 
                    (SELECT SUM(matriculados) FROM vista_grupo_matriculados_promovidos) AS total_matriculados");
    $get_grupo = mysqli_fetch_assoc($list_grupo); 

    $list_matriculados = mysqli_query($conexion, "SELECT (SELECT COUNT(*) FROM todos_l20 WHERE Matricula='Promovido' AND Alumno='Matriculado') AS total_a_promovidos, 
                        (SELECT COUNT(*) FROM todos_l20 WHERE Alumno='Matriculado' AND todos_l20.Matricula='Asistiendo') AS total_a_matriculados");
    $get_matriculados = mysqli_fetch_assoc($list_matriculados); 

    $list_usuario = mysqli_query($conexion, "SELECT usuario_email FROM users 
                    WHERE id_usuario IN (7,10)");

    if($get_grupo['total_promovidos']!=$get_matriculados['total_a_promovidos'] || $get_grupo['total_matriculados']!=$get_matriculados['total_a_matriculados']){
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
            $mail->setFrom('noreplay@ifv.edu.pe', 'Diferencia de Grupos y Matriculados'); //desde donde se envia

            while($fila = mysqli_fetch_assoc($list_usuario)){
                $mail->addAddress($fila['usuario_email']);
            }
            $mail->addAddress('dtecnologia@gllg.edu.pe');
            
            $mail->isHTML(true);                                  // Set email format to HTML
    
            $mail->Subject = 'Diferencia de Grupos y Matriculados';
    
            $mail->Body = '<FONT SIZE=4>
                            Algo está mal y debe ser resuelto.
                            </FONT SIZE>';
    
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
?>