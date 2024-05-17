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

    $list_fotocheck_terminado = mysqli_query($conexion, "SELECT fo.id_fotocheck,td.Email,td.Celular 
                                FROM fotocheck fo
                                LEFT JOIN todos_l20 td ON fo.Id=td.Id
                                WHERE fo.esta_fotocheck=2 AND fo.enviado=0 AND td.Alumno='Matriculado'");                          

    while ($fila = mysqli_fetch_assoc($list_fotocheck_terminado)) { 
        $mail = new PHPMailer(true);
    
        try {
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'noreply@snappy.org.pe';                     // usuario de acceso
            $mail->Password   = 'gllg2023@';                                // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->setFrom('noreply@snappy.org.pe', "SNAPPY"); //desde donde se envia
    
            $mail->addAddress($fila['Email']);
    
            $mail->isHTML(true);                                  // Set email format to HTML
    
            $mail->Subject = "Fotocheck listo";
        
            $mail->Body = '<FONT SIZE=3>
                                ¡Hola!<br><br>
                                Tu fotocheck esta listo y en camino a IFV.<br><br>
                                Contacta a nuestro personal para que lo puedas recoger.<br><br>
                                Instituto Federico Villarreal<br>
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }

        if($fila['Celular']!='' && $fila['Celular']!==NULL){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.altiria.net:8443/api/http',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'cmd=sendsms&login=vanessa.hilario%40gllg.edu.pe&passwd=gllg2021&dest=51'.$fila['Celular'].'&msg=¡Hola!%0ATu%20fotocheck%20esta%20listo%20y%20en%20camino%20a%20IFV.%0AContacta%20a%20nuestro%20personal%20para%20que%20lo%20puedas%20recoger.%0AInstituto%20Federico%20Villarreal&concat=true',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded;charset=utf-8'
                ),
            ));
            
            $response = curl_exec($curl);

            curl_close($curl);
        }

        mysqli_query($conexion, "UPDATE fotocheck SET enviado=1 
        WHERE id_fotocheck=".$fila['id_fotocheck']);
    }
?>