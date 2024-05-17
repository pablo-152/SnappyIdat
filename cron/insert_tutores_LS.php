<?php
    include 'conexion.php'; 

    $query_t = mysqli_query($conexion, "TRUNCATE TABLE tutores_ls");

    $query = mysqli_query($conexion, "SELECT GROUP_CONCAT(DISTINCT Id SEPARATOR ',') AS ids FROM todos_ls");

    $get_id = mysqli_fetch_assoc($query);  

    include 'conexion_arpay.php';

    $query_a = sqlsrv_query($conexion_arpay,"SELECT gu.Id,gu.StudentClientId,pe.FatherSurname AS Apellido_Paterno,pe.MotherSurname AS Apellido_Materno,
                pe.FirstName AS Nombre,pe.IdentityCardNumber AS Dni,pe.Email,pe.MobilePhone AS Celular,FORMAT(pe.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,
                gt.Description AS Parentesco
                FROM Guardian gu
                LEFT JOIN Person pe ON pe.Id=PersonId
                LEFT JOIN GuardianTypeTranslation gt ON gt.GuardianTypeId=gu.Kinship AND gt.Language='es-PE'
                WHERE gu.StudentClientId IN (".$get_id['ids'].")");

    while( $fila = sqlsrv_fetch_array( $query_a, SQLSRV_FETCH_ASSOC) ) {
        $query_i = mysqli_query($conexion, "INSERT INTO tutores_ls (Id_Tutor,Id_Alumno,Apellido_Paterno,Apellido_Materno,Nombre,Dni,Email,Celular,
                    Fecha_Cumpleanos,Parentesco)
                    VALUES ('".$fila['Id']."','".$fila['StudentClientId']."','".$fila['Apellido_Paterno']."','".$fila['Apellido_Materno']."',
                    '".$fila['Nombre']."','".$fila['Dni']."','".$fila['Email']."','".$fila['Celular']."','".$fila['Fecha_Cumpleanos']."',
                    '".$fila['Parentesco']."')");
    }
    
    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>