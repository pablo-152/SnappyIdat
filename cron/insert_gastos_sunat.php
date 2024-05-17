<?php
    include 'conexion_arpay.php';

    $anio_pasado = date('Y')-1;
    $anio_actual = date('Y');

    $query_c = sqlsrv_query($conexion_arpay,"SELECT ap.Id,FORMAT(ap.AccountingDate,'yyyy-MM-dd') AS Mes_Anio,
                ap.CostNumber AS Pedido,'Pago de Contabilidad' AS Tipo,en.Code AS Cod_Empresa_Factura,en.Name AS Empresa_Factura,
                eh.Code AS Gasto_Empresa,ap.CostTypeId,co.Name AS Rubro,ct.Name AS Subrubro,ap.Description AS Descripcion,
                ISNULL(ap.Amount,0) AS Monto,ac.Description AS Tipo_Solicitante,
                CASE WHEN ap.EmployeeId>0 THEN CONCAT(pe.MotherSurname,' ',pe.FatherSurname,' ',pe.FirstName) 
                WHEN ap.SupplierContactId>0 THEN CONCAT(su.SupplierId,'/',sp.Name,'/',su.Name) ELSE ap.OtherRequester END AS Solicitante,
                aa.Description AS Estado,au.Name AS Aprobado_Por,FORMAT(ap.PaymentDate,'yyyy-MM-dd') AS Fecha_Entrega,
                rt.Description AS Tipo_Documento,FORMAT(ap.ReceiptDate,'yyyy-MM-dd') AS Fecha_Documento,ap.ReceiptNumber AS Numero_Recibo,
                ar.Description AS Tipo_Pago,ba.Name AS Cuenta_Bancaria,ev.Name AS Caja,CASE ap.DoNotAccount WHEN 0 THEN 'FALSO' ELSE 'VERDADERO' 
                END AS Sin_Contabilizar,'0' AS Total_Asignado,'No' AS Centro_Costo,CASE ap.Validated WHEN 0 THEN 'FALSO' ELSE 'VERDADERO' 
                END AS Revisado,CASE ap.DeductibleCost WHEN 0 THEN 'FALSO' ELSE 'VERDADERO' END AS Gasto_Deducible,eq.Code AS Empresa,
                sp.RUC AS Ruc_Proveedor,FORMAT(ap.CreationDate,'yyyy-MM-dd') AS Fecha_Creacion,ap.OperationNumber AS Operacion
                FROM AccountingPayment ap
                LEFT JOIN EnterpriseHeadquarter en ON en.Id=ap.EnterpriseHeadquarterIdInvoiceName
                LEFT JOIN EnterpriseHeadquarter eh ON eh.Id=ap.EnterpriseHeadquarterId
                LEFT JOIN CostType ct ON ct.Id=ap.CostTypeId
                LEFT JOIN CostType co ON co.Id=ct.ParentCostTypeId
                LEFT JOIN ReceiptTypeTranslation rt ON rt.ReceiptTypeId=ap.ReceiptTypeId
                LEFT JOIN AccountingPaymentExitTypeTranslation ar ON ar.AccountingPaymentExitTypeId=ap.AccountingPaymentExitTypeId
                LEFT JOIN AccoutingPaymentRequesterTypeTranslation ac ON ac.AccountingPaymentRequesterTypeId=ap.RequesterTypeId
                LEFT JOIN AccountingPaymentStatusTranslation aa ON aa.AccountingPaymentStatusId=ap.AccountingPaymentStatusId
                LEFT JOIN Employee em ON em.Id=ap.EmployeeId
                LEFT JOIN Person pe ON pe.Id=em.PersonId
                LEFT JOIN SupplierContact su ON su.Id=ap.SupplierContactId
                LEFT JOIN Supplier sp ON sp.Id=su.SupplierId
                LEFT JOIN BankAccount ba ON ba.Id=ap.BankAccountId
                LEFT JOIN EnterpriseHeadquarterVault ev ON ev.Id=ap.EnterpriseHeadquarterVaultId
                LEFT JOIN EnterpriseHeadquarter eq ON eq.Id=ap.DeductibleEnterpriseHeadquarterId
                LEFT JOIN AspNetUsers au ON au.Id=ap.CreationUserId
                WHERE YEAR(ap.PaymentDate) IN ($anio_pasado,$anio_actual) AND ap.ReceiptTypeId IN (0,3,4,5,6,7,10,11,12,13) AND ap.AccountingPaymentStatusId=0 
                ORDER BY ap.ReceiptDate ASC");

    include 'conexion.php';

    $query_t1 = mysqli_query($conexion, "DELETE FROM gastos_sunat_arpay WHERE YEAR(Fecha_Entrega)=$anio_pasado");
    $query_t2 = mysqli_query($conexion, "DELETE FROM gastos_sunat_arpay WHERE YEAR(Fecha_Entrega)=$anio_actual");

    while( $fila = sqlsrv_fetch_array( $query_c, SQLSRV_FETCH_ASSOC) ) { 
        $query_a = mysqli_query($conexion, "INSERT INTO gastos_sunat_arpay (Id,Mes_Anio,Pedido,Tipo,Cod_Empresa_Factura,Empresa_Factura,Gasto_Empresa,
                    CostTypeId,Rubro,Subrubro,Descripcion,Monto,Tipo_Solicitante,Solicitante,Estado,Aprobado_Por,Fecha_Entrega,Tipo_Documento,
                    Fecha_Documento,Numero_Recibo,Tipo_Pago,Cuenta_Bancaria,Caja,Sin_Contabilizar,Total_Asignado,Centro_Costo,Revisado,
                    Gasto_Deducible,Empresa,Ruc_Proveedor,Fecha_Creacion,Operacion) 
                    VALUES ('".$fila['Id']."','".$fila['Mes_Anio']."','".$fila['Pedido']."','".$fila['Tipo']."',
                    '".$fila['Cod_Empresa_Factura']."','".$fila['Empresa_Factura']."','".$fila['Gasto_Empresa']."','".$fila['CostTypeId']."',
                    '".$fila['Rubro']."','".$fila['Subrubro']."','".addslashes($fila['Descripcion'])."','".$fila['Monto']."',
                    '".$fila['Tipo_Solicitante']."','".addslashes($fila['Solicitante'])."','".$fila['Estado']."','".$fila['Aprobado_Por']."',
                    '".$fila['Fecha_Entrega']."','".$fila['Tipo_Documento']."','".$fila['Fecha_Documento']."','".$fila['Numero_Recibo']."',
                    '".$fila['Tipo_Pago']."','".$fila['Cuenta_Bancaria']."','".$fila['Caja']."','".$fila['Sin_Contabilizar']."',
                    '".$fila['Total_Asignado']."','".$fila['Centro_Costo']."','".$fila['Revisado']."','".$fila['Gasto_Deducible']."',
                    '".$fila['Empresa']."','".$fila['Ruc_Proveedor']."','".$fila['Fecha_Creacion']."','".$fila['Operacion']."')"); 
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>