<?php
    include 'conexion.php';

    $anio_actual = date('Y');

    $query_t = mysqli_query($conexion, "DELETE FROM pago_arpay_fv WHERE id_producto IN (SELECT Id FROM producto_arpay_fv WHERE anio=$anio_actual)");

    $StartDate = $anio_actual."-01-01";
    $EndDate = $anio_actual."-12-31";

    $query_p = mysqli_query($conexion,"SELECT Id FROM producto_arpay_fv WHERE anio=$anio_actual ORDER BY id_producto ASC");

    include 'conexion_arpay.php';

    while( $fila = mysqli_fetch_assoc( $query_p ) ) {
        $id_producto = $fila['Id'];

        $query_cancelado = sqlsrv_query($conexion_arpay,"SELECT cli.InternalStudentId AS 'InternalStudentId',
                            p.FirstName,p.FatherSurname,p.MotherSurname,prod.Name AS 'ProductName',
                            cppr.Description AS 'Description',ISNULL(cppr.Cost,0) AS Cost,ISNULL(cppr.TotalDiscount,0) AS TotalDiscount,
                            ISNULL(cppr.PenaltyAmountPaid,0) AS PenaltyAmountPaid,FORMAT(cppr.PaymentDate,'yyyy-MM-dd') AS PaymentDate,
                            'ElectronicReceiptNumber' = CASE WHEN cppr.ManualReceiptSerieId IS NOT NULL THEN 
                            (SELECT TOP 1 CONCAT(  
                            LEFT(purchaseSerie.CBT,   
                            LEN(purchaseSerie.CBT)-2),'/',   
                            RIGHT(purchaseSerie.CBT, LEN(purchaseSerie.CBT)-2),   
                            ' '+purchaseSerie.Letter+' ', purchaseReceipt.ReceiptNumber)   
                            FROM ClientProductPurchaseRegistry purchase  
                            JOIN ManualRegistryReceiptSerie purchaseSerie ON purchaseSerie.Id = purchase.ManualReceiptSerieId  
                            JOIN ManualReceipt purchaseReceipt ON purchaseReceipt.Id = purchase.ManualReceiptId  
                            WHERE purchase.ManualReceiptSerieId = cppr.ManualReceiptSerieId  
                            AND purchase.ManualReceiptId = cppr.ManualReceiptId)  
                            ELSE cppr.ElectronicReceiptNumber END,(ISNULL(cppr.Cost,0)+ISNULL(cppr.PenaltyAmountPaid,0)-ISNULL(cppr.TotalDiscount,0)) AS Total,
                            ucg.Name as Grupo,(SELECT TOP 1 tuc.Name FROM University.StudentMatriculation stm
                            LEFT JOIN University.TeachingUnitClass tuc ON tuc.Id=stm.TeachingUnitClassId
                            WHERE stm.ClientId=cli.Id AND stm.TeachingUnitClassId IS NOT NULL ORDER BY stm.Id DESC) AS Seccion,
                            CASE WHEN sms.ActiveMatriculation = 1 THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 5 AND Language = 'es-PE')  
                            WHEN cli.StudentStatusId IS NULL AND sm.Id IS NULL THEN (SELECT Description FROM StudentStatusTranslation WHERE StudentStatusId = 4 AND Language = 'es-PE')  
                            ELSE cst.[Description] END AS StudentStatus,FORMAT(cppr.PurchaseDate,'yyyy-MM-dd') AS PurchaseDate
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
                            WHERE cppr.ProductId = $id_producto AND cppr.PaymentStatusId IN (1,4) AND 
                            cppr.PaymentDate BETWEEN '$StartDate' AND '$EndDate'
                            ORDER BY p.FatherSurname ASC,p.MotherSurname ASC,p.FirstName ASC");

        while( $fila_cancelado = sqlsrv_fetch_array( $query_cancelado, SQLSRV_FETCH_ASSOC) ) {
            $query_ca = mysqli_query($conexion, "INSERT INTO pago_arpay_fv (id_producto,Tipo,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Grupo,
                    Seccion,Producto,Descripcion,Monto,Descuento,Penalidad,Total,Fecha_Pago,Fecha_Vencimiento,Recibo,Estado) 
                    VALUES ($id_producto,1,'".$fila_cancelado['FatherSurname']."','".$fila_cancelado['MotherSurname']."','".$fila_cancelado['FirstName']."',
                    '".$fila_cancelado['InternalStudentId']."','".$fila_cancelado['Grupo']."','".$fila_cancelado['Seccion']."',
                    '".$fila_cancelado['ProductName']."','".$fila_cancelado['Description']."','".$fila_cancelado['Cost']."',
                    '".$fila_cancelado['TotalDiscount']."','".$fila_cancelado['PenaltyAmountPaid']."','".$fila_cancelado['Total']."',
                    '".$fila_cancelado['PaymentDate']."','".$fila_cancelado['PurchaseDate']."','".$fila_cancelado['ElectronicReceiptNumber']."',
                    '".$fila_cancelado['StudentStatus']."')");
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>