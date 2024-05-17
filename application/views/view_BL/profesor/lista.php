<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="15%">Apellido Paterno</th>
            <th class="text-center" width="15%">Apellido Materno</th>
            <th class="text-center" width="16%">Nombre(s)</th>
            <th class="text-center" width="10%">Nr. de Empleado</th>
            <th class="text-center" width="10%">DNI</th>
            <th class="text-center" width="10%">Tipo Contrato</th>
            <th class="text-center" width="8%">Fecha Inicio</th>
            <th class="text-center" width="8%">Fecha Fin</th>
            <th class="text-center" width="8%">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_profesor as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['FatherSurname']; ?></td>   
                <td class="text-left"><?php echo $list['MotherSurname']; ?></td>   
                <td class="text-left"><?php echo $list['FirstName']; ?></td>   
                <td><?php echo $list['InternalEmployeeId']; ?></td>   
                <td><?php echo $list['IdentityCardNumber']; ?></td>   
                <td class="text-left"><?php echo $list['Description']; ?></td>   
                <td><?php echo $list['StartDate']; ?></td>   
                <td><?php echo $list['EndDate']; ?></td>   
                <td><?php echo $list['Estado']; ?></td>                                                   
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

        var table=$('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 8 ]
                }
            ]
        } );
    } );
</script>