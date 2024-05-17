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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Sedes (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a title="Nueva Empresa" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('General/Modal_sedes') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('General/Excel_Sede') ?>">
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
                <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                    <thead >
                        <tr>
                            <th class="text-center" width="5%" title="Código">Cód.</th>
                            <th class="text-center" width="5%" title="Empresa">Emp.</th>
                            <th class="text-center" width="15%" title="Local">Local</th>
                            <th class="text-center" width="57%" title="Observación">Observación</th>
                            <th class="text-center" width="10%" title="Aparece en Menú">Apa.&nbsp;Menú</th>
                            <th class="text-center" width="10%" title="Orden de Menú">Ord.&nbsp;Menú</th>
                            <th class="text-center" width="5%" title="Base de Datos">B.&nbsp;Datos</th>
                            <th class="text-center" width="5%" title="Status">Status</th>
                            <td class="text-center" width="3%" title="Acciones"></td>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php foreach($listar_sede as $list) {  ?>                                           
                            <tr class="even pointer">
                                <td><?php echo $list['cod_sede']; ?></td>
                                <td><?php echo $list['cod_empresa']; ?></td>
                                <td><?php echo $list['nom_local']; ?></td>
                                <td class="text-left"><?php echo $list['observaciones_sede']; ?></td>  
                                <td><?php echo $list['aparece_menu']; ?></td>
                                <td><?php echo $list['orden_menu']; ?></td>                                                  
                                <td><?php echo $list['bd']; ?></td>
                                <td><?php echo $list['nom_status']; ?></td>
                                <td>
                                    <img title="Editar Datos de Sede" data-toggle="modal" data-target="#acceso_modal_mod"  app_crear_mod="<?= site_url('General/Modal_Update_sede') ?>/<?php echo $list["id_sede"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
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
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#sedes").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";
    });
</script>

<?php $this->load->view('general/footer'); ?>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
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
            order: [0,"asc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 7 ]
            } ]
        });

    });
</script>
