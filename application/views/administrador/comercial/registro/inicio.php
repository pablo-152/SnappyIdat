<div class="row">
    <?php $busqueda = in_array(3,array_column($list_empresa_cabecera, 'id_empresa'));
        if($busqueda!=false){ ?>
        <div class="col-lg-2 col-xs-12" style="color:#fff; background-color:#c5227f">
            <div class="small-box" >
                <div class="inner" align="center">
                    <h3 style="font-size: 34px;">
                    <b>(BL)</b> <span style="font-size: 28px;cursor:help" title="Matriculados"><?php echo $total_bl[0]['Total']; ?></span>
                    </h3> 
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table width='100%' cellpadding='0' cellspacing='0' class="table-total" style="font-size:10px">
                            <tbody>
                                <tr>
                                    <th width="50%"></th>
                                    <th class="text-right" width="10%"><b><span title="SIN DEFINIR" style="cursor:help">SD</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="INTERESE MODERADO" style="cursor:help">IM</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="SUPER INTERESE" style="cursor:help">SI</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="MATRICULADO" style="cursor:help">MT</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="EXCLUIDO" style="cursor:help">EX</span></b></th>
                                </tr>
                                <?php foreach($list_bl as $list){?>
                                    <tr>
                                        <td width="50%" nowrap style="font-size: 12px;" title="<?php echo $list['nom_producto_interes'] ?>"><?php echo substr($list['nom_producto_interes'],0,30) ?>:</td>     
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Sin_Definir']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Interese_Moderado']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Super_Interese']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Matriculado']; ?></td>      
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Excluido']; ?></td>                                                  
                                    </tr> 
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $busqueda = in_array(2,array_column($list_empresa_cabecera, 'id_empresa'));
        if($busqueda!=false){ ?>
        <div class="col-lg-2 col-xs-12" style="color:#fff;background-color:#cddb00;">
            <div class="small-box bg-aqua">
                <div class="inner" align="center">
                    <h3 style="font-size: 34px;">
                    <b>(LL)</b> <span style="font-size: 28px;cursor:help" title="Matriculados"><?php echo $total_ll[0]['Total']; ?></span>
                    </h3> 
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table-total" align="left" style="font-size:11px">
                            <tbody>
                                <tr>
                                    <th width="50%"></th>
                                    <th class="text-right" width="10%"><b><span title="SIN DEFINIR" style="cursor:help">SD</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="INTERESE MODERADO" style="cursor:help">IM</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="SUPER INTERESE" style="cursor:help">SI</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="MATRICULADO" style="cursor:help">MT</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="EXCLUIDO" style="cursor:help">EX</span></b></th>
                                </tr>
                                <?php foreach($list_ll as $list){?>
                                    <tr>
                                        <td width="50%" nowrap style="font-size: 12px;" title="<?php echo $list['nom_producto_interes'] ?>"><?php echo substr($list['nom_producto_interes'],0,30) ?>:</td>     
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Sin_Definir']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Interese_Moderado']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Super_Interese']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Matriculado']; ?></td>      
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Excluido']; ?></td>                                                 
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $busqueda = in_array(4,array_column($list_empresa_cabecera, 'id_empresa'));
        if($busqueda!=false){ ?>
        <div class="col-lg-2 col-xs-12" style="color:#fff; background-color:#1d7abd">
            <div class="small-box" >
                <div class="inner" align="center">
                    <h3 style="font-size: 34px;">
                    <b>(LS PRI)</b> <span style="font-size: 28px;cursor:help" title="Matriculados"><?php echo $total_ls_pri[0]['Total']; ?></span>
                    </h3> 
                </div>
                <div class="row">
                    <div class="col-lg-12">
                    <table class="table-total" align="center" style="font-size:9px">
                        <tbody>
                            <tr>
                                <th width="50%"></th>
                                <th class="text-right" width="10%"><b><span title="SIN DEFINIR" style="cursor:help">SD</span></b></th>
                                <th class="text-right" width="10%"><b><span title="INTERESE MODERADO" style="cursor:help">IM</span></b></th>
                                <th class="text-right" width="10%"><b><span title="SUPER INTERESE" style="cursor:help">SI</span></b></th>
                                <th class="text-right" width="10%"><b><span title="MATRICULADO" style="cursor:help">MT</span></b></th>
                                <th class="text-right" width="10%"><b><span title="EXCLUIDO" style="cursor:help">EX</span></b></th>
                            </tr>
                            <?php foreach($list_ls_pri as $list){?>
                                <tr>
                                    <td width="50%" nowrap style="font-size: 12px;" title="<?php echo $list['nom_producto_interes'] ?>"><?php echo substr($list['nom_producto_interes'],0,30) ?>:</td>     
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Sin_Definir']; ?></td>  
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Interese_Moderado']; ?></td>  
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Super_Interese']; ?></td>  
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Matriculado']; ?></td>      
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Excluido']; ?></td>                                                  
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    
    <?php $busqueda = in_array(4,array_column($list_empresa_cabecera, 'id_empresa'));
        if($busqueda!=false){ ?>
        <div class="col-lg-2 col-xs-12" style="color:#fff; background-color:#1d7abd">
            <div class="small-box" >
                <div class="inner" align="center">
                    <h3 style="font-size: 34px;">
                    <b>(LS SEC)</b> <span style="font-size: 28px;cursor:help" title="Matriculados"><?php echo $total_ls_secu[0]['Total']; ?></span>
                    </h3> 
                </div>
                <div class="row">
                    <div class="col-lg-12">
                    <table class="table-total" align="center" style="font-size:9px">
                        <tbody>
                            <tr>
                                <th width="50%"></th>
                                <th class="text-right" width="10%"><b><span title="SIN DEFINIR" style="cursor:help">SD</span></b></th>
                                <th class="text-right" width="10%"><b><span title="INTERESE MODERADO" style="cursor:help">IM</span></b></th>
                                <th class="text-right" width="10%"><b><span title="SUPER INTERESE" style="cursor:help">SI</span></b></th>
                                <th class="text-right" width="10%"><b><span title="MATRICULADO" style="cursor:help">MT</span></b></th>
                                <th class="text-right" width="10%"><b><span title="EXCLUIDO" style="cursor:help">EX</span></b></th>
                            </tr>
                            <?php foreach($list_ls_secu as $list){?>
                                <tr>
                                    <td width="50%" nowrap style="font-size: 12px;" title="<?php echo $list['nom_producto_interes'] ?>"><?php echo substr($list['nom_producto_interes'],0,30) ?>:</td>     
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Sin_Definir']; ?></td>  
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Interese_Moderado']; ?></td>  
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Super_Interese']; ?></td>  
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Matriculado']; ?></td>      
                                    <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Excluido']; ?></td>                                                  
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $busqueda = in_array(5,array_column($list_empresa_cabecera, 'id_empresa'));
        if($busqueda!=false){ ?>
        <div class="col-lg-2 col-xs-12" style="color:#fff; background-color:#012061">
            <div class="small-box" >
                <div class="inner" align="center">
                    <h3 style="font-size: 34px;">
                    <b>(EP1)</b> <span style="font-size: 28px;cursor:help" title="Matriculados"><?php echo $total_ep1[0]['Total']; ?></span>
                    </h3> 
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table-total" align="center" style="font-size:10px">
                            <tbody>
                                <tr>
                                    <th width="50%"></th>
                                    <th class="text-right" width="10%"><b><span title="SIN DEFINIR" style="cursor:help">SD</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="INTERESE MODERADO" style="cursor:help">IM</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="SUPER INTERESE" style="cursor:help">SI</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="MATRICULADO" style="cursor:help">MT</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="EXCLUIDO" style="cursor:help">EX</span></b></th>
                                </tr>
                                <?php foreach($list_ep1 as $list){ ?>
                                    <tr>
                                        <td width="50%" nowrap style="font-size: 12px;" title="<?php echo $list['nom_producto_interes'] ?>"><?php echo substr($list['nom_producto_interes'],0,30) ?>:</td>     
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Sin_Definir']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Interese_Moderado']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Super_Interese']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Matriculado']; ?></td>      
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Excluido']; ?></td>                                                  
                                    </tr>
                                <?php } ?> 
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $busqueda = in_array(5,array_column($list_empresa_cabecera, 'id_empresa'));
        if($busqueda!=false){ ?>
        <div class="col-lg-2 col-xs-12" style="color:#fff; background-color:#012061">
            <div class="small-box" >
                <div class="inner" align="center">
                    <h3 style="font-size: 34px;">
                    <b>(EP2)</b> <span style="font-size: 28px;cursor:help" title="Matriculados"><?php echo $total_ep2[0]['Total']; ?></span>
                    </h3> 
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table-total" align="center" style="font-size:10px">
                            <tbody>
                                <tr>
                                    <th width="50%"></th>
                                    <th class="text-right" width="10%"><b><span title="SIN DEFINIR" style="cursor:help">SD</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="INTERESE MODERADO" style="cursor:help">IM</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="SUPER INTERESE" style="cursor:help">SI</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="MATRICULADO" style="cursor:help">MT</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="EXCLUIDO" style="cursor:help">EX</span></b></th>
                                </tr>
                                <?php foreach($list_ep2 as $list){?>
                                    <tr>
                                        <td width="50%" nowrap style="font-size: 12px;" title="<?php echo $list['nom_producto_interes'] ?>"><?php echo substr($list['nom_producto_interes'],0,30) ?>:</td>     
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Sin_Definir']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Interese_Moderado']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Super_Interese']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Matriculado']; ?></td>      
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Excluido']; ?></td>                                                  
                                    </tr>
                                <?php } ?> 
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $busqueda = in_array(6,array_column($list_empresa_cabecera, 'id_empresa'));
        if($busqueda!=false){ ?>
        <div class="col-lg-2 col-xs-12" style="color:#fff; background-color:#ef8700">
            <div class="small-box " >
                <div class="inner" align="center">
                    <h3 style="font-size: 34px;">
                    <b>(FV)</b> <span style="font-size: 28px;cursor:help" title="Matriculados"><?php echo $total_fv[0]['Total']; ?></span>
                    </h3> 
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table-total" align="center" style="font-size:10px">
                            <tbody>
                                <tr>
                                    <th width="50%"></th>
                                    <th class="text-right" width="10%"><b><span title="SIN DEFINIR" style="cursor:help">SD</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="INTERESE MODERADO" style="cursor:help">IM</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="SUPER INTERESE" style="cursor:help">SI</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="MATRICULADO" style="cursor:help">MT</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="EXCLUIDO" style="cursor:help">EX</span></b></th>
                                </tr>
                                <?php foreach($list_fv as $list){?>
                                    <tr>
                                        <td width="50%" nowrap style="font-size: 12px;" title="<?php echo $list['nom_producto_interes'] ?>"><?php echo substr($list['nom_producto_interes'],0,30) ?>:</td>     
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Sin_Definir']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Interese_Moderado']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Super_Interese']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Matriculado']; ?></td>      
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Excluido']; ?></td>                                                  
                                    </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php $busqueda = in_array(9,array_column($list_empresa_cabecera, 'id_empresa'));
        if($busqueda!=false){ ?>
        <div class="col-lg-2 col-xs-12" style="color:#fff;background:#343399">
            <div class="small-box " >
                <div class="inner" align="center">
                    <h3 style="font-size: 34px;"> 
                    <b>(LD)</b> <span style="font-size: 28px;cursor:help" title="Matriculados"><?php echo $total_ld[0]['Total']; ?></span>
                    </h3> 
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table-total" align="center" style="font-size:10px">
                            <tbody>
                                <tr>
                                    <th width="50%"></th>
                                    <th class="text-right" width="10%"><b><span title="SIN DEFINIR" style="cursor:help">SD</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="INTERESE MODERADO" style="cursor:help">IM</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="SUPER INTERESE" style="cursor:help">SI</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="MATRICULADO" style="cursor:help">MT</span></b></th>
                                    <th class="text-right" width="10%"><b><span title="EXCLUIDO" style="cursor:help">EX</span></b></th>
                                </tr>
                                <?php foreach($list_ld as $list){?>
                                    <tr>
                                        <td width="50%" nowrap style="font-size: 12px;" title="<?php echo $list['nom_producto_interes'] ?>"><?php echo substr($list['nom_producto_interes'],0,10) ?>:</td>     
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Sin_Definir']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Interese_Moderado']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Super_Interese']; ?></td>  
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Matriculado']; ?></td>      
                                        <td class="text-right" width="10%" style="font-size: 11px;"><?php echo $list['Excluido']; ?></td>                                                  
                                    </tr>
                                <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div></br>