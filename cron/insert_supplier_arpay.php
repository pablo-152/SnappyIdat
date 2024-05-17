<?php
    include 'conexion_arpay.php';

    $query_c = sqlsrv_query($conexion_arpay,"SELECT * FROM Supplier WHERE Id IN (76,82,97);");

    include 'conexion.php';

    $query_t = mysqli_query($conexion, "TRUNCATE TABLE supplier_arpay");

    while( $fila = sqlsrv_fetch_array( $query_c, SQLSRV_FETCH_ASSOC) ) { 
        $query_a = mysqli_query($conexion, "INSERT INTO supplier_arpay (Id,Nombre,Ruc) 
                    VALUES ('".$fila['Id']."','".$fila['Name']."','".$fila['RUC']."')"); 
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>