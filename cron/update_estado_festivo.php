<?php
    include 'conexion.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    } 

    $update = mysqli_query($conexion, "UPDATE calendar_festivo SET estado=5
                WHERE TIMESTAMPDIFF(DAY, DATE(inicio), CURDATE())>=15 AND estado=2");
?>