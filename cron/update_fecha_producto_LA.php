<?php
    include 'conexion.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    mysqli_query($conexion, "UPDATE producto_la SET estado=3 
    WHERE hasta<=CURDATE() AND estado=2"); 
?>