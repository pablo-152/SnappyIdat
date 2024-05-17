<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="11%">Tipo</th>
            <th class="text-center" width="5%">Ref</th> 
            <th class="text-center" width="26%">Descripción</th>
            <th class="text-center" width="26%">Documento</th> 
            <th class="text-center" width="7%">Enviados</th>   
            <th class="text-center" width="7%">Firmados</th> 
            <th class="text-center" width="7%">Por Firmar</th>  
            <th class="text-center" width="6%">Estado</th> 
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_c_contrato as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['tipo']; ?></td>    
                <td><?php echo $list['referencia']; ?></td>   
                <td class="text-left"><?php echo $list['descripcion']; ?></td>   
                <td class="text-left"><?php echo $list['documento']; ?></td>   
                <td><?php echo $list['enviados']; ?></td>   
                <td><?php echo $list['firmados']; ?></td>   
                <td><?php echo $list['por_firmar']; ?></td>   
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_status']; ?></span></td>   
                <td>
                    <a title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('BabyLeaders/Modal_Update_C_Contrato') ?>/<?php echo $list['id_c_contrato']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    </a>

                    <a onclick="Descargar_C_Contrato('<?php echo $list['id_c_contrato']; ?>');">
                        <img src="<?= base_url() ?>template/img/descarga_peq.png">
                    </a>

                    <a href="#" class="" title="Eliminar" onclick="Delete_C_Contrato('<?php echo $list['id_c_contrato']; ?>')" role="button">
                        <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;">
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
            order: [[1,"asc"]],
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