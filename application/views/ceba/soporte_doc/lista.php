<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%" title="Empresa">Emp.</th>
            <th class="text-center" width="20%">Descripción</th> 
            <th class="text-center" width="15%" title="Nombre (Documento)">Nombre (Doc.)</th>
            <th class="text-center" width="28%">Link</th>
            <th class="text-center" width="8%">Usuario</th>
            <th class="text-center" width="7%">Fecha</th>
            <th class="text-center" width="4%">Archivo</th>
            <th class="text-center" width="4%">Visible</th> 
            <th class="text-center" width="6%">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_soporte_doc as $list) {  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_empresa']; ?></td>             
                <td class="text-left"><?php echo $list['descripcion']; ?></td>    
                <td class="text-left"><?php echo $list['nom_documento']; ?></td>   
                <td class="text-left"><a href="<?php echo $list['href']; ?>" target="_blank"><?php echo $list['link']; ?></a></td>
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>   
                <td><?php echo $list['fecha']; ?></td>     
                <td><?php echo $list['v_documento']; ?></td>   
                <td><?php echo $list['visible']; ?></td>                    
                <td><?php echo $list['nom_status']; ?></td>                                                   
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var filtro_tabla =  $('#filtro_tabla').val();

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
            order: [[0,"asc"],[1,"asc"]],
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