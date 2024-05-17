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

    if(date('l')=="Thursday"){
        $query_obj_grupal = mysqli_query($conexion, "SELECT IFNULL(SUM(us.artes),0)+IFNULL(SUM(us.redes),0) AS objetivo_grupal 
                            FROM users us 
                            WHERE us.id_nivel IN (2,3,4) AND us.estado=2"); 
        $obj_grupal = mysqli_fetch_assoc($query_obj_grupal);

        $anio=date('Y');
        $semana=date('W');

        $query_u = mysqli_query($conexion, "SELECT us.id_usuario,us.usuario_codigo,us.artes,us.redes,us.usuario_email,
                    IFNULL((SELECT COUNT(*) FROM proyecto 
                    WHERE status=2 AND id_asignado=us.id_usuario),0) AS total_asignadas,
                    IFNULL((SELECT COUNT(*) FROM proyecto 
                    WHERE status=3 AND id_asignado=us.id_usuario),0) AS total_en_tramite,
                    IFNULL((SELECT COUNT(*) FROM proyecto 
                    WHERE status=4 AND id_asignado=us.id_usuario),0) AS total_pendientes,
                    IFNULL((SELECT COUNT(*) FROM proyecto 
                    WHERE semanat=$semana AND YEAR(fec_termino)=$anio AND status=5 AND id_asignado=us.id_usuario),0) AS total_terminados,
                    IFNULL((SELECT IFNULL(SUM(s_artes),0)+IFNULL(SUM(s_redes),0) FROM proyecto 
                    WHERE semanat=$semana AND YEAR(fec_termino)=$anio AND status=5 AND id_asignado=us.id_usuario),0) AS snappys_terminados
                    FROM users us
                    WHERE us.id_nivel IN (2,3,4) AND us.estado=2
                    GROUP BY us.id_usuario");

        while ($fila = mysqli_fetch_assoc($query_u)) {
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
                $mail->setFrom('noreply@snappy.org.pe', 'Snappy'); //desde donde se envia
                
                $mail->addAddress($fila['usuario_email']);
                $mail->addAddress('dcomunicacion@gllg.edu.pe');
                //$mail->addAddress('daniel11143118@gmail.com');
                
                $mail->isHTML(true);                                  // Set email format to HTML
        
                $mail->Subject = 'REPORTE de tu semana';
        
                $mail->Body =  '<FONT SIZE=3>
                                    ¡Hola!<br>
                                    A la fecha, <b>'.$fila['usuario_codigo'].'</b>, este es tu reporte semanal:<br><br>
                                    Artes Asignadas: '.$fila['total_asignadas'].'<br>
                                    Artes en Tramite: '.$fila['total_en_tramite'].'<br>
                                    Artes Pendientes: '.$fila['total_pendientes'].'<br><br>
                                    ARTES CERRADAS: '.$fila['total_terminados'].'<br>
                                    SNAPPYS CERRADOS: '.$fila['snappys_terminados'].'<br>
                                    OBJETIVO personal: '.($fila['artes']+$fila['redes']).'<br><br>
                                    Objetivo Grupo: '.number_format($obj_grupal['objetivo_grupal'],0).'<br><br>
                                    ¡Que tengas un excelente día!
                                </FONT SIZE>';
        
                $mail->CharSet = 'UTF-8';
                $mail->send();
        
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }        
    }
?>