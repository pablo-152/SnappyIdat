<table id="example_horario" class="table table-hover table-bordered table-striped" width="100%">
    <thead> 
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th>
            <th class="text-center" width="20%">Día</th>
            <th class="text-center" width="20%">Hora Entrada</th>
            <th class="text-center" width="20%">Hora Salida</th>
            <th class="text-center" width="20%">Hora Descanso Entrada</th>
            <th class="text-center" width="20%">Hora Salida Descanso</th>
        </tr>
    </thead>
    
    <tbody>
    <?php foreach($list_horario as $list) {  ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['dia']; ?></td> 
                <td><?php echo $list['nom_dia']; ?></td> 
                <td><?php echo $list['hora_entrada']; ?></td>  
                <td><?php echo $list['hora_salida']; ?></td>  
                <td><?php echo $list['hora_descanso_e']; ?></td> 
                <td><?php echo $list['hora_descanso_s']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_horario thead tr').clone(true).appendTo( '#example_horario thead' );
        $('#example_horario thead tr:eq(1) th').each( function (i) {
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

        var table = $('#example_horario').DataTable( {
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 5 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>