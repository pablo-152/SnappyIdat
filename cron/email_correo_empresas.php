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

        $dir = dirname(__DIR__, 2);


        $query_u = mysqli_query($conexion, "SELECT * FROM `correos_empresas` WHERE empresa ='ll' AND  DATE(fecha_envio_por)=".date('Y-m-d').";");
    

                            // echo '<pre>';
                            // print_r($fila['Email']);
                            // echo ' </pre>';
        exit();

        while ($fila = mysqli_fetch_assoc($query_u)) {
                      
            
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
               
                $mail->setFrom('no-reply@gllg.edu.pe', $fila['titulo_mail'] ); //desde donde se envia

                // $mail->addAddress('rosanna.apolaya@gllg.edu.pe');

                $query_correos = mysqli_query($conexion, "SELECT Email FROM todos_ll WHERE YEAR(Fecha_Pago_Matricula)='".$fila['anio']."' AND id_matriculado in (".$fila['id_alumno']."); ");


                while ($data_fila = mysqli_fetch_assoc($query_correos)) {
                    
                        if (filter_var($data_fila['Email'], FILTER_VALIDATE_EMAIL)) {
                            // $mail->addAddress('pupixoxd@gmail.com');
                             $mail->addAddress('pupixoxd@gmail.com');
                             //$mail->addAddress($data_fila['Email']);
                            // echo '<pre>';
                            // print_r($fila['Email']);
                            // echo ' </pre>';
    
                        } 
                }
              
                $query_dos = mysqli_query($conexion, "SELECT * FROM `archivos_correo_ll` WHERE id_correo_empre=".$fila['id_correo_empre']." ;");

                while ($row = mysqli_fetch_assoc($query_dos)) {
                    $nombre_arch =  str_replace("/","'\'", $row['ruta']); 
                    $mail->AddAttachment(  $dir .'/'.$nombre_arch , $row['nombre']);
                }

                $mail->AddEmbeddedImage($dir.'\correo_img\img1.jpg', 'logo_1');                                
                $mail->AddEmbeddedImage($dir.'\correo_img\youtube_logo.png', 'logo_2');                  
                $mail->AddEmbeddedImage($dir.'\correo_img\facebook.png', 'logo_3');                  
                $mail->AddEmbeddedImage($dir.'\correo_img\logo_0.png', 'logo_4');                  

                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $fila['titulo_mail'];
          
                $mail->Body =  '
                                        <!DOCTYPE html>
                                        <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                                            <head>
                                                <meta charset="UTF-8">
                                                <meta name="viewport" content="width=device-width,initial-scale=1">
                                                <meta name="x-apple-disable-message-reformatting">
                                                <title></title>
                                                <style>
                                                    table, td, div, h1, p {font-family: Arial, sans-serif;}
                                                </style>
                                            </head>
                                            <body style="margin:0;padding:0;">
                                                <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
                                                    <tr>
                                                        <td align="center" style="padding:0;">
                                                            <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                                                                <tr>
                                                                    <td align="center" style="padding:40px 0 30px 0;background:#c4ff0e;">
                                                                        <img  src="cid:logo_1" alt="" width="300" style="height: 100px;display:block;border-radius:100%;width: 100px;" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:36px 30px 42px 30px;">
                                                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                                                            <tr>
                                                                                <td style="padding:0 0 36px 0;color:#153643;">
                                                                                    <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">'.$fila['titulo_mail'].'</h1>
                                                                                    <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">'. $fila['text_mail'].'</p>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:30px;background:#ee4c50;">
                                                                        <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                                                                            <tr>
                                                                                <td style="padding:0;width:50%;" align="left">
                                                                                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                                                                        &reg;  Conecta con Little Leaders  Preschool <br/><a href="http://www.example.com" style="color:#ffffff;text-decoration:underline;"></a>
                                                                                    </p>
                                                                                </td>
                                                                                <td style="padding:0;width:50%;" align="right">
                                                                                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                                                                                        <tr>
                                                                                            <td style="padding:0 0 0 10px;width:38px;">
                                                                                                <a href="https://www.facebook.com/littleleadersperu/" style="color:#ffffff;"><img src="cid:logo_3"  alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                                                                                            </td>
                                                                    <td style="padding:0 0 0 10px;width:38px;">
                                                                                                <a href="https://littleleaders.edu.pe/" style="color:#ffffff;"><img src="cid:logo_4"  alt="Web" width="38" style="height:auto;display:block;border:0;" /></a>
                                                                                            </td>
                                                                    <td style="padding:0 0 0 10px;width:38px;">
                                                                                                <a href="https://www.youtube.com/channel/UCFFQ1XiAwKFRSDpUd-U_i3A" style="color:#ffffff;"><img src="cid:logo_2" alt="Youtube" width="38" style="height:auto;display:block;border:0;" /></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </body>
                                        </html>
                            ';
                
                $mail->CharSet = 'UTF-8';
                $mail->send();
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }

        }        
    
?>