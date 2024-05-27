<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Documentos Recibidos (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a onclick="Excel_Documento_Recibido();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <div class="container-fluid"> 
        <div class="heading-btn-group">
            <a onclick="Lista_Documento_Recibido(1);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Pendiente</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Documento_Recibido(2);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel" value="1">
        </div>
        <div class="row">
            <div id="lista_documento" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#tramites").addClass('active');
        $("#htramites").attr('aria-expanded','true');
        $("#documentos_recibidos").addClass('active');
		document.getElementById("rtramites").style.display = "block"; 

        Lista_Documento_Recibido(1);
    });

    function Lista_Documento_Recibido(t){
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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Documento_Recibido/"+t;

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_documento').html(resp);
            }
        });

        var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');
        if(t==1){
            activos.style.color = '#ffffff';
            todos.style.color = '#000000';
        }else{
            activos.style.color = '#000000';
            todos.style.color = '#ffffff';
        }
    }

    function Delete_Documento(id){
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Documento";

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
                    data: {'id_documento':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Documento();
                        });
                    }
                });
            }
        })
    }

    function Excel_Documento_Recibido(){
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Documento_Recibido/"+$('#tipo_i').val();
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>