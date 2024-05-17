<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="6%">Año</th>
            <th class="text-center" width="20%">Nombre</th>
            <th class="text-center" width="20%">Referencia</th>
            <th class="text-center" width="12%">Tipo</th>
            <th class="text-center" width="12%">Público</th>
            <th class="text-center" width="10%">Monto</th>
            <th class="text-center" width="5%" title="Obligatorio estar al día">Obli.</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_articulo as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['anio']; ?></td>   
                <td class="text-left"><?php echo $list['nombre']; ?></td>   
                <td class="text-left"><?php echo $list['referencia']; ?></td>   
                <td><?php echo $list['nom_tipo']; ?></td>   
                <td><?php echo $list['nom_publico']; ?></td>   
                <td class="text-right"><?php echo "s./ ".$list['monto']; ?></td>   
                <td><?php echo $list['obligatorio_dia']; ?></td>   
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_status']; ?></span></td>                                            
                <td>
                    <img title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('CursosCortos/Modal_Update_Articulo') ?>/<?php echo $list['id_articulo']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    <a href="#" class="" title="Eliminar" onclick="Delete_Articulo('<?php echo $list['id_articulo']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"></a>
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
            order: [[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                }
            ]
        } );
    } );
</script>