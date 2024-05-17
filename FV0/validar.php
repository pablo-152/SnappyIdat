<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php");

    include "mcript.php";
    include 'httpPHPAltiria.php'; 
?>

<?php
    $id_empresa = 6;
    $id_sede = 28;

    $query_e = mysqli_query($con, "SELECT id_evento FROM evento 
                WHERE id_empresa=$id_empresa AND id_estadoe=1 AND estado=2 AND tipo_link=3
                ORDER BY id_evento ASC LIMIT 1"); 
    $totalRows_e = mysqli_num_rows($query_e);

    if($totalRows_e>0){
        $get_id = mysqli_fetch_assoc($query_e);
        $id_evento = $get_id['id_evento'];
        $totalRows_v = 1;
    }else{
        $totalRows_v = 0;
    }

    $nombres = $_POST['nombres'];
	$numero_dni = $_POST['numero_dni'];
	$asesor = $_POST['asesor'];
    $apellidos = $_POST['apellidos'];
    $mail = $_POST['mail'];
    $tel = $_POST['tel'];
    $grado = $_POST['grado'];
    $checkbox2 = $_POST['checkbox2'];

    $nombre=$nombres." ".$apellidos;

    if ($totalRows_v==0){
        echo "validez";
    }else{
        if($mail!="" && $tel==""){
            $query_t = mysqli_query($con, "SELECT hr.* FROM historial_registro_mail hr
                        LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
                        WHERE hr.id_evento=$id_evento AND hr.estado!=35 AND rm.correo='$mail'");
            $totalRows_t = mysqli_num_rows($query_t);
        }elseif($mail=="" && $tel!=""){
            $query_t = mysqli_query($con, "SELECT hr.* FROM historial_registro_mail hr
                        LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
                        WHERE hr.id_evento=$id_evento AND hr.estado!=35 AND rm.contacto1='$tel'");
            $totalRows_t = mysqli_num_rows($query_t);
        }else{
            $query_t = mysqli_query($con, "SELECT hr.* FROM historial_registro_mail hr
                        LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
                        WHERE hr.id_evento=$id_evento AND hr.estado!=35 AND rm.correo='$mail' AND rm.contacto1='$tel'");
            $totalRows_t = mysqli_num_rows($query_t);
        }

        if($totalRows_t>0){
            echo "error";
        }else{
            if($mail!="" && $tel==""){
                $query_buscar = mysqli_query($con, "SELECT * FROM registro_mail WHERE id_empresa=$id_empresa AND id_sede=$id_sede AND 
                                correo='$mail' ORDER BY id_registro DESC LIMIT 1");
                $totalRows_buscar = mysqli_num_rows($query_buscar);
            }elseif($mail=="" && $tel!=""){
                $query_buscar = mysqli_query($con, "SELECT * FROM registro_mail WHERE id_empresa=$id_empresa AND id_sede=$id_sede AND 
                                contacto1='$tel' ORDER BY id_registro DESC LIMIT 1");
                $totalRows_buscar = mysqli_num_rows($query_buscar);
            }else{
                $query_buscar = mysqli_query($con, "SELECT * FROM registro_mail WHERE id_empresa=$id_empresa AND id_sede=$id_sede AND 
                                correo='$mail' AND contacto1='$tel' ORDER BY id_registro DESC LIMIT 1");
                $totalRows_buscar = mysqli_num_rows($query_buscar);
            }

            $query_id = mysqli_query($con, "SELECT * FROM evento WHERE id_evento=$id_evento");
            $get_id = mysqli_fetch_row($query_id);

            if($totalRows_buscar>0){
                $get_rm = mysqli_fetch_row($query_buscar);
                $id_registro = $get_rm[0];

                $query_ihrm=mysqli_query($con, "INSERT INTO historial_registro_mail (id_registro,id_evento,id_producto_interes,comentario,observacion,fecha_accion,id_accion,
                            envio_correo,asesor,estado,fec_reg,user_reg)
                            VALUES ('$id_registro','$id_evento','$grado','$get_id[2]','$get_id[2]',NOW(),12,1,'$asesor',57,NOW(),0)");

                $query_buscar_pi = mysqli_query($con, "SELECT * FROM registro_mail_producto WHERE id_registro=$id_registro AND id_producto_interes=$grado");
                $totalRows_buscar_pi = mysqli_num_rows($query_buscar_pi);

                if($totalRows_buscar_pi==0){
                    $query_inrp=mysqli_query($con, "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
                                VALUES ('$id_registro','$grado',2,NOW(),0)");
                }

                $query_aviso = mysqli_query($con, "SELECT rm.cod_registro FROM historial_registro_mail hr
                                LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
                                WHERE hr.id_evento=$id_evento AND hr.estado!=35
                                ORDER BY hr.id_historial DESC");
                $cantidad = mysqli_num_rows($query_aviso);
                $get_id = mysqli_fetch_assoc($query_aviso);
                if($cantidad>0){
                    if($tel!=""){
                        $altiriaSMS = new AltiriaSMS();
            
                        $altiriaSMS->setDebug(true);
                        $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                        $altiriaSMS->setPassword('gllg2021');
                    
                        $sDestination = '51'.$tel;
                        $sMessage = 'Gracias por tu registro en IFV. Tu referencia es '.$get_id['cod_registro'].'. ¡SUERTE!';
                        $altiriaSMS->sendSMS($sDestination, $sMessage);
                    }
                    echo "***".$get_id['cod_registro'];
                }else{
                    if($tel!=""){
                        $altiriaSMS = new AltiriaSMS();
            
                        $altiriaSMS->setDebug(true);
                        $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                        $altiriaSMS->setPassword('gllg2021');
                    
                        $sDestination = '51'.$tel;
                        $sMessage = 'Gracias por tu registro en IFV. Tu referencia es XXXX. ¡SUERTE!';
                        $altiriaSMS->sendSMS($sDestination, $sMessage);
                    }
                    echo "***XXXX";
                }
            }else{
                $anio=date('Y');
                $query_rm=mysqli_query($con, "SELECT * FROM registro_mail WHERE YEAR(fec_reg)=$anio");
                $row_rm=mysqli_fetch_array($query_rm);
                $totalRows_rm = mysqli_num_rows($query_rm);
    
                $aniof=substr($anio,2,2);
        
                if($totalRows_rm<9){
                    $codigo=$aniof."000".($totalRows_rm+1);
                }
                if($totalRows_rm>8 && $totalRows_rm<99){
                    $codigo=$aniof."00".($totalRows_rm+1);
                }
                if($totalRows_rm>98 && $totalRows_rm<999){
                    $codigo=$aniof."0".($totalRows_rm+1);
                }
                if($totalRows_rm>998 ){
                    $codigo=$aniof.($totalRows_rm+1);
                }
    
                $cod_registro=$codigo;
    
                $query_irm = mysqli_query($con, "INSERT INTO registro_mail (cod_registro,id_informe,
                            nombres_apellidos,dni,contacto1,correo,id_empresa,id_sede,recibir_info,
                            fecha_inicial,observacion,envio_correo,estado,fec_reg,user_reg) 
                            VALUES ('$cod_registro',14,'$nombre','$numero_dni','$tel','$mail',$id_empresa,
                            $id_sede,'$checkbox2',NOW(),'$get_id[2]',1,1,NOW(),0)");
    
                $query_urm=mysqli_query($con, "SELECT * FROM registro_mail ORDER BY id_registro DESC LIMIT 1");
                $ultimo = mysqli_fetch_row($query_urm);
                $id_registro = $ultimo[0];
    
                $query_ihrm=mysqli_query($con, "INSERT INTO historial_registro_mail (id_registro,id_evento,id_producto_interes,comentario,observacion,fecha_accion,id_accion,
                            envio_correo,asesor,estado,fec_reg,user_reg)
                            VALUES ('$id_registro','$id_evento','$grado','$get_id[2]','$get_id[2]',NOW(),12,1,'$asesor',57,NOW(),0)");
    
                $query_buscar_pi = mysqli_query($con, "SELECT * FROM registro_mail_producto WHERE id_registro=$id_registro AND id_producto_interes=$grado");
                $totalRows_buscar_pi = mysqli_num_rows($query_buscar_pi);

                if($totalRows_buscar_pi==0){
                    $query_inrp=mysqli_query($con, "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
                                VALUES ('$id_registro','$grado',2,NOW(),0)");
                }

                $query_aviso = mysqli_query($con, "SELECT rm.cod_registro FROM historial_registro_mail hr
                                LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
                                WHERE hr.id_evento=$id_evento AND hr.estado!=35
                                ORDER BY hr.id_historial DESC");
                $cantidad = mysqli_num_rows($query_aviso);
                $get_id = mysqli_fetch_assoc($query_aviso);
                if($cantidad>0){ 
                    if($tel!=""){
                        $altiriaSMS = new AltiriaSMS();
            
                        $altiriaSMS->setDebug(true);
                        $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                        $altiriaSMS->setPassword('gllg2021');
                    
                        $sDestination = '51'.$tel;
                        $sMessage = 'Gracias por tu registro en IFV. Tu referencia es '.$get_id['cod_registro'].'. ¡SUERTE!';
                        $altiriaSMS->sendSMS($sDestination, $sMessage);
                    }
                    echo "***".$get_id['cod_registro'];
                }else{
                    if($tel!=""){
                        $altiriaSMS = new AltiriaSMS();
            
                        $altiriaSMS->setDebug(true);
                        $altiriaSMS->setLogin('vanessa.hilario@gllg.edu.pe');
                        $altiriaSMS->setPassword('gllg2021');
                    
                        $sDestination = '51'.$tel;
                        $sMessage = 'Gracias por tu registro en IFV. Tu referencia es XXXX. ¡SUERTE!';
                        $altiriaSMS->sendSMS($sDestination, $sMessage);
                    }
                    echo "***XXXX";
                }
            }
        }
    }
?>