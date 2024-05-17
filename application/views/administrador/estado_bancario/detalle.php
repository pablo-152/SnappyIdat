<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
$usuario_actual = $_SESSION['usuario'][0]['id_usuario'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b><b><?php echo $get_id[0]['nom_empresa']." (".$get_id[0]['cuenta_bancaria'].")"; ?></b></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <!--<a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Mes_Detalle_Estado_Bancario') ?>/<?php echo $get_id[0]['id_estado_bancario']; ?>">  <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Evento" />
                        </a>-->

                        <a type="button" href="<?= site_url('Administrador/Estado_Bancario') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                        
                        <a style="margin-left:5px;" onclick="Excel_Detalle_Estado_Bancario();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Detalle_Estado_Bancario(1);" id="resumen" style="color: #ffffff;background-color: #4472c4;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Resumen</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Detalle_Estado_Bancario(2);" id="movimientos" style="color: #000;background-color: #6f7072 ;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Movimientos</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="id_estado_bancario" value="<?php echo $get_id[0]['id_estado_bancario']; ?>">
            <input type="hidden" id="tipo_excel" value="1">
        </div>

        <div class="row">
            <div id="lista_detalle_estado_bancario" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded','true');
        $("#ebancario").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";

        Lista_Detalle_Estado_Bancario(1);
    } );

    function Lista_Detalle_Estado_Bancario(tipo){
        Cargando();

        var id_estado_bancario = $("#id_estado_bancario").val();
        var url="<?php echo site_url(); ?>Administrador/Lista_Detalle_Estado_Bancario";
        
        $.ajax({
            type:"POST",
            url:url,
            data:{'tipo':tipo,'id_estado_bancario':id_estado_bancario},
            success:function (data) { 
                $('#lista_detalle_estado_bancario').html(data);
                $('#tipo_excel').val(tipo);
            }
        });

        var resumen = document.getElementById('resumen');
        var movimientos = document.getElementById('movimientos');
        if(tipo==1){
            resumen.style.color = '#ffffff';
            movimientos.style.color = '#000000';
        }else{
            resumen.style.color = '#000000';
            movimientos.style.color = '#ffffff';
        }
    }

    function Excel_Detalle_Estado_Bancario(){
        var tipo_excel = $("#tipo_excel").val();
        var id_estado_bancario = $("#id_estado_bancario").val();

        if(tipo_excel==1){
            window.location = "<?php echo site_url(); ?>Administrador/Excel_Detalle_Estado_Bancario/"+id_estado_bancario;
        }else{
            var mes_anio = $("#mes_anioi").val();
            var mes_anio=mes_anio.replace('/', '&')
            if(mes_anio!=0){
                window.location = "<?php echo site_url(); ?>Administrador/Excel_Estado_Bancario_Mes_Anio/"+id_estado_bancario+"/"+mes_anio;
            }
        }
    }
</script>

<?php $this->load->view('Admin/footer'); ?>

		
