<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<!--<link href="<?php echo base_url(); ?>template/assets/css/components/custom-accordions.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>template/assets/js/components/ui-accordions.js"></script>-->

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Solicitud</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="#" style="margin-right:5px;">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nueva Acción" />
                        </a><!-- data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Historial_Registro_Mail') ?>/<?php echo $get_id[0]['id_registro']; ?>"-->
                        <a type="button" href="#"><!--<?= site_url('AppIFV/Vista_Update_Centro') ?>/<?php //echo $get_id[0]['id_centro']; ?>-->
                            <img title="Editar Ticket" style="margin-right:5px;cursor:pointer;"  src="<?= base_url() ?>template/img/editar_grande.png" alt="">
                        </a>
                        <a type="button" href="<?= site_url('AppIFV/Solicitud') ?>" >
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-md-12 row">
                    <!--
                    <div class="form-group col-md-1">
                        <label class="control-label text-bold">Código:</label>
                        <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['Codigo']; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Apellido(s) Pat.:</label>
                        <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['Apellido_Paterno']; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Apellido(s) Mat.:</label>
                        <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['Apellido_Materno']; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">Nombre(s):</label>
                        <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['Nombres']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Estado:</label>
                        <input type="text" readonly class="form-control" value="<?php //echo $get_id[0]['Estado']; ?>">
                    </div>
                    -->
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Especialidad:</label>
                        <input type="text" readonly class="form-control" value="<?php //echo $get_id[0]['Codigo']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Lic.:</label>
                        <input type="text" readonly class="form-control" value="<?php //echo $get_id[0]['Apellido_Paterno']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Sede:</label>
                        <input type="text" readonly class="form-control" value="<?php //echo $get_id[0]['Apellido_Materno']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Grupo:</label>
                        <input type="text" readonly class="form-control" value="<?php //echo $get_id[0]['Nombres']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">Año Termino:</label>
                        <input type="text" readonly class="form-control" value="<?php //echo $get_id[0]['Estado']; ?>">
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-12">
                        <label class="control-label text-bold">Observaciones:</label>
                        <textarea class="form-control" disabled id="observacionese" name="observacionese" rows="2"><?php //echo $get_id[0]['observaciones']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <div id="toggleAccordion">
                            <?php $i=1; foreach($list_fase as $list){ ?>
                                <div class="card">
                                    <div class="card-header" id="heading_<?php echo $i; ?>">
                                        <section class="mb-0 mt-0">
                                        <div role="menu" class="collapsed" data-toggle="collapse" data-target="#defaultAccordion_<?php echo $i; ?>" aria-expanded="false" aria-controls="defaultAccordion_<?php echo $i; ?>">
                                            <?php echo $list['nom_fase']; ?>  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                        </div>
                                        </section>
                                    </div>

                                    <div id="defaultAccordion_<?php echo $i; ?>" class="collapse" aria-labelledby="heading_<?php echo $i; ?>" data-parent="#toggleAccordion">
                                        <div class="card-body">
                                            <p class="">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.                                                
                                            </p>

                                            <p class="">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                            </p>  
                                        </div>
                                    </div>
                                </div>
                            <?php $i++; } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
</div>

<?php $i=1; foreach($list_fase as $list){ ?>
    <div class="panel panel-flat panel-collapsed">
        <div class="panel-heading">
            <h5 class="panel-title"><?php echo $list['nom_fase']; ?></h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <!--<li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>-->
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="content-group-lg">
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.
            </div>
        </div>
    </div>
<?php $i++; } ?>

<script>
    $(document).ready(function() {
        $("#titulacion").addClass('active');
        $("#htitulacion").attr('aria-expanded', 'true');
        $("#solicitudes").addClass('active');
		document.getElementById("rtitulacion").style.display = "block";
    });
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>