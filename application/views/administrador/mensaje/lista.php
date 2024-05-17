<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th>
            <th class="text-center" width="4%" title="Empresa">Emp.</th>
            <th class="text-center" width="4%">Sede</th>
            <th class="text-center" width="10%">Tipo</th>
            <th class="text-center" width="13%">Motivo</th>
            <th class="text-center" width="13%">Base de Datos</th>
            <th class="text-center" width="6%" title="Código">Cod</th>
            <th class="text-center" width="6%" title="Celular">Cel.</th>
            <th class="text-center" width="7%" title="Números Enviados">N. Env.</th>
            <th class="text-center" width="6%">Usuario</th> 
            <th class="text-center" width="6%">Fecha</th>
            <th class="text-center" width="6%">Hora</th>
            <th class="text-center" width="16%">Mensaje</th>
            <th class="text-center" width="3%"></th>
        </tr>
    </thead>

    <tbody class="text-center">
        <?php foreach ($list_mensaje as $list){ ?>
            <tr class="even pointer">
                <td><?php echo $list['id_mensaje']; ?></td>
                <td><?php echo $list['cod_empresa']; ?></td>
                <td class="text-left"><?php echo $list['cod_sede']; ?></td>
                <td><?php echo ""; ?></td>
                <td class="text-left"><?php echo $list['motivo']; ?></td>
                <td class="text-left"><?php echo $list['nom_base_datos']; ?></td>
                <td><?php echo ""; ?></td>
                <td><?php echo $list['numero']; ?></td>
                <td><?php echo $list['envios']; ?></td>
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>
                <td><?php echo $list['fecha']; ?></td>
                <td><?php echo $list['hora']; ?></td>
                <td class="text-left"><?php echo $list['mensaje']; ?></td>
                <td>
                    <?php if($list['id_base_datos']!=0){ ?>
                        <a title="Detalle" href="<?= site_url('Administrador/Detalle_Mensaje') ?>/<?php echo $list['id_mensaje']; ?>">
                            <img src="<?= base_url() ?>/template/img/ver.png" style="cursor:pointer;cursor:hand;">
                        </a>
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
            order: [[0,"desc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 13 ]
                } ,
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>