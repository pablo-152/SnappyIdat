<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="20%">Tipo</th>
            <th class="text-center" width="20%">Especialidad</th>
            <th class="text-center" width="25%">Asunto</th> 
            <th class="text-center" width="30%">Texto</th>
            <th class="text-center" width="5%"></th>  
        </tr>
    </thead> 

    <tbody>
        <?php foreach($list_correo as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['nom_especialidad']; ?></td>
                <td class="text-left"><?php echo $list['asunto']; ?></td>
                <td class="text-left"><?php echo nl2br($list['texto']); ?></td>                       
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('AppIFV/Modal_Update_Correo_Efsrt') ?>/<?php echo $list['id_correo']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <?php if($list['documento']!=""){ ?>
                        <a onclick="Descargar_Correo('<?php echo $list['id_correo']; ?>');">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                    <?php } ?>

                    <a title="Eliminar" onclick="Delete_Correo('<?php echo $list['id_correo']; ?>')">
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
            order: [[0,"asc"],[1,"asc"]], 
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