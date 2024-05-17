<table id="example_pagos_snappy" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="10%" class="text-center">Código</th> 
            <th width="63%" class="text-center">Producto(s)</th>
            <th width="8%" class="text-center">Monto</th> 
            <th width="8%" class="text-center">Fecha</th> 
            <th width="8%" class="text-center">Estado</th>
            <th width="3%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_pago_snappy as $list){ ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_venta']; ?></td>
                <td class="text-left"><?php echo $list['productos']; ?></td>
                <td class="text-right"><?php echo "s./ ".$list['monto']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['nom_estado']; ?></td>
                <td>
                    <?php if($list['pendiente']==1){ ?>
                        <a title="Pagar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Pago_Snappy') ?>/<?php echo $list['id_venta']; ?>"> 
                            <img src="<?= base_url() ?>template/img/btn_pagar.png">
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_pagos_snappy thead tr').clone(true).appendTo('#example_pagos_snappy thead');
        $('#example_pagos_snappy thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }
        
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example_pagos_snappy').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        });
    } );
</script>