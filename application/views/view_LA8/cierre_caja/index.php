<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<?php $this->load->view('view_LA8/header'); ?>
<?php $this->load->view('view_LA8/nav'); ?>  

<div class="panel panel-flat">
    <div class="panel-heading"> 
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cierre de Caja (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Cerrar Caja" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Laleli8/Modal_Cierre_Caja') ?>">
                            <img src="<?= base_url() ?>template/img/cerrar_caja.png" alt="Cerrar Caja" />
                        </a>

                        <a onclick="Excel_Cierre_Caja();">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Lista_Cierre_Caja(1);" id="mes_actual" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Mes actual</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Lista_Cierre_Caja(2);" id="historico" style="color: #000000; background-color: #0070C0;height: 32px;width: 150px;padding: 5px;" class="form-group btn"><span>Histórico</span><i class="icon-arrow-down52"></i></a>
            <input type="hidden" id="tipo_excel" name="tipo_excel"> 
        </div>

        <div class="row">
            <div id="lista_cierre_caja" class="col-lg-12">
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

        Lista_Cierre_Caja(1);
    });

    function Lista_Cierre_Caja(tipo){
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

        var url="<?php echo site_url(); ?>Laleli8/Lista_Cierre_Caja";

        $.ajax({
            type:"POST",
            url:url,
            data: {'tipo':tipo},
            success:function (resp) {
                $('#lista_cierre_caja').html(resp);
                $("#tipo_excel").val(tipo);
            }
        });

        var mes_actual = document.getElementById('mes_actual');
        var historico = document.getElementById('historico');
        if(tipo==1){
            mes_actual.style.color = '#ffffff';
            historico.style.color = '#000000';
        }else{
            mes_actual.style.color = '#000000';
            historico.style.color = '#ffffff';
        }
    } 

    function Delete_Cierre_Caja(id){
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

        var url="<?php echo site_url(); ?>Laleli8/Delete_Cierre_Caja";
        
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
                    data: {'id_cierre_caja':id},
                    success:function () {
                        Lista_Cierre_Caja(1);
                    }
                });
            }
        })
    }

    function Excel_Cierre_Caja() {
        var tipo_excel = $("#tipo_excel").val();
        window.location = "<?php echo site_url(); ?>Laleli8/Excel_Cierre_Caja/"+tipo_excel; 
    }
</script>

<?php $this->load->view('view_LA8/footer'); ?>