<style>
    .cursor_tabla{
        cursor: help;
    }
</style>

<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="9%" class="text-center cursor_tabla" title="Apellido Paterno">Ap. Paterno</th>
            <th width="9%" class="text-center cursor_tabla" title="Apellido Materno">Ap. Materno</th>
            <th width="10%" class="text-center">Nombre(s)</th>
            <th width="4%" class="text-center" title="Código">Cod.</th>
            <th width="7%" class="text-center">Grado</th>
            <th width="4%" class="text-center">Sección</th>
            <th width="6%" class="text-center" title="Status">Status</th>
            <th width="5%" class="text-center" title="Matricula">Mat.</th>
            <th width="6%" class="text-center" title="Usuario">Usu.</th> 
            <th width="5%" class="text-center cursor_tabla" title="Pago Cuota">Pag.Cuo</th>
            <th width="5%" class="text-center cursor_tabla">Monto</th>
            <th width="5%" class="text-center cursor_tabla" title="Pago Matrícula">Pag.Mat.</th>
            <th width="5%" class="text-center" title="Alumno">Alu.</th>
            <th width="4%" class="text-center">Año</th>
            <th width="3%" class="text-center" title="Contrato">Ct.</th>
            <th width="5%" class="text-center">Pagos</th>
            <th width="4%" class="text-center cursor_tabla" title="Documentos">Doc.</th>
            <th width="4%" class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_alumno as $list) { ?>
            <tr class="even pointer text-center" <?php if($tipo==5){ if($list['id_alumno_retirado']!=''){ ?> style="background-color:#5a485b;" <?php } } ?>>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Grado']; ?></td>
                <td class="text-left"><?php echo $list['Seccion']; ?></td> 
                <td><?php echo $list['Matricula']; ?></td>
                <td><?php echo $list['Fec_Matricula']; ?></td>
                <td class="text-left"><?php echo $list['Usuario']; ?></td>
                <td><?php echo $list['Fec_Pago_Cuota_Ingreso']; ?></td>
                <td class="text-right">S/ <?php echo $list['Monto_Cuota_Ingreso']; ?></td>
                <td><?php echo $list['Fec_Pago_Matricula']; ?></td>
                <td><?php echo $list['Alumno']; ?></td>
                <td><?php echo $list['Anio']; ?></td>
                <td><?php echo $list['v_contrato']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color_pago_pendiente']; ?>;"><?php echo $list['nom_pago_pendiente']; ?></span></td>
                <td>
                    <?php if($list['documentos_subidos']==$list['documentos_obligatorios']){ ?>
                        <span class="badge" style="background:#00C000;color:white;font-size:14px;"><?php echo $list['documentos_subidos']."/".$list['documentos_obligatorios']; ?></span>
                    <?php }else{ ?>
                        <span class="badge" style="background:#C00000;color:white;font-size:14px;"><?php echo $list['documentos_subidos']."/".$list['documentos_obligatorios']; ?></span>
                    <?php } ?>
                </td>
                <td>
                    <?php if($tipo==5){ ?>
                        <a title="Retirar" href="<?= site_url('LeadershipSchool/Retiro_Alumno') ?>/<?php echo $list['Id']; ?>">
                            <img src="<?= base_url() ?>template/img/retirar.png">
                        </a>    

                        <?php if($list['id_alumno_retirado']!=""){ ?>
                            <a title="Editar Observación" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('LeadershipSchool/Modal_Update_Obs_Retiro') ?>/<?php echo $list['id_alumno_retirado']; ?>">
                                <img src="<?= base_url() ?>template/img/editar.png">
                            </a>
                        <?php } ?>
                    <?php } ?>

                    <a title="Más Información" href="<?= site_url('LeadershipSchool/Detalle_Matriculados') ?>/<?php echo $list['Id']; ?>">
                        <img title="Más Información" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"],[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 17 ]
                }
            ]
        });
    });
</script>