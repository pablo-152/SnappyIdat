<?php 
$id_usuario= $_SESSION['usuario'][0]['id_usuario'];
$id_nivel= $_SESSION['usuario'][0]['id_nivel'];
?>
<input type="hidden" id="tipo_excel" name="tipo_excel" value="<?php echo $t ?>">
<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="20%">Año</th>
            <th class="text-center" width="20%">Semana</th>
            <th class="text-center" width="20%">De</th>
            <th class="text-center" width="20%">Hasta</th>
            <th class="text-center" width="20%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_semanas as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['anio']; ?></td>             
                <td><?php echo $list['nom_semana']; ?></td>    
                <td><?php echo $list['fec_inicio']; ?></td>   
                <td><?php echo $list['fec_fin']; ?></td>                                                 
                <td>
                    <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('General/Modal_Update_Semana') ?>/<?php echo $list['id_semanas']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    <?php if($id_nivel==1 || $id_usuario==1 || $id_usuario==7){?>
                        <a href="javascript:void(0)" class="" title="Eliminar" onclick="Delete_Semana('<?php echo $list['id_semanas']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>    
                    <?php }?>
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

        var table=$('#example').DataTable( {
            order: [[0,"asc"],[1,"asc"]],
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