<form id="formulario_update_evento"  method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title"><b>Editar Evento</b></h5>
  </div>

  <div class="modal-body" style="max-height:600px; overflow:auto;">
    <div class="col-md-12 row">
      <div class="form-group col-md-3">
        <label class=" text-bold">Estado:</label>
        <div class="col">
          <select class="form-control" id="id_status_e" name="id_status_e">
            <option value="0">Seleccione</option>
            <?php foreach($list_status as $list){ ?>
              <option <?php if($list['id_status_general']==$get_id[0]['estado']){ echo "selected"; } ?> value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
            <?php } ?>
          </select>
        </div> 
      </div>                 
  </div>

  <div class="modal-footer">
    <input type="hidden" id="id_historial" name="id_historial" value="<?php echo $get_id[0]['id_historial']; ?>">
    <input type="hidden" id="id_registro" name="id_registro" value="<?php echo $get_id[0]['id_registro']; ?>">
    <input type="hidden" id="id_evento" name="id_evento" value="<?php echo $get_id[0]['id_evento']; ?>">
    <button type="button" onclick="Update_Historial_Evento();" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>

<script>
  function Update_Historial_Evento(){ 
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
    var id_evento = $("#id_evento").val();
    var dataString = $("#formulario_update_evento").serialize();
    var url ="<?php echo site_url(); ?>Administrador/Update_Historial_Evento";

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
                window.location = "<?php echo site_url(); ?>Administrador/Historial_Evento/"+id_registro+"/"+id_evento;
            });
          }
      });
    }
  }

  function Valida_Update_Registro_Mail() {
    if($('#id_status_e').val()=="0"){
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

   




