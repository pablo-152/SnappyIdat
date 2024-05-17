<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>

<?php $this->load->view('Admin/header'); ?>
<link href="<?=base_url() ?>template/docs/css/fullcalendar.css" rel="stylesheet" />
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <div class="col-md-10">
                        <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Redes (Agenda)</b></span></h4>
                    </div>                
                    
                    <div class="col-md-2">
                        <select style="margin:-15px" class="form-control" name="val_empresa" id="val_empresa" onchange="Empresa()">
                            <?php if($id_nivel==7){ ?>
                                <option value="5">EP</option>
                            <?php }else{ ?>
                                <option value="0">Todo</option>
                                <?php foreach($combo_empresa as $list){ ?>
                                    <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                                <?php } ?>
                            <?php }?>
                        </select>
                        <select style="margin: -36px 0 0 -115%" class="form-control" name="val_redes" id="val_redes" onchange="Empresa()">
                            <?php if($id_nivel != ""){ ?>
                                <option value="0">Todo</option>
                                <option value="15">Facebook</option>
                                <option value="20">Instagram</option>
                                <option value="22">Mailing</option>
                            <?php }else{ ?>
                                <option value="0">Todo</option>
                                <?php foreach($combo_empresa as $list){ ?>
                                    <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                                <?php } ?>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form method="post" id="formulario_excel" enctype="multipart/form-data" class="formulario" >
            <div class="heading-btn-group">
                <?php if($sesion['id_usuario']==1 || $sesion['id_usuario']==5 || $sesion['id_usuario']==7 || $sesion['id_usuario']==35 || $sesion['id_usuario']==71){ ?>
                    <a class="form-group btn">
                        <input name="archivo_excel" id="archivo_excel" type="file" data-allowed-file-extensions='["xls|xlsx"]'>
                    </a>
                
                    <a class="form-group btn" href="<?= site_url('Snappy/Excel_Vacio_Redes') ?>" target="_blank" title="Estructura de Excel">
                        <img height="36px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel">
                    </a>
                
                    <a class="form-group btn">
                        <button class="btn btn-primary" type="button" onclick="Importar_Redes();">Importar</button>
                    </a>
                <?php } ?>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-12">
                <div id="calendar" class="col-centered">
                </div>
            </div>

            <!-- Modal Nuevo-->
            <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <form class="form-horizontal" method="POST" action="addEvent.php">
                    
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Agregar Evento</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Titulo</label>
                            <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="color" class="col-sm-2 control-label">Color</label>
                            <div class="col-sm-10">
                            <select name="color" class="form-control" id="color">
                                            <option value="">Seleccionar</option>
                                <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
                                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                <option style="color:#008000;" value="#008000">&#9724; Verde</option>                         
                                <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
                                <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
                                <option style="color:#000;" value="#000">&#9724; Negro</option>
                                
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
                            <div class="col-sm-10">
                            <input type="text" name="start" class="form-control" id="start" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end" class="col-sm-2 control-label">Fecha Final</label>
                            <div class="col-sm-10">
                            <input type="text" name="end" class="form-control" id="end" readonly>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            
            <!-- Modal Edición-->
            <div id="ModalEdit" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="form-horizontal" id="from_redes" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Update_Redes')?>"  class="formulario">
                            <div class="modal-header">
                                <!--<h5 class="modal-title" id="exampleModalLabel">Datos Arte</h5>-->
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body" style="max-height:500px; overflow:auto;">
                                <div class="col-md-12 row">
                                    <div class="col-md-5">
                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="codproyecto">Código: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="codproyecto" name="codproyecto"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="tipo">Tipo: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="tipo" name="tipo"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="subtipo">Sub-Tipo: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="subtipo" name="subtipo"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="descripcion">Descripción: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="descripcion" name="descripcion"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="usuario_codigo">Usuario: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="usuario_codigo" name="usuario_codigo"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="nom_statusp">Estatus: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="nom_statusp" name="nom_statusp"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold">Subido: </label>
                                            </div>
                                            <?php if($id_nivel==7){ ?>
                                                <div class="form-group col-md-2">
                                                    <input type="checkbox" disabled />
                                                </div>
                                            <?php }else{ ?>
                                                <div class="form-group col-md-2">
                                                    <input type="checkbox" id="subido" name="subido" value="1" />
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="nom_statusp">Copy: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="copy" name="copy"></div>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="inicio" id="inicio">
                                        <input type="hidden" name="snappy_redes" id="snappy_redes">
                                    </div>  

                                    <div class="col-md-7">
                                        <div id="imagen" name="imagen"></div>
                                    </div>	 
                                </div>          	                	        
                            </div> 

                            <div class="modal-footer">
                                <input type="hidden" id="cod_proyecto" name="cod_proyecto"/>
                                <input type="hidden" id="imagen_proyecto" name="imagen_proyecto"/>
                                <input type="hidden" id="id_proyecto" name="id_proyecto"/>
                                <div class="col-md-6">
                                    <a class="btn col-md-4" style="background-color:#0070c0;color:#FFFFFF" onclick="Ir_Proyecto();">
                                        Ver tkt
                                    </a>

                                    <a class="btn col-md-4" style="background-color:#c00000;color:#FFFFFF" onclick="Descargar_Imagen();">
                                        Descargar
                                    </a>
                                </div>

                                <div class="col-md-6">
                                    <?php if($id_nivel!=7 && $_SESSION['usuario'][0]['id_usuario']!=69 && $_SESSION['usuario'][0]['id_usuario']!=72){ ?>
                                        <div class="col-md-8">
                                        </div>
                                        <button type="button" class="btn col-md-4" id="btn_redes" style="background:#6b586e;color:#FFF;" data-loading-text="Loading..." autocomplete="off">
                                            Guardar
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Duplicado-->
            <!--<div id="ModalEdit2" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form class="form-horizontal" id="from_redes2" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Update_Redes')?>"  class="formulario">
                            <div class="modal-header">
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body" style="max-height:450px; overflow:auto;">
                                <div class="col-md-12 row">
                                    <div class="col-md-5">
                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="codproyecto">Código: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="codproyecto" name="codproyecto"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="tipo">Tipo: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="tipo" name="tipo"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="subtipo">Sub-Tipo: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="subtipo" name="subtipo"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="descripcion">Descripción: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="descripcion" name="descripcion"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="usuario_codigo">Usuario: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="usuario_codigo" name="usuario_codigo"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold" for="nom_statusp">Estatus: </label>
                                            </div>
                                            <div class="form-group col-md-7">
                                                <div id="nom_statusp" name="nom_statusp"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-5">
                                                <label class="text-bold">Subido: </label>
                                            </div>
                                            <?php if($id_nivel==7){ ?>
                                                <div class="form-group col-md-2">
                                                    <input type="checkbox" disabled />
                                                </div>
                                            <?php }else{ ?>
                                                <div class="form-group col-md-2">
                                                    <input type="checkbox" id="subido" name="subido" value="1" />
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <input type="checkbox" id="subido2" name="subido2" value="" />
                                        <input type="hidden" name="inicio" id="inicio">
                                        <input type="hidden" name="snappy_redes" id="snappy_redes">
                                    </div>  

                                    <div class="col-md-7">
                                        <div id="imagen" name="imagen"></div>
                                    </div>	 
                                </div>          	                	        
                            </div> 

                            <div class="modal-footer">
                                <a class="btn col-md-3" style="background-color:#9B9B9B;color:#FFFFFF" onclick="Ir_Proyecto2();">
                                    Ver tkt
                                </a>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <div class="col-md-4"></div>

                                <input type="hidden" id="codproyecto2" name="codproyecto2"/>
                                <input type="hidden" id="id_proyecto2" name="id_proyecto2"/>
                                <?php if($id_nivel!=7){?>
                                    <button type="button" class="btn col-md-4 btn-vino" id="btn_redes2" data-loading-text="Loading..." autocomplete="off">
                                        Guardar
                                    </button>
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded', 'true');
        $("#sredes").addClass('active');
        $("#hsredes").attr('aria-expanded', 'true');
        $("#agenda_redes").addClass('active');
		document.getElementById("rredes").style.display = "block";
        document.getElementById("rcomunicacion").style.display = "block";
        Empresa();
    });

    function Importar_Redes() { 
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

        var dataString = new FormData(document.getElementById('formulario_excel'));
        var url="<?php echo site_url(); ?>Snappy/Validar_Importar_Redes";
        var url2="<?php echo site_url(); ?>Snappy/Importar_Redes";

        if (Valida_Importar_Redes()){
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
                                window.location = "<?php echo site_url(); ?>Snappy/Redes";
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
                                                    window.location = "<?php echo site_url(); ?>Snappy/Redes";
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
                            window.location = "<?php echo site_url(); ?>Snappy/Redes";
                        });
                    }
                }
            });
        }
  }

    function Valida_Importar_Redes() {
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
</script>

<?php $this->load->view('Admin/footer'); ?>

<script src="<?= base_url() ?>template/docs/js/moment.min.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/fullcalendar.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/locale/es.js"></script>

<script>
    function Ir_Proyecto(){
        var id_proyecto = $('#id_proyecto').val();
        window.open("<?php echo site_url(); ?>Administrador/Detalle_Proyecto/"+id_proyecto,"_blank");
    }

    function Descargar_Imagen(){
        var id_proyecto = $('#id_proyecto').val();
        window.location ="<?php echo site_url(); ?>Snappy/Descargar_Imagen/"+id_proyecto;
    }

    $("#btn_redes").on('click', function(e){
        // if (img()) {
            bootbox.confirm({
                title: "Actualizar",
                message: "¿Desea cambiar estado?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        //$('#from_redes').submit();
                        var dataString2 = new FormData(document.getElementById('from_redes'));
                        var url2="<?php echo site_url(); ?>Snappy/Update_Redes";
                        $.ajax({
                            type:"POST",
                            url: url2,
                            data:dataString2,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                            //$('#div_direccion').html(data);
                            $("#ModalEdit .close").click();
                            var val_empresa3 = $('#val_empresa').val();
                            if(val_empresa3==0){
                                window.location = "<?php echo site_url(); ?>Snappy/Redes";
                            }else{
                                var url3="<?php echo site_url(); ?>Snappy/Agenda_Empresa";
                                $.ajax({
                                    type:"POST",
                                    url:url3,
                                    data: {'val_empresa':val_empresa3},
                                    success:function (data) {
                                        $('#calendar').html(data);
                                    }
                                });
                            }
                        }
                        });
                    }
                } 
            });
    });

    /*$(document).ready(function() {
        var id_nivel = <?php echo $id_nivel; ?>;
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
        var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
        
        
        $('#calendar').fullCalendar({
            header: {
                language: 'es',
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay',

            },
            defaultDate: yyyy+"-"+mm+"-"+dd,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: false,
            selectHelper: true,
            select: function(start, end) {
                
                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function(event, element) {
                element.bind('dblclick', function() {
                    if(event.codproyecto!="0")
                    {
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #tipo').html(event.tipo);
                        $('#ModalEdit #subtipo').html(event.subtipo);
                        $('#ModalEdit #descripcion').html(event.descripcion);
                        $('#ModalEdit #usuario_codigo').html(event.usuario_codigo);
                        $('#ModalEdit #nom_statusp').html(event.nom_statusp);
                        $('#ModalEdit #codproyecto').html(event.codproyecto);  
                        $('#ModalEdit #cod_proyecto').val(event.codproyecto);  
                        $('#ModalEdit #imagen').html(event.imagen);
                        $('#ModalEdit #inicio').val(event.inicio);
                        $('#ModalEdit #snappy_redes').val(event.snappy_redes);
                        $('#ModalEdit #id_proyecto').val(event.id_proyecto);
                        $('#ModalEdit #copy').html(event.copy);
                        //$('#ModalEdit #subido1').val(event.subido);
                        
                        if (id_nivel==1)
                        {
                            if (event.subido=="1")
                            {
                                //$('#ModalEdit #subido').attr("checked", true);
                                $("#subido").prop("checked", true);
                            }
                            else
                            {
                                //$('#ModalEdit #subido').attr("checked", false);
                                $("#subido").prop("checked", false);
                            }
                        }
                        else{
                            if (event.subido=="1")
                            {
                                //$('#ModalEdit #subido').attr("checked", true);
                                $("#subido").prop("checked", true);
                                //$('#ModalEdit #subido').attr("disabled", true);
                                $("#subido").prop("disabled", false);
                                $('#ModalEdit #btn_redes').attr("disabled", true);
                            }
                            else
                            {
                                //$('#ModalEdit #subido').attr("checked", false);
                                //$('#ModalEdit #subido').attr("disabled", false);
                                $("#subido").prop("checked", false);
                                $("#subido").prop("disabled", false);
                                $('#ModalEdit #btn_redes').attr("disabled", false);
                            }
                        }
                        //$('#ModalEdit #subido').val(event.subido); 
                        $('#ModalEdit').modal('show');
                    }
                    else{}
                });
            },
            eventDrop: function(event, delta, revertFunc) { // si changement de position

                edit(event);

            },
            eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

                edit(event);

            },
            events: [
                <?php $i=0; foreach($list_redes as $list) {

                    $base_url=base_url();

                    $empresas="";
                    $cont="";
                    /*foreach($list_empresa_proyecto as $empresa){
                        if($empresa['id_proyecto']==$list['id_proyecto']){
                            $empresas=$empresas.$empresa['cod_empresa'].",";

                            
                            foreach($list_duplicado as $dup){
                                if($dup['cod_proyecto']==$list['cod_proyecto']){
                                    $cont=$cont."*";
                                }
                            }
                        }
                    }*/
                    if($list['duplicado']=="1"){
                        $cont=$cont."*";
                    }
                    
                    if($list['cod_empresa']==""){
                        $empresa_codigos="";
                    }else{
                        $empresa_codigos="(".$list['cod_empresa'].") ";
                    }
                    
                    $start = explode(" ", $list['inicio']);
                    $end = explode(" ", $list['fin']);
                    if($start[1] == '00:00:00'){
                        $start = $start[0];
                    }else{
                        $start = $list['inicio'];
                    }
                    if($end[1] == '00:00:00'){
                        $end = $end[0];
                    }else{
                        $end = $list['fin'];
                    }

                    
                    $descargar=site_url('Snappy/Descargar_Imagen');

                ?>
                
                    {
                        id: '<?php echo $list['id_calendar_redes']; ?>',
                        title: '<?php if ($list['cod_proyecto']!=""){ echo $empresa_codigos.$list['cod_proyecto'].$cont.' - '.$list['descripcion']; }else{ echo $empresa_codigos.$list['descripcion']; } ?>',
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        descripcion: '<?php echo $list['descripcion']; ?>',
                        codproyecto: '<?php echo $list['cod_proyecto']; ?>',
                        usuario_codigo: '<?php echo $list['usuario_codigo']; ?>',
                        subido: '<?php echo $list['subido']; ?>',
                        nom_statusp: '<?php echo $list['nom_statusp']; ?>',
                        tipo: '<?php echo $list['nom_tipo']; ?>',
                        subtipo: '<?php echo $list['nom_subtipo']; ?>',
                        //color: '<?php if ($list['cod_proyecto']!=""){ if($list['subido']==1){echo "#9ddafa";} elseif ($list['status']==5 || $list['status']==6 || $list['status']==7) { echo "#BDE5E7"; } else { echo "#FCE9DA";} } else{ echo $list['color']; } ?>',
                        color: '<?php if ($list['cod_proyecto']!="" || ($list['id_secundario']!=0 && $list['tipo_calendar']=="Proyecto")){ if($list['subido']==1 || $list['status']==5){ echo "#b7afb8"; }elseif($list['status']==6 || $list['status']==7) { echo "#BDE5E7"; }else{ echo "#FCE9DA";} } else{ echo $list['color']; } ?>',
                        imagen: '<?php if($list['imagen']!=""){ echo '<a title="Descargar Imagen" href="'.$descargar.'/'.$list['id_proyecto'].'"><img src="'.$base_url.''.$list['imagen'].'" height=380px width=450px></a>'; }else{ echo ''; } ?>',
                        inicio: '<?php echo $list['inicio']; ?>',
                        snappy_redes: '<?php echo $list['snappy_redes']; ?>',
                        id_proyecto: '<?php echo $list['id_proyecto']; ?>',
                        copy: '<?php echo $list['copy']; ?>',
                    },
                <?php } ?>
            ]
        });
        
        function edit(event){
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if(event.end){
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            }else{
                end = start;
            }
            
            id =  event.id;
            codproyecto =  event.codproyecto;
            
            Event = [];
            Event[0] = id;
            Event[1] = start;
            Event[2] = end;
            Event[3] = codproyecto;
            var url = "<?php echo site_url(); ?>" + "/Snappy/Edit_Calendar_Redes";
            //frm = {sistema: sistema, depen:depen };
            
            $.ajax({
                url: url,
                type: "POST",
                data: {Event:Event},
                success: function(rep) {
                    /*if(rep == 'OK'){
                        alert('Evento se ha guardado correctamente');
                    /*}else{
                        alert('No se pudo guardar. Inténtalo de nuevo.'); 
                    }
                }
            });
        }
        
    });*/

    function Empresa(){
        Cargando();

        var val_empresa = $('#val_empresa').val();
        var val_redes = $('#val_redes').val();
        var url="<?php echo site_url(); ?>Snappy/Agenda_Empresa";
        $.ajax({
            type:"POST",
            url:url,
            data: {'val_empresa':val_empresa,'val_redes':val_redes},
            success:function (data) {
                $('#calendar').html(data);
            }
        });
    }

</script>
