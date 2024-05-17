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
    
    $query_p = mysqli_query($conexion, "SELECT pr.id_producto,pr.aviso,CONCAT(tp.cod_tipo_producto,'-',ta.cod_talla) AS codigo,tp.descripcion,ti.nom_tipo,ta.talla,
                (SELECT vm.stock_total FROM vista_movimiento_almacen vm WHERE vm.id_producto=pr.id_producto LIMIT 1) AS stock_total
                FROM producto_la pr
                LEFT JOIN tipo_producto_la tp ON tp.id_tipo_producto=pr.id_tipo_producto
                LEFT JOIN talla_la ta ON ta.id_talla=pr.id_talla
                LEFT JOIN tipo_la ti ON ti.id_tipo=tp.id_tipo
                WHERE pr.estado=2 AND pr.id_producto=1"); 

    $query_u = mysqli_query($conexion, "SELECT ar.id_responsable AS id_usuario,ur.usuario_email AS email FROM almacen ar
                LEFT JOIN users ur ON ur.id_usuario=ar.id_responsable
                WHERE ar.estado=2 
                UNION
                SELECT au.id_supervisor AS id_usuario,uu.usuario_email AS email FROM almacen au
                LEFT JOIN users uu ON uu.id_usuario=au.id_supervisor
                WHERE au.estado=2 
                GROUP BY id_usuario,email");
    $totalRows_u = mysqli_num_rows($query_u);

    while ($fila = mysqli_fetch_assoc($query_p)) {
        $query_v = mysqli_query($conexion, "SELECT id_producto,codigo,stock_total FROM vista_movimiento_almacen 
                    WHERE id_producto=".$fila['id_producto']." AND stock_total<".$fila['aviso']."
                    GROUP BY id_producto,codigo,stock_total 
                    ORDER BY codigo ASC");

        $query_v = mysqli_num_rows($query_v);


        if($query_v>0){
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

                while ($fila_u = mysqli_fetch_assoc($query_u)) {
                    $mail->addAddress($fila_u['email']);
                }
                
                $mail->isHTML(true);                                  // Set email format to HTML
        
                $mail->Subject = '(LA) Producto LIMITE STOCK';
        
                $mail->Body =  '<table style="border:hidden;font-size:16px;" width="100%">
                                    <tr>
                                        <td colspan="4">¡Hola!</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">A la fecha tiene estes productos en limite de Stock:</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b>Codigo:</b> '.$fila['codigo'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b>Tipo:</b> '.$fila['nom_tipo'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b>Descripción:</b> '.$fila['descripcion'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b>Talla:</b> '.$fila['talla'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><b>Stock existente:</b> '.$fila['stock_total'].'</td>
                                    </tr>
                                </table>
                                <p style="font-size:16px;">¡Que tengas un excelente día!</p>';
        
                $mail->CharSet = 'UTF-8';
                $mail->send();
        
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }
?>