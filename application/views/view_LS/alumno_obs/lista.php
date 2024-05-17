<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="9%" class="text-center">Empresa</th>
            <th width="5%" class="text-center">Fecha</th>
            <th width="6%" class="text-center">Usuario</th>
            <th width="3%" class="text-center">Código</th>
            <th width="6%" class="text-center">Apellido Pat.</th>
            <th width="7%" class="text-center">Apellido Mat.</th>
            <th width="6%" class="text-center">Nombre(s)</th>
            <th width="4%" class="text-center">Grado</th>
            <th width="3%" class="text-center">Sección</th>
            <th width="24%" class="text-center">Comentario</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_alumno_obs as $list) { ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['nom_empresa']; ?></td>
                <td><?php echo $list['fecha_registro']; ?></td>
                <td><?php echo $list['usuario_codigo']; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Grado']; ?></td>
                <td><?php echo $list['Seccion']; ?></td>
                <td class="text-left"><?php echo $list['observacion']; ?></td>
                <td  style="display:none" width="1%"></td>
                <td  style="display:none" width="1%"></td>
                <td  style="display:none" width="1%"></td>
                <td  style="display:none" width="1%"></td>

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
            order: [[0,"asc"],[1,"asc"],[2,"asc"],[5,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 13 ]
                }
            ]
        });
    });
</script>