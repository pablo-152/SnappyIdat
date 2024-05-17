<?php 
    $sesion =  $_SESSION['usuario'][0];
    defined('BASEPATH') OR exit('No direct script access allowed');
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .fondo_ref{
        background-color:#715d74 !important;
        color:white;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;">
                    <span class="text-semibold"><b>Público <?php echo $get_id[0]['cod_publico']; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a type="button" data-toggle="modal" data-target="#acceso_modal_mod" 
                        app_crear_mod="<?= site_url('AppIFV/Modal_Historial_Publico') ?>/<?php echo $get_id[0]['id_publico']; ?>" style="margin-right:5px;">  
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <a type="button" href="<?= site_url('AppIFV/Editar_Publico') ?>/<?php echo $get_id[0]['id_publico']; ?>" style="margin-right:5px;">  
                            <img src="<?= base_url() ?>template/img/editar_grande.png">
                        </a>
                        
                        <a type="button" href="<?= site_url('AppIFV/Publico') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="text-bold">Referencia:</label>
                <div class="col">
                    <input type="text" class="form-control fondo_ref" value="<?php echo $get_id[0]['cod_publico']; ?>" readonly>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Tipo:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_tipo']; ?>" readonly>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class=" text-bold">Estado:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_status']; ?>" readonly>
                </div>
            </div>

            <div class="form-group col-md-3">
                <label class="text-bold">Cliente:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['nombres_apellidos'] ?>" readonly>
                </div>
            </div>

            <div class="form-group col-md-3">
                <label class="text-bold">DNI:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['dni'] ?>" readonly>
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-3">
                <label class="text-bold">Departamento:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['nombre_departamento']; ?>" readonly>
                </div>
            </div>
            
            <div class="form-group col-md-2">
                <label class="text-bold">Provincia:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['nombre_provincia']; ?>" readonly>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Distrito:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['nombre_distrito']; ?>" readonly>
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="text-bold">Contacto 1:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['contacto1'] ?>" readonly>
                </div>
            </div>

            <div class="form-group col-md-3">
                <label class="text-bold">Correo:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['correo'] ?>" readonly>
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-3">
                <label class="control-label text-bold">Facebook:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['facebook'] ?>" readonly>
                </div>
            </div>
            
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Contacto 2:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['contacto2']; ?>" readonly>
                </div>
            </div>
            
            <div class="form-group col-md-2">
                <label class="text-bold">Intereses:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_producto_interes']; ?>" readonly>
                </div>
            </div>
            
            <div class="form-group col-md-4">
                <label class="text-bold">Comentario:</label>
                <div class="col">
                    <input type="text" class="form-control" value="<?php echo $get_id[0]['ultimo_comentario']; ?>" readonly>
                </div>
            </div>
        </div>

        <input type="hidden" id="id_publico" value="<?php echo $get_id[0]['id_publico']; ?>">

        <div class="col-lg-12" id="lista_historial">
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#titulacion").addClass('active');
        $("#htitulacion").attr('aria-expanded','true');
        $("#titu_publicos").addClass('active');
        document.getElementById("rtitulacion").style.display = "block";

        Lista_Historial_Publico();
    } );

    function Lista_Historial_Publico(){
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
            });/**/
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

        var id_publico = $('#id_publico').val();
        var url = "<?php echo site_url(); ?>AppIFV/Lista_Historial_Publico";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_publico':id_publico},
            success:function (data) {
                $('#lista_historial').html(data);
            }
        });
    }

    function Delete_Historial_Publico(id){
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
            });/**/
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

        var url="<?php echo site_url(); ?>AppIFV/Delete_Historial_Publico";

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
                    data: {'id_historial':id},
                    success:function (data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Historial_Publico();
                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>