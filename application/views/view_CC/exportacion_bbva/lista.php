<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th>
            <th class="text-center" width="15%">Fecha Creación</th>
            <th class="text-center" width="15%">Fecha Inicio</th>
            <th class="text-center" width="15%">Fecha Fin</th>
            <th class="text-center" width="20%">Tipo Operación</th>
            <th class="text-center" width="15%">Usuario</th>
            <th class="text-center" width="15%">Número Pagos</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>

    <tbody >
        <?php foreach($list_exportacion_bbva as $list){ ?>                                           
            <tr class="even pointer text-center">
                <td><?php echo $list['fec_reg']; ?></td>
                <td><?php echo $list['fecha_creacion']; ?></td>
                <td><?php echo $list['fecha_inicio']; ?></td>
                <td><?php echo $list['fecha_fin']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo_operacion']; ?></td>
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>       
                <td><?php echo $list['numero_pagos']; ?></td>                                                       
                <td>
                    <a onclick="Generar_Txt('<?php echo $list['id_exportacion']; ?>');">
                        <img title="Generar Txt" src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer;"/>
                    </a>
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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [  
                {
                    'bSortable' : false,
                    'aTargets' : [ 7 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>