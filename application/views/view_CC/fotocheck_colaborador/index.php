<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_CC/header'); ?>
<?php $this->load->view('view_CC/nav'); ?>

<style>
    .x_x_panel {
        display: flex;
        width: 67px;
        flex-direction: row;
        text-align: center;
        justify-content: space-between;
        position: absolute;
        color: #fff;
        top: 50%;
        right: 200px;
        margin-top: -30px;
    }

    .x_x_panel h3 {
        margin: 0px 0px 0px 0px;
    }

    .x_x_panel h4 {
        margin: 0px 0px 0px 0px;
        font-size: 15px;
    }

    .x_x_panel .lab {
        width: 67px;
        height: 64.59px;
        display: grid;
        align-content: center;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Fotocheck (Alumnos)</b></span></h4>
                </div>

                <div class="x_x_panel">
                    <div class="lab" style="background-color: #e07e80;">
                        <h3><?php echo (0);  ?></h3>
                        <h4>Pdt Pago</h4>
                    </div>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <?php if ($_SESSION['usuario'][0]['id_usuario'] == 1 || $_SESSION['usuario'][0]['id_usuario'] == 7 ||
                            $_SESSION['usuario'][0]['id_usuario'] == 5 || $_SESSION['usuario'][0]['id_usuario'] == 30 ||
                            $_SESSION['usuario'][0]['id_usuario'] == 69 || $_SESSION['usuario'][0]['id_usuario'] == 71 ||
                            $_SESSION['usuario'][0]['id_usuario'] == 81) { ?>
                            <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#LargeLabelModal" LargeLabelModal="<?= site_url('AppIFV/Modal_Envio') ?>">
                                <img src="<?= base_url() ?>template/img/BOTON-ENVIO-FOTOCHECKS.png">
                            </a>
                        <?php } ?>
                        <a onclick="Excel_Fotocheck();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Fotocheck_Alumnos(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Fotocheck_Alumnos(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel" value="1">
        </div>

        <div class="container-fluid">
            <div class="row">
                <div id="lista_fotocheck" class="col-lg-12">
                </div>
            </div>
        </div>
    </div>
</div>


