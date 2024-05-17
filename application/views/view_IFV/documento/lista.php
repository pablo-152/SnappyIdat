<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="6%">Código</th>
            <th class="text-center" width="6%">Departamento</th>  
            <th class="text-center" width="11%">Especialidad</th>  
            <th class="text-center" width="25%">Nombre</th> 
            <th class="text-center" width="35%">Descripción</th>
            <th class="text-center" width="10%">Obligatorio</th>
            <th class="text-center" width="8%">Documentos</th>
            <th class="text-center" width="8%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_documento as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_documento']; ?></td>  
                <td><?php echo $list['departamento']; ?></td>   
                <td><?php echo $list['nom_especialidad']; ?></td>   
                <td class="text-left"><?php echo $list['nom_documento']; ?></td>   
                <td class="text-left"><?php echo $list['descripcion_documento']; ?></td>   
                <td><?php echo $list['obligatorio']; ?></td> 
                <td><?php if($list['aparece_doc']==1){echo "Si";}else{echo "No";}?></td>   
                <td><?php echo $list['nom_status']; ?></td>   
                <td nowrap>
                    <a title="Editar Datos" data-toggle="modal" data-target="#acceso_modal_mod" 
                    app_crear_mod="<?= site_url('AppIFV/Modal_Update_Documento') ?>/<?php echo $list['id_documento']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>
                    <a href="#" class="" title="Eliminar" onclick="Delete_Documento('<?php echo $list['id_documento']; ?>')" role="button">
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
            order: [[4,"desc"],[0,"asc"]],
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