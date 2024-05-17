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

    $list_config = mysqli_query($conexion, "SELECT url_config FROM config 
                    WHERE id_config=3");
    $get_config = mysqli_fetch_assoc($list_config); 
    $url_base = $get_config['url_config'];

    $list_cargo = mysqli_query($conexion, "SELECT ca.id_cargo,ca.cod_cargo,ca.id_usuario_1,
                    uu.usuario_email AS correo_usuario_1,eu.cod_empresa AS cod_empresa_1,
                    ca.desc_cargo AS descripcion,ca.obs_cargo AS observacion
                    FROM cargo ca 
                    LEFT JOIN (SELECT id_cargo,MAX(id_cargo_historial) AS id_historial 
                    FROM cargo_historial 
                    WHERE estado=2 GROUP BY id_cargo) ci ON ca.id_cargo=ci.id_cargo 
                    LEFT JOIN cargo_historial ch ON ci.id_historial=ch.id_cargo_historial 
                    LEFT JOIN users uu ON ca.id_usuario_1=uu.id_usuario
                    LEFT JOIN empresa eu ON ca.id_empresa_1=eu.id_empresa
                    WHERE ch.id_estado IN (45)");

    while ($fila = mysqli_fetch_assoc($list_cargo)) { 
        $id_cargo = $encriptar($fila['id_cargo']);

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
            $mail->setFrom('webcontactos@gllg.edu.pe', "Aprobación de Recepción (Para)"); //desde donde se envia

            $mail->addAddress($fila['correo_usuario_1']);

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = "APROBACIÓN RECEPCIÓN";

            $mail->Body = '<span style="font-size:14px;text-align: justify;"><b>Código Cargo:</b> '.$fila['cod_cargo'].'<br>
                            <b>Empresa:</b> '.$fila['cod_empresa_1'].'<br>
                            <b>Descripción:</b> '.$fila['descripcion'].'<br>
                            <b>Observación:</b> '.$fila['observacion'].'<br></span>
                            <br><br>
                            <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$fila['id_usuario_1'].'/1"><button type="button" target="_blank" class="btn" style="background-color:#e59e28;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido</button></a>
                            <a href="'.$url_base.'index.php?/Snappy/Aprobar_Cargo_Para/'.$id_cargo.'/'.$fila['id_usuario_1'].'/0"><button type="button" class="btn" style="background-color:green;color:white;border: 1px solid transparent;padding: 7px 12px;font-size: 13px;cursor:pointer">Recibido y Confirmado</button></a>';  
                            
            $mail->CharSet = 'UTF-8';
            $mail->send();
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
?>