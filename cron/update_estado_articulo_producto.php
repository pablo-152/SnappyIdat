<?php
    include 'conexion.php'; 

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));  
    } 

    $update_articulo = mysqli_query($conexion, "UPDATE articulo SET estado=3
                        WHERE anio<YEAR(CURDATE()) AND estado=2");

    $update_producto = mysqli_query($conexion, "UPDATE producto_articulo SET estado=3
                        WHERE anio<YEAR(CURDATE()) AND estado=2");
?>