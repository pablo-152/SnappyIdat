<?php
$sesion =  $_SESSION['usuario'][0]; 
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<style>
    .x_x_panel{ 
        display: flex;
        width: 180px;
        flex-direction: row;
        text-align: center;
        justify-content: space-between;
        position: absolute;
        color: #fff;
        top: 50%;
        right: 220px;
        margin-top: -36px;
    }

    .x_x_panel h3{ 
        margin: 0px 0px 0px 0px;
    }

    .x_x_panel h4{ 
        margin: 0px 0px 0px 0px;
        font-size: 15px;
    }

    .x_x_panel .lab{
        width: 67px;
        height: 75px;
        display: grid;
        align-content: center; 
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>SMS (Lista)</b></span></h4>
                </div>

                <!--<div class="x_x_panel">
                    <div class="lab" style="background-color: #F8CBAD;">
                        <h4>PEND</h4> 
                        <h3><?php //echo $total_comprado[0]['total']-$total_enviado[0]['total']; ?></h3>
                    </div>        
                </div>-->

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="margin-right:5px;" data-toggle="modal" 
                        data-target="#acceso_modal" app_crear_per="<?= site_url('Administrador/Modal_Mensaje') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a href="<?= site_url('Administrador/Excel_Mensaje') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="x_panel">
            <div class="col-lg-4 col-xs-12">
                <div class="small-box" style="color:#fff;background:#3BB9AE;text-align:center;">
                    <div class="inner" style="text-align: center;">
                        <h3 style="font-size: 32px;"><?php echo $total_enviado[0]['total']; ?></h3>
                    </div>
                    <div>
                        <br><br>
                    </div>
                    <a onclick="Buscar(this,1);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Mensajes Enviados</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: 25px;">
        <div class="col-md-12 row">
            <div class="form-group col-md-1">
                <label class="control-label text-bold">Mes/Año: </label>
            </div>
            <div class="form-group col-md-2">
                <select class="form-control" id="mes_anio" name="mes_anio" onchange="Lista_Mensaje();">
                    <?php foreach($list_mes_anio as $list){ ?>
                        <option value="<?php echo $list['cod_mes_anio']; ?>" <?php if($list['cod_mes_anio']==date('m').date('Y')){ echo "selected"; } ?>>
                            <?php echo $list['mes_anio']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: 25px;">
        <div class="row">
            <div class="col-lg-12" id="lista_mensaje">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comercial").addClass('active');
        $("#hcomercial").attr('aria-expanded', 'true');
        $("#smensaje_sms").addClass('active');
        $("#hmensaje_sms").attr('aria-expanded', 'true');
        $("#lista_mensajes").addClass('active');
        document.getElementById("rmensaje_sms").style.display = "block";
        document.getElementById("rcomercial").style.display = "block";

        Lista_Mensaje();
    });

    function Lista_Mensaje(){
        Cargando();

        var url="<?php echo site_url(); ?>Administrador/Lista_Mensaje";
        var mes_anio = $("#mes_anio").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'mes_anio':mes_anio},
            success:function (resp) {
                $('#lista_mensaje').html(resp);
            }
        });
    }
</script>

<?php $this->load->view('Admin/footer'); ?>