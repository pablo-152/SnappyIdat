<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Cargo (Nuevo)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                      <a  title="Nuevo Archivo" style="cursor:pointer; cursor: hand;margin-right:5px;" data-toggle="modal"  data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('Snappy/Modal_archivo_cargo_reg') ?>">
                        <img src="<?= base_url() ?>template/img/icono-subir.png" alt="Exportar Excel">
                      </a>
                      <a type="button" href="<?= site_url('Snappy/Cargo') ?>">
                          <img src="<?= base_url() ?>template/img/icono-regresar.png">
                      </a>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    <form id="formulario_cargo" method="POST" enctype="multipart/form-data"  class="horizontal">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">De: </label>
                </div>
                <div class="form-group col-md-2">
                  <?php if($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 6){ ?>
                      <select class="form-control" name="id_usuario_de" id="id_usuario_de">
                        <option value="0">Seleccione</option>
                        <?php foreach ($list_usuario as $list) { ?>
                          <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                        <?php }?>
                      </select>
                  <?php }else{ ?>
                      <input id="id_usuario_de" name="id_usuario_de" type="hidden" value="<?php echo $_SESSION['usuario'][0]['id_usuario']; ?>" readonly>
                      <input id="nom" name="nom" type="text" value="<?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?>" readonly>
                  <?php } ?>
                </div>

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Estado:</label>
                </div>
                <div class="form-group col-md-2">
                  <select class="form-control" name="id_est_men" id="id_est_men" disabled>
                    <option value="0">Creado</option>
                  </select>
                </div>

                <div class="form-group col-md-4 text-right">
                  <label class="control-label text-bold label_tabla margintop"></label>
                </div>
                <div class="form-group col-md-1" style="width: 150px !important;">
                  <input id="cod_cargo" name="cod_cargo" title="Referencia automática" style="cursor:help;background-color:#715d7436" type="text" maxlength="50" class="form-control" value="" readonly>
                </div>
              </div>
              <div class="col-md-12"> 
                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Descripción:</label>
                </div>
                <div class="form-group col-md-11">
                  <input name="desc_cargo" type="text" maxlength="50" class="form-control" id="desc_cargo" placeholder="Ingresar Descripción" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                </div>
              </div>

              <div class="col-md-12" style="margin-top: 15px;">
                <div class="form-group col-md-6">
                  <label class="control-label text-bold label_tabla">Para:</label>
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label text-bold label_tabla">Intermediario:</label>
                </div>
              </div>

              <div class="col-md-12" style="margin-top: 15px;">

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Empresa</label>
                </div>
                <div class="form-group col-md-2">
                  <select class="form-control" name="id_empresa" id="id_empresa" onchange="Buscar_Sede()">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_empresam as $list) { ?>
                      <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold margintop">Sede:</label>
                </div>

                <div class="form-group col-md-2" id="msede">
                  <select class="form-control" name="id_sede" id="id_sede">
                    <option value="0" selected>Seleccione</option>
                  </select>
                </div>

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Empresa</label>
                </div>
                <div class="form-group col-md-2">
                  <select class="form-control" name="id_empresa2" id="id_empresa2" onchange="Buscar_Sede2()">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_empresam as $list) { ?>
                      <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold margintop">Sede:</label>
                </div>

                <div class="form-group col-md-2" id="msede2">
                  <select class="form-control" name="id_sede2" id="id_sede2">
                    <option value="0" selected>Seleccione</option>
                  </select>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Usuario:</label>
                </div>

                <div class="form-group col-md-2">
                  <select class="form-control" name="id_usuario_1" id="id_usuario_1" onchange="Buscar_Correo_Usuario_Cargo(),Buscar_Celular_Usuario_Cargo();">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_usuario as $list) { ?>
                      <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Correo:</label>
                </div>
                <div class="form-group col-md-2" id="m-correo-usuario1">
                    <input name="correo_1" type="text" maxlength="50" class="form-control" id="correo_1" readonly placeholder="Ingresar Correo" >
                </div>

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Usuario:</label>
                </div>
                <div class="form-group col-md-2">
                  <select class="form-control" name="id_usuario_2" id="id_usuario_2" onchange="Buscar_Correo_Usuario2_Cargo(),Buscar_Celular_Usuario2_Cargo();">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_usuario as $list) { ?>
                      <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Correo:</label>
                </div>
                <div class="form-group col-md-2" id="m-correo-usuario2">
                  <input name="correo_2" type="text" maxlength="50" class="form-control" id="correo_2" readonly placeholder="Ingresar Correo" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                </div>

              </div>
              <div class="col-md-12">
                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Celular:</label>
                </div>
                <div class="form-group col-md-2" id="m-celular-usuario1">
                  <input name="celular_1" type="text" maxlength="9" class="form-control" id="celular_1" readonly placeholder="Ingresar Celular" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                </div>
                <?php if ($_SESSION['usuario'][0]['id_nivel'] == 1 || $_SESSION['usuario'][0]['id_nivel'] == 2 || $_SESSION['usuario'][0]['id_nivel'] == 6) { ?>
                  <div class="form-group col-md-1 text-right">
                    <label class="control-label text-bold label_tabla margintop">Otro:</label>
                  </div>
                  <div class="form-group col-md-2">
                    <input id="otro_1" name="otro_1" type="text" maxlength="50" class="form-control"   placeholder="Ingresar Persona Externa" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                  </div>
                <?php } ?> 
                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Celular:</label>
                </div>
                <div class="form-group col-md-2" id="m-celular-usuario2">
                  <input name="celular_2" type="text" maxlength="9" class="form-control" id="celular_2" readonly placeholder="Ingresar Celular" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                </div>

                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Otro:</label>
                </div>
                <div class="form-group col-md-2">
                  <input name="otro_2" type="text" maxlength="50" class="form-control" id="otro_2" placeholder="Ingresar Persona Externa" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                </div>
              </div>

              <div class="col-md-12" style="margin-top: 15px;">
                <div class="form-group col-md-12">
                  <label class="control-label text-bold label_tabla">Transporte:</label>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop" title="Empresa Transporte">Emp. Transporte:</label>
                </div>
                <div class="form-group col-md-5">
                  <input name="empresa_transporte" type="text" maxlength="50" class="form-control" id="empresa_transporte" placeholder="Ingresar Empresa Transporte" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                </div>

                
              </div>
              <div class="col-md-12">
              <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Referencia:</label>
                </div>
                <div class="form-group col-md-5">
                  <input name="referencia" type="text" maxlength="50" class="form-control" id="referencia" placeholder="Ingresar Referencia" onkeypress="if(event.keyCode == 13){ Insert_Cargo(); }">
                </div>
                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Rubro:</label>
                </div>
                <div class="form-group col-md-2">
                  <select class="form-control" name="id_rubro" id="id_rubro">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_rubro as $list) { ?>
                      <option value="<?php echo $list['id_rubro']; ?>"><?php echo $list['nom_rubro']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group col-md-1 text-right">
                  <label class="control-label text-bold label_tabla margintop">Observaciones:</label>
                </div>

                <div class="form-group col-md-11">
                  <textarea name="obs_cargo" type="text" maxlength="500" rows="5" class="form-control" id="obs_cargo" placeholder="Ingresar Observaciones"></textarea>
                </div>
              </div>

              <div class="col-md-12">
                <div class="col-md-12" id="div_temporal">
                </div>
              </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Insert_Cargo()" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <!--<button type="button" class="btn btn-default" onclick="Cancelar()">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>-->
        </div>
    </form>
</div>

<script>
    $('#celular_1').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#celular_2').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

    $(document).ready(function() {
        $("#cargo").addClass('active');
        $("#hcargo").attr('aria-expanded', 'true');
        $("#slista").addClass('active');
        /*$("#hlista").attr('aria-expanded', 'true');
        $("#nuevocargo").addClass('active');
        document.getElementById("rlista").style.display = "block";*/
        document.getElementById("rcargo").style.display = "block";
    });

    function Agregar_Documento() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_archi_reg'));
        var url="<?php echo site_url(); ?>Snappy/Preguardar_Documento_Cargo";

        if (Valida_Documento()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Existe un documento con el mismo nombre!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }
                    else if(data=="1"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Solo se puede adjuntar 5 documentos por cargo!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        var url2="<?php echo site_url(); ?>Snappy/List_Preguardado_Documento_Cargo";
                        var dataString2 = new FormData(document.getElementById('formulario_cargo'));
                        
                        $.ajax({
                            type:"POST",
                            url: url2,
                            data:dataString2,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                            $('#div_temporal').html(data);
                            //$("#ModalUpdate .close").click()
                            document.getElementById("nom_documento").value = "";
                            document.getElementById("documento").value = "";
                            $("#modal_form_vertical .close").click()
                        }
                        });
                    }
                }
            });
        }
    }

    function Valida_Documento(){
      if($('#nom_documento').val().trim() === '') {
          Swal(
              'Ups!',
              'Debe ingresar nombre de documento.',
              'warning'
          ).then(function() { });
          return false;
      }
      if($('#documento').val().trim() === '') {
          Swal(
              'Ups!',
              'Debe adjuntar documento.',
              'warning'
          ).then(function() { });
          return false;
      }
      return true;
    }

    $('#archivos').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['png','jpeg','jpg','xls','xlsx','pdf'],
    });

    function Buscar_Correo_Usuario_Cargo(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cargo'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Correo_Usuario_Cargo";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#m-correo-usuario1').html(data);
            }
        });
    }

    function Buscar_Celular_Usuario_Cargo(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cargo'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Celular_Usuario_Cargo";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#m-celular-usuario1').html(data);
            }
        });
    }

    function Buscar_Correo_Usuario2_Cargo(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cargo'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Correo_Usuario2_Cargo";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#m-correo-usuario2').html(data);
            }
        });
    }

    function Buscar_Celular_Usuario2_Cargo(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cargo'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Celular_Usuario2_Cargo";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#m-celular-usuario2').html(data);
            }
        });
    }
    function Buscar_Sede(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_cargo'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Sede_Cargo";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#msede').html(data);
            }
        });
    }

  function Buscar_Sede2() {
      Cargando();
      
      var dataString = new FormData(document.getElementById('formulario_cargo'));
      var url="<?php echo site_url(); ?>Snappy/Buscar_Sede_Cargo2";
      $.ajax({
          type:"POST",
          url: url,
          data:dataString,
          processData: false,
          contentType: false,
          success:function (data) {
              $('#msede2').html(data);
          }
      });
  }

  function Insert_Cargo(){ 
    Cargando();

    var dataString = new FormData(document.getElementById('formulario_cargo'));
    var url="<?php echo site_url(); ?>Snappy/Insert_Crear_yEnviar_Cargo";

    if (valida_registros_cargo()) {
      if ($('#div_verificar').length > 0) {
          bootbox.dialog({
              message: " ",
              title: "Registrar Cargo",
              buttons: {
                  main: {
                      label: "Crear y enviar",
                      className: "btn-primary",
                      callback: function() {
                        $.ajax({
                          type:"POST",
                          url:url,
                          data:dataString,
                          processData: false,
                          contentType: false,
                          success:function (data) {
                              if(data=="cantidad"){
                                  Swal({
                                      title: 'Registro Denegado',
                                      text: 'El usuario no puede tener más de 2 cargos asignados',
                                      type: 'error',
                                      showCancelButton: false,
                                      confirmButtonColor: '#3085d6',
                                      confirmButtonText: 'OK',
                                  });
                              }else if(data=="error"){
                                  Swal({
                                      title: 'Registro Denegado',
                                      text: 'El registro ya existe',
                                      type: 'error',
                                      showCancelButton: false,
                                      confirmButtonColor: '#3085d6',
                                      confirmButtonText: 'OK',
                                  });
                              }else{
                                  swal.fire(
                                      'Registro Exitoso!',
                                      'Se registró y envió correo de un Nuevo cargo!</br>Referencia de Cargo <b>'+data,
                                      'success'
                                  ).then(function() {
                                        window.location = "<?php echo site_url('Snappy/Cargo')?>";
                                  });
                              }
                          }
                        });
                      }
                  },
                  danger: {
                      label: "Cancelar",
                      className: "btn-default",
                      callback: function() {
                      }
                  },
              }
          });
 
      }else{
        Swal({
              title: '¿Realmente desea guardar el cargo?',
              text: "Es recomendable poner foto o archivo",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si',
              cancelButtonText: 'No',
          }).then((result) => {
              if (result.value) {
                bootbox.dialog({
                    message: " ",
                    title: "Registrar Cargo",
                    buttons: {
                        main: {
                            label: "Crear y enviar",
                            className: "btn-primary",
                            callback: function() {
                              $.ajax({
                                type:"POST",
                                url:url,
                                data:dataString,
                                processData: false,
                                contentType: false,
                                success:function (data) {
                                    if(data=="cantidad"){
                                        Swal({
                                            title: 'Registro Denegado',
                                            text: 'El usuario no puede tener más de 2 cargos asignados',
                                            type: 'error',
                                            showCancelButton: false,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                        });
                                    }else if(data=="error"){
                                        Swal({
                                            title: 'Registro Denegado',
                                            text: 'El registro ya existe',
                                            type: 'error',
                                            showCancelButton: false,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                        });
                                    }else{
                                        swal.fire(
                                            'Registro Exitoso!',
                                            'Se registró y envió correo de un Nuevo cargo!</br>Referencia de Cargo <b>'+data,
                                            'success'
                                        ).then(function() {
                                              window.location = "<?php echo site_url('Snappy/Cargo')?>";
                                        });
                                    }
                                }
                              });
                            }
                        },
                        danger: {
                            label: "Cancelar",
                            className: "btn-default",
                            callback: function() {
                            }
                        },
                    }
                });
              }
        }) 
      }
    }
  }

  function Cancelar(){
    window.location = "<?php echo site_url('Snappy/Cargo')?>";
  }

  function valida_imagen(){
    if($('#div_veri').val() !== null) {

    }
    
  }

  function valida_registros_cargo() {

    if($('#id_usuario_de').val() == '0') {
        Swal(
            'Ups!',
            'Debe seleccionar Usuario que realiza el registro.',
            'warning'
        ).then(function() { });
        return false;
    }

    if($('#id_empresa').val() == '0') {
        Swal(
            'Ups!',
            'Debe seleccionar empresa (para).',
            'warning'
        ).then(function() { });
        return false;
    }
    if($('#id_sede').val() == '0') {
        Swal(
            'Ups!',
            'Debe seleccionar sede (para).',
            'warning'
        ).then(function() { });
        return false;
    }

    if($('#id_usuario_1').val() == '0') {
        Swal(
            'Ups!',
            'Debe seleccionar usuario de destino.',
            'warning'
        ).then(function() { });
        return false;
    }

    if($('#desc_cargo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar una Descripción.',
                'warning'
            ).then(function() { });
            return false;
    }

    if($('#id_rubro').val() == '0') {
        Swal(
            'Ups!',
            'Debe seleccionar un Rubro.',
            'warning'
        ).then(function() { });
        return false;
    }

    return true;
  }
</script>

<script>
    

    $(".img_post_temporal").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file_temporal', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Snappy/Descargar_Imagen_Cargo_Temporal/" + image_id);
    });

    $(document).on('click', '#delete_file_temporal', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Snappy/Delete_Imagen_Cargo_Temporal',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>

<?php $this->load->view('Admin/footer'); ?>