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

    $query_w = mysqli_query($conexion, "SELECT ci.*,ca.url FROM comunicaion_img ci
                LEFT JOIN carrera ca ON ca.id_carrera=ci.cod_referencia AND ca.estado=2
                WHERE ci.fin_comuimg<=CURDATE() AND ci.estado=1");

    while($fila = mysqli_fetch_assoc($query_w)){
        $update = mysqli_query($conexion, "UPDATE comunicaion_img SET estado=2 
                    WHERE id_comuimg=".$fila['id_comuimg']."");

        if($fila['flag_referencia']==0){
            $nombre = "Resultados IFV";
            array_map('unlink', glob('./resultadoifv/resultados.pdf'));
        }elseif($fila['flag_referencia']==1){
            $nombre = "Triptico de ".$fila['refe_comuimg'];
            array_map('unlink', glob('./triptico/'.$fila['url'].'.pdf'));
        }elseif($fila['flag_referencia']==2){
            $nombre = "Imagen Web";
            array_map('unlink', glob('./imagenWeb/web.jpg'));
        }elseif($fila['flag_referencia']==3){
            $nombre = "Reglamento Interno";
            array_map('unlink', glob('./reglamento/reglamento.pdf'));
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
            $mail->setFrom('noreply@snappy.org.pe', 'Caducidad Web IFV'); //desde donde se envia
            
            $mail->addAddress('dtecnologia@gllg.edu.pe');
            
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Link Caducado '.$nombre;

            $mail->Body =  '<FONT SIZE=3>
                                ¡Hola!<br>
                                Te informamos que a la fecha no tienes ningún documento activo en '.$nombre.'.<br>
                            </FONT SIZE>';

            $mail->CharSet = 'UTF-8';
            $mail->send();

        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    } 

    $query_a = mysqli_query($conexion, "SELECT ci.*,ca.url FROM comunicaion_img ci
                LEFT JOIN carrera ca ON ca.id_carrera=ci.cod_referencia AND ca.estado=2
                WHERE ci.estado=1 AND CURDATE() BETWEEN ci.inicio_comuimg AND ci.fin_comuimg");

    while($fila = mysqli_fetch_assoc($query_a)){
        $ruta1 = "../".$fila['img_comuimg'];

        if($fila['flag_referencia']==1){
            $query_c = mysqli_query($conexion, "SELECT * FROM carrera 
                            WHERE id_carrera=".$fila['cod_referencia']."");
            $get_carrera = mysqli_fetch_assoc($query_c); 
            $ruta2 = "../triptico/".$get_carrera['url'].".pdf";
            array_map('unlink', glob('./triptico/'.$get_carrera['url'].'.pdf'));
        }elseif($fila['flag_referencia']==0){
            $ruta2 = "../resultadoifv/resultados.pdf";
            array_map('unlink', glob('./resultadoifv/resultados.pdf'));
        }elseif($fila['flag_referencia']==2){
            $ruta2 = "../imagenWeb/web.jpg";
            array_map('unlink', glob('./imagenWeb/web.jpg'));
        }elseif($fila['flag_referencia']==3){
            $ruta2 = "../reglamento/reglamento.pdf";
            array_map('unlink', glob('./reglamento/reglamento.pdf'));
        }
        copy($ruta1,$ruta2);
    }
?>