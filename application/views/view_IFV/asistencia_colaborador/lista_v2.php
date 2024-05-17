<table class="table table-hover table-striped table-bordered" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="5%">Hora</th>
            <th class="text-center" width="5%" title="Código">Cod.</th>
            <th class="text-center" width="7%" title="Apellido Paterno">Ap. Paterno</th>
            <th class="text-center" width="7%" title="Apellido Materno">Ap. Materno</th>
            <th class="text-center" width="7%">Nombre(s)</th>
            <th class="text-center" width="4%" title="Observaciones">Ob.</th>
            <th class="text-center" width="8%">Tipo</th>
            <th class="text-center" width="5%">Estado</th>
            <th class="text-center" width="6%" title="Autorización">Aut.</th>
            <th class="text-center" width="6%">Registro</th>
            <th class="text-center" width="6%" title="Tipo Acceso">Usuario</th>
            <th class="text-center" width="6%">Registro</th>
            <th class="text-center" width="6%">Usuario</th>
            <th class="text-center" width="3%"></th>
        </tr>
    </thead> 
    <tbody>
        <?php foreach($list_registro_ingreso as $list){ ?>                                        
            <tr class="even pointer text-center">
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['fecha_ingreso']; ?></td> 
                <td><?php echo $list['hora_ingreso']; ?></td>
                <td><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['apater']; ?></td>
                <td class="text-left"><?php echo $list['amater']; ?></td>
                <td class="text-left"><?php echo $list['nombre']; ?></td>
                <td><?php echo ""//$list['obs']; ?></td>
                <td class="text-left"><?php echo ""//$list['tipo_desc']; ?></td>
                <td class="text-left"><?php echo ""//$list['nom_estado_reporte']; ?></td> 
                <td class="text-left"><?php echo ""//$list['usuario_codigo']; ?></td>
                <td class="text-left"><?php echo ""//$list['estado_ing']; ?></td>
                <td class="text-left"><?php echo ""; ?></td>
                <td><?php echo ""; ?></td>
                <td class="text-left"><?php echo ""; ?></td>
                <td>
                    <?php /*if($list['obs']=="Si"){ ?>
                        <a title="Historial"  data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('AppIFV/Modal_Historial_Registro_Ingreso') ?>/<?php echo $list['id_registro_ingreso']; ?>">
                            <img title="Historial" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
                        </a>
                    <?php } ?>

                    <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                        <a href="#" title="Eliminar" onclick="Delete_Asistencia_Colaborador('<?php echo $list['id_registro_ingreso']; ?>')" role="button"> 
                            <img src="<?= base_url() ?>template/img/eliminar.png">
                        </a>
                    <?php }*/ ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<script>
$(document).ready(function() {
    $("#asistencias").addClass('active');
    $("#hasistencias").attr('aria-expanded', 'true');
    $("#listas_asistencias").addClass('active');
    document.getElementById("rasistencias").style.display = "block";

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
        order: [0,"desc"],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 100,
        "aoColumnDefs" : [ 
            {
                'bSortable' : false,
                'aTargets' : [ 15 ]
            },
            {
                'targets' : [ 0 ],
                'visible' : false
            } 
        ]
    } );
});


</script>    