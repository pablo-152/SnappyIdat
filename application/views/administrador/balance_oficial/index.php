<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<style>
    #div_empresa:hover{
        background-color: #929292;
    }

    #div_empresa{
        background-color:#cecece;
    }

    #imagen_empresa{
        padding: 5px;
        width: 150px;
        height: 150px;
    }

    .verde{
        background-color: #00b976;
        color: #FFF;
        padding: 5px;
        border-radius: 5px;
        font-weight: 100;
        font-size: 14px;
        display: block;
    }

    .rojo{
        background-color: #ff4262;
        color: #FFF;
        padding: 5px;
        border-radius: 5px;
        font-weight: 100;
        font-size: 14px;
        display: block;
    }

    .azul{
        background-color: #008fed;
        color: #FFF;
        padding: 5px;
        border-radius: 5px;
        font-weight: 100;
        font-size: 14px;
        display: block;
    }

    .blanco{
        background-color: #FFF;
        color: #000;
        padding: 5px;
        border-radius: 5px;
        font-weight: 100;
        font-size: 14px;
        border: 1px solid #000;
        display: block;
    }

    .negro{
        background-color: #9B9B9B;
        color: #FFF;
        padding: 5px;
        border-radius: 5px;
        font-weight: 100;
        font-size: 14px;
        margin-top: 10px;
        display: block;
    }

    .gris:hover{
        background-color: #a5a5a5;
        color: #FFF;
    }

    .gris{
        background-color: #cecece;
        color: #FFF;
        padding: 5px;
        border-radius: 5px;
        font-weight: 100;
        font-size: 14px;
        margin-top: 10px;
        display: block;
    }

    .negro:hover{
        background-color: #3C3C3C;
        color: #FFF;
    }

    .positivo{
        border: 1px solid #008fed;
    }

    .negativo{
        border: 1px solid #ff4262;
    }

    .col-lg-1 {
    width: 12.33333333%;
    }

    @media (max-width:1200px){
   
        .col-md-4 {
            width: 24.333333%;
        }
    }

    @media (max-width:768px){
   
        .col-lg-1 {
            width: 100%;
        }
    }
</style>

<script>
    $(document).ready(function(){
        $('.color').click(function(){
            $('.color').each(function(){
            $(this).css('background-color', '');
        });
            $(this).css('background-color', '#0074c5');
        });
    });

    $(document).ready(function(){
        $('.gris').click(function(){
            $('.gris').each(function(){
                $(this).css('background-color', '');
            });
            $(this).css('background-color', '#3C3C3C');
        });
    });
</script>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Balance Oficial (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Balance_Oficial();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="parte_superior" class="container-fluid" style="margin-bottom:20px;">
    </div>

    <input type="hidden" id="empresa_seleccionado" name="empresa_seleccionado" value="GL">
    <input type="hidden" id="anio_seleccionado" name="anio_seleccionado" value="<?php echo date('Y'); ?>">

    <div class="container-fluid" style="margin-bottom:20px;">
        <div class="row">
            <div id="lista_balance_oficial" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#balances_oficiales").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";

        Cambiar_Empresa('GL');
    });

    function Cambiar_Superior(){
        Cargando();

        var empresa = $('#empresa_seleccionado').val();
        var anio = $('#anio_seleccionado').val();
        var url = "<?php echo site_url(); ?>Administrador/Cambiar_Superior_Balance_Oficial";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'empresa':empresa,'anio':anio},
            success: function(data) {
                $('#parte_superior').html(data);
            }
        });
    }

    function Cambiar_Empresa(empresa) {
        Cargando();

        $('#empresa_seleccionado').val(empresa);
        var anio = $('#anio_seleccionado').val();
        var url = "<?php echo site_url(); ?>Administrador/Cambiar_Balance_Oficial";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'empresa':empresa,'anio':anio},
            success: function(data) {
                Cambiar_Superior();
                $('#lista_balance_oficial').html(data);
            }
        });
    }

    function Cambiar_Anio(anio) {
        Cargando();

        $('#anio_seleccionado').val(anio);
        var empresa = $('#empresa_seleccionado').val();
        var url = "<?php echo site_url(); ?>Administrador/Cambiar_Balance_Oficial";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'empresa':empresa,'anio':anio},
            success: function(data) {
                Cambiar_Superior();
                $('#lista_balance_oficial').html(data);
            }
        });
    }

    function Excel_Balance_Oficial(){
        var anio = $('#anio_seleccionado').val();
        var empresa = $('#empresa_seleccionado').val();
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Balance_Oficial/"+empresa+"/"+anio;
    }

    function Excel_Resumen_Oficial(empresa, anio, mes) {
        var anio = anio; 
        var empresa = empresa;
        var mes = mes;
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Resumen_Oficial/"+empresa+"/"+anio+"/"+mes;
    }

    function Excel_Resumen_Oficial_CC(empresa, anio, mes) {
        var anio = anio;
        var empresa = empresa;
        var mes = mes;
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Resumen_Oficial_CC/"+empresa+"/"+anio+"/"+mes;
    }

    function Excel_Resumen_Oficial_ND(empresa, anio, mes) {
        var anio = anio;
        var empresa = empresa;
        var mes = mes;
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Resumen_Oficial_ND/"+empresa+"/"+anio+"/"+mes;
    }

    function Excel_Resumen_Oficial_NC(empresa, anio, mes) {
        var anio = anio;
        var empresa = empresa;
        var mes = mes;
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Resumen_Oficial_NC/"+empresa+"/"+anio+"/"+mes;
    }

    function Excel_Resumen_Oficial_FT(empresa, anio, mes) {
        var anio = anio;
        var empresa = empresa;
        var mes = mes;
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Resumen_Oficial_FT/"+empresa+"/"+anio+"/"+mes;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>