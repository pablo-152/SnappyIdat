<?php
    include 'conexion.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/Exception.php'; 
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require_once ('tcpdf/tcpdf.php');

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $query_a = mysqli_query($conexion, "UPDATE evento SET id_estadoe=1 WHERE fec_ini=CURDATE() AND estado=2");

    $query_f = mysqli_query($conexion, "UPDATE evento SET id_estadoe=2 WHERE fec_fin<=CURDATE() AND estado=2");

    /*$query_c = mysqli_query($conexion, "SELECT * FROM evento WHERE DATE_SUB(fec_agenda,interval 14 day)=CURDATE() || 
    DATE_SUB(fec_agenda,interval 7 day)=CURDATE() || DATE_SUB(fec_agenda,interval 1 day)=CURDATE() || fec_agenda=CURDATE() || 
    DATE_ADD(fec_agenda,interval 7 day)=CURDATE()");*/

    $query_c = mysqli_query($conexion, "SELECT * FROM evento WHERE id_estadoe=1 AND DATE_SUB(fec_agenda,interval 14 day)=CURDATE() || 
    DATE_SUB(fec_agenda,interval 7 day)=CURDATE() || DATE_SUB(fec_agenda,interval 1 day)=CURDATE() || fec_agenda=CURDATE()");

    while ($fila = mysqli_fetch_assoc($query_c)) {
        //CREAR EL PDF
        $query_e = mysqli_query($conexion, "SELECT en.imagen,ev.cod_evento,ev.nom_evento,ee.nom_estadoe,DATE_FORMAT(ev.fec_agenda,'%d/%m/%Y') as fecha_agenda,
        en.cod_empresa,se.cod_sede,DATE_FORMAT(ev.fec_ini,'%d/%m/%Y') as fecha_ini,DATE_FORMAT(ev.fec_fin,'%d/%m/%Y') as fecha_fin,us.usuario_codigo,
        CASE WHEN ev.tipo_link=3 THEN CONCAT('https://snappy.org.pe/',en.cod_empresa,'0')
        WHEN ev.tipo_link>0 THEN CONCAT('https://snappy.org.pe/',en.cod_empresa,ev.tipo_link) ELSE '' END 
        AS link,ev.autorizaciones,ev.obs_evento,
        DATE_FORMAT(ev.fec_agenda,'%d-%m-%Y') as fecha_agenda_operativa,ev.id_evento,ev.fec_agenda
        FROM evento ev
        LEFT JOIN empresa en ON en.id_empresa=ev.id_empresa
        LEFT JOIN sede se ON se.id_sede=ev.id_sede
        LEFT JOIN estadoe ee ON ee.id_estadoe=ev.id_estadoe
        LEFT JOIN users us ON us.id_usuario=ev.user_reg
        WHERE ev.id_evento=".$fila['id_evento']."");
        $get_id = mysqli_fetch_assoc($query_e);

        $query_u = mysqli_query($conexion, "SELECT * FROM users WHERE estado=2");
        $totalRows_u = mysqli_num_rows($query_u);

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Erick Daniel Palomino Mamani');
        $pdf->SetTitle('Informe Evento');
        $pdf->SetSubject('Informe Evento');
        $pdf->SetKeywords('Informe, Evento, Registrados, Contactados, Asisten');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica','',18);

        // add a page
        $pdf->AddPage();

        $y2=25;

        $pdf->SetFillColor(255,255,255);

        $pdf->SetFillColor(196,37,129);
        $pdf->SetXY (0,$y2);
        $pdf->MultiCell (210,20,'',0,'L',1,0,'','',true,0,false,true,10,'M');

        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (20,$y2+3);
        $pdf->MultiCell (60,14,'Informe de Eventos',0,'L',1,0,'','',true,0,false,true,14,'M');
        $pdf->Image($get_id['imagen'],176,28,14,14,'', '', '', true, 150, '', false, false, 0);

        $pdf->SetLineStyle(array('width'=>0.6,'cap'=>'butt','join'=>'miter','dash'=> 0,'color'=>array(0, 0, 0)));
        $pdf->Line(15,$y2+35,195,$y2+35,'');

        $pdf->SetFont('helvetica','B',10);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY (15,$y2+40);
        $pdf->MultiCell (14,8,'Ref.:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (30,8,$get_id['cod_evento'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Evento:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (85,8,$get_id['nom_evento'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Estado:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id['nom_estadoe'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+50);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (14,8,'Fecha:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (30,8,$get_id['fecha_agenda'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (19,8,'Empresa:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (14,8,$get_id['cod_empresa'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (12,8,'Sede:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (14,8,$get_id['cod_sede'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (20,8,'Activo de:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id['fecha_ini'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (15,8,'Hasta:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id['fecha_fin'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+60);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (23,8,'Creado Por:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (21,8,$get_id['usuario_codigo'],0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (11,8,'Link:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (125,8,$get_id['link'],0,'L',1,0,'','',true,0,false,true,8,'M');

        $usuario_informe="";
        if($get_id['autorizaciones']!=""){
            $array=explode(",",$get_id['autorizaciones']);
            $contador=0;
            $cadena="";
            while($contador<count($array)){
                $contador2=0;

                while($contador2<$totalRows_u){
                    mysqli_data_seek($query_u,$contador2);
                    $list_usuario = mysqli_fetch_assoc($query_u);
        
                    if($list_usuario['id_usuario']==$array[$contador]){
                        $cadena=$cadena.$list_usuario['usuario_codigo'].",";
                    }

                    $contador2++;
                }
                $contador++;
            }
            $usuario_informe=substr($cadena,0,-1);
        }

        $pdf->SetXY (15,$y2+70);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (31,8,'Usuario Informe:',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (149,8,$usuario_informe,0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->Line(15,$y2+83,195,$y2+83,'');

        $pdf->SetXY (15,$y2+88);
        $pdf->SetFont('helvetica','B',10);
        $pdf->MultiCell (31,8,'Observaciones:',0,'L',1,0,'','',true,0,false,true,8,'M');

        $pdf->SetXY (15,$y2+96);
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (180,50,$get_id['obs_evento'],0,'L',1,0,'','',true,0,false,true,50,'T');

        //TABLA
        $fecha = $get_id['fecha_agenda_operativa'];
        $fecha_evento = $get_id['fecha_agenda'];
        $fecha_consulta = $get_id['fec_agenda'];
        $fecha_7_despues = date('d/m/Y',strtotime('+7 day', strtotime($fecha)));
        $fecha_1_antes = date('d/m/Y',strtotime('-1 day', strtotime($fecha)));
        $fecha_7_antes = date('d/m/Y',strtotime('-7 day', strtotime($fecha)));
        $fecha_14_antes = date('d/m/Y',strtotime('-14 day', strtotime($fecha)));

        $query_7_despues = mysqli_query($conexion, "SELECT (SELECT COUNT(*) FROM historial_registro_mail
                            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND (DATE(fecha_accion) BETWEEN DATE_ADD('$fecha_consulta',interval 1 day)
                            AND DATE_ADD('$fecha_consulta',interval 7 day))) AS registrados,
                            (SELECT COUNT(*) FROM historial_registro_mail
                            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND (DATE(fec_contactado) BETWEEN DATE_ADD('$fecha_consulta',interval 1 day)
                            AND DATE_ADD('$fecha_consulta',interval 7 day))) AS contactados,
                            (SELECT COUNT(*) FROM historial_registro_mail
                            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND asiste=1 AND (DATE(fecha_accion) BETWEEN DATE_ADD('$fecha_consulta',interval 1 day)
                            AND DATE_ADD('$fecha_consulta',interval 7 day))) AS asistes,
                            (SELECT COUNT(*) FROM historial_registro_mail
                            WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND no_asiste=1 AND (DATE(fecha_accion) BETWEEN DATE_ADD('$fecha_consulta',interval 1 day)
                            AND DATE_ADD('$fecha_consulta',interval 7 day))) AS no_asistes,
                            (SELECT COUNT(*) FROM historial_registro_mail
                            WHERE id_evento=ev.id_evento AND estado=57 AND (DATE(fecha_accion) BETWEEN DATE_ADD('$fecha_consulta',interval 1 day)
                            AND DATE_ADD('$fecha_consulta',interval 7 day))) AS sin_revisar
                            FROM evento ev
                            WHERE ev.id_evento=".$get_id['id_evento']."");
        $datos_7_despues = mysqli_fetch_assoc($query_7_despues); 

        $query_hoy = mysqli_query($conexion, "SELECT (SELECT COUNT(*) FROM historial_registro_mail
                    WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND DATE(fecha_accion)='$fecha_consulta') AS registrados,
                    (SELECT COUNT(*) FROM historial_registro_mail
                    WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND DATE(fec_contactado)='$fecha_consulta') AS contactados,
                    (SELECT COUNT(*) FROM historial_registro_mail
                    WHERE id_evento=ev.id_evento AND estado=57 AND DATE(fecha_accion)='$fecha_consulta') AS sin_revisar
                    FROM evento ev
                    WHERE ev.id_evento=".$get_id['id_evento']."");
        $datos_hoy = mysqli_fetch_assoc($query_hoy);

        $query_1_antes = mysqli_query($conexion, "SELECT (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND DATE(fecha_accion)=DATE_SUB('$fecha_consulta',interval 1 day)) AS registrados,
                        (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND DATE(fec_contactado)=DATE_SUB('$fecha_consulta',interval 1 day)) AS contactados,
                        (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado=57 AND DATE(fecha_accion)=DATE_SUB('$fecha_consulta',interval 1 day)) AS sin_revisar
                        FROM evento ev
                        WHERE ev.id_evento=".$get_id['id_evento']."");
        $datos_1_antes = mysqli_fetch_assoc($query_1_antes);

        $query_7_antes = mysqli_query($conexion, "SELECT (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND (DATE(fecha_accion) BETWEEN DATE_SUB('$fecha_consulta',interval 7 day) 
                        AND DATE_SUB('$fecha_consulta',interval 2 day))) AS registrados,
                        (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND (DATE(fec_contactado) BETWEEN DATE_SUB('$fecha_consulta',interval 7 day) 
                        AND DATE_SUB('$fecha_consulta',interval 2 day))) AS contactados,
                        (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado=57 AND (DATE(fecha_accion) BETWEEN DATE_SUB('$fecha_consulta',interval 7 day) 
                        AND DATE_SUB('$fecha_consulta',interval 2 day))) AS sin_revisar
                        FROM evento ev
                        WHERE ev.id_evento=".$get_id['id_evento']."");
        $datos_7_antes = mysqli_fetch_assoc($query_7_antes);

        $query_14_antes = mysqli_query($conexion, "SELECT (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND (DATE(fecha_accion) BETWEEN DATE_SUB('$fecha_consulta',interval 14 day) 
                        AND DATE_SUB('$fecha_consulta',interval 8 day))) AS registrados,
                        (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado NOT IN (35,54) AND contactado=1 AND (DATE(fec_contactado) BETWEEN DATE_SUB('$fecha_consulta',interval 14 day) 
                        AND DATE_SUB('$fecha_consulta',interval 8 day))) AS contactados,
                        (SELECT COUNT(*) FROM historial_registro_mail
                        WHERE id_evento=ev.id_evento AND estado=57 AND (DATE(fecha_accion) BETWEEN DATE_SUB('$fecha_consulta',interval 14 day) 
                        AND DATE_SUB('$fecha_consulta',interval 8 day))) AS sin_revisar
                        FROM evento ev
                        WHERE ev.id_evento=".$get_id['id_evento']."");
        $datos_14_antes = mysqli_fetch_assoc($query_14_antes);

        $total_registrados = $datos_7_despues['registrados']+$datos_hoy['registrados']+$datos_1_antes['registrados']+$datos_7_antes['registrados']+$datos_14_antes['registrados'];
        $total_contactados = $datos_7_despues['contactados']+$datos_hoy['contactados']+$datos_1_antes['contactados']+$datos_7_antes['contactados']+$datos_14_antes['contactados'];
        $total_sin_revisar = $datos_7_despues['sin_revisar']+$datos_hoy['sin_revisar']+$datos_1_antes['sin_revisar']+$datos_7_antes['sin_revisar']+$datos_14_antes['sin_revisar'];

        $pdf->SetXY (15,$y2+154);
        $pdf->MultiCell (180,62,'',1,'L',1,0,'','',true,0,false,true,62,'M');

        $pdf->SetXY (18,$y2+157);
        $pdf->MultiCell (47,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,230,153);
        $pdf->MultiCell (22,8,'Registrados',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(189,215,238);
        $pdf->MultiCell (22,8,'Contactados',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(84,130,53);
        $pdf->SetTextColor(255,255,255);
        $pdf->MultiCell (22,8,'Han Asistido',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(248,203,173);
        $pdf->MultiCell (22,8,'No Asisten',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (22,8,'Sin Revisar',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+165);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'7 días después',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_7_despues,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_7_despues['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_7_despues['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(226,239,218);
        $pdf->MultiCell (22,8,$datos_7_despues['asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(252,228,214);
        $pdf->MultiCell (22,8,$datos_7_despues['no_asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_7_despues['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+173);
        $pdf->SetFont('helvetica','B',8);
        $pdf->MultiCell (27,8,'Día Evento',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_evento,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_hoy['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_hoy['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_hoy['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+181);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'1 día antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_1_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_1_antes['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_1_antes['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_1_antes['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+189);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'7 días antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_7_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_7_antes['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_7_antes['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_7_antes['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+197);
        $pdf->SetFont('helvetica','',8);
        $pdf->MultiCell (27,8,'14 días antes',0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFont('helvetica','',10);
        $pdf->MultiCell (20,8,$fecha_14_antes,0,'R',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,242,204);
        $pdf->MultiCell (22,8,$datos_14_antes['registrados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(221,235,247);
        $pdf->MultiCell (22,8,$datos_14_antes['contactados'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (22,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(242,242,242);
        $pdf->MultiCell (22,8,$datos_7_antes['sin_revisar'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        $pdf->SetXY (18,$y2+205);
        $pdf->MultiCell (47,8,'',0,'L',1,0,'','',true,0,false,true,8,'M');
        $pdf->MultiCell (5,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,230,153);
        $pdf->MultiCell (22,8,$total_registrados,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(189,215,238);
        $pdf->MultiCell (22,8,$total_contactados,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(84,130,53);
        $pdf->SetTextColor(255,255,255);
        $pdf->MultiCell (22,8,$datos_7_despues['asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(248,203,173);
        $pdf->MultiCell (22,8,$datos_7_despues['no_asistes'],0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);
        $pdf->MultiCell (3,8,'',0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(217,217,217);
        $pdf->MultiCell (22,8,$total_sin_revisar,0,'C',1,0,'','',true,0,false,true,8,'M');
        $pdf->SetFillColor(255,255,255);

        //FOOTER
        $pdf->SetFillColor(196,37,129);
        $pdf->SetXY (0,$y2+235);
        $pdf->MultiCell (210,12,'',0,'L',1,0,'','',true,0,false,true,12,'M');

        $pdf->SetTextColor(255,255,255);
        $pdf->SetXY (10,$y2+236);
        $pdf->MultiCell (45,10,'Global Leadership Group',0,'L',1,0,'','',true,0,false,true,10,'M');
        $pdf->MultiCell (100,10,'',0,'L',1,0,'','',true,0,false,true,10,'M');
        $pdf->MultiCell (45,10,date('d/m/Y')." - ".date('H:i:s'),0,'R',1,0,'','',true,0,false,true,10,'M');

        $emailAttachment = $pdf->Output('', 'S');

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
            $mail->setFrom('no-reply@gllg.edu.pe', 'Eventos'); //desde donde se envia

            $array=explode(",",$get_id['autorizaciones']);
            $contador=0;
            $cadena="";
            while($contador<count($array)){
                $contador2=0;

                while($contador2<$totalRows_u){
                    mysqli_data_seek($query_u,$contador2);
                    $list_usuario = mysqli_fetch_assoc($query_u);
        
                    if($list_usuario['id_usuario']==$array[$contador]){
                        $mail->addAddress($list_usuario['usuario_email']);
                    }

                    $contador2++;
                }
                $contador++;
            }

            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'EVENTO: '.$get_id['cod_empresa'].'-'.$get_id['nom_evento'];

            $mail->Body =  '<p style="font-size:14px;">¡Hola!</p>
                            <p style="font-size:14px;">El siguiente evento a sido creado:</p>
                            <table style="border:hidden;font-size:14px;" width="100%">
                                <tr>
                                    <td colspan="4"><b>Ref: </b>'.$get_id['cod_evento'].'</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><b>Evento: </b>'.$get_id['nom_evento'].'</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><b>Fecha: </b>'.$get_id['fecha_agenda'].'</td>
                                </tr>
                                <tr>
                                    <td width="25%"><b>Empresa: </b>'.$get_id['cod_empresa'].'</td>
                                    <td width="25%"><b>Sede: </b>'.$get_id['cod_sede'].'</td>
                                    <td width="25%"><b>Activo de: </b>'.$get_id['fecha_ini'].'</td>
                                    <td width="25%"><b>Hasta: </b>'.$get_id['fecha_fin'].'</td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2"><b>Creado Por: </b>'.$get_id['cod_empresa'].'</td>
                                    <td width="50%" colspan="2"><b>Link Registro: </b>'.$get_id['link'].'</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><b>Usuarios: </b>'.$usuario_informe.'</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><b>Observaciones: </b>'.$get_id['obs_evento'].'</td>
                                </tr>
                            </table>
                            <br>
                            <p>Puedes siempre revisar:</p>
                            <p>Base de datos del evento: https://snappy.org.pe//index.php?/Administrador/Eventos/</p>
                            <p>Informe del Evento: https://snappy.org.pe//index.php?/Administrador/Pdf_Evento/'.$get_id['id_evento'].'</p>
                            <br>
                            <p>Igualmente recibirás automáticamente este mismo informe 14, 7 y 1 día antes del evento.</p>
                            <p>(este correo ha sido enviado de forma automática)</p>';

            $mail->CharSet = 'UTF-8';
            $mail->AddStringAttachment($emailAttachment, 'Informe_Evento.pdf', 'base64', 'application/pdf');
            $mail->send();

        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
?>