<input type="hidden" id="tipo_i" name="tipo_i" value="<?php echo $t ?>">
<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="10%">Ap. Paterno</th>
            <th class="text-center" width="10%">Ap. Materno</th>
            <th class="text-center" width="10%">Nombre(s)</th>
            <th class="text-center" width="6%">Código</th>  
            <th class="text-center" width="20%">Especialidad</th>  
            <th class="text-center" width="20%">Documento</th> 
            <th class="text-center" width="5%">Estado</th>
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_documento_recibido as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>  
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>  
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>  
                <td><?php echo $list['Codigo']; ?></td>   
                <td class="text-left"><?php echo $list['Especialidad']; ?></td>   
                <td class="text-left"><?php echo $list['nom_documento']; ?></td>   
                <td><span class="badge" style="background:<?php if($list['estado']==2){echo "#0070C0;"; }if($list['estado']==3){echo "#C00000;"; }if($list['estado']==4){echo "#00C000;"; }?>"><?php echo $list['desc_estado']; ?></span>    
                </td>   
                <td class="text-left"><?php if($list['estado']!=2){echo $list['usuario_codigo']; }?></td> 
                <td><?php if($list['estado']==2){ echo $list['fecha_registro']; }else{ echo $list['fecha_actualizacion']; } ?></td>    
                <td>
                    <a title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('AppIFV/Modal_Update_Documento_Recibido') ?>/<?php echo $list['id_doc_cargado']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_doc_cargado']; ?>">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>
                    <?php if($list['estado']!=3){?> 
                        <a href="#" class="" title="Anular" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('AppIFV/Modal_Anular_Documento_Recibido') ?>/<?php echo $list['id_doc_cargado']; ?>">
                            <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png">
                        </a>    
                    <?php }?>
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
            order: [[4,"desc"],[0,"asc"]],
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
    
    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Documento_Recibido/" + image_id);
    });
</script>