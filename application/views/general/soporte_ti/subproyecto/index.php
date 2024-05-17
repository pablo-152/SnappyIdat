<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Sub-Proyectos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo Usuario" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('General/Modal_Soporte_Subproyecto') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('General/Excel_Soporte_Subproyecto') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped" id="example" width="100%">
                    <thead>
                        <tr>
                            <th class="text-center" width="8%">Empresa</th>
                            <th class="text-center" width="41%">Proyecto</th>
                            <th class="text-center" width="41%">Sub-Proyecto</th>
                            <th class="text-center" width="6%">Estado</th>
                            <td class="text-center" width="4%"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_subproyecto as $list) { ?>
                            <tr class="text-center">
                                <td><?php echo $list['cod_empresa']; ?></td>
                                <td class="text-left"><?php echo $list['proyecto']; ?></td>
                                <td class="text-left"><?php echo $list['subproyecto']; ?></td>
                                <td><?php echo $list['nom_status']; ?></td>
                                <td>
                                    <img title="Editar Datos del Tipo" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('General/Modal_Update_Soporte_Subproyecto') ?>/<?php echo $list["id_subproyecto_soporte"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#soporteti").addClass('active');
        $("#hsoporteti").attr('aria-expanded', 'true');
        $("#configsoporteti").addClass('active');
        $("#hconfigsoporteti").attr('aria-expanded', 'true');
        $("#subproyectos").addClass('active');
		document.getElementById("rsoporteti").style.display = "block";
        document.getElementById("rconfigsoporteti").style.display = "block";
    });
</script>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

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
            pageLength: 25,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 4 ]
                } 
            ]
        });
    });
</script>

<?php $this->load->view('general/footer'); ?>
