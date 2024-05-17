<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>

<?php $this->load->view('Admin/nav'); ?>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>

<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script><script type="text/javascript" src="<?= base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>
<!--<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>

<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<div class="panel panel-flat">
    
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cargo (Nuevo)</b></span></h4>
                </div>

            </div>
        </div>
    </div>

    <form id="formulario_cargo" method="POST" enctype="multipart/form-data"  class="horizontal">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12" id="cambio">
                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Dni:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input id="otro_1" name="otro_1" type="text" maxlength="8" class="form-control"  placeholder="Ingresar DNI" onkeypress="ValidaSoloNumeros()">
                  </div>
                  <div class="form-group col-md-3">
                    <button type="button" class="btn btn-primary" onclick="Insert_Cargo()" data-loading-text="Loading..." autocomplete="off">
                        <i class="glyphicon glyphicon-ok-sign"></i> Validar
                    </button>
                  </div>
                  <div class="form-group col-md-12">
                    <label class="control-label text-bold label_tabla">Tu Invitado:</label>
                  </div>
                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Dni:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input id="dni_re" name="dni_re" type="text" maxlength="8" class="form-control"  placeholder="Ingresar DNI" onkeypress="ValidaSoloNumeros()">
                  </div>
                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Celular:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input id="celu_re" name="celu_re" type="text" maxlength="9" class="form-control"  placeholder="Ingresar Celular" onkeypress="ValidaSoloNumeros()">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Correo Electronico:</label>
                  </div>
                  <div class="form-group col-md-4">
                    <input id="corre_re" name="corre_re" type="text" maxlength="50" class="form-control"  placeholder="Ingresar Correo Electronico">
                  </div>
                </div>
                
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="button" disabled onclick="Insert_Cargo1()" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" onclick="Cancelar()">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
    </form>
</div>
<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

<script>
    $('#celular_1').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#celular_2').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });
    $(document).ready(function() {
        $("#cargo").addClass('active');
        $("#hcargo").attr('aria-expanded', 'true');
        $("#slista").addClass('active');
        /*$("#hlista").attr('aria-expanded', 'true');
        $("#nuevocargo").addClass('active');
        document.getElementById("rlista").style.display = "block";*/
        document.getElementById("rcargo").style.display = "block";
    });

    function Agregar_Documento() {
        $(document).ajaxStart(function () {
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

        var dataString = new FormData(document.getElementById('formulario_archi_reg'));
        var url="<?php echo site_url(); ?>Snappy/Preguardar_Documento_Cargo";
        if (Valida_Documento()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Existe un documento con el mismo nombre!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }
                    else if(data=="1"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Solo se puede adjuntar 5 documentos por cargo!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        var url2="<?php echo site_url(); ?>Snappy/List_Preguardado_Documento_Cargo";
                        var dataString2 = new FormData(document.getElementById('formulario_cargo'));
                        
                        $.ajax({
                            type:"POST",
                            url: url2,
                            data:dataString2,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                            $('#div_temporal').html(data);
                            //$("#ModalUpdate .close").click()
                            document.getElementById("nom_documento").value = "";
                            document.getElementById("documento").value = "";
                            $("#modal_form_vertical .close").click()
                        }
                        });
                    }
                }
            });
        }
    }

    function Valida_Documento(){
      if($('#otro_1').val().trim() === '') {
          Swal(
              'Ups!',
              'Debe ingresar Dni.',
              'warning'
          ).then(function() { });
          return false;
      }
      
      return true;
    }
</script>

<script>
  function Insert_Cargo(){
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
    var dataString = new FormData(document.getElementById('formulario_cargo'));
    var url="<?php echo site_url(); ?>AppIFV/Validar";
        if (valida_registros_cargo()) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data:dataString,
                    processData: false,
                    contentType: false,
                    success:function (data) {
                        if(data=="no-existe"){
                            document.getElementById("button").disabled = true;
                            Swal(
                                'Registro Denegado!',
                                'Existe una empresa con el mismo RUC',
                                'error'
                            ).then(function() {
                            });
                        }else if (data=="existe"){
                            document.getElementById("button").disabled = false;
                            
                            Swal(
                                'Seguir!',
                                '',
                                'success'
                            ).then(function() {
                            });
                        }
                    }
                });
            }else{
                bootbox.alert(msgDate)
                var input = $(inputFocus).parent();
                $(input).addClass("has-error");
                $(input).on("change", function () {
                    if ($(input).hasClass("has-error")) {
                        $(input).removeClass("has-error");
                    }
                });
            }
    }
                  
  function Cancelar(){
    window.location = "<?php echo site_url('Snappy/Cargo')?>";
  }

  function valida_registros_cargo() {
    if($('#otro_1').val() == '') {
        Swal(
            'Ups!',
            'Debe ingregar Dni.',
            'warning'
        ).then(function() { });
        return false;
    }
    if($('#otro_1').val().length!=8) {
          Swal(
              'Ups!',
              'El número de Dni debe contener 8 dígitos.',
              'warning'
          ).then(function() { });

          return false;
      }

    return true;
  }
  function ValidaSoloNumeros() {
 if ((event.keyCode < 48) || (event.keyCode > 57)) 
  event.returnValue = false;
}
</script>

<script>
  function Insert_Cargo1(){
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
    //let button = document.querySelector(".button");
    var dataString = new FormData(document.getElementById('formulario_cargo'));
    var url="<?php echo site_url(); ?>AppIFV/enviar_mensaje";
        if (valida_registros_cargo1()) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data:dataString,
                    processData: false,
                    contentType: false,
                    success:function (data) {
                        if(data=="no-existe"){
                            Swal(
                                'Registro Denegado!',
                                'Existe una empresa con el mismo RUC',
                                'error'
                            ).then(function() {
                            });
                        }else if (data=="existe"){
                            document.getElementById("button").disabled = false;
                            $('#button').removeAttr('disabled');
                            $('#button').prop('disabled', false);
                            Swal(
                                'Seguir!',
                                '',
                                'success'
                            ).then(function() {
                            });

                        }
                    }
                });
            }else{
                bootbox.alert(msgDate)
                var input = $(inputFocus).parent();
                $(input).addClass("has-error");
                $(input).on("change", function () {
                    if ($(input).hasClass("has-error")) {
                        $(input).removeClass("has-error");
                    }
                });
            }
    }
                  
  function Cancelar(){
    window.location = "<?php echo site_url('Snappy/Cargo')?>";
  }

  function valida_registros_cargo1() {
    if($('#dni_re').val() == '') {
        Swal(
            'Ups!',
            'Debe ingregar Dni re.',
            'warning'
        ).then(function() { });
        return false;
    }
    if($('#celu_re').val() == '') {
        Swal(
            'Ups!',
            'Debe ingregar celu re.',
            'warning'
        ).then(function() { });
        return false;
    }
    if($('#corre_re').val() == '') {
        Swal(
            'Ups!',
            'Debe ingregar correo re.',
            'warning'
        ).then(function() { });
        return false;
    }

    return true;
  }
</script>

<?php $this->load->view('Admin/footer'); ?>