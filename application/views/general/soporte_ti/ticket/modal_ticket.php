<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<form id="formulario" method="POST" enctype="multipart/form-data">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Ticket (Nuevo)</b></h5>
  </div>

  <div class="modal-body" style="max-height:520px; overflow:auto;"> 
    <div class="col-md-12 row">
      <div class="form-group col-md-4">
        <label class="control-label text-bold">Tipo:</label>
        <select class="form-control" id="id_tipo_ticket" name="id_tipo_ticket">
            <option value="0">Seleccione</option>
            <?php foreach($list_tipo_ticket as $list){ ?>
              <option value="<?php echo $list['id_tipo_ticket']; ?>">
                <?php echo $list['nom_tipo_ticket']; ?>
              </option>
            <?php } ?>
        </select>
      </div>

      <?php if($id_usuario==33 || $id_usuario==48 || 
      $_SESSION['usuario'][0]['id_nivel']==6){ ?>
        <div class="form-group col-md-4">
          <label class="control-label text-bold">Solicitado Por:</label>
          <select class="form-control" id="id_solicitante" name="id_solicitante" onchange="Follow_Up();">
            <option value="0">Seleccione</option>
            <?php foreach($list_solicitante as $list){ ?>
                <option value="<?php echo $list['id_usuario']; ?>" 
                <?php if($list['id_usuario']==$id_usuario){ echo "selected"; } ?>>
                  <?php echo $list['usuario_codigo']; ?>
                </option>
            <?php } ?>
          </select>     
        </div>
      <?php }else{ ?>
        <div class="form-group col-md-4">
          <label class="control-label text-bold">Solicitado Por:</label>
          <div class="col">
            <?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?>
          </div>
          <input type="hidden" id="id_solicitante" name="id_solicitante" value="<?php echo $id_usuario; ?>">
        </div>
      <?php } ?>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Fecha:</label>
        <div class="col">
          <?php echo date('d/m/Y');?>
        </div>
      </div>
    </div>

    <div class="col-md-12" style="margin-bottom:15px;">
      <label class="control-label text-bold">Follow Up:</label>
      <select class="form-control multivalue" id="follow_up" name="follow_up[]" multiple="multiple">
          <?php foreach($list_follow_up as $list){ ?>
              <option value="<?php echo $list['id_usuario']; ?>">
                <?php echo $list['usuario_codigo']; ?>
              </option>
          <?php } ?>
      </select>
    </div>

    <div class="col-md-12 row">
      <div class=" form-group col-md-4">
        <label class="control-label text-bold">Empresa:</label>
        <select class="form-control" id="id_empresa" name="id_empresa" onchange="Proyecto();">
            <option value="0">Seleccione</option>
              <?php foreach($list_empresa as $list){ ?>
              <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
            <?php } ?>
        </select>  
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Proyecto:</label>
        <select class="form-control" id="id_proyecto_soporte" name="id_proyecto_soporte" onchange="Subproyecto();">
          <option value="0">Seleccione</option>
        </select>
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Sub-Proyecto:</label>
        <select class="form-control" id="id_subproyecto_soporte" name="id_subproyecto_soporte">
          <option value="0">Seleccione</option>
        </select>
      </div>
    </div>
        
    <div class="col-md-12 row">
      <div class="form-group col-md-9">
        <label class="control-label text-bold">Descripción:</label>
        <input name="ticket_desc" type="text" maxlength="50" class="form-control" id="ticket_desc" placeholder="Ingresar descripción">
      </div>

      <div class="form-group col-md-3">
        <label class="control-label text-bold">Prioridad:</label>
        <select class="form-control" name="prioridad" id="prioridad">
          <option value="">Selecione</option>
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select> 
      </div>
    </div>

    <div class="form-group col-md-12">
      <label class="control-label text-bold">Observaciones:</label>
      <textarea name="ticket_obs" rows="4" class="form-control" id="ticket_obs" placeholder="Ingresar Observaciones"></textarea>
    </div>

    <div class="form-group col-md-12">
      <label class="control-label text-bold">Archivos:</label>
      <input type="file" name="files[]" id="files" multiple/>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="Insert_Ticket();">Guardar</button>
    <button type="button" class="btn btn-link" data-dismiss="modal">Cancelar</button>
  </div>
</form>

<script>
  var ss = $(".multivalue").select2({
    tags: true
  });

  $('.multivalue').select2({
    dropdownParent: $('#modal_form_vertical')
  });

  function Follow_Up(){
    Cargando();

    var url = "<?php echo site_url(); ?>General/Busca_Follow_Up_Ticket";
    var id_solicitante = $('#id_solicitante').val();

    $.ajax({
        url: url,
        type: 'POST',
        data: {'id_solicitante':id_solicitante},
        success: function(data){
            $('#follow_up').html(data);
        }
    });
  }

  function Proyecto(){
    Cargando();

    var url = "<?php echo site_url(); ?>General/Busca_Proyecto_Ticket";
    var id_empresa = $('#id_empresa').val();

    $.ajax({
        url: url,
        type: 'POST',
        data: {'id_empresa':id_empresa},
        success: function(data){
            $('#id_proyecto_soporte').html(data);
            $('#id_subproyecto_soporte').html('<option value="0">Seleccione</option>');
        }
    });
  }

  function Subproyecto(){
    Cargando();
    
    var url = "<?php echo site_url(); ?>General/Busca_Subproyecto_Ticket";
    var id_empresa = $('#id_empresa').val();
    var id_proyecto_soporte = $('#id_proyecto_soporte').val();
    
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id_empresa':id_empresa,'id_proyecto_soporte':id_proyecto_soporte},
        success: function(data){
            $('#id_subproyecto_soporte').html(data);
        }
    });
  }

  function Insert_Ticket(){
      Cargando();

      var dataString = new FormData(document.getElementById('formulario'));
      var url="<?php echo site_url(); ?>General/Insert_Ticket";

      if (Valida_Insert_Ticket()) {
          $.ajax({
              url: url,
              data:dataString,
              type:"POST",
              processData: false,
              contentType: false,
              success:function (data) {
                  swal.fire(
                      'Tu ticket se ha grabado correctamente con el código',
                      data,
                      'success'
                  ).then(function() {
                      $("#modal_form_vertical .close").click()
                      Lista_Ticket(0);
                  });
              }
          });
      }
  }

  function Valida_Insert_Ticket() {
      if($('#id_tipo_ticket').val() === '0') {
          Swal(
              'Ups!',
              'Debe seleccionar Tipo.',
              'warning'
          ).then(function() { });
          return false;
      }
      if($('#id_solicitante').val() === '0') {
          Swal(
              'Ups!',
              'Debe seleccionar Solicitante.',
              'warning'
          ).then(function() { });
          return false;
      }
      if($('#id_empresa').val() === '0') {
          Swal(
              'Ups!',
              'Debe seleccionar Empresa.',
              'warning'
          ).then(function() { });
          return false;
      }
      if($('#id_proyecto_soporte').val() === '0') {
          Swal(
              'Ups!',
              'Debe seleccionar Proyecto.',
              'warning'
          ).then(function() { });
          return false;
      }
      if($('#id_subproyecto_soporte').val() === '0') {
          Swal(
              'Ups!',
              'Debe seleccionar Subproyecto.',
              'warning'
          ).then(function() { });
          return false;
      }
      if($('#ticket_desc').val().trim() === '') {
          Swal(
              'Ups!',
              'Debe ingresar Descripción.',
              'warning'
          ).then(function() { });
          return false;
      }
      if($('#prioridad').val().trim() === '') {
          Swal(
              'Ups!',
              'Debe seleccionar Prioridad.',
              'warning'
          ).then(function() { });
          return false;
      }
      return true;
  }
</script>