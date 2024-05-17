<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="60%">Nombre</th> 
            <th class="text-center" width="10%">Alumno</th> 
            <th class="text-center" width="10%">Fecha Envío</th> 
            <th class="text-center" width="15%">Estado</th>
            <th class="text-center" width="5%"></th> 
        </tr>
    </thead>
    <tbody> 
        <?php foreach($list_tipo_c_contrato as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>   
                <td><?php echo $list['alumno']; ?></td>   
                <td><?php echo $list['fecha_envio']; ?></td> 
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_status']; ?></span></td>      
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('AppIFV/Modal_Update_Tipo_C_Contrato') ?>/<?php echo $list['id_tipo']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <a title="Eliminar" onclick="Delete_Tipo_C_Contrato('<?php echo $list['id_tipo']; ?>')">
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

        var table=$('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 4 ]
                }
            ]
        } );
    } );
</script>