<?php 
    /*ANTIGUO*/
    $ingreso_enero_ant=$get_boleta_ant[0]['Enero']+$get_cuentas_por_cobrar_ant[0]['Enero']+$get_factura_ant[0]['Enero']+$get_nota_debito_ant[0]['Enero']-$get_nota_credito_ant[0]['Enero'];
    $ingreso_febrero_ant=$get_boleta_ant[0]['Febrero']+$get_cuentas_por_cobrar_ant[0]['Febrero']+$get_factura_ant[0]['Febrero']+$get_nota_debito_ant[0]['Febrero']-$get_nota_credito_ant[0]['Febrero'];
    $ingreso_marzo_ant=$get_boleta_ant[0]['Marzo']+$get_cuentas_por_cobrar_ant[0]['Marzo']+$get_factura_ant[0]['Marzo']+$get_nota_debito_ant[0]['Marzo']-$get_nota_credito_ant[0]['Marzo'];
    $ingreso_abril_ant=$get_boleta_ant[0]['Abril']+$get_cuentas_por_cobrar_ant[0]['Abril']+$get_factura_ant[0]['Abril']+$get_nota_debito_ant[0]['Abril']-$get_nota_credito_ant[0]['Abril'];
    $ingreso_mayo_ant=$get_boleta_ant[0]['Mayo']+$get_cuentas_por_cobrar_ant[0]['Mayo']+$get_factura_ant[0]['Mayo']+$get_nota_debito_ant[0]['Mayo']-$get_nota_credito_ant[0]['Mayo'];
    $ingreso_junio_ant=$get_boleta_ant[0]['Junio']+$get_cuentas_por_cobrar_ant[0]['Junio']+$get_factura_ant[0]['Junio']+$get_nota_debito_ant[0]['Junio']-$get_nota_credito_ant[0]['Junio'];
    $ingreso_julio_ant=$get_boleta_ant[0]['Julio']+$get_cuentas_por_cobrar_ant[0]['Julio']+$get_factura_ant[0]['Julio']+$get_nota_debito_ant[0]['Julio']-$get_nota_credito_ant[0]['Julio'];
    $ingreso_agosto_ant=$get_boleta_ant[0]['Agosto']+$get_cuentas_por_cobrar_ant[0]['Agosto']+$get_factura_ant[0]['Agosto']+$get_nota_debito_ant[0]['Agosto']-$get_nota_credito_ant[0]['Agosto'];
    $ingreso_septiembre_ant=$get_boleta_ant[0]['Septiembre']+$get_cuentas_por_cobrar_ant[0]['Septiembre']+$get_factura_ant[0]['Septiembre']+$get_nota_debito_ant[0]['Septiembre']-$get_nota_credito_ant[0]['Septiembre'];
    $ingreso_octubre_ant=$get_boleta_ant[0]['Octubre']+$get_cuentas_por_cobrar_ant[0]['Octubre']+$get_factura_ant[0]['Octubre']+$get_nota_debito_ant[0]['Octubre']-$get_nota_credito_ant[0]['Octubre'];
    $ingreso_noviembre_ant=$get_boleta_ant[0]['Noviembre']+$get_cuentas_por_cobrar_ant[0]['Noviembre']+$get_factura_ant[0]['Noviembre']+$get_nota_debito_ant[0]['Noviembre']-$get_nota_credito_ant[0]['Noviembre'];
    $ingreso_diciembre_ant=$get_boleta_ant[0]['Diciembre']+$get_cuentas_por_cobrar_ant[0]['Diciembre']+$get_factura_ant[0]['Diciembre']+$get_nota_debito_ant[0]['Diciembre']-$get_nota_credito_ant[0]['Diciembre'];
    $ingreso_total_ant=$get_boleta_ant[0]['Total']+$get_cuentas_por_cobrar_ant[0]['Total']+$get_factura_ant[0]['Total']+$get_nota_debito_ant[0]['Total']-$get_nota_credito_ant[0]['Total'];

    $before_enero_ant=$ingreso_enero_ant-$get_gasto_ant[0]['Enero'];
    $before_febrero_ant=$ingreso_febrero_ant-$get_gasto_ant[0]['Febrero'];
    $before_marzo_ant=$ingreso_marzo_ant-$get_gasto_ant[0]['Marzo'];
    $before_abril_ant=$ingreso_abril_ant-$get_gasto_ant[0]['Abril'];
    $before_mayo_ant=$ingreso_mayo_ant-$get_gasto_ant[0]['Mayo'];
    $before_junio_ant=$ingreso_junio_ant-$get_gasto_ant[0]['Junio'];
    $before_julio_ant=$ingreso_julio_ant-$get_gasto_ant[0]['Julio'];
    $before_agosto_ant=$ingreso_agosto_ant-$get_gasto_ant[0]['Agosto'];
    $before_septiembre_ant=$ingreso_septiembre_ant-$get_gasto_ant[0]['Septiembre'];
    $before_octubre_ant=$ingreso_octubre_ant-$get_gasto_ant[0]['Octubre'];
    $before_noviembre_ant=$ingreso_noviembre_ant-$get_gasto_ant[0]['Noviembre'];
    $before_diciembre_ant=$ingreso_diciembre_ant-$get_gasto_ant[0]['Diciembre'];
    $before_total_ant=$ingreso_total_ant-$get_gasto_ant[0]['Total'];

    $after_enero_ant=$before_enero_ant-$get_impuesto_ant[0]['Enero'];
    $after_febrero_ant=$before_febrero_ant-$get_impuesto_ant[0]['Febrero'];
    $after_marzo_ant=$before_marzo_ant-$get_impuesto_ant[0]['Marzo'];
    $after_abril_ant=$before_abril_ant-$get_impuesto_ant[0]['Abril'];
    $after_mayo_ant=$before_mayo_ant-$get_impuesto_ant[0]['Mayo'];
    $after_junio_ant=$before_junio_ant-$get_impuesto_ant[0]['Junio'];
    $after_julio_ant=$before_julio_ant-$get_impuesto_ant[0]['Julio'];
    $after_agosto_ant=$before_agosto_ant-$get_impuesto_ant[0]['Agosto'];
    $after_septiembre_ant=$before_septiembre_ant-$get_impuesto_ant[0]['Septiembre'];
    $after_octubre_ant=$before_octubre_ant-$get_impuesto_ant[0]['Octubre'];
    $after_noviembre_ant=$before_noviembre_ant-$get_impuesto_ant[0]['Noviembre'];
    $after_diciembre_ant=$before_diciembre_ant-$get_impuesto_ant[0]['Diciembre'];
    $after_total_ant=$before_total_ant-$get_impuesto_ant[0]['Total'];

    /*ACTUAL*/
    /*INGRESOS*/
    $ingreso_enero=$get_boleta[0]['Enero']+$get_cuentas_por_cobrar[0]['Enero']+$get_factura[0]['Enero']+$get_nota_debito[0]['Enero']-$get_nota_credito[0]['Enero'];
    $ingreso_febrero=$get_boleta[0]['Febrero']+$get_cuentas_por_cobrar[0]['Febrero']+$get_factura[0]['Febrero']+$get_nota_debito[0]['Febrero']-$get_nota_credito[0]['Febrero'];
    $ingreso_marzo=$get_boleta[0]['Marzo']+$get_cuentas_por_cobrar[0]['Marzo']+$get_factura[0]['Marzo']+$get_nota_debito[0]['Marzo']-$get_nota_credito[0]['Marzo'];
    $ingreso_abril=$get_boleta[0]['Abril']+$get_cuentas_por_cobrar[0]['Abril']+$get_factura[0]['Abril']+$get_nota_debito[0]['Abril']-$get_nota_credito[0]['Abril'];
    $ingreso_mayo=$get_boleta[0]['Mayo']+$get_cuentas_por_cobrar[0]['Mayo']+$get_factura[0]['Mayo']+$get_nota_debito[0]['Mayo']-$get_nota_credito[0]['Mayo'];
    $ingreso_junio=$get_boleta[0]['Junio']+$get_cuentas_por_cobrar[0]['Junio']+$get_factura[0]['Junio']+$get_nota_debito[0]['Junio']-$get_nota_credito[0]['Junio'];
    $ingreso_julio=$get_boleta[0]['Julio']+$get_cuentas_por_cobrar[0]['Julio']+$get_factura[0]['Julio']+$get_nota_debito[0]['Julio']-$get_nota_credito[0]['Julio'];
    $ingreso_agosto=$get_boleta[0]['Agosto']+$get_cuentas_por_cobrar[0]['Agosto']+$get_factura[0]['Agosto']+$get_nota_debito[0]['Agosto']-$get_nota_credito[0]['Agosto'];
    $ingreso_septiembre=$get_boleta[0]['Septiembre']+$get_cuentas_por_cobrar[0]['Septiembre']+$get_factura[0]['Septiembre']+$get_nota_debito[0]['Septiembre']-$get_nota_credito[0]['Septiembre'];
    $ingreso_octubre=$get_boleta[0]['Octubre']+$get_cuentas_por_cobrar[0]['Octubre']+$get_factura[0]['Octubre']+$get_nota_debito[0]['Octubre']-$get_nota_credito[0]['Octubre'];
    $ingreso_noviembre=$get_boleta[0]['Noviembre']+$get_cuentas_por_cobrar[0]['Noviembre']+$get_factura[0]['Noviembre']+$get_nota_debito[0]['Noviembre']-$get_nota_credito[0]['Noviembre'];
    $ingreso_diciembre=$get_boleta[0]['Diciembre']+$get_cuentas_por_cobrar[0]['Diciembre']+$get_factura[0]['Diciembre']+$get_nota_debito[0]['Diciembre']-$get_nota_credito[0]['Diciembre'];
    $ingreso_total=$get_boleta[0]['Total']+$get_cuentas_por_cobrar[0]['Total']+$get_factura[0]['Total']+$get_nota_debito[0]['Total']-$get_nota_credito[0]['Total'];

    /*UTILIDAD(BEFORE TAX)*/
    $before_enero=$ingreso_enero-$get_gasto[0]['Enero'];
    $before_febrero=$ingreso_febrero-$get_gasto[0]['Febrero'];
    $before_marzo=$ingreso_marzo-$get_gasto[0]['Marzo'];
    $before_abril=$ingreso_abril-$get_gasto[0]['Abril'];
    $before_mayo=$ingreso_mayo-$get_gasto[0]['Mayo'];
    $before_junio=$ingreso_junio-$get_gasto[0]['Junio'];
    $before_julio=$ingreso_julio-$get_gasto[0]['Julio'];
    $before_agosto=$ingreso_agosto-$get_gasto[0]['Agosto'];
    $before_septiembre=$ingreso_septiembre-$get_gasto[0]['Septiembre'];
    $before_octubre=$ingreso_octubre-$get_gasto[0]['Octubre'];
    $before_noviembre=$ingreso_noviembre-$get_gasto[0]['Noviembre'];
    $before_diciembre=$ingreso_diciembre-$get_gasto[0]['Diciembre'];
    $before_total=$ingreso_total-$get_gasto[0]['Total'];

    /*UTILIDAD(AFTER TAX)*/
    $after_enero=$before_enero-$get_impuesto[0]['Enero'];
    $after_febrero=$before_febrero-$get_impuesto[0]['Febrero'];
    $after_marzo=$before_marzo-$get_impuesto[0]['Marzo'];
    $after_abril=$before_abril-$get_impuesto[0]['Abril'];
    $after_mayo=$before_mayo-$get_impuesto[0]['Mayo'];
    $after_junio=$before_junio-$get_impuesto[0]['Junio'];
    $after_julio=$before_julio-$get_impuesto[0]['Julio'];
    $after_agosto=$before_agosto-$get_impuesto[0]['Agosto'];
    $after_septiembre=$before_septiembre-$get_impuesto[0]['Septiembre'];
    $after_octubre=$before_octubre-$get_impuesto[0]['Octubre'];
    $after_noviembre=$before_noviembre-$get_impuesto[0]['Noviembre'];
    $after_diciembre=$before_diciembre-$get_impuesto[0]['Diciembre'];
    $after_total=$before_total-$get_impuesto[0]['Total'];
    
    /*DIFERENCIA*/
    if($ingreso_enero_ant==0){
        $diferencia_ingreso_enero = 0;
    }else{
        $diferencia_ingreso_enero = (($ingreso_enero-$ingreso_enero_ant)/$ingreso_enero_ant)*100;
    }
    if($ingreso_febrero_ant==0){
        $diferencia_ingreso_febrero = 0;
    }else{
        $diferencia_ingreso_febrero = (($ingreso_febrero-$ingreso_febrero_ant)/$ingreso_febrero_ant)*100;
    }
    if($ingreso_marzo_ant==0){
        $diferencia_ingreso_marzo = 0;
    }else{
        $diferencia_ingreso_marzo = (($ingreso_marzo-$ingreso_marzo_ant)/$ingreso_marzo_ant)*100;
    }
    if($ingreso_abril_ant==0){
        $diferencia_ingreso_abril = 0;
    }else{
        $diferencia_ingreso_abril = (($ingreso_abril-$ingreso_abril_ant)/$ingreso_abril_ant)*100;
    }
    if($ingreso_mayo_ant==0){
        $diferencia_ingreso_mayo = 0;
    }else{
        $diferencia_ingreso_mayo = (($ingreso_mayo-$ingreso_mayo_ant)/$ingreso_mayo_ant)*100;
    }
    if($ingreso_junio_ant==0){
        $diferencia_ingreso_junio = 0;
    }else{
        $diferencia_ingreso_junio = (($ingreso_junio-$ingreso_junio_ant)/$ingreso_junio_ant)*100;
    }
    if($ingreso_julio_ant==0){
        $diferencia_ingreso_julio = 0;
    }else{
        $diferencia_ingreso_julio = (($ingreso_julio-$ingreso_julio_ant)/$ingreso_julio_ant)*100;
    }
    if($ingreso_agosto_ant==0){
        $diferencia_ingreso_agosto = 0;
    }else{
        $diferencia_ingreso_agosto = (($ingreso_agosto-$ingreso_agosto_ant)/$ingreso_agosto_ant)*100;
    }
    if($ingreso_septiembre_ant==0){
        $diferencia_ingreso_septiembre = 0;
    }else{
        $diferencia_ingreso_septiembre = (($ingreso_septiembre-$ingreso_septiembre_ant)/$ingreso_septiembre_ant)*100;
    }
    if($ingreso_octubre_ant==0){
        $diferencia_ingreso_octubre = 0;
    }else{
        $diferencia_ingreso_octubre = (($ingreso_octubre-$ingreso_octubre_ant)/$ingreso_octubre_ant)*100;
    }
    if($ingreso_noviembre_ant==0){
        $diferencia_ingreso_noviembre = 0;
    }else{
        $diferencia_ingreso_noviembre = (($ingreso_noviembre-$ingreso_noviembre_ant)/$ingreso_noviembre_ant)*100;
    }
    if($ingreso_diciembre_ant==0){
        $diferencia_ingreso_diciembre = 0;
    }else{
        $diferencia_ingreso_diciembre = (($ingreso_diciembre-$ingreso_diciembre_ant)/$ingreso_diciembre_ant)*100;
    }
    if($ingreso_total_ant==0){
        $diferencia_ingreso_total = 0;
    }else{
        $diferencia_ingreso_total = (($ingreso_total-$ingreso_total_ant)/$ingreso_total_ant)*100;
    }

    
    if($get_gasto_ant[0]['Enero']==0){
        $diferencia_gasto_enero = 0;
    }else{
        $diferencia_gasto_enero = (($get_gasto[0]['Enero']-$get_gasto_ant[0]['Enero'])/$get_gasto_ant[0]['Enero'])*100;
    }
    if($get_gasto_ant[0]['Febrero']==0){
        $diferencia_gasto_febrero = 0;
    }else{
        $diferencia_gasto_febrero = (($get_gasto[0]['Febrero']-$get_gasto_ant[0]['Febrero'])/$get_gasto_ant[0]['Febrero'])*100;
    }
    if($get_gasto_ant[0]['Marzo']==0){
        $diferencia_gasto_marzo = 0;
    }else{
        $diferencia_gasto_marzo = (($get_gasto[0]['Marzo']-$get_gasto_ant[0]['Marzo'])/$get_gasto_ant[0]['Marzo'])*100;
    }
    if($get_gasto_ant[0]['Abril']==0){
        $diferencia_gasto_abril = 0;
    }else{
        $diferencia_gasto_abril = (($get_gasto[0]['Abril']-$get_gasto_ant[0]['Abril'])/$get_gasto_ant[0]['Abril'])*100;
    }
    if($get_gasto_ant[0]['Mayo']==0){
        $diferencia_gasto_mayo = 0;
    }else{
        $diferencia_gasto_mayo = (($get_gasto[0]['Mayo']-$get_gasto_ant[0]['Mayo'])/$get_gasto_ant[0]['Mayo'])*100;
    }
    if($get_gasto_ant[0]['Junio']==0){
        $diferencia_gasto_junio = 0;
    }else{
        $diferencia_gasto_junio = (($get_gasto[0]['Junio']-$get_gasto_ant[0]['Junio'])/$get_gasto_ant[0]['Junio'])*100;
    }
    if($get_gasto_ant[0]['Julio']==0){
        $diferencia_gasto_julio = 0;
    }else{
        $diferencia_gasto_julio = (($get_gasto[0]['Julio']-$get_gasto_ant[0]['Julio'])/$get_gasto_ant[0]['Julio'])*100;
    }
    if($get_gasto_ant[0]['Agosto']==0){
        $diferencia_gasto_agosto = 0;
    }else{
        $diferencia_gasto_agosto = (($get_gasto[0]['Agosto']-$get_gasto_ant[0]['Agosto'])/$get_gasto_ant[0]['Agosto'])*100;
    }
    if($get_gasto_ant[0]['Septiembre']==0){
        $diferencia_gasto_septiembre = 0;
    }else{
        $diferencia_gasto_septiembre = (($get_gasto[0]['Septiembre']-$get_gasto_ant[0]['Septiembre'])/$get_gasto_ant[0]['Septiembre'])*100;
    }
    if($get_gasto_ant[0]['Octubre']==0){
        $diferencia_gasto_octubre = 0;
    }else{
        $diferencia_gasto_octubre = (($get_gasto[0]['Octubre']-$get_gasto_ant[0]['Octubre'])/$get_gasto_ant[0]['Octubre'])*100;
    }
    if($get_gasto_ant[0]['Noviembre']==0){
        $diferencia_gasto_noviembre = 0;
    }else{
        $diferencia_gasto_noviembre = (($get_gasto[0]['Noviembre']-$get_gasto_ant[0]['Noviembre'])/$get_gasto_ant[0]['Noviembre'])*100;
    }
    if($get_gasto_ant[0]['Diciembre']==0){
        $diferencia_gasto_diciembre = 0;
    }else{
        $diferencia_gasto_diciembre = (($get_gasto[0]['Diciembre']-$get_gasto_ant[0]['Diciembre'])/$get_gasto_ant[0]['Diciembre'])*100;
    }
    if($get_gasto_ant[0]['Total']==0){
        $diferencia_gasto_total = 0;
    }else{
        $diferencia_gasto_total = (($get_gasto[0]['Total']-$get_gasto_ant[0]['Total'])/$get_gasto_ant[0]['Total'])*100;
    }

    
    if($before_enero_ant==0){
        $diferencia_before_enero = 0;
    }else{
        $diferencia_before_enero = (($before_enero-$before_enero_ant)/$before_enero_ant)*100;
    }
    if($before_febrero_ant==0){
        $diferencia_before_febrero = 0;
    }else{
        $diferencia_before_febrero = (($before_febrero-$before_febrero_ant)/$before_febrero_ant)*100;
    }
    if($before_marzo_ant==0){
        $diferencia_before_marzo = 0;
    }else{
        $diferencia_before_marzo = (($before_marzo-$before_marzo_ant)/$before_marzo_ant)*100;
    }
    if($before_abril_ant==0){
        $diferencia_before_abril = 0;
    }else{
        $diferencia_before_abril = (($before_abril-$before_abril_ant)/$before_abril_ant)*100;
    }
    if($before_mayo_ant==0){
        $diferencia_before_mayo = 0;
    }else{
        $diferencia_before_mayo = (($before_mayo-$before_mayo_ant)/$before_mayo_ant)*100;
    }
    if($before_junio_ant==0){
        $diferencia_before_junio = 0;
    }else{
        $diferencia_before_junio = (($before_junio-$before_junio_ant)/$before_junio_ant)*100;
    }
    if($before_julio_ant==0){
        $diferencia_before_julio = 0;
    }else{
        $diferencia_before_julio = (($before_julio-$before_julio_ant)/$before_julio_ant)*100;
    }
    if($before_agosto_ant==0){
        $diferencia_before_agosto = 0;
    }else{
        $diferencia_before_agosto = (($before_agosto-$before_agosto_ant)/$before_agosto_ant)*100;
    }
    if($before_septiembre_ant==0){
        $diferencia_before_septiembre = 0;
    }else{
        $diferencia_before_septiembre = (($before_septiembre-$before_septiembre_ant)/$before_septiembre_ant)*100;
    }
    if($before_octubre_ant==0){
        $diferencia_before_octubre = 0;
    }else{
        $diferencia_before_octubre = (($before_octubre-$before_octubre_ant)/$before_octubre_ant)*100;
    }
    if($before_noviembre_ant==0){
        $diferencia_before_noviembre = 0;
    }else{
        $diferencia_before_noviembre = (($before_noviembre-$before_noviembre_ant)/$before_noviembre_ant)*100;
    }
    if($before_diciembre_ant==0){
        $diferencia_before_diciembre = 0;
    }else{
        $diferencia_before_diciembre = (($before_diciembre-$before_diciembre_ant)/$before_diciembre_ant)*100;
    }
    if($before_total_ant==0){
        $diferencia_before_total = 0;
    }else{
        $diferencia_before_total = (($before_total-$before_total_ant)/$before_total_ant)*100;
    }


    if($get_impuesto_ant[0]['Enero']==0){
        $diferencia_impuesto_enero = 0;
    }else{
        $diferencia_impuesto_enero = (($get_impuesto[0]['Enero']-$get_impuesto_ant[0]['Enero'])/$get_impuesto_ant[0]['Enero'])*100;
    }
    if($get_impuesto_ant[0]['Febrero']==0){
        $diferencia_impuesto_febrero = 0;
    }else{
        $diferencia_impuesto_febrero = (($get_impuesto[0]['Febrero']-$get_impuesto_ant[0]['Febrero'])/$get_impuesto_ant[0]['Febrero'])*100;
    }
    if($get_impuesto_ant[0]['Marzo']==0){
        $diferencia_impuesto_marzo = 0;
    }else{
        $diferencia_impuesto_marzo = (($get_impuesto[0]['Marzo']-$get_impuesto_ant[0]['Marzo'])/$get_impuesto_ant[0]['Marzo'])*100;
    }
    if($get_impuesto_ant[0]['Abril']==0){
        $diferencia_impuesto_abril = 0;
    }else{
        $diferencia_impuesto_abril = (($get_impuesto[0]['Abril']-$get_impuesto_ant[0]['Abril'])/$get_impuesto_ant[0]['Abril'])*100;
    }
    if($get_impuesto_ant[0]['Mayo']==0){
        $diferencia_impuesto_mayo = 0;
    }else{
        $diferencia_impuesto_mayo = (($get_impuesto[0]['Mayo']-$get_impuesto_ant[0]['Mayo'])/$get_impuesto_ant[0]['Mayo'])*100;
    }
    if($get_impuesto_ant[0]['Junio']==0){
        $diferencia_impuesto_junio = 0;
    }else{
        $diferencia_impuesto_junio = (($get_impuesto[0]['Junio']-$get_impuesto_ant[0]['Junio'])/$get_impuesto_ant[0]['Junio'])*100;
    }
    if($get_impuesto_ant[0]['Julio']==0){
        $diferencia_impuesto_julio = 0;
    }else{
        $diferencia_impuesto_julio = (($get_impuesto[0]['Julio']-$get_impuesto_ant[0]['Julio'])/$get_impuesto_ant[0]['Julio'])*100;
    }
    if($get_impuesto_ant[0]['Agosto']==0){
        $diferencia_impuesto_agosto = 0;
    }else{
        $diferencia_impuesto_agosto = (($get_impuesto[0]['Agosto']-$get_impuesto_ant[0]['Agosto'])/$get_impuesto_ant[0]['Agosto'])*100;
    }
    if($get_impuesto_ant[0]['Septiembre']==0){
        $diferencia_impuesto_septiembre = 0;
    }else{
        $diferencia_impuesto_septiembre = (($get_impuesto[0]['Septiembre']-$get_impuesto_ant[0]['Septiembre'])/$get_impuesto_ant[0]['Septiembre'])*100;
    }
    if($get_impuesto_ant[0]['Octubre']==0){
        $diferencia_impuesto_octubre = 0;
    }else{
        $diferencia_impuesto_octubre = (($get_impuesto[0]['Octubre']-$get_impuesto_ant[0]['Octubre'])/$get_impuesto_ant[0]['Octubre'])*100;
    }
    if($get_impuesto_ant[0]['Noviembre']==0){
        $diferencia_impuesto_noviembre = 0;
    }else{
        $diferencia_impuesto_noviembre = (($get_impuesto[0]['Noviembre']-$get_impuesto_ant[0]['Noviembre'])/$get_impuesto_ant[0]['Noviembre'])*100;
    }
    if($get_impuesto_ant[0]['Diciembre']==0){
        $diferencia_impuesto_diciembre = 0;
    }else{
        $diferencia_impuesto_diciembre = (($get_impuesto[0]['Diciembre']-$get_impuesto_ant[0]['Diciembre'])/$get_impuesto_ant[0]['Diciembre'])*100;
    }
    if($get_impuesto_ant[0]['Total']==0){
        $diferencia_impuesto_total = 0;
    }else{
        $diferencia_impuesto_total = (($get_impuesto[0]['Total']-$get_impuesto_ant[0]['Total'])/$get_impuesto_ant[0]['Total'])*100;
    }


    if($after_enero_ant==0){
        $diferencia_after_enero = 0;
    }else{
        $diferencia_after_enero = (($after_enero-$after_enero_ant)/$after_enero_ant)*100;
    }
    if($after_febrero_ant==0){
        $diferencia_after_febrero = 0;
    }else{
        $diferencia_after_febrero = (($after_febrero-$after_febrero_ant)/$after_febrero_ant)*100;
    }
    if($after_marzo_ant==0){
        $diferencia_after_marzo = 0;
    }else{
        $diferencia_after_marzo = (($after_marzo-$after_marzo_ant)/$after_marzo_ant)*100;
    }
    if($after_abril_ant==0){
        $diferencia_after_abril = 0;
    }else{
        $diferencia_after_abril = (($after_abril-$after_abril_ant)/$after_abril_ant)*100;
    }
    if($after_mayo_ant==0){
        $diferencia_after_mayo = 0;
    }else{
        $diferencia_after_mayo = (($after_mayo-$after_mayo_ant)/$after_mayo_ant)*100;
    }
    if($after_junio_ant==0){
        $diferencia_after_junio = 0;
    }else{
        $diferencia_after_junio = (($after_junio-$after_junio_ant)/$after_junio_ant)*100;
    }
    if($after_julio_ant==0){
        $diferencia_after_julio = 0;
    }else{
        $diferencia_after_julio = (($after_julio-$after_julio_ant)/$after_julio_ant)*100;
    }
    if($after_agosto_ant==0){
        $diferencia_after_agosto = 0;
    }else{
        $diferencia_after_agosto = (($after_agosto-$after_agosto_ant)/$after_agosto_ant)*100;
    }
    if($after_septiembre_ant==0){
        $diferencia_after_septiembre = 0;
    }else{
        $diferencia_after_septiembre = (($after_septiembre-$after_septiembre_ant)/$after_septiembre_ant)*100;
    }
    if($after_octubre_ant==0){
        $diferencia_after_octubre = 0;
    }else{
        $diferencia_after_octubre = (($after_octubre-$after_octubre_ant)/$after_octubre_ant)*100;
    }
    if($after_noviembre_ant==0){
        $diferencia_after_noviembre = 0;
    }else{
        $diferencia_after_noviembre = (($after_noviembre-$after_noviembre_ant)/$after_noviembre_ant)*100;
    }
    if($after_diciembre_ant==0){
        $diferencia_after_diciembre = 0;
    }else{
        $diferencia_after_diciembre = (($after_diciembre-$after_diciembre_ant)/$after_diciembre_ant)*100;
    }
    if($after_total_ant==0){
        $diferencia_after_total = 0;
    }else{
        $diferencia_after_total = (($after_total-$after_total_ant)/$after_total_ant)*100;
    }
