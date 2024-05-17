<?php 
    include 'conexion.php';
    include 'conexion_arpay.php';
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

    mysqli_query($conexion, "TRUNCATE TABLE nuevos_ll");
    mysqli_query($conexion, "TRUNCATE TABLE apoderados_ll");

    $anio = date('Y');
    $anio_siguiente = date('Y')+1;
    $list_nuevos_ll = sqlsrv_query($conexion_arpay, "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,
                        per.FirstName AS Nombre,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) END AS Codigo,
                        per.IdentityCardNumber AS Dni,FORMAT(per.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,Grado=ISNULL(cgt.Description, ''),
                        CASE WHEN cc.Name IS NULL THEN '' WHEN mat.StatusId IN (2,3,4,6,7) THEN '' ELSE cc.Name END AS Seccion,
                        (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp
                        WHERE cp.ClientId=cli.Id AND cp.Description='Matricula' AND cp.PaymentStatusId NOT IN (3)
                        ORDER BY cp.Id DESC) AS Fecha_Pago_Matricula,
                        (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp
                        WHERE cp.ClientId=cli.Id AND cp.Description='Cuota de Ingreso' AND cp.PaymentStatusId NOT IN (3)
                        ORDER BY cp.Id DESC) AS Fecha_Pago_Cuota_Ingreso,Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D')
                        FROM Client cli
                        JOIN Person per ON per.Id = cli.PersonId  
                        LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
                        WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                        LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
                        LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                        LEFT JOIN Course c ON c.Id = pi.CourseId  
                        LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
                        LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                        WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
                        ORDER BY ccs2.Id DESC)  
                        LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                        LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                        WHERE cli.EnterpriseHeadquarterId = 7 AND cli.InternalStudentId IS NOT NULL AND YEAR(mat.StartDate) IN ($anio,$anio_siguiente) AND 
                        sst.Description='Matriculado'
                        ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId");

    while($fila_alumno = sqlsrv_fetch_array($list_nuevos_ll)){
        mysqli_query($conexion, "INSERT INTO nuevos_ll (Id,Codigo,Apellido_Paterno,Apellido_Materno,Nombre,Dni,
        Fecha_Cumpleanos,Grado,Seccion,Fecha_Matricula,Fecha_Cuota,Anio) 
        VALUES ('".$fila_alumno['Id']."','".$fila_alumno['Codigo']."','".$fila_alumno['Apellido_Paterno']."',
        '".$fila_alumno['Apellido_Materno']."','".$fila_alumno['Nombre']."','".$fila_alumno['Dni']."',
        '".$fila_alumno['Fecha_Cumpleanos']."','".$fila_alumno['Grado']."','".$fila_alumno['Seccion']."',
        '".$fila_alumno['Fecha_Matricula']."','".$fila_alumno['Fecha_Cuota']."','".$fila_alumno['Anio']."')"); 
    }

    $get_Ids_nuevos_ll = mysqli_query($conexion, "SELECT GROUP_CONCAT(DISTINCT Id SEPARATOR ',') AS ids FROM nuevos_ll");
    $get_id = mysqli_fetch_assoc($get_Ids_nuevos_ll); 

    $list_apoderados_ll = sqlsrv_query($conexion_arpay, "SELECT gu.Id,gu.StudentClientId AS Id_Alumno,pe.FatherSurname AS Apellido_Paterno,
                            pe.MotherSurname AS Apellido_Materno,pe.FirstName AS Nombre,pe.IdentityCardNumber AS Dni,pe.Email,pe.MobilePhone AS Celular,
                            FORMAT(pe.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,gt.Description AS Parentesco
                            FROM Guardian gu
                            LEFT JOIN Person pe ON pe.Id=PersonId
                            LEFT JOIN GuardianTypeTranslation gt ON gt.GuardianTypeId=gu.Kinship AND gt.Language='es-PE'
                            WHERE gu.StudentClientId IN (".$get_id['ids'].")");

    while($fila_apoderado = sqlsrv_fetch_array($list_apoderados_ll)){
        mysqli_query($conexion, "INSERT INTO apoderados_ll (Id,Id_Alumno,Apellido_Paterno,Apellido_Materno,Nombre,Dni,Email,Celular,
                    Fecha_Cumpleanos,Parentesco) 
                    VALUES ('".$fila_apoderado['Id']."','".$fila_apoderado['Id_Alumno']."','".$fila_apoderado['Apellido_Paterno']."',
                    '".$fila_apoderado['Apellido_Materno']."','".$fila_apoderado['Nombre']."','".$fila_apoderado['Dni']."','".$fila_apoderado['Email']."',
                    '".$fila_apoderado['Celular']."','".$fila_apoderado['Fecha_Cumpleanos']."','".$fila_apoderado['Parentesco']."')"); 
    }

    $query_c = mysqli_query($conexion, "SELECT id_c_contrato,asunto,texto_correo,sms,texto_sms
                FROM c_contrato 
                WHERE id_empresa=2 AND (tipo IN (1,2,3,4) OR (tipo=5 AND fecha_envio=CURDATE())) AND 
                estado=2");

    while($get_contrato = mysqli_fetch_assoc($query_c)){
        $list_alumno = mysqli_query($conexion, "CALL datos_alumno_contrato (".$fila['id_c_contrato'].",2)");
        mysqli_next_result($conexion);

        while($fila = mysqli_fetch_assoc($list_alumno)){
            if($get_contrato['id_c_contrato']==17){
                if($fila['grado_alumno']!="2 Años"){
                    $query_v = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma 
                                WHERE id_alumno='".$fila['Id_Alumno']."' AND id_apoderado='".$fila['Id']."' AND id_empresa=2 AND enviado=1 AND 
                                id_contrato='".$get_contrato['id_c_contrato']."' AND estado=2");
                    $total = mysqli_num_rows($query_v);

                    if($total==0){
                        mysqli_query($conexion, "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                        nom_alumno,cumpleanos_alumno,dni_alumno,grado_alumno,seccion_alumno,id_apoderado,apater_apoderado,
                        amater_apoderado,nom_apoderado,parentesco_apoderado,email_apoderado,celular_apoderado,cumpleanos_apoderado,
                        dni_apoderado,id_empresa,enviado,fecha_envio,id_contrato,estado_d,estado,fec_reg,user_reg)
                        VALUES ('".$fila['Id_Alumno']."','".$fila['cod_alumno']."','".$fila['apater_alumno']."','".$fila['amater_alumno']."',
                        '".$fila['nom_alumno']."','".$fila['cumpleanos_alumno']."','".$fila['dni_alumno']."','".$fila['grado_alumno']."',
                        '".$fila['seccion_alumno']."','".$fila['Id']."','".$fila['Apellido_Paterno']."','".$fila['Apellido_Materno']."',
                        '".$fila['Nombre']."','".$fila['Parentesco']."','".$fila['Email']."','".$fila['Celular']."',
                        '".$fila['cumpleanos_apoderado']."','".$fila['dni_apoderado']."',2,1,NOW(),
                        '".$get_contrato['id_c_contrato']."',2,2,NOW(),0)");

                        $query_documento_firma = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma
                                                ORDER BY id_documento_firma DESC
                                                LIMIT 1");
                        $get_documento_firma = mysqli_fetch_assoc($query_documento_firma); 

                        $encryption_id = $encriptar($get_documento_firma['id_documento_firma']);

                        $mail = new PHPMailer(true);
                        $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_ll/".$encryption_id;
                        
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'admision@littleleaders.edu.pe';                     // usuario de acceso
                            $mail->Password   = 'xpmcvlmggnolcxjr';                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('noreply@snappy.org.pe', 'Little Leaders'); //desde donde se envia
                            
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
            }else{
                $query_v = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma 
                            WHERE id_alumno='".$fila['Id_Alumno']."' AND id_apoderado='".$fila['Id']."' AND id_empresa=2 AND enviado=1 AND 
                            id_contrato='".$get_contrato['id_c_contrato']."' AND estado=2");
                $total = mysqli_num_rows($query_v);

                if($total==0){
                    mysqli_query($conexion, "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                    nom_alumno,cumpleanos_alumno,dni_alumno,grado_alumno,seccion_alumno,id_apoderado,apater_apoderado,
                    amater_apoderado,nom_apoderado,parentesco_apoderado,email_apoderado,celular_apoderado,cumpleanos_apoderado,
                    dni_apoderado,id_empresa,enviado,fecha_envio,id_contrato,estado_d,estado,fec_reg,user_reg)
                    VALUES ('".$fila['Id_Alumno']."','".$fila['cod_alumno']."','".$fila['apater_alumno']."','".$fila['amater_alumno']."',
                    '".$fila['nom_alumno']."','".$fila['cumpleanos_alumno']."','".$fila['dni_alumno']."','".$fila['grado_alumno']."',
                    '".$fila['seccion_alumno']."','".$fila['Id']."','".$fila['Apellido_Paterno']."','".$fila['Apellido_Materno']."',
                    '".$fila['Nombre']."','".$fila['Parentesco']."','".$fila['Email']."','".$fila['Celular']."',
                    '".$fila['cumpleanos_apoderado']."','".$fila['dni_apoderado']."',2,1,NOW(),
                    '".$get_contrato['id_c_contrato']."',2,2,NOW(),0)");

                    $query_documento_firma = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma
                                            ORDER BY id_documento_firma DESC
                                            LIMIT 1");
                    $get_documento_firma = mysqli_fetch_assoc($query_documento_firma); 

                    $encryption_id = $encriptar($get_documento_firma['id_documento_firma']);

                    $mail = new PHPMailer(true);
                    $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_ll/".$encryption_id;
                    
                    try {
                        $mail->SMTPDebug = 0;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'admision@littleleaders.edu.pe';                     // usuario de acceso
                        $mail->Password   = 'xpmcvlmggnolcxjr';                                // SMTP password
                        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                        $mail->setFrom('noreply@snappy.org.pe', 'Little Leaders'); //desde donde se envia
                        
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