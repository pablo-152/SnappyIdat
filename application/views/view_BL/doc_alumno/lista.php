<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="12%">Apellido Paterno</th> 
            <th class="text-center" width="12%">Apellido Materno</th>
            <th class="text-center" width="22%">Nombre(s)</th>
            <th class="text-center" width="8%">Código</th>
            <th class="text-center" width="10%">Grado</th>
            <th class="text-center" width="10%">Sección</th>
            <th class="text-center" width="8%">Matrícula</th>
            <th class="text-center" width="8%">Alumno</th>
            <th class="text-center" width="5%">Año</th>
            <th class="text-center" width="5%" title="Documentos">Doc.</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_alumno as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['alum_apater']; ?></td>   
                <td class="text-left"><?php echo $list['alum_amater']; ?></td>   
                <td class="text-left"><?php echo $list['alum_nom']; ?></td>   
                <td><?php echo $list['cod_alum']; ?></td>   
                <td class="text-left"><?php echo $list['nom_grado']; ?></td>     
                <td class="text-left"><?php echo $list['nom_seccion']; ?></td>    
                <td class="text-left"><?php echo $list['estado_matricula']; ?></td>   
                <td><?php echo $list['estado_alumno']; ?></td>  
                <td><?php echo $list['anio']; ?></td> 
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