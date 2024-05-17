<table class="table table-hover table-bordered table-striped" id="example_retirado" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="20%">Ap. Paterno</th>
            <th class="text-center" width="20%">Ap. Materno</th>  
            <th class="text-center" width="30%">Nombre(s)</th> 
            <th class="text-center" width="10%">DNI</th> 
            <th class="text-center" width="10%">Código</th>
            <th class="text-center" width="10%">Matricula</th>
            <th class="text-center" width="10%">Alumno</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_retirado as $list){ ?>                                            
            <tr class="even pointer text-center"> 
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>         
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>   
                <td class="text-left"><?php echo $list['Nombre']; ?></td>                                                   
                <td><?php echo $list['Dni']; ?></td>   
                <td><?php echo $list['Codigo']; ?></td>   
                <td><?php echo $list['Matricula']; ?></td>         
                <td><span class="badge" <?php if($list['Alumno']=="Retirado"){ echo "style='background-color:#C00000;'"; }else{ echo "style='background-color:#9cd5d1;'"; } ?>><?php echo $list['Alumno']; ?></span></td>                        
            </tr>
        <?php } ?> 
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_retirado thead tr').clone(true).appendTo( '#example_retirado thead' );
        $('#example_retirado thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_retirado').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 5 ]
                }
            ]
        } );
    } );
</script>