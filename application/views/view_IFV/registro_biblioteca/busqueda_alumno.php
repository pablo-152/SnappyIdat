
<?php if(count($get_temporal)>0){?> 
    <input type="hidden" id="accion" name="accion" value="<?php echo $get_temporal[0]['accion'] ?>">
    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
        <thead>
            <tr style="background-color: #E5E5E5;">
                <th class="text-center" width="4%" title="Código">Código</th>
                <th class="text-center" width="15%">Alumno</th>
                <th class="text-center" width="15%">Especialidad</th>
                <th class="text-center" width="15%">Acción</th>
                <th class="text-center" width="15%">Fecha</th>
                <th class="text-center" width="15%">Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($get_temporal as $list){
                ?>                                           
                <tr class="even pointer text-center">
                    <td><?php echo $list['InternalStudentId'] ?></td>   
                    <td class="text-left"><?php echo $list['nombres']." ".$list['apater']." ".$list['amater']; ?></td>   
                    <td class="text-left"><?php echo $list['especialidad']; ?></td>    
                    <td><?php if($list['accion']==1){echo "Solicitar"; }if($list['accion']==2){echo "Devolver"; }if($list['accion']==3){echo "Perdido"; }; ?></td>    
                    <td><?php echo $list['fecha']; ?></td>    
                    <td><?php echo $list['usuario']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>  
<?php }else{?>
    <input type="hidden" id="accion" name="accion" >    
<?php }?>


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
            pageLength: 21,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 1 ]
                }
            ]
        } );
    } );
</script>