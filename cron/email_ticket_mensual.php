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


    $terminados = mysqli_query($conexion, "SELECT COUNT(*) as terminados
    FROM ticket t
    LEFT JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
    LEFT JOIN users u on u.id_usuario=t.user_reg
    LEFT JOIN empresa e on e.id_empresa=t.id_empresa
    LEFT JOIN proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
    LEFT JOIN subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
    LEFT JOIN status_general st on st.id_status_general=t.id_status_ticket
    LEFT JOIN users ue on ue.id_usuario=t.id_mantenimiento
    LEFT JOIN users uo on uo.id_usuario=t.id_solicitante
    left join mes m on month(t.fec_reg)=m.cod_mes
    WHERE t.id_status_ticket=23
    order by t.prioridad");
    $revision = mysqli_query($conexion, "SELECT COUNT(*) as en_revision
    FROM ticket t
    LEFT JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
    LEFT JOIN users u on u.id_usuario=t.user_reg
    LEFT JOIN empresa e on e.id_empresa=t.id_empresa
    LEFT JOIN proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
    LEFT JOIN subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
    LEFT JOIN status_general st on st.id_status_general=t.id_status_ticket
    LEFT JOIN users ue on ue.id_usuario=t.id_mantenimiento
    LEFT JOIN users uo on uo.id_usuario=t.id_solicitante
    left join mes m on month(t.fec_reg)=m.cod_mes
    WHERE t.id_status_ticket=36
    order by t.prioridad");
    $contestado = mysqli_query($conexion, "SELECT COUNT(*) as contestado
    FROM ticket t
    LEFT JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
    LEFT JOIN users u on u.id_usuario=t.user_reg
    LEFT JOIN empresa e on e.id_empresa=t.id_empresa
    LEFT JOIN proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
    LEFT JOIN subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
    LEFT JOIN status_general st on st.id_status_general=t.id_status_ticket
    LEFT JOIN users ue on ue.id_usuario=t.id_mantenimiento
    LEFT JOIN users uo on uo.id_usuario=t.id_solicitante
    left join mes m on month(t.fec_reg)=m.cod_mes
    WHERE t.id_status_ticket=27
    order by t.prioridad");
    $solicitado = mysqli_query($conexion, "SELECT COUNT(*) as solicitado
    from ticket t
    left join tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
    left join users u on u.id_usuario=t.user_reg
    left join empresa e on e.id_empresa=t.id_empresa
    left join proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
    left join subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
    left join status_general st on st.id_status_general=t.id_status_ticket
    left join users ue on ue.id_usuario=t.id_mantenimiento
    left join users uo on uo.id_usuario=t.id_solicitante
    left join mes m on month(t.fec_reg)=m.cod_mes
    where t.id_status_ticket IN (1)
    order by t.prioridad");
    $mes=date('m');
    if($mes<10){
        $mes=substr($mes, 1, 1);
    }
    $anio=date('Y');
    $fecha=$mes."-".$anio;
    $revisado = mysqli_query($conexion, "SELECT count(*) as revisados
    from ticket t
    LEFT JOIN tipo_ticket tt on tt.id_tipo_ticket=t.id_tipo_ticket
    LEFT JOIN users u on u.id_usuario=t.user_reg
    LEFT JOIN empresa e on e.id_empresa=t.id_empresa
    LEFT JOIN proyecto_soporte ps on ps.id_proyecto_soporte=t.id_proyecto_soporte
    LEFT JOIN subproyecto_soporte sps on sps.id_subproyecto_soporte=t.id_subproyecto_soporte
    LEFT JOIN status_general st on st.id_status_general=t.id_status_ticket
    LEFT JOIN users ue on ue.id_usuario=t.id_mantenimiento
    LEFT JOIN users uo on uo.id_usuario=t.id_solicitante
    left join mes m on month(t.fec_reg)=m.cod_mes
    WHERE t.id_status_ticket=34 AND t.completado=0 and (SELECT concat(month(htt.fec_reg),'-',year(htt.fec_reg)) FROM historial_ticket htt
    WHERE htt.id_ticket=t.id_ticket and htt.estado=1 ORDER BY htt.fec_reg DESC LIMIT 1) = '$fecha'
    ORDER BY t.prioridad;");

    $get_terminados = mysqli_fetch_assoc($terminados);
    $get_revision = mysqli_fetch_assoc($revision);
    $get_contestado = mysqli_fetch_assoc($contestado);
    $get_revisado = mysqli_fetch_assoc($revisado);
    $get_solicitado = mysqli_fetch_assoc($solicitado);

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
        $mail->setFrom('no-reply@gllg.edu.pe', 'Tickets'); //desde donde se envia

        $array=explode(",",$get_id['autorizaciones']);
        $contador=0;
        $cadena="";
        
        //$mail->addAddress('fhuertamendez2015@gmail.com');
        $mail->addAddress('vanessa.hilario@gllg.edu.pe');
        $mail->addAddress('fidel.sante@gllg.edu.pe');
        $mail->addAddress('dtecnologia@gllg.edu.pe');
        $mail->addAddress('pedro.vieira@gllg.edu.pe');
        
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Advertencia Tickets Snappy';

        $mail->Body =  '<p style="font-size:14px;">¡Hola!</p>
                        <p style="font-size:14px;">A la fecha, en Soporte Snappy, tienes:</p>
                        <table style="border:hidden;font-size:14px;" width="100%">
                            <tr>
                                <td colspan="4">- '.$get_terminados['terminados'].' tkt "Terminados" (pendientes de revisión) </td>
                            </tr>
                            <tr>
                                <td colspan="4">- '.$get_revision['en_revision'].' tkt "En Revisión"</td>
                            </tr>
                            <tr>
                                <td colspan="4">- '.$get_contestado['contestado'].' tkt "Contestados"</td>
                            </tr>
                            <tr>
                                <td colspan="4">- '.$get_solicitado['solicitado'].' tkt "Solicitados"</td>
                            </tr>
                        </table>
                        <br>
                        <table style="border:hidden;font-size:14px;" width="100%">
                            <tr>
                                <td colspan="4">- '.$get_revisado['revisados'].' tkt "Revisados". </td>
                            </tr>
                        </table>
                        <p style="font-size:14px;">El mes se cierra dentro de poco. Agiliza cierre de proyectos.</p>
                        <p style="font-size:14px;">Saludos!</p>';

        $mail->CharSet = 'UTF-8';
        $mail->send();

    } catch (Exception $e) {
        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
    }
?>