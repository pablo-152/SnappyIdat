<?php
    include 'conexion.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    } 

    mysqli_query($conexion, "UPDATE contrato_colaborador SET estado=3
    WHERE SUBSTRING(fin_contrato,1,1)='2' AND fin_contrato<CURDATE() AND estado_contrato=2 AND estado=2");
?>