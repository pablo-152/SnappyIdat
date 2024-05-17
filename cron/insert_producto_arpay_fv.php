<?php
    include 'conexion_arpay.php';

    $anio_actual = date('Y');
    $StartDate = "$anio_actual-01-01";
    $EndDate = "$anio_actual-12-31";
    $EnterpriseHeadquarterId = 10;

    $query_p = sqlsrv_query($conexion_arpay,"SELECT t1.Id AS ProductId,t1.SchoolYear AS SchoolYear,t1.Name AS Name,SUM(t1.TotalPeopleToBePaid) AS 'TotalPeopleToBePaid',   
                SUM(t1.TotalToBePaid) AS 'TotalToBePaid',SUM(t1.TotalPeoplePaid) AS 'TotalPeoplePaid',SUM(t1.Cost) AS Cost,  
                SUM(t1.Discount) AS Discount,SUM(t1.PenaltyAmountPaid) AS PenaltyAmountPaid,SUM(t1.TotalPaid) AS TotalPaid,t1.Estado
                FROM 
                (SELECT prod.Id,prod.SchoolYear,prod.Name,0 AS TotalPeopleToBePaid,0 AS TotalToBePaid,0 AS TotalPeoplePaid,   
                SUM(ISNULL(cppr.Cost,0)) AS Cost,SUM(ISNULL(cppr.TotalDiscount,0)) AS Discount,
                SUM(ISNULL(cppr.PenaltyAmountPaid,0)) AS PenaltyAmountPaid,SUM(cppr.Cost - ISNULL(cppr.TotalDiscount,0) + ISNULL(cppr.PenaltyAmountPaid,0)) as TotalPaid,
                st.Description AS Estado  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                LEFT JOIN StatusTranslation st ON st.StatusId=prod.StatusId 
                WHERE cppr.PaymentStatusId IN (1,4) AND prod.EnterpriseHeadquarterId = $EnterpriseHeadquarterId AND cppr.PaymentDate >= '$StartDate' AND  
                cppr.PaymentDate <= '$EndDate'  
                GROUP BY prod.Id, prod.SchoolYear, prod.Name, st.Description  
                UNION ALL  
                SELECT prod.Id,prod.SchoolYear,prod.Name, 0 AS TotalPeopleToBePaid,0 AS TotalToBePaid,Count(prod.Id) AS TotalPeoplePaid,   
                0 AS Cost,0 AS Discount,0 AS PenaltyAmountPaid,0 AS TotalPaid,st.Description AS Estado 
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                LEFT JOIN StatusTranslation st ON st.StatusId=prod.StatusId 
                WHERE cppr.PaymentStatusId IN (1,4) AND prod.EnterpriseHeadquarterId = $EnterpriseHeadquarterId AND cppr.PaymentDate >= '$StartDate' AND  
                cppr.PaymentDate <= '$EndDate'  
                GROUP BY prod.Id, prod.SchoolYear, prod.Name, st.Description  
                UNION ALL  
                SELECT prod1.Id,prod1.SchoolYear,prod1.Name,0 AS TotalPeopleToBePaid,SUM(cppr1.Cost) AS TotalToBePaid,0 AS TotalPeoplePaid,   
                0 AS Cost,0 AS Discount,0 AS PenaltyAmountPaid,0 as TotalPaid,st.Description AS Estado
                FROM ClientProductPurchaseRegistry cppr1  
                JOIN Product prod1 ON prod1.Id = cppr1.ProductId  
                LEFT JOIN StatusTranslation st ON st.StatusId=prod1.StatusId 
                WHERE cppr1.ProductId = prod1.Id AND cppr1.PaymentStatusId = 2 AND prod1.EnterpriseHeadquarterId = $EnterpriseHeadquarterId   
                GROUP BY prod1.Id, prod1.SchoolYear, prod1.Name, st.Description  
                UNION ALL  
                SELECT prod1.Id,prod1.SchoolYear,prod1.Name,Count(prod1.Id) AS TotalPeopleToBePaid,0 AS TotalToBePaid,0 AS TotalPeoplePaid,   
                0 AS Cost,0 AS Discount,0 AS PenaltyAmountPaid,0 as TotalPaid,st.Description AS Estado
                FROM ClientProductPurchaseRegistry cppr1  
                JOIN Product prod1 ON prod1.Id = cppr1.ProductId  
                LEFT JOIN StatusTranslation st ON st.StatusId=prod1.StatusId 
                WHERE cppr1.PaymentStatusId = 2 AND prod1.EnterpriseHeadquarterId = $EnterpriseHeadquarterId  
                GROUP BY prod1.Id, prod1.SchoolYear, prod1.Name, st.Description) t1  
                GROUP BY t1.Id, t1.SchoolYear, t1.Name, t1.Estado
                ORDER BY t1.Name ASC, t1.SchoolYear");

    include 'conexion.php';

    $query_t = mysqli_query($conexion, "TRUNCATE TABLE producto_arpay_fv");

    while( $fila = sqlsrv_fetch_array( $query_p, SQLSRV_FETCH_ASSOC) ) {
        $query_producto = mysqli_query($conexion, "INSERT INTO producto_arpay_fv (Id,anio,nom_producto,pendientes,total_cancelar,pagos,
                    total_cancelado,total_descuento,total_penalizacion,sub_total,estado) 
                    VALUES ('".$fila['ProductId']."','".$fila['SchoolYear']."','".$fila['Name']."','".$fila['TotalPeopleToBePaid']."',
                    '".$fila['TotalToBePaid']."','".$fila['TotalPeoplePaid']."','".$fila['Cost']."','".$fila['Discount']."',
                    '".$fila['PenaltyAmountPaid']."','".$fila['TotalPaid']."','".$fila['Estado']."')");
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>