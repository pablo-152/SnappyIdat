<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="10%" class="text-center cursor_tabla" title="Apellido Paterno">Ap. Paterno</th>
            <th width="10%" class="text-center cursor_tabla" title="Apellido Materno">Ap. Materno</th>
            <th width="12%" class="text-center">Nombre(s)</th>
            <th width="5%" class="text-center cursor_tabla">DNI</th>
            <th width="7%" class="text-center cursor_tabla" title="Fecha Nacimiento">Fecha Nac.</th> 
            <th width="5%" class="text-center" title="Código">Cod.</th>
            <th width="8%" class="text-center">Grado</th>
            <th width="8%" class="text-center">Sección</th>
            <th width="6%" class="text-center" title="Status">Status</th>
            <th width="6%" class="text-center" title="Matricula">Mat.</th>
            <th width="6%" class="text-center" title="Usuario">Usu.</th>
            <th width="6%" class="text-center" title="Alumno">Alu.</th>
            <th width="6%" class="text-center">Año</th>
            <th width="6%" class="text-center cursor_tabla" title="Documentos">Doc.</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_alumno as $list) { ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Dni']; ?></td>
                <td><?php echo $list['Cumpleanos']; ?></td>
                <td><?php echo $list['Codigo']; ?></td>
                <td class="text-left"><?php echo $list['Grado']; ?></td>
                <td class="text-left"><?php echo $list['Seccion']; ?></td>
                <td><?php echo $list['Matricula']; ?></td>
                <td><?php echo $list['Fec_Matricula']; ?></td>
                <td class="text-left"><?php echo $list['Usuario']; ?></td>
                <td><?php echo $list['Alumno']; ?></td> 
                <td><?php echo $list['Anio']; ?></td>
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
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }
        
            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#example').DataTable({
            order: [[0,"asc"],[1,"asc"],[2,"asc"],[5,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 13 ]
                }
            ]
        });
    });
</script>