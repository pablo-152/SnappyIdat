<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="5%" title="Obligatorio">Obg</th> 
            <th class="text-center" width="5%" title="Código">Cod</th>
            <th class="text-center" width="25%">Nombre</th>
            <th class="text-center" width="25%">Descripción</th>
            <th class="text-center" width="15%">Documento</th>
            <th class="text-center" width="10%">Subido Por</th>
            <th class="text-center" width="10%">Fecha de Carga</th>
            <td class="text-center" width="5%"></td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($list_documento as $list){  
            if($list['cod_documento']=="D00"){
                $documento = "No";
                if($list['archivo']!=""){ $array = explode("/",$list['archivo']); $documento = $array[3]; }
            }else{
                $id_documento = "";
                $documento = "No";
                $usuario_entrega = "";
                $fecha_entrega = "";
                $documento_subido = "";
                $busqueda=in_array($list['nom_documento'],array_column($arpay,'Nom_Documento'));
                if($busqueda!=false){
                    $posicion = array_search($list['nom_documento'], array_column($arpay, 'Nom_Documento'));
                    $id_documento = $arpay[$posicion]['Id'];
                    if($arpay[$posicion]['Documento_Subido']!=""){
                        $documento = "Si";
                    }
                    $usuario_entrega = $arpay[$posicion]['Usuario_Entrega'];
                    $fecha_entrega = $arpay[$posicion]['Fecha_Entrega'];
                    $documento_subido = $arpay[$posicion]['Documento_Subido']; 
                }
            }
            ?>
            <tr class="even pointer text-center" <?php if($documento!="No"){ ?> style="background-color:#E2F0D9;" <?php } ?>>
                <td><?php echo $list['v_obligatorio']; ?></td>  
                <td><?php echo $list['cod_documento']; ?></td>  
                <td class="text-left"><?php echo $list['nom_documento']; ?></td>  
                <td class="text-left"><?php echo $list['descripcion_documento']; ?></td>  
                <?php if($list['cod_documento']=="D00"){ ?>
                    <td class="text-left">
                        <?php if($list['archivo']==""){ ?> 
                            <?php if($list['id_detalle']==""){ ?>
                                <button style="background-color:#efefef;border-color: #767676;color:black" class="btn btn-primary" title="Archivo" data-toggle="modal" data-target="#acceso_modal" 
                                app_crear_per="<?= site_url('AppIFV/Modal_Documento_Alumno') ?>/<?php echo $list['id_documento']; ?>/<?php echo $id_alumno; ?>">
                                    Subir
                                </button>
                            <?php }else{ ?>
                                <button style="background-color:#efefef;border-color: #767676;color:black" class="btn btn-primary" title="Archivo" data-toggle="modal" data-target="#acceso_modal_mod" 
                                app_crear_mod="<?= site_url('AppIFV/Modal_Update_Documento_Alumno') ?>/<?php echo $list['id_detalle']; ?>">
                                    Subir
                                </button>
                            <?php } ?>
                        <?php }else{ ?>
                            <a style="font-size:12px"><?php echo $documento; ?></a>
                        <?php } ?>
                    </td>
                    <td class="text-left"><?php echo $list['usuario_codigo']; ?></td> 
                    <td><?php echo $list['fec_subido']; ?></td>
                    <td>
                        <?php if(($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==27) && $list['archivo']!=""){ ?>
                            <a href="<?= site_url('AppIFV/Descargar_Documento_Alumno') ?>/<?php echo $list['id_detalle'] ?>" title="Descargar Documento"> 
                                <img src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer; cursor: hand;"/>
                            </a> 
                        <?php } ?> 

                        <?php if(($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6) && $list['archivo']!=""){ ?>
                            <a style="cursor:pointer" onclick="Delete_Documento_Alumno('<?php echo $list['id_detalle']; ?>')" title="Eliminar">
                                <img src="<?= base_url() ?>template/img/x.png" />
                            </a>
                        <?php } ?> 
                    </td>    
                <?php }else{ ?>
                    <td><?php echo $documento; ?></td>  
                    <td class="text-left"><?php echo $usuario_entrega; ?></td> 
                    <td><?php echo $fecha_entrega; ?></td>
                    <td>
                        <?php if(($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==27) && $documento=="Si"){ ?>
                            <a href="http://intranet.gllg.edu.pe/Areas/Frontoffice/Content/StudentDocument/<?php echo $id_documento."/".$documento_subido; ?>" title="Descargar Documento" target="_blank"> 
                                <img src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer; cursor: hand;"/>
                            </a>
                        <?php } ?>
                    </td>    
                <?php } ?>
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
        order: [[0,"desc"],[2,"asc"],[1,"asc"]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 100,
        "aoColumnDefs" : [ 
            {
                'bSortable' : false,
                'aTargets' : [ 7 ]
            }
        ]
    });
</script>