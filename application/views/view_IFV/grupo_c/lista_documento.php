<table class="table table-hover table-bordered table-striped" id="example_documento" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="35%">Documento</th> 
            <th class="text-center" width="10%">Estado</th> 
            <th class="text-center" width="25%">Nombre Documento</th> 
            <th class="text-center" width="10%">Fecha</th> 
            <th class="text-center" width="15%">Usuario</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_documento as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['nom_documento']; ?></td>         
                <td><?php echo $list['nom_estado']; ?></td>   
                <td class="text-left">
                    <?php if($list['archivo']==""){ ?>
                        <button style="background-color:#efefef;border-color: #767676;color:black" class="btn btn-primary" title="Archivo" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('AppIFV/Modal_Update_Documento_Grupo_C') ?>/<?php echo $list['id_documento']; ?>">
                            Subir
                        </button>
                    <?php }else{ ?>
                        <a style="font-size:12px"><?php echo $list['nom_archivo']; ?></a>
                    <?php } ?>
                </td>                                                   
                <td><?php echo $list['fecha']; ?></td>   
                <td class="text-left"><?php echo $list['usuario']; ?></td>   
                <td>
                    <?php if($list['archivo']!=""){ ?>
                        <a title="Descargar" href="<?= site_url('AppIFV/Descargar_Documento_Grupo_C') ?>/<?php echo $list['id_documento']; ?>"> 
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a> 
                    <?php } ?> 

                    <?php if(($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6) && $list['archivo']!=""){ ?>
                        <a title="Eliminar" onclick="Delete_Documento('<?php echo $list['id_documento']; ?>')">
                            <img src="<?= base_url() ?>template/img/x.png">
                        </a>
                    <?php } ?> 
                </td>                             
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_documento thead tr').clone(true).appendTo( '#example_documento thead' );
        $('#example_documento thead tr:eq(1) th').each( function (i) { 
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

        var table=$('#example_documento').DataTable( {
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    } );
</script>