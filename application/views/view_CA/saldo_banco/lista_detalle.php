<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr>
            <th>Año</th>
            <th>Mes</th>
            <th class="text-center">Mes</th>
            <th class="text-center">Movimientos (PDF)</th>
            <th class="text-center">Saldo (Banco)</th>
            <th class="text-center">Movimientos (XLS)</th>
            <th class="text-center">Saldo (Real)</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_detalle as $list) { ?>
            <tr class="text-center">
                <td><?php echo $list['anio']; ?></td>
                <td><?php echo $list['mes']; ?></td>
                <td><?php echo $list['mes_anio']; ?></td>
                <td>
                    <?php if ( $list['movimiento_pdf']!="") { ?>
                        <span class="badge" style="background:#92D050;color: white;">Cargado</span>
                    <?php }else{ ?>
                        <span class="badge" style="background:#C00000;color: white;">Pendiente</span>
                    <?php } ?>    
                </td>
                <td class="text-right"><?php if($list['saldo_bbva']!=0){ echo "€".number_format($list['saldo_bbva'],2); }else{ echo ""; }  ?></td>
                <td>
                    <?php if ( $list['movimiento_excel']!="") { ?>
                        <span class="badge" style="background:#92D050;color: white;">Cargado</span>
                    <?php }else{ ?>
                        <span class="badge" style="background:#C00000;color: white;">Pendiente</span>
                    <?php } ?>    
                </td> 
                <td class="text-right"><?php if($list['saldo_real']!=0){ echo "€".number_format($list['saldo_real'],2); }else{ echo ""; }  ?></td>
                <td>
                    <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
                        <a type="button" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Ca/Modal_Update_Detalle_Saldo_Banco') ?>/<?php echo $list['id_detalle']; ?>">
                            <img src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;">
                        </a>
                    <?php }else{ ?>
                        <a type="button" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Ca/Modal_Ver_Detalle_Saldo_Banco') ?>/<?php echo $list['id_detalle']; ?>">
                            <img src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;">
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

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

        var table=$('#example').DataTable( {
            order: [[0,"desc"],[1,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 7 ]
                },
                {
                    'targets' : [ 0,1 ],
                    'visible' : false
                } 
            ]
        } );
    } );
</script>