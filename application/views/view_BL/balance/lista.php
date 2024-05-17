<?php 
    $total_ingreso_ene = $get_balance[0]['total_boleta_ene']+$get_balance[0]['total_factura_ene']+$get_balance[0]['total_nota_debito_ene']-$get_balance[0]['total_nota_credito_ene'];
    $total_ingreso_feb = $get_balance[0]['total_boleta_feb']+$get_balance[0]['total_factura_feb']+$get_balance[0]['total_nota_debito_feb']-$get_balance[0]['total_nota_credito_feb'];
    $total_ingreso_mar = $get_balance[0]['total_boleta_mar']+$get_balance[0]['total_factura_mar']+$get_balance[0]['total_nota_debito_mar']-$get_balance[0]['total_nota_credito_mar'];
    $total_ingreso_abr = $get_balance[0]['total_boleta_abr']+$get_balance[0]['total_factura_abr']+$get_balance[0]['total_nota_debito_abr']-$get_balance[0]['total_nota_credito_abr'];
    $total_ingreso_may = $get_balance[0]['total_boleta_may']+$get_balance[0]['total_factura_may']+$get_balance[0]['total_nota_debito_may']-$get_balance[0]['total_nota_credito_may'];
    $total_ingreso_jun = $get_balance[0]['total_boleta_jun']+$get_balance[0]['total_factura_jun']+$get_balance[0]['total_nota_debito_jun']-$get_balance[0]['total_nota_credito_jun'];
    $total_ingreso_jul = $get_balance[0]['total_boleta_jul']+$get_balance[0]['total_factura_jul']+$get_balance[0]['total_nota_debito_jul']-$get_balance[0]['total_nota_credito_jul'];
    $total_ingreso_ago = $get_balance[0]['total_boleta_ago']+$get_balance[0]['total_factura_ago']+$get_balance[0]['total_nota_debito_ago']-$get_balance[0]['total_nota_credito_ago'];
    $total_ingreso_sep = $get_balance[0]['total_boleta_sep']+$get_balance[0]['total_factura_sep']+$get_balance[0]['total_nota_debito_sep']-$get_balance[0]['total_nota_credito_sep'];
    $total_ingreso_oct = $get_balance[0]['total_boleta_oct']+$get_balance[0]['total_factura_oct']+$get_balance[0]['total_nota_debito_oct']-$get_balance[0]['total_nota_credito_oct'];
    $total_ingreso_nov = $get_balance[0]['total_boleta_nov']+$get_balance[0]['total_factura_nov']+$get_balance[0]['total_nota_debito_nov']-$get_balance[0]['total_nota_credito_nov'];
    $total_ingreso_dic = $get_balance[0]['total_boleta_dic']+$get_balance[0]['total_factura_dic']+$get_balance[0]['total_nota_debito_dic']-$get_balance[0]['total_nota_credito_dic'];
    $total_ingreso = $get_balance[0]['total_boleta']+$get_balance[0]['total_factura']+$get_balance[0]['total_nota_debito']-$get_balance[0]['total_nota_credito'];

    $total_ingreso_ene_ant = $get_balance_ant[0]['total_boleta_ene']+$get_balance_ant[0]['total_factura_ene']+$get_balance_ant[0]['total_nota_debito_ene']-$get_balance_ant[0]['total_nota_credito_ene'];
    $total_ingreso_feb_ant = $get_balance_ant[0]['total_boleta_feb']+$get_balance_ant[0]['total_factura_feb']+$get_balance_ant[0]['total_nota_debito_feb']-$get_balance_ant[0]['total_nota_credito_feb'];
    $total_ingreso_mar_ant = $get_balance_ant[0]['total_boleta_mar']+$get_balance_ant[0]['total_factura_mar']+$get_balance_ant[0]['total_nota_debito_mar']-$get_balance_ant[0]['total_nota_credito_mar'];
    $total_ingreso_abr_ant = $get_balance_ant[0]['total_boleta_abr']+$get_balance_ant[0]['total_factura_abr']+$get_balance_ant[0]['total_nota_debito_abr']-$get_balance_ant[0]['total_nota_credito_abr'];
    $total_ingreso_may_ant = $get_balance_ant[0]['total_boleta_may']+$get_balance_ant[0]['total_factura_may']+$get_balance_ant[0]['total_nota_debito_may']-$get_balance_ant[0]['total_nota_credito_may'];
    $total_ingreso_jun_ant = $get_balance_ant[0]['total_boleta_jun']+$get_balance_ant[0]['total_factura_jun']+$get_balance_ant[0]['total_nota_debito_jun']-$get_balance_ant[0]['total_nota_credito_jun'];
    $total_ingreso_jul_ant = $get_balance_ant[0]['total_boleta_jul']+$get_balance_ant[0]['total_factura_jul']+$get_balance_ant[0]['total_nota_debito_jul']-$get_balance_ant[0]['total_nota_credito_jul'];
    $total_ingreso_ago_ant = $get_balance_ant[0]['total_boleta_ago']+$get_balance_ant[0]['total_factura_ago']+$get_balance_ant[0]['total_nota_debito_ago']-$get_balance_ant[0]['total_nota_credito_ago'];
    $total_ingreso_sep_ant = $get_balance_ant[0]['total_boleta_sep']+$get_balance_ant[0]['total_factura_sep']+$get_balance_ant[0]['total_nota_debito_sep']-$get_balance_ant[0]['total_nota_credito_sep'];
    $total_ingreso_oct_ant = $get_balance_ant[0]['total_boleta_oct']+$get_balance_ant[0]['total_factura_oct']+$get_balance_ant[0]['total_nota_debito_oct']-$get_balance_ant[0]['total_nota_credito_oct'];
    $total_ingreso_nov_ant = $get_balance_ant[0]['total_boleta_nov']+$get_balance_ant[0]['total_factura_nov']+$get_balance_ant[0]['total_nota_debito_nov']-$get_balance_ant[0]['total_nota_credito_nov'];
    $total_ingreso_dic_ant = $get_balance_ant[0]['total_boleta_dic']+$get_balance_ant[0]['total_factura_dic']+$get_balance_ant[0]['total_nota_debito_dic']-$get_balance_ant[0]['total_nota_credito_dic'];
    $total_ingreso_ant = $get_balance_ant[0]['total_boleta']+$get_balance_ant[0]['total_factura']+$get_balance_ant[0]['total_nota_debito']-$get_balance_ant[0]['total_nota_credito'];

    if($total_ingreso_ene_ant==0){
        $dif_total_ingreso_ene = 0;
    }else{
        $dif_total_ingreso_ene = (($total_ingreso_ene-$total_ingreso_ene_ant)/$total_ingreso_ene_ant)*100;
    }
    if($total_ingreso_feb_ant==0){
        $dif_total_ingreso_feb = 0;
    }else{
        $dif_total_ingreso_feb = (($total_ingreso_feb-$total_ingreso_feb_ant)/$total_ingreso_feb_ant)*100;
    }
    if($total_ingreso_mar_ant==0){
        $dif_total_ingreso_mar = 0;
    }else{
        $dif_total_ingreso_mar = (($total_ingreso_mar-$total_ingreso_mar_ant)/$total_ingreso_mar_ant)*100;
    }
    if($total_ingreso_abr_ant==0){
        $dif_total_ingreso_abr = 0;
    }else{
        $dif_total_ingreso_abr = (($total_ingreso_abr-$total_ingreso_abr_ant)/$total_ingreso_abr_ant)*100;
    }
    if($total_ingreso_may_ant==0){
        $dif_total_ingreso_may = 0;
    }else{
        $dif_total_ingreso_may = (($total_ingreso_may-$total_ingreso_may_ant)/$total_ingreso_may_ant)*100;
    }
    if($total_ingreso_jun_ant==0){
        $dif_total_ingreso_jun = 0;
    }else{
        $dif_total_ingreso_jun = (($total_ingreso_jun-$total_ingreso_jun_ant)/$total_ingreso_jun_ant)*100;
    }
    if($total_ingreso_jul_ant==0){
        $dif_total_ingreso_jul = 0;
    }else{
        $dif_total_ingreso_jul = (($total_ingreso_jul-$total_ingreso_jul_ant)/$total_ingreso_jul_ant)*100;
    }
    if($total_ingreso_ago_ant==0){
        $dif_total_ingreso_ago = 0;
    }else{
        $dif_total_ingreso_ago = (($total_ingreso_ago-$total_ingreso_ago_ant)/$total_ingreso_ago_ant)*100;
    }
    if($total_ingreso_sep_ant==0){
        $dif_total_ingreso_sep = 0;
    }else{
        $dif_total_ingreso_sep = (($total_ingreso_sep-$total_ingreso_sep_ant)/$total_ingreso_sep_ant)*100;
    }
    if($total_ingreso_oct_ant==0){
        $dif_total_ingreso_oct = 0;
    }else{
        $dif_total_ingreso_oct = (($total_ingreso_oct-$total_ingreso_oct_ant)/$total_ingreso_oct_ant)*100;
    }
    if($total_ingreso_nov_ant==0){
        $dif_total_ingreso_nov = 0;
    }else{
        $dif_total_ingreso_nov = (($total_ingreso_nov-$total_ingreso_nov_ant)/$total_ingreso_nov_ant)*100;
    }
    if($total_ingreso_dic_ant==0){
        $dif_total_ingreso_dic = 0;
    }else{
        $dif_total_ingreso_dic = (($total_ingreso_dic-$total_ingreso_dic_ant)/$total_ingreso_dic_ant)*100;
    }
    if($total_ingreso_ant==0){
        $dif_total_ingreso = 0;
    }else{
        $dif_total_ingreso = (($total_ingreso-$total_ingreso_ant)/$total_ingreso_ant)*100;
    }
