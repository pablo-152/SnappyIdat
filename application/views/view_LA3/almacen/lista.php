<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;"> 
            <th class="text-center" width="5%">Año</th>
            <th class="text-center" width="5%" title="Empresa">Emp.</th>
            <th class="text-center" width="5%">Sede</th>
            <th class="text-center" width="16%">Descripción</th>   
            <th class="text-center" width="6%">Stock</th>
            <th class="text-center" width="6%">Ventas</th>
            <th class="text-center" width="7%">Solicitados</th>
            <th class="text-center" width="8%">Responsable</th>
            <th class="text-center" width="8%">Supervisor</th>
            <th class="text-center" width="8%">Entrega</th>
            <th class="text-center" width="8%">Administrador</th>
            <th class="text-center" width="5%" title="Vendedor(es)">Vend.</th>
            <th class="text-center" width="5%" title="Principal">Pri.</th>
            <th class="text-center" width="5%">Estado</th>
            <th class="text-center" width="3%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($list_almacen as $list){ ?>                                           
            <tr class="even pointer text-center" <?php if($list['principal']==1){ ?> style="background-color:#E2F0D9;" <?php } ?>>
                <td><?php echo $list['nom_anio']; ?></td>
                <td><?php echo $list['cod_empresa']; ?></td>
                <td><?php echo $list['cod_sede']; ?></td> 
                <td class="text-left"><?php echo $list['descripcion']; ?></td>
                <td><?php echo $list['stock']; ?></td>
                <td><?php echo $list['ventas']; ?></td> 
                <td><?php echo ""; ?></td>
                <td class="text-left"><?php echo $list['nom_responsable']; ?></td>
                <td class="text-left"><?php echo $list['nom_supervisor']; ?></td>
                <td class="text-left"><?php echo $list['nom_entrega']; ?></td>
                <td class="text-left"><?php echo $list['nom_administrador']; ?></td>
                <td><?php echo $list['v_vendedor']; ?></td>
                <td><?php echo $list['v_principal']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;font-size:13px;"><?php echo $list['nom_status']; ?></span></td>                                                      
                <td>
                    <a title="Más Información" href="<?= site_url('Laleli3/Detalle_Almacen') ?>/<?php echo $list['id_almacen']; ?>">
                        <img src="<?= base_url() ?>template/img/ver.png"/>
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
            order: [[12,"desc"],[0,"asc"],[1,"asc"],[3,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 14 ]
                }
            ]
        } );
    });
</script>