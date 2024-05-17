<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Empresa</th> 
            <th class="text-center" width="7%">Fecha</th> 
            <th class="text-center" width="4%">Usuario</th> 
            <th class="text-center" width="5%">Código</th>
            <th class="text-center" width="6%">Apellido Pat.</th> 
            <th class="text-center" width="6%">Apellido Mat.</th>
            <th class="text-center" width="9%">Nombre(s)</th>
            <th class="text-center" width="5%">Grado</th>
            <th class="text-center" width="6%">Sección</th>
            <th class="text-center" width="30%">Comentario</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_alumno_obs as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['nom_empresa']; ?></td> 
                <td><?php echo $list['fecha_registro']; ?></td> 
                <td><?php echo $list['usuario_codigo']; ?></td>   
                <td><?php echo $list['cod_alum']; ?></td>
                <td class="text-left"><?php echo $list['alum_apater']; ?></td>   
                <td class="text-left"><?php echo $list['alum_amater']; ?></td>   
                <td class="text-left"><?php echo $list['alum_nom']; ?></td>   
                <td class="text-left"><?php echo $list['nom_grado']; ?></td>     
                <td class="text-left"><?php echo $list['nom_seccion']; ?></td>     
                <td class="text-left"><?php echo $list['observacion']; ?></td>    
                                                                                       
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 9 ]
                }
            ]
        } );
    } );
</script>