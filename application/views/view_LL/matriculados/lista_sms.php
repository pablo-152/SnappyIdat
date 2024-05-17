<table id="example_sms" class="table table-hover table-bordered table-striped" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden</th>
            <th class="text-center" width="8%">Fecha</th>
            <th class="text-center" width="10%">Usuario</th>
            <th class="text-center" width="82%">Mensaje</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach($list_sms as $list){ ?> 
            <tr class="even pointer text-center"> 
                <td><?php echo $list['orden']; ?></td>  
                <td><?php echo $list['fecha']; ?></td>  
                <td class="text-left"><?php echo $list['usuario']; ?></td>  
                <td class="text-left"><?php echo $list['mensaje']; ?></td>  
            </tr>
        <?php } ?>
    </tbody>  
</table>

<script>
    $('#example_sms thead tr').clone(true).appendTo('#example_sms thead');
    $('#example_sms thead tr:eq(1) th').each(function(i) { 
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

    var table = $('#example_sms').DataTable({
        order: [0,"desc"],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        "aoColumnDefs" : [ 
            {
                'bSortable' : true,
                'aTargets' : [ 3 ] 
            },
            {
                'targets' : [ 0 ],
                'visible' : false
            } 
        ]
    });
</script>