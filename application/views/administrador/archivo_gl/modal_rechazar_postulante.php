<form id="formulario_rechazar_arch_postulante" method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Rechazar Archivo</b></h5>
  </div>

  <div class="modal-body" style="max-height:600px; overflow:auto;">
    <div class="col-md-12 row">
      <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo:</label>
      </div>
        <div class="form-group col-md-3">
          <select class="form-control" id="id_tipo_observacion" name="id_tipo_observacion">
            <option value="0">Seleccione</option>
            <?php foreach ($list_tipo_obs as $list) { ?>
              <option value="<?php echo $list['id_tipo']; ?>"><?php echo $list['nom_tipo']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group col-md-9">
          <label class=" text-bold">Comentario:</label>
        </div>
        <div class="form-group col-md-12">
          <input class="form-control" type="text" id="observacion" name="observacion" maxlength="150" placeholder="Comentario">
        </div>
    </div>
  </div>

  <div class="modal-footer">
    <input type="hidden" id="id_postulante" name="id_postulante" value="<?php echo $id_postulante; ?>">
    
    <input type="hidden" id="id_detalle" name="id_detalle" value="<?php echo $id_detalle; ?>">
    <input type="hidden" id="observacion_archivo" name="observacion_archivo" value="<?php echo $archivo; ?>">
    <input type="hidden" id="id_documento" name="id_documento" value="<?php echo $id_documento; ?>">
    <button type="button" onclick="Insert_Obs_Rechazar_Postulante();" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>

<script>
  function Insert_Obs_Rechazar_Postulante() {
    Cargando();

    var dataString = new FormData(document.getElementById('formulario_rechazar_arch_postulante'));
    var url = "<?php echo site_url(); ?>Administrador/Insert_Observacion_Rechazar_Postulante";
    var tipoLista = $("#tipo_lista").val();

    if (Valida_Insert_Observacion_Rechazar_Postulante()) {
      $.ajax({
        type: "POST",
        url: url,
        data: dataString,
        processData: false,
        contentType: false,
        success: function() {
          Lista_Archivo_Postulante(tipoLista);
          $('#acceso_modal_mod').modal('hide');
        }
      });
    }
  }

  function Valida_Insert_Observacion_Rechazar_Postulante() {
    if ($('#id_tipo_observacion').val().trim() == 0) {
      Swal(
        'Ups!',
        'Debe seleccionar Tipo',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#observacion').val().trim() === "") {
      Swal(
        'Ups!',
        'Debe ingresar Comentario',
        'warning'
      ).then(function() {});
      return false;
    }
    return true;
  }
</script>