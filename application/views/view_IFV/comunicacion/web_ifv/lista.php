<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th>Orden</th>
            <th class="text-center" width="10%">Tipo</th>
            <th class="text-center" width="30%">Referencia o Carrera</th>
            <th class="text-center" width="10%">Activo de</th>
            <th class="text-center" width="10%">Hasta</th>
            <th class="text-center" width="10%">Creado por</th>
            <th class="text-center" width="10%">Fecha</th>
            <th class="text-center" width="5%">Doc.</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th> 
        </tr> 
    </thead>

    <tbody>
        <?php foreach ($list_total_web_ifv as $list) {  ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['inicio_comuimg'] ?></td>
                <td class="text-left"><?php echo $list['tipo']; ?></td>
                <td class="text-left"><?php echo $list['refe_comuimg']; ?></td>
                <td><?php echo $list['inicio'] ?></td>
                <td><?php echo $list['fin']; ?></td>
                <td class="text-left"><?php echo $list['creado_por']; ?></td>
                <td><?php echo $list['fec_reg']; ?></td>
                <td>
                    <?php echo ($list['img_comuimg']!="") ? "SI" : "NO" ?>
                </td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                 
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Web_IFV') ?>/<?php echo $list['id_comuimg']; ?>">
                        <img src="<?= base_url() ?>template/img/editar.png">
                    </a>

                    <?php if($list['img_comuimg']!=""){ ?>
                        <a onclick="Descargar_Web_IFV('<?php echo $list['id_comuimg']; ?>');">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png">
                        </a>
                    <?php } ?>
                    
                    <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6) { ?>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Web_IFV('<?php echo $list['id_comuimg']; ?>')" role="button">
                            <img title="Eliminar" src="<?= base_url() ?>template/img/eliminar.png">
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
            order: [[0,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 9 ]  
                },
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>