<input type="hidden" id="filtro_tabla" value="<?php echo $_SESSION['usuario'][0]['id_nivel']; ?>">

<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="5%" title="Empresa">Emp.</th> 
            <th class="text-center" width="18%">Sub-Rubro</th>
            <th class="text-center" width="18%">Descripción</th>
            <th class="text-center" width="12%" title="Nombre (Documento)">Nombre (Doc.)</th>
            <th class="text-center" width="28%">Link</th>
            <th class="text-center" width="4%">Archivo</th>
            <th class="text-center" width="4%">Visible</th>
            <th class="text-center" width="6%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_documento as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo "CA"; ?></td>   
                <td class="text-left"><?php echo $list['nom_subrubro']; ?></td>             
                <td class="text-left"><?php echo $list['descripcion']; ?></td>    
                <td class="text-left"><?php echo $list['nom_documento']; ?></td>   
                <td class="text-left"><a href="<?php echo $list['href']; ?>" target="_blank"><?php echo $list['link']; ?></a></td>         
                <td><?php echo $list['v_documento']; ?></td>   
                <td><?php echo $list['visible']; ?></td>                    
                <td><?php echo $list['nom_status']; ?></td>                                                   
                <td>
                    <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Ca/Modal_Update_Documento') ?>/<?php echo $list['id_documento']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    <a href="#" class="" title="Eliminar" onclick="Delete_Documento('<?php echo $list['id_documento']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var filtro_tabla =  $('#filtro_tabla').val();

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

        if(filtro_tabla == 13){
            var table=$('#example').DataTable( {
                order: [[1,"asc"],[2,"asc"]],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 21,
                "aoColumnDefs" : [ 
                    {
                        'targets' : [ 6,8 ],
                        'visible' : false
                    }
                ]
            } );
        }else{
            var table=$('#example').DataTable( {
                order: [[1,"asc"],[2,"asc"]],
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 21,
                "aoColumnDefs" : [ 
                    {
                        'bSortable' : false,
                        'aTargets' : [ 8 ]
                    }
                ]
            } );
        }
    } );
</script>