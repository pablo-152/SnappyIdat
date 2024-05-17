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

    if(date('N')!=6 && date('N')!=7){
        $list_ticket = mysqli_query($conexion, "SELECT ti.id_ticket,ti.cod_ticket,ht.id_status_ticket,st.nom_status,
                        so.emailp AS correo_solicitante,ma.emailp AS correo_mantenimiento,em.cod_empresa,
                        tt.nom_tipo_ticket,so.usuario_codigo AS solicitante,
                        (SELECT GROUP_CONCAT(DISTINCT us.usuario_codigo)
                        FROM ticket_follow_up tf
                        LEFT JOIN users us ON tf.id_usuario=us.id_usuario
                        WHERE tf.id_ticket=ti.id_ticket) AS follow_up,ps.proyecto,ss.subproyecto,ti.ticket_desc,
                        ti.id_mantenimiento
                        FROM ticket ti
                        LEFT JOIN (SELECT id_ticket,MAX(id_historial) AS id_historial 
                        FROM historial_ticket
                        WHERE estado=1
                        GROUP BY id_ticket) hi ON ti.id_ticket=hi.id_ticket
                        LEFT JOIN historial_ticket ht ON hi.id_historial=ht.id_historial
                        LEFT JOIN status_general st ON ht.id_status_ticket=st.id_status_general
                        LEFT JOIN users so ON ti.id_solicitante=so.id_usuario
                        LEFT JOIN users ma ON ti.id_mantenimiento=ma.id_usuario
                        LEFT JOIN empresa em ON ti.id_empresa=em.id_empresa
                        LEFT JOIN tipo_ticket tt ON ti.id_tipo_ticket=tt.id_tipo_ticket
                        LEFT JOIN proyecto_soporte ps ON ti.id_proyecto_soporte=ps.id_proyecto_soporte
                        LEFT JOIN subproyecto_soporte ss ON ti.id_subproyecto_soporte=ss.id_subproyecto_soporte
                        WHERE ht.id_status_ticket IN (2,27)");

        while ($fila = mysqli_fetch_assoc($list_ticket)) { 
            if($fila['id_status_ticket']==2){
                $minuscula = "Presupuesto";
            }
            if($fila['id_status_ticket']==22){
                $minuscula = "Pendiente de respuesta";
            }
            if($fila['id_status_ticket']==27){
                $minuscula = "Contestado";
            }

            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
                $mail->Password   = 'Contactos2021@';                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('webcontactos@gllg.edu.pe', "SNAPPY"); //desde donde se envia

                if($fila['id_status_ticket']==2){
                    $list_presupuesto = mysqli_query($conexion, "SELECT emailp FROM users
                                        WHERE id_usuario IN (1,7)");
                    while($fila_p = mysqli_fetch_assoc($list_presupuesto)){
                        $mail->addAddress($fila_p['emailp']);
                    }
                }
                if($fila['id_status_ticket']==22){
                    $mail->addAddress($fila['correo_solicitante']);
                    $list_follow_up = mysqli_query($conexion, "SELECT us.emailp FROM ticket_follow_up tf
                                        LEFT JOIN users us ON tf.id_usuario=us.id_usuario
                                        WHERE tf.id_ticket=".$fila['id_ticket']);              
                    while($fila_f = mysqli_fetch_assoc($list_follow_up)){
                        $mail->addAddress($fila_f['emailp']);
                    }
                }
                if($fila['id_status_ticket']==27){
                    $mail->addAddress($fila['correo_mantenimiento']);
                    $list_contestado = mysqli_query($conexion, "SELECT emailp FROM users
                                        WHERE id_usuario IN (5,33) AND id_usuario NOT IN (".$fila['id_mantenimiento'].")");
                    while($fila_c = mysqli_fetch_assoc($list_contestado)){
                        $mail->addAddress($fila_c['emailp']);
                    }
                }

                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = "Ticket ".$fila['cod_ticket']." ".$minuscula;

                $mail->Body = '<FONT SIZE=3>
                                    ¡Hola!<br><br>
                                    El siguiente ticket '.$fila['cod_ticket'].' se encuentra con el estado '.$minuscula.'.<br><br>
                                    <div style="border: 1px solid black;margin-left: 30px;padding: 5px 0 0 25px;background-color:#E0D9DF;">
                                        <table width="100%">
                                            <tr>
                                                <td>Empresa: '.$fila['cod_empresa'].'</td>
                                                <td>Tipo: '.$fila['nom_tipo_ticket'].'</td>
                                                <td>Solicitado por: '.$fila['solicitante'].'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Follow Up: '.$fila['follow_up'].'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Proyecto: '.$fila['proyecto'].'</td>
                                                <td>Sub-Proyecto: '.$fila['subproyecto'].'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">Descripción: '.$fila['ticket_desc'].'</td>
                                            </tr>
                                        </table>
                                    </div><br>
                                    Puedes usar el link abajo para aceder directamente:<br>
                                    https://www.snappy.org.pe/index.php?/General/Historial_Ticket/'.$fila['id_ticket'].'<br><br>
                                    Agradecemos tu pronta respuesta.<br>
                                    Que tengas un excelente dia.<br>
                                    Snappy
                                </FONT SIZE>';

                $mail->CharSet = 'UTF-8';
                $mail->send();
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }
?>