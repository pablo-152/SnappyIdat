<?php
    //include 'conexion.php';  

    use PHPMailer\PHPMailer\PHPMailer; 
    use PHPMailer\PHPMailer\Exception; 

    require 'PHPMailer/Exception.php'; 
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    /*if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }*/
   
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
        $mail->setFrom('webcontactos@gllg.edu.pe', "Snappy"); //desde donde se envia
        
        $mail->addAddress('daniel11143118@gmail.com');
        
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = "Validar correo personal";

        $mail->Body =  '<FONT SIZE=3>
                            Señorita buenos días le hago llegar el ingreso de la Sem-04-24.<br><br>
                            <table cellpadding="3" cellspacing="0" border="1" style="width:100%;">     
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">Despacho</td>
                                    <td style="text-align:right;">SEM-04-24</td>
                                </tr>
                                <tr>
                                    <td rowspan="2" style="font-weight:bold;">Guía Remisión</td>
                                    <td style="font-weight:bold;">Nuestra</td>
                                    <td style="text-align:right;">T230: 013-014-015-016-017</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;">Transporte.</td>
                                    <td style="text-align:right;">OS02-070909</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td style="text-align:right;">-</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">N° Factura</td>
                                    <td style="text-align:right;">FF02-00007611</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">Paquetes</td>
                                    <td style="text-align:right;">1</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">Sobres</td>
                                    <td style="text-align:right;">-</td>
                                </tr>          
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">Fardos</td>
                                    <td style="text-align:right;">12</td>
                                </tr>           
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">Bultos</td>
                                    <td style="text-align:right;">-</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">Caja</td>
                                    <td style="text-align:right;">4</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="font-weight:bold;">Importe Pagado</td>
                                    <td style="text-align:right;">S/329.00</td>
                                </tr>
                                <tr>
                                    <td rowspan="3" style="font-weight:bold;">Fecha</td>
                                    <td style="font-weight:bold;">Partida</td>
                                    <td style="text-align:right;">26 ENERO DEL 2024</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;">Llegada</td>
                                    <td style="text-align:right;">29 ENERO DEL 2024</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold;">Diferencia.</td>
                                    <td style="text-align:center;">03 Días</td>
                                </tr>
                            </table><br>
                            <span style="font-weight:bold;">Nota:</span><br>
                            <span style="font-weight:bold;">*Pendiente por revisar diferencias</span>

                            <a href="'.base_url().'index.php?/Tracking" 
                            title="Verificar Fardo"
                            target="_blank" 
                            style="background-color: red;
                                    color: white;
                                    border: 1px solid transparent;
                                    padding: 7px 12px;
                                    font-size: 13px;
                                    text-decoration: none !important;
                                    border-radius: 10px;
                                    text-decoration: none; /* Evita subrayado en todos los navegadores */
                                    cursor: pointer; /* Cambia el cursor al pasar sobre el enlace */
                                    outline: none; /* Elimina el contorno al hacer clic en el enlace */
                                    display: inline-block; /* Permite ajustar el tamaño del enlace */
                                    line-height: 1; /* Evita espacios adicionales */
                                    -webkit-tap-highlight-color: transparent; /* Evita resaltado táctil en Safari */
                                    -moz-appearance: none; /* Evita resaltado táctil en Firefox */">
                                Verificar Fardo
                            </a>
                        </FONT SIZE>';
                        

        $mail->CharSet = 'UTF-8';

        $mail->send();
    } catch (Exception $e) {
        echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
    }
?>