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

    $query_c = mysqli_query($conexion, "SELECT cc.*,tc.fecha_envio AS v_fecha_envio 
                FROM c_contrato cc
                LEFT JOIN tipo_contrato tc ON tc.id_tipo=cc.tipo
                WHERE cc.id_empresa=6 AND tc.alumno=1 AND cc.estado=2");

    while($get_contrato = mysqli_fetch_assoc($query_c)){
        if($get_contrato['enviar']==1){
            $array = explode(",",$get_contrato['alumnos']);
            
            if($get_contrato['v_fecha_envio']==1){
                if($get_contrato['fecha_envio']==date('Y-m-d')){ 
                    $i = 0;

                    while($i<count($array)){
                        $query_alumno = mysqli_query($conexion, "SELECT Id AS Id_Alumno,Codigo AS cod_alumno,Apellido_Paterno AS apater_alumno,
                                        Apellido_Materno AS amater_alumno,Nombre AS nom_alumno,Email AS email_alumno,
                                        Celular AS celular_alumno,Grupo AS grupo_alumno,
                                        Especialidad AS especialidad_alumno,Turno AS turno_alumno 
                                        FROM nuevos_fv 
                                        WHERE Id=".$array[$i]."");
                         $get_alumno = mysqli_fetch_assoc($query_alumno);

                        $query_d = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma 
                                    WHERE id_alumno=".$get_alumno['Id_Alumno']." AND cod_alumno='".$get_alumno['cod_alumno']."' AND id_empresa=6 AND 
                                    enviado=1 AND id_contrato=".$get_contrato['id_c_contrato']." AND estado=2");
                        $total = mysqli_num_rows($query_d); 
        
                        if($total==0){
                            $insert_documento_firma = mysqli_query($conexion, "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                                                        nom_alumno,email_alumno,celular_alumno,grupo_alumno,especialidad_alumno,turno_alumno,id_empresa,
                                                        enviado,fecha_envio,id_contrato,estado_d,estado,fec_reg,user_reg)
                                                        VALUES ('".$get_alumno['Id_Alumno']."','".$get_alumno['cod_alumno']."','".$get_alumno['apater_alumno']."','".$get_alumno['amater_alumno']."',
                                                        '".$get_alumno['nom_alumno']."','".$get_alumno['email_alumno']."','".$get_alumno['celular_alumno']."','".$get_alumno['grupo_alumno']."',
                                                        '".$get_alumno['especialidad_alumno']."','".$get_alumno['turno_alumno']."',6,1,NOW(),
                                                        '".$get_contrato['id_c_contrato']."',2,2,NOW(),0)");
        
                            $query_documento_firma = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma
                                                    ORDER BY id_documento_firma DESC
                                                    LIMIT 1");
                            $get_documento_firma = mysqli_fetch_assoc($query_documento_firma);
    
                            $encryption_id = $encriptar($get_documento_firma['id_documento_firma']);
    
                            $mail = new PHPMailer(true); 
                            $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_fv/".$encryption_id;
                            
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
                                
                                $mail->addAddress($get_alumno['email_alumno']);
                                
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
                            
                                $sDestination = '51'.$get_alumno['celular_alumno'];
                                $sMessage = $get_contrato['texto_sms'];
                                $altiriaSMS->sendSMS($sDestination, $sMessage);
                            }
                        }

                        $i++;
                    }
                }
            }else{
                $i = 0;

                while($i<count($array)){
                    $query_alumno = mysqli_query($conexion, "SELECT Id AS Id_Alumno,Codigo AS cod_alumno,Apellido_Paterno AS apater_alumno,
                                    Apellido_Materno AS amater_alumno,Nombre AS nom_alumno,Email AS email_alumno,
                                    Celular AS celular_alumno,Grupo AS grupo_alumno,
                                    Especialidad AS especialidad_alumno,Turno AS turno_alumno 
                                    FROM nuevos_fv 
                                    WHERE Id=".$array[$i]."");
                     $get_alumno = mysqli_fetch_assoc($query_alumno);

                    $query_d = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma 
                                WHERE id_alumno=".$get_alumno['Id_Alumno']." AND cod_alumno='".$get_alumno['cod_alumno']."' AND id_empresa=6 AND 
                                enviado=1 AND id_contrato=".$get_contrato['id_c_contrato']." AND estado=2");
                    $total = mysqli_num_rows($query_d);
    
                    if($total==0){
                        $insert_documento_firma = mysqli_query($conexion, "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                                                    nom_alumno,email_alumno,celular_alumno,grupo_alumno,especialidad_alumno,turno_alumno,id_empresa,
                                                    enviado,fecha_envio,id_contrato,estado_d,estado,fec_reg,user_reg)
                                                    VALUES ('".$get_alumno['Id_Alumno']."','".$get_alumno['cod_alumno']."','".$get_alumno['apater_alumno']."','".$get_alumno['amater_alumno']."',
                                                    '".$get_alumno['nom_alumno']."','".$get_alumno['email_alumno']."','".$get_alumno['celular_alumno']."','".$get_alumno['grupo_alumno']."',
                                                    '".$get_alumno['especialidad_alumno']."','".$get_alumno['turno_alumno']."',6,1,NOW(),
                                                    '".$get_contrato['id_c_contrato']."',2,2,NOW(),0)");
    
                        $query_documento_firma = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma
                                                ORDER BY id_documento_firma DESC
                                                LIMIT 1");
                        $get_documento_firma = mysqli_fetch_assoc($query_documento_firma);

                        $encryption_id = $encriptar($get_documento_firma['id_documento_firma']);

                        $mail = new PHPMailer(true); 
                        $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_fv/".$encryption_id;
                        
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'admision@ifv.edu.pe';                     // usuario de acceso
                            $mail->Password   = 'qkbotbqtcqsywpwx';                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('noreply@snappy.org.pe', 'Instituto Federico Villarreal'); //desde donde se envia
                            
                            $mail->addAddress($get_alumno['email_alumno']);
                            
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
                        
                            $sDestination = '51'.$get_alumno['celular_alumno'];
                            $sMessage = $get_contrato['texto_sms'];
                            $altiriaSMS->sendSMS($sDestination, $sMessage);
                        }
                    }

                    $i++;
                }
            }
        }else{
            $parte_grupo = "";
            $parte_especialidad = "";
            $parte_turno = "";
            if($get_contrato['id_grupo']!="0"){
                $parte_grupo = "AND Grupo='".$get_contrato['id_grupo']."'";
            }
            if($get_contrato['id_especialidad']!="0"){
                $parte_especialidad = "AND Especialidad='".$get_contrato['id_especialidad']."'";
            }
            if($get_contrato['id_turno']!="0"){
                $parte_turno = "AND Turno='".$get_contrato['id_turno']."'";
            }
            $query_a = mysqli_query($conexion, "SELECT Id AS Id_Alumno,Codigo AS cod_alumno,Apellido_Paterno AS apater_alumno,
                        Apellido_Materno AS amater_alumno,Nombre AS nom_alumno,Email AS email_alumno,Celular AS celular_alumno,
                        Grupo AS grupo_alumno,Especialidad AS especialidad_alumno,Turno AS turno_alumno
                        FROM nuevos_fv
                        WHERE TIMESTAMPDIFF(YEAR, Fecha_Cumpleanos, CURDATE())>=18 $parte_grupo $parte_especialidad $parte_turno");
    
            if($get_contrato['v_fecha_envio']==1){
                if($get_contrato['fecha_envio']==date('Y-m-d')){ 
                    while ($fila = mysqli_fetch_assoc($query_a)) { 
                        $query_d = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma 
                                    WHERE id_alumno=".$fila['Id_Alumno']." AND cod_alumno='".$fila['cod_alumno']."' AND id_empresa=6 AND 
                                    enviado=1 AND id_contrato=".$get_contrato['id_c_contrato']." AND estado=2");
                        $total = mysqli_num_rows($query_d);
        
                        if($total==0){
                            $insert_documento_firma = mysqli_query($conexion, "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                                                        nom_alumno,email_alumno,celular_alumno,grupo_alumno,especialidad_alumno,turno_alumno,id_empresa,
                                                        enviado,fecha_envio,id_contrato,estado_d,estado,fec_reg,user_reg)
                                                        VALUES ('".$fila['Id_Alumno']."','".$fila['cod_alumno']."','".$fila['apater_alumno']."','".$fila['amater_alumno']."',
                                                        '".$fila['nom_alumno']."','".$fila['email_alumno']."','".$fila['celular_alumno']."','".$fila['grupo_alumno']."',
                                                        '".$fila['especialidad_alumno']."','".$fila['turno_alumno']."',6,1,NOW(),
                                                        '".$get_contrato['id_c_contrato']."',2,2,NOW(),0)");
        
                            $query_documento_firma = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma
                                                    ORDER BY id_documento_firma DESC
                                                    LIMIT 1");
                            $get_documento_firma = mysqli_fetch_assoc($query_documento_firma);
    
                            $encryption_id = $encriptar($get_documento_firma['id_documento_firma']);
    
                            $mail = new PHPMailer(true); 
                            $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_fv/".$encryption_id;
                            
                            try {
                                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                                $mail->isSMTP();                                            // Send using SMTP
                                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                                $mail->Username   = 'admision@ifv.edu.pe';                     // usuario de acceso
                                $mail->Password   = 'qkbotbqtcqsywpwx';                                // SMTP password
                                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                                $mail->setFrom('noreply@snappy.org.pe', 'Instituto Federico Villarreal'); //desde donde se envia
                                
                                $mail->addAddress($fila['email_alumno']);
                                
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
                            
                                $sDestination = '51'.$fila['celular_alumno'];
                                $sMessage = $get_contrato['texto_sms'];
                                $altiriaSMS->sendSMS($sDestination, $sMessage);
                            }
                        }
                    }
                }
            }else{
                while ($fila = mysqli_fetch_assoc($query_a)) { 
                    $query_d = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma 
                                WHERE id_alumno=".$fila['Id_Alumno']." AND cod_alumno='".$fila['cod_alumno']."' AND id_empresa=6 AND 
                                enviado=1 AND id_contrato=".$get_contrato['id_c_contrato']." AND estado=2");
                    $total = mysqli_num_rows($query_d);
    
                    if($total==0){
                        $insert_documento_firma = mysqli_query($conexion, "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,
                                                    nom_alumno,email_alumno,celular_alumno,grupo_alumno,especialidad_alumno,turno_alumno,id_empresa,
                                                    enviado,fecha_envio,id_contrato,estado_d,estado,fec_reg,user_reg)
                                                    VALUES ('".$fila['Id_Alumno']."','".$fila['cod_alumno']."','".$fila['apater_alumno']."','".$fila['amater_alumno']."',
                                                    '".$fila['nom_alumno']."','".$fila['email_alumno']."','".$fila['celular_alumno']."','".$fila['grupo_alumno']."',
                                                    '".$fila['especialidad_alumno']."','".$fila['turno_alumno']."',6,1,NOW(),
                                                    '".$get_contrato['id_c_contrato']."',2,2,NOW(),0)");
    
                        $query_documento_firma = mysqli_query($conexion, "SELECT id_documento_firma FROM documento_firma
                                                ORDER BY id_documento_firma DESC
                                                LIMIT 1");
                        $get_documento_firma = mysqli_fetch_assoc($query_documento_firma);

                        $encryption_id = $encriptar($get_documento_firma['id_documento_firma']);

                        $mail = new PHPMailer(true); 
                        $link = "https://snappy.org.pe/"."Pagina/index.php?Pagina/index_fv/".$encryption_id;
                        
                        try {
                            $mail->SMTPDebug = 0;                      // Enable verbose debug output
                            $mail->isSMTP();                                            // Send using SMTP
                            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                            $mail->Username   = 'admision@ifv.edu.pe';                     // usuario de acceso
                            $mail->Password   = 'qkbotbqtcqsywpwx';                                // SMTP password
                            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                            $mail->setFrom('noreply@snappy.org.pe', 'Instituto Federico Villarreal'); //desde donde se envia
                            
                            $mail->addAddress($fila['email_alumno']);
                            
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
                        
                            $sDestination = '51'.$fila['celular_alumno'];
                            $sMessage = $get_contrato['texto_sms'];
                            $altiriaSMS->sendSMS($sDestination, $sMessage);
                        }
                    }
                }
            }
        }
    }
?>