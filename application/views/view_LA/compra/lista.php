<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center">Orden</th> 
            <th class="text-center" width="8%">Código</th>
            <th class="text-center" width="14%">Tipo</th>
            <th class="text-center" width="14%">Sub-Tipo</th>
            <th class="text-center" width="18%">Tipo Producto</th> 
            <th class="text-center" width="8%">Talla/Ref</th> 
            <th class="text-center" width="8%">Fecha Compra</th> 
            <th class="text-center" width="5%">Año</th> 
            <th class="text-center" width="8%">Precio Compra</th>  
            <th class="text-center" width="8%">Gasto Arpay</th>
            <th class="text-center" width="6%">Cantidad</th>
            <th class="text-center" width="3%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_compra as $list){ ?>                                           
            <tr class="even pointer text-center"> 
                <td><?php echo $list['fecha_compra']; ?></td>
                <td class="text-left"><?php echo $list['codigo']; ?></td>
                <td class="text-left"><?php echo $list['nom_tipo']; ?></td>
                <td class="text-left"><?php echo $list['nom_subtipo']; ?></td>
                <td class="text-left"><?php echo $list['descripcion']; ?></td> 
                <td><?php echo $list['talla']; ?></td>
                <td><?php echo $list['fec_compra']; ?></td>
                <td><?php echo $list['nom_anio']; ?></td> 
                <td class="text-right"><?php echo "s/.".$list['precio_compra']; ?></td>
                <td><?php echo $list['gasto_arpay']; ?></td>
                <td><?php echo $list['cantidad']; ?></td> 
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Laleli/Modal_Update_Compra') ?>/<?php echo $list['id_compra']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
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
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 11 ]
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        } );
    });
</script>