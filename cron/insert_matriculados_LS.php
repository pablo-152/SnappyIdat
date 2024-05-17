<?php
    include 'conexion_arpay.php';
    include 'conexion.php';
    include 'conexion_vps.php';

    $query_c = sqlsrv_query($conexion_arpay,"SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombre,
                per.IdentityCardNumber AS Dni,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
                END AS Codigo,per.Email,Grado=ISNULL(cgt.Description, ''),
                CASE WHEN cc.Name IS NULL THEN '' WHEN mat.StatusId IN (2,3,4,6,7) THEN '' ELSE cc.Name END AS Seccion,
                CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name 
                FROM Matriculation oldMat  
                JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
                JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId   
                WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), '') ELSE c.Name END AS 'Curso',ISNULL(cc.Name, '') AS 'Clase',
                mst.Description AS Matricula,sst.Description AS Alumno,
                (SELECT COUNT(*) FROM ClientProductPurchaseRegistry cp 
                WHERE cp.ClientId=cli.Id AND cp.PaymentStatusId=2 AND cp.PaymentDueDate<=GETDATE()) AS Pago_Pendiente,
                (SELECT COUNT(*) FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cli.Id AND cp.Description='Matricula' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2023) AS Pago_Matricula,
                (SELECT COUNT(*) FROM ClientProductPurchaseRegistry cp
                LEFT JOIN Product pr ON pr.Id=cp.ProductId
                WHERE cp.ClientId=cli.Id AND cp.Description='Cuota de Ingreso' AND cp.PaymentStatusId=1 AND pr.SchoolYear=2023) AS Pago_Cuota_Ingreso,
                (SELECT TOP 1 sd.DocumentFilePath FROM Student.StudentDocument sd 
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=c.Id AND sd.Name='DNI (Alumno/a)'
                ORDER BY sd.Id DESC) AS Documento_Dni,
                (SELECT TOP 1 sd.DocumentFilePath FROM Student.StudentDocument sd
                LEFT JOIN AspNetUsers au ON au.Id=sd.DeliveredBy
                WHERE sd.ClientId=c.Id AND sd.Name='1 Foto digital'
                ORDER BY sd.Id DESC) AS Documento_Foto,
                (SELECT COUNT(*) FROM ClientProductPurchaseRegistry cp 
                WHERE cp.Description IN ('Fotocheck') AND cp.PaymentStatusId=1 AND cp.ClientId=c.Id) AS Fotocheck
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
                LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                WHERE cli.EnterpriseHeadquarterId = 5 AND cli.InternalStudentId IS NOT NULL
                ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId");

    $query_t = mysqli_query($conexion, "DELETE FROM matriculados_ls WHERE Tipo IN (1,2)"); 
    $query_t2 = sqlsrv_query($conexion_vps, "DELETE FROM matriculados_ls WHERE Tipo IN (1,2)"); 

    while( $fila = sqlsrv_fetch_array( $query_c, SQLSRV_FETCH_ASSOC) ) {
        if($fila['Alumno']=="Matriculado"){
            $query_ap = mysqli_query($conexion, "INSERT INTO matriculados_ls (Tipo,Id,Dni,Email,
                        Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Codigoa,Grado,Seccion,Curso,Clase,
                        Matricula,Alumno,Pago_Pendiente,Pago_Matricula,Pago_Cuota_Ingreso,fec_reg) 
                        VALUES (1,'".$fila['Id']."','".$fila['Dni']."','".$fila['Email']."',
                        '".$fila['Apellido_Paterno']."', '".$fila['Apellido_Materno']."','".$fila['Nombre']."',
                        '".$fila['Codigo']."','".$fila['Codigo']."','".$fila['Grado']."','".$fila['Seccion']."',
                        '".$fila['Curso']."','".$fila['Clase']."','".$fila['Matricula']."','".$fila['Alumno']."',
                        '".$fila['Pago_Pendiente']."','".$fila['Pago_Matricula']."',
                        '".$fila['Pago_Cuota_Ingreso']."',NOW())");

            $query_ap2 = sqlsrv_query($conexion_vps, "INSERT INTO matriculados_ls (Tipo,Id,Dni,Email,
                        Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Codigoa,Grado,Seccion,Curso,Clase,
                        Matricula,Alumno,Pago_Pendiente,Pago_Matricula,Pago_Cuota_Ingreso,fec_reg) 
                        VALUES (1,'".$fila['Id']."','".$fila['Dni']."','".$fila['Email']."',
                        '".$fila['Apellido_Paterno']."', '".$fila['Apellido_Materno']."','".$fila['Nombre']."',
                        '".$fila['Codigo']."','".$fila['Codigo']."','".$fila['Grado']."','".$fila['Seccion']."',
                        '".$fila['Curso']."','".$fila['Clase']."','".$fila['Matricula']."','".$fila['Alumno']."',
                        '".$fila['Pago_Pendiente']."','".$fila['Pago_Matricula']."',
                        '".$fila['Pago_Cuota_Ingreso']."', getdate())");
        }

        /*$comercial = mysqli_query($conexion, "SELECT id_registro FROM registro_mail 
                    WHERE id_empresa=4 AND dni='".$fila['IdentityCardNumber']."' 
                    ORDER BY id_registro DESC");
        $dato_comercial = mysqli_fetch_assoc($comercial);
        $total_comercial = mysqli_num_rows($comercial);

        if($total_comercial>0){
            $valida_historico = mysqli_query($conexion, "SELECT id_historial FROM historial_registro_mail 
                                WHERE id_registro='".$dato_comercial['id_registro']."' AND id_accion=13 AND estado=15");
            $total_valida_historico = mysqli_num_rows($valida_historico);
            if($total_valida_historico==0){
                $historico = mysqli_query($conexion, "SELECT comentario FROM historial_registro_mail 
                            WHERE id_registro='".$dato_comercial['id_registro']."' ORDER BY id_historial DESC");
                $dato_historico = mysqli_fetch_assoc($historico);
                $query_h = mysqli_query($conexion, "INSERT INTO historial_registro_mail (id_registro,comentario,id_accion,fecha_accion,estado,fec_reg,user_reg) 
                            VALUES ('".$dato_comercial['id_registro']."','".$dato_historico['comentario']."',13,NOW(),15,NOW(),0)");
            }
        }*/
    }
?>