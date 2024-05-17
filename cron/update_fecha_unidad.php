<?php
    include 'conexion.php';

    $query_i = mysqli_query($conexion, "UPDATE unidad_ep1 SET estado=3 WHERE fin_clase=CURDATE() AND estado=2");

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

?>