<style>
    #tabla_balance_real th{
        font-size: 14px !important;
    }

    #tabla_balance_real td{
        font-size: 14px !important;
    }

    #tabla_balance_real td:first-child[content^="-"] {
        color: red !important;
    }
</style>

<?php
    /*ANTIGUO*/
    /*INGRESOS*/
    $ingreso_enero_ant=$get_cierre_caja_ant[0]['Enero']+$get_doc_sunat_ant[0]['Enero']-$get_nota_credito_ant[0]['Enero']-$get_cuentas_por_cobrar_ant[0]['Enero'];
    $ingreso_febrero_ant=$get_cierre_caja_ant[0]['Febrero']+$get_doc_sunat_ant[0]['Febrero']-$get_nota_credito_ant[0]['Febrero']-$get_cuentas_por_cobrar_ant[0]['Febrero'];
    $ingreso_marzo_ant=$get_cierre_caja_ant[0]['Marzo']+$get_doc_sunat_ant[0]['Marzo']-$get_nota_credito_ant[0]['Marzo']-$get_cuentas_por_cobrar_ant[0]['Marzo'];
    $ingreso_abril_ant=$get_cierre_caja_ant[0]['Abril']+$get_doc_sunat_ant[0]['Abril']-$get_nota_credito_ant[0]['Abril']-$get_cuentas_por_cobrar_ant[0]['Abril'];
    $ingreso_mayo_ant=$get_cierre_caja_ant[0]['Mayo']+$get_doc_sunat_ant[0]['Mayo']-$get_nota_credito_ant[0]['Mayo']-$get_cuentas_por_cobrar_ant[0]['Mayo'];
    $ingreso_junio_ant=$get_cierre_caja_ant[0]['Junio']+$get_doc_sunat_ant[0]['Junio']-$get_nota_credito_ant[0]['Junio']-$get_cuentas_por_cobrar_ant[0]['Junio'];
    $ingreso_julio_ant=$get_cierre_caja_ant[0]['Julio']+$get_doc_sunat_ant[0]['Julio']-$get_nota_credito_ant[0]['Julio']-$get_cuentas_por_cobrar_ant[0]['Julio'];
    $ingreso_agosto_ant=$get_cierre_caja_ant[0]['Agosto']+$get_doc_sunat_ant[0]['Agosto']-$get_nota_credito_ant[0]['Agosto']-$get_cuentas_por_cobrar_ant[0]['Agosto'];
    $ingreso_septiembre_ant=$get_cierre_caja_ant[0]['Septiembre']+$get_doc_sunat_ant[0]['Septiembre']-$get_nota_credito_ant[0]['Septiembre']-$get_cuentas_por_cobrar_ant[0]['Septiembre'];
    $ingreso_octubre_ant=$get_cierre_caja_ant[0]['Octubre']+$get_doc_sunat_ant[0]['Octubre']-$get_nota_credito_ant[0]['Octubre']-$get_cuentas_por_cobrar_ant[0]['Octubre'];
    $ingreso_noviembre_ant=$get_cierre_caja_ant[0]['Noviembre']+$get_doc_sunat_ant[0]['Noviembre']-$get_nota_credito_ant[0]['Noviembre']-$get_cuentas_por_cobrar_ant[0]['Noviembre'];
    $ingreso_diciembre_ant=$get_cierre_caja_ant[0]['Diciembre']+$get_doc_sunat_ant[0]['Diciembre']-$get_nota_credito_ant[0]['Diciembre']-$get_cuentas_por_cobrar_ant[0]['Diciembre'];
    $ingreso_total_ant=$get_cierre_caja_ant[0]['Total']+$get_doc_sunat_ant[0]['Total']-$get_nota_credito_ant[0]['Total']-$get_cuentas_por_cobrar_ant[0]['Total'];

    /*UTILIDAD(BEFORE TAX)*/
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

    /*UTILIDAD(AFTER TAX)*/
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
    $ingreso_enero=$get_cierre_caja[0]['Enero']+$get_doc_sunat[0]['Enero']-$get_nota_credito[0]['Enero']-$get_cuentas_por_cobrar[0]['Enero'];
    $ingreso_febrero=$get_cierre_caja[0]['Febrero']+$get_doc_sunat[0]['Febrero']-$get_nota_credito[0]['Febrero']-$get_cuentas_por_cobrar[0]['Febrero'];
    $ingreso_marzo=$get_cierre_caja[0]['Marzo']+$get_doc_sunat[0]['Marzo']-$get_nota_credito[0]['Marzo']-$get_cuentas_por_cobrar[0]['Marzo'];
    $ingreso_abril=$get_cierre_caja[0]['Abril']+$get_doc_sunat[0]['Abril']-$get_nota_credito[0]['Abril']-$get_cuentas_por_cobrar[0]['Abril'];
    $ingreso_mayo=$get_cierre_caja[0]['Mayo']+$get_doc_sunat[0]['Mayo']-$get_nota_credito[0]['Mayo']-$get_cuentas_por_cobrar[0]['Mayo'];
    $ingreso_junio=$get_cierre_caja[0]['Junio']+$get_doc_sunat[0]['Junio']-$get_nota_credito[0]['Junio']-$get_cuentas_por_cobrar[0]['Junio'];
    $ingreso_julio=$get_cierre_caja[0]['Julio']+$get_doc_sunat[0]['Julio']-$get_nota_credito[0]['Julio']-$get_cuentas_por_cobrar[0]['Julio'];
    $ingreso_agosto=$get_cierre_caja[0]['Agosto']+$get_doc_sunat[0]['Agosto']-$get_nota_credito[0]['Agosto']-$get_cuentas_por_cobrar[0]['Agosto'];
    $ingreso_septiembre=$get_cierre_caja[0]['Septiembre']+$get_doc_sunat[0]['Septiembre']-$get_nota_credito[0]['Septiembre']-$get_cuentas_por_cobrar[0]['Septiembre'];
    $ingreso_octubre=$get_cierre_caja[0]['Octubre']+$get_doc_sunat[0]['Octubre']-$get_nota_credito[0]['Octubre']-$get_cuentas_por_cobrar[0]['Octubre'];
    $ingreso_noviembre=$get_cierre_caja[0]['Noviembre']+$get_doc_sunat[0]['Noviembre']-$get_nota_credito[0]['Noviembre']-$get_cuentas_por_cobrar[0]['Noviembre'];
    $ingreso_diciembre=$get_cierre_caja[0]['Diciembre']+$get_doc_sunat[0]['Diciembre']-$get_nota_credito[0]['Diciembre']-$get_cuentas_por_cobrar[0]['Diciembre'];
    $ingreso_total=$get_cierre_caja[0]['Total']+$get_doc_sunat[0]['Total']-$get_nota_credito[0]['Total']-$get_cuentas_por_cobrar[0]['Total'];

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

    /*CAPITAL-TOTAL*/
    $capital_enero=$get_aumento[0]['Enero']-$get_salida[0]['Enero']-$get_gasto_personal[0]['Enero'];
    $capital_febrero=$get_aumento[0]['Febrero']-$get_salida[0]['Febrero']-$get_gasto_personal[0]['Febrero'];
    $capital_marzo=$get_aumento[0]['Marzo']-$get_salida[0]['Marzo']-$get_gasto_personal[0]['Marzo'];
    $capital_abril=$get_aumento[0]['Abril']-$get_salida[0]['Abril']-$get_gasto_personal[0]['Abril'];
    $capital_mayo=$get_aumento[0]['Mayo']-$get_salida[0]['Mayo']-$get_gasto_personal[0]['Mayo'];
    $capital_junio=$get_aumento[0]['Junio']-$get_salida[0]['Junio']-$get_gasto_personal[0]['Junio'];
    $capital_julio=$get_aumento[0]['Julio']-$get_salida[0]['Julio']-$get_gasto_personal[0]['Julio'];
    $capital_agosto=$get_aumento[0]['Agosto']-$get_salida[0]['Agosto']-$get_gasto_personal[0]['Agosto'];
    $capital_septiembre=$get_aumento[0]['Septiembre']-$get_salida[0]['Septiembre']-$get_gasto_personal[0]['Septiembre'];
    $capital_octubre=$get_aumento[0]['Octubre']-$get_salida[0]['Octubre']-$get_gasto_personal[0]['Octubre'];
    $capital_noviembre=$get_aumento[0]['Noviembre']-$get_salida[0]['Noviembre']-$get_gasto_personal[0]['Noviembre'];
    $capital_diciembre=$get_aumento[0]['Diciembre']-$get_salida[0]['Diciembre']-$get_gasto_personal[0]['Diciembre'];
    $capital_total=$get_aumento[0]['Total']-$get_salida[0]['Total']-$get_gasto_personal[0]['Total'];

    /*PENDIENTES*/
    $pendiente_febrero=$get_cuentas_por_cobrar[0]['Enero']+$get_cuentas_por_cobrar[0]['Febrero'];
    $pendiente_marzo=$pendiente_febrero+$get_cuentas_por_cobrar[0]['Marzo'];
    $pendiente_abril=$pendiente_marzo+$get_cuentas_por_cobrar[0]['Abril'];
    $pendiente_mayo=$pendiente_abril+$get_cuentas_por_cobrar[0]['Mayo'];
    $pendiente_junio=$pendiente_mayo+$get_cuentas_por_cobrar[0]['Junio'];
    $pendiente_julio=$pendiente_junio+$get_cuentas_por_cobrar[0]['Julio'];
    $pendiente_agosto=$pendiente_julio+$get_cuentas_por_cobrar[0]['Agosto'];
    $pendiente_septiembre=$pendiente_agosto+$get_cuentas_por_cobrar[0]['Septiembre'];
    $pendiente_octubre=$pendiente_septiembre+$get_cuentas_por_cobrar[0]['Octubre'];
    $pendiente_noviembre=$pendiente_octubre+$get_cuentas_por_cobrar[0]['Noviembre'];
    $pendiente_diciembre=$pendiente_noviembre+$get_cuentas_por_cobrar[0]['Diciembre'];

    /*ACUMULADO*/
    $acumulado_febrero=$get_acumulado[0]['Enero']+$get_acumulado[0]['Febrero'];
    $acumulado_marzo=$acumulado_febrero+$get_acumulado[0]['Marzo'];
    $acumulado_abril=$acumulado_marzo+$get_acumulado[0]['Abril'];
    $acumulado_mayo=$acumulado_abril+$get_acumulado[0]['Mayo'];
    $acumulado_junio=$acumulado_mayo+$get_acumulado[0]['Junio'];
    $acumulado_julio=$acumulado_junio+$get_acumulado[0]['Julio'];
    $acumulado_agosto=$acumulado_julio+$get_acumulado[0]['Agosto'];
    $acumulado_septiembre=$acumulado_agosto+$get_acumulado[0]['Septiembre'];
    $acumulado_octubre=$acumulado_septiembre+$get_acumulado[0]['Octubre'];
    $acumulado_noviembre=$acumulado_octubre+$get_acumulado[0]['Noviembre'];
    $acumulado_diciembre=$acumulado_noviembre+$get_acumulado[0]['Diciembre'];

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

