<?php
    include 'conexion_arpay.php';
 
    $query_p = sqlsrv_query($conexion_arpay,"SELECT ca.ClientId,pe.FatherSurname AS Apellido_Paterno,pe.MotherSurname AS Apellido_Materno, 
                pe.FirstName AS Nombre,cl.InternalStudentId AS Codigo,ct.Description AS Especialidad,cg.Name AS Grupo,
                (SELECT STRING_AGG(results.Txt, ', ') FROM (SELECT DISTINCT CASE WHEN st.ShiftId = 0 THEN 'MN' WHEN st.ShiftId = 1 THEN 'TR' WHEN st.ShiftId = 2 
                THEN 'NC' ELSE 'ON' END AS Txt  FROM University.StudentMatriculation stuMat  
                JOIN University.TeachingUnitDateShift tuds ON tuds.Id = stuMat.TeachingUnitDateShiftId
                JOIN University.TeachingUnit teachUnits ON teachUnits.Id = tuds.TeachingUnitId
                JOIN University.Module module ON module.Id = teachUnits.ModuleId  
                JOIN University.ShiftTranslation st ON st.ShiftId = tuds.ShiftId AND st.[Language] = 'es-PE'  
                WHERE stuMat.ClientId = ca.ClientId AND module.CareerId = m.CareerId AND stuMat.UniversityMatriculationId = sm.UniversityMatriculationId) results) AS CareerShifts,
                CASE WHEN EXISTS (SELECT 1 FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = ca.ClientId AND sutMatStat.ActiveMatriculation = 1) THEN 'Asistiendo'  
                WHEN EXISTS (SELECT 1 FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = ca.ClientId AND sutMatStat.ActiveMatriculation = 1) THEN (SELECT TOP 1 sutMatStat.Description FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = ca.ClientId AND sutMatStat.ActiveMatriculation = 1)  
                WHEN sm.StudentMatriculationStatusId = 3 THEN sms.Description  
                ELSE 'Retirado' END AS Matricula,
                CASE WHEN sms.ActiveMatriculation = 1 THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 5 AND Language = 'es-PE')  
                WHEN cl.StudentStatusId IS NULL AND sm.Id IS NULL THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 4 AND Language = 'es-PE')  
                ELSE cst.Description END AS Alumno,pe.Email,pe.MobilePhone,FORMAT(pe.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,
                (SELECT TOP 1 pa.Description FROM ClientProductPurchaseRegistry cp 
                LEFT JOIN PaymentStatusTranslation pa ON pa.PaymentStatusId=cp.PaymentStatusId
                WHERE cp.ClientId=ca.ClientId AND cp.Description='Matricula 1' AND cp.PaymentStatusId IN (1) ORDER BY cp.Id DESC) AS Estado_Matricula,
                ISNULL((SELECT TOP 1 ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0) FROM ClientProductPurchaseRegistry cp 
                WHERE cp.ClientId=ca.ClientId AND cp.Description='Matricula 1' AND cp.PaymentStatusId IN (1) ORDER BY cp.Id DESC),0) AS Monto_Matricula,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp 
                WHERE cp.ClientId=ca.ClientId AND cp.Description='Matricula 1' AND cp.PaymentStatusId IN (1) ORDER BY cp.Id DESC) AS Fecha_Matricula,
                (SELECT TOP 1 pa.Description FROM ClientProductPurchaseRegistry cp 
                LEFT JOIN PaymentStatusTranslation pa ON pa.PaymentStatusId=cp.PaymentStatusId
                WHERE cp.ClientId=ca.ClientId AND cp.Description='Cuota 1' AND cp.PaymentStatusId IN (1) ORDER BY cp.Id DESC) AS Estado_Cuota_1,
                ISNULL((SELECT TOP 1 ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0) FROM ClientProductPurchaseRegistry cp 
                WHERE cp.ClientId=ca.ClientId AND cp.Description='Cuota 1' AND cp.PaymentStatusId IN (1) ORDER BY cp.Id DESC),0) AS Monto_Cuota_1,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp 
                WHERE cp.ClientId=ca.ClientId AND cp.Description='Cuota 1' AND cp.PaymentStatusId IN (1) ORDER BY cp.Id DESC) AS Fecha_Cuota_1
                FROM University.CareerApplication ca
                LEFT JOIN Client cl ON cl.Id=ca.ClientId 
                LEFT JOIN Person pe ON pe.Id=cl.PersonId
                LEFT JOIN University.CareerGroup cg ON cg.Id = cl.CareerGroupId  
                JOIN University.StudentMatriculation sm ON sm.Id = (SELECT TOP 1 Id FROM University.StudentMatriculation WHERE ClientId = ca.ClientId ORDER BY Id DESC)  
                LEFT JOIN University.TeachingUnitDateShift tudf ON tudf.Id = sm.TeachingUnitDateShiftId  
                LEFT JOIN University.TeachingUnit tu ON tu.Id = tudf.TeachingUnitId  
                LEFT JOIN University.Module m ON m.Id = tu.ModuleId  
                LEFT JOIN University.CareerTranslation ct ON ct.CareerId = m.CareerId  
                LEFT JOIN StudentStatusTranslation cst ON cst.StudentStatusId = cl.StudentStatusId  
                JOIN University.StudentMatriculationStatus sms ON sms.Id = sm.StudentMatriculationStatusId  
                WHERE ca.Id IN (SELECT MAX(Id) FROM University.CareerApplication WHERE ApprovalStatusId=1 GROUP BY ClientId)
                ORDER BY pe.FatherSurname ASC,pe.MotherSurname ASC,pe.FirstName ASC"); 

    include 'conexion.php'; 

    $query_t = mysqli_query($conexion, "TRUNCATE TABLE alumno_admision_fv"); 

    while( $fila = sqlsrv_fetch_array( $query_p, SQLSRV_FETCH_ASSOC) ) { 
        if(($fila['Matricula']=='Asistiendo' || $fila['Matricula']=='Promovido') && $fila['Alumno']=='Matriculado' && $fila['Estado_Matricula']=='Cancelado'){
            $insert = mysqli_query($conexion, "INSERT INTO alumno_admision_fv (ClientId,Apellido_Paterno,Apellido_Materno,Nombre,
                        Codigo,Especialidad,Grupo,Turno,Matricula,Alumno,Email,Celular,Fecha_Cumpleanos,Fecha_Matricula,
                        Monto_Matricula,Estado_Matricula,Fecha_Cuota_1,Monto_Cuota_1,Estado_Cuota_1) 
                        VALUES ('".$fila['ClientId']."','".$fila['Apellido_Paterno']."','".$fila['Apellido_Materno']."',
                        '".$fila['Nombre']."','".$fila['Codigo']."','".substr($fila['Especialidad'],0,-6)."','".$fila['Grupo']."',
                        '".$fila['CareerShifts']."','".$fila['Matricula']."','".$fila['Alumno']."','".$fila['Email']."',
                        '".$fila['MobilePhone']."','".$fila['Fecha_Cumpleanos']."','".$fila['Fecha_Matricula']."',
                        '".$fila['Monto_Matricula']."','".$fila['Estado_Matricula']."','".$fila['Fecha_Cuota_1']."',
                        '".$fila['Monto_Cuota_1']."','".$fila['Estado_Cuota_1']."')");
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>