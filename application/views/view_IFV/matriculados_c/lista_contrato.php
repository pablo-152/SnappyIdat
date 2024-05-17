<table id="example_contratos_alumnos" class="table table-hover table-bordered table-striped" width="100%"> 
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th width="8%" class="text-center">Contrato</th> 
            <th width="20%" class="text-center">Descripcion</th>
            <th width="8%" class="text-center">Codigo</th>  
            <th width="16%" class="text-center">Email</th> 
            <th width="8%" class="text-center">Fecha&nbsp;E.</th>
            <th width="8%" class="text-center">Hora&nbsp;E.</th> 
            <th width="8%" class="text-center">Fecha&nbsp;F.</th>
            <th width="8%" class="text-center">Hora&nbsp;F.</th>  
            <th width="8%" class="text-center">Arpay</th> 
            <th width="8%" class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_contrato as $list){ ?>
            <tr class="even pointer text-center">
                <td class="text-left"><?php echo $list['referencia']; ?></td>  
                <td class="text-left"><?php echo $list['descripcion']; ?></td>  
                <td class="text-center"><?php echo $list['cod_alumno']; ?></td> 
                <td class="text-left"><?php echo $list['email_alumno']; ?></td>  
                <td class="text-center"><?php echo $list['fec_envio']; ?></td>
                <td class="text-center"><?php echo $list['hora_envio']; ?></td>
                <td class="text-center"><?php echo $list['fec_firma']; ?></td>
                <td class="text-center"><?php echo $list['hora_firma']; ?></td>
                <td class="text-center"><?php echo $list['v_arpay']; ?></td>
                <td class="text-center"><span class="badge" style="background:<?php echo $list['color_status'] ?>;"><?php echo $list['nom_status']; ?></span></td>
                
            </tr>
        <?php } ?>
    </tbody> 
</table>

<script>
    $('#example_contratos_alumnos thead tr').clone(true).appendTo('#example_contratos_alumnos thead');
    $('#example_contratos_alumnos thead tr:eq(1) th').each(function(i) { 
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

    var table = $('#example_contratos_alumnos').DataTable({
        order: [[6,"desc"]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 100,
        "aoColumnDefs" : [ 
            {
                'bSortable' : false,
                'aTargets' : [ 9 ]
            }
        ]
    });
    
</script>
