<?php
    include 'conexion.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $query_e = mysqli_query($conexion, "SELECT id_estado_bancario FROM estado_bancario 
                WHERE estado=2");

    while($fila = mysqli_fetch_assoc($query_e)){
        mysqli_query($conexion, "INSERT INTO detalle_estado_bancario (id_estado_bancario,mes,anio,
        estado,fec_reg,user_reg) 
        VALUES(".$fila['id_estado_bancario'].",SUBSTRING(DATE_ADD(CURDATE(),INTERVAL -1 MONTH),6,2),
        SUBSTRING(DATE_ADD(CURDATE(),INTERVAL -1 MONTH),1,4),1,NOW(),1)");
    }
?>