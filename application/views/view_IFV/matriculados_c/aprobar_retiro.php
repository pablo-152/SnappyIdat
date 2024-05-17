<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .img-presentation-small {
        width: 100px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        margin: 5px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span id="titulo" class="text-semibold"><b>Aprobación de Retiro de Alumno</b></span></h4>
                </div>
            </div>
        </div>
    </div>

</div>


<?php $this->load->view('view_IFV/footer'); ?>
<?php $this->load->view('ceba/validaciones'); ?>
<script>
    $(document).ready(function() {
        $("#calendarizaciones").addClass('active');
        $("#hcalendarizaciones").attr('aria-expanded', 'true');
        $("#matriculados_c").addClass('active');
		document.getElementById("rcalendarizaciones").style.display = "block";
        
    });
    var validacion=<?php if(count($validacion)>0){echo count($validacion);}else{echo "0";}; ?>;
    if(validacion>0){
        var aprobado="<?php if(count($validacion)>0){echo $validacion[0]['aprobado'];}else{echo "0";}  ?>";
        if(aprobado!="0"){
            if(aprobado==1){
                txt="aprobada";
            }else{
                txt="desaprobada";
            }
            Swal(
                'Actualización Denegada!',
                'La solicitud ya fue '+txt+' anteriormente.',
                'error'
            ).then(function() {
                window.location = "<?php echo site_url(); ?>AppIFV/Matriculados_C";
            });
        }else{
            var aprobacion="<?php echo $aprobacion ?>";
            if(aprobacion==1){
                txt="aprobó";
            }else{
                txt="desaprobó";
            }
            Swal(
                'Actualización Exitosa!',
                'La solicitud se '+txt+' exitosamente!',
                'success'
            ).then(function() {
                window.location = "<?php echo site_url(); ?>AppIFV/Matriculados_C";
            });
        }
    }else{
        Swal(
            'Registro no encontrado!',
            '',
            'error'
        ).then(function() {
            window.location = "<?php echo site_url(); ?>AppIFV/Matriculados_C";
        });
    }
</script>
