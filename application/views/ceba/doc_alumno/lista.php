<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Fec Reg</th>
            <th class="text-center" width="6%" title="Código Snappy">Cod. S.</th>
            <th class="text-center" width="6%" title="Código Arpay">Cod. A.</th> 
            <th class="text-center" width="10%">Grado</th>
            <th class="text-center" width="6%">Celular</th>
            <th class="text-center" width="9%">Ap. Paterno</th>
            <th class="text-center" width="9%">Ap. Materno</th>
            <th class="text-center" width="11%">Nombre(s)</th>
            <th class="text-center" width="7%" title="Fecha Registro">Fec. Reg.</th>
            <th class="text-center" width="6%" title="Creado Por">Cre. Por</th>
            <th class="text-center" width="8%">Departa.</th>
            <th class="text-center" width="8%">Provincia</th>
            <th class="text-center" width="4%">Edad</th>
            <th class="text-center" width="4%">Mat.</th>
            <th class="text-center" width="6%">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_alumno as $list){  ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['fec_reg']; ?></td>   
                <td><?php echo $list['cod_alum']; ?></td>   
                <td><?php echo $list['cod_arpay']; ?></td>   
                <td class="text-left"><?php echo $list['descripcion_grado']; ?></td>   
                <td><?php echo $list['alum_celular']; ?></td>   
                <td class="text-left"><?php echo $list['alum_apater']; ?></td>   
                <td class="text-left"><?php echo $list['alum_amater']; ?></td>    
                <td class="text-left"><?php echo $list['alum_nom']; ?></td>    
                <td><?php echo $list['fecha_registro']; ?></td>   
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>  
                <td class="text-left"><?php echo $list['nombre_departamento']; ?></td>   
                <td class="text-left"><?php echo $list['nombre_provincia']; ?></td>          
                <td><?php echo $list['alum_edad']; ?></td>  
                <td><?php echo $list['cant_matricula']; ?></td>   
                <td class="text-left"><?php echo $list['nom_estadoa']; ?></td>                                                                         
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
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 14 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    } );
</script>