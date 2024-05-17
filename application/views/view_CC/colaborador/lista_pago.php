<table class="table table-hover table-bordered table-striped" id="example_pago" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="14%">Banco</th> 
            <th class="text-center" width="70%">Cuenta Bancaria</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_pago as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_banco']; ?></td>
                <td class="text-left"><?php echo $list['cuenta_bancaria']; ?></td> 
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>    
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('CursosCortos/Modal_Update_Pago_Colaborador') ?>/<?php echo $list['id_pago']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    
                    <a title="Eliminar" onclick="Delete_Pago_Colaborador('<?php echo $list['id_pago']; ?>')">
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody> 
</table>

<script>
    $(document).ready(function() {
        $('#example_pago thead tr').clone(true).appendTo( '#example_pago thead' );
        $('#example_pago thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_pago').DataTable( {
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 3 ]
                }
            ]
        } );
    });
</script>