<table id="tabla_balance_real" width="100%" border="1" align="center" cellpadding="1" cellspacing="1">
    <thead>
        <tr>
            <th width="" style="background-color:#ffffff;">&nbsp;</th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Ene-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Feb-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Mar-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Abr-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">May-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Jun-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Jul-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Ago-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Set-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Oct-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Nov-<?php echo substr(date('Y'),-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Dic-<?php echo substr(date('Y'),-2); ?></th>
            <th width="" style="background-color:#ffffff;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="2" style="background-color:#8dbf42;color:#ffffff;">INGRESOS</td> 
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Enero']+$get_doc_sunat[0]['Enero']-$get_nota_credito[0]['Enero'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Enero']+$get_doc_sunat[0]['Enero']-$get_nota_credito[0]['Enero']),2); ?><?php //echo "S/".number_format($ingreso_enero,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Febrero']+$get_doc_sunat[0]['Febrero']-$get_nota_credito[0]['Febrero'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Febrero']+$get_doc_sunat[0]['Febrero']-$get_nota_credito[0]['Febrero']),2); ?><?php //echo "S/".number_format($ingreso_febrero,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Marzo']+$get_doc_sunat[0]['Marzo']-$get_nota_credito[0]['Marzo'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Marzo']+$get_doc_sunat[0]['Marzo']-$get_nota_credito[0]['Marzo']),2); ?><?php //echo "S/".number_format($ingreso_marzo,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Abril']+$get_doc_sunat[0]['Abril']-$get_nota_credito[0]['Abril'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Abril']+$get_doc_sunat[0]['Abril']-$get_nota_credito[0]['Abril']),2); ?><?php //echo "S/".number_format($ingreso_abril,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Mayo']+$get_doc_sunat[0]['Mayo']-$get_nota_credito[0]['Mayo'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Mayo']+$get_doc_sunat[0]['Mayo']-$get_nota_credito[0]['Mayo']),2); ?><?php //echo "S/".number_format($ingreso_mayo,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Junio']+$get_doc_sunat[0]['Junio']-$get_nota_credito[0]['Junio'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Junio']+$get_doc_sunat[0]['Junio']-$get_nota_credito[0]['Junio']),2); ?><?php //echo "S/".number_format($ingreso_junio,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Julio']+$get_doc_sunat[0]['Julio']-$get_nota_credito[0]['Julio'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Julio']+$get_doc_sunat[0]['Julio']-$get_nota_credito[0]['Julio']),2); ?><?php //echo "S/".number_format($ingreso_julio,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Agosto']+$get_doc_sunat[0]['Agosto']-$get_nota_credito[0]['Agosto'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Agosto']+$get_doc_sunat[0]['Agosto']-$get_nota_credito[0]['Agosto']),2); ?><?php //echo "S/".number_format($ingreso_agosto,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Septiembre']+$get_doc_sunat[0]['Septiembre']-$get_nota_credito[0]['Septiembre'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Septiembre']+$get_doc_sunat[0]['Septiembre']-$get_nota_credito[0]['Septiembre']),2); ?><?php //echo "S/".number_format($ingreso_septiembre,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Octubre']+$get_doc_sunat[0]['Octubre']-$get_nota_credito[0]['Octubre'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Octubre']+$get_doc_sunat[0]['Octubre']-$get_nota_credito[0]['Octubre']),2); ?><?php //echo "S/".number_format($ingreso_octubre,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Noviembre']+$get_doc_sunat[0]['Noviembre']-$get_nota_credito[0]['Noviembre'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Noviembre']+$get_doc_sunat[0]['Noviembre']-$get_nota_credito[0]['Noviembre']),2); ?><?php //echo "S/".number_format($ingreso_noviembre,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if(($get_cierre_caja[0]['Diciembre']+$get_doc_sunat[0]['Diciembre']-$get_nota_credito[0]['Diciembre'])<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format(($get_cierre_caja[0]['Diciembre']+$get_doc_sunat[0]['Diciembre']-$get_nota_credito[0]['Diciembre']),2); ?><?php //echo "S/".number_format($ingreso_diciembre,2); ?></td>
            <td class="text-right" style="background-color:#8dbf42;<?php if($ingreso_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo "S/".number_format($ingreso_total,2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_enero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_febrero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_marzo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_abril<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_mayo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_junio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_julio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_agosto<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_septiembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_octubre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_noviembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;<?php if($diferencia_ingreso_diciembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_ingreso_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#8dbf42;<?php if($diferencia_ingreso_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo number_format($diferencia_ingreso_total,2)."%"; ?></td>
        </tr>
        <tr>
            <td class="text-right">Productos</td>
            <td class="text-right" <?php if($ingreso_enero<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_enero,2); ?></td>
            <td class="text-right" <?php if($ingreso_febrero<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_febrero,2); ?></td>
            <td class="text-right" <?php if($ingreso_marzo<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_marzo,2); ?></td>
            <td class="text-right" <?php if($ingreso_abril<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_abril,2); ?></td>
            <td class="text-right" <?php if($ingreso_mayo<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_mayo,2); ?></td>
            <td class="text-right" <?php if($ingreso_junio<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_junio,2); ?></td>
            <td class="text-right" <?php if($ingreso_julio<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_julio,2); ?></td>
            <td class="text-right" <?php if($ingreso_agosto<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_agosto,2); ?></td>
            <td class="text-right" <?php if($ingreso_septiembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_septiembre,2); ?></td>
            <td class="text-right" <?php if($ingreso_octubre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_octubre,2); ?></td>
            <td class="text-right" <?php if($ingreso_noviembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_noviembre,2); ?></td>
            <td class="text-right" <?php if($ingreso_diciembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_diciembre,2); ?></td>
            <td class="text-right" <?php if($ingreso_total<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($ingreso_total,2); ?></td>
        </tr>
        <tr style="background-color:#F2F2F2;">
            <td class="text-right"><b>Cierre Caja (Cash)</b></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Enero'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Febrero'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Marzo'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Abril'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Mayo'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Junio'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Julio'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Agosto'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Septiembre'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Octubre'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Noviembre'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Diciembre'],2); ?></td>
            <td class="text-right" <?php if($get_cierre_caja[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cierre_caja[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Recibos</td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Enero']-$get_caja_devolucion[0]['Enero'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Enero']-$get_caja_devolucion[0]['Enero']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Febrero']-$get_caja_devolucion[0]['Febrero'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Febrero']-$get_caja_devolucion[0]['Febrero']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Marzo']-$get_caja_devolucion[0]['Marzo'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Marzo']-$get_caja_devolucion[0]['Marzo']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Abril']-$get_caja_devolucion[0]['Abril'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Abril']-$get_caja_devolucion[0]['Abril']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Mayo']-$get_caja_devolucion[0]['Mayo'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Mayo']-$get_caja_devolucion[0]['Mayo']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Junio']-$get_caja_devolucion[0]['Junio'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Junio']-$get_caja_devolucion[0]['Junio']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Julio']-$get_caja_devolucion[0]['Julio'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Julio']-$get_caja_devolucion[0]['Julio']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Agosto']-$get_caja_devolucion[0]['Agosto'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Agosto']-$get_caja_devolucion[0]['Agosto']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Septiembre']-$get_caja_devolucion[0]['Septiembre'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Septiembre']-$get_caja_devolucion[0]['Septiembre']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Octubre']-$get_caja_devolucion[0]['Octubre'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Octubre']-$get_caja_devolucion[0]['Octubre']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Noviembre']-$get_caja_devolucion[0]['Noviembre'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Noviembre']-$get_caja_devolucion[0]['Noviembre']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Diciembre']-$get_caja_devolucion[0]['Diciembre'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Diciembre']-$get_caja_devolucion[0]['Diciembre']),2); ?></td>
            <td class="text-right" <?php if(($get_cierre_caja[0]['Total']-$get_caja_devolucion[0]['Total'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_cierre_caja[0]['Total']-$get_caja_devolucion[0]['Total']),2); ?></td>
        </tr>
        <tr style="background-color:#F2F2F2;">
            <td class="text-right">Devoluciones</td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Enero'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Febrero'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Marzo'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Abril'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Mayo'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Junio'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Julio'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Agosto'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Septiembre'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Octubre'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Noviembre'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Diciembre'],2); ?></td>
            <td class="text-right" <?php if($get_caja_devolucion[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_caja_devolucion[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right"><b>Cierre Caja (BBVA)</b></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Enero']-$get_nota_credito[0]['Enero'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Enero']-$get_nota_credito[0]['Enero']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Febrero']-$get_nota_credito[0]['Febrero'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Febrero']-$get_nota_credito[0]['Febrero']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Marzo']-$get_nota_credito[0]['Marzo'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Marzo']-$get_nota_credito[0]['Marzo']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Abril']-$get_nota_credito[0]['Abril'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Abril']-$get_nota_credito[0]['Abril']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Mayo']-$get_nota_credito[0]['Mayo'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Mayo']-$get_nota_credito[0]['Mayo']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Junio']-$get_nota_credito[0]['Junio'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Junio']-$get_nota_credito[0]['Junio']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Julio']-$get_nota_credito[0]['Julio'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Julio']-$get_nota_credito[0]['Julio']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Agosto']-$get_nota_credito[0]['Agosto'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Agosto']-$get_nota_credito[0]['Agosto']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Septiembre']-$get_nota_credito[0]['Septiembre'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Septiembre']-$get_nota_credito[0]['Septiembre']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Octubre']-$get_nota_credito[0]['Octubre'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Octubre']-$get_nota_credito[0]['Octubre']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Noviembre']-$get_nota_credito[0]['Noviembre'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Noviembre']-$get_nota_credito[0]['Noviembre']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Diciembre']-$get_nota_credito[0]['Diciembre'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Diciembre']-$get_nota_credito[0]['Diciembre']),2); ?></td>
            <td class="text-right" <?php if(($get_doc_sunat[0]['Total']-$get_nota_credito[0]['Total'])<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format(($get_doc_sunat[0]['Total']-$get_nota_credito[0]['Total']),2); ?></td>
        </tr>
        <tr style="background-color:#F2F2F2;">
            <td class="text-right">Doc Sunat</td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Enero'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Febrero'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Marzo'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Abril'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Mayo'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Junio'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Julio'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Agosto'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Septiembre'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Octubre'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Noviembre'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Diciembre'],2); ?></td>
            <td class="text-right" <?php if($get_doc_sunat[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_doc_sunat[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Notas Credito</td>
            <td class="text-right" <?php if($get_nota_credito[0]['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Enero'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Febrero'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Marzo'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Abril'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Mayo'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Junio'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Julio'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Agosto'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Septiembre'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Octubre'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Noviembre'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Diciembre'],2); ?></td>
            <td class="text-right" <?php if($get_nota_credito[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_nota_credito[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td rowspan="2" style="background-color:#ff0000;color:#ffffff;">GASTOS</td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Enero']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Enero'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Febrero']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Febrero'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Marzo']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Marzo'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Abril']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Abril'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Mayo']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Mayo'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Junio']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Junio'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Julio']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Julio'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Agosto']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Agosto'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Septiembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Septiembre'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Octubre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Octubre'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Noviembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Noviembre'],2); ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($get_gasto[0]['Diciembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Diciembre'],2); ?></td>
            <td class="text-right" style="background-color:#ff0000;<?php if($get_gasto[0]['Total']<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo "S/".number_format($get_gasto[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_enero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_febrero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_marzo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_abril<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_mayo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_junio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_julio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_agosto<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_septiembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_octubre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_noviembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ffe1e2;<?php if($diferencia_gasto_diciembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_gasto_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#ff0000;<?php if($diferencia_gasto_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo number_format($diferencia_gasto_total,2)."%"; ?></td>
        </tr>
        <?php 
        $i=1;
        foreach($list_gastos as $list){ ?>
            <tr <?php if($i%2==0){echo "style='background-color:#F2F2F2;'";} ?>>
                <td class="text-right"><?php echo $list['Name']; ?></td>
                <td class="text-right" <?php if($list['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Enero'],2); ?></td>
                <td class="text-right" <?php if($list['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Febrero'],2); ?></td>
                <td class="text-right" <?php if($list['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Marzo'],2); ?></td>
                <td class="text-right" <?php if($list['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Abril'],2); ?></td>
                <td class="text-right" <?php if($list['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Mayo'],2); ?></td>
                <td class="text-right" <?php if($list['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Junio'],2); ?></td>
                <td class="text-right" <?php if($list['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Julio'],2); ?></td>
                <td class="text-right" <?php if($list['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Agosto'],2); ?></td>
                <td class="text-right" <?php if($list['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Septiembre'],2); ?></td>
                <td class="text-right" <?php if($list['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Octubre'],2); ?></td>
                <td class="text-right" <?php if($list['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Noviembre'],2); ?></td>
                <td class="text-right" <?php if($list['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Diciembre'],2); ?></td>
                <td class="text-right" <?php if($list['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Total'],2); ?></td>
            </tr>
        <?php $i=$i+1;} ?>
        <tr>
            <td rowspan="2" style="background-color:#779ecb;color:#ffffff;">UTILIDAD (Before Tax)</td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_enero<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_enero,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_febrero<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_febrero,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_marzo<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_marzo,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_abril<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_abril,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_mayo<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_mayo,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_junio<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_junio,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_julio<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_julio,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_agosto<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_agosto,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_septiembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_septiembre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_octubre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_octubre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_noviembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_noviembre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($before_diciembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($before_diciembre,2); ?></td>
            <td class="text-right" style="background-color:#779ecb;<?php if($before_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo "S/".number_format($before_total,2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_enero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_febrero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_marzo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_abril<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_mayo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_junio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_julio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_agosto<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_septiembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_octubre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_noviembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e3f2fd;<?php if($diferencia_before_diciembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_before_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#779ecb;<?php if($diferencia_before_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo number_format($diferencia_before_total,2)."%"; ?></td>
        </tr>
        <tr>
            <td rowspan="2" style="background-color:#9b9b9b;color:#ffffff;">IMPUESTOS</td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Enero']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Enero'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Febrero']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Febrero'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Marzo']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Marzo'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Abril']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Abril'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Mayo']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Mayo'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Junio']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Junio'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Julio']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Julio'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Agosto']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Agosto'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Septiembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Septiembre'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Octubre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Octubre'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Noviembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Noviembre'],2); ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($get_impuesto[0]['Diciembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Diciembre'],2); ?></td>
            <td class="text-right" style="background-color:#9b9b9b;<?php if($get_impuesto[0]['Total']<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo "S/".number_format($get_impuesto[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_enero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_febrero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_marzo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_abril<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_mayo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_junio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_julio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_agosto<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_septiembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_octubre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_noviembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#cdcdcd;<?php if($diferencia_impuesto_diciembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_impuesto_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#9b9b9b;<?php if($diferencia_impuesto_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo number_format($diferencia_impuesto_total,2)."%"; ?></td>
        </tr>
        <?php
        $j=1;
        foreach($list_impuestos as $list){ ?>
            <tr <?php if($j%2==0){echo "style='background-color:#F2F2F2;'";} ?>>
                <td class="text-right"><?php echo $list['Name']; ?></td>
                <td class="text-right" <?php if($list['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Enero'],2); ?></td>
                <td class="text-right" <?php if($list['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Febrero'],2); ?></td>
                <td class="text-right" <?php if($list['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Marzo'],2); ?></td>
                <td class="text-right" <?php if($list['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Abril'],2); ?></td>
                <td class="text-right" <?php if($list['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Mayo'],2); ?></td>
                <td class="text-right" <?php if($list['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Junio'],2); ?></td>
                <td class="text-right" <?php if($list['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Julio'],2); ?></td>
                <td class="text-right" <?php if($list['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Agosto'],2); ?></td>
                <td class="text-right" <?php if($list['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Septiembre'],2); ?></td>
                <td class="text-right" <?php if($list['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Octubre'],2); ?></td>
                <td class="text-right" <?php if($list['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Noviembre'],2); ?></td>
                <td class="text-right" <?php if($list['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Diciembre'],2); ?></td>
                <td class="text-right" <?php if($list['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($list['Total'],2); ?></td>
            </tr>
        <?php $j=$j+1;} ?>
        <tr>
            <td rowspan="2" style="background-color:#1976d2;color:#ffffff;">UTILIDAD (After Tax)</td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_enero<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_enero,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_febrero<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_febrero,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_marzo<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_marzo,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_abril<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_abril,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_mayo<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_mayo,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_junio<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_junio,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_julio<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_julio,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_agosto<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_agosto,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_septiembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_septiembre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_octubre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_octubre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_noviembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_noviembre,2); ?></td>
            <td class="text-right" style="background-color:#e3f2fe;<?php if($after_diciembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($after_diciembre,2); ?></td>
            <td class="text-right" style="background-color:#1976d2;<?php if($after_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo "S/".number_format($after_total,2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_enero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_enero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_febrero<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_febrero,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_marzo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_marzo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_abril<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_abril,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_mayo<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_mayo,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_junio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_junio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_julio<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_julio,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_agosto<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_agosto,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_septiembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_septiembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_octubre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_octubre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_noviembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_noviembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e1f5fe;<?php if($diferencia_after_diciembre<0){ echo "color:red;"; } ?>"><?php echo number_format($diferencia_after_diciembre,2)."%"; ?></td>
            <td class="text-right" style="background-color:#1976d2;<?php if($diferencia_after_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo number_format($diferencia_after_total,2)."%"; ?></td>
        </tr>
        <tr>
            <td style="background-color:#ff8000;color:#ffffff;">CAPITAL</td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_enero<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_enero,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_febrero<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_febrero,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_marzo<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_marzo,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_abril<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_abril,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_mayo<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_mayo,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_junio<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_junio,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_julio<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_julio,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_agosto<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_agosto,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_septiembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_septiembre,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_octubre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_octubre,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_noviembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_noviembre,2); ?></td>
            <td class="text-right" style="background-color:#ffe0b2;<?php if($capital_diciembre<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($capital_diciembre,2); ?></td>
            <td class="text-right" style="background-color:#ff8000;<?php if($capital_total<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo "S/".number_format($capital_total,2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Aumento</td>
            <td class="text-right" <?php if($get_aumento[0]['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Enero'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Febrero'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Marzo'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Abril'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Mayo'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Junio'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Julio'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Agosto'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Septiembre'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Octubre'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Noviembre'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Diciembre'],2); ?></td>
            <td class="text-right" <?php if($get_aumento[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_aumento[0]['Total'],2); ?></td>
        </tr>
        <tr style="background-color:#F2F2F2;">
            <td class="text-right">Salida</td>
            <td class="text-right" <?php if($get_salida[0]['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Enero'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Febrero'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Marzo'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Abril'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Mayo'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Junio'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Julio'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Agosto'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Septiembre'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Octubre'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Noviembre'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Diciembre'],2); ?></td>
            <td class="text-right" <?php if($get_salida[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_salida[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Gastos Personales</td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Enero'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Febrero'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Marzo'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Abril'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Mayo'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Junio'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Julio'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Agosto'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Septiembre'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Octubre'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Noviembre'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Diciembre'],2); ?></td>
            <td class="text-right" <?php if($get_gasto_personal[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_gasto_personal[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td style="background-color:#4a148c;color:#ffffff;">Cuentas por Cobrar</td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Enero']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Enero'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Febrero']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Febrero'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Marzo']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Marzo'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Abril']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Abril'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Mayo']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Mayo'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Junio']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Junio'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Julio']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Julio'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Agosto']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Agosto'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Septiembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Septiembre'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Octubre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Octubre'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Noviembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Noviembre'],2); ?></td>
            <td class="text-right" style="background-color:#f3e5f5;<?php if($get_cuentas_por_cobrar[0]['Diciembre']<0){ echo "color:red;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Diciembre'],2); ?></td>
            <td class="text-right" style="background-color:#4a148c;<?php if($get_cuentas_por_cobrar[0]['Total']<0){ echo "color:red;"; }else{ echo "color:white;"; } ?>"><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Mes</td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Enero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Enero'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Febrero']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Febrero'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Marzo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Marzo'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Abril']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Abril'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Mayo']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Mayo'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Junio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Junio'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Julio']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Julio'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Agosto']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Agosto'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Septiembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Septiembre'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Octubre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Octubre'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Noviembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Noviembre'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Diciembre']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Diciembre'],2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Total'],2); ?></td>
        </tr>
        <tr style="background-color:#F2F2F2;">
            <td class="text-right">Pendientes</td>
            <td class="text-right"></td>
            <td class="text-right" <?php if($pendiente_febrero<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_febrero,2); ?></td>
            <td class="text-right" <?php if($pendiente_marzo<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_marzo,2); ?></td>
            <td class="text-right" <?php if($pendiente_abril<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_abril,2); ?></td>
            <td class="text-right" <?php if($pendiente_mayo<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_mayo,2); ?></td>
            <td class="text-right" <?php if($pendiente_junio<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_junio,2); ?></td>
            <td class="text-right" <?php if($pendiente_julio<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_julio,2); ?></td>
            <td class="text-right" <?php if($pendiente_agosto<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_agosto,2); ?></td>
            <td class="text-right" <?php if($pendiente_septiembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_septiembre,2); ?></td>
            <td class="text-right" <?php if($pendiente_octubre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_octubre,2); ?></td>
            <td class="text-right" <?php if($pendiente_noviembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_noviembre,2); ?></td>
            <td class="text-right" <?php if($pendiente_diciembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($pendiente_diciembre,2); ?></td>
            <td class="text-right" <?php if($get_cuentas_por_cobrar[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_cuentas_por_cobrar[0]['Total'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Acumulado</td>
            <td class="text-right"></td>
            <td class="text-right" <?php if($acumulado_febrero<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_febrero,2); ?></td>
            <td class="text-right" <?php if($acumulado_marzo<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_marzo,2); ?></td>
            <td class="text-right" <?php if($acumulado_abril<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_abril,2); ?></td>
            <td class="text-right" <?php if($acumulado_mayo<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_mayo,2); ?></td>
            <td class="text-right" <?php if($acumulado_junio<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_junio,2); ?></td>
            <td class="text-right" <?php if($acumulado_julio<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_julio,2); ?></td>
            <td class="text-right" <?php if($acumulado_agosto<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_agosto,2); ?></td>
            <td class="text-right" <?php if($acumulado_septiembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_septiembre,2); ?></td>
            <td class="text-right" <?php if($acumulado_octubre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_octubre,2); ?></td>
            <td class="text-right" <?php if($acumulado_noviembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_noviembre,2); ?></td>
            <td class="text-right" <?php if($acumulado_diciembre<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($acumulado_diciembre,2); ?></td>
            <td class="text-right" <?php if($get_acumulado[0]['Total']<0){ echo "style='color:red;'"; } ?>><?php echo "S/".number_format($get_acumulado[0]['Total'],2); ?></td>
        </tr>
    </tbody>
</table>