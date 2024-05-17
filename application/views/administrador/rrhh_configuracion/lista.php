<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="70%">Nombre</th>
            <th class="text-center" width="10%">Monto</th> 
            <th class="text-center" width="15%">Tipo de Descuento</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead> 

    <tbody >
        <?php foreach($list_rrhh_configuracion as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nombre']; ?></td>
                <td><?php echo $list['monto']; ?></td>
                <td><?php echo $list['tipo_descuento']; ?></td>
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('Administrador/Modal_Update_Rrhh_Configuracion') ?>/<?php echo $list['id']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" onclick="Delete_Rrhh_Configuracion('<?php echo $list['id']; ?>')">
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
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

        var table = $('#example').DataTable( {
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