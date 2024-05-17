<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('Admin/nav'); ?>

<main class="app-content">
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <form id="formulario_cargo" method="POST" enctype="multipart/form-data" class="needs-validation">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="row tile-title line-head" style="background-color: #C1C1C1;">
                      <div class="col" style="vertical-align: middle;">
                        <b>Nuevo Cargo</b>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 row mt-3 mb-2">
                    <div class="form-group col-md-1">
                      <label class="control-label text-bold label_tabla">De: </label>
                    </div>
                    <div class="form-group col-md-2">
                      <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1) { ?>
                          <select class="form-control" name="id_remi" id="id_remi">
                            <option value="0">Seleccione</option>
                            <?php foreach ($list_usuario as $list) { ?>
                              <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                              <?php }?>
                          </select>
                    <?php } else {?>
                          <select  class="form-control" disabled name="id_remi" id="id_remi">
                              <option value="0" >Seleccione</option>
                          <?php foreach ($list_usuario as $list1) { 
                            if ($_SESSION['usuario'][0]['id_usuario'] == $list1['id_usuario']) { ?>
                              <option selected value="<?php echo $list1['id_usuario']; ?>"><?php echo $list1['usuario_codigo']; ?></option>
                              <?php }}?>
                      </select> 
                      <?php } ?>

                      </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Estado:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_est_men" id="id_est_men">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_estado_cargo as $list) { ?>
                        <option value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-1">
                  </div><!-- estado-->
                  <div class="form-group col-md-2">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Ref:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input id="new_code_cargo" name="new_code_cargo" type="text" maxlength="50" class="form-control"
                    value="<?php echo $siguiente_cargo_ref['0']['next_cargo']; ?>" readonly>
                  </div>

                  <div class="form-group col-md-12">
                    <label class="control-label text-bold label_tabla">Para:</label>
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Empresa</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_empresa" id="id_empresa" onchange="Sede()">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_empresa as $list) { ?>
                        <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold">Sede:</label>
                  </div>

                  <div class="form-group col-md-2" id="msede">
                    <select class="form-control" name="id_sede" id="id_sede">
                      <option value="0" selected>Seleccione</option>
                    </select>
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Usuario:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_usu_recep" id="id_usu_recep">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_usuario as $list) { ?>
                        <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-1">
                  </div>
                  <div class="form-group col-md-2">
                  </div>
                  <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 2) { ?>
                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Otro:</label>
                  </div>
                  <div class="form-group col-md-3">
                    <input id="otro" name="otro" type="text" maxlength="50" class="form-control"  placeholder="Ingresar Persona Externa">
                  </div>
                  <?php } ?> 
                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Correo:</label>
                  </div>
                  <div class="form-group col-md-3">
                    <input name="correo" type="text" maxlength="50" class="form-control" id="correo" placeholder="Ingresar Correo">
                  </div>
                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Celular:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input name="celular" type="text" maxlength="50" class="form-control" id="celular" placeholder="Ingresar Celular">
                  </div>

                  <div class="form-group col-md-12">
                    <label class="control-label text-bold label_tabla">Intermediario/Transporte:</label>
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Empresa</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_empresa2" id="id_empresa2" onchange="Sede2()">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_empresa as $list) { ?>
                        <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold">Sede:</label>
                  </div>

                  <div class="form-group col-md-2" id="msede2">
                    <select class="form-control" name="id_sede2" id="id_sede2">
                      <option value="0" selected>Seleccione</option>
                    </select>
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Usuario:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <select class="form-control" name="id_usu_trans" id="id_solicitante">
                      <option value="0">Seleccione</option>
                      <?php foreach ($list_usuario as $list) { ?>
                        <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-1">
                  </div>
                  <div class="form-group col-md-2">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Otro:</label>
                  </div>
                  <div class="form-group col-md-3">
                    <input name="otro_trans" type="text" maxlength="50" class="form-control" id="otro_trans" placeholder="Ingresar Persona Externa">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Correo:</label>
                  </div>
                  <div class="form-group col-md-3">
                    <input name="correo_trans" type="text" maxlength="50" class="form-control" id="correo_trans" placeholder="Ingresar Correo">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Celular:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input name="celular_trans" type="text" maxlength="50" class="form-control" id="celular_trans" placeholder="Ingresar Celular">
                  </div>

                  <div class="form-group col-md-1">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Empresa Transporte:</label>
                  </div>
                  <div class="form-group col-md-3">
                    <input name="emp_trans" type="text" maxlength="50" class="form-control" id="emp_trans" placeholder="Ingresar Empresa Transporte">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Referencia:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input name="refe_trans" type="text" maxlength="50" class="form-control" id="refe_trans" placeholder="Ingresar Referencia">
                  </div>

                  <div class="form-group col-md-5">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Descripción:</label>
                  </div>
                  <div class="form-group col-md-6">
                    <input name="descrip" type="text" maxlength="50" class="form-control" id="descrip" placeholder="Ingresar Descripción">
                  </div>

                  <div class="form-group col-md-5">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold label_tabla">Observaciones:</label>
                  </div>

                  <div class="form-group col-md-11">
                  </div>
                  <div class="form-group col-md-1">
                  </div>

                  <div class="form-group col-md-8">
                    <textarea name="obs_trans" type="text" maxlength="500" rows="5" class="form-control" id="obs_trans" placeholder="Ingresar Observaciones"></textarea>
                  </div>

                  <div class="form-group col-md-3">
                  </div>

                  <div class="form-group col-md-1">
                    <label class="control-label text-bold">Archivos:</label>
                  </div>
                  <div class="form-group col-md-8">
                  <input type="file" class="form-control" name="files[]" id="files" multiple autofocus />
                  </div>
                  <div class="modal-footer col-md-12">
                    <button type="button" class="btn btn-primary" onclick="Insert_Cargo();">Guardar</button> 
                    <button type="button" class="btn btn-default" >Cancelar</button>
                  </div>
              </form>
              
            </div>

            
          </div>

        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</main>
<link href="<?php echo base_url(); ?>template/inputfiles/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>template/inputfiles/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/piexif.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/sortable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/fr.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/es.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.js" type="text/javascript"></script>


<script>
  $('#files').fileinput({
    theme: 'fas',
    language: 'es',
    uploadUrl: '#',
    maxTotalFileCount: 5,
    showUpload: false,
    overwriteInitial: false,
    initialPreviewAsData: true,
    allowedFileExtensions: ['png', 'jpeg', 'jpg', 'xls', 'xlsx', 'pdf'],
  });
</script>


<script>
  function Sede() {
    var url = "<?php echo site_url(); ?>Administrador/Busca_Sede_Ticket";
    $.ajax({
      url: url,
      type: 'POST',
      data: $("#formulario_cargo").serialize(),
      success: function(data) {
        $('#msede').html(data);
      }
    });
  }

  function Sede2() {
    var url = "<?php echo site_url(); ?>Administrador/Busca_Sede2_Ticket";
    $.ajax({
      url: url,
      type: 'POST',
      data: $("#formulario_cargo").serialize(),
      success: function(data) {
        $('#msede2').html(data);
      }
    });
  }
</script>
<script>
  function Insert_Cargo(){
      var dataString = new FormData(document.getElementById('formulario_cargo'));
      //var dataString = $("#formulario_insert_pc").serialize();
      //var url="<?php echo site_url(); ?>Administrador/Insert_Escritorio_Detalle";
      if (valida_registros_cargo()) {
          $.ajax({
              type:"POST",
              url:url,
              data:dataString,
              processData: false,
              contentType: false,
              success:function (data) {
                  var valor_error=data.split("*")[0];
                  var mensaje=data.split("*")[1];
                  
                  if(valor_error==="ERROR"){
                      Swal({
                          title: 'Registro Denegado',
                          text: mensaje,
                          type: 'error',
                          showCancelButton: false,
                          confirmButtonColor: '#3085d6',
                          confirmButtonText: 'OK',
                      });
                  }else if (valor_error==="CODIGO"){
                      swal.fire(
                          'Registro Exitoso!',
                          'Se Agrego un Nuevo Mantenimiento a la '+mensaje,
                          'success'
                      ).then(function() {
                            window.location = "<?php echo site_url('Administrador/Modal_Escritorio_Actualizar')
                            ?>/<?php echo $list['id_pc'] ?>";
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
  function valida_registros_cargo() {
    if($('#id_empresa').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }

      return true;
  }
</script>

<?php $this->load->view('Admin/footer'); ?>

