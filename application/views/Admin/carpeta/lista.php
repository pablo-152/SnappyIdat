<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="40%" title="Nombre">Nombre</th>
            <th class="text-center" width="15%" title="Inicio">Inicio</th>
            <th class="text-center" width="15%" title="Fin">Fin</th>
            <th class="text-center" width="10%" title="Bloqueado">Bloque.</th>
            <th class="text-center" width="10%" title="Estado">Estado</th>
            <th class="text-center" width="10%" title="Acciones"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_carpetas as $list){ ?>                                            
            <tr class="even pointer text-center"> 
                <td><?php echo $list['nom_carpeta']; ?></td> 
                <td><?php echo $list['inicio_carpeta']; ?></td> 
                <td><?php echo $list['fin_carpeta']; ?></td> 
                <td><?php echo $list['bloqueo_carpeta_nombre']; ?></td>    
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>   
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('Snappy/Modal_Update_Carpeta') ?>/<?php echo $list['id_carpeta']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <a href="#" class="" title="Eliminar" onclick="Delete_Carpeta('<?php echo $list['id_carpeta']; ?>')" role="button">
                        <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png">
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
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    } );
</script>