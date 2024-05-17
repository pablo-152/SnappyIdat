<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="8%" title="Obligatorio">Obg</th>
            <th class="text-center" width="6%">Año</th>
            <th class="text-center" width="5%" title="Código">Cod</th>
            <th class="text-center" width="30%">Nombre</th> 
            <th class="text-center" width="30%">Nombre Documento</th> 
            <th class="text-center" width="8%">Subido Por</th>
            <th class="text-center" width="8%">Fecha Carga</th>
            <td class="text-center" width="5%"></td>  
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($list_documento as $list){ ?> 
            <tr class="even pointer text-center">
                <td><?php echo $list['v_obligatorio']; ?></td>  
                <td><?php echo $list['anio']; ?></td>  
                <td><?php echo $list['cod_documento']; ?></td>  
                <td class="text-left"><?php echo $list['nom_documento']; ?></td>   
                <td class="text-left">
                    <?php if($list['cod_documento']=="D54"){ ?>
                        <?php echo $list['nom_archivo']; ?>
                    <?php }else{ if($list['archivo']==""){ ?>
                        <button style="background-color:#efefef;border-color: #767676;color:black" class="btn btn-primary" title="Archivo" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('LittleLeaders/Modal_Update_Documento_Alumno') ?>/<?php echo $list['id_detalle']; ?>">
                            Subir
                        </button>
                    <?php }else{ ?>
                        <a style="font-size:12px"><?php echo $list['nom_archivo']; ?></a>
                    <?php }} ?>
                </td>
                <td class="text-left"><?php echo $list['usuario_subido']; ?></td> 
                <td><?php echo $list['fec_subido']; ?></td>
                <td>
                    <?php if(($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==27) && $list['archivo']!=""){ ?>
                        <a href="<?= site_url('LeadershipSchool/Descargar_Imagen') ?>/<?php echo $list['id_detalle'] ?>" title="Descargar Documento"> 
                            <img src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer; cursor: hand;"/>
                        </a> 
                    <?php } ?> 

                    <?php if(($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6) && $list['archivo']!=""){ ?>
                        <a style="cursor:pointer" onclick="Delete_Documento_Alumno('<?php echo $list['id_detalle']; ?>')" title="Eliminar">
                            <img src="<?= base_url() ?>template/img/x.png" />
                        </a>
                    <?php } ?> 
                </td>    
            </tr>
        <?php } ?>
    </tbody> 
</table>

<script>
    $('#example thead tr').clone(true).appendTo('#example thead');
    $('#example thead tr:eq(1) th').each(function(i) { 
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

    var table = $('#example').DataTable({
        order: [[1,"desc"],[0,"desc"],[2,"asc"],[3,"asc"]],
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