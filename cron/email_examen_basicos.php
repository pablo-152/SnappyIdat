<?php
    include 'conexion.php';
    include 'conexion_vps_examen.php';
    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception;
  
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
    $conexion->set_charset("utf8");

    $query_correo = mysqli_query($conexion, "SELECT asunto,texto FROM correo_efsrt
                    WHERE id_tipo=3 AND estado=2 
                    LIMIT 1");
    $get_correo = mysqli_fetch_assoc($query_correo);
    $total_correo = mysqli_num_rows($query_correo);

    $query_examen = mysqli_query($conexion_vps_examen, "SELECT id_examen,DATE_FORMAT(fec_limite, '%Y-%m-%d') as fec_limite FROM examen_efsrt_ifv
                    WHERE estado=2
                    ORDER BY id_examen DESC
                    LIMIT 1");
    $get_examen = mysqli_fetch_assoc($query_examen);
    $total_examen = mysqli_num_rows($query_examen);

    if($total_correo>0 && $total_examen>0){
        //1 CICLO - SEMANA 8 LUNES
        $list_grupo = mysqli_query($conexion, "SELECT gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno
                    FROM grupo_calendarizacion gc
                    LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                    LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                    LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                    LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                    WHERE gc.estado_grupo NOT IN (4) AND
                    NOW() >= DATE_SUB(gc.inicio_clase, INTERVAL 42 DAY) AND
                    NOW() <= DATE_ADD(gc.fin_clase, INTERVAL 42 DAY) AND
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)=1 AND 
                    mo.modulo='M1' AND DATE_ADD(inicio_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),INTERVAL 49 DAY)=CURDATE()
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC
                    LIMIT 3,1");

        while ($fila = mysqli_fetch_assoc($list_grupo)) {
            $list_alumno = mysqli_query($conexion, "SELECT et.id_alumno,et.cod_alumno,et.apater_alumno,
                            et.amater_alumno,et.nom_alumno,et.dni_alumno,et.email_alumno,et.id_especialidad,et.grupo
                            FROM entrega_temario_efsrt et
                            LEFT JOIN todos_l20 td ON td.Id=et.id_alumno
                            WHERE et.grupo='".$fila['grupo']."' AND et.id_especialidad=".$fila['id_especialidad']." AND 
                            et.id_modulo=".$fila['id_modulo']." AND et.id_turno=".$fila['id_turno']." AND et.estado=2 AND td.Pago_Pendiente<3 AND
                            et.id_alumno NOT IN (SELECT id_alumno FROM examen_basico_efsrt 
                            WHERE grupo='".$fila['grupo']."' AND id_especialidad=".$fila['id_especialidad']." AND 
                            id_modulo=".$fila['id_modulo']." AND id_turno=".$fila['id_turno']." AND estado=2)");

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){ 
                //if($fila_alumno['cod_alumno']=='24018'){
                    $mail = new PHPMailer(true);
                    $link = 'http://ifv.snappy.org.pe/practicas/index.php?/Examen/index/'.$fila_alumno['cod_alumno'];

                    try {
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'noreplay@ifv.edu.pe';                     // usuario de acceso
                        $mail->Password   = 'ifvc2022';                                // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->setFrom('noreplay@ifv.edu.pe', 'Instituto Federico Villarreal'); //desde donde se envia

                        $mail->addAddress($fila_alumno['email_alumno']);
                        //$mail->addAddress('daniel11143118@gmail.com');

                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->Subject = $get_correo['asunto'];

                        $mail->Body =  '<FONT SIZE=4>'.nl2br($get_correo['texto']).'<br><br>
                                                        Ingrese al link:'.$link.'
                                        </FONT SIZE>';

                        $mail->CharSet = 'UTF-8';
                        $mail->send();

                        mysqli_query($conexion, "INSERT INTO postulantes_efsrt (codigo,interese,id_carrera,nr_documento,apellido_pat,
                        apellido_mat,nombres,email,grupo,celular,id_examen,fec_examen,hora_inicio,fec_envio,estado,fec_reg)
                        VALUES ('".$fila_alumno['cod_alumno']."','".$fila_alumno['id_especialidad']."','".$fila_alumno['id_especialidad']."',
                        '".$fila_alumno['dni_alumno']."','".$fila_alumno['apater_alumno']."','".$fila_alumno['amater_alumno']."',
                        '".$fila_alumno['nom_alumno']."', '".$fila_alumno['email_alumno']."','".$fila_alumno['grupo']."','',
                        '".$get_examen['id_examen']."','".$get_examen['fec_limite']."','16:15:00',NOW(),30,NOW())");

                        mysqli_query($conexion_vps_examen, "INSERT INTO pos_exam_efsrt (idpos_pe,idexa_pe,fec_examen,
                        hora_inicio,hora_final,id_carrera,estado_pe,fec_reg,user_reg,fec_act,fec_eli,user_act,user_eli) 
                        VALUES ('".$fila_alumno['cod_alumno']."','".$get_examen['id_examen']."','".$get_examen['fec_limite']."',
                        '16:15:00',ADDTIME('16:15:00', '00:20:00'),'".$fila_alumno['id_carrera']."',30,NOW(),'0',NOW(),NOW(),0,0)");

                        mysqli_query($conexion, "INSERT INTO examen_basico_efsrt (grupo,id_especialidad,
                        id_modulo,id_turno,id_examen_efsrt,id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,
                        dni_alumno,email_alumno,fec_envio,estado_e,estado,fec_reg,user_reg)
                        VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                        '".$fila['id_turno']."','".$get_examen['id_examen']."','".$fila_alumno['id_alumno']."',
                        '".$fila_alumno['cod_alumno']."','".$fila_alumno['apater_alumno']."',
                        '".$fila_alumno['amater_alumno']."','".$fila_alumno['nom_alumno']."',
                        '".$fila_alumno['dni_alumno']."','".$fila_alumno['email_alumno']."',
                        NOW(),1,2,NOW(),0)");
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }
                //}
            }
        }
    
        /*2 CICLOS - SEMANA 16 LUNES
        $list_grupo = mysqli_query($conexion, "SELECT gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno
                    FROM grupo_calendarizacion gc
                    LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                    LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                    LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                    LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                    WHERE gc.estado_grupo NOT IN (4) AND
                    NOW() >= DATE_SUB(gc.inicio_clase, INTERVAL 42 DAY) AND
                    NOW() <= DATE_ADD(gc.fin_clase, INTERVAL 42 DAY) AND
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)=2 AND 
                    mo.modulo='M1' AND DATE_ADD(inicio_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),INTERVAL 16 WEEK)=CURDATE()
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC");

        while ($fila = mysqli_fetch_assoc($list_grupo)) {
            $list_alumno = mysqli_query($conexion, "SELECT et.id_alumno,et.cod_alumno,et.apater_alumno,
                            et.amater_alumno,et.nom_alumno,et.dni_alumno,et.email_alumno 
                            FROM entrega_temario_efsrt et
                            LEFT JOIN todos_l20 td ON td.Id=et.id_alumno
                            WHERE et.grupo='".$fila['grupo']."' AND et.id_especialidad=".$fila['id_especialidad']." AND 
                            et.id_modulo=".$fila['id_modulo']." AND et.id_turno=".$fila['id_turno']." AND et.estado=2 AND td.Pago_Pendiente<3 AND
                            et.id_alumno NOT IN (SELECT id_alumno FROM examen_basico_efsrt 
                            WHERE grupo='".$fila['grupo']."' AND id_especialidad=".$fila['id_especialidad']." AND 
                            id_modulo=".$fila['id_modulo']." AND id_turno=".$fila['id_turno']." AND estado=2)");

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
                $insert = mysqli_query($conexion, "INSERT INTO examen_basico_efsrt (grupo,id_especialidad,
                            id_modulo,id_turno,id_examen_efsrt,id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,
                            dni_alumno,email_alumno,fec_envio,estado_e,estado,fec_reg,user_reg)
                            VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                            '".$fila['id_turno']."','".$get_examen['id_examen']."','".$fila_alumno['id_alumno']."',
                            '".$fila_alumno['cod_alumno']."','".$fila_alumno['apater_alumno']."',
                            '".$fila_alumno['amater_alumno']."','".$fila_alumno['nom_alumno']."',
                            '".$fila_alumno['dni_alumno']."','".$fila_alumno['email_alumno']."',
                            NOW(),1,2,NOW(),0)");

                $mail = new PHPMailer(true);
                $link = 'http://ifv.snappy.org.pe/practicas/index.php?/Examen/index/'.$fila_alumno['cod_alumno'];

                try {
                    $mail->SMTPDebug = 0;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'noreplay@ifv.edu.pe';                     // usuario de acceso
                    $mail->Password   = 'ifvc2022';                                // SMTP password
                    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->setFrom('noreplay@ifv.edu.pe', 'Instituto Federico Villarreal'); //desde donde se envia

                    //$mail->addAddress($fila_alumno['email_alumno']);
                    $mail->addAddress('fhuertamendez2015@gmail.com');

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = $get_correo['asunto'];

                    $mail->Body =  '<FONT SIZE=4>'.nl2br($get_correo['texto']).'<br><br>
                                                    Ingrese al link:'.$link.'
                                    </FONT SIZE>';

                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
        }*/

        /*$list_alumno = mysqli_query($conexion, "SELECT et.id_alumno,et.cod_alumno,et.apater_alumno,
        et.amater_alumno,et.nom_alumno,et.dni_alumno,et.email_alumno,td.Codigo as codigo,
        td.Especialidad as interese,
        (select e.id_especialidad from especialidad e where td.Especialidad=e.nom_especialidad and e.estado=2 limit 1) as id_carrera,
        td.Dni as nr_documento,td.Apellido_Paterno as apellido_pat,td.Apellido_Materno as apellido_mat,
        td.Nombre as nombres,td.Email as email,et.grupo,td.Celular as celular
        FROM entrega_temario_efsrt et
        LEFT JOIN todos_l20 td ON td.Id=et.id_alumno and td.Codigo in (23647)
        WHERE et.grupo='23/3' AND et.estado=2 AND td.Pago_Pendiente<3 AND
        et.id_alumno NOT IN (SELECT id_alumno FROM examen_basico_efsrt 
        WHERE grupo='23/3' AND estado=2)");

        while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
            $insert = mysqli_query($conexion, "INSERT INTO postulantes_efsrt (codigo,interese,id_carrera,nr_documento,apellido_pat,
            apellido_mat,nombres,email,grupo,celular,
            id_examen,fec_examen,hora_inicio,fec_envio,estado, fec_reg)
                        VALUES ('".$fila_alumno['codigo']."', '".$fila_alumno['interese']."','".$fila_alumno['id_carrera']."',
                        '".$fila_alumno['nr_documento']."','".$fila_alumno['apellido_pat']."', 
                '".$fila_alumno['apellido_mat']."','".$fila_alumno['nombres']."', '".$fila_alumno['email']."',
                '".$fila_alumno['grupo']."','".$fila_alumno['celular']."',
                '".$get_examen['id_examen']."','".$get_examen['fec_limite']."','08:21:00',NOW(),
                30,NOW())");

            $insert = mysqli_query($conexion_vps_examen, "INSERT INTO pos_exam_efsrt (idpos_pe,idexa_pe,fec_examen,
            hora_inicio,hora_final,id_carrera,estado_pe,fec_reg,user_reg,fec_act,fec_eli,user_act,user_eli) 
            VALUES ('".$fila_alumno['codigo']."','".$get_examen['id_examen']."','".$get_examen['fec_limite']."',
            '08:21:00',ADDTIME('08:21:00', '00:30:00'),'".$fila_alumno['id_carrera']."',30,NOW(),'0',NOW(),NOW(),0,0)");

            $insert = mysqli_query($conexion, "INSERT INTO examen_basico_efsrt (grupo,id_especialidad,
                        id_modulo,id_turno,id_examen_efsrt,id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,
                        dni_alumno,email_alumno,fec_envio,estado_e,estado,fec_reg,user_reg)
                        VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                        '".$fila['id_turno']."','".$get_examen['id_examen']."','".$fila_alumno['id_alumno']."',
                        '".$fila_alumno['cod_alumno']."','".$fila_alumno['apater_alumno']."',
                        '".$fila_alumno['amater_alumno']."','".$fila_alumno['nom_alumno']."',
                        '".$fila_alumno['dni_alumno']."','".$fila_alumno['email_alumno']."',
                        NOW(),1,2,NOW(),0)");

            $mail = new PHPMailer(true);
            $link = 'http://ifv.snappy.org.pe/practicas/index.php?/Examen/index/'.$fila_alumno['cod_alumno'];

            try {
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'noreplay@ifv.edu.pe';                     // usuario de acceso
                $mail->Password   = 'ifvc2022';                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('noreplay@ifv.edu.pe', 'Instituto Federico Villarreal'); //desde donde se envia

                $mail->addAddress($fila_alumno['email_alumno']);
                //$mail->addAddress('fhuertamendez2015@gmail.com');
                //$mail->addAddress('dtecnologia@ifv.edu.pe');

                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = $get_correo['asunto'];

                $mail->Body =  '<FONT SIZE=4>'.nl2br($get_correo['texto']).'<br><br>
                                                Ingrese al link:'.$link.'
                                </FONT SIZE>';

                $mail->CharSet = 'UTF-8';
                $mail->send();
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }*/
    }
?>