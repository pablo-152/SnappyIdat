<form class="formulario" id="formulario_validacion" method="POST" enctype="multipart/form-data" >
  <div class="modal-header">
      <h3 class="tile-title"><b>Validar Documentación</b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
  </div>

  <div class="modal-body" style="overflow:auto;">
    <div class="col-md-12 row">

      <div class="form-group col-md-12">
        <input type="checkbox" id="doc" name="doc" value="1" <?php if($get_id[0]['ch_doc']==1){ echo "checked"; }?> class="minimal"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><label class="form-group">Documento </label>
      </div>

      <div class="form-group col-md-12">
        <input type="checkbox" id="dni" name="dni" value="1" <?php if($get_id[0]['ch_dni']==1){ echo "checked"; }?> class="minimal"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><label class="form-group">DNI </label>
      </div>

      <div class="form-group col-md-12">
        <input type="checkbox" id="certificadoe" name="certificadoe" value="1" <?php if($get_id[0]['ch_certificadoe']==1){ echo "checked"; }?> class="minimal"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><label class="form-group">Certificado de Estudios </label>
      </div>

      <div class="form-group col-md-12">
        <input type="checkbox" id="foto" name="foto" value="1" <?php if($get_id[0]['ch_foto']==1){ echo "checked"; }?> class="minimal"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span><label class="form-group">Foto </label>
      </div>
      

    </div>
  </div>

  <div class="modal-footer">
    <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $id_alumno ?>">
    <button type="button" class="btn btn-primary" onclick="Validar_Documentacion()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>



   