?>

<table width="100%" border="1" align="center" cellpadding="1" cellspacing="1">
    <thead>
        <tr>
            <th style="background-color:#ffffff;">&nbsp;</th>
            <th class="text-center" style="background-color:#c8c8c8;">Ene-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Feb-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Mar-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Abr-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">May-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Jun-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Jul-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Ago-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Set-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Oct-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Nov-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" style="background-color:#c8c8c8;">Dic-<?php echo substr($anio,-2); ?></th>
            <th style="background-color:#ffffff;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="2" style="background-color:#8dbf42;color:#ffffff;">INGRESOS</td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_enero,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_febrero,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_marzo,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_abril,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_mayo,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_junio,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_julio,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_agosto,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_septiembre,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_octubre,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_noviembre,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($ingreso_diciembre,2); ?></td>
            <td class="text-right" style="background-color:#8dbf42;color:#ffffff;"><?php echo "S/".number_format($ingreso_total,2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($diferencia_ingreso_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#8dbf42;color:#ffffff;"><?php echo number_format($diferencia_ingreso_total,2)."%"; ?></td>
        </tr>
        <tr>
            <td class="text-right">Boletas</td> 
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '1');"><?php echo "S/".number_format($get_boleta[0]['Enero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '2');"><?php echo "S/".number_format($get_boleta[0]['Febrero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '3');"><?php echo "S/".number_format($get_boleta[0]['Marzo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '4');"><?php echo "S/".number_format($get_boleta[0]['Abril'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '5');"><?php echo "S/".number_format($get_boleta[0]['Mayo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '6');"><?php echo "S/".number_format($get_boleta[0]['Junio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '7');"><?php echo "S/".number_format($get_boleta[0]['Julio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '8');"><?php echo "S/".number_format($get_boleta[0]['Agosto'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '9');"><?php echo "S/".number_format($get_boleta[0]['Septiembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '10');"><?php echo "S/".number_format($get_boleta[0]['Octubre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '11');"><?php echo "S/".number_format($get_boleta[0]['Noviembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '12');"><?php echo "S/".number_format($get_boleta[0]['Diciembre'],2); ?></a></td>
            <td class="text-right"><?php echo "S/".number_format($get_boleta[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Cuentas Por Cobrar</td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '1');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Enero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '2');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Febrero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '3');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Marzo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '4');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Abril'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '5');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Mayo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '6');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Junio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '7');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Julio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '8');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Agosto'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '9');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Septiembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '10');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Octubre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '11');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Noviembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_CC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '12');"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Diciembre'],2); ?></a></td>
            <td class="text-right"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Facturas</td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '1');"><?php echo "S/".number_format($get_factura[0]['Enero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '2');"><?php echo "S/".number_format($get_factura[0]['Febrero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '3');"><?php echo "S/".number_format($get_factura[0]['Marzo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '4');"><?php echo "S/".number_format($get_factura[0]['Abril'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '5');"><?php echo "S/".number_format($get_factura[0]['Mayo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '6');"><?php echo "S/".number_format($get_factura[0]['Junio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '7');"><?php echo "S/".number_format($get_factura[0]['Julio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '8');"><?php echo "S/".number_format($get_factura[0]['Agosto'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '9');"><?php echo "S/".number_format($get_factura[0]['Septiembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '10');"><?php echo "S/".number_format($get_factura[0]['Octubre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '11');"><?php echo "S/".number_format($get_factura[0]['Noviembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_FT('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '12');"><?php echo "S/".number_format($get_factura[0]['Diciembre'],2); ?></a></td>
            <td class="text-right"><?php echo "S/".number_format($get_factura[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Notas de Debito</td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '1');"><?php echo "S/".number_format($get_nota_debito[0]['Enero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '2');"><?php echo "S/".number_format($get_nota_debito[0]['Febrero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '3');"><?php echo "S/".number_format($get_nota_debito[0]['Marzo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '4');"><?php echo "S/".number_format($get_nota_debito[0]['Abril'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '5');"><?php echo "S/".number_format($get_nota_debito[0]['Mayo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '6');"><?php echo "S/".number_format($get_nota_debito[0]['Junio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '7');"><?php echo "S/".number_format($get_nota_debito[0]['Julio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '8');"><?php echo "S/".number_format($get_nota_debito[0]['Agosto'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '9');"><?php echo "S/".number_format($get_nota_debito[0]['Septiembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '10');"><?php echo "S/".number_format($get_nota_debito[0]['Octubre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '11');"><?php echo "S/".number_format($get_nota_debito[0]['Noviembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_ND('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '12');"><?php echo "S/".number_format($get_nota_debito[0]['Diciembre'],2); ?></a></td>
            <td class="text-right"><?php echo "S/".number_format($get_nota_debito[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Notas de Credito</td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '1');"><?php echo "S/".number_format($get_nota_credito[0]['Enero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '2');"><?php echo "S/".number_format($get_nota_credito[0]['Febrero'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '3');"><?php echo "S/".number_format($get_nota_credito[0]['Marzo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '4');"><?php echo "S/".number_format($get_nota_credito[0]['Abril'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '5');"><?php echo "S/".number_format($get_nota_credito[0]['Mayo'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '6');"><?php echo "S/".number_format($get_nota_credito[0]['Junio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '7');"><?php echo "S/".number_format($get_nota_credito[0]['Julio'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '8');"><?php echo "S/".number_format($get_nota_credito[0]['Agosto'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '9');"><?php echo "S/".number_format($get_nota_credito[0]['Septiembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '10');"><?php echo "S/".number_format($get_nota_credito[0]['Octubre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '11');"><?php echo "S/".number_format($get_nota_credito[0]['Noviembre'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Resumen_Oficial_NC('<?php echo $empresa; ?>', '<?php echo $anio; ?>', '12');"><?php echo "S/".number_format($get_nota_credito[0]['Diciembre'],2); ?></a></td>
            <td class="text-right"><?php echo "S/".number_format($get_nota_credito[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td rowspan="2" style="background-color:#ff0000;color:#ffffff;">GASTOS</td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Enero'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Febrero'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Marzo'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Abril'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Mayo'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Junio'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Julio'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Agosto'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Septiembre'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Octubre'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Noviembre'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($get_gasto[0]['Diciembre'],2); ?></td>
            <td class="text-right" style="background-color:#ff0000;color:#ffffff;"><?php echo "S/".number_format($get_gasto[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;"><?php echo number_format($diferencia_gasto_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ff0000;color:#ffffff;"><?php echo number_format($diferencia_gasto_total,2)."%"; ?></td>
        </tr>
        <?php foreach($list_gastos as $list){ ?>
            <tr>
                <td class="text-right"><?php echo substr($list['Description'],5); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Enero'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Febrero'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Marzo'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Abril'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Mayo'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Junio'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Julio'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Agosto'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Septiembre'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Octubre'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Noviembre'],2); ?></td>
                <td class="text-right" style="background-color:#ffe1e2;"><?php echo "S/".number_format($list['Diciembre'],2); ?></td>
                <td class="text-right" style="background-color:#ff0000;color:#ffffff;"><?php echo "S/".number_format($list['Total'],2); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td rowspan="2" style="background-color:#779ecb;color:#ffffff;">UTILIDAD (Before Tax)</td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_enero,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_febrero,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_marzo,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_abril,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_mayo,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_junio,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_julio,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_agosto,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_septiembre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_octubre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_noviembre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo "S/".number_format($before_diciembre,2); ?></td>
            <td class="text-right" style="background-color:#779ecb;color:#ffffff;"><?php echo "S/".number_format($before_total,2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;"><?php echo number_format($diferencia_before_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#779ecb;color:#ffffff;"><?php echo number_format($diferencia_before_total,2)."%"; ?></td>
        </tr>
        <tr>
            <td rowspan="2" style="background-color:#9b9b9b;color:#ffffff;">IMPUESTOS</td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Enero'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Febrero'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Marzo'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Abril'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Mayo'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Junio'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Julio'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Agosto'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Septiembre'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Octubre'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Noviembre'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo "S/".number_format($get_impuesto[0]['Diciembre'],2); ?></td>
            <td class="text-right" style="background-color:#9b9b9b;color:#ffffff;"><?php echo "S/".number_format($get_impuesto[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;"><?php echo number_format($diferencia_impuesto_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#9b9b9b;color:#ffffff;"><?php echo number_format($diferencia_impuesto_total,2)."%"; ?></td>
        </tr>
        <tr>
            <td class="text-right"><b>Renta</b></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Enero'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Febrero'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Marzo'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Abril'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Mayo'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Junio'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Julio'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Agosto'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Septiembre'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Octubre'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Noviembre'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Diciembre'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_impuesto[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td rowspan="2" style="background-color:#1976d2;color:#ffffff;">UTILIDAD (After Tax)</td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_enero,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_febrero,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_marzo,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_abril,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_mayo,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_junio,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_julio,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_agosto,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_septiembre,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_octubre,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_noviembre,2); ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo "S/".number_format($after_diciembre,2); ?></td>
            <td class="text-right" style="background-color:#1976d2;color:#ffffff;"><?php echo "S/".number_format($after_total,2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;"><?php echo number_format($diferencia_after_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#1976d2;color:#ffffff;"><?php echo number_format($diferencia_after_total,2)."%"; ?></td>
        </tr>
    </tbody>
</table>