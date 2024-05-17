<table class="table table-hover table-bordered table-striped" id="example_rezagado" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="8%">Ap. Paterno</th> 
            <th class="text-center" width="8%">Ap. Materno</th>   
            <th class="text-center" width="10%">Nombre(s)</th>  
            <th class="text-center" width="5%">Código</th>
            <th class="text-center" width="5%">Pago</th>
            <th class="text-center" width="5%">Monto</th>
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="8%">Correo</th>  
            <th class="text-center" width="6%" title="Fecha Envío">Fecha E.</th>
            <th class="text-center" width="5%">Hora</th> 
            <th class="text-center" width="6%" title="Fecha Termino">Fecha T.</th>
            <th class="text-center" width="5%">Hora</th>  
            <th class="text-center" width="6%">Nota</th>
            <th class="text-center" width="6%" title="Envío Nota">Envío N.</th>
            <th class="text-center" width="5%">Hora</th> 
            <th class="text-center" width="6%">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_rezagado as $list){ ?>                                            
            <tr class="even pointer text-center"> 
                <td class="text-left"><?php echo $list['apater_alumno']; ?></td>         
                <td class="text-left"><?php echo $list['amater_alumno']; ?></td>   
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>                                                     
                <td><?php echo $list['cod_alumno']; ?></td>   
                <td><?php echo $list['nom_pago']; ?></td>       
                <td class="text-right"><?php if($list['monto']!=""){ echo "s./ ".$list['monto']; }else{ echo $list['monto']; } ?></td>       
                <td><?php echo $list['fecha']; ?></td>       
                <td class="text-left"><?php echo $list['email_alumno']; ?></td>     
                <td><?php echo $list['fecha_envio']; ?></td>       
                <td><?php echo $list['hora_envio']; ?></td>       
                <td><?php echo $list['fecha_termino']; ?></td>       
                <td><?php echo $list['hora_termino']; ?></td>     
                <td><?php echo $list['nota']; ?></td>       
                <td><?php echo $list['fecha_nota']; ?></td>       
                <td><?php echo $list['hora_nota']; ?></td>         
                <td><?php echo $list['nom_estado']; ?></td>                           
            </tr>
        <?php } ?> 
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example_rezagado thead tr').clone(true).appendTo( '#example_rezagado thead' );
        $('#example_rezagado thead tr:eq(1) th').each( function (i) {
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

        var table=$('#example_rezagado').DataTable( {
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 15 ]
                }
            ]
        } );
    } );
</script>