<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="4%">Foto</th> 
            <th class="text-center" width="8%">Ap. Paterno</th>
            <th class="text-center" width="8%">Ap. Materno</th>
            <th class="text-center" width="13%">Nombre(s)</th>
            <th class="text-center" width="6%">Nickname</th>
            <th class="text-center" width="4%" title="Código">Cod.</th>
            <th class="text-center" width="7%">Cargo</th>
            <th class="text-center" width="6%" title="Inicio de Funciones">Inicio F.</th>
            <th class="text-center" width="20%">Correo</th>
            <th class="text-center" width="6%">Celular</th> 
            <th class="text-center" width="4%" title="DNI">DNI</th>
            <th class="text-center" width="4%" title="Curriculum Vitae">CV</th>
            <th class="text-center" width="4%" title="Contrato">CT</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_colaborador as $list){ ?>                                             
            <tr class="even pointer text-center">
                <td><?php echo $list['ft']; ?></td>
                <td class="text-left"><?php echo $list['apellido_paterno']; ?></td> 
                <td class="text-left"><?php echo $list['apellido_materno']; ?></td>
                <td class="text-left"><?php echo $list['nombres']; ?></td>
                <td class="text-left"><?php echo $list['nickname']; ?></td>
                <td><?php echo $list['codigo_gll']; ?></td>
                <td><?php echo $list['perfil'] ?></td>
                <td><?php if($list['inicio_funciones']!="" && $list['inicio_funciones']!="0000-00-00"){echo date('d/m/Y',strtotime($list['inicio_funciones'])); } ?></td>
                <td class="text-left"><?php echo $list['correo_personal']; ?></td>
                <td><?php echo $list['celular']; ?></td>
                <td><?php echo $list['doc']; ?></td>                                                      
                <td><?php echo $list['cv']; ?></td>
                <td><?php echo $list['ct']; ?></td>
                <td>
                    <!--<a title="Editar" href="<?= site_url('AppIFV/Editar_Colaborador') ?>/<?php echo $list['id_colaborador']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>-->

                    <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Colaborador') ?>/<?php echo $list['id_colaborador']; ?>">
                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png">
                    </a>

                    <?php if($list['foto']!=""){ ?>
                        <a onclick="Descargar_Foto_Colaborador('<?php echo $list['id_colaborador']; ?>');">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                    <?php } ?>
                    
                    <a title="Eliminar" onclick="Delete_Colaborador('<?php echo $list['id_colaborador']; ?>')">
                        <img src="<?= base_url() ?>template/img/eliminar.png">
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

        var table = $('#example').DataTable( {
            order: [[1,"asc"],[2,"asc"],[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 13 ]
                }
            ]
        } );
    });
</script>