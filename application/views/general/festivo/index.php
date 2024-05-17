<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>
		
<div class="panel panel-flat"> 
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Festivos & Fechas Importantes (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a title="Nuevo Festivo" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('Snappy/Modal_Festivo') ?>">
                            <img  src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel">
                        </a>

                        <a onclick="Excel_Festivo();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Festivo(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Festivo(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>
        
        <div class="row">
            <div id="lista_festivo" class="col-lg-12">
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#festivo").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

        Lista_Festivo(1);
    });

    function Lista_Festivo(tipo){
        Cargando();

        var url="<?php echo site_url(); ?>General/Lista_Festivo";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (resp) {
                $('#lista_festivo').html(resp);
                $("#tipo_excel").val(tipo);
            }
        });

        var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');
        if(tipo==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Delete_Festivo(id){
        Cargando();

        var id = id;
        var url="<?php echo site_url(); ?>General/Delete_Festivo";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'id_calendar_festivo':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Festivo(1);
                        });
                    }
                });
            }
        })
    }

    function Excel_Festivo(){ 
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>General/Excel_Festivo/"+tipo_excel;
    }
</script>

<?php $this->load->view('general/footer'); ?>
