<?php  
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA4/header'); ?>
<?php $this->load->view('view_LA4/nav'); ?>

<style>
    .parte_superior{
        margin-bottom:15px;
        margin-left:1px;
        padding-top:15px;
        background-color:#E9EEF3;
    }

    .parte_inferior_izquierda{
        margin-bottom:15px;
        margin-right:10px;
    }

    .parte_inferior_derecha{
        margin-bottom:15px;
        margin-left:1px;
        padding-top:15px;
        background-color:#DEEBF7;
    }

    .no_bold{
        font-weight: normal;
    }

    .btn_pagar{
        background-color:#9CD5D1; 
        border-color:#9CD5D1;
    } 

    .letra_grande{
        font-size: 18px;
    }

    .margin_top{
        margin-top:5px ;
    }

    .color_casilla{
        border-color: #DBDBDB;
        color: #000;
        background-color: rgba(219,219,219,255) !important;
    }

    .checkeable img {
        border: 4px solid transparent;
    }

    .checkeable input {
        display: none;
    }

    #cuadros_modal{
        position: relative;
    }

    .clase_modal{
        height: 50px; 
        text-align: center;
        color: #FFF;
        font-size: 25px;
        line-height: 50px;
    }

    #precio_modal{
        position: absolute;
        right: 5%;
        background-color: #64c1e2;
        width: 180px;
    }

    #cantidad_modal{
        position: absolute;
        right: 0%;
        background-color: #33687a;
        width: 50px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Venta (Nueva)</b></span></h4>
                </div> 

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Limpiar" href="<?= site_url('Laleli4/Nueva_Venta') ?>">
                            <img src="<?= base_url() ?>template/img/limpiar.png" alt="Limpiar Página"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div id="div_alumno" class="col-md-12 row parte_superior">
        </div>
    </div> 

    <div class="container-fluid">
        <div class="col-md-9 row parte_inferior_izquierda">
            <div class="row">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" placeholder="Código" id="cod_producto" name="cod_producto" onkeypress="if(event.keyCode == 13){ Insert_Producto_Nueva_Venta(); }">
                </div>

                <div class="form-group col-md-1">
                    <a title="Buscar" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Laleli4/Modal_Producto_Nueva_Venta') ?>">
                        <img src="<?= base_url() ?>template/img/lupa_pequeno.png">
                    </a>
                </div>
            </div>

            <div class="row">
                <div id="lista_producto_nueva_venta" class="col-lg-12">
                </div>
            </div>
        </div>

        <div class="col-md-3 row parte_inferior_derecha">
            <div class="row">
                <div id="div_facturacion" class="form-group col-md-12">
                </div>

                <div id="div_botones" class="form-group col-md-12">
                </div>

                <div id="div_detalle" class="form-group col-md-12">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#venta").addClass('active');
        $("#hventa").attr('aria-expanded', 'true');
        $("#v_nueva").addClass('active'); 
		document.getElementById("rventa").style.display = "block";

        Alumno_Nueva_Venta();
        Lista_Producto_Nueva_Venta();
        Facturacion_Nueva_Venta();
        Botones_Nueva_Venta();
        Detalle_Nueva_Venta();
    });

    $(function () {
        $('#acceso_modal_pequeno').on('shown.bs.modal', function (e) {
            $('#monto_entregado').focus(); 
        })
    });

    function Alumno_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli4/Alumno_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#div_alumno').html(resp);
            }
        });
    }

    function Lista_Producto_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli4/Lista_Producto_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_producto_nueva_venta').html(resp);
            }
        });
    }

    function Facturacion_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli4/Facturacion_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#div_facturacion').html(resp);
            }
        });
    }

    function Botones_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli4/Botones_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#div_botones').html(resp);
            }
        });
    }

    function Detalle_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli4/Detalle_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#div_detalle').html(resp);
            }
        });
    }

    function Update_Alumno_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli4/Update_Alumno_Nueva_Venta";
        var id_alumno =  $("#id_alumno").val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_alumno':id_alumno},
            success:function (resp) {
                Alumno_Nueva_Venta();
                $('#cod_producto').focus();
            }
        });
    }

    function Delete_Alumno_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli4/Delete_Alumno_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                Alumno_Nueva_Venta();
            }
        });
    }

    function Insert_Producto_Nueva_Venta(){  
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

        var url="<?php echo site_url(); ?>Laleli4/Insert_Producto_Nueva_Venta";
        var id_alumno =  $("#id_alumno").val();
        var cod_producto =  $("#cod_producto").val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_alumno':id_alumno,'cod_producto':cod_producto},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡Código inválido!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="no_encomienda"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No se puede encomendar este producto!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="no_stock"){ 
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No hay stock disponible para este producto, realizar otra venta para encomendarlo!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    Lista_Producto_Nueva_Venta();
                    Botones_Nueva_Venta();
                    $('#cod_producto').val('');
                    $('#cod_producto').focus();
                }
            }
        });
    }

    function Delete_Producto_Nueva_Venta(id){
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

        var url="<?php echo site_url(); ?>Laleli4/Delete_Producto_Nueva_Venta";
        
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
                    data: {'id_nueva_venta_producto':id},
                    success:function () {
                        Lista_Producto_Nueva_Venta();
                        Botones_Nueva_Venta();
                    }
                });
            }
        })
    }

    function Update_Facturacion_Nueva_Venta(){ 
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

        if($('#id_tipo_documento_1').is(':checked')){
            $('#dni').val('');
            $('#nombre').val('');
            $('#ruc').val('');
            $('#nom_empresa').val('');
            $('#direccion').val('');
            $('#ubigeo').val('');
            $('#distrito').val('');
            $('#provincia').val('');
            $('#departamento').val('');
            $('#fec_emision').val('');
            $('#fec_vencimiento').val('');
        }else if($('#id_tipo_documento_2').is(':checked')){
            $('#ruc').val('');
            $('#nom_empresa').val('');
            $('#direccion').val('');
            $('#ubigeo').val('');
            $('#distrito').val('');
            $('#provincia').val('');
            $('#departamento').val('');
            $('#fec_vencimiento').val('');
        }else{
            $('#dni').val('');
            $('#nombre').val('');
        }

        var dataString = $("#formulario_facturacion").serialize();
        var url="<?php echo site_url(); ?>Laleli4/Update_Facturacion_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            data:dataString,
            success:function (resp) { 
                Facturacion_Nueva_Venta();
            }
        });
    }
</script>

<?php $this->load->view('view_LA4/footer'); ?>