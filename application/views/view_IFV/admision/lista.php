<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="8%" class="text-center" title="Apellido Paterno">Ap. Paterno</th>
            <th width="8%" class="text-center" title="Apellido Materno">Ap. Materno</th>
            <th width="10%" class="text-center">Nombre(s)</th>
            <th width="4%" class="text-center" title="Código">Cod.</th>
            <th width="3%" class="text-center" title="Especialidad">Esp.</th>
            <th width="3%" class="text-center" title="Grupo">Gru.</th>
            <th width="4%" class="text-center" title="Grupo">Turno</th> 
            <th width="6%" class="text-center">Alumno</th>
            <th width="5%" class="text-center">Celular</th>
            <th width="7%" class="text-center" title="Matrícula (Estado)">Mat. (Estado)</th>
            <th width="3%" class="text-center" title="Matrícula (Pago)">Mat.(Pag.)</th>
            <th width="6%" class="text-center" title="Matrícula (Fecha)">Mat.(Fec.)</th>
            <th width="7%" class="text-center" title="Cuota 1 (Estado)">Cta1(Estado)</th>
            <th width="3%" class="text-center" title="Cuota 1 (Pago)">Cta1.(Pag.)</th>
            <th width="6%" class="text-center" title="Cuota 1 (Fecha)">Cta1.(Fec.)</th>
            <th width="4%" class="text-center" title="Declaración Jurada">Dec.Jur.</th>
            <th width="5%" class="text-center">Fecha</th>
            <th width="4%" class="text-center" title="Documentos">Doc.</th>
            <th width="2%" class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_admision as $list){ ?>
            <tr class="even pointer text-center"> 
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td><?php echo $list['abreviatura']; ?></td>
                <td><?php echo $list['Grupo']; ?></td>
                <td><?php echo $list['Turno']; ?></td>
                <td><?php echo $list['Alumno']; ?></td>
                <td><?php echo $list['Celular']; ?></td>
                <td>
                <?php if ($list['Estado_Matricula']=="Cancelado"){  ?>
                    <span class="badge" style="background:#92D050;">Cancelado</span>
                <?php }
                else if ($list['Estado_Matricula']=="Pendiente") {?>
                    <span class="badge" style="background:#C00000;">Pendiente</span>
                <?php }
                else{ ?>
                    <span class="badge" style="background:#7F7F7F;"><?php echo $list['Estado_Matricula']; ?></span>
                <?php }?>
                </td>
                <td class="text-right"><?php echo "s./ ".number_format($list['Monto_Matricula'],2); ?></td>
                <td><?php echo $list['Fec_Matricula']; ?></td>
                <td>
                <?php if ($list['Estado_Cuota_1']=="Cancelado"){  ?>
                    <span class="badge" style="background:#92D050;">Cancelado</span>
                <?php }
                else if ($list['Estado_Cuota_1']=="Pendiente") {?>
                    <span class="badge" style="background:#C00000;">Pendiente</span>
                <?php }
                else{ ?>
                    <span class="badge" style="background:#7F7F7F;"><?php echo $list['Estado_Cuota_1']; ?></span>
                <?php }?>
                </td>
                <td class="text-right"><?php echo "s./ ".number_format($list['Monto_Cuota_1'],2); ?></td>
                <td><?php echo $list['Fec_Cuota_1']; ?></td>
                <td><?php echo $list['v_contrato']; ?></td>
                <td><?php echo $list['fecha_firma']; ?></td>
                <td>
                    <?php /*if($list['documentos_subidos']==$list['documentos_obligatorios']){ ?>
                        <span class="badge" style="background:#00C000;color:white;font-size:14px;"><?php echo $list['documentos_subidos']."/".$list['documentos_obligatorios']; ?></span>
                    <?php }else{ ?>
                        <span class="badge" style="background:#C00000;color:white;font-size:14px;"><?php echo $list['documentos_subidos']."/".$list['documentos_obligatorios']; ?></span>
                    <?php }*/ ?>
                </td>
                <td>
                    <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Matriculados_C') ?>/<?php echo $list['ClientId']; ?>"> 
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 18 ]
                }
            ]
        });
    });
</script>