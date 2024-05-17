<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<?php $this->load->view('view_LA5/header'); ?> 

<style>
    .tabset > input[type="radio"] { 
        position: absolute;
        left: -200vw;
    }

    .tabset .tab-panel {
        display: none;
    }

    .tabset > input:first-child:checked ~ .tab-panels > .tab-panel:first-child,
    .tabset > input:nth-child(3):checked ~ .tab-panels > .tab-panel:nth-child(2),
    .tabset > input:nth-child(5):checked ~ .tab-panels > .tab-panel:nth-child(3),
    .tabset > input:nth-child(7):checked ~ .tab-panels > .tab-panel:nth-child(4),
    .tabset > input:nth-child(9):checked ~ .tab-panels > .tab-panel:nth-child(5),
    .tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6){
        display: block;
    }

    .tabset > label {
        position: relative;
        display: inline-block;
        padding: 15px 15px 25px;
        border: 1px solid transparent;
        border-bottom: 0;
        cursor: pointer;
        font-weight: 600;
        background: #799dfd5c;
    }

    .tabset > label::after {
        content: "";
        position: absolute;
        left: 15px;
        bottom: 10px;
        width: 22px;
        height: 4px;
        background: #8d8d8d;
    }

    .tabset > label:hover,
    .tabset > input:focus + label {
        color: #06c;
    }

    .tabset > label:hover::after,
    .tabset > input:focus + label::after,
    .tabset > input:checked + label::after {
        background: #06c;
    }

    .tabset > input:checked + label {
        border-color: #ccc;
        border-bottom: 1px solid #fff;
        margin-bottom: -1px;
    }

    .tab-panel {
        padding: 30px 0;
        border-top: 1px solid #ccc;
    }

    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    .tabset {
        margin: 8px 15px;
    }

    .contenedor1 {
        position: relative;
        height: 80px;
        width: 80px;
        float: left;
    }

    .contenedor1 img {
        position: absolute;
        left: 0;
        transition: opacity 0.3s ease-in-out;
        height: 80px;
        width: 80px;
    }

    .contenedor1 img.top:hover {
        opacity: 0;
        height: 80px;
        width: 80px;
    }

    table th {
        text-align: center;
    }

    .margintop{
        margin-top:5px ;
    }

    .color_casilla{
        border-color: #C8C8C8;
        color: #000;
        background-color: #C8C8C8 !important;
    }

    .img_class{
        position: absolute;
        width: 80px;
        height: 90px;
        top: 5%;
        left: 1%;
    }

    .boton_exportable{
        margin: 0 0 10px 0;
    }
</style>

<?php $this->load->view('view_LA5/nav'); ?>  
 
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Cierre de Caja</b></span></h4>
                </div>

                <div class="heading-elements"> 
                    <div class="heading-btn-group">
                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                            <!--<a title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" 
                            app_crear_mod="<?= site_url('Laleli4/Modal_Update_Cierre_Caja') ?>/<?php echo $get_id[0]['id_cierre_caja']; ?>"> 
                                <img title="Editar" style="margin-right:5px;cursor:pointer;"  src="<?= base_url() ?>template/img/editar_grande.png" alt="">
                            </a>-->
                        <?php } ?>

                        <a type="button" href="<?= site_url('Laleli4/Cierre_Caja') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Caja:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['caja']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Fecha de Cierre:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['fecha_cierre']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Vendedor:</label> 
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['cod_vendedor']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Vendedor - Cierre:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['cod_entrega']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Saldo Manual:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['monto_entregado']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Empresa:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['cod_sede']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Saldo Automatico:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['saldo_automatico']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Sede:</label>
                </div>
                <div class="form-group col-md-3"> 
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_sede']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Ingresos:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['ingresos']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Ingresos Sistema:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['ingresos']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-2"> 
                    <label class="col-sm-12 control-label text-bold margintop">Egresos:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['egresos']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Egresos en Sistema:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['egresos']; ?>">
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Caja fuerte:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['cofre']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold margintop">Observaciones:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" disabled value="<?php //echo $get_id[0]['cod_empleado']; ?>">
                </div>
            </div> 
        </div>

        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked>
                <label for="tab1">Ingresos - Ventas Directas</label>

                <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2">
                <label for="tab2">Egresos - Devoluciones Directas</label>

                <input type="hidden" id="id_cierre_caja" name="id_cierre_caja" value="<?php echo $get_id[0]['id_cierre_caja']; ?>">
             
                <div class="tab-panels">
                    <!-- INGRESOS -->
                    <section id="rauchbier1" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="Excel_Ingreso();">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a>
                        </div>

                        <div id="lista_ingreso" class="box-body table-responsive">
                        </div> 
                    </section>

                    <!-- EGRESOS -->
                    <section id="rauchbier2" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="Excel_Egreso();">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a>
                        </div>

                        <div id="lista_egreso" class="box-body table-responsive">
                        </div> 
                    </section>
                </div>
            </div> 
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#c_cierres_cajas").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";

        Lista_Ingreso();
        Lista_Egreso();
    });

    function Lista_Ingreso(){ 
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var id_cierre_caja = $("#id_cierre_caja").val();
        var url="<?php echo site_url(); ?>Laleli4/Lista_Ingreso_Cierre_Caja";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_cierre_caja':id_cierre_caja},
            success:function (resp) {
                $('#lista_ingreso').html(resp);
            }
        });
    }

    function Excel_Ingreso(){
        var id_cierre_caja = $("#id_cierre_caja").val();
        window.location ="<?php echo site_url(); ?>Laleli4/Excel_Ingreso_Cierre_Caja/"+id_cierre_caja;
    }

    function Lista_Egreso(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var id_cierre_caja = $("#id_cierre_caja").val();
        var url="<?php echo site_url(); ?>Laleli4/Lista_Egreso_Cierre_Caja";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_cierre_caja':id_cierre_caja},
            success:function (resp) {
                $('#lista_egreso').html(resp);
            }
        });
    }

    function Excel_Egreso(){
        var id_cierre_caja = $("#id_cierre_caja").val();
        window.location ="<?php echo site_url(); ?>Laleli4/Excel_Egreso_Cierre_Caja/"+id_cierre_caja;
    }
</script>

<?php $this->load->view('view_LA5/footer'); ?>