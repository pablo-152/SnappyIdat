<table id="example_mensaje" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%">Código</th>
            <th class="text-center" width="35%">Documento / Contrato</th>
            <th class="text-center" width="30%">Subido / Firmado Por</th>
            <th class="text-center" width="15%">Fecha Carga / Firma</th> 
            <th class="text-center" width="10%">Estado</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($list_mensaje as $list){ ?>
            <tr class="even pointer text-center"> 
                <td><?php echo $list['referencia']; ?></td>  
                <td class="text-left"><?php echo $list['descripcion']; ?></td>  
                <td><?php echo $list['Parentesco']; ?></td>  
                <td><?php echo $list['fec_firma']; ?></td> 
                <td><span class="badge" style="background:<?php echo $list['color_status'] ?>;"><?php echo $list['nom_status']; ?></span></td>   
            </tr>
        <?php } ?>
    </tbody>  
</table>

<script>
    $('#example_mensaje thead tr').clone(true).appendTo('#example_mensaje thead');
    $('#example_mensaje thead tr:eq(1) th').each(function(i) { 
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

    var table = $('#example_mensaje').DataTable({
        order: [0,"asc"],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        "aoColumnDefs" : [ 
            {
                'bSortable' : true,
                'aTargets' : [ 4 ] 
            }
        ]
    });
</script>