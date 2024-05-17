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

    $list_pendientes_web_ifv = mysqli_query($conexion, "SELECT ci.id_comuimg,ci.inicio_comuimg,ci.refe_comuimg,u.usuario_codigo AS creado_por,
    DATE_FORMAT(ci.inicio_comuimg, '%d/%m/%Y') AS inicio,DATE_FORMAT(ci.fin_comuimg, '%d/%m/%Y') AS fin,
    DATE_FORMAT(ci.fec_reg, '%d/%m/%Y') AS fec_reg,s.nom_status,s.color,
    CASE WHEN ci.flag_referencia=0 THEN 'Resultados IFV'
    WHEN ci.flag_referencia=1 THEN 'Triptico' 
    WHEN ci.flag_referencia=3 THEN 'Reglamento Interno' 
    WHEN ci.flag_referencia=2 THEN 'Imagen' 
    ELSE '' END AS tipo,ci.img_comuimg
    FROM comunicaion_img ci
    LEFT JOIN users u on u.id_usuario=ci.user_reg
    LEFT JOIN statusav s on s.id_statusav=ci.estado
    WHERE ci.id_comuimg>0 AND ci.estado=5
    ORDER BY s.nom_status ASC,ci.inicio_comuimg DESC");

    while ($get_pendientes = mysqli_fetch_assoc($list_pendientes_web_ifv)) {
        $fin = date('Y-m-d', strtotime(str_replace('/', '-', $get_pendientes['fin'])));
        $seven_days_before = date('Y-m-d', strtotime('-7 days', strtotime($fin)));
        if (date('Y-m-d') >= $seven_days_before) {
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();    
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'noreplay@ifv.edu.pe';
                $mail->Password   = 'ifvc2022';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
                $mail->setFrom('noreplay@ifv.edu.pe', "Web IFV");
            
                $mail->addAddress('dtecnologia2@ifv.edu.pe');
                $mail->addAddress('dgrafico3@ifv.edu.pe');
                $mail->addAddress('Vanessa.Hilario@ifv.edu.pe');
                $mail->addAddress('Pedro.vieira@ifv.edu.pe');
                $mail->addAddress('Rosanna.Apolaya@ifv.edu.pe'); 
                $mail->isHTML(true);
            
                $mail->Subject = "Pendiente Documento Web IFV";
            
                $mail->Body = '<FONT SIZE=4>¡Hola!<br>
                                Te hacemos acordar que dentro de poco no tienes
                                nada programado para Web IFV + '.$get_pendientes['tipo'].'.<br>
                                Ingresa al sistema y actualiza lo antes posible. <br><br>
                                Saludos. <br>
                                </FONT SIZE>';
                $mail->CharSet = 'UTF-8';
                $mail->send();
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }
?>