<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('Admin/nav'); ?>
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 class="tile-title line-head">Lista de Empresas</h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="toolbar">
                                    <div align="right">
                                        <button class="btn btn-info" type="button" title="Nueva Empresa" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Snappy/Modal_Empresa') ?>"><i class="fa fa-plus"></i> Nueva Empresa</button>
                                        <a href="<?= site_url('Snappy/Excel_Empresa') ?>" target="_blank"> Generar excel</a>
                                    </div>
                                </div>
                                <br>
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped" id="papeletas">
                                        <thead>
                                            <tr>
                                                <th>Empresa</th>
                                                <th>Código</th>
                                                <th>Orden</th>
                                                <th>Observaciones</th>
                                                <th>Rep. Redes</th>
                                                <th>Status</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($list_empresa as $list) {  ?>                                           
                                                <tr class="even pointer">
                                                    <td><?php echo $list['nom_empresa']; ?></td>
                                                    <td><?php echo $list['cod_empresa']; ?></td>
                                                    <td><?php echo $list['orden_empresa']; ?></td>
                                                    <td><?php echo $list['observaciones_empresa']; ?></td>
                                                    <td><?php if ($list['rep_redes']==1) {echo "Si";} else {echo "No";}?></td>
                                                    <td><?php echo $list['nom_status']; ?></td>
                                                    <td align="center">
                                                        <img title="Editar Datos Empresa" data-toggle="modal" 
                                                        data-target="#acceso_modal_mod" 
                                                        app_crear_mod="<?= site_url('Snappy/Modal_Update_Empresa') ?>/<?php echo $list["id_empresa"]; ?>" 
                                                        src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" 
                                                        width="22" height="22" />
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</main>
<?php $this->load->view('Admin/footer'); ?>