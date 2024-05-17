<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="26%">Empresa</th>
            <th class="text-center" width="26%">Descripción</th>
            <th class="text-center" width="26%">Inicio</th>
            <th class="text-center" width="26%">Fin</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_c_bimestres as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-center"><?php echo $list['nom_empresa']; ?></td>   
                <td class="text-center"><?php echo $list['descripcion']; ?></td>
                <td class="text-center"><?php echo $list['inicio']; ?></td>   
                <td class="text-center"><?php echo $list['fin']; ?></td>   
                <td>
                    <a title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('LittleLeaders/Modal_Update_C_Bimestres') ?>/<?php echo $list['id_bimestre']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    </a>

                    <a href="#" class="" title="Eliminar" onclick="Delete_C_Bimestres('<?php echo $list['id_bimestre']; ?>')" role="button">
                        <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;">
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

        var table=$('#example').DataTable( {
            order: [[0,'asc'],[1,'asc']],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 40,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 1 ]
                }
            ]
        } );
    } );
</script>