<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th  width="8%">Tipo</th>
            <th  width="17%">Motivo</th>
            <!--<th  width="10%">De</th>-->
            <th  width="10%">Para</th>
            <th  width="15%">Usuarios</th>
            <th class="text-center" width="3%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_motivo as $list) {  ?>                                           
            <tr class="even pointer ">
                <td ><?php echo $list['nom_tipo']; ?></td>   
                <td><?php echo $list['titulo']; ?></td>             
                <!--<td><?php echo $list['de']; ?></td>     -->        
                <td><?php echo $list['para']; ?></td>  
                <td><select class="form-control multivalue" id="usuarios" name="usuarios[]" multiple="multiple" disabled="disabled">
                    <?php $base_array = explode(",",$list['usuarios']);
                    foreach($list_usuario as $lista){ ?>
                    <option value="<?php echo $lista['id_usuario']; ?>" <?php if(in_array($lista['id_usuario'],$base_array)){ echo "selected=\"selected\""; } ?>>
                        <?php echo $lista['usuario_codigo']; ?>
                    </option>
                    <?php } ?>
                </select> </td>             
                <td class="text-center">
                    <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_C_Motivo_Contactenos') ?>/<?php echo $list['id_motivo']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    <a href="#" class="" title="Eliminar" onclick="Delete_C_Motivo_Contactenos('<?php echo $list['id_motivo']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    var ss = $(".multivalue").select2({
        tags: true
    });

    $('.multivalue').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

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
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 2 ]
                }
            ]
        } );
    } );
</script>