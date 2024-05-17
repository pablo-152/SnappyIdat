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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b><?php echo $get_id[0]['descripcion']." (Transferir Producto) "; ?></b></span></h4>
                </div>

                <div class="heading-elements"> 
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('Laleli8/Detalle_Almacen') ?>/<?php echo $get_id[0]['id_almacen']; ?>">
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
                    <input type="hidden" id="id_almacen" value="<?php echo $get_id[0]['id_almacen']; ?>">
                    <select class="form-control" id="almacen_t" name="almacen_t" onchange="Buscar_Producto_Transferir();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_almacen as $list){ ?>
                            <option value="<?php echo $list['id_almacen']; ?>"><?php echo $list['cod_sede']." - ".$list['descripcion']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div> 
        </div>

        <div class="row ocultar_datos">
            <form id="formulario_transferir" method="POST" enctype="multipart/form-data" class="formulario"> 
                <div id="lista_temporal" class="col-lg-12" style="margin-top: 15px;">
                </div>
            </form>
        </div>

        <div class="modal-footer ocultar_datos">
            <button type="button" class="btn btn-primary" onclick="Detalle_Transferencia();"> 
                Confirmar Transferencia
            </button>    
        </div>

        <div class="row mostrar_datos" style="margin-bottom:15px;">
            <div id="lista_detalle" class="col-lg-12" style="margin-top: 15px;">
            </div>
        </div>

        <div class="modal-footer mostrar_datos">
            <button type="button" class="btn btn-primary" style="background-color:green;border-color:green;color:white;" onclick="Transferir_Producto();">
                Transferir Productos
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

        $('.mostrar_datos').hide();
    });

    function Buscar_Producto_Transferir(){
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

        var url="<?php echo site_url(); ?>Laleli8/Buscar_Producto_Transferir";
        var id_almacen = $("#almacen_t").val();
        var almacen_actual = $("#id_almacen").val();

        if(id_almacen==0){
            $("#lista_temporal").html('');
        }else{
            $.ajax({
                type:"POST",
                url: url,
                data: {'id_almacen':id_almacen,'almacen_actual':almacen_actual},
                success:function (data) {
                    $("#lista_temporal").html(data);
                    $('.ocultar_datos').show();
                    $('.mostrar_datos').hide();
                }
            });   
        }
    }

    function Detalle_Transferencia(){ 
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

        var url="<?php echo site_url(); ?>Laleli8/Detalle_Transferencia";
        var dataString = $("#formulario_transferir").serialize();
        var id_almacen = $("#id_almacen").val();

        $.ajax({
            type:"POST", 
            url:url,
            data:dataString,
            success:function (data) {
                $("#lista_detalle").html(data);
                $('.mostrar_datos').show();
                $('.ocultar_datos').hide();
            }
        });
    }

    function Transferir_Producto(){
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

        var url="<?php echo site_url(); ?>Laleli8/Valida_Transferir_Producto";
        var url2="<?php echo site_url(); ?>Laleli8/Transferir_Producto";
        var dataString = $("#formulario_transferir").serialize();
        var id_almacen = $("#id_almacen").val();

        if(Valida_Transferir_Producto()){
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data!=""){
                        swal.fire(
                            'Errores Encontrados!',
                            data.split("*")[0],
                            'error'
                        ).then(function() {
                            if(data.split("*")[1]=="INCORRECTO"){
                                Buscar_Producto_Transferir();
                            }else{
                                Swal({
                                    title: '¿Desea transferir de todos modos?',
                                    text: "La transferencia contiene errores y no se tomará en cuenta esos registros",
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
                                            data:dataString,
                                            success:function () {
                                                window.location = "<?php echo site_url(); ?>Laleli8/Detalle_Almacen/" + id_almacen;
                                            }
                                        });
                                    }
                                })
                            }
                        });
                    }else{
                        window.location = "<?php echo site_url(); ?>Laleli8/Detalle_Almacen/" + id_almacen;
                    }
                }
            });
        }
    }

    function Valida_Transferir_Producto(){
        if($('#almacen_t').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar almacén a transferir.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('view_LA8/footer'); ?>