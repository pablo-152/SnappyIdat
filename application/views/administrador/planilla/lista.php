<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="24%">Año</th>
            <th class="text-center" width="24%">Mes</th> 
            <th class="text-center" width="23%">Fecha</th>
            <th class="text-center" width="24%">Usuario</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead> 

    <tbody>
        <?php foreach($list_planilla as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['anio']; ?></td>
                <td><?php echo $list['mes']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td class="text-left"><?php echo $list['usuario']; ?></td>
                <td>
                    <a title="Ver" href="<?= site_url('Administrador/Detalle_Planilla') ?>/<?php echo $list['id']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png">
                    </a>
                    <a title="Eliminar" onclick="Delete_Planilla('<?php echo $list['id']; ?>')">
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
                    'aTargets' : [ 4 ]
                }
            ]
        } );
    });
</script>