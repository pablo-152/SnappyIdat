<?php 
    $sesion =  $_SESSION['usuario'][0];
    defined('BASEPATH') OR exit('No direct script access allowed');
    $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .col-xs-12 {
        width: 12.5%;
    }

    .x_x_panel{
        display: flex;
        width: 165px;
        flex-direction: row;
        text-align: center;
        justify-content: space-between;
        position: absolute;
        color: #fff;
        top: 50%;
        right: 532px;
        margin-top: -40px;
    }

    .x_x_panel h3{ 
        margin: 0px 0px 0px 0px;
    }

    .x_x_panel h4{ 
        margin: 0px 0px 0px 0px;
        font-size: 15px;
    }

    .x_x_panel .lab{
        width: 80px;
        height: 80px;
        display: grid;
        align-content: center;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Público (Lista)</b></span></h4>
                </div>

                <?php if($_SESSION['usuario'][0]['id_nivel']!=15){ ?>
                    <div class="x_x_panel">
                        <div class="lab" style="background-color: #F8CBAD;">
                            <h4>STATUS</h4> 
                            <h3><?php echo $get_datos_publico[0]['status_sin_definir'];  ?></h3>
                            <h4>Sin Definir</h4>
                        </div>
                        <div class="lab" style="background-color: #F3E9CC;">
                            <h4>INTERESE</h4>
                            <h3><?php echo $get_datos_publico[0]['interese_sin_definir'];  ?></h3>
                            <h4>Sin Definir</h4>
                        </div>           
                    </div>
                <?php } ?>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('AppIFV/Registrar_Publico') ?>" title="Nuevo">
                            <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>

                        <?php if($_SESSION['usuario'][0]['id_nivel']==15){ ?>
                            <a href="<?= site_url('AppIFV/Excel_Publico') ?>/2/0" style="margin-left:5px;">
                                <img src="<?= base_url() ?>template/img/excel.png">
                            </a>
                        <?php }else{ ?>
                            <a style="cursor:pointer;margin-left:5px;" data-toggle="modal" data-target="#acceso_modal" 
                            app_crear_per="<?= site_url('AppIFV/Modal_Registro_Mail_Mailing') ?>">
                                <img src="<?= base_url() ?>template/img/mailing.png">
                            </a>

                            <a style="cursor:pointer;margin-right:5px;margin-left:5px;" title="Duplicar" onclick="Duplicar();">
                                <img src="<?= base_url() ?>template/img/copy.png">
                            </a>

                            <a onclick="Excel_Publico();">
                                <img src="<?= base_url() ?>template/img/excel.png">
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div id="lista_publico" class="container-fluid">
        <input type="hidden" id="anio_busqueda" value="<?php echo date('Y'); ?>">
        <input type="hidden" id="tipo_excel">
    </div>
</div>

<script>
    $(document).ready(function() { 
        $("#titulacion").addClass('active');
        $("#htitulacion").attr('aria-expanded','true');
        $("#titu_publicos").addClass('active');
        document.getElementById("rtitulacion").style.display = "block";

        <?php if($_SESSION['usuario'][0]['id_nivel']!=15){ ?>
            Lista_Publico(0);
        <?php }else{ ?> 
            Lista_Publico(2);
        <?php } ?>
    });

    function Lista_Publico(parametro){
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

        if(parametro==2){
            var url = "<?php echo site_url(); ?>AppIFV/Lista_Publico";

            $.ajax({
                type:"POST",
                url:url,
                data: {'parametro':parametro},
                success:function (data) {
                    $('#lista_publico').html(data);
                }
            });
        }else{
            if(parametro==3){
                var parametro = $('#tipo_excel').val();
            }
            var anio = $('#anio_busqueda').val();
            var url = "<?php echo site_url(); ?>AppIFV/Lista_Publico";

            $.ajax({
                type:"POST",
                url:url,
                data: {'parametro':parametro,'anio':anio},
                success:function (data) {
                    $('#lista_publico').html(data);
                    $("#tipo_excel").val(parametro);

                    var activos = document.getElementById('activos');
                    var todos = document.getElementById('todos');
                    if(parametro==0){
                        todos.style.color = '#000000';
                        activos.style.color = '#ffffff';
                    }else if(parametro==1){
                        todos.style.color = '#ffffff';
                        activos.style.color = '#000000'; 
                    }
                }
            });
        }
    }

    function Duplicar(){
        if($('#cantidad').val() == 0) {
            Swal(
                'Ups!',
                'Debe seleccionar un registro.',
                'warning'
            ).then(function() { });
            return false;
        }else if($('#cantidad').val() > 1){
            Swal(
                'Ups!',
                'Debe seleccionar solo un registro.',
                'warning'
            ).then(function() { });
            return false;
        }else{
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

            var tipo_excel = $('#tipo_excel').val();
            var dataString = $("#formulario_duplicado").serialize();
            var url = "<?php echo site_url(); ?>AppIFV/Duplicar_Registro";

            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Duplicado Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Publico(tipo_excel);
                    });
                }
            }); 
        }
    }

    function Importar_Comercial() {
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

        var tipo_excel = $('#tipo_excel').val();
        var dataString = new FormData(document.getElementById('formulario_excel'));
        var url="<?php echo site_url(); ?>AppIFV/Validar_Importar_Publico";
        var url2="<?php echo site_url(); ?>AppIFV/Importar_Publico";

        if (Valida_Importar_Excel()){ 
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data!=""){
                        swal.fire(
                            'Errores Encontrados!',
                            data.split("*")[0],
                            'error'
                        ).then(function() {
                            if(data.split("*")[1]=="INCORRECTO"){
                                Lista_Publico(tipo_excel);
                            }else{
                                Swal({
                                    title: '¿Desea registrar de todos modos?',
                                    text: "El archivo contiene errores y no se cargara esa(s) fila(s)",
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
                                            data: dataString,
                                            processData: false,
                                            contentType: false,
                                            success:function () {
                                                swal.fire(
                                                    'Carga Exitosa!',
                                                    'Haga clic en el botón!',
                                                    'success'
                                                ).then(function() {
                                                    Lista_Publico(tipo_excel);
                                                });
                                            }
                                        });
                                    }
                                })
                            }
                        });
                    }else{
                        swal.fire(
                            'Carga Exitosa!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Publico(tipo_excel);
                        });
                    }
                }
            });
        }
    }

    function Valida_Importar_Excel() {
        if($('#archivo_excel').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar archivo Excel.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Excel_Publico(){
        var tipo_excel = $("#tipo_excel").val();
        var anio = $('#anio_busqueda').val();
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Publico/"+tipo_excel+"/"+anio;
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>