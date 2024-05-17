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
    
    $query_a = mysqli_query($conexion, "SELECT al.id_almacen,al.descripcion,al.id_sede,al.id_vendedor,ur.usuario_email AS correo_responsable,us.usuario_email AS correo_supervisor 
                FROM almacen al
                LEFT JOIN users ur ON ur.id_usuario=al.id_responsable
                LEFT JOIN users us ON us.id_usuario=al.id_supervisor
                WHERE al.id_vendedor!=''"); 

    while ($fila = mysqli_fetch_assoc($query_a)) {
        $array=explode(",",$fila['id_vendedor']); 
        $contador=0;
        $cadena=""; 
        while($contador<count($array)){
            $query_movimiento = mysqli_query($conexion, "SELECT COUNT(1) AS cantidad FROM venta ve
                                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                                WHERE ve.estado=2 AND ve.user_reg=".$array[$contador]." AND DATE(ve.fec_reg)=CURDATE() AND al.id_sede=".$fila['id_sede']);
            $movimiento = mysqli_fetch_assoc($query_movimiento);

            $query_devolucion = mysqli_query($conexion, "SELECT COUNT(1) AS cantidad FROM devolucion de
                                LEFT JOIN venta ve ON ve.id_venta=de.id_venta
                                LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen
                                WHERE de.estado=2 AND de.id_usuario=".$array[$contador]." AND 
                                de.estado_d=0 AND al.id_sede=".$fila['id_sede']);
            $devolucion = mysqli_fetch_assoc($query_devolucion);

            $query_c = mysqli_query($conexion, "SELECT * FROM cierre_caja 
                        WHERE id_sede=".$fila['id_sede']." AND id_vendedor=".$array[$contador]."  AND fecha=CURDATE() AND estado=2");
            $totalRows_c = mysqli_num_rows($query_c);

            if($totalRows_c==0 && $movimiento['cantidad']>0 && $devolucion['cantidad']==0){ 
                $query_saldo = mysqli_query($conexion, "SELECT (IFNULL((SELECT SUM(vd.precio*vd.cantidad) FROM venta_detalle vd 
                        LEFT JOIN venta ve ON ve.id_venta=vd.id_venta 
                        LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen 
                        WHERE ve.user_reg=".$array[$contador]." AND DATE(ve.fec_reg)=CURDATE() AND ve.estado=2 AND ve.estado_venta=1 AND 
                        al.id_sede=".$fila['id_sede']."),0)-
                        IFNULL((SELECT SUM(vd.precio*vd.cantidad) FROM venta_detalle vd 
                        LEFT JOIN venta ve ON ve.id_venta=vd.id_venta 
                        LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen 
                        WHERE ve.user_reg=".$array[$contador]." AND DATE(ve.fec_reg)=CURDATE() AND ve.estado=2 AND ve.estado_venta=3 AND 
                        al.id_sede=".$fila['id_sede']."),0)) AS saldo_automatico,
                        (IFNULL((SELECT SUM(vd.cantidad) FROM venta_detalle vd 
                        LEFT JOIN venta ve ON ve.id_venta=vd.id_venta 
                        LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen 
                        WHERE ve.user_reg=".$array[$contador]." AND DATE(ve.fec_reg)=CURDATE() AND ve.estado=2 AND ve.estado_venta=1 AND 
                        al.id_sede=".$fila['id_sede']."),0)-
                        IFNULL((SELECT SUM(vd.cantidad) FROM venta_detalle vd 
                        LEFT JOIN venta ve ON ve.id_venta=vd.id_venta 
                        LEFT JOIN almacen al ON al.id_almacen=ve.id_almacen 
                        WHERE ve.user_reg=".$array[$contador]." AND DATE(ve.fec_reg)=CURDATE() AND ve.estado=2 AND ve.estado_venta=3 AND 
                        al.id_sede=".$fila['id_sede']."),0)) AS productos"); 
                $saldo = mysqli_fetch_assoc($query_saldo);

                $insert = mysqli_query($conexion, "INSERT INTO cierre_caja (id_sede,id_vendedor,fecha,saldo_automatico,productos,estado)
                        VALUES ('".$fila['id_sede']."','".$array[$contador]."',CURDATE(),'".$saldo['saldo_automatico']."','".$saldo['productos']."',2)");

                $query_usuario = mysqli_query($conexion, "SELECT * FROM users WHERE id_usuario=".$array[$contador]);
                $get_usuario = mysqli_fetch_assoc($query_usuario);

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
                    $mail->setFrom('noreply@snappy.edu.pe', 'Snappy'); //desde donde se envia
                    
                    $mail->addAddress($fila['correo_responsable']); 
                    $mail->addAddress($fila['correo_supervisor']);
                    $mail->addAddress('pedro.vieira@gllg.edu.pe');
                    //$mail->addAddress('daniel11143118@gmail.com');
                    
                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = '(LA) Caja PENDIENTE DE CERRAR';

                    $mail->Body =  '<table style="border:hidden;font-size:16px;" width="100%">
                                        <tr>
                                            <td colspan="4">¡Hola!</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">A la fecha tiene pendiente de cerrar:</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Punto de venta:</b> '.$fila['descripcion'].'</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Cajas:</b> 1</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><b>Usuarios:</b> '.$get_usuario['usuario_codigo'].'</td>
                                        </tr>
                                    </table>
                                    <p style="font-size:16px;">¡Que tengas un excelente día!</p>';

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }

            $contador++;
        }
    }
?>