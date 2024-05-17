<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('view_LS/header'); ?>
<?php $this->load->view('view_LS/nav'); ?>
		
<div class="panel panel-flat"> 
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel"> 
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Calendario (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a title="Nuevo" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('LeadershipSchool/Modal_Calendario') ?>" style="margin-right:5px">
                            <img  src="<?= base_url() ?>template/img/nuevo.png"> 
                        </a>

                        <a onclick="Excel_Calendario();">
                            <img src="<?= base_url() ?>template/img/excel.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Calendario(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Calendario(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel" name="tipo_excel">
        </div>
        
        <div class="row">
            <div id="lista_calendario" class="col-lg-12">
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#c_calendarios").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

        Lista_Calendario(1);
    });

    function Lista_Calendario(tipo){
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

        var url="<?php echo site_url(); ?>LeadershipSchool/Lista_Calendario";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (resp) {
                $('#lista_calendario').html(resp);
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

    function Delete_Calendario(id){
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

        var tipo_excel = $("#tipo_excel").val();
        var url="<?php echo site_url(); ?>LeadershipSchool/Delete_Calendario";

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
                    data: {'id_calendario':id},
                    success:function () {
                        Lista_Calendario(tipo_excel);
                    }
                });
            }
        })
    }

    function Excel_Calendario(){ 
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>LeadershipSchool/Excel_Calendario/"+tipo_excel;
    }
</script>

<?php $this->load->view('view_LS/footer'); ?>
