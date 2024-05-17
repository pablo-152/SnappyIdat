<?php
	require_once ("config/db.php");
    require_once ("config/conexion.php")
?>

<?php
    $nombre=utf8_decode($_POST['nombre']);
    $correo=utf8_decode($_POST['correo']);
    $celular=$_POST['celular'];
    $dni=$_POST['dni'];
    $id_contacto=$_POST['id_contacto'];
    $id_departamento=$_POST['id_departamento'];
    $id_provincia=$_POST['id_provincia'];

    $query_t = mysqli_query($con, "SELECT * FROM inscripcion WHERE dni='$dni' AND empresa='Happy'");
    $totalRows_t = mysqli_num_rows($query_t);

    if ($totalRows_t>0){
        echo "error";
    }else{
        $anio=date('Y');
        $query_i=mysqli_query($con, "SELECT * FROM inscripcion");
        $row_i=mysqli_fetch_array($query_i);
        $totalRows_i = mysqli_num_rows($query_i);

        $aniof=substr($anio, 2,2);

        if($totalRows_i<9){
            $codigo=$aniof."C000000".($totalRows_i+1);
        }
        if($totalRows_i>8 && $totalRows_i<99){
            $codigo=$aniof."C00000".($totalRows_i+1);
        }
        if($totalRows_i>98 && $totalRows_i<999){
            $codigo=$aniof."C0000".($totalRows_i+1);
        }
        if($totalRows_i>998 ){
            $codigo=$totalRows_i+1;
        }

        $cod_inscripcion=$codigo;

        $query_b=mysqli_query($con, "INSERT INTO inscripcion (cod_inscripcion,id_contacto,empresa,
                nombres,dni,correo,celular,id_departamento,id_provincia,fec_reg,user_reg,id_estadoi) 
                VALUES ('$cod_inscripcion','$id_contacto','Happy','$nombre','$dni','$correo',
                '$celular','$id_departamento','$id_provincia',NOW(),'$dni','2')");
    }
?>