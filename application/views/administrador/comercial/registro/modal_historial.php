<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<form id="formulario_insert"  method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title"><b>Nueva Acción</b></h5>
  </div>

  <div class="modal-body" style="max-height:600px; overflow:auto;">
    <div class="col-md-12 row">
      <div class="form-group col-md-4">
        <label class="text-bold">Fecha</label>
        <div class="col">
          <input type="date" class="form-control" id="fecha_accion_i" name="fecha_accion_i" value="<?php echo date('Y-m-d'); ?>" onkeypress="if(event.keyCode == 13){ Insert_Historial(); }">
        </div>
      </div>

      <?php if($get_id[0]['id_informe']==14){ ?> 
        <div class="form-group col-md-8">
          <label class="text-bold">Comentario</label>
          <div class="col">
              <input type="text" class="form-control" id="comentario1_i" name="comentario1_i" value="<?php echo $get_id[0]['ultimo_comentario']; ?>" placeholder="Comentario" maxlength="35" readonly>
          </div>
        </div>
      <?php }else{ ?>
        <div class="form-group col-md-8">
          <label class="text-bold">Comentario</label>
          <div class="col">
            <?php if($get_id[0]['ultimo_comentario']==""){ ?>
              <input type="text" class="form-control" id="comentario1_i" name="comentario1_i" placeholder="Comentario" maxlength="35" onkeypress="if(event.keyCode == 13){ Insert_Historial(); }">
            <?php }else{?>
              <input type="text" class="form-control" id="comentario1_i" name="comentario1_i" value="<?php echo $get_id[0]['ultimo_comentario']; ?>" placeholder="Comentario" maxlength="35" onkeypress="if(event.keyCode == 13){ Insert_Historial(); }">
            <?php } ?>
          </div>
        </div>
      <?php } ?>
      
      <div class="form-group col-md-12">
        <label class="text-bold">Observaciones:</label>
        <div class="col">
          <textarea class="form-control" id="observacion_i" name="observacion_i" rows="5" placeholder="Observaciones"></textarea>
        </div>
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Tipo:</label>
        <div class="col">
          <select class="form-control" id="id_tipo_i" name="id_tipo_i">
            <option value="0" >Seleccione</option>
            <?php foreach($list_informe as $list){ ?>
                <option value="<?php echo $list['id_informe']; ?>" <?php if($get_id[0]['id_informe']==$list['id_informe']){ echo "selected"; } ?>>
                  <?php echo $list['nom_informe'];?>
                </option>
            <?php } ?>
          </select>
        </div> 
      </div>    

      <div class="form-group col-md-4">
        <label class="text-bold">Acción:</label>
        <div class="col">
          <?php if($id_nivel==1 || $id_nivel==6){ ?>
            <select name="id_accion_i" id="id_accion_i" class="form-control" onchange="Status()">
              <option value="0">Seleccione</option>
              <?php foreach($list_accion as $list){ ?>
                  <option value="<?php echo $list['id_accion']; ?>"><?php echo $list['nom_accion'];?></option>
              <?php } ?>
            </select>
          <?php }else{ ?>
            <select name="id_accion_i" id="id_accion_i" class="form-control" onchange="Status()">
              <option value="0">Seleccione</option>
              <?php foreach($list_accion as $list){ if($list['id_accion']!=11){ ?>
                  <option value="<?php echo $list['id_accion']; ?>"><?php echo $list['nom_accion'];?></option>
              <?php }} ?>
            </select>
          <?php } ?>
        </div>
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Estado:</label>
        <div id="mstatus_i" class="col">
          <select class="form-control" id="id_status_i" name="id_status_i">
            <option value="0" >Seleccione</option>
          </select>
        </div> 
      </div>                          
  </div>

  <div class="modal-footer">
    <input type="hidden" id="id_registro" name="id_registro" value="<?php echo $get_id[0]['id_registro']; ?>">
    <input type="hidden" id="id_informe" name="id_informe" value="<?php echo $get_id[0]['id_informe']; ?>">
    <input type="hidden" id="cod_registro" name="cod_registro" value="<?php echo $get_id[0]['cod_registro']; ?>">
    <input type="hidden" id="mailing" name="mailing" value="<?php echo $get_id[0]['mailing']; ?>">
    <input type="hidden" id="ultimo_comentario" name="ultimo_comentario" value="<?php echo $get_id[0]['ultimo_comentario']; ?>">
    <button type="button" onclick="Insert_Historial();" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>

<script>
  function Status(){
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

    var url = "<?php echo site_url(); ?>Administrador/Cambia_Status";
    var id_accion = $('#id_accion_i').val();
    var mailing = $('#mailing').val();

    $.ajax({
      url: url,
      type: 'POST',
      data: {'id_accion':id_accion,'mailing':mailing},
      success: function(data){
        $('#mstatus_i').html(data);
      }
    });
  }

  function Insert_Historial(){
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

    var id_registro = $("#id_registro").val();
    var dataString = $("#formulario_insert").serialize();
    var url="<?php echo site_url(); ?>Administrador/Insert_Historial_Registro_Mail";

    if (Valida_Insert_Registro_Mail()) {
      $.ajax({
          type:"POST",
          url:url,
          data:dataString,
          success:function (data) {
            if(data=="error"){
              Swal({
                  title: 'Registro Denegado',
                  text: "¡Existe un registro con misma observación, acción y estado!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              });
            }else if(data=="error2"){
              Swal({
                  title: 'Registro Denegado',
                  text: "¡Existe un registro con el mismo comentario!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              });
            }else{
              swal.fire(
                  'Registro Exitoso!',
                  'Haga clic en el botón!',
                  'success'
              ).then(function() {
                  window.location = "<?php echo site_url(); ?>Administrador/Historial_Registro_Mail/"+id_registro;
              });
            }
          }
      });
    }
  }

  function Valida_Insert_Registro_Mail() {
    if($('#id_tipo_i').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Tipo.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_accion_i').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Acción.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_status_i').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Estado.',
          'warning'
      ).then(function() { });
      return false;
    }
    return true;
  }
</script>

   




