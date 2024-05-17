<table class="table table-hover table-bordered table-striped" id="example_alumno" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="19%">Ap. Paterno</th>
            <th class="text-center" width="19%">Ap. Materno</th> 
            <th class="text-center" width="24%">Nombre(s)</th>  
            <th class="text-center" width="8%">DNI</th> 
            <th class="text-center" width="8%">Código</th> 
            <th class="text-center" width="8%">Matricula</th> 
            <th class="text-center" width="8%">Alumno</th>
            <th class="text-center" width="6%" title="Documentos">Doc.</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_alumno as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>         
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>   
                <td class="text-left"><?php echo $list['Nombre']; ?></td>                                                   
                <td><?php echo $list['Dni']; ?></td>   
                <td><?php echo $list['Codigo']; ?></td>   
                <td><?php echo $list['Matricula']; ?></td>         
                <td><span class="badge" <?php if($list['Alumno']=="Retirado"){ echo "style='background-color:#C00000;'"; }else{ echo "style='background-color:#9cd5d1;'"; } ?>><?php echo $list['Alumno']; ?></span></td>                        
                <td>
                    <?php if($list['documentos_subidos']==$list['documentos_obligatorios']){ ?>
                        <span class="badge" style="background:#00C000;color:white;font-size:14px;"><?php echo $list['documentos_subidos']."/".$list['documentos_obligatorios']; ?></span>
                    <?php }else{ ?>
                        <span class="badge" style="background:#C00000;color:white;font-size:14px;"><?php echo $list['documentos_subidos']."/".$list['documentos_obligatorios']; ?></span>
                    <?php } ?>
                </td>         
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_alumno thead tr').clone(true).appendTo( '#example_alumno thead' );
        $('#example_alumno thead tr:eq(1) th').each( function (i) { 
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

        var table=$('#example_alumno').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 6 ]
                }
            ]
        } );
    } );
</script>