<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

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
</style>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Registro (Nuevo)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <a type="button" href="<?= site_url('AppIFV/Registro') ?>">
              <img src="<?= base_url() ?>template/img/icono-regresar.png">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container-fluid">
    <form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
      <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
          <div class="form-group col-md-2">
            <label class="control-label text-bold">Tipo:</label>
            <select class="form-control" id="tipo" name="tipo">
              <option value="0">Seleccione</option>
              <option value="1">Actas</option>
              <option value="2">Nominas</option>
              <option value="3">Titulación</option>
            </select>
          </div>
        
          <div class="form-group col-md-2">
            <label class="control-label text-bold">Ref:</label>
            <select class="form-control" id="ref_mes" name="ref_mes">
              <?php foreach($list_mes as $list){ ?>
                <option value="<?php echo $list['cod_mes']; ?>" <?php if($list['cod_mes']==date('m')){ echo "selected"; } ?>><?php echo $list['nom_mes']; ?></option>
              <?php } ?>
            </select>
          </div>
          

        <div class="form-group col-md-2">
          <label style="color:transparent;">Ref</label>
          <select class="form-control" id="ref_anio" name="ref_anio">
            <?php foreach($list_anio as $list){ ?>
              <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['nom_anio']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-2">
        <label style="color:transparent;">Ref</label>
          <select class="form-control" id="ref_lugar" name="ref_lugar">
            <option value="1">Chincha</option>
            <option value="2" selected>Lima</option>
          </select>
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-4">
          <label class="control-label text-bold">Especialidad:</label>
          <select class="form-control" id="id_especialidad" name="id_especialidad">
            <option value="0">Seleccione</option>
            <?php foreach($list_especialidad as $list){ ?>
              <option value="<?php echo $list['id_especialidad']; ?>"><?php echo $list['nom_especialidad']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-2">
          <label class="control-label text-bold">Grupo:</label>
          <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo">
        </div>
        
        <div class="form-group col-md-2">
          <label class="control-label text-bold">Fecha Envio:</label>
          <input type="date" class="form-control" id="fecha_envio" name="fecha_envio">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Nr. Alumnos:</label>
          <input type="text" class="form-control" id="n_alumnos" name="n_alumnos" placeholder="Nr. Alumnos">
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-8">
          <label class="control-label text-bold">Producto:</label>
          <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto">
        </div>
      </div>

     <div class="col-md-12 row">
        <div class="form-group col-md-8">
          <label class="control-label text-bold">Observaciones:</label>
          <textarea rows="5" class="form-control" id="observaciones" name="observaciones" placeholder="Observaciones" disabled></textarea>
          <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
        </div>
      </div>

      <div class="col-md-8 row">
        <div class="form-group col-md-6">
          <label class="control-label text-bold">Tablas Alumnos Arpay:</label>
          <input type="file" id="tabla_alumno_arpay" name="tabla_alumno_arpay" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required>
        </div>

        <div class="form-group col-md-6">
          <label class="control-label text-bold">Registro (apuntes):</label>
          <input type="file" id="registro_apuntes" name="registro_apuntes" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required>
        </div>

        <div class="form-group col-md-6">
          <label class="control-label text-bold">Documento Enviado:</label>
          <input type="file" id="documento_enviado" name="documento_enviado" onchange="Cambiar_Estado();" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required>
        </div>

        <div class="form-group col-md-6">
          <label class="control-label text-bold">Documento Recibido:</label>
          <input type="file" id="documento_recibido" name="documento_recibido" onchange="Cambiar_Estado();" data-allowed-file-extensions='["xls|xlsx|pdf|jpg|png|jpeg"]' size="100" required>
        </div>
      </div>

      <div class="col-md-12 row">
        <div id="div_estado" class="form-group col-md-2">
          <label class="control-label text-bold">Estado:</label>
          <select class="form-control" id="segundo_estado" name="segundo_estado" onchange="Permitir_Obs();">
            <option value="1" selected>Registrado</option>
            <option value="2">Enviado</option>
            <option value="3">Confirmado</option>
          </select>
        </div>
      </div>
      <?php if($id_nivel==1){?>
        <div id="div_boton" class="col-md-6 div_padre" style="display: none;">
          <button type="button" class="btn boton_principal_pendiente" <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?> onclick="Primer_Estado(1);" <?php } ?>>Pendiente</button>
        </div>
      <?php }?>
      <div class="col-md-8 modal-footer">
        <input type="hidden" id="primer_estado" name="primer_estado">
        <button type="button" class="btn btn-primary" onclick="Insert_Registro()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
        <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Registro') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#registros").addClass('active');
  });
</script>

<?php $this->load->view('view_IFV/footer'); ?>

<script>
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
    
    var documento_enviado = $('#documento_enviado').val();
    var documento_recibido = $('#documento_recibido').val();

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

    var url = "<?php echo site_url(); ?>AppIFV/Cambiar_Estado";

    $.ajax({
      url: url,
      type: 'POST',
      data: {'id':id},
      success: function(data) {
        $('#div_boton').html(data);
        $('#primer_estado').val(id);
        Cambiar_Estado();
      }
    });
  }

  function Insert_Registro() {
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
    var url = "<?php echo site_url(); ?>AppIFV/Insert_Registro";

    if (Valida_Registro()) {
      $.ajax({
        url: url,
        data:dataString,
        type:"POST",
        processData: false,
        contentType: false,
        success: function(data) {
          swal.fire(
            'Registro Exitoso!',
            'Haga clic en el botón!',
            'success'
          ).then(function() {
            window.location = "<?php echo site_url(); ?>AppIFV/Registro";
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
    if ($('#id_especialidad').val().trim() === "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Especialidad.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#grupo').val().trim() === "") {
      Swal(
        'Ups!',
        'Debe ingresar un Grupo.',
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
    if ($('#producto').val().trim() === "") {
      Swal(
        'Ups!',
        'Debe seleccionar Producto.',
        'warning'
      ).then(function() {});
      return false;
    }

    if ($('#segundo_estado').val().trim() === "2") {
        if ($('#documento_enviado').val().trim() == "") {
        Swal(
          'Ups!',
          'Debe subir un archivo en Documento Enviado.',
          'warning'
        ).then(function() {});
        return false;
      }
    }else if ($('#segundo_estado').val().trim() === "3") {
        if ($('#documento_recibido').val().trim() == "") {
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