<table class="table table-hover table-bordered table-striped" id="example_unidad_didactica" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Módulo</th> 
            <th class="text-center" width="8%">Competencia</th>
            <th class="text-center" width="8%">Código</th> 
            <th class="text-center" width="52%">Nombre</th>
            <th class="text-center" width="8%">Créditos</th>
            <th class="text-center" width="8%" title="Puntaje Mínimo">Pj Mínimo</th>
            <th class="text-center" width="8%">Ciclo</th> 
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_unidad_didactica as $list){ ?>                                            
            <tr class="even pointer text-center">
                <td><?php echo $list['modulo']; ?></td>         
                <td class="text-left"><?php echo $list['nom_competencia']; ?></td>   
                <td><?php echo $list['cod_unidad_didactica']; ?></td>                                                   
                <td class="text-left"><?php echo $list['nom_unidad_didactica']; ?></td>   
                <td><?php echo $list['creditos']; ?></td>         
                <td><?php echo $list['puntaje_minimo']; ?></td>   
                <td><?php echo $list['ciclo_academico']; ?></td>                           
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_unidad_didactica thead tr').clone(true).appendTo( '#example_unidad_didactica thead' );
        $('#example_unidad_didactica thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_unidad_didactica').DataTable( {
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