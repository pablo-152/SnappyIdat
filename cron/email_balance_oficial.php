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

    if(date('m')=="01"){
        $mes = 12;
        $anio = date('Y')-1;
    }else{
        $mes = date('m')-1;
        $anio = date('Y');
    }
    
    $query_m = mysqli_query($conexion, "SELECT id_mes,nom_mes FROM mes 
                WHERE id_mes='$mes'");
    $get_mes = mysqli_fetch_assoc($query_m);

    $query_e = mysqli_query($conexion, "SELECT cod_empresa,nom_empresa,ruc_empresa FROM empresa 
                WHERE id_empresa IN (2,3,4,5,6) 
                ORDER BY cod_empresa ASC");

    include 'conexion_arpay.php';

    if(date('d')=="05"){
        while ($fila = mysqli_fetch_assoc($query_e)) {
            $boletas_cobradas = sqlsrv_query($conexion_arpay,"SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)),0) AS total 
                                FROM Invoice iv_ene
                                LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId
                                LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
                                LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
                                WHERE YEAR(iv_ene.Date)='$anio' AND MONTH(iv_ene.Date)=".$get_mes['id_mes']." AND cp_ene.PaymentStatusId=1 AND 
                                en_ene.Code LIKE '".$fila['cod_empresa']."%'");
            $get_boletas_cobradas = sqlsrv_fetch_array($boletas_cobradas);
    
            $boletas_por_cobrar = sqlsrv_query($conexion_arpay,"SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)),0) AS total 
                                    FROM Invoice iv_ene
                                    LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=iv_ene.ClientProductPurchaseRegistryId
                                    LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
                                    LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
                                    WHERE YEAR(iv_ene.Date)='$anio' AND MONTH(iv_ene.Date)=".$get_mes['id_mes']." AND cp_ene.PaymentStatusId=2 AND 
                                    en_ene.Code LIKE '".$fila['cod_empresa']."%'");
            $get_boletas_por_cobrar = sqlsrv_fetch_array($boletas_por_cobrar);
    
            $facturas = sqlsrv_query($conexion_arpay,"SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)),0) AS total 
                        FROM Bill bi_ene
                        LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=bi_ene.ClientProductPurchaseRegistryId 
                        LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
                        LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
                        WHERE YEAR(bi_ene.Date)='$anio' AND MONTH(bi_ene.Date)=".$get_mes['id_mes']." AND en_ene.Code LIKE '".$fila['cod_empresa']."%'");
            $get_facturas = sqlsrv_fetch_array($facturas);
    
            $notas_debito = sqlsrv_query($conexion_arpay,"SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(cp_ene.PenaltyAmountPaid),0) AS total 
                            FROM DebitNote dn_ene
                            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=dn_ene.ClientProductPurchaseRegistryId 
                            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
                            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
                            WHERE YEAR(dn_ene.Date)='$anio' AND MONTH(dn_ene.Date)=".$get_mes['id_mes']." AND en_ene.Code LIKE '".$fila['cod_empresa']."%'");
            $get_notas_debito = sqlsrv_fetch_array($notas_debito);
    
            $notas_credito = sqlsrv_query($conexion_arpay,"SELECT ISNULL(COUNT(*),0) AS cantidad,ISNULL(SUM(ISNULL(cp_ene.Cost,0)-ISNULL(cp_ene.TotalDiscount,0)),0) AS total 
                            FROM CreditNote cn_ene
                            LEFT JOIN ClientProductPurchaseRegistry cp_ene ON cp_ene.Id=cn_ene.ClientProductPurchaseRegistryId 
                            LEFT JOIN Client cl_ene ON cl_ene.Id=cp_ene.ClientId
                            LEFT JOIN EnterpriseHeadquarter en_ene ON en_ene.Id=cl_ene.EnterpriseHeadquarterId
                            WHERE YEAR(cn_ene.Date)='$anio' AND MONTH(cn_ene.Date)=".$get_mes['id_mes']." AND cn_ene.CreditNoteStatusId=1 AND 
                            en_ene.Code LIKE '".$fila['cod_empresa']."%'");
            $get_notas_credito = sqlsrv_fetch_array($notas_credito);

            $list_gastos = sqlsrv_query($conexion_arpay,"SELECT rt.Description,
                            (SELECT COUNT(*) FROM AccountingPayment ap 
                            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
                            WHERE MONTH(ap.AccountingDate)=".$get_mes['id_mes']." AND YEAR(ap.AccountingDate)=$anio AND 
                            en.Code LIKE '".$fila['cod_empresa']."%' AND ap.ReceiptTypeId=rt.ReceiptTypeId) AS cantidad,
                            ISNULL((SELECT SUM(ap.Amount) FROM AccountingPayment ap 
                            LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterId
                            WHERE MONTH(ap.AccountingDate)=".$get_mes['id_mes']." AND YEAR(ap.AccountingDate)=$anio AND 
                            en.Code LIKE '".$fila['cod_empresa']."%' AND ap.ReceiptTypeId=rt.ReceiptTypeId),0) AS monto
                            FROM ReceiptTypeTranslation rt
                            WHERE rt.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) 
                            ORDER BY rt.Description ASC");

            $cadena = '<table width="20%">';
            while( $fila_g = sqlsrv_fetch_array( $list_gastos, SQLSRV_FETCH_ASSOC) ) {
                $cadena = $cadena.'<tr><td>'.$fila_g['Description'].':</td><td style="text-align:center;">'.$fila_g['cantidad'].'</td><td style="text-align:right;">s/ '.number_format($fila_g['monto'],2).'</td></tr>';
            }
            $cadena = $cadena.'</table>';
    
            $mail = new PHPMailer(true);
            
            try {
                $mail->SMTPDebug = 0;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'noreply@gllg.edu.pe';                     // usuario de acceso
                $mail->Password   = 'tqaifaesxsuvpnwt';                                // SMTP password
                $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mail->setFrom('noreply@snappy.org.pe', 'GLLG'); //desde donde se envia
                
                $mail->addAddress('dcontabilidad@gllg.edu.pe');
                //$mail->addAddress('daniel11143118@gmail.com');
                
                $mail->isHTML(true);                                  // Set email format to HTML
        
                $mail->Subject = 'Reporte Mensual - '.$fila['cod_empresa'];

                $mail->Body =  '<FONT SIZE=2>
                                    ¡Hola!<br><br>
                                    Adjunto resumen a la fecha.<br><br>
                                    <b>'.$get_mes['nom_mes'].' '.$anio.'</b><br>
                                    <table width="15%">
                                        <tr>
                                            <td>Empresa:</td>
                                            <td>'.$fila['nom_empresa'].'</td>
                                        </tr>
                                        <tr>
                                            <td>Ruc:</td>
                                            <td>'.$fila['ruc_empresa'].'</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <b>Documentos Sunat</b><br>
                                    <table width="20%">
                                        <tr>
                                            <td>Boletas (cobradas):</td>
                                            <td style="text-align:center;">'.$get_boletas_cobradas['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_boletas_cobradas['total'],2).'</td>
                                        </tr>
                                        <tr>
                                            <td>Boletas (por cobrar):</td>
                                            <td style="text-align:center;">'.$get_boletas_por_cobrar['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_boletas_por_cobrar['total'],2).'</td>
                                        </tr>
                                        <tr>
                                            <td>Facturas:</td>
                                            <td style="text-align:center;">'.$get_facturas['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_facturas['total'],2).'</td>
                                        </tr>
                                        <tr>
                                            <td>Notas de Débito:</td>
                                            <td style="text-align:center;">'.$get_notas_debito['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_notas_debito['total'],2).'</td>
                                        </tr>
                                        <tr>
                                            <td>Notas de Crédito:</td>
                                            <td style="text-align:center;">'.$get_notas_credito['cantidad'].'</td>
                                            <td style="text-align:right;">s/ '.number_format($get_notas_credito['total'],2).'</td>
                                        </tr>
                                    </table>
                                    <br>
                                    <b>Gastos Sunat</b><br>
                                    '.$cadena.'
                                    <br>
                                    Revisar montos antes de reenvíar a estudio contable.<br>
                                    Gracias.
                                </FONT SIZE>';
        
                $mail->CharSet = 'UTF-8';
                $mail->send();
        
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}"; 
            }
        }
    }
?>