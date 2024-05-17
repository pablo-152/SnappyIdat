<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Asistencia (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Asistencia_Colaborador();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-md-2">
                <label class="text-bold">Fecha Inicio:</label>
                <div class="col">
                    <!--<input type="date" class="form-control" id="fec_in" name="fec_in" value="<?php echo date('Y-m-01'); ?>">-->
                    <input type="date" class="form-control" id="fec_in" name="fec_in" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Fecha Fin:</label>
                <div class="col">
                    <input type="date" class="form-control" id="fec_fi" name="fec_fi" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold" style="color: transparent;">Fecha Inicio:</label> 
                <div class="col">
                    <button type="button" class="btn btn-primary"  id="busqueda_lista_asistencia" onclick="Lista_Asistencia(1);">Buscar</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="lista_registro_ingreso" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#colaboradores").addClass('active');
        $("#hcolaboradores").attr('aria-expanded', 'true');
        $("#asistencias_colaboradores").addClass('active');
		document.getElementById("rcolaboradores").style.display = "block";

        Lista_Asistencia(1);
    });

    function Lista_Asistencia(tipo){
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

        var fec_in = $("#fec_in").val();
        var fec_fi = $("#fec_fi").val();
        var url="<?php echo site_url(); ?>Administrador/Asistencia_Colaborador_Lista";

        $.ajax({
            type:"POST",
            url:url,
            data:{'fec_in':fec_in,'fec_fi':fec_fi},
            success:function (resp) {
                $('#lista_registro_ingreso').html(resp);
            }
        });
    }

    function Excel_Asistencia_Colaborador(){
        var fec_in=$('#fec_in').val().split("-");
        var fec_in = fec_in[0]+fec_in[1]+fec_in[2]
        var fec_fi=$('#fec_fi').val().split("-");
        var fec_fi = fec_fi[0]+fec_fi[1]+fec_fi[2];
        window.location = "<?php echo site_url(); ?>Administrador/Excel_Asistencia_Colaborador/"+fec_in+"/"+fec_fi;
    }

    function Delete_Asistencia_Colaborador(id){
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

        var url="<?php echo site_url(); ?>Administrador/Delete_Registro_Ingreso_Lista";

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
                    data: {'id_registro_ingreso':id},
                    success:function () {
                        Lista_Asistencia();
                    }
                });
            }
        })
    }
</script>
<?php $this->load->view('Admin/footer'); ?>

