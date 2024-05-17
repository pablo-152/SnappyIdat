<table class="table table-hover table-striped table-bordered" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th>
            <th class="text-center" width="7%" title="Fecha LogIN">F. LogIN</th>
            <th class="text-center" width="7%" title="Hora LogIN">H. LogIN</th>
            <th class="text-center" width="8%" title="Fecha LogOUT">F. LogOUT</th>
            <th class="text-center" width="8%" title="Hora LogOUT">H. LogOUT</th>
            <th class="text-center" width="6%" title="Tipo Acceso">T. Acce.</th>
            <th class="text-center" width="12%">Usuario</th>
            <th class="text-center" width="5%" title="Código">Cod.</th>
            <th class="text-center" width="8%" title="Apellido Paterno">A. Paterno</th>
            <th class="text-center" width="8%" title="Apellido Materno">A. Materno</th>
            <th class="text-center" width="9%">Nombres</th>
            <th class="text-center" width="17%">Especialidad</th>
            <th class="text-center" width="5%">Grupo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_historico_extranet as $list) {
            $especialidad="";
            $grupo="";
            $busqueda = in_array($list['documento'], array_column($list_matriculado, 'Dni'));
            if ($busqueda != false) {
                $posicion = array_search($list['documento'], array_column($list_matriculado, 'Dni'));
                $codigo = $list_matriculado[$posicion]['Codigo'];
                $especialidad = $list_matriculado[$posicion]['Especialidad'];
                $grupo = $list_matriculado[$posicion]['Grupo'];
            } 
            ?>                                           
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['orden_tabla']; ?></td>
                <td><?php echo $list['dUltimo_Acceso']; ?></td>
                <td><?php echo $list['hUltimo_Acceso']; ?></td>
                <td><?php echo $list['dLogout']; ?></td>
                <td><?php echo $list['hLogout']; ?></td>
                <td><?php echo $list['tipo_acceso']; ?></td>
                <td class="text-left"><?php echo $list['Usuario']; ?></td>
                <td><?php echo $codigo; ?></td>
                <td class="text-left"><?php echo $list['FatherSurname']; ?></td>
                <td class="text-left"><?php echo $list['MotherSurname']; ?></td>
                <td class="text-left"><?php echo $list['FirstName']; ?></td>
                <td class="text-left"><?php echo $especialidad; ?></td>
                <td><?php echo $grupo; ?></td>
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
            order: [0,"desc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ 
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    } );
</script>