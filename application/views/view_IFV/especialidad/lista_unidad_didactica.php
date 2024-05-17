<table class="table table-hover table-bordered table-striped" id="example_unidad_didactica" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Módulo</th>
            <th class="text-center" width="8%">Competencia</th>
            <th class="text-center" width="8%">Código</th> 
            <th class="text-center" width="39%">Nombre</th>
            <th class="text-center" width="8%">Créditos</th>
            <th class="text-center" width="8%" title="Puntaje Mínimo">Pj Mínimo</th>
            <th class="text-center" width="8%">Ciclo</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="5%"></th> 
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_unidad_didactica as $list) {  ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['modulo']; ?></td>         
                <td class="text-left"><?php echo $list['nom_competencia']; ?></td>   
                <td><?php echo $list['cod_unidad_didactica']; ?></td>                                                   
                <td class="text-left"><?php echo $list['nom_unidad_didactica']; ?></td>   
                <td><?php echo $list['creditos']; ?></td>         
                <td><?php echo $list['puntaje_minimo']; ?></td>   
                <td><?php echo $list['ciclo_academico']; ?></td>     
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                         
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Unidad_Didactica') ?>/<?php echo $list['id_unidad_didactica']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a title="Eliminar" href="#" onclick="Delete_Unidad_Didactica('<?php echo $list['id_unidad_didactica']; ?>')" role="button"> 
                        <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png">
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_unidad_didactica thead tr').clone(true).appendTo( '#example_unidad_didactica thead' );
        $('#example_unidad_didactica thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_unidad_didactica').DataTable( {
            order: [[7,"asc"],[0,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 8 ]
                }
            ]
        } );
    } );
</script>