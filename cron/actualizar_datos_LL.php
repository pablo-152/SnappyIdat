<?php 
    include 'conexion.php';
    include 'conexion_arpay.php';

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }

    $query_d = mysqli_query($conexion, "SELECT * FROM documento_firma WHERE id_empresa=2"); 

    while ($fila = mysqli_fetch_assoc($query_d)) { 
        $query_apoderado = sqlsrv_query($conexion_arpay,"SELECT pe.FatherSurname AS Apellido_Paterno,pe.MotherSurname AS Apellido_Materno,
                            pe.FirstName AS Nombre,pe.Email,pe.MobilePhone AS Celular,gt.Description AS Parentesco
                            FROM Guardian gu
                            LEFT JOIN Person pe ON pe.Id=PersonId
                            LEFT JOIN GuardianTypeTranslation gt ON gt.GuardianTypeId=gu.Kinship AND gt.Language='es-PE'
                            WHERE gu.Id=".$fila['id_apoderado']);

        $get_apoderado = sqlsrv_fetch_array($query_apoderado,SQLSRV_FETCH_ASSOC);

        $update_apoderado = mysqli_query($conexion, "UPDATE documento_firma SET apater_apoderado='".$get_apoderado['Apellido_Paterno']."',
                            amater_apoderado='".$get_apoderado['Apellido_Materno']."',nom_apoderado='".$get_apoderado['Nombre']."',
                            parentesco_apoderado='".$get_apoderado['Parentesco']."',email_apoderado='".$get_apoderado['Email']."',
                            celular_apoderado='".$get_apoderado['Celular']."'
                            WHERE id_documento_firma=".$fila['id_documento_firma']."");

        $query_alumno = sqlsrv_query($conexion_arpay,"SELECT per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombre,
                        CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) END AS Codigo,
                        Grado=ISNULL(cgt.Description, ''),CASE WHEN cc.Name IS NULL THEN '' WHEN mat.StatusId IN (2,3,4,6,7) THEN '' ELSE cc.Name END AS Seccion
                        FROM Client cli
                        JOIN Person per ON per.Id = cli.PersonId  
                        LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
                        WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                        LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
                        LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                        LEFT JOIN Course c ON c.Id = pi.CourseId  
                        LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
                        LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                        WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
                        ORDER BY ccs2.Id DESC)  
                        LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                        LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                        WHERE cli.Id=".$fila['id_alumno']);

        $get_alumno = sqlsrv_fetch_array($query_alumno,SQLSRV_FETCH_ASSOC);

        $update_alumno = mysqli_query($conexion, "UPDATE documento_firma SET cod_alumno='".$get_alumno['Codigo']."',apater_alumno='".$get_alumno['Apellido_Paterno']."',
                        amater_alumno='".$get_alumno['Apellido_Materno']."',nom_alumno='".$get_alumno['Nombre']."',grado_alumno='".$get_alumno['Grado']."',
                        seccion_alumno='".$get_alumno['Seccion']."'
                        WHERE id_documento_firma=".$fila['id_documento_firma']."");
    }
?>