<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
    $id_evento = 0;
    $id_empresa = 9;
    $nombres=$_POST['nombres'];
    $apellidos=$_POST['apellidos'];
    $dni=$_POST['dni'];
    $numero_dni=$_POST['numero_dni'];
    $mail=$_POST['mail'];
    $tel=$_POST['tel'];
    $grado=$_POST['grado'];
    $checkbox2=$_POST['checkbox2'];

    $nombre=$nombres." ".$apellidos;

    $query_t = mysqli_query($con, "SELECT ic.* FROM inscripcion ic
                                    LEFT JOIN evento ev ON ev.id_evento=ic.id_evento
                                    WHERE ic.dni='$numero_dni' AND ev.id_empresa=$id_empresa");
    $totalRows_t = mysqli_num_rows($query_t);

    $query_v = mysqli_query($con, "SELECT * FROM evento WHERE id_evento=$id_evento AND id_estadoe=1");
    $totalRows_v = mysqli_num_rows($query_v);

    if ($totalRows_v==0){
        echo "validez";
    }else{
        if($totalRows_t>0){
            echo "error";
        }else{
            $anio=date('Y');
            $query_i=mysqli_query($con, "SELECT * FROM inscripcion WHERE YEAR(fec_reg)=$anio");
            $row_i=mysqli_fetch_array($query_i);
            $totalRows_i = mysqli_num_rows($query_i);

            $aniof=substr($anio, 2,2);

            if($totalRows_i<9){
                $codigo=$aniof."C000".($totalRows_i+1);
            }
            if($totalRows_i>8 && $totalRows_i<99){
                $codigo=$aniof."C00".($totalRows_i+1);
            }
            if($totalRows_i>98 && $totalRows_i<999){
                $codigo=$aniof."C0".($totalRows_i+1);
            }
            if($totalRows_i>998 ){
                $codigo=$totalRows_i+1;
            }

            $cod_inscripcion=$codigo;

            $query_b=mysqli_query($con, "INSERT INTO inscripcion (cod_inscripcion,id_evento,
                    nombres,id_tipodoc,dni,correo,celular,id_grado_escuela,recibir_info,fec_reg,user_reg,id_estadoi) 
                    VALUES ('$cod_inscripcion','$id_evento','$nombre','$dni','$numero_dni','$mail','$tel',
                    '$grado','$checkbox2',NOW(),'$numero_dni','2')");
        }
    }
?>


        

    

