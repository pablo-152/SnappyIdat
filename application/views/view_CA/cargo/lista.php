<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead class="text-center">
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Referencia </th>
            <th class="text-center" width="8%">Fecha </th>
            <th class="text-center" width="8%">De</th>
            <th class="text-center" width="5%">Sede&nbsp;para</th>
            <th class="text-center" width="5%">Usuario&nbsp;para</th>
            <th class="text-center" width="8%">Rubro</th>
            <th class="text-center" width="36%">Descripción</th>
            <th class="text-center" width="6%">Doc</th>
            <th class="text-center" width="10%">Estado</th>
            <td class="text-center" width="6%"></td> 
        </tr>
    </thead>
    <tbody >
        <?php foreach($list_cargo as $list){ ?>    
            <tr class="even pointer text-center">
                <td><?php echo $list['codigo']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td class="text-left"><?php echo $list['usuario_de']; ?></td>
                <td class="text-left"><?php echo $list['sede_1']; ?></td>
                <td class="text-left"><?php echo $list['usuario_1']; ?></td>
                <td class="text-left"><?php echo $list['nom_rubro']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['doc']; ?></td>
                <td>
                    <span class="badge" style="background:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span> 
                </td>
                <td>
                    <a title="Más Información" href="<?= site_url('Ca/Editar_Cargo') ?>/<?php echo $list['id']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png">
                    </a> 
                    <a title="Eliminar" onclick="Delete_Cargo('<?php echo $list['id']; ?>')">
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
            
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    
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
            order: [[7,"desc"],[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 9 ]
                }
            ]
        } );
    } );
</script>