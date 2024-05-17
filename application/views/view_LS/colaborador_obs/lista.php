<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="5%" class="text-center">Fecha</th>
            <th width="3%" class="text-center">Usuario</th>
            <th width="1%" class="text-center">Código</th>
            <th width="5%" class="text-center" title="Apellido Paterno">Ape.&nbsp;Pat.</th>
            <th width="5%" class="text-center" title="Apellido Materno">Ape.&nbsp;Mat.</th>
            <th width="8%" class="text-center">Nombre(s)</th>           
            <th width="24%" class="text-center">Comentario</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_colaborador_obs as $list) { ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['fecha_registro']; ?></td> 
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>
                <td class="text-left"><?php echo $list['codigo_gll']; ?></td> 
                <td class="text-left"><?php echo $list['apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['apellido_Materno'] ?></td>
                <td class="text-left"><?php echo $list['nombres']; ?></td>
                <td class="text-left"><?php echo $list['Comentario']; ?></td>

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
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 6 ]
                }
            ]
        });
    });
</script>