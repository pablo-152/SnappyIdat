<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th title="Código Snappy">Cod.&nbsp;S.</th>
            <th title="Código Arpay">Cod.&nbsp;A.</th>
            <th>Grado</th>
            <th title="Celular">Cel.</th>
            <th title="Apellido Paterno">Ap.&nbsp;Paterno</th>
            <th title="Apellido Materno">Ap.&nbsp;Materno</th>
            <th>Nombre(s)</th>
            <th title="Fecha Registro">Fec.&nbsp;Reg.</th>
            <th title="Departamento">Departa.</th>
            <th>Provincia</th>
            <th>Edad</th>
            <th title="Matriculado">Mat.</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_matricula as $list) {  ?>                                           
            <tr <?php if($list['tmatricula']==1){ echo 'style="background-color:#f9da45"'; } ?>  class="even pointer">
                <td class="text-center" nowrap><?php echo $list['cod_alum']; ?></td>
                <td class="text-center" nowrap><?php echo $list['cod_arpay']; ?></td>
                <td nowrap><?php echo $list['descripcion_grado']; ?></td>   
                <td class="text-center" nowrap><?php echo $list['alum_celular']; ?></td>                                                  
                <td nowrap><?php echo substr($list['alum_apater'],0,20); ?></td>  
                <td nowrap><?php echo substr($list['alum_amater'],0,20); ?></td>
                <td nowrap><?php echo substr($list['alum_nom'],0,20); ?></td>
                <td class="text-center" nowrap><?php echo $list['fecha_registro']; ?></td>
                <td nowrap><?php echo substr($list['nombre_departamento'],0,13); ?></td>
                <td nowrap><?php echo substr($list['nombre_provincia'],0,26); ?></td>
                <td class="text-center" nowrap><?php echo $list['alum_edad']; ?></td>
                <td class="text-center" nowrap><?php echo $list['cant_matricula']; ?></td>
                <td nowrap><?php echo $list['nom_estadoa']; ?></td>                                       
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 7 ]
                }
            ]
        } );
    } );
</script>