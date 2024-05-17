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

    $query_correo = mysqli_query($conexion, "SELECT asunto,texto FROM correo_efsrt
                    WHERE id_tipo=5 AND estado=2 
                    LIMIT 1");
    $get_correo = mysqli_fetch_assoc($query_correo);
    $total_correo = mysqli_num_rows($query_correo);

    if($total_correo>0){
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
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),INTERVAL 50 DAY)=CURDATE()
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC");

        while ($fila = mysqli_fetch_assoc($list_grupo)) {
            $list_alumno = mysqli_query($conexion, "SELECT id_examen,id_examen_efsrt,id_alumno,cod_alumno,
                            apater_alumno,amater_alumno,nom_alumno,dni_alumno,email_alumno 
                            FROM examen_basico_efsrt
                            WHERE grupo='".$fila['grupo']."' AND id_especialidad=".$fila['id_especialidad']." AND 
                            id_modulo=".$fila['id_modulo']." AND id_turno=".$fila['id_turno']." AND estado=2"); 

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
                $query_resultado = mysqli_query($conexion_vps_examen, "SELECT ROUND(puntaje) AS puntaje,fec_termino 
                                    FROM resultado_examen_efsrt_ifv 
                                    WHERE cod_postulante='".$fila_alumno['cod_alumno']."' AND 
                                    id_examen='".$fila_alumno['id_examen_efsrt']."' AND estado IN (31,33)
                                    ORDER BY id_resultado DESC");
                $get_resultado = mysqli_fetch_assoc($query_resultado);
                $total_resultado = mysqli_num_rows($query_resultado);

                if($total_resultado>0){
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
                        $mail->setFrom('noreplay@ifv.edu.pe', 'Instituto Federico Villarreal'); //desde donde se envia
    
                        $mail->addAddress($fila_alumno['email_alumno']);
                        
                        $mail->isHTML(true);                                  // Set email format to HTML
    
                        $mail->Subject = $get_correo['asunto'];
    
                        $mail->Body = '<FONT SIZE=4>'.nl2br($get_correo['texto']).' '.$get_resultado['puntaje'].'
                                        </FONT SIZE>';
    
                        $mail->CharSet = 'UTF-8';
                        $mail->send();

                        /*if($get_resultado['puntaje']<11){
                            $estado_e = 2;
                        }else{*/
                            $estado_e = 3;
                        //}

                        mysqli_query($conexion, "UPDATE examen_basico_efsrt SET 
                        fec_termino='".$get_resultado['fec_termino']."',
                        nota='".$get_resultado['puntaje']."',
                        fec_nota=NOW(),estado_e=$estado_e,
                        fec_act=NOW(),user_act=0
                        WHERE id_examen='".$fila_alumno['id_examen']."'");
    
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }

                    /*if($get_resultado['puntaje']<11){
                        $query_venta_empresa = mysqli_query($conexion, "SELECT id_venta FROM venta_empresa 
                                                WHERE id_empresa=6");
                        $totalRows_t = mysqli_num_rows($query_venta_empresa);
                        $aniof = substr(date('Y'),2,2);

                        if($totalRows_t<9){
                            $codigo=$aniof."R-FV10000".($totalRows_t+1);
                        }
                        if($totalRows_t>8 && $totalRows_t<99){
                            $codigo=$aniof."R-FV1000".($totalRows_t+1);
                        }
                        if($totalRows_t>98 && $totalRows_t<999){
                            $codigo=$aniof."R-FV100".($totalRows_t+1);
                        }
                        if($totalRows_t>998 && $totalRows_t<9999){
                            $codigo=$aniof."R-FV10".($totalRows_t+1);
                        }
                        if($totalRows_t>9998 && $totalRows_t<99999){
                            $codigo=$aniof."R-FV1".($totalRows_t+1);
                        }

                        $insert = mysqli_query($conexion, "INSERT INTO venta_empresa (cod_venta,id_empresa,
                                    id_alumno,pendiente,estado,fec_reg,user_reg) 
                                    VALUES ('$codigo',6,'".$fila_alumno['id_alumno']."',1,2,NOW(),0)");

                        $query_ultimo = mysqli_query($conexion, "SELECT id_venta FROM venta_empresa
                                                WHERE id_empresa=6
                                                ORDER BY id_venta DESC LIMIT 1");
                        $ultimo = mysqli_fetch_assoc($query_ultimo);

                        $insert = mysqli_query($conexion, "INSERT INTO venta_empresa_detalle (id_venta,
                                    cod_producto,precio,descuento,cantidad,estado,fec_reg,user_reg) 
                                    VALUES ('".$ultimo['id_venta']."','FV15',100.00,
                                    0.00,1,2,NOW(),0)");

                        $insert = mysqli_query($conexion, "INSERT INTO rezagado_efsrt (grupo,id_especialidad,
                                    id_modulo,id_turno,id_examen_basico,id_venta,estado_r,estado,fec_reg,user_reg) 
                                    VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."',
                                    '".$fila['id_modulo']."','".$fila['id_turno']."','".$fila_alumno['id_examen']."',
                                    '".$ultimo['id_venta']."',1,2,NOW(),0)");
                    }else{*/
                        mysqli_query($conexion, "INSERT INTO evaluacion_basica_efsrt (grupo,id_especialidad,
                        id_modulo,id_turno,id_examen_basico,estado_e,estado,fec_reg,user_reg) 
                        VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                        '".$fila['id_turno']."','".$fila_alumno['id_examen']."',1,2,NOW(),0)");
                    //}
                }
            }
        }
    
        //2 CICLOS - SEMANA 16 LUNES
        /*$list_grupo = mysqli_query($conexion, "SELECT gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno
                    FROM grupo_calendarizacion gc
                    LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                    LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                    LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                    LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                    WHERE gc.estado_grupo NOT IN (4) AND
                    (gc.fin_clase>=CURDATE() OR (gc.fin_clase<=CURDATE() AND
                    TIMESTAMPDIFF(DAY,gc.fin_clase,CURDATE())<=42)) AND
                    (gc.inicio_clase<=CURDATE() OR (gc.inicio_clase>=CURDATE() AND
                    TIMESTAMPDIFF(DAY,CURDATE(),gc.inicio_clase)>=42)) AND 
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)=2 AND 
                    mo.modulo='M1' AND DATE_ADD(inicio_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),/INTERVAL 113 DAY)=CURDATE()
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC"); 

        while ($fila = mysqli_fetch_assoc($list_grupo)) {
            $list_alumno = mysqli_query($conexion, "SELECT id_examen,id_examen_efsrt,id_alumno,cod_alumno,
                            apater_alumno,amater_alumno,nom_alumno,dni_alumno,email_alumno 
                            FROM examen_basico_efsrt
                            WHERE grupo='".$fila['grupo']."' AND id_especialidad=".$fila['id_especialidad']." AND 
                            id_modulo=".$fila['id_modulo']." AND estado=2 AND fec_nota IS NULL");

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
                $query_resultado = mysqli_query($conexion_vps_examen, "SELECT puntaje,fec_termino 
                                    FROM resultado_examen_efsrt_ifv 
                                    WHERE cod_postulante='".$fila_alumno['cod_alumno']."' AND 
                                    id_examen='".$fila_alumno['id_examen_efsrt']."' AND estado IN (31,33)");
                $get_resultado = mysqli_fetch_assoc($query_resultado);
                $total_resultado = mysqli_num_rows($query_resultado);

                if($total_resultado>0){
                    if($get_resultado['puntaje']<11){
                        $estado_e = 2;
                    }else{
                        $estado_e = 3;
                    }

                    $update = mysqli_query($conexion, "UPDATE examen_basico_efsrt SET 
                                fec_termino='".$get_resultado['fec_termino']."',
                                nota='".$get_resultado['puntaje']."',
                                fec_nota=NOW(),estado_e=$estado_e,
                                fec_act=NOW(),user_act=0
                                WHERE id_examen='".$fila_alumno['id_examen']."'");

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
                        $mail->setFrom('noreplay@ifv.edu.pe', 'Instituto Federico Villarreal'); //desde donde se envia
    
                        $mail->addAddress($fila_alumno['email_alumno']);
                        
                        $mail->isHTML(true);                                  // Set email format to HTML
    
                        $mail->Subject = $get_correo['asunto'];
    
                        $mail->Body = '<FONT SIZE=4>'.nl2br($get_correo['texto']).'<br><br>
                                                        Su nota es: '.$get_resultado['puntaje'].'
                                        </FONT SIZE>';
    
                        $mail->CharSet = 'UTF-8';
                        $mail->send();
    
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }

                    if($get_resultado['puntaje']<11){
                        $query_venta_empresa = mysqli_query($conexion, "SELECT id_venta FROM venta_empresa 
                                                WHERE id_empresa=6");
                        $totalRows_t = mysqli_num_rows($query_venta_empresa);
                        $aniof = substr(date('Y'),2,2);

                        if($totalRows_t<9){
                            $codigo=$aniof."R-FV10000".($totalRows_t+1);
                        }
                        if($totalRows_t>8 && $totalRows_t<99){
                            $codigo=$aniof."R-FV1000".($totalRows_t+1);
                        }
                        if($totalRows_t>98 && $totalRows_t<999){
                            $codigo=$aniof."R-FV100".($totalRows_t+1);
                        }
                        if($totalRows_t>998 && $totalRows_t<9999){
                            $codigo=$aniof."R-FV10".($totalRows_t+1);
                        }
                        if($totalRows_t>9998 && $totalRows_t<99999){
                            $codigo=$aniof."R-FV1".($totalRows_t+1);
                        }

                        $insert = mysqli_query($conexion, "INSERT INTO venta_empresa (cod_venta,id_empresa,
                                    id_alumno,pendiente,estado,fec_reg,user_reg) 
                                    VALUES ('$codigo',6,'".$fila_alumno['id_alumno']."',1,2,NOW(),0)");

                        $query_ultimo = mysqli_query($conexion, "SELECT id_venta FROM venta_empresa
                                                WHERE id_empresa=6
                                                ORDER BY id_venta DESC LIMIT 1");
                        $ultimo = mysqli_fetch_assoc($query_ultimo);

                        $insert = mysqli_query($conexion, "INSERT INTO venta_empresa_detalle (id_venta,
                                    cod_producto,precio,descuento,cantidad,estado,fec_reg,user_reg) 
                                    VALUES ('".$ultimo['id_venta']."','FV15',100.00,
                                    0.00,1,2,NOW(),0)");

                        $insert = mysqli_query($conexion, "INSERT INTO rezagado_efsrt (grupo,id_especialidad,
                                    id_modulo,id_turno,id_examen_basico,id_venta,estado_r,estado,fec_reg,user_reg) 
                                    VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."',
                                    '".$fila['id_modulo']."','".$fila['id_turno']."','".$fila_alumno['id_examen']."',
                                    '".$ultimo['id_venta']."',1,2,NOW(),0)");
                    }else{
                        $insert = mysqli_query($conexion, "INSERT INTO evaluacion_basica_efsrt (grupo,id_especialidad,
                                    id_modulo,id_turno,id_examen_basico,estado_e,estado,fec_reg,user_reg) 
                                    VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                                    '".$fila['id_turno']."','".$fila_alumno['id_examen']."',1,2,NOW(),0)");
                    }
                }
            }
        }*/
    }
?>