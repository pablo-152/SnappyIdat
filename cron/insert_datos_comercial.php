<?php
    include 'conexion.php';

    $query_t = mysqli_query($conexion, "TRUNCATE TABLE datos_comercial");  

    $query_a = mysqli_query($conexion, "INSERT INTO datos_comercial (status_sin_definir,interese_sin_definir) 
                VALUES ((SELECT COUNT(1) FROM max_historico_mail_2 
                WHERE estado=14 AND id_empresa>0),
                (SELECT COUNT(1) FROM max_historico_mail_2 
                WHERE nom_productos='Sin Definir' AND estado!=35 AND id_empresa>0))"); 

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>