<?php
    include 'conexion.php'; 
    include 'conexion_vps.php'; 

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));  
    }

    sqlsrv_query($conexion_vps, "TRUNCATE TABLE fotocheck"); 

    $query_a = mysqli_query($conexion, "SELECT * FROM fotocheck");

    while($fila = mysqli_fetch_assoc($query_a)) {
        sqlsrv_query($conexion_vps, "INSERT INTO fotocheck (Id,Fecha_Pago_Fotocheck,
        Monto_Pago_Fotocheck,Doc_Pago_Fotocheck,esta_fotocheck,fec_reg,user_reg) 
        VALUES ('".$fila['Id']."','".$fila['Fecha_Pago_Fotocheck']."',
        '".$fila['Monto_Pago_Fotocheck']."','".$fila['Doc_Pago_Fotocheck']."',
        '".$fila['esta_fotocheck']."','".$fila['fec_reg']."','".$fila['user_reg']."')"); 
    }
?>