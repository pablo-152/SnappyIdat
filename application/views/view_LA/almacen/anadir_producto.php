<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LA/header'); ?>
<?php $this->load->view('view_LA/nav'); ?> 

<style>
    .margin_derecha{
        margin-right: 10px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b><?php echo $get_id[0]['descripcion']." (Añadir Producto) "; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('Laleli/Detalle_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>"> 
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
                    <input type="text" class="form-control" id="cod_producto" name="cod_producto" placeholder="Código" autofocus onkeypress="if(event.keyCode == 13){ Buscar_Producto_Anadir(); }">
                </div>

                <div class="form-group col-md-1">
                    <input type="hidden" id="id_almacen" value="<?php echo $get_id[0]['id_almacen']; ?>">
                    <button type="button" class="btn btn-primary margin_derecha" onclick="Buscar_Producto_Anadir();">Buscar</button>
                    <a title="Buscar" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Laleli/Modal_Producto_Almacen') ?>">
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
            <button type="button" class="btn btn-primary" onclick="Anadir_Producto();">
                Añadir Productos
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

        Lista_Temporal_Anadir_Producto();
    });

    function Lista_Temporal_Anadir_Producto(){
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

        var url="<?php echo site_url(); ?>Laleli/Lista_Temporal_Anadir_Producto";
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

    function Buscar_Producto_Anadir(){
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

        var url="<?php echo site_url(); ?>Laleli/Buscar_Producto_Anadir";
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

    function Insert_Temporal_Anadir_Producto(){
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

        var dataString = new FormData(document.getElementById('formulario_anadir'));
        var url="<?php echo site_url(); ?>Laleli/Insert_Temporal_Anadir_Producto"; 

        if (Valida_Insert_Temporal_Anadir_Producto()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡No hay esa cantidad de producto comprada!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Temporal_Anadir_Producto();
                    }
                }
            });
        }    
    }

    function Valida_Insert_Temporal_Anadir_Producto() {
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

    function Delete_Temporal_Anadir_Producto(id){
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

        var url="<?php echo site_url(); ?>Laleli/Delete_Temporal_Anadir_Producto";
        
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
                        Lista_Temporal_Anadir_Producto();
                    }
                });
            }
        })
    }

    function Anadir_Producto(){
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

        var url="<?php echo site_url(); ?>Laleli/Anadir_Producto";
        var id_almacen = $("#id_almacen").val();

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_almacen':id_almacen},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No se ha seleccionado ningún producto!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    window.location = "<?php echo site_url(); ?>Laleli/Detalle_Almacen/" + id_almacen;
                }
            }
        });
    }
</script>

<?php $this->load->view('view_LA/footer'); ?>