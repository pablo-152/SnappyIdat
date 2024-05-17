<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="7%" class="text-center" title="Código Snappy">Cod.&nbsp;S.</th>
            <th width="6%" class="text-center" title="Código Arpay">Cod.&nbsp;A.</th>
            <th width="10%" class="text-center">Grado</th>
            <th width="12%" class="text-center" title="Apellido Paterno">Ap.&nbsp;Paterno</th>
            <th width="12%" class="text-center" title="Apellido Materno">Ap.&nbsp;Materno</th>
            <th width="14%" class="text-center">Nombre(s)</th>
            <th width="6%" class="text-center" title="Fecha Registro">F.&nbsp;Reg.</th>
            <th width="10%" class="text-center" title="Departamento">Departa.</th>
            <th width="10%" class="text-center">Provincia</th>
            <th width="5%" class="text-center">Edad</th>
            <th width="8%" class="text-center">Estado</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_matricula as $list){  
            $fec_de = new DateTime($list['fecha_nacimiento']);
            $fec_hasta = new DateTime(date('Y-m-d'));
            $diff = $fec_de->diff($fec_hasta); ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_alum']; ?></td>
                <td><?php echo $list['cod_arpay']; ?></td>
                <td class="text-left"><?php echo $list['nom_grado']; ?></td>                                                
                <td class="text-left"><?php echo substr($list['alum_apater'],0,20); ?></td>  
                <td class="text-left"><?php echo substr($list['alum_amater'],0,20); ?></td>
                <td class="text-left"><?php echo substr($list['alum_nom'],0,20); ?></td>
                <td><?php echo $list['fecha_registro']; ?></td>
                <td class="text-left"><?php echo substr($list['nombre_departamento'],0,13); ?></td>
                <td class="text-left"><?php echo substr($list['nombre_provincia'],0,26); ?></td>
                <td><?php echo $diff->y; ?></td>
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