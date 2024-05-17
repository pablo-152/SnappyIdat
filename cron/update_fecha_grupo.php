<?php
    include 'conexion.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $query_ep = mysqli_query($conexion, "UPDATE grupo_calendarizacion set estado_grupo=5 where estado=2 and estado_grupo not in (2,4,5,6) and fin_clase < CURDATE()");

    $query_ep2 = mysqli_query($conexion, "UPDATE grupo_calendarizacion set estado_grupo=2 where id_grupo in (
        SELECT id_grupo FROM grupo_calendarizacion gc
        LEFT JOIN ciclo ci ON ci.id_ciclo=gc.id_ciclo and ci.estado=2
        where gc.estado=2 and estado_grupo not in (2,4,5,6) and fin_clase < CURDATE() and ci.ciclo='C6')");
    
    $query_ep3 = mysqli_query($conexion, "UPDATE grupo_calendarizacion set estado_grupo=3 where estado=2 and estado_grupo in (1) and CURDATE() >= inicio_clase and fin_clase <= CURDATE()");
?>