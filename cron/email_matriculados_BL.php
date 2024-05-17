<?php 
    include 'conexion.php';
    include "mcript.php"; 
    include 'httpPHPAltiria.php';

    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception;  

    require 'PHPMailer/Exception.php';  
    require 'PHPMailer/PHPMailer.php'; 
    require 'PHPMailer/SMTP.php';
    
    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $query_c = mysqli_query($conexion, "SELECT * FROM c_contrato 
                WHERE id_empresa=3 AND estado=2");

    while($get_contrato = mysqli_fetch_assoc($query_c)){
        $parte_grado_1 = "";
        $parte_seccion_1 = "";
        if($get_contrato['id_grado']!="0"){
            $parte_grado_1 = "AND ua.nom_grado='".$get_contrato['id_grado']."'";
        }
        if($get_contrato['id_seccion']!="0"){
            $parte_seccion_1 = "AND ua.nom_seccion='".$get_contrato['id_seccion']."'";
        }
        $parte_grado_2 = "";
        $parte_seccion_2 = "";
        if($get_contrato['id_grado']!="0"){
            $parte_grado_2 = "AND ub.nom_grado='".$get_contrato['id_grado']."'";
        }
        if($get_contrato['id_seccion']!="0"){
            $parte_seccion_2 = "AND ub.nom_seccion='".$get_contrato['id_seccion']."'";
        }

        $query_a = mysqli_query($conexion, "SELECT 1 AS Id,aa.id_alumno AS Id_Alumno,aa.titular1_apater AS Apellido_Paterno,
                    aa.titular1_amater AS Apellido_Materno,aa.titular1_nom AS Nombre,
                    aa.titular1_correo AS Email,aa.titular1_celular AS Celular,
                    pa.nom_parentesco AS Parentesco,aa.cod_alum AS cod_alumno,
                    aa.alum_apater AS apater_alumno,aa.alum_amater AS amater_alumno,
                    aa.alum_nom AS nom_alumno,ua.nom_grado AS grado_alumno,
                    ua.nom_seccion AS seccion_alumno
                    FROM alumno aa
                    LEFT JOIN parentesco pa ON pa.id_parentesco=aa.titular1_parentesco
                    LEFT JOIN ultima_matricula_bl ua ON ua.id_alumno=aa.id_alumno
                    WHERE aa.id_sede=6 AND aa.estado=2 AND aa.titular1_correo!='' AND 
                    ua.anio=".date('Y')." AND ua.pago_matricula=0 AND 
                    ua.estado_matricula NOT IN ('Retirado(a)')
                    $parte_grado_1 $parte_seccion_1
                    UNION 
                    SELECT 2 AS Id,ab.id_alumno AS Id_Alumno,ab.titular2_apater AS Apellido_Paterno,
                    ab.titular2_amater AS Apellido_Materno,ab.titular2_nom AS Nombre,
                    ab.titular2_correo AS Email,ab.titular2_celular AS Celular,
                    pb.nom_parentesco AS Parentesco,ab.cod_alum AS cod_alumno,
                    ab.alum_apater AS apater_alumno,ab.alum_amater AS amater_alumno,
                    ab.alum_nom AS nom_alumno,ub.nom_grado AS grado_alumno,
                    ub.nom_seccion AS seccion_alumno
                    FROM alumno ab
                    LEFT JOIN parentesco pb ON pb.id_parentesco=ab.titular2_parentesco
                    LEFT JOIN ultima_matricula_bl ub ON ub.id_alumno=ab.id_alumno
                    WHERE ab.id_sede=6 AND ab.estado=2 AND ab.titular2_correo!='' AND 
                    ub.anio=".date('Y')." AND ub.pago_matricula=0 AND 
                    ub.estado_matricula NOT IN ('Retirado(a)')
                    $parte_grado_2 $parte_seccion_2");

        if($get_contrato['tipo']==5){
            if($get_contrato['fecha_envio']==date('Y-m-d')){
                while ($fila = mysqli_fetch_assoc($query_a)) { 
                    $query_d = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma 
                                WHERE id_alumno=".$fila['Id_Alumno']." AND id_apoderado=".$fila['Id']." AND id_empresa=3 AND enviado=1 AND 
                                id_contrato=".$get_contrato['id_c_contrato']." AND estado=2");
                    $total = mysqli_num_rows($query_d);
    
                    if($total==0){
                        $insert_documento_firma = mysqli_query($conexion, "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                                                    nom_alumno,grado_alumno,seccion_alumno,id_apoderado,apater_apoderado,amater_apoderado,nom_apoderado,
                                                    parentesco_apoderado,email_apoderado,celular_apoderado,id_empresa,enviado,fecha_envio,id_contrato,
                                                    estado_d,estado,fec_reg,user_reg)
                                                    VALUES ('".$fila['Id_Alumno']."','".$fila['cod_alumno']."','".$fila['apater_alumno']."','".$fila['amater_alumno']."',
                                                    '".$fila['nom_alumno']."','".$fila['grado_alumno']."','".$fila['seccion_alumno']."','".$fila['Id']."',
                                                    '".$fila['Apellido_Paterno']."','".$fila['Apellido_Materno']."','".$fila['Nombre']."',
                                                    '".$fila['Parentesco']."','".$fila['Email']."','".$fila['Celular']."',3,1,NOW(),
                                                    '".$get_contrato['id_c_contrato']."',2,2,NOW(),0)");

                        $query_documento_firma = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma
                                                ORDER BY id_documento_firma DESC
                                                LIMIT 1");
                        $get_documento_firma = mysqli_fetch_assoc($query_documento_firma); 

                        $encryption_id = $encriptar($get_documento_firma['id_documento_firma']);

                        $mail = new PHPMailer(true); 
                        $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_bl/".$encryption_id;
                        
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'admision@babyleaders.edu.pe';                     // usuario de acceso
                            $mail->Password   = 'vilfgbmbjncpmjks';                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('noreply@snappy.org.pe', 'Baby Leaders'); //desde donde se envia
                            
                            $mail->addAddress($fila['Email']);
                            
                            $mail->isHTML(true);                                  // Set email format to HTML
                    
                            $mail->Subject = $get_contrato['asunto'];
                    
                            $mail->Body =  '<FONT SIZE=3>'.nl2br($get_contrato['texto_correo']).'<br><br>
                                                            Ingrese al link:'.$link.'
                                            </FONT SIZE>';
                    
                            $mail->CharSet = 'UTF-8';
                            $mail->send();
                    
                        } catch (Exception $e) {
                            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}"; 
                        }
    
                        if($get_contrato['sms']==1){
                            $altiriaSMS = new AltiriaSMS();
        
                            $altiriaSMS->setDebug(true);
                            $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                            $altiriaSMS->setPassword('gllg2021');
                        
                            $sDestination = '51'.$fila['Celular'];
                            $sMessage = $get_contrato['texto_sms'];
                            $altiriaSMS->sendSMS($sDestination, $sMessage);
                        }
                    }
                }
            }
        }else{
            while ($fila = mysqli_fetch_assoc($query_a)) { 
                $query_d = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma 
                            WHERE id_alumno=".$fila['Id_Alumno']." AND id_apoderado=".$fila['Id']." AND id_empresa=3 AND enviado=1 AND 
                            id_contrato=".$get_contrato['id_c_contrato']." AND estado=2");
                $total = mysqli_num_rows($query_d);

                if($total==0){
                    $insert_documento_firma = mysqli_query($conexion, "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                                                nom_alumno,grado_alumno,seccion_alumno,id_apoderado,apater_apoderado,amater_apoderado,nom_apoderado,
                                                parentesco_apoderado,email_apoderado,celular_apoderado,id_empresa,enviado,fecha_envio,id_contrato,
                                                estado_d,estado,fec_reg,user_reg)
                                                VALUES ('".$fila['Id_Alumno']."','".$fila['cod_alumno']."','".$fila['apater_alumno']."','".$fila['amater_alumno']."',
                                                '".$fila['nom_alumno']."','".$fila['grado_alumno']."','".$fila['seccion_alumno']."','".$fila['Id']."',
                                                '".$fila['Apellido_Paterno']."','".$fila['Apellido_Materno']."','".$fila['Nombre']."',
                                                '".$fila['Parentesco']."','".$fila['Email']."','".$fila['Celular']."',3,1,NOW(),
                                                '".$get_contrato['id_c_contrato']."',2,2,NOW(),0)");

                    $query_documento_firma = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma
                                            ORDER BY id_documento_firma DESC
                                            LIMIT 1");
                    $get_documento_firma = mysqli_fetch_assoc($query_documento_firma);

                    $encryption_id = $encriptar($get_documento_firma['id_documento_firma']);

                    $mail = new PHPMailer(true); 
                    $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_bl/".$encryption_id;
                    
                    try {
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'admision@babyleaders.edu.pe';                     // usuario de acceso
                        $mail->Password   = 'vilfgbmbjncpmjks';                                // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->setFrom('noreply@snappy.org.pe', 'Baby Leaders'); //desde donde se envia
                        
                        $mail->addAddress($fila['Email']);
                        
                        $mail->isHTML(true);                                  // Set email format to HTML
                
                        $mail->Subject = $get_contrato['asunto'];
                
                        $mail->Body =  '<FONT SIZE=3>'.nl2br($get_contrato['texto_correo']).'<br><br>
                                                        Ingrese al link:'.$link.'
                                        </FONT SIZE>';
                
                        $mail->CharSet = 'UTF-8';
                        $mail->send();
                
                    } catch (Exception $e) {
                        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                    }

                    if($get_contrato['sms']==1){
                        $altiriaSMS = new AltiriaSMS();
    
                        $altiriaSMS->setDebug(true);
                        $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                        $altiriaSMS->setPassword('gllg2021');
                    
                        $sDestination = '51'.$fila['Celular'];
                        $sMessage = $get_contrato['texto_sms'];
                        $altiriaSMS->sendSMS($sDestination, $sMessage);
                    }
                }
            }
        }
    }
?>