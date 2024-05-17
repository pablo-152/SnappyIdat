<?php 
    $sesion =  $_SESSION['usuario'][0];
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<input type="hidden" id="cant_tabla" name="cant_tabla" value="<?php echo $cant_tabla; ?>">

<table id="tabla_todo" class="table table-hover table-striped table-bordered" width="100%" style="font-family:'Source Sans Pro', sans-serif;">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <?php if ($id_nivel == 1 || $id_nivel == 6) { ?>
                <th width="5%"><div align="center"><input type="checkbox" id="total" name="total" onclick="seleccionart();" value="1"></div></th>
            <?php } ?>
            <th width="7%"><div align="center">Código</div></th>
            <th width="6%"><div align="center">Status</div></th>
            <th width="6%"><div align="center">Emp</div></th>
            <th width="6%"><div align="center">Tipo</div></th>
            <th width="6%"><div align="center">SubTipo</div></th>
            <th width="28%"><div align="center">Descripción</div></th>
            <th width="6%"><div align="center">Snappy's</div></th>
            <th width="6%"><div align="center">Agenda</div></th>
            <th width="6%"><div align="center">Usuario</div></th>
            <th width="6%"><div align="center">Fecha</div></th>
            <th width="6%"><div align="center">Usuario</div></th>
            <th width="6%"><div align="center">Fecha</div></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_proyecto as $list) {  ?>
            <tr class="even pointer">
                <?php if ($id_nivel == 1 || $id_nivel == 6) { ?>
                    <td style="width: 1px;word-wrap: break-word" align="center"><input type="checkbox" class="select_checkbox" id="proyecto[]" name="proyecto[]" value="<?php echo $list['id_proyecto']; ?>"></td>
                <?php } ?>
                <td nowrap align="center"><?php echo utf8_encode($list['cod_proyecto']); ?></td>
                <td style="background-color:<?php echo $list['color']; ?>"><?php echo $list['nom_statusp']; ?></td>
                <td nowrap>
                    <?php
                    $empresa = "";
                    foreach ($list_empresam as $emp) {
                        if ($emp['id_proyecto'] == $list['id_proyecto']) {
                            $empresa = $empresa . $emp['cod_empresa'] . ",";
                        }
                    }
                    echo substr($empresa, 0, -1);
                    ?>
                </td>
                <td><?php echo $list['nom_tipo']; ?></td>
                <td><?php echo $list['nom_subtipo']; ?></td>
                <td style="min-width: 100px;max-width: 308px; overflow: hidden;" nowrap><?php echo $list['descripcion']; ?></td>
                <td align="center"><?php echo $list['s_artes'] + $list['s_redes']; ?></td>
                <td align="center"><?php if ($list['fec_agenda'] != '0000-00-00') echo date('d/m/Y', strtotime($list['fec_agenda'])); ?></td>
                <td><?php echo $list['ucodigo_solicitado']; ?></td>
                <td align="center"><?php if ($list['fec_solicitante'] != '0000-00-00') echo date('d/m/Y', strtotime($list['fec_solicitante'])); ?></td>
                <td><?php echo $list['ucodigo_asignado']; ?></td>
                <td align="center"><?php if ($list['fec_termino'] != '0000-00-00 00:00:00') echo date('d/m/Y', strtotime($list['fec_termino'])); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#tabla_todo thead tr').clone(true).appendTo('#tabla_todo thead');
        $('#tabla_todo thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title!=""){
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }else{
                $(this).html('');
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

        var cant_tabla = $('#cant_tabla').val();

        var table = $('#tabla_todo').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: Number(cant_tabla)
        });
    });
</script>