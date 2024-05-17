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

    //LOCAL
    //$url = $_SERVER['DOCUMENT_ROOT'] . '/new_snappy/';
    //PRODUCCIÓN
    $url = $_SERVER['DOCUMENT_ROOT'] . '/';

    $list_mailing = mysqli_query($conexion, "SELECT id_mailing,titulo,texto,documento
                    FROM mailing_alumno 
                    WHERE id_empresa=6 AND enviado=0 AND estado_m=2 AND 
                    (tipo_envio=1 OR (tipo_envio=2 AND fecha_envio=CURDATE())) AND estado=2");
    $total_mailing = mysqli_num_rows($list_mailing); 

    if($total_mailing>0){
        while ($fila = mysqli_fetch_assoc($list_mailing)) { 
            $list_alumno = mysqli_query($conexion, "CALL datos_alumno_mailing (".$fila['id_mailing'].")");
            mysqli_next_result($conexion);

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
                $mail = new PHPMailer(true);
                
                try {
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'admision@ifv.edu.pe';                     // usuario de acceso
                    $mail->Password   = 'qkbotbqtcqsywpwx';                                // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->setFrom('admision@ifv.edu.pe', 'Instituto Federico Villarreal'); //desde donde se envia
                    
                    $mail->addAddress($fila_alumno['email_envio']);
                    
                    $mail->isHTML(true);                                  // Set email format to HTML
            
                    $mail->Subject = $fila['titulo'];
            
                    $mail->Body =  '<FONT SIZE=3>'.nl2br($fila['texto']).'
                                    </FONT SIZE>';
            
                    $mail->CharSet = 'UTF-8';
                    if($fila['documento']!=""){
                        $mail->addAttachment($url."/".$fila['documento']);
                    }
                    $mail->send();

                    mysqli_query($conexion, "INSERT INTO detalle_mailing_alumno (id_mailing,id_alumno,
                    cod_alumno,apater_alumno,amater_alumno,nom_alumno,email_alumno,celular_alumno,grupo_alumno,
                    especialidad_alumno,turno_alumno,modulo_alumno,id_apoderado,apater_apoderado,amater_apoderado,nom_apoderado,
                    parentesco_apoderado,email_apoderado,celular_apoderado,fecha_envio,estado,fec_reg,user_reg) 
                    VALUES ('".$fila['id_mailing']."','".$fila_alumno['id_alumno']."',
                    '".$fila_alumno['cod_alumno']."','".$fila_alumno['apater_alumno']."',
                    '".$fila_alumno['amater_alumno']."','".$fila_alumno['nom_alumno']."',
                    '".$fila_alumno['email_alumno']."','".$fila_alumno['celular_alumno']."',
                    '".$fila_alumno['grupo_alumno']."','".$fila_alumno['especialidad_alumno']."',
                    '".$fila_alumno['turno_alumno']."','".$fila_alumno['modulo_alumno']."',
                    '".$fila_alumno['id_apoderado']."','".$fila_alumno['apater_apoderado']."',
                    '".$fila_alumno['amater_apoderado']."','".$fila_alumno['nom_apoderado']."',
                    '".$fila_alumno['parentesco_apoderado']."','".$fila_alumno['email_apoderado']."',
                    '".$fila_alumno['celular_apoderado']."',NOW(),2,NOW(),0)");
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }

            mysqli_query($conexion, "UPDATE mailing_alumno SET enviado=1,estado_m=3
            WHERE id_mailing=".$fila['id_mailing']."");
        }
    }
?>