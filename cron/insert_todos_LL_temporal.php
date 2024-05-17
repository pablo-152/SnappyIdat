<?php
    include 'conexion_arpay.php';

    $query_c = sqlsrv_query($conexion_arpay,"SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombre,
                per.IdentityCardNumber AS Dni,CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
                END AS Codigo,Grado=ISNULL(cgt.Description, 'N/D'),CASE WHEN mat.Id IS NULL THEN ISNULL((SELECT TOP 1 oldCourse.Name 
                FROM Matriculation oldMat   
                JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
                JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
                WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',sst.Description AS Alumno,
                ISNULL(cc.Name, 'N/D') AS 'Class',Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
                (SELECT TOP 1 FORMAT(PurchaseDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry 
                WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                ClientProductPurchaseRegistry.Description='Matricula') AS Fecha_Matricula,(SELECT TOP 1 ap.Name FROM ClientProductPurchaseRegistry
                INNER JOIN AspNetUsers ap ON ap.Id=ClientProductPurchaseRegistry.PurchaseEmployeeId
                WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                ClientProductPurchaseRegistry.Description='Matricula') AS Usuario,FORMAT(per.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,
                CASE WHEN cc.Name IS NULL THEN 'N/D' WHEN mat.StatusId IN (2,3,4,6,7) THEN 'N/D' ELSE cc.Name END AS Seccion,
                mst.Description AS MatriculationStatusName,
                (SELECT COUNT(*) FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.PaymentStatusId=2 AND cp.PaymentDueDate<=GETDATE()) AS Pago_Pendiente,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Matricula' AND cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC) AS Fecha_Pago_Matricula,
                ISNULL((SELECT TOP 1 (ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0)) FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Matricula' AND cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC),0) AS Monto_Matricula,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Cuota de Ingreso' AND cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC) AS Fecha_Pago_Cuota_Ingreso,
                ISNULL((SELECT TOP 1 (ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0)) FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Cuota de Ingreso' AND cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC),0) AS Monto_Cuota_Ingreso,per.Email,per.MobilePhone
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
                WHERE cli.EnterpriseHeadquarterId = 7 AND cli.InternalStudentId IS NOT NULL
                ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId");

    include 'conexion.php';

    $query_t = mysqli_query($conexion, "TRUNCATE TABLE todos_ll_temporal"); 

    while( $fila = sqlsrv_fetch_array( $query_c, SQLSRV_FETCH_ASSOC) ) {
        $query_a = mysqli_query($conexion, "INSERT INTO todos_ll_temporal (Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Dni,Email,Celular,
                    Fecha_Cumpleanos,Grado,Seccion,Curso,Clase,Anio,Fecha_Matricula,Usuario,Matricula,Alumno,Pago_Pendiente,Fecha_Pago_Matricula,
                    Monto_Matricula,Fecha_Pago_Cuota_Ingreso,Monto_Cuota_Ingreso) 
                    VALUES ('".$fila['Id']."','".$fila['Apellido_Paterno']."','".$fila['Apellido_Materno']."','".$fila['Nombre']."',
                    '".$fila['Codigo']."','".$fila['Dni']."','".$fila['Email']."','".$fila['MobilePhone']."','".$fila['Fecha_Cumpleanos']."',
                    '".$fila['Grado']."','".$fila['Seccion']."','".$fila['Course']."','".$fila['Class']."','".$fila['Anio']."',
                    '".$fila['Fecha_Matricula']."','".$fila['Usuario']."','".$fila['MatriculationStatusName']."','".$fila['Alumno']."',
                    '".$fila['Pago_Pendiente']."','".$fila['Fecha_Pago_Matricula']."','".$fila['Monto_Matricula']."',
                    '".$fila['Fecha_Pago_Cuota_Ingreso']."','".$fila['Monto_Cuota_Ingreso']."')");
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>