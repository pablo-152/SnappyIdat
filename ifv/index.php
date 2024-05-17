<?php
    require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    //require 'autoload.php';

    // Instantiation and passing `true` enables exceptions

    $mail = new PHPMailer(true);

    $nombres=utf8_decode($_POST['sendEmailName']);
    $email=utf8_decode($_POST['sendEmailEmail']);
    $celular=$_POST['sendEmailPhone'];
    $mensaje=utf8_decode($_POST['sendEmailMessage']);

    $nom_empresa="IFV";
    $body="<b>Origen:</b> ".$nom_empresa."<br><b>Nombre:</b> ".$_POST['sendEmailName']."<br><b>Correo Electrónico:</b> ".$_POST['sendEmailEmail']."<br><b>Celular:</b> ".$celular."<br><b>Mensaje:</b> ".$_POST['sendEmailMessage'];


    $query_p=mysqli_query($con, "SELECT * FROM registro_mail WHERE correo='$email' AND id_empresa=6");

    $totalRows_p = mysqli_num_rows($query_p);

    if($totalRows_p!=0){
        $query_b=mysqli_query($con, "INSERT INTO historial_registro_mail (id_registro,observacion,id_accion,fecha_accion,fec_reg,user_reg,estado) 
        VALUES ((SELECT id_registro FROM registro_mail WHERE correo='$email' AND id_empresa=6),'$mensaje',1,DATE_sub(NOW(), INTERVAL 1 HOUR),DATE_sub(NOW(), INTERVAL 1 HOUR),0,14)");
    }else{
        $anio=date('Y');

        $query_t=mysqli_query($con, "SELECT * FROM registro_mail");
        $row_t=mysqli_fetch_array($query_t);
        $totalRows_t = mysqli_num_rows($query_t);
    
        $aniof=substr($anio, 2,2);
    
        if($totalRows_t<9){
            $codigo=$aniof."R000".($totalRows_t+1);
        }
        if($totalRows_t>8 && $totalRows_t<99){
            $codigo=$aniof."R00".($totalRows_t+1);
        }
        if($totalRows_t>98 && $totalRows_t<999){
            $codigo=$aniof."R0".($totalRows_t+1);
        }
        if($totalRows_t>998 ){
            $codigo=$totalRows_t+1;
        }
    
        $cod_registro=$codigo;
    
        $query_b=mysqli_query($con, "INSERT INTO registro_mail (cod_registro,id_informe,fecha_inicial,nombres_apellidos,contacto1,correo,id_empresa,id_sede,mensaje,id_accion,web,fecha_accion,fec_reg,user_reg,estado) 
        values ('$cod_registro',1,DATE_sub(NOW(), INTERVAL 1 HOUR),'$nombres','$celular','$email',6,9,'$mensaje',1,1,DATE_sub(NOW(), INTERVAL 1 HOUR),DATE_sub(NOW(), INTERVAL 1 HOUR),0,14)");

        $query_c=mysqli_query($con, "INSERT INTO historial_registro_mail (id_registro,observacion,id_accion,fecha_accion,fec_reg,user_reg,estado) 
        VALUES ((SELECT id_registro FROM registro_mail WHERE cod_registro='$cod_registro'),'$mensaje',1,DATE_sub(NOW(), INTERVAL 1 HOUR),DATE_sub(NOW(), INTERVAL 1 HOUR),0,14)");
    
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'webcontactos@gllg.edu.pe';                     // usuario de acceso
            $mail->Password   = 'Contactos2021@';                               // SMTP password
            $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('webcontactos@gllg.edu.pe', $_POST['sendEmailName']); //desde donde se envia
            $mail->addAddress('info@ifv.edu.pe');    // a quien se envía
            //$mail->addAddress('fhuertamendez2015@gmail.com'); // Name is optional
            $mail->addReplyTo($email);
    
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Pedido de contacto - '.$_POST['sendEmailName'];
            $mail->Body    = $body;
            $mail->CharSet = 'UTF-8';
            $mail->send();
    
    
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }





        

    
