<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Id</th>
            <th>Id</th>
            <th class="text-center" width="30%">Código</th>
            <th class="text-center" width="30%">Talla/Ref.</th> 
            <th class="text-center" width="30%">Estado</th>
            <th class="text-center" width="10%"></th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_talla as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['id_talla']; ?></td>
                <td><?php echo $list['id_talla']; ?></td>
                <td><?php echo $list['cod_talla']; ?></td>
                <td><?php echo $list['talla']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_status']; ?></span></td>                                                      
                <td>
                    <img title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('Laleli/Modal_Update_Talla') ?>/<?php echo $list['id_talla']; ?>" 
                    src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer;"/>

                    <img title="Eliminar" onclick="Delete_Talla('<?php echo $list['id_talla']; ?>')"
                    src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer;"/>
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
            order: [2,"asc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                },
                {
                    'targets' : [ 0,1 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>