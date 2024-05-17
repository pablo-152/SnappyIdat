<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<form id="formulario_update"  method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title"><b>Editar Acción</b></h5>
  </div>

  <div class="modal-body" style="max-height:600px; overflow:auto;">
    <div class="col-md-12 row">
      <div class="form-group col-md-6">
        <label class=" text-bold">Fecha</label>
        <div class="col">
          <input type="date" class="form-control" id="fecha_accion_u" name="fecha_accion_u" value="<?php echo $get_id[0]['fecha_accion']; ?>" onkeypress="if(event.keyCode == 13){ Insert_Historial(); }">
        </div>
      </div>
      
      <?php if($get_registro[0]['id_informe']==14){ ?> 
        <div class="form-group col-md-6">
          <label class=" text-bold">Comentario</label>
          <div class="col">
            <input type="text" class="form-control" id="comentario1_u" name="comentario1_u" maxlength="35" placeholder="Comentario" value="<?php echo $get_registro[0]['ultimo_comentario']; ?>" readonly>
          </div>
        </div>
      <?php }else{ ?>
        <div class="form-group col-md-6">
          <label class=" text-bold">Comentario</label>
          <div class="col">
            <input type="text" class="form-control" id="comentario1_u" name="comentario1_u" maxlength="35" placeholder="Comentario" value="<?php echo $get_registro[0]['ultimo_comentario']; ?>" onkeypress="if(event.keyCode == 13){ Insert_Historial(); }">
          </div>
        </div>
      <?php } ?>
      
      <div class="form-group col-md-12">
        <label class="text-bold">Observaciones:</label>
        <div class="col">
          <textarea class="form-control" id="observacion_u" name="observacion_u" rows="5" placeholder="Observaciones"><?php echo $get_id[0]['observacion'] ?></textarea>
        </div>
      </div>

      <div class="form-group col-md-4">
        <label class=" text-bold">Tipo:</label>
        <div class="col">
          <select class="form-control" id="id_tipo_u" name="id_tipo_u">
            <option value="0" >Seleccione</option>
            <?php foreach($list_informe as $list){ ?>
              <option <?php if($list['id_informe']==$get_id[0]['id_tipo']){ echo "selected"; } ?> value="<?php echo $list['id_informe']; ?>">
                <?php echo $list['nom_informe'];?>
              </option>
            <?php } ?>
          </select>
        </div> 
      </div>  

      <div class="form-group col-md-4">
        <label class=" text-bold">Acción:</label>
        <div class="col">
          <?php if($id_nivel==1 || $id_nivel==6){ ?>
            <input type="hidden" class="form-control" readonly id="accionbd" name="accionbd"  value="<?php echo $get_id[0]['id_accion'] ?>">
            <select  name="id_accion_u" id="id_accion_u" class="form-control" onchange="Status()">
              <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_accion']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
              <?php foreach($list_accion as $list){ ?>
                  <option value="<?php echo $list['id_accion']; ?>" <?php if (!(strcmp($list['id_accion'], $get_id[0]['id_accion']))) {echo "selected=\"selected\"";} ?>><?php echo $list['nom_accion'];?></option>
                <?php }  ?>
            </select>
          <?php }else{ ?>
            <input type="hidden" class="form-control" readonly id="accionbd" name="accionbd" value="<?php echo $get_id[0]['id_accion'] ?>">
            <select name="id_accion_u" id="id_accion_u" class="form-control" onchange="Status()">
              <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_accion']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
              <?php foreach($list_accion as $list){ if($list['id_accion']==11){ ?>
                  <option value="<?php echo $list['id_accion']; ?>" <?php if (!(strcmp($list['id_accion'], $get_id[0]['id_accion']))) {echo "selected=\"selected\"";} ?>><?php echo $list['nom_accion'];?></option>
                <?php }} ?>
            </select>
          <?php } ?>
        </div>
      </div>
      
      <div class="form-group col-md-4">
        <label class=" text-bold">Estado:</label>
        <div id="mstatus_u" class="col">
          <select class="form-control" id="id_status_u" name="id_status_u">
            <option value="0" >Seleccione</option>
            <?php foreach($list_status as $list){ ?>
              <option <?php if($list['id_status_general']==$get_id[0]['estado']){ echo "selected"; } ?> value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
            <?php } ?>
          </select>
        </div> 
      </div>                 
  </div>

  <div class="modal-footer">
    <input type="hidden" class="form-control" id="id_historial" name="id_historial" value="<?php echo $get_id[0]['id_historial']; ?>">
    <input type="hidden" class="form-control" id="id_registro" name="id_registro" value="<?php echo $get_id[0]['id_registro']; ?>">
    <input type="hidden" class="form-control" id="ultimo_comentario" name="ultimo_comentario" value="<?php echo $get_registro[0]['ultimo_comentario']; ?>">
    <button type="button" onclick="Update_Historial_Mail();" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
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
    var id_historial = $('#id_historial').val();
    var id_accion = $('#id_accion_u').val();
    var mailing = $('#mailing').val();

    $.ajax({
      url: url,
      type: 'POST',
      data: {'id_historial':id_historial,'id_accion':id_accion,'mailing':mailing},
      success: function(data){
        $('#mstatus_u').html(data);
      }
    });
  }

  function Update_Historial_Mail(){
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
    var dataString = $("#formulario_update").serialize();
    var url ="<?php echo site_url(); ?>Administrador/Update_Historial_Registro_Mail";

    if (Valida_Update_Registro_Mail()) {
      $.ajax({
          type:"POST",
          url:url,
          data:dataString,
          success:function (data) {
            swal.fire(
                'Actualización Exitosa!',
                'Haga clic en el botón!',
                'success'
            ).then(function() {
                window.location = "<?php echo site_url(); ?>Administrador/Historial_Registro_Mail/"+id_registro;
            });
          }
      });
    }
  }

  function Valida_Update_Registro_Mail() {
    if($('#id_tipo_u').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Tipo.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_accion_u').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Acción.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_status_u').val()=="0"){
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

   




