<?php
    include 'conexion_arpay.php';
    include 'conexion.php';
    include 'conexion_vps.php';

    $query_p = sqlsrv_query($conexion_arpay,"SELECT em.EmployeeId,pe.IdentityCardNumber,pe.Email,pe.FatherSurname,pe.MotherSurname,pe.FirstName,ep.InternalEmployeeId
                FROM EmployeeEnterpriseActivity em
                LEFT JOIN Employee ep ON ep.Id=em.EmployeeId
                LEFT JOIN Person pe ON pe.Id=ep.PersonId
                WHERE em.EnterpriseHeadquarterId IN (4,5,7,8) AND em.EndDate IS NULL
                ORDER BY pe.FatherSurname ASC,pe.MotherSurname ASC,pe.FirstName ASC"); 

    
    
    while( $fila_p = sqlsrv_fetch_array( $query_p, SQLSRV_FETCH_ASSOC) ) { 
        $codigoa=$fila_p['InternalEmployeeId']."'C"; 
        $query_ap = mysqli_query($conexion, "INSERT INTO matriculados_ls (Tipo,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
                    Codigo, Codigoa, fec_reg) 
                    VALUES (2,'".$fila_p['EmployeeId']."','".$fila_p['IdentityCardNumber']."','".$fila_p['Email']."','".$fila_p['FatherSurname']."',
                    '".$fila_p['MotherSurname']."','".$fila_p['FirstName']."',
                    '".$fila_p['InternalEmployeeId']."', '".addslashes($codigoa)."',NOW())");
        
        $codigoa=$fila_p['InternalEmployeeId']."''C"; 
        $query_ap2 = sqlsrv_query($conexion_vps, "INSERT INTO matriculados_ls (Tipo,Id,Dni,Email,
                    Apellido_Paterno,Apellido_Materno,Nombre, Codigo, Codigoa,fec_reg) 
                    VALUES (2,'".$fila_p['EmployeeId']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['Email']."','".$fila_p['FatherSurname']."',
                    '".$fila_p['MotherSurname']."','".$fila_p['FirstName']."',
                    '".$fila_p['InternalEmployeeId']."','".$codigoa."', getdate())");
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion)); 
    }

?>