<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden</th> 
            <th class="text-center" width="10%">Venta</th>
            <th class="text-center" width="10%">Fecha</th> 
            <th class="text-center" width="10%">Usuario</th>
            <th class="text-center" width="55%">Motivo</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_devolucion as $list){ ?>                                            
            <tr class="even pointer text-center"> 
                <td><?php echo $list['orden']; ?></td>
                <td><?php echo $list['cod_venta']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td class="text-left"><?php echo $list['usuario']; ?></td>
                <td class="text-left"><?php echo $list['motivo']; ?></td> 
                <td><span class="badge" style="background:<?php echo $list['color_estado']; ?>;font-size:13px;"><?php echo $list['nom_estado']; ?></span></td>  
                <td>
                    <?php if($list['estado_d']==0){ ?>
                        <a title="Aprobar" onclick="Update_Devolucion('<?php echo $list['id_devolucion']; ?>',1);">
                            <img src="<?= base_url() ?>template/img/check.png">
                        </a>

                        <a title="Denegar" onclick="Update_Devolucion('<?php echo $list['id_devolucion']; ?>',2);">
                            <img src="<?= base_url() ?>template/img/x.png">
                        </a>
                    <?php } ?>
                </td>
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
                    'bSortable' : false,
                    'aTargets' : [ 6 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>