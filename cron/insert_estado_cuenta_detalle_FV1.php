<?php
    include 'conexion_arpay.php';

    $query_c = sqlsrv_query($conexion_arpay,"SELECT *  
    FROM
    (

        SELECT  
            NULL AS AccountingPaymentId,  
            NULL AS SystemMoneyTransferId,  
            cppr.Id AS ClientProductPurchaseRegistryId,  
            'ING' AS MovementType,  
            i.PaymentDate AS 'Date',  
            i.PaymentDate AS MovementDate,  
            i.PaidAmount AS AmountValue,  
            i.PaidAmount AS RealAmount,  
            CASE WHEN cppr.OperationNumber IS NOT NULL THEN cppr.OperationNumber ELSE i.MovementNumber END AS OperationNumber,  
            CONCAT(eh.Code, ' - ', cli.InternalStudentId, ' | ', i.Reference) AS Description,  
            i.MovementNumber AS Reference  
            FROM BankPaymentImportItem i  
            JOIN BankPaymentImport bpi ON bpi.Id = i.BankPaymentImportId  
            LEFT JOIN ClientProductPurchaseRegistry cppr ON cppr.Id = i.ClientProductPurchaseRegistryId  
            LEFT JOIN Client cli ON cli.Id = cppr.ClientId  
            LEFT JOIN EnterpriseHeadquarter eh ON eh.Id = cli.EnterpriseHeadquarterId  
        WHERE bpi.BankAccountId = 1013 AND i.IsProcessed = convert(bit, 1)  
    
        UNION  
    
        SELECT  
            NULL AS AccountingPaymentId,  
            NULL AS SystemMoneyTransferId,  
            c.Id AS ClientProductPurchaseRegistryId,  
            CASE WHEN c.PaymentStatusId = 1 THEN 'ING' ELSE 'DEV' END AS MovementType,  
            ISNULL(BankAccountPaymentDate, c.PaymentDate) AS 'Date',  
            ISNULL(BankAccountPaymentDate, c.PaymentDate) AS MovementDate,  
            CASE WHEN c.PaymentStatusId = 4 AND (c.Cost + ISNULL(c.PenaltyAmountPaid, 0) - ISNULL(c.TotalDiscount, 0)) > 0  
            THEN (c.Cost + ISNULL(c.PenaltyAmountPaid, 0) - ISNULL(c.TotalDiscount, 0)) * -1  
            ELSE(c.Cost + ISNULL(c.PenaltyAmountPaid, 0) - ISNULL(c.TotalDiscount, 0))  
            END AS AmountValue,  
            (c.Cost + ISNULL(c.PenaltyAmountPaid, 0) - ISNULL(c.TotalDiscount, 0)) AS RealAmount,  
            c.OperationNumber AS OperationNumber,  
            CONCAT(eh.Code, ' - ', cli.InternalStudentId, ' | ', c.ElectronicReceiptNumber, ' - ', c.Description) AS Description,  
            NULL AS Reference  
            FROM ClientProductPurchaseRegistry c  
            JOIN Client cli ON cli.Id = c.ClientId  
            JOIN EnterpriseHeadquarter eh ON eh.Id = cli.EnterpriseHeadquarterId  
        WHERE c.BankAccountId = 1013 AND c.PaymentStatusId IN (1,4)
        
    
        UNION  
    
        SELECT  
            ap.Id AS AccountingPaymentId,  
            NULL AS SystemMoneyTransferId,  
            NULL AS ClientProductPurchaseRegistryId,  
            'GST' AS MovementType,  
            ap.PaymentDate AS 'Date',  
            ap.PaymentDate AS MovementDate,  
            ap.Amount AS AmountValue,  
            ap.Amount * -1 AS RealAmount,  
            ap.OperationNumber AS OperationNumber,  
            ap.Description AS Description,  
            ap.CostNumber AS Reference  
            FROM AccountingPayment ap  
        WHERE ap.AccountingPaymentStatusId = 0 AND ap.BankAccountId = 1013
    
        UNION  
    
        SELECT  
            NULL AS AccountingPaymentId,  
            st.Id AS SystemMoneyTransferId,  
            NULL AS ClientProductPurchaseRegistryId,  
            'TRF' AS MovementType,  
            st.[Date] AS 'Date',  
            st.[Date] AS MovementDate,  
            st.Amount AS AmountValue,  
            CASE WHEN st.SourceBankAccountId = 1013 THEN st.Amount * -1 ELSE st.Amount END AS RealAmount,  
            st.OperationNumber AS OperationNumber,  
            st.Observations AS Description,  
            NULL AS Reference  
            FROM SystemMoneyTransfer st  
        WHERE (st.SourceBankAccountId = 1013 OR st.DestinationBankAccountId = 1013)
    ) results  
    ORDER BY  
    CASE WHEN results.OperationNumber IS NOT NULL THEN results.OperationNumber ELSE 99999999 END ASC,   
    results.MovementDate
     
    ");

    include 'conexion.php';

    //$query_t = mysqli_query($conexion, "TRUNCATE TABLE GetBankStatementMovements_Snappy");

    while( $fila = sqlsrv_fetch_array( $query_c, SQLSRV_FETCH_ASSOC) ) {
        

        $comercial = mysqli_query($conexion, "SELECT * FROM estado_bancario_fecha WHERE estado=2 AND MovementType='".$fila['MovementType']."' AND Reference='".$fila['Reference']."' AND OperationNumber='".$fila['OperationNumber']."'");
        $dato_comercial = mysqli_fetch_assoc($comercial);
        $total_comercial = mysqli_num_rows($comercial);

        if($total_comercial>0){
            
        }else{
            $query_h = mysqli_query($conexion, "INSERT INTO GetBankStatementMovements_Snappy (BankAccountId,AccountingPaymentId,SystemMoneyTransferId,ClientProductPurchaseRegistryId,MovementType,Date,MovementDate,AmountValue,RealAmount,OperationNumber,Description,Reference,estado,fec_reg,user_reg) 
            VALUES ('1013','".$fila['AccountingPaymentId']."','".$fila['SystemMoneyTransferId']."','".$fila['ClientProductPurchaseRegistryId']."','".$fila['MovementType']."','".DATE_FORMAT($fila['Date'], 'Y-m-d H:i:s')."','".DATE_FORMAT($fila['MovementDate'], 'Y-m-d H:i:s')."','".$fila['AmountValue']."','".$fila['RealAmount']."','".$fila['OperationNumber']."','".$fila['Description']."','".$fila['Reference']."',2,NOW(),0)");
        }
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>