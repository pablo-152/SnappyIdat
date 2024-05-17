<form class="formulario" id="formulario_ev" method="POST" enctype="multipart/form-data" >
  <div class="modal-header">
      <h3 class="tile-title"><b>Asignar</b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
  </div>

  <div class="modal-body" style="overflow:auto;">
    <div class="col-md-12 row">

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Año:</label>
      </div>
      <div class="form-group col-md-10">
        <input name="anio1" type="text" maxlength="4" class="form-control" id="anio1" placeholder="Ingresar año">
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Folder:</label>
      </div>
      
      <div class="form-group col-md-10">
        <select class="form-control" id="folder" name="folder" onchange="FolderM()">
          <option value="0">Seleccione</option>
          <?php foreach($tipo as $l){?>
            <option value="<?php echo $l; ?>"><?php echo $l; ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Tipo:</label>
      </div>
      <div class="form-group col-md-10">
        <select class="form-control" id="tipo_folder" name="tipo_folder" onchange="TipoM()">
          <option value="0">Seleccione</option>
          <option value="A">A</option>
          <option value="B">B</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Sede:</label>
      </div>
      <div class="form-group col-md-10">
        <select class="form-control" id="sede_folder" name="sede_folder" onchange="SedeM()">
          <option value="0">Seleccione</option>
          <?php foreach($list_sede as $list){ ?>
            <option value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede']; ?></option>
          <?php } ?>
        </select>
      </div>

    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="Asignar_Folder()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>
    
<script>
  $('#anio1').bind('keyup paste', function(){
    var anio=$('#anio1').val();
    $('#anio_f').val(anio);
  });


  function SedeM(){
    var sede_folder=$('#sede_folder').val();
    $('#sede_folder_f').val(sede_folder);
  }

  function FolderM(){
    var folder_f=$('#folder').val();
    $('#folder_f').val(folder_f);
  }

  function TipoM(){
    var tipofolder=$('#tipo_folder').val();
    $('#tipo_folder_f').val(tipofolder);
  }
  
</script>



   




