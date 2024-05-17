<table id="example_documento" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">  
            <th class="text-center" width="6%" title="Año">Año</th> 
            <th class="text-center" width="8%" title="Obligatorio">Obg</th>
            <th class="text-center" width="5%" title="Código">Cod</th>
            <th class="text-center" width="29%" title="Nombre">Nombre</th> 
            <th class="text-center" width="29%" title="Nombre Documento">Nombre Documento</th>
            <th class="text-center" width="8%" title="Subido Por">Sub.&nbsp;Por</th>
            <th class="text-center" width="8%" title="Fecha Carga">Fe.&nbsp;Car.</th>
            <td class="text-center" width="7%"></td> 
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($list_documento as $list){ ?>
            <tr class="even pointer text-center">
                <td><?= $list['nom_anio']; ?></td> 
                <td><?= $list['v_obligatorio']; ?></td>  
                <td><?= $list['cod_documento']; ?></td>  
                <td class="text-left"><?= $list['nom_documento']; ?></td> 
                <td class="text-left">
                    <?php if($list['cod_documento']=="D54"){ ?>
                        <?= $list['nom_archivo']; ?>
                    <?php }else{ if($list['archivo']==""){ ?>
                        <button style="background-color:#efefef;border-color: #767676;color:black" class="btn btn-primary" title="Archivo" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('Colaborador/Modal_Update_Documento_Colaborador') ?>/<?= $list['id_detalle']; ?>">
                            Subir
                        </button>
                    <?php }else{ ?>
                        <a style="font-size:12px"><?= $list['nom_archivo']; ?></a>
                    <?php }} ?>
                </td>
                <td class="text-left"><?= $list['usuario_subido']; ?></td> 
                <td><?= $list['fec_subido']; ?></td>
                <td>
                    <?php if($list['archivo']!=""){ ?>
                        <a href="<?= site_url('Colaborador/Descargar_Documento_Colaborador') ?>/<?= $list['id_detalle'] ?>" title="Descargar Documento"> 
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a> 
                    <?php } ?>

                    <?php if(($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6) && $list['archivo']!=""){ ?>
                        <a title="Descartar" onclick="Descartar_Documento_Colaborador('<?= $list['id_detalle']; ?>')">
                            <img src="<?= base_url() ?>template/img/x.png"> 
                        </a>
                    <?php } ?> 

                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                        <a title="Eliminar" onclick="Delete_Documento_Colaborador('<?= $list['id_detalle']; ?>')">
                            <img src="<?= base_url() ?>template/img/eliminar.png"> 
                        </a>
                    <?php } ?>
                </td>    
            </tr>
        <?php } ?>
    </tbody> 
</table>

<script>
    $('#example_documento thead tr').clone(true).appendTo('#example_documento thead'); 
    $('#example_documento thead tr:eq(1) th').each(function(i) { 
        var title = $(this).text();

        if(title==""){
            $(this).html('');
        }else{
            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
        }
    
        $('input', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    var table = $('#example_documento').DataTable({
        order: [[0,"asc"],[2,"asc"]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        "aoColumnDefs" : [ 
            {
                'bSortable' : false,
                'aTargets' : [ 7 ]
            }
        ]
    });
</script>