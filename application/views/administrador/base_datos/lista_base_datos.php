<table id="example" class="table table-bordered table-striped">
    <thead class="text-center">
        <tr style="background-color: #E5E5E5;">
            <th width="6%">Empresa</th>
            <th width="6%">Sede</th>
            <th width="37%">Base de Datos</th>
            <th width="37%">Números</th>
            <th width="8%">Estado</th>
            <th width="6%">&nbsp;</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php foreach ($list_base_datos as $list) { ?>
            <?php
            $bd_numeros = "";
            foreach ($list_base_datos_num as $num) {
                if ($num['id_base_datos'] == $list['id_base_datos']) {
                    $bd_numeros = $bd_numeros . $num['numero'] . ",";
                }
            }
            ?>
            <tr class="even pointer">
                <td><?php echo $list['cod_empresa']; ?></td>
                <td><?php echo $list['cod_sede']; ?></td>
                <td align="left"><?php echo $list['nom_base_datos']; ?></td>
                <td align="left"><?php echo substr($bd_numeros, 0, -1); ?></td>
                <td><?php echo $list['nom_status']; ?></td>
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Base_Datos') ?>/<?php echo $list['id_base_datos']; ?>">
                        <img title="Editar" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
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

        var table = $('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            dom: 'Bfrtip',
            pageLength: 21
        } );

    } );
</script>