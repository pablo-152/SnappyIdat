<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
    $id_evento = 56;
    $id_empresa = 9;
    $id_sede = 11;
    $nombres=$_POST['nombres'];
    $apellidos=$_POST['apellidos'];
    $mail=$_POST['mail'];
    $tel=$_POST['tel'];
    $grado=$_POST['grado'];

    $nombre=$nombres." ".$apellidos;

    $query_v = mysqli_query($con, "SELECT * FROM evento WHERE id_evento=$id_evento AND id_estadoe=1");
    $totalRows_v = mysqli_num_rows($query_v);

    if ($totalRows_v==0){
        echo "validez";
    }else{
        if($mail!="" && $tel==""){
            $query_t = mysqli_query($con, "SELECT hr.* FROM historial_registro_mail hr
                        LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
                        WHERE hr.id_evento=$id_evento AND hr.id_producto_interes=$grado AND hr.estado!=35 AND rm.correo='$mail'");
            $totalRows_t = mysqli_num_rows($query_t);
        }elseif($mail=="" && $tel!=""){
            $query_t = mysqli_query($con, "SELECT hr.* FROM historial_registro_mail hr
                        LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
                        WHERE hr.id_evento=$id_evento AND hr.id_producto_interes=$grado AND hr.estado!=35 AND rm.contacto1='$tel'");
            $totalRows_t = mysqli_num_rows($query_t);
        }else{
            $query_t = mysqli_query($con, "SELECT hr.* FROM historial_registro_mail hr
                        LEFT JOIN registro_mail rm ON rm.id_registro=hr.id_registro
                        WHERE hr.id_evento=$id_evento AND hr.id_producto_interes=$grado AND hr.estado!=35 AND rm.correo='$mail' AND rm.contacto1='$tel'");
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
                            envio_correo,estado,fec_reg,user_reg)
                            VALUES ('$id_registro','$id_evento','$grado','$get_id[2]','$get_id[2]',NOW(),12,1,57,NOW(),0)");

                $query_buscar_pi = mysqli_query($con, "SELECT * FROM registro_mail_producto WHERE id_registro=$id_registro AND id_producto_interes=$grado");
                $totalRows_buscar_pi = mysqli_num_rows($query_buscar_pi);

                if($totalRows_buscar_pi==0){
                    $query_inrp=mysqli_query($con, "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
                                VALUES ('$id_registro','$grado',2,NOW(),0)");
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
    
                $query_irm=mysqli_query($con, "INSERT INTO registro_mail (cod_registro,id_informe,nombres_apellidos,contacto1,
                            correo,id_empresa,id_sede,fecha_inicial,observacion,envio_correo,estado,fec_reg,user_reg) 
                            VALUES ('$cod_registro',14,'$nombre','$tel','$mail',$id_empresa,$id_sede,NOW(),
                            '$get_id[2]',1,1,NOW(),0)");
    
                $query_urm=mysqli_query($con, "SELECT * FROM registro_mail ORDER BY id_registro DESC LIMIT 1");
                $ultimo = mysqli_fetch_row($query_urm);
                $id_registro = $ultimo[0];
    
                $query_ihrm=mysqli_query($con, "INSERT INTO historial_registro_mail (id_registro,id_evento,id_producto_interes,comentario,observacion,fecha_accion,id_accion,
                            envio_correo,estado,fec_reg,user_reg)
                            VALUES ('$id_registro','$id_evento','$grado','$get_id[2]','$get_id[2]',NOW(),12,1,57,NOW(),0)");
    
                $query_buscar_pi = mysqli_query($con, "SELECT * FROM registro_mail_producto WHERE id_registro=$id_registro AND id_producto_interes=$grado");
                $totalRows_buscar_pi = mysqli_num_rows($query_buscar_pi);

                if($totalRows_buscar_pi==0){
                    $query_inrp=mysqli_query($con, "INSERT INTO registro_mail_producto (id_registro,id_producto_interes,estado,fec_reg,user_reg) 
                                VALUES ('$id_registro','$grado',2,NOW(),0)");
                }
            }
        }
    }
?>