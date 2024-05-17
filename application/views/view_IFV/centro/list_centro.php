<input type="hidden" id="parametro" name="parametro" value="<?php echo $parametro ?>">
<div class="col-lg-12">
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" title="Referencia" style="cursor:help">Ref.</th>
                <th class="text-center">Inicio</th>
                <th class="text-center">Fin</th>
                <th class="text-center">Firma</th>
                <th class="text-center">Centro</th>
                <th width="1%" class="text-center">ET</th>
                <th width="1%" class="text-center">FT</th>
                <th width="1%" class="text-center">AE</th>
                <th width="1%" class="text-center">CF</th>
                <th width="1%" class="text-center">DS</th>
                <th width="10%" class="text-center">Provincia</th>
                <th width="10%" class="text-center">Distrito</th>
                <th class="text-center" style="cursor:help" title="Alumnos Activos">ACT</th>
                <th class="text-center" style="cursor:help" title="Alumnos Totales">TTL</th>
                <th class="text-center">CP</th>
                <th class="text-center">Acción</th>
                <th width="20%" >Comentario</th>
                <th class="text-center">Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_centro as $list) {  ?>                                           
                <tr class="even pointer text-center">                                                  
                    <td><?php echo $list['cod_centro']; ?></td>
                    <td><?php if($list['inicio']!="00/00/0000"){echo $list['inicio']; }  ?></td>
                    <td><?php if($list['fin']!="00/00/0000"){echo $list['fin']; } ?></td>
                    <td><?php if($list['fec_firma']!="00/00/0000"){echo $list['fec_firma']; } ?></td>
                    <td class="text-left" nowrap><?php echo $list['nom_comercial']; ?></td>
                    <td class="text-left" nowrap><?php echo $list['especialida_et']; ?></td>
                    <td class="text-left" nowrap><?php echo $list['especialida_ft']; ?></td>
                    <td class="text-left" nowrap><?php echo $list['especialida_ae']; ?></td>
                    <td class="text-left" nowrap><?php echo $list['especialida_cf']; ?></td>
                    <td class="text-left" nowrap><?php echo $list['especialida_ds']; ?></td>
                    <td class="text-left" nowrap><?php echo $list['provinciad']; ?></td>
                    <td class="text-left" nowrap><?php echo $list['distritod']; ?></td>
                    <td ><?php echo "0"; ?></td>
                    <td ><?php echo "0"; ?></td>
                    <td><?php echo $list['CP']; ?></td>
                    <td><?php echo $list['uaccion']; ?></td>
                    <td class="text-left"><?php echo substr($list['ucomentario'], 0, 50); ?></td>
                    <td><?php if($list['id_statush']==48 || $list['id_statush']==55){?> 
                        <span class='badge' style='background:#92d050;color: white;font-size:12px'><?php echo $list['nom_status'] ?></span> <?php }
                        if($list['id_statush']==49){?>
                            <span class='badge' style='background:#C00000;color: white;font-size:12px'><?php echo $list['nom_status'] ?></span><?php }
                        if($list['id_statush']==50){?>  
                            <span class='badge' style='background:#0070C0;color: white;font-size:12px'><?php echo $list['nom_status'] ?></span><?php }
                        if($list['id_statush']==51){?>
                        <span class='badge' style='background:#eaeaa3;color: black;font-size:12px'><?php echo $list['nom_status'] ?></span>
                        <?php }?>
                    </td>
                    <td nowrap>
                        <a style="cursor:pointer;" class="" href="<?= site_url('AppIFV/Detalle_Centro') ?>/<?php echo $list["id_centro"]; ?>" title="Detalle"> <img  src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
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

        var table = $('#example').DataTable( {
            ordering:false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            
        } );
    } );
</script>