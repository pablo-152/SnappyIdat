<?php 
    include 'conexion.php';
    include 'conexion_arpay.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $query_d = mysqli_query($conexion, "SELECT * FROM documento_firma WHERE id_empresa=6");  

    while ($fila = mysqli_fetch_assoc($query_d)) { 
        $query_a = sqlsrv_query($conexion_arpay,"SELECT ca.ClientId AS Id,ca.Id AS Codigo,pe.FatherSurname AS Apellido_Paterno,pe.MotherSurname AS Apellido_Materno,
                    pe.FirstName AS Nombre,pe.Email,FORMAT(pe.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,pe.MobilePhone AS Celular,
                    pe.IdentityCardNumber AS Dni,ct.Description AS Especialidad,cg.Name AS Grupo,st.Description AS Turno
                    FROM University.CareerApplication ca
                    LEFT JOIN Client cl ON cl.Id=ca.ClientId
                    LEFT JOIN Person pe ON pe.Id=cl.PersonId
                    LEFT JOIN University.CareerTranslation ct ON ct.CareerId=ca.CareerId
                    LEFT JOIN University.CareerGroup cg ON cg.Id=ca.CareerGroupId
                    LEFT JOIN University.ShiftTranslation st ON st.ShiftId=ca.ShiftId
                    WHERE ca.ClientId=".$fila['id_alumno']."");

        $get_alumno = sqlsrv_fetch_array($query_a,SQLSRV_FETCH_ASSOC);

        $update = mysqli_query($conexion, "UPDATE documento_firma SET cod_alumno='".$get_alumno['Codigo']."',apater_alumno='".$get_alumno['Apellido_Paterno']."',
                    amater_alumno='".$get_alumno['Apellido_Materno']."',nom_alumno='".$get_alumno['Nombre']."',email_alumno='".$get_alumno['Email']."',
                    celular_alumno='".$get_alumno['Celular']."',grupo_alumno='".$get_alumno['Grupo']."',especialidad_alumno='".$get_alumno['Especialidad']."',
                    turno_alumno='".$get_alumno['Turno']."'
                    WHERE id_documento_firma=".$fila['id_documento_firma']."");
    }
?>