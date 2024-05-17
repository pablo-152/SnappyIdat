<table class="table table-hover table-bordered table-striped" id="example" width="100%">
    <thead>
        <tr style="background-color: #E5E5E5;">
            <th class="text-center" width="10%" title="Empresa">Emp.</th>
            <th class="text-center" width="10%">Sede</th>
            <th class="text-center" width="25%" title="Base de Datos">B. Datos</th>
            <th class="text-center" width="10%" title="Cantidad Subida">C. Sub.</th>
            <th class="text-center" width="10%">Números</th>
            <th class="text-center" width="10%">Fecha</th>
            <th class="text-center" width="10%">Usuario</th>
            <th class="text-center" width="10%">Estado</th>
            <th class="text-center" width="5%"></th>
        </tr>
    </thead>
 
    <tbody>
        <?php foreach ($list_base_datos as $list) { ?>
            <tr class="even pointer text-center">
                <td><?php echo $list['cod_empresa']; ?></td>
                <td class="text-left"><?php echo $list['cod_sede']; ?></td>
                <td class="text-left"><?php echo $list['nom_base_datos']; ?></td>
                <td><?php echo $list['num_subido']; ?></td> 
                <td>
                    <a title="Ver Números" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Ver_Numeros') ?>/<?php echo $list['id_base_datos']; ?>">
                        <img title="Ver Números" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;">
                    </a>
                </td>
                <td><?php echo $list['fecha']; ?></td>
                <td class="text-left"><?php echo $list['usuario_codigo']; ?></td>
                <td><span class="badge" style="background-color:<?php echo $list['color']; ?>;"><?php echo $list['nom_status']; ?></span></td>                
                <td>
                    <a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Base_Datos') ?>/<?php echo $list['id_base_datos']; ?>">
                        <img title="Editar" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;">
                    </a>

                    <?php //if($sesion['id_usuario']==1 || $sesion['id_usuario']==5){ ?>
                        <!--<a href="#" class="" title="Eliminar" onclick="Delete_Base_Datos('<?php echo $list['id_base_datos']; ?>')" role="button"> 
                            <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;">
                        </a>-->
                    <?php //} ?>
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
            order: [[0,"asc"],[1,"asc"],[2,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 8 ]
            } ]
        });
    });
</script>