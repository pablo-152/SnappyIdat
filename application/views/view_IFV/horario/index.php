<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Horarios (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" href="<?= site_url('AppIFV/Registrar_Horario') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png"/>
                        </a>
                        <a style="cursor:pointer;margin-right:5px;" id="btn_invitar">
                            <img  src="<?= base_url() ?>template/img/copy.png" alt="Duplicar Examen"  style="cursor:pointer; cursor: hand;" />
                        </a>
                        <a href="<?= site_url('AppIFV/Excel_Registro') ?>" >
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <form id="form_index">
                <div class="col-lg-12">
                    <?php foreach($list_carrera as $list){?> 
                        <a onclick="Carrera_Horario('<?php echo $list['id_carrera'] ?>');"  id="invitados" style="color: #ffffff;background-color: <?php echo $list['background_color'] ?>;width: 150px;padding: 5px;font-size:16px" class=" form-group btn"><span><br><?php echo $list['codigo'] ?><br>&nbsp;</span></a>    
                    <?php }?>
                </div>
                <div class="col-lg-12 ">
                    <a onclick="Estado_Horario(1);"  id="invitados" style="color: #ffffff;background-color: #C00000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Activos</span><i class="icon-arrow-down52"></i></a>
                    <a onclick="Estado_Horario(2);"  id="todos" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                    <input type="hidden" name="estadoi" id="estadoi" value="1">
                    <input type="hidden" name="id_especialidadi" id="id_especialidadi" value="<?php echo $list_carrera[0]['id_carrera'] ?>">
                </div>    
            </form>
            
            <div id="busqueda" class="col-lg-12">
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $("#registros").addClass('active');
        $("#hregistros").attr('aria-expanded', 'true');
        $("#horarios_registros").addClass('active');
		document.getElementById("rregistros").style.display = "block";

        Lista_Horario();
    });

    function Estado_Horario(estado){
        $('#estadoi').val(estado);
        Lista_Horario();
    }
    function Carrera_Horario(id_especialidad){
        $('#id_especialidadi').val(id_especialidad);
        Lista_Horario();
    }
    function Lista_Horario() {
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
        var estado=$('#estadoi').val();
        var id_especialidad=$('#id_especialidadi').val();
        var url = "<?php echo site_url(); ?>AppIFV/Lista_Horario";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'estado': estado,'id_especialidad':id_especialidad},
            success: function(resp) {
                $('#busqueda').html(resp);
            }
        });
    }

    function Delete_Horario(id) {
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

        var id = id;
        var url = "<?php echo site_url(); ?>AppIFV/Delete_Horario";
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
                    type: "POST",
                    url: url,
                    data: {'id_horario': id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Horario();
                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>