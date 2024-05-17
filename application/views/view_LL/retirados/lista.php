<table id="example" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th width="11%" class="text-center" title="Apellido Paterno">Ap. Paterno</th>
            <th width="11%" class="text-center" title="Apellido Materno">Ap. Materno</th>
            <th width="14%" class="text-center">Nombre(s)</th>
            <th width="6%" class="text-center">Código</th> 
            <th width="12%" class="text-center">¿Desde cuando no asiste?</th> 
            <th width="8%" class="text-center">Motivo</th> 
            <th width="8%" class="text-center">¿FUT de retiro?</th>
            <th width="8%" class="text-center">Recibo</th>
            <th width="6%" class="text-center">Fecha</th>
            <th width="10%" class="text-center">¿Pagos Pendientes?</th>
            <th width="6%" class="text-center">Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_retirados as $list){ ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>
                <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td>
                <td class="text-left"><?php echo $list['Nombre']; ?></td>
                <td><?php echo $list['Codigo']; ?></td> 
                <td><?php echo $list['fecha_no_asiste']; ?></td>
                <td><?php echo $list['nom_motivo']; ?></td>
                <td><?php echo $list['fut']; ?></td>
                <td><?php echo $list['tkt_boleta']; ?></td>
                <td><?php echo $list['fecha_fut']; ?></td>
                <td><?php echo $list['pago_pendiente']; ?></td>
                <td title="text-right"><?php echo $list['monto']; ?></td>
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : true,
                    'aTargets' : [ 10 ]
                }
            ]
        });
    });
</script>
