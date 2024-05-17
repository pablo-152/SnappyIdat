<?php
    include 'conexion.php';

    $anio_actual = date('Y');

    $query_p = mysqli_query($conexion,"SELECT Id FROM producto_arpay_fv WHERE anio=$anio_actual ORDER BY id_producto ASC");

    include 'conexion_arpay.php';

    while( $fila = mysqli_fetch_assoc( $query_p ) ) {
        $id_producto = $fila['Id'];

        $query_pendiente = sqlsrv_query($conexion_arpay,"SELECT cli.InternalStudentId AS 'InternalStudentId',p.FirstName,
                            p.FatherSurname,p.MotherSurname,prod.Name AS 'ProductName',cppr.Description AS 'Description',
                            (ISNULL(cppr.Cost,0)-ISNULL(cppr.TotalDiscount,0)) AS Total,
                            ucg.Name as Grupo,(SELECT TOP 1 tuc.Name FROM University.StudentMatriculation stm
                            LEFT JOIN University.TeachingUnitClass tuc ON tuc.Id=stm.TeachingUnitClassId
                            WHERE stm.ClientId=cli.Id AND stm.TeachingUnitClassId IS NOT NULL ORDER BY stm.Id DESC) AS Seccion,
                            CASE WHEN sms.ActiveMatriculation = 1 THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 5 AND Language = 'es-PE')  
                            WHEN cli.StudentStatusId IS NULL AND sm.Id IS NULL THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 4 AND Language = 'es-PE')  
                            ELSE cst.[Description] END AS StudentStatus,FORMAT(cppr.PaymentDueDate,'yyyy-MM-dd') AS PaymentDueDate
                            FROM ClientProductPurchaseRegistry cppr
                            inner join Client cli on cppr.ClientId = cli.Id
                            inner join Person p on cli.PersonId = p.Id
                            inner join EnterpriseHeadquarter eh on cli.EnterpriseHeadquarterId = eh.Id
                            inner join Headquarter he on eh.HeadquarterId = he.Id
                            inner join Product prod on cppr.ProductId = prod.Id
                            inner join ProductItem prodItem on cppr.ProductItemId = prodItem.Id
                            inner join PaymentStatusTranslation pst on cppr.PaymentStatusId = pst.PaymentStatusId AND pst.[Language] = 'es-PE'
                            left join University.CareerGroup ucg on ucg.id=cli.CareerGroupId 
                            JOIN University.StudentMatriculation sm ON sm.Id = (SELECT TOP 1 Id FROM University.StudentMatriculation WHERE ClientId = cli.Id ORDER BY Id DESC)
                            LEFT JOIN StudentStatusTranslation cst ON cst.StudentStatusId = cli.StudentStatusId  
                            JOIN University.StudentMatriculationStatus sms ON sms.Id = sm.StudentMatriculationStatusId  
                            WHERE cppr.ProductId = $id_producto AND cppr.PaymentStatusId = 2
                            ORDER BY p.FatherSurname ASC,p.MotherSurname ASC,p.FirstName ASC");

        while( $fila_pendiente = sqlsrv_fetch_array( $query_pendiente, SQLSRV_FETCH_ASSOC) ) {
            $query_pe = mysqli_query($conexion, "INSERT INTO pago_arpay_fv (id_producto,Tipo,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Grupo,
                    Seccion,Producto,Descripcion,Total,Fecha_Vencimiento,Estado) 
                    VALUES ($id_producto,2,'".$fila_pendiente['FatherSurname']."','".$fila_pendiente['MotherSurname']."','".$fila_pendiente['FirstName']."',
                    '".$fila_pendiente['InternalStudentId']."','".$fila_pendiente['Grupo']."','".$fila_pendiente['Seccion']."',
                    '".$fila_pendiente['ProductName']."','".$fila_pendiente['Description']."','".$fila_pendiente['Total']."',
                    '".$fila_pendiente['PaymentDueDate']."','".$fila_pendiente['StudentStatus']."')");
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>