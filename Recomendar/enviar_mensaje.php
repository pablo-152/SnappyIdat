<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
    $dni_alumno=$_POST['otro_1'];
    $codigo = "";
    $especialidad = "";
    $tipo = "";
    $dni_recomendado=$_POST['dni_re'];
	$celular=$_POST['celu_re'];
    $correo=$_POST['corre_re'];

    $sql1 = mysqli_query($con, "SELECT * FROM matriculados_l14 WHERE Dni='$dni_alumno'");
    $total1 = mysqli_num_rows($sql1);
    $get_id1 = mysqli_fetch_assoc($sql1);

    $sql2 = mysqli_query($con, "SELECT * FROM matriculados_l20 WHERE Dni='$dni_alumno'");
    $total2 = mysqli_num_rows($sql2);
    $get_id2 = mysqli_fetch_assoc($sql2);

    if($total1>0){
        $codigo = $get_id1['Codigo'];
        $especialidad = $get_id1['Especialidad'];
        $nombre = $get_id1['Nombre'];
        $tipo = "l14";
    }

    if($total2>0){
        $codigo = $get_id2['Codigo'];
        $especialidad = $get_id2['Especialidad'];
        $nombre = $get_id2['Nombre'];
        $tipo = "l20";
    }

    $nombre_completo = explode(" ", $nombre);
    $primer_nombre = $nombre_completo[0];

    $query_a = mysqli_query($con, "INSERT INTO recomendados (dni_alumno,codigo,especialidad,tipo,registro,dni_recomendado,celular,correo,estado,fec_reg,user_reg)
                VALUES ('$dni_alumno','$codigo','$especialidad','$tipo',NOW(),'$dni_recomendado','$celular','$correo',2,NOW(),0)");

    //ENVÍO DE SMS Y CORREO
                
    $sql3 = mysqli_query($con, "SELECT * FROM config WHERE id_config=5");
    $total3 = mysqli_num_rows($sql3);
    $get_id3 = mysqli_fetch_assoc($sql3);

	include('httpPHPAltiria.php');

    $altiriaSMS = new AltiriaSMS();

    $altiriaSMS->setDebug(true);
    $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
    $altiriaSMS->setPassword('gllg2021');

    $sDestination = '51'.$celular;
    $sMessage = str_replace('recomendado',$primer_nombre,$get_id3['observaciones']);
    $altiriaSMS->sendSMS($sDestination, $sMessage);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'admision@ifv.edu.pe';                     // usuario de acceso
        $mail->Password   = 'ldej fhvy sqth tmnp';                                // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->setFrom('admision@ifv.edu.pe', "Admisión IFV"); //desde donde se envia

        $mail->addAddress($correo);

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = "Web Recomiendanos";

        $mail->Body = str_replace('recomendado',$primer_nombre,$get_id3['observaciones']);
        $mail->CharSet = 'UTF-8';
        $mail->send();

    } catch (Exception $e) {
        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
    }
?>