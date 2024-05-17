<?php
    include 'conexion.php';  
    include 'conexion_arpay.php';

    $list_colaborador = mysqli_query($conexion, "SELECT id_colaborador,dni FROM colaborador 
                        WHERE estado=2");

    mysqli_query($conexion, "TRUNCATE TABLE pago_colaborador");

    while($fila = mysqli_fetch_assoc($list_colaborador)){
        $list_pago = sqlsrv_query($conexion_arpay,"SELECT ap.CostNumber AS pedido,
                    'Pago de Contabilidad' AS tipo,ct.ParentCostTypeId AS id_rubro,ct.Name AS subrubro,
                    ap.Description AS descripcion,ISNULL(ap.Amount,0) AS monto,aa.Description AS estado,
                    au.Name AS aprobado_por,FORMAT(ap.CreationDate,'yyyy-MM-dd') AS fecha_aprobacion,
                    FORMAT(ap.PaymentDate,'yyyy-MM-dd') AS fecha_entrega,rt.Description AS tipo_documento
                    FROM AccountingPayment ap
                    LEFT JOIN Employee em ON ap.EmployeeId=em.Id
                    LEFT JOIN Person pe ON em.PersonId=pe.Id
                    LEFT JOIN CostType ct ON ap.CostTypeId=ct.Id
                    LEFT JOIN CostType co ON ct.ParentCostTypeId=co.Id
                    LEFT JOIN AccountingPaymentStatusTranslation aa ON ap.AccountingPaymentStatusId=aa.AccountingPaymentStatusId
                    LEFT JOIN AspNetUsers au ON ap.CreationUserId=au.Id
                    LEFT JOIN ReceiptTypeTranslation rt ON ap.ReceiptTypeId=rt.ReceiptTypeId
                    WHERE ap.EmployeeId>0 AND ct.ParentCostTypeId=11 AND pe.IdentityCardNumber='".$fila['dni']."'");

        while( $fila_a = sqlsrv_fetch_array( $list_pago, SQLSRV_FETCH_ASSOC) ) { 
            mysqli_query($conexion, "INSERT INTO pago_colaborador (id_colaborador,pedido,tipo,subrubro,
            descripcion,monto,estado,aprobado_por,fecha_aprobacion,fecha_entrega,tipo_documento) 
            VALUES ('".$fila['id_colaborador']."','".$fila_a['pedido']."','".$fila_a['tipo']."',
            '".$fila_a['subrubro']."','".$fila_a['descripcion']."','".$fila_a['monto']."',
            '".$fila_a['estado']."','".$fila_a['aprobado_por']."','".$fila_a['fecha_aprobacion']."',
            '".$fila_a['fecha_entrega']."','".$fila_a['tipo_documento']."')");
        }
    }
?>