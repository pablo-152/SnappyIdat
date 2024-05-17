<style>
    .cursor_tabla{
        cursor: help;
    }
</style>

<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="7%" class="text-center cursor_tabla" title="Apellido Paterno">A. Paterno</th>
            <th width="7%" class="text-center cursor_tabla" title="Apellido Materno">A. Materno</th>
            <th width="11%" class="text-center">Nombres</th>
            <th width="5%" class="text-center cursor_tabla" title="Documento de Identidad">Doc. Ide.</th>
            <th width="5%" class="text-center cursor_tabla" title="Cumpleaños">Cumple.</th>
            <th width="5%" class="text-center cursor_tabla" title="Edad (Años)">Edad (A.)</th>
            <th width="4%" class="text-center">Código</th>
            <th width="8%" class="text-center">Grado</th>
            <th width="8%" class="text-center">Sección</th>
            <th width="6%" class="text-center">Status</th>
            <th width="5%" class="text-center">Matricula</th>
            <th width="6%" class="text-center">Usuario</th>
            <th width="5%" class="text-center">Alumno</th>
            <th width="4%" class="text-center">Año</th>
            <th width="5%" class="text-center cursor_tabla" title="Documentos">Documen.</th>
            <th width="6%" class="text-center">Pagos</th>
            <th width="3%" class="text-center"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_alumno as $list) { 
            $fec_de = new DateTime($list['Fecha_Cumpleanos']);
            $fec_hasta = new DateTime(date('Y-m-d'));
            $diff = $fec_de->diff($fec_hasta); 
            ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombres']; ?></td>
                <td><?php echo $list['Documento']; ?></td>
                <td><?php echo $list['Cumpleanos']; ?></td>
                <td><?php echo $diff->y; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Grado']; ?></td>
                <td class="text-left"><?php echo $list['Seccion']; ?></td>
                <td class="text-left"><?php echo $list['MatriculationStatusName']; ?></td>
                <td><?php echo $list['Matricula']; ?></td>
                <td class="text-left"><?php echo $list['Usuario']; ?></td>
                <td><?php echo $list['Alumno']; ?></td>
                <td><?php echo $list['Anio']; ?></td>
                <td>
                    <?php if($list['Cantidad_Subida']==$list['Cantidad_Obligatorio']){ ?>
                        <span class="badge" style="background:#00C000;color:white;font-size:14px;"><?php echo $list['Cantidad_Subida']."/".$list['Cantidad_Obligatorio']; ?></span>
                    <?php }else{ ?>
                        <span class="badge" style="background:#C00000;color:white;font-size:14px;"><?php echo $list['Cantidad_Subida']."/".$list['Cantidad_Obligatorio']; ?></span>
                    <?php } ?>
                </td>
                <td>
                    <a title="Pagos" href="<?= site_url('BabyLeaders/Pago_Matriculados') ?>/<?php echo $list['Id']; ?>">
                        <img title="Pagos" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
                    </a>
                </td>
                <td>
                    <a title="Más Información" href="<?= site_url('BabyLeaders/Detalle_Matriculados') ?>/<?php echo $list['Id']; ?>">
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
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50
        });
    });
</script>