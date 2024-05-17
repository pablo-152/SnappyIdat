<table class="table table-hover table-bordered table-striped" id="example_mov" width="100%">
    <thead>
        <tr>
            <th class="no-content text-center" width="3%"><input type="checkbox" id="total" name="total" onclick="seleccionart();" value="1"></th>
            <th class="text-center" width="10%" title="Mes/Año Snappy">Mes/Año Snp</th>
            <th class="text-center" width="10%" title="Mes/Año Arpay">Mes/Año</th>
            <th class="text-center" width="8%">Tipo</th>
            <th class="text-center" width="8%">Fecha</th>
            <!--<th class="text-center" width="10%">Monto</th>-->
            <th class="text-center" width="10%" title="Saldo Snappy">Saldo Snp <?php echo $saldo ?></th>
            <th class="text-center" width="10%" title="Saldo Arpay">Saldo</th>
            <th class="text-center" width="10%">Monto Real</th>
            <th class="text-center" width="26%">Descripción</th>
            <th class="text-center" width="8%">Ref</th> 
            <th class="text-center" width="8%">Operación</th>
            <th class="text-center" width="4%"></th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $saldo=$saldo;
            
            $saldo_a=$get_saldo_arpay[0][''];
            foreach($get_fechas as $f){
                $busqueda = in_array($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($list_movimiento, 'Verificar'));
                $posicion = array_search($f['MovementType'].'-'.$f['Reference'].'-'.$f['OperationNumber'], array_column($list_movimiento, 'Verificar'));
                if ($busqueda== false) {
                    if($f['mes_anio']==$mes_anio){
                        $saldo=$saldo+$f['RealAmount'];
                        ?>
                        <tr class="text-center">
                            <td class="text-center"><input required type="checkbox" id="id_registro[]" name="id_registro[]" value="<?php echo $id_estado_bancario."/".str_replace('/','__',$fecha_busqueda)."/".$f['MovementType']."/".$f['Reference']."/".$f['OperationNumber']; ?>"></td>
                            <td style="background-color:#deebf7"><?php echo $mes_anio; ?></td>
                            <td><?php echo $f['desc_mes']."/".$f['anio'] ?></td>
                            <td><?php echo $f['MovementType']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($f['MovementDate'])); ?></td>
                            <!--<td class="text-right" style="color:<?php if($f['AmountValue']<=0){echo "red";}?>"><?php echo "s./".number_format($f['AmountValue'],2); ?></td>-->
                            <td class="text-right" style="background-color:#deebf7;color:<?php if($saldo<=0){echo "red";}?>"><?php echo "s./".number_format($saldo,2); ?></td>
                            <td class="text-right"></td>
                            <td class="text-right" style="color:<?php if($f['RealAmount']<=0){echo "red";}?>"><?php echo "s./".number_format($f['RealAmount'],2); ?></td>
                            <td class="text-left"><?php echo $f['Description']; ?></td>
                            <td><?php echo $f['Reference']; ?></td>
                            <td><?php echo $f['OperationNumber']; ?></td>
                            <td>
                                <a type="button" title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?=site_url('Administrador/Modal_Update_Estado_Bancario_Mes_Anio') ?>/<?php echo $id_estado_bancario."/".str_replace('/','__',$fecha_busqueda)."/".$f['MovementType']."/".$f['Reference']."/".$f['OperationNumber']; ?>">
                                    <img src="<?= base_url() ?>images/editar.png" style="cursor:pointer; cursor: hand;"/>
                                </a>
                            </td>
                        </tr>
                    <?php }
                }
            }
            foreach ($list_movimiento as $list){
                
                $busqueda = in_array($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($get_fechas, 'verificar'));
                $posicion = array_search($list['MovementType'].'-'.$list['Reference'].'-'.$list['OperationNumber'], array_column($get_fechas, 'verificar'));
                
                if ($busqueda!= false) {
                    
                }else{
                    $saldo=$saldo+$list['RealAmount'];
                    $saldo_a=$saldo_a+$list['RealAmount'];
                    
                    ?> 
                <tr class="text-center">
                    <td class="text-center"><input required type="checkbox" id="id_registro[]" name="id_registro[]" value="<?php echo $id_estado_bancario."/".str_replace('/','__',$fecha_busqueda)."/".$list['MovementType']."/".$list['Reference']."/".$list['OperationNumber']; ?>"></td>
                    <td style="background-color:#deebf7"><?php echo $mes_anio ?></td>
                    <td><?php echo $mes_anio; ?></td>
                    <td><?php echo $list['MovementType']; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($list['MovementDate'])); ?></td>
                    <!--<td class="text-right" style="color:<?php if($list['AmountValue']<=0){echo "red";}?>"><?php echo "s./".number_format($list['AmountValue'],2); ?></td>-->
                    
                    <td class="text-right" style="background-color:#deebf7;color:<?php if($saldo<=0){echo "red";}?>"><?php echo "s./".number_format($saldo,2); ?></td>
                    <td class="text-right" style="color:<?php if($saldo_a<=0){echo "red";}?>"><?php echo "s./".number_format($saldo_a,2); ?></td>
                    <td class="text-right" style="color:<?php if($list['RealAmount']<=0){echo "red";}?>" title="<?php echo $list['RealAmount']; ?>"><?php echo "s./".number_format($list['RealAmount'],2); ?></td>
                    <td class="text-left"><?php echo $list['Description']; ?></td>
                    <td><?php echo $list['Reference']; ?></td>
                    <td><?php echo $list['OperationNumber']; ?></td>
                    <td>
                        <a type="button" title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?=site_url('Administrador/Modal_Update_Estado_Bancario_Mes_Anio') ?>/<?php echo $id_estado_bancario."/".str_replace('/','__',$fecha_busqueda)."/".$list['MovementType']."/".$list['Reference']."/".$list['OperationNumber']; ?>">
                            <img src="<?= base_url() ?>images/editar.png" style="cursor:pointer; cursor: hand;"/>
                        </a>
                    </td>
                </tr>
                <?php }
             ?>
            
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_mov thead tr').clone(true).appendTo( '#example_mov thead' );
        $('#example_mov thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            if(title==""){
              $(this).html('');
            }else{
              $(this).html('<input type="text" placeholder="Buscar '+title+'"/>');
            }
            
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example_mov').DataTable({
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0 ]
                }
            ]
        });
    } );

    function seleccionart(){
        if (document.getElementById('total').checked){
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_registro')
                inp[i].checked=1;
            }
        }else{
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_registro')
                inp[i].checked=0;
            }
        }
    }

    function Update_Todos(){
        var contador=0;
        var contadorf=0;

        $("input[type=checkbox]").each(function(){
            if($(this).is(":checked"))
            contador++;
        }); 

        if(contador>0 && document.getElementById('total').checked){
            contadorf=contador-1;
        }else{
            contadorf=contador;
        }
        
        if(contadorf>0){
            $('#registro_mailing').modal('show');    
        }else{
            Swal(
                'Ups!',
                'Debe seleccionar al menos 1 registro.',
                'warning'
            ).then(function() { });
            return false;
        }
    }
</script>