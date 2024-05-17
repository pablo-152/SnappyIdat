<table class="table table-hover table-bordered table-striped" id="example_contrato" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">  
            <th class="text-center" width="54%">Descripción</th>
            <th class="text-center" width="8%">Fecha</th> 
            <th class="text-center" width="8%">Contrato</th> 
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="8%">Fecha</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_contrato as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_contrato']; ?></td>
                <td><?php echo $list['fecha']; ?></td> 
                <td><?php echo $list['v_archivo']; ?></td>
                <td class="text-left"><?php echo $list['user_registro']; ?></td>
                <td><?php echo $list['fec_registro']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>    
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('LittleLeaders/Modal_Update_Contrato_Colaborador') ?>/<?php echo $list['id_contrato']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <?php if($list['archivo']!=""){ ?>
                        <a onclick="Descargar_Contrato_Colaborador('<?php echo $list['id_contrato']; ?>');">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                    <?php } ?>
                    
                    <a title="Eliminar" onclick="Delete_Contrato_Colaborador('<?php echo $list['id_contrato']; ?>')">
                        <img src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_contrato thead tr').clone(true).appendTo( '#example_contrato thead' );
        $('#example_contrato thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_contrato').DataTable( {
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 6 ]
                }
            ]
        } );
    });
</script>