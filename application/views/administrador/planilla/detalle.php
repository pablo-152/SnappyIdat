<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>

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

<?php $this->load->view('Admin/nav'); ?>  

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle de Planilla</b></span></h4>
                </div>

                <div class="heading-elements"> 
                    <div class="heading-btn-group"> 
                        <a type="button" href="<?= site_url('Administrador/Planilla') ?>/<?= $get_id[0]['id_sede']; ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png"> 
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 row">
                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Mes:</label>
                </div>
                <div class="form-group col-lg-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['mes']; ?>">
                </div>

                <div class="form-group col-lg-2">
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Fecha:</label>
                </div>
                <div class="form-group col-lg-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['fecha']; ?>">
                </div>
            </div> 

            <div class="col-lg-12 row">
                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Año:</label>
                </div>
                <div class="form-group col-lg-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['anio']; ?>">
                </div>

                <div class="form-group col-lg-2">
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Usuario:</label>
                </div>
                <div class="form-group col-lg-3">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['usuario']; ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="tabset">
                <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
                <label for="tab1">Ingresos - Ventas Directas</label>

                <input type="hidden" id="fecha" name="fecha" value="<?php echo $get_id[0]['fecha']; ?>">
            
                <!-- Ingresos - Ventas Directas -->
                <div class="tab-panels">
                    <section id="marzen" class="tab-panel">
                        <div class="boton_exportable">
                            <a title="Excel" onclick="Excel_Detalle_Cierre_Caja();">
                                <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                            </a>
                        </div>

                        <div id="lista_detalle_cierre_caja" class="box-body table-responsive">
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

        //Lista_Detalle_Cierre_Caja();
    });

    function Lista_Ingreso(){
        Cargando();

        var id_cierre_caja = $("#id_cierre_caja").val();
        var url="<?php echo site_url(); ?>Laleli/Lista_Ingreso_Cierre_Caja";

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
        window.location ="<?php echo site_url(); ?>Laleli/Excel_Ingreso_Cierre_Caja/"+id_cierre_caja;
    }

    function Lista_Egreso(){
        Cargando();

        var id_cierre_caja = $("#id_cierre_caja").val();
        var url="<?php echo site_url(); ?>Laleli/Lista_Egreso_Cierre_Caja";

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
        window.location ="<?php echo site_url(); ?>Laleli/Excel_Egreso_Cierre_Caja/"+id_cierre_caja;
    }

    function Lista_Detalle_Cierre_Caja(){ 
        Cargando();

        var fecha = $("#fecha").val();
        <?php if($get_id[0]['id_empresa']==3){ ?>
            var url="<?php echo site_url(); ?>BabyLeaders/Lista_Detalle_Cierre_Caja";
        <?php }else{ ?>
            var url="<?php echo site_url(); ?>AppIFV/Lista_Detalle_Cierre_Caja";
        <?php } ?>

        $.ajax({
            type:"POST",
            url:url,
            data: {'fecha':fecha},
            success:function (resp) {
                $('#lista_detalle_cierre_caja').html(resp);
            }
        });
    }

    function Excel_Detalle_Cierre_Caja(){
        var fecha=$('#fecha').val().split("-");
        var fecha = fecha[0]+fecha[1]+fecha[2]
        <?php if($get_id[0]['id_empresa']==3){ ?>
            window.location ="<?php echo site_url(); ?>BabyLeaders/Excel_Detalle_Cierre_Caja/"+fecha;
        <?php }else{ ?>
            window.location ="<?php echo site_url(); ?>AppIFV/Excel_Detalle_Cierre_Caja/"+fecha;
        <?php } ?>
    }
</script>

<?php $this->load->view('Admin/footer'); ?>