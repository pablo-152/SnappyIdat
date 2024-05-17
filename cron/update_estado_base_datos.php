<?php
    include 'conexion.php'; 

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    } 

    $update = mysqli_query($conexion, "UPDATE base_datos SET estado=3
                WHERE TIMESTAMPDIFF(MONTH, DATE(fec_reg), CURDATE())>=1 AND estado=2");
?>