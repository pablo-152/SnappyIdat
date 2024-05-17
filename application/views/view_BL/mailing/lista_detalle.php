<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden</th>  
            <th class="text-center" width="6%">Cod</th> 
            <th class="text-center" width="8%" title="Apellido Paterno">Ap. Paterno</th>
            <th class="text-center" width="8%" title="Apellido Materno">Ap. Materno</th>
            <th class="text-center" width="14%">Nombre(s)</th> 
            <th class="text-center" width="18%">Apoderado</th>
            <th class="text-center" width="8%" title="Parentesco">Paren.</th>
            <th class="text-center" width="18%">Email</th>
            <th class="text-center" width="8%">Celular</th>  
            <th class="text-center" width="6%" title="Fecha Envío">Fecha E.</th>
            <th class="text-center" width="6%" title="Hora Envío">Hora E.</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_detalle as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['cod_alumno']; ?></td>
                <td class="text-left"><?php echo $list['apater_alumno']; ?></td>
                <td class="text-left"><?php echo $list['amater_alumno']; ?></td>
                <td class="text-left"><?php echo $list['nom_alumno']; ?></td>
                <td class="text-left"><?php echo $list['nom_apoderado']; ?></td>
                <td><?php echo $list['parentesco_apoderado']; ?></td> 
                <td class="text-left"><?php echo $list['email_apoderado']; ?></td> 
                <td><?php echo $list['celular_apoderado']; ?></td> 
                <td><?php echo $list['fec_envio']; ?></td>
                <td><?php echo $list['hora_envio']; ?></td> 
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

        var table = $('#example').DataTable( {
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 10 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                }
            ]
        } );
    });
</script>