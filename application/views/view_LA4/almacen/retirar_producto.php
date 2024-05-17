<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA4/header'); ?>
<?php $this->load->view('view_LA4/nav'); ?> 

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;"> 
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b><?php echo $get_id[0]['descripcion']." (Retirar Producto) "; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group"> 
                        <a type="button" href="<?= site_url('Laleli4/Detalle_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" id="cod_producto" name="cod_producto" placeholder="Código" autofocus onkeypress="if(event.keyCode == 13){ Buscar_Producto_Retirar(); }">
                </div>

                <div class="form-group col-md-2">
                    <input type="hidden" id="id_almacen" value="<?php echo $get_id[0]['id_almacen']; ?>">
                    <button type="button" class="btn btn-primary" onclick="Buscar_Producto_Retirar('<?php echo $get_id[0]['id_almacen']; ?>');">Buscar</button>
                    <a title="Buscar" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Laleli4/Modal_Retirar_Producto_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>">
                        <img src="<?= base_url() ?>template/img/lupa_pequeno.png">
                    </a>
                </div>
            </div> 
        </div>

        <div id="datos_producto" class="row" style="margin-top: 15px;">
        </div>

        <div class="row">
            <div id="lista_temporal" class="col-lg-12" style="margin-top: 15px;">
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" style="background-color:red;border-color:red;color:white;" onclick="Retirar_Producto();"> 
                Retirar Productos
            </button>    
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#almacen").addClass('active');
        $("#halmacen").attr('aria-expanded', 'true');
        $("#a_listas_almacenes").addClass('active');
		document.getElementById("ralmacen").style.display = "block";

        Lista_Temporal_Retirar_Producto();
    });

    function Lista_Temporal_Retirar_Producto(){
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

        var url="<?php echo site_url(); ?>Laleli4/Lista_Temporal_Retirar_Producto";
        var id_almacen = $("#id_almacen").val();

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_almacen':id_almacen},
            success:function (resp) {
                $('#lista_temporal').html(resp);
            }
        });
    }

    function Buscar_Producto_Retirar(){
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

        var url="<?php echo site_url(); ?>Laleli4/Buscar_Producto_Retirar";
        var cod_producto = $("#cod_producto").val();
        var id_almacen = $("#id_almacen").val();

        $.ajax({
            type:"POST",
            url: url,
            data: {'cod_producto':cod_producto,'id_almacen':id_almacen},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡El producto no existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    $("#datos_producto").html(data);
                }
            }
        });   
    }

    function Insert_Temporal_Retirar_Producto(){ 
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

        var dataString = $("#formulario_retirar").serialize();
        var url="<?php echo site_url(); ?>Laleli4/Insert_Temporal_Retirar_Producto";

        if (Valida_Insert_Temporal_Retirar_Producto()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El producto no cuenta con ese stock disponible!",
                            type: 'error',
                            showCancelButton: false, 
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Temporal_Retirar_Producto();
                        $('#cod_producto').val('');
                    }
                }
            });
        }    
    }

    function Valida_Insert_Temporal_Retirar_Producto() {
        if($('#ingresado').val() <= '0') {
            Swal(
                'Ups!',
                'Ingresado debe ser mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Delete_Temporal_Retirar_Producto(id){
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

        var url="<?php echo site_url(); ?>Laleli4/Delete_Temporal_Retirar_Producto";
        
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
                    data: {'id_temporal':id},
                    success:function () {
                        Lista_Temporal_Retirar_Producto();
                    }
                });
            }
        })
    }

    function Retirar_Producto(){
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

        var url="<?php echo site_url(); ?>Laleli4/Valida_Retirar_Producto"; 
        var url2="<?php echo site_url(); ?>Laleli4/Retirar_Producto";
        var id_almacen = $("#id_almacen").val();

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_almacen':id_almacen},
            success:function (data) {
                if(data!=""){
                    if(data.split("*")[0]=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡No se ha seleccionado ningún producto!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Errores Encontrados!', 
                            data.split("*")[0],
                            'error'
                        ).then(function() {
                            if(data.split("*")[1]=="INCORRECTO"){
                                Buscar_Producto_Retirar();
                            }else{
                                Swal({
                                    title: '¿Desea retirar de todos modos?',
                                    text: "El retiro contiene errores y no se tomará en cuenta esos registros",
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
                                            url:url2,
                                            data: {'id_almacen':id_almacen},
                                            success:function () {
                                                window.location = "<?php echo site_url(); ?>Laleli4/Detalle_Almacen/" + id_almacen;
                                            }
                                        });
                                    }
                                })
                            }
                        });
                    }
                }else{ 
                    window.location = "<?php echo site_url(); ?>Laleli4/Detalle_Almacen/" + id_almacen;
                }
            }
        });
    }
</script>

<?php $this->load->view('view_LA4/footer'); ?>