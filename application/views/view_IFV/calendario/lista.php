<table class="table table-hover table-bordered table-striped" id="example" width="100%" >
    <thead>
        <tr>
            <th class="text-center">Orden</th> 
            <th class="text-center" width="5%">Año</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="7%" title="Día de Semana">D. Semana</th>
            <th class="text-center" width="25%">Descripción</th>
            <th class="text-center" width="10%">Tipo</th>
            <th class="text-center" width="6%">F/V</th> 
            <th class="text-center" width="35%">Observaciones</th>
            <th class="text-center" width="6%">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_festivo as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['inicio']; ?></td>
                <td><?php echo $list['anio']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['nom_dia']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo_fecha']; ?></td>
                <td><?php echo $list['f_v']; ?></td>
                <td class="text-left"><?php echo $list['observaciones']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                 
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

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
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 8 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>