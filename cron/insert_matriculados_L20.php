<?php
    include 'conexion_arpay.php';
    include 'conexion_vps.php';

    $query_c = sqlsrv_query($conexion_arpay,"SELECT results.Id,results.IdentityCardNumber,results.Email,results.CareerGroupText,results.FirstName,results.MotherSurname,  
                results.FatherSurname,results.InternalStudentId,results.CareerName,results.CareerShifts,results.Module,  
                results.MatriculationStatus,results.StudentStatus,results.Pago_Pendiente,results.Seccion,results.Pago_Matricula_1,results.Pago_Cuota_1
                FROM (SELECT c.Id,p.IdentityCardNumber,p.Email,cg.[Name] AS CareerGroupText,p.FirstName AS FirstName,p.MotherSurname AS MotherSurname,  
                p.FatherSurname AS FatherSurname,c.InternalStudentId AS InternalStudentId,ct.[Description] AS CareerName,    
                (SELECT STRING_AGG(results.Txt, ', ') FROM (SELECT DISTINCT CASE WHEN st.ShiftId = 0 THEN 'MN' WHEN st.ShiftId = 1 THEN 'TR' WHEN st.ShiftId = 2 
                THEN 'NC' ELSE 'ON' END AS Txt  FROM University.StudentMatriculation stuMat  
                JOIN University.TeachingUnitDateShift tuds ON tuds.Id = stuMat.TeachingUnitDateShiftId  
                JOIN University.TeachingUnit teachUnits ON teachUnits.Id = tuds.TeachingUnitId  
                JOIN University.Module module ON module.Id = teachUnits.ModuleId  
                JOIN University.ShiftTranslation st ON st.ShiftId = tuds.ShiftId AND st.[Language] = 'es-PE'  
                WHERE stuMat.ClientId = c.Id AND module.CareerId = m.CareerId AND stuMat.UniversityMatriculationId = sm.UniversityMatriculationId) results) AS CareerShifts,  
                (SELECT CASE WHEN res.Txt IS NULL THEN NULL ELSE CONCAT('M', res.Txt) END  
                FROM (SELECT MAX(module.OrderNumber) AS Txt  
                FROM University.StudentMatriculation stuMat  
                JOIN University.TeachingUnitDateShift tuds ON tuds.Id = stuMat.TeachingUnitDateShiftId   
                JOIN University.TeachingUnit t ON t.Id = tuds.TeachingUnitId  
                JOIN University.Module module ON module.Id = tu.ModuleId  
                WHERE stuMat.ClientId = c.Id AND module.CareerId = m.CareerId) res) AS Module,  
                CASE WHEN EXISTS (SELECT 1 FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = c.Id AND sutMatStat.ActiveMatriculation = 1) THEN 'Asistiendo'  
                WHEN EXISTS (SELECT 1 FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = c.Id AND sutMatStat.ActiveMatriculation = 1) THEN (SELECT TOP 1 sutMatStat.Description FROM University.StudentMatriculation sutMat   
                JOIN University.StudentMatriculationStatus sutMatStat ON sutMatStat.Id = sutMat.StudentMatriculationStatusId   
                WHERE sutMat.ClientId = c.Id AND sutMatStat.ActiveMatriculation = 1)  
                WHEN sm.StudentMatriculationStatusId = 3 THEN sms.Description  
                ELSE 'Retirado' END AS MatriculationStatus,  
                CASE WHEN sms.ActiveMatriculation = 1 THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 5 AND Language = 'es-PE')  
                WHEN c.StudentStatusId IS NULL AND sm.Id IS NULL THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 4 AND Language = 'es-PE')  
                ELSE cst.[Description] END AS StudentStatus,(SELECT COUNT(*) FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=c.Id AND cp.PaymentStatusId=2 AND cp.Description LIKE 'Cuota%' AND cp.PaymentDueDate<=GETDATE()) AS Pago_Pendiente,
                (SELECT TOP 1 tuc.Name FROM University.StudentMatriculation stm
                LEFT JOIN University.TeachingUnitClass tuc ON tuc.Id=stm.TeachingUnitClassId
                WHERE stm.ClientId=c.Id AND stm.TeachingUnitClassId IS NOT NULL ORDER BY stm.Id DESC) AS Seccion,
                ISNULL((SELECT TOP 1 cp.PaymentStatusId FROM ClientProductPurchaseRegistry cp 
                WHERE cp.ClientId=c.Id AND cp.Description='Matricula 1' ORDER BY cp.Id DESC),0) AS Pago_Matricula_1, 
                ISNULL((SELECT TOP 1 cp.PaymentStatusId FROM ClientProductPurchaseRegistry cp 
                WHERE cp.ClientId=c.Id AND cp.Description='Cuota 1' ORDER BY cp.Id DESC),0) AS Pago_Cuota_1 
                FROM Client c  
                JOIN Person p ON p.Id = c.PersonId  
                LEFT JOIN University.CareerGroup cg ON cg.Id = c.CareerGroupId  
                JOIN University.StudentMatriculation sm ON sm.Id = (SELECT TOP 1 modSm.Id FROM University.StudentMatriculation modSm JOIN University.TeachingUnitDateShift modTuds ON modTuds.Id = modSm.TeachingUnitDateShiftId JOIN University.TeachingUnit modTu
                ON modTu.Id = modTuds.TeachingUnitId JOIN University.Module modModule ON modModule.Id = modTu.ModuleId WHERE modSm.ClientId = c.Id ORDER BY modModule.OrderNumber DESC, modSm.Id DESC) 
                LEFT JOIN University.TeachingUnitDateShift tudf ON tudf.Id = sm.TeachingUnitDateShiftId  
                LEFT JOIN University.TeachingUnit tu ON tu.Id = tudf.TeachingUnitId  
                LEFT JOIN University.Module m ON m.Id = tu.ModuleId  
                LEFT JOIN University.CareerTranslation ct ON ct.CareerId = m.CareerId  
                LEFT JOIN StudentStatusTranslation cst ON cst.StudentStatusId = c.StudentStatusId  
                JOIN University.StudentMatriculationStatus sms ON sms.Id = sm.StudentMatriculationStatusId  
                WHERE c.EnterpriseHeadquarterId = 10 AND ct.[Language] = 'es-PE' AND ct.Description NOT LIKE '%L14%' AND
                (c.StatusId IS NULL OR c.StatusId <> 2 OR '' = 1)) results  
                LEFT JOIN Student.StudentDocument sd ON sd.ClientId = results.Id  
                GROUP BY results.Id,results.IdentityCardNumber,results.Email,results.CareerGroupText,results.FirstName,results.MotherSurname,results.FatherSurname,  
                results.InternalStudentId,results.CareerName,results.CareerShifts,results.Module,results.MatriculationStatus,
                results.StudentStatus,results.Pago_Pendiente,results.Seccion,results.Pago_Matricula_1,results.Pago_Cuota_1
                ORDER BY results.FatherSurname ASC, results.MotherSurname ASC, results.FirstName ASC"); 

    include 'conexion.php';

    $query_t = mysqli_query($conexion, "DELETE FROM matriculados_l20 WHERE Tipo IN (1,2)");
    $query_t1 = sqlsrv_query($conexion_vps, "DELETE FROM matriculados_l20 WHERE Tipo IN (1,2)");

    while( $fila = sqlsrv_fetch_array( $query_c, SQLSRV_FETCH_ASSOC) ) {
        if($fila['MatriculationStatus']=="Asistiendo" && $fila['StudentStatus']=="Matriculado"){
            $query_a = mysqli_query($conexion, "INSERT INTO matriculados_l20 (Tipo,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
                        Codigo,Codigoa,Grupo,Especialidad,Turno,Modulo,Seccion,Matricula,Alumno,Pago_Pendiente,Pago_Matricula_1,Pago_Cuota_1) 
                        VALUES (1,'".$fila['Id']."','".$fila['IdentityCardNumber']."','".$fila['Email']."','".$fila['FatherSurname']."',
                        '".$fila['MotherSurname']."','".$fila['FirstName']."','".$fila['InternalStudentId']."','".$fila['InternalStudentId']."',
                        '".$fila['CareerGroupText']."','".substr($fila['CareerName'],0,-6)."','".$fila['CareerShifts']."','".$fila['Module']."',
                        '".$fila['Seccion']."','".$fila['MatriculationStatus']."','".$fila['StudentStatus']."','".$fila['Pago_Pendiente']."',
                        '".$fila['Pago_Matricula_1']."','".$fila['Pago_Cuota_1']."')");

            $query_a1 = sqlsrv_query($conexion_vps, "INSERT INTO matriculados_l20 (Tipo,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
                        Codigo,Codigoa,Grupo,Especialidad,Turno,Modulo,Seccion,Matricula,Alumno,Pago_Pendiente,Pago_Matricula_1,Pago_Cuota_1) 
                        VALUES (1,'".$fila['Id']."','".$fila['IdentityCardNumber']."','".$fila['Email']."','".$fila['FatherSurname']."',
                        '".$fila['MotherSurname']."','".$fila['FirstName']."','".$fila['InternalStudentId']."','".$fila['InternalStudentId']."',
                        '".$fila['CareerGroupText']."','".substr($fila['CareerName'],0,-6)."','".$fila['CareerShifts']."','".$fila['Module']."',
                        '".$fila['Seccion']."','".$fila['MatriculationStatus']."','".$fila['StudentStatus']."','".$fila['Pago_Pendiente']."',
                        '".$fila['Pago_Matricula_1']."','".$fila['Pago_Cuota_1']."')");
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>