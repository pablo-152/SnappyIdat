<?php
    include 'conexion.php';
    include "mcript.php";

    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception;
 
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    }

    $query_correo = mysqli_query($conexion, "SELECT asunto,texto FROM correo_efsrt
                    WHERE id_tipo=4 AND estado=2 
                    LIMIT 1");
    $get_correo = mysqli_fetch_assoc($query_correo);
 
    $total_correo = mysqli_num_rows($query_correo);

    if($total_correo>0){ 
        //MODULO 1
        //1 CICLO - SEMANA 4 LUNES
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
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),INTERVAL 21 DAY)=CURDATE()
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC");

        while ($fila = mysqli_fetch_assoc($list_grupo)) { 
            $list_alumno = mysqli_query($conexion, "SELECT id_alumno,cod_alumno,apater_alumno,
                            amater_alumno,nom_alumno,dni_alumno,email_alumno,
                            TIMESTAMPDIFF(YEAR, cumpleanos_alumno, CURDATE()) AS edad
                            FROM entrega_formato_efsrt
                            WHERE grupo='".$fila['grupo']."' AND id_especialidad=".$fila['id_especialidad']." AND 
                            id_modulo=".$fila['id_modulo']." AND id_turno=".$fila['id_turno']." AND estado=2 AND 
                            id_alumno NOT IN (SELECT id_alumno FROM firma_contrato_efsrt 
                            WHERE grupo='".$fila['grupo']."' AND id_especialidad=".$fila['id_especialidad']." AND 
                            id_modulo=".$fila['id_modulo']." AND id_turno=".$fila['id_turno']." AND estado=2)");

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
                if($fila_alumno['edad']>=18){
                    $insert = mysqli_query($conexion, "INSERT INTO firma_contrato_efsrt (grupo,id_especialidad,
                                id_modulo,id_turno,id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,dni_alumno,
                                email_alumno,tipo,fec_envio,estado_f,estado,fec_reg,user_reg)
                                VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                                '".$fila['id_turno']."','".$fila_alumno['id_alumno']."','".$fila_alumno['cod_alumno']."',
                                '".$fila_alumno['apater_alumno']."','".$fila_alumno['amater_alumno']."',
                                '".$fila_alumno['nom_alumno']."','".$fila_alumno['dni_alumno']."',
                                '".$fila_alumno['email_alumno']."',1,NOW(),1,2,
                                NOW(),0)");

                    $query_firma_contrato = mysqli_query($conexion, "SELECT id_firma FROM firma_contrato_efsrt
                                            ORDER BY id_firma DESC
                                            LIMIT 1");
                    $get_firma_contrato = mysqli_fetch_assoc($query_firma_contrato); 

                    $encryption_id = $encriptar($get_firma_contrato['id_firma']);

                    $mail = new PHPMailer(true);
                    $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/firma_contrato_efsrt/".$encryption_id;

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

                        $mail->Body =  '<FONT SIZE=4>'.nl2br($get_correo['texto']).'<br><br>
                                                        Ingrese al link:'.$link.'
                                        </FONT SIZE>';

                        $mail->CharSet = 'UTF-8';
                        $mail->send();

                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }
                }
            }
        }

        //MODULO 1
        //2 CICLOS - SEMANA 15 LUNES
        /*$list_grupo = mysqli_query($conexion, "SELECT gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno
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
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),INTERVAL 15 WEEK)=CURDATE()
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC");

        while ($fila = mysqli_fetch_assoc($list_grupo)) {
            $list_alumno = mysqli_query($conexion, "SELECT id_alumno,cod_alumno,apater_alumno,
                            amater_alumno,nom_alumno,dni_alumno,email_alumno 
                            FROM entrega_formato_efsrt
                            WHERE grupo='".$fila['grupo']."' AND id_especialidad=".$fila['id_especialidad']." AND 
                            id_modulo=".$fila['id_modulo']." AND id_turno=".$fila['id_turno']." AND estado=2 AND 
                            id_alumno NOT IN (SELECT id_alumno FROM firma_contrato_efsrt 
                            WHERE grupo='".$fila['grupo']."' AND id_especialidad=".$fila['id_especialidad']." AND 
                            id_modulo=".$fila['id_modulo']." AND id_turno=".$fila['id_turno']." AND estado=2)");

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
                $insert = mysqli_query($conexion, "INSERT INTO firma_contrato_efsrt (grupo,id_especialidad,
                            id_modulo,id_turno,id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,dni_alumno,
                            email_alumno,tipo,fec_envio,estado_f,estado,fec_reg,user_reg)
                            VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                            '".$fila['id_turno']."','".$fila_alumno['id_alumno']."','".$fila_alumno['cod_alumno']."',
                            '".$fila_alumno['apater_alumno']."','".$fila_alumno['amater_alumno']."',
                            '".$fila_alumno['nom_alumno']."','".$fila_alumno['dni_alumno']."',
                            '".$fila_alumno['email_alumno']."',1,NOW(),1,2,
                            NOW(),0)");

                $query_firma_contrato = mysqli_query($conexion, "SELECT id_firma FROM firma_contrato_efsrt
                                        ORDER BY id_firma DESC
                                        LIMIT 1");
                $get_firma_contrato = mysqli_fetch_assoc($query_firma_contrato); 

                $encryption_id = $encriptar($get_firma_contrato['id_firma']);

                $mail = new PHPMailer(true);
                $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/firma_contrato_efsrt/".$encryption_id;

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

                    $mail->Body =  '<FONT SIZE=4>'.nl2br($get_correo['texto']).'<br><br>
                                                    Ingrese al link:'.$link.'
                                    </FONT SIZE>';

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
        }

        //MODULO que no son el 1
        //1 CICLO - SEMANA 4 LUNES
        $list_grupo = mysqli_query($conexion, "SELECT gc.grupo,es.nom_especialidad,mo.modulo,
                    gc.id_especialidad,gc.id_modulo,gc.id_turno
                    FROM grupo_calendarizacion gc
                    LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                    LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                    LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                    LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                    WHERE gc.estado_grupo NOT IN (4) AND
                    NOW() >= DATE_SUB(gc.inicio_clase, INTERVAL 42 DAY) AND
                    NOW() <= DATE_ADD(gc.fin_clase, INTERVAL 42 DAY) AND
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)=1 AND 
                    mo.modulo NOT IN ('M1') AND DATE_ADD(inicio_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),INTERVAL 21 DAY)=CURDATE()
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC");

        while ($fila = mysqli_fetch_assoc($list_grupo)) {
            $list_alumno = mysqli_query($conexion, "SELECT Id AS id_alumno,Codigo AS cod_alumno,
                            Apellido_Paterno AS apater_alumno,Apellido_Materno AS amater_alumno,
                            Nombre AS nom_alumno,Dni AS dni_alumno,Email AS email_alumno 
                            FROM todos_l20
                            WHERE Tipo=1 AND Grupo='".$fila['grupo']."' AND Especialidad='".$fila['nom_especialidad']."' AND 
                            Modulo='".$fila['modulo']."' AND Alumno='Matriculado' AND Matricula='Asistiendo'");

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
                $insert = mysqli_query($conexion, "INSERT INTO firma_contrato_efsrt (grupo,id_especialidad,
                            id_modulo,id_turno,id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,dni_alumno,
                            email_alumno,tipo,fec_envio,estado_f,estado,fec_reg,user_reg)
                            VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                            '".$fila['id_turno']."','".$fila_alumno['id_alumno']."','".$fila_alumno['cod_alumno']."',
                            '".$fila_alumno['apater_alumno']."','".$fila_alumno['amater_alumno']."',
                            '".$fila_alumno['nom_alumno']."','".$fila_alumno['dni_alumno']."',
                            '".$fila_alumno['email_alumno']."',1,NOW(),1,2,
                            NOW(),0)");

                $query_firma_contrato = mysqli_query($conexion, "SELECT id_firma FROM firma_contrato_efsrt
                                        ORDER BY id_firma DESC
                                        LIMIT 1");
                $get_firma_contrato = mysqli_fetch_assoc($query_firma_contrato); 

                $encryption_id = $encriptar($get_firma_contrato['id_firma']);

                $mail = new PHPMailer(true);
                $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/firma_contrato_efsrt/".$encryption_id;

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

                    $mail->Body =  '<FONT SIZE=4>'.nl2br($get_correo['texto']).'<br><br>
                                                    Ingrese al link:'.$link.'
                                    </FONT SIZE>';

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
        }

        //MODULO que no son el 1
        //2 CICLOS - SEMANA 15 LUNES
        $list_grupo = mysqli_query($conexion, "SELECT gc.grupo,es.nom_especialidad,mo.modulo,
                    gc.id_especialidad,gc.id_modulo,gc.id_turno
                    FROM grupo_calendarizacion gc
                    LEFT JOIN especialidad es ON es.id_especialidad=gc.id_especialidad AND es.estado=2
                    LEFT JOIN modulo mo ON mo.id_modulo=gc.id_modulo
                    LEFT JOIN turno tu ON tu.id_turno=gc.id_turno
                    LEFT JOIN hora ho ON ho.id_hora=tu.id_hora
                    WHERE gc.estado_grupo NOT IN (4) AND
                    NOW() >= DATE_SUB(gc.inicio_clase, INTERVAL 42 DAY) AND
                    NOW() <= DATE_ADD(gc.fin_clase, INTERVAL 42 DAY) AND
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)=2 AND 
                    mo.modulo NOT IN ('M1') AND DATE_ADD(inicio_fecha_efsrt(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno,
                    numero_ciclos_grupo(gc.grupo,gc.id_especialidad,gc.id_modulo,gc.id_turno)),INTERVAL 15 WEEK)=CURDATE()
                    GROUP BY gc.grupo,es.abreviatura,mo.modulo,ho.nom_turno
                    ORDER BY gc.grupo ASC,es.abreviatura ASC,mo.modulo ASC,ho.nom_turno ASC");

        while ($fila = mysqli_fetch_assoc($list_grupo)) {
            $list_alumno = mysqli_query($conexion, "SELECT Id AS id_alumno,Codigo AS cod_alumno,
                            Apellido_Paterno AS apater_alumno,Apellido_Materno AS amater_alumno,
                            Nombre AS nom_alumno,Dni AS dni_alumno,Email AS email_alumno 
                            FROM todos_l20
                            WHERE Tipo=1 AND Grupo='".$fila['grupo']."' AND Especialidad='".$fila['nom_especialidad']."' AND 
                            Modulo='".$fila['modulo']."' AND Alumno='Matriculado' AND Matricula='Asistiendo'");

            while($fila_alumno = mysqli_fetch_assoc($list_alumno)){
                $insert = mysqli_query($conexion, "INSERT INTO firma_contrato_efsrt (grupo,id_especialidad,
                            id_modulo,id_turno,id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,dni_alumno,
                            email_alumno,tipo,fec_envio,estado_f,estado,fec_reg,user_reg)
                            VALUES ('".$fila['grupo']."','".$fila['id_especialidad']."','".$fila['id_modulo']."',
                            '".$fila['id_turno']."','".$fila_alumno['id_alumno']."','".$fila_alumno['cod_alumno']."',
                            '".$fila_alumno['apater_alumno']."','".$fila_alumno['amater_alumno']."',
                            '".$fila_alumno['nom_alumno']."','".$fila_alumno['dni_alumno']."',
                            '".$fila_alumno['email_alumno']."',1,NOW(),1,2,
                            NOW(),0)");

                $query_firma_contrato = mysqli_query($conexion, "SELECT id_firma FROM firma_contrato_efsrt
                                        ORDER BY id_firma DESC
                                        LIMIT 1");
                $get_firma_contrato = mysqli_fetch_assoc($query_firma_contrato); 

                $encryption_id = $encriptar($get_firma_contrato['id_firma']);

                $mail = new PHPMailer(true);
                $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/firma_contrato_efsrt/".$encryption_id;

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
    }
?>