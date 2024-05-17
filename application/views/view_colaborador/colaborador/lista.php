<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="4%" title="Código">Cod.</th>
            <th class="text-center" width="8%">Ap. Paterno</th>
            <th class="text-center" width="8%">Ap. Materno</th>
            <th class="text-center" width="12%">Nombre(s)</th>
            <th class="text-center" width="8%">Nickname</th>
            <th class="text-center" width="8%">Perfil</th>
            <th class="text-center" width="6%" title="Inicio de Funciones">Inicio F.</th>
            <th class="text-center" width="6%" title="Fin de Funciones">Fin F.</th>
            <th class="text-center" width="6%" title="Inicio de Contrato">Inicio C.</th>
            <th class="text-center" width="6%" title="Fin de Contrato">Fin C.</th>
            <th class="text-center" width="6%">Celular</th> 
            <th class="text-center" width="4%" title="DNI">DNI</th>
            <th class="text-center" width="4%" title="Curriculum Vitae">CV</th>
            <th class="text-center" width="4%" title="Contrato">CT</th>
            <th class="text-center" width="4%" title="Validar correo">VC</th>
            <th class="text-center" width="6%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_colaborador as $list){ ?>                                             
            <tr class="even pointer text-center">
                <td><?= $list['codigo_gll']; ?></td>
                <td class="text-left"><?= $list['apellido_paterno']; ?></td> 
                <td class="text-left"><?= $list['apellido_materno']; ?></td>
                <td class="text-left"><?= $list['nombres']; ?></td>
                <td class="text-left"><?= $list['nickname']; ?></td>
                <td class="text-left"><?= $list['perfil'] ?></td>
                <td><?= $list['inicio_funciones']; ?></td>
                <td><?= $list['fin_funciones']; ?></td>
                <td><?= $list['inicio_contrato']; ?></td>
                <td><?= $list['fin_contrato']; ?></td>
                <td><?= $list['celular']; ?></td>
                <td><?= $list['doc']; ?></td>                                                      
                <td><?= $list['cv']; ?></td>
                <td><?= $list['ct']; ?></td>
                <td><?= $list['validacion_correo']; ?></td>
                <td>
                    <a title="Más Información" href="<?= site_url('Colaborador/Detalle_Colaborador') ?>/<?= $list['id_colaborador']; ?>/<?= $id_sede; ?>">
                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png">
                    </a>

                    <a title="Reenviar" onclick="Reenviar_Validacion_Correo('<?= $list['id_colaborador']; ?>')">
                        <img src="<?= base_url() ?>template/img/Botón_Edición_Reenviar correo.png">
                    </a>
                    
                    <a title="Eliminar" onclick="Delete_Colaborador('<?= $list['id_colaborador']; ?>')">
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
                    'aTargets' : [ 15 ]
                }
            ]
        } );
    });
</script>