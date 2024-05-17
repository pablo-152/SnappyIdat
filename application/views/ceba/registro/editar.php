<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('ceba/header'); ?>
<?php $this->load->view('ceba/nav'); ?>

<style>
  .div_padre{
    position: relative;
    padding-bottom: 86px;
    text-align: center;
  }

  .boton_principal_pendiente{
    position: absolute;
    background-color: #C00000;
    border-color: #C00000;
    color: white;
    top: 50%;
    margin-top: -18px;
  }

  .boton_principal_revisado{
    position: absolute;
    background-color: #009245;
    border-color: #009245;
    color: white;
    top: 50%;
    margin-top: -18px;
  }

  .boton_principal_pendiente:hover{
    color: white;
  }

  .boton_principal_revisado:hover{
    color: white;
  }

  .span_volador1{
    position: absolute;
    top: 70%;
  }

  .span_volador2{
    position: absolute;
    top: 90%;
  }
</style>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Registro</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <a type="button" href="<?= site_url('Ceba/Registro') ?>">
              <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="div_editar" class="container-fluid">
    <form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
      <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
          <div class="form-group col-md-2">
            <label class="control-label text-bold">Tipo:</label>
            <select class="form-control" id="tipo" name="tipo">
              <option value="0" <?php if($get_id[0]['tipo']==0){ echo "selected"; } ?>>Seleccione</option>
              <option value="1" <?php if($get_id[0]['tipo']==1){ echo "selected"; } ?>>Actas</option>
              <option value="2" <?php if($get_id[0]['tipo']==2){ echo "selected"; } ?>>Nominas</option>
            </select>
          </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Ref:</label>
          <select class="form-control" id="ref_mes" name="ref_mes">
            <?php foreach($list_mes as $list){ ?>
              <option value="<?php echo $list['cod_mes']; ?>" <?php if($list['cod_mes']==$get_id[0]['ref_mes']){ echo "selected"; } ?>><?php echo $list['nom_mes']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-2">
          <label style="color:transparent;">Ref</label>
          <select class="form-control" id="ref_anio" name="ref_anio">
            <?php foreach($list_anio as $list){ ?>
              <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==$get_id[0]['ref_anio']){ echo "selected"; } ?>><?php echo $list['nom_anio']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-2">
          <label class="control-label text-bold">Fecha Envio:</label>
          <input type="date" class="form-control" id="fecha_envio" name="fecha_envio" value="<?php echo $get_id[0]['fecha_envio']; ?>">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Nr. Alumnos:</label>
          <input type="text" class="form-control" id="n_alumnos" name="n_alumnos" placeholder="Nr. Alumnos" value="<?php echo $get_id[0]['n_alumnos']; ?>">
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-8">
          <label class="control-label text-bold">Observaciones:</label>
          <textarea rows="5" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" <?php if($get_id[0]['segundo_estado']!=3){ echo "disabled"; } ?>><?php echo $get_id[0]['observaciones']; ?></textarea>
          <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-6">
          <label class="control-label text-bold">Tablas Alumnos Arpay:</label>
          <?php if($get_id[0]['tabla_alumno_arpay']!=""){ ?>
            <a href="<?= site_url('Ceba/Descargar_Documento_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>/1">
                <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="30" height="20">
            </a>
          <?php } ?>
          <input type="file" id="tabla_alumno_arpay" name="tabla_alumno_arpay" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required>
        </div>

        <div class="form-group col-md-6">
          <label class="control-label text-bold">Registro (apuntes):</label>
          <?php if($get_id[0]['registro_apuntes']!=""){ ?>
            <a href="<?= site_url('Ceba/Descargar_Documento_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>/2">
                <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="30" height="20">
            </a>
          <?php } ?>
          <input type="file" id="registro_apuntes" name="registro_apuntes" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required>
        </div>

        <div class="form-group col-md-6">
          <label class="control-label text-bold">Documento Enviado:</label>
          <?php if($get_id[0]['documento_enviado']!=""){ ?>
            <a href="<?= site_url('Ceba/Descargar_Documento_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>/3">
                <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="30" height="20">
            </a>
          <?php } ?>
          <input type="file" id="documento_enviado" name="documento_enviado" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required onchange="Cambiar_Estado();"><!-- -->
        </div>

        <div class="form-group col-md-6">
          <label class="control-label text-bold">Documento Recibido:</label>
          <?php if($get_id[0]['documento_recibido']!=""){ ?>
            <a href="<?= site_url('Ceba/Descargar_Documento_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>/4">
                <img title="Descargar" src="<?= base_url() ?>template/img/icono-subir.png" style="cursor:pointer; cursor: hand;" width="30" height="20">
            </a>
          <?php } ?>
          <input type="file" id="documento_recibido" name="documento_recibido" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required onchange="Cambiar_Estado();">
        </div>
      </div>

      <div id="div_boton" class="col-md-6 div_padre">
        <?php if($get_id[0]['segundo_estado']==="3"){ ?>
          <?php if($get_id[0]['primer_estado']==0){ ?>
            <button type="button" class="btn boton_principal_pendiente"  <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?> onclick="Primer_Estado(1);" <?php } ?>>Pendiente</button>
          <?php }else{ ?>
            <button type="button" class="btn boton_principal_revisado" <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?> onclick="Primer_Estado(0);" <?php } ?>>Revisado </button>
            <span class="span_volador1"><?php echo $get_id[0]['f_rev']; ?></span>
            <span class="span_volador2"><?php echo $get_id[0]['u_rev']; ?></span>
          <?php } ?>
        <?php } ?>
      </div>

      <div class="col-md-12 row">
        <div id="div_estado" class="form-group col-md-2">
          <label class="control-label text-bold">Estado:</label>
         <select class="form-control" id="segundo_estado" name="segundo_estado" onchange="Permitir_Obs();">
            <option value="1" <?php if($get_id[0]['segundo_estado']==1){ echo "selected"; } ?>>Registrado</option>
            <option value="2" <?php if($get_id[0]['segundo_estado']==2){ echo "selected"; } ?>>Enviado</option>
            <option value="3" <?php if($get_id[0]['segundo_estado']==3){ echo "selected"; } ?>>Confirmado</option>
          </select>
        </div>
      </div>

      <div class="col-md-8 modal-footer">
        <input type="hidden" id="id_registro" name="id_registro" value="<?php echo $get_id[0]['id_registro']; ?>">
        <input type="hidden" id="primer_estado" name="primer_estado" value="<?php echo $get_id[0]['primer_estado']; ?>">
        <input type="hidden" name="tabla_alumno_arpay_actual" value="<?php echo $get_id[0]['tabla_alumno_arpay']; ?>">
        <input type="hidden" name="registro_apuntes_actual" value="<?php echo $get_id[0]['registro_apuntes']; ?>">
        <input type="hidden" name="documento_enviado_actual" value="<?php echo $get_id[0]['documento_enviado']; ?>">
        <input type="hidden" name="documento_recibido_actual" value="<?php echo $get_id[0]['documento_recibido']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Registro()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
        <a type="button" class="btn btn-default" href="<?= site_url('Ceba/Registro') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#registros").addClass('active');
  });

  $('#n_alumnos').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });
  
  function Cambiar_Estado() {
    $(document)
    .ajaxStart(function() {
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
    .ajaxStop(function() {
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
    
    var documento_enviado = $('#documento_enviado_actual').val();
    var documento_recibido = $('#documento_recibido_actual').val();

    if(documento_enviado=="" && documento_recibido==""){
      $('#segundo_estado').val(1);
      $('#div_boton').css('display','none');
    }else if(documento_enviado!="" && documento_recibido==""){
      $('#segundo_estado').val(2);
      $('#div_boton').css('display','none');
    }else{
      $('#segundo_estado').val(3);
      $('#div_boton').css('display','block');
    }

    Permitir_Obs();
  }

  function Permitir_Obs() {
    $(document)
    .ajaxStart(function() {
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
    .ajaxStop(function() {
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

    var segundo_estado = $('#segundo_estado').val();

    if(segundo_estado==3){
      $('#observaciones').attr('disabled',false);
      $('#div_boton').css('display','block');
    }else{
      $('#observaciones').attr('disabled',true);
      $('#div_boton').css('display','none');
    }
  }

  function Primer_Estado(id) {
    $(document)
    .ajaxStart(function() {
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
    .ajaxStop(function() {
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

    var url = "<?php echo site_url(); ?>Ceba/Cambiar_Estado";
    var id_registro = $('#id_registro').val();

    $.ajax({
      url: url,
      type: 'POST',
      data: {'id':id,'id_registro':id_registro},
      success: function(data) {
        $('#div_boton').html(data);
        $('#primer_estado').val(id);
        Cambiar_Estado();
      }
    });
  }

  function Update_Registro() {
    $(document)
    .ajaxStart(function() {
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
    .ajaxStop(function() {
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

    var dataString = new FormData(document.getElementById('formulario'));
    var url = "<?php echo site_url(); ?>Ceba/Update_Registro";

    if (Valida_Registro()) {
      $.ajax({
        url: url,
        data:dataString,
        type:"POST",
        processData: false,
        contentType: false,
        success: function(data) {
          swal.fire(
            'Actualización Exitosa!',
            'Haga clic en el botón!',
            'success'
          ).then(function() {
            window.location = "<?php echo site_url(); ?>Ceba/Registro";
          });
        }
      });
    }
  }

  function Valida_Registro() {
    if ($('#tipo').val().trim() === "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Tipo.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#fecha_envio').val().trim() === "") {
      Swal(
        'Ups!',
        'Debe seleccionar Fecha Envio.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#n_alumnos').val().trim() === "") {
      Swal(
        'Ups!',
        'Debe seleccionar Nr. Alumnos.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#segundo_estado').val().trim() === "2") {
        if ($('#documento_enviado_actual').val() == "") {
          Swal(
            'Ups!',
            'Debe subir un archivo en Documento Enviado.',
            'warning'
          ).then(function() {});
          return false;
        }
    }else if ($('#segundo_estado').val().trim() === "3") {
        if ($('#documento_recibido_actual').val() == "") {
          Swal(
            'Ups!',
            'Debe subir un archivo en Documento Recibido.',
            'warning'
          ).then(function() {});
          return false;
        }    
    }
    return true;
  }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('ceba/footer'); ?>