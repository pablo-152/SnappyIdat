<?php
    include 'conexion_arpay.php';

    $query_c = sqlsrv_query($conexion_arpay,"SELECT cli.Id,per.IdentityCardNumber,per.Email,CASE WHEN cli.InternalStudentId IS NULL THEN NULL 
                ELSE CONCAT('', cli.InternalStudentId) END AS InternalStudentId,per.FatherSurname,
                per.MotherSurname,per.FirstName,'CourseGrade'=ISNULL(cgt.Description, 'N/D'),
                CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name FROM Matriculation oldMat  
                JOIN ProductItem oldPI ON oldPI.Id=oldMat.ProductItemId  
                JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
                WHERE ClientId=cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',sst.Description AS 'StudentStatus',
                ISNULL(cc.Name, 'N/D') AS 'Class','YEAR'=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
                mst.Description AS 'CourseMatriculationStatus'
                FROM Client cli  
                JOIN Person per ON per.Id = cli.PersonId  
                LEFT JOIN Matriculation mat ON mat.ClientId=cli.Id AND mat.Id=(SELECT TOP 1 Id FROM Matriculation 
                WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.[Language]='es-PE'  
                LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                LEFT JOIN Course c ON c.Id = pi.CourseId  
                LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId=c.CourseGradeId AND cgt.[Language]='es-PE'  
                LEFT JOIN CourseClassStudent ccs ON ccs.Id=(SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND   
                ccs2.StudentClientId = mat.ClientId ORDER BY ccs2.Id DESC)  
                LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                WHERE cli.EnterpriseHeadquarterId = 10 AND cli.InternalStudentId IS NOT NULL  
                ORDER BY per.FatherSurname, per.MotherSurname, per.FirstName, cli.InternalStudentId");

    include 'conexion.php';

    $query_t = mysqli_query($conexion, "TRUNCATE TABLE matriculados_l14");

    while( $fila = sqlsrv_fetch_array( $query_c, SQLSRV_FETCH_ASSOC) ) {
        if($fila['StudentStatus']=="Matriculado" && $fila['YEAR']!="N/D" && $fila['CourseMatriculationStatus']!="Anulada"){
            $query_a = mysqli_query($conexion, "INSERT INTO matriculados_l14 (Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
                        Codigo,Especialidad,Curso,Seccion,Matricula,Alumno,Anio) 
                        VALUES ('".$fila['Id']."','".$fila['IdentityCardNumber']."','".$fila['Email']."',
                        '".$fila['FatherSurname']."','".$fila['MotherSurname']."',
                        '".$fila['FirstName']."','".$fila['InternalStudentId']."',
                        '".$fila['CourseGrade']."','".$fila['Course']."','".$fila['Class']."',
                        '".$fila['CourseMatriculationStatus']."','".$fila['StudentStatus']."',
                        '".$fila['YEAR']."')");
        }

        $comercial = mysqli_query($conexion, "SELECT id_registro FROM registro_mail WHERE id_empresa=6 AND dni='".$fila['IdentityCardNumber']."' ORDER BY id_registro DESC");
        $dato_comercial = mysqli_fetch_assoc($comercial);
        $total_comercial = mysqli_num_rows($comercial);

        if($total_comercial>0){
            $valida_historico = mysqli_query($conexion, "SELECT id_historial FROM historial_registro_mail WHERE id_registro='".$dato_comercial['id_registro']."' AND id_accion=13 AND estado=15");
            $total_valida_historico = mysqli_num_rows($valida_historico);
            if($total_valida_historico==0){
                $historico = mysqli_query($conexion, "SELECT comentario FROM historial_registro_mail WHERE id_registro='".$dato_comercial['id_registro']."' ORDER BY id_historial DESC");
                $dato_historico = mysqli_fetch_assoc($historico);
                $query_h = mysqli_query($conexion, "INSERT INTO historial_registro_mail (id_registro,comentario,id_accion,fecha_accion,estado,fec_reg,user_reg) 
                            VALUES ('".$dato_comercial['id_registro']."','".$dato_historico['comentario']."',13,NOW(),15,NOW(),0)");
            }
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>