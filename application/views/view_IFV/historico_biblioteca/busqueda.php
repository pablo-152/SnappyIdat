<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="3%" title="Código">Código</th>
            <th class="text-center" width="15%">Alumno</th>
            <th class="text-center" width="12%">Especialidad</th>
            <th class="text-center" width="4%" >Acción</th>
            <th class="text-center" width="4%" >Fecha</th>
            <th class="text-center" width="3%">Usuario</th>
            <th class="text-center" width="3%">Código</th>
            <th class="text-center" width="12%">Título</th>
            <th class="text-center" width="12%">Sub-Título</th>
            <th class="text-center" width="10%">Editorial</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_historico as $list){?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['InternalStudentId']; ?></td>   
                <td class="text-left"><?php echo $list['nombres']." ".$list['apater']." ".$list['amater']; ?></td>   
                <td class="text-left"><?php echo $list['especialidad']; ?></td>                                                     
                <td><?php echo $list['nom_accion']; ?></td>   
                <td nowrap><?php echo $list['fecha']; ?></td>   
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>   
                <td class="text-center" nowrap><?php echo $list['cod_biblioteca']; ?></td>   
                <td class="text-left"><?php echo $list['titulo']; ?></td>   
                <td class="text-left"><?php echo $list['subtitulo']; ?></td>   
                <td class="text-left"><?php echo $list['editorial']; ?></td>    
                
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    
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
            ordering:false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 9 ]
        } ]
        } );
    } );
</script>