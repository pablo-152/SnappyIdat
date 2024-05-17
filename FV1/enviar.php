<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php



$nombre=$_POST['nombres'];
$apellidos=$_POST['apellidos'];
$nombres=utf8_decode($nombre." ".$apellidos);
$id_tipodoc=$_POST['dni'];

$numero_dni=$_POST['numero_dni'];

$correo=utf8_decode($_POST['mail']);
$celular=$_POST['tel'];
$id_grado=$_POST['grado'];
$empresa="Leadership";
$checkbox2=$_POST['checkbox2'];

/** */
$query_t = mysqli_query($con, "SELECT * FROM inscripcion WHERE dni='$numero_dni' AND empresa='LS'");
    $totalRows_t = mysqli_num_rows($query_t);

    if ($totalRows_t>0){
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
            $codigo=$aniof.($totalRows_i+1);
        }

        $cod_inscripcion=$codigo;

        $query_b=mysqli_query($con, "INSERT INTO inscripcion (cod_inscripcion,nombres,dni,correo,celular,id_grado_escuela,
                id_tipodoc,recibir_info,fec_reg,user_reg,id_estadoi) 
                VALUES ('$cod_inscripcion','$nombres','$numero_dni','$correo','$celular','$id_grado','$id_tipodoc',
                '$checkbox2',NOW(),'$numero_dni','2')");
    }


        

    