?>
<table width="100%" border="1" align="center" cellpadding="1" cellspacing="1">
    <thead>
        <tr>
            <th width="" style="background-color:#ffffff;">&nbsp;</th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Ene-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Feb-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Mar-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Abr-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">May-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Jun-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Jul-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Ago-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Set-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Oct-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Nov-<?php echo substr($anio,-2); ?></th>
            <th class="text-center" width="" style="background-color:#c8c8c8;">Dic-<?php echo substr($anio,-2); ?></th>
            <th width="" style="background-color:#ffffff;">&nbsp;</th>
            <th width="" style="background-color:#ffffff;">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="2" style="background-color:#8dbf42;color:#ffffff;">INGRESOS</td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_ene,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_feb,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_mar,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_abr,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_may,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_jun,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_jul,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_ago,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_sep,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_oct,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_nov,2); ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo "S/".number_format($total_ingreso_dic,2); ?></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right" style="background-color:#8dbf42;color:#ffffff;"><?php echo "S/".number_format($total_ingreso,2); ?></td>
        </tr>
        <tr>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_ene,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_feb,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_mar,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_abr,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_may,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_jun,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_jul,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_ago,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_sep,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_oct,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_nov,2)."%"; ?></td>
            <td class="text-right" style="background-color:#e6ffbf;"><?php echo number_format($dif_total_ingreso_dic,2)."%"; ?></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right" style="background-color:#8dbf42;color:#ffffff;"><?php echo number_format($dif_total_ingreso,2)."%"; ?></td>
        </tr>
        <tr>
            <td class="text-right">Boletas</td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','1');"><?php echo "S/".number_format($get_balance[0]['total_boleta_ene'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','2');"><?php echo "S/".number_format($get_balance[0]['total_boleta_feb'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','3');"><?php echo "S/".number_format($get_balance[0]['total_boleta_mar'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','4');"><?php echo "S/".number_format($get_balance[0]['total_boleta_abr'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','5');"><?php echo "S/".number_format($get_balance[0]['total_boleta_may'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','6');"><?php echo "S/".number_format($get_balance[0]['total_boleta_jun'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','7');"><?php echo "S/".number_format($get_balance[0]['total_boleta_jul'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','8');"><?php echo "S/".number_format($get_balance[0]['total_boleta_ago'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','9');"><?php echo "S/".number_format($get_balance[0]['total_boleta_sep'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','10');"><?php echo "S/".number_format($get_balance[0]['total_boleta_oct'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','11');"><?php echo "S/".number_format($get_balance[0]['total_boleta_nov'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Boleta('<?php echo $anio; ?>','12');"><?php echo "S/".number_format($get_balance[0]['total_boleta_dic'],2); ?></a></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_boleta'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Cuentas Por Cobrar</td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_ene'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_feb'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_mar'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_abr'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_may'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_jun'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_jul'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_ago'],2); ?></td> 
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_sep'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_oct'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_nov'],2); ?></td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar_dic'],2); ?></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_cuentas_cobrar'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Facturas</td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','1');"><?php echo "S/".number_format($get_balance[0]['total_factura_ene'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','2');"><?php echo "S/".number_format($get_balance[0]['total_factura_feb'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','3');"><?php echo "S/".number_format($get_balance[0]['total_factura_mar'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','4');"><?php echo "S/".number_format($get_balance[0]['total_factura_abr'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','5');"><?php echo "S/".number_format($get_balance[0]['total_factura_may'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','6');"><?php echo "S/".number_format($get_balance[0]['total_factura_jun'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','7');"><?php echo "S/".number_format($get_balance[0]['total_factura_jul'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','8');"><?php echo "S/".number_format($get_balance[0]['total_factura_ago'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','9');"><?php echo "S/".number_format($get_balance[0]['total_factura_sep'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','10');"><?php echo "S/".number_format($get_balance[0]['total_factura_oct'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','11');"><?php echo "S/".number_format($get_balance[0]['total_factura_nov'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Factura('<?php echo $anio; ?>','12');"><?php echo "S/".number_format($get_balance[0]['total_factura_dic'],2); ?></a></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_factura'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Notas de Débito</td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','1');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_ene'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','2');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_feb'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','3');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_mar'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','4');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_abr'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','5');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_may'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','6');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_jun'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','7');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_jul'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','8');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_ago'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','9');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_sep'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','10');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_oct'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','11');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_nov'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Debito('<?php echo $anio; ?>','12');"><?php echo "S/".number_format($get_balance[0]['total_nota_debito_dic'],2); ?></a></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_nota_debito'],2); ?></td>
        </tr>
        <tr>
            <td class="text-right">Notas de Crédito</td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','1');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_ene'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','2');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_feb'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','3');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_mar'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','4');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_abr'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','5');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_may'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','6');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_jun'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','7');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_jul'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','8');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_ago'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','9');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_sep'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','10');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_oct'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','11');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_nov'],2); ?></a></td>
            <td class="text-right"><a onclick="Excel_Balance_Nota_Credito('<?php echo $anio; ?>','12');"><?php echo "S/".number_format($get_balance[0]['total_nota_credito_dic'],2); ?></a></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right"><?php echo "S/".number_format($get_balance[0]['total_nota_credito'],2); ?></td>
        </tr>
    </tbody>
</table>