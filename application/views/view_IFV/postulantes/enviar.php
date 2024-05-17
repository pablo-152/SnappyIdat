
<?php

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;



require 'PHPMailer/Exception.php';

require 'PHPMailer/PHPMailer.php';

require 'PHPMailer/SMTP.php';



$mail = new PHPMailer(true);



$email_postulante=$email_postulante;
$nombres=$nombres;
$apellido_pat=$apellido_pat;
$apellido_mat=$apellido_mat;
$codigo=$codigo;
$fecha_examen=$fecha_examen;
$fecha_resultados=$fecha_resultados;
$link='http://snappy.org.pe/examen_ifv/index.php?/Examendeadmision/index/'.$codigo;
//$link='http://localhost/examen_ifv/index.php?/Examendeadmision/index/'.$codigo;



try {

    //Server settings

    $mail->SMTPDebug = 0;                      // Enable verbose debug output

    $mail->isSMTP();                                            // Send using SMTP

    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through

    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication

    $mail->Username   = 'admision@ifv.edu.pe';                     // usuario de acceso
    $mail->Password   = 'ifvc2021';                                // SMTP password
    /*$mail->Username   = 'fhuerta@lyfproyectos.com';
    $mail->Password   = 'Fhuerta2021@'; */

    $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged

    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above



    //Recipients

    $mail->setFrom('admision@ifv.edu.pe', "Admisión IFV"); //desde donde se envia

    //$mail->addAddress('info@babyleaders.edu.pe');     // a quien se envía

    //$mail->addAddress('fhuertamendez2015@gmail.com'); 
    //$mail->addAddress('Valerosa0409@gmail.com'); 

    $mail->addAddress($email_postulante);               // Name is optional

    //$mail->addReplyTo('intranet@valerosaperu.com');



    //IMAGEN

    //$mail->addAttachment('/var/tmp/file.tar.gz'); 

    //$mail->addAttachment($ruta,'valerosa.jpg');

    //$url = 'https://valerosaperu.com/test/template/img/logoval.jpg'; //url ejemplo del archivo

    //$fichero = file_get_contents($url); //Aqui guardas el archivo temporalmente.

    // Content

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = "EXAMEN DE ADMISIÓN ".$fecha_examen;



    $mail->Body = '<FONT SIZE=4>¡Hola Estimado postulante!<br>
                    Llegó el gran día para que puedas rendir el EXAMEN DE ADMISIÓN. <br><br>
                    
                    <b>Por ello es importante que sepas las condiciones del examen: </b><br><br>
                    
                    - El examen queda activo solo hasta las 8pm del dia de hoy. Después de esa hora ya no puedes ingresar y hacer el examen.<br>
                    - Sólo se considerará el examen y la puntuación del primer envío registrado.<br>
                    - Después de  activar el link del examen sólo puede aplicarse una sola vez, por lo que un segundo intento quedará invalidado.<br>
                    - Asegúrate que el dispositivo en el cual realices el examen se encuentra cargado y con disponibilidad de internet para evitar que se cuelgue o se pierda la información.<br>
                    - El puntaje mínimo para calificar es de 164.<br>
                    - Los resultados serán publicados a través de nuestra web institucional <a href="http://www.ifv.edu.pe/admision/">http://www.ifv.edu.pe/admision/</a> en el icono “ResultadosAdmisión” el '.$fecha_resultados.'.<br><br>
                    
                    - Lee atentamente las instrucciones.<br><br>

                    <b>Instrucciones para el óptimo desarrollo del examen: </b><br>
                    - El examen de admisión es único para todos los postulantes y consiste en una prueba de aptitud académica y de conocimientos.<br>
                    - Durante el examen, lea con cuidado cada pregunta. Si lee apresuradamente, puede obviar información y equivocarse.<br>
                    - Todas las preguntas otorgan el mismo puntaje: 4 puntos.<br>
                    - El examen de admisión está integrado por 80 Preguntas, que evalúan 4 componentes: <br>
                            Razonamiento Matemático, Razonamiento Verbal, Ciencias y Ambiente y Cultura General.<br>
                    - Las preguntas del 1 al 20 están referidas a Razonamiento Matemático, del 21 al 40 a Razonamiento Verbal,  del 41 al 60 a Ciencia y Ambiente y del 61 al 80 a Cultura General.<br>
                    - El tiempo máximo para responder el examen es de 120 minutos, una vez iniciado/activado el link. Despues de eso no puede continuar a hacer su examen y queda invalido.<br>
                    - Es recomendable marcar cada respuesta, al momento mismo de conocerla.<br><br>
                    <b>¡Vamos inicia tu examen haciendo click Aquí !:</b><br>
                    '.$link.'<br><br>
                    ¡¡ EXITOS EN TU EXAMEN !!</FONT SIZE>';
    $mail->CharSet = 'UTF-8';

    $mail->send();

} catch (Exception $e) {
  echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
}

//view('contactanos.html');   



        

    

