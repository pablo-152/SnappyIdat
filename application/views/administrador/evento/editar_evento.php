<style>
  .grande{
    width: 20px !important;
    height: 20px !important;
  }
</style>

<form class="formulario" id="formularioe_ev"  method="POST" enctype="multipart/form-data" >
  <div class="modal-header">
    <h3 class="tile-title">Edición de Datos del Evento <b><?php echo $get_id[0]['cod_evento']; ?></b></h3>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>
  
  <div class="modal-body" >
      <div class="col-md-12 row">
        <div class="form-group col-md-2">
          <label class="control-label text-bold">Evento:</label>
        </div>
        <div class="form-group col-md-10">
          <input name="nom_evento" type="text" maxlength="35" class="form-control" id="nom_evento" value="<?php echo $get_id[0]['nom_evento'] ?>" placeholder="Ingresar evento" onkeypress="if(event.keyCode == 13){ Update_Evento(); }"> 
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Fecha&nbsp;(Evento):</label>
        </div>
        <div class="form-group col-md-4">
          <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha" type="date" value="<?php echo $get_id[0]['fec_agenda'] ?>" onkeypress="if(event.keyCode == 13){ Update_Evento(); }"/>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Hora&nbsp;(Evento):</label>
        </div>
        <div class="form-group col-md-4">
          <input class="form-control" id="hora_evento" name="hora_evento" placeholder= "Seleccione fecha" type="time" value="<?php echo $get_id[0]['hora_evento'] ?>" onkeypress="if(event.keyCode == 13){ Update_Evento(); }"/>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Activo&nbsp;de:</label>
        </div>
        <div class="form-group col-md-4">
          <input class="form-control date" id="fec_ini" name="fec_ini" placeholder= "Seleccione fecha" type="date" value="<?php echo $get_id[0]['fec_ini'] ?>" onkeypress="if(event.keyCode == 13){ Update_Evento(); }"/>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Hasta:</label>
        </div>
        <div class="form-group col-md-4">
          <input class="form-control date" id="fec_fin" name="fec_fin" placeholder= "Seleccione fecha" type="date" value="<?php echo $get_id[0]['fec_fin'] ?>" onkeypress="if(event.keyCode == 13){ Update_Evento(); }"/>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Empresa:</label>
        </div>
        <div class="form-group col-md-4">
          <select class="form-control" id="id_empresa" name="id_empresa" onchange="Sede();">
            <option value="0" <?php if(!(strcmp(0, $get_id[0]['id_empresa']))){ echo "selected=\"selected\""; } ?>>Seleccione</option>
            <?php foreach($list_empresa as $list){ ?>
              <option value="<?php echo $list['id_empresa']; ?>" <?php if(!(strcmp($list['id_empresa'],$get_id[0]['id_empresa']))){ echo "selected=\"selected\"";} ?>>
                <?php echo $list['cod_empresa']; ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Sede:</label>
        </div>
        <div id="select_sede" class="form-group col-md-4">
          <select class="form-control" id="id_sede" name="id_sede" onchange="Sede();">
            <option value="0" <?php if(!(strcmp(0, $get_id[0]['id_sede']))){ echo "selected=\"selected\""; } ?>>Seleccione</option>
            <?php foreach($list_sede as $list){ if($list['id_empresa']==$get_id[0]['id_empresa']){ ?>
              <option value="<?php echo $list['id_sede']; ?>" <?php if(!(strcmp($list['id_sede'],$get_id[0]['id_sede']))){ echo "selected=\"selected\"";} ?>>
                <?php echo $list['cod_sede']; ?>
              </option>
            <?php } } ?>
          </select>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Link:</label> 
        </div>
        <div id="div_link" class="form-group col-md-10">
          <select class="form-control" id="tipo_link" name="tipo_link">
              <option value="0" <?php if($get_id[0]['tipo_link']==0){ echo "selected"; } ?>>Seleccione</option>
              <option value="3" <?php if($get_id[0]['tipo_link']==3){ echo "selected"; } ?>>https://snappy.org.pe/<?php echo $get_id[0]['cod_empresa']; ?>0</option>
              <option value="1" <?php if($get_id[0]['tipo_link']==1){ echo "selected"; } ?>>https://snappy.org.pe/<?php echo $get_id[0]['cod_empresa']; ?>1</option>
              <option value="2" <?php if($get_id[0]['tipo_link']==2){ echo "selected"; } ?>>https://snappy.org.pe/<?php echo $get_id[0]['cod_empresa']; ?>2</option>
          </select>
          <!--<input name="link" type="text" maxlength="50" class="form-control" id="link" value="<?php echo $get_id[0]['link'] ?>" placeholder="Ingresar link" onkeypress="if(event.keyCode == 13){ Update_Evento(); }">-->
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Informe:</label>
          <br>
          <input type="checkbox" class="grande" id="informe" name="informe" value="1" <?php if($get_id[0]['informe']==1){ echo "checked"; } ?> onkeypress="if(event.keyCode == 13){ Update_Evento(); }">
        </div>

        <div class="form-group col-md-10">
          <label class="control-label text-bold">Enviar autorizaciones a solo estos usuarios:</label>
          <select class="form-control multivalue_update" id="autorizaciones" name="autorizaciones[]" multiple="multiple">
            <?php $base_array = explode(",",$get_id[0]['autorizaciones']);
              foreach($list_usuario as $list){ ?>
              <option value="<?php echo $list['id_usuario']; ?>" <?php if(in_array($list['id_usuario'],$base_array)){ echo "selected=\"selected\""; } ?>>
                <?php echo $list['usuario_codigo']; ?>
              </option>
            <?php } ?> 
          </select>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Objetivo:</label>
        </div>
        <div class="form-group col-md-4">
            <select class="form-control" name="id_objetivo" id="id_objetivo">
                <option value="0">Seleccione</option>
                <?php foreach($list_objetivo as $list){ ?>
                    <option value="<?php echo $list['id_objetivo']; ?>" <?php if($list['id_objetivo']==$get_id[0]['id_objetivo']){ echo "selected"; } ?>>
                      <?php echo $list['nom_objetivo']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Estado:</label>
        </div>
        <div class="form-group col-md-4">
            <select class="form-control" name="id_estadoe" id="id_estadoe">
                <option value="0" <?php if(!(strcmp(0, $get_id[0]['id_estadoe']))){ echo "selected=\"selected\""; } ?>>Seleccione</option>
                <?php foreach($list_estado as $list){ ?>
                    <option value="<?php echo $list['id_estadoe']; ?>" <?php if(!(strcmp($list['id_estadoe'],$get_id[0]['id_estadoe']))){ echo "selected=\"selected\"";} ?>>
                      <?php echo $list['nom_estadoe']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
          <label class="control-label text-bold">Observaciones:</label>
        </div>
        <div class="form-group col-md-12">
            <textarea name="obs_evento" rows="8" cols="80"  class="form-control" id="obs_evento" ><?php echo $get_id[0]['obs_evento'] ?></textarea>
            <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
        </div>                                          
  </div> 

  <div class="modal-footer">
    <input  type="hidden" name="id_evento" id="id_evento" value="<?php echo $get_id[0]['id_evento'] ?>">
    <button type="button" class="btn btn-primary" onclick="Update_Evento();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>

<script>
  var ss = $(".multivalue_update").select2({
    tags: true
  });

  $('.multivalue_update').select2({
    dropdownParent: $('#acceso_modal_mod')
  });

  function Sede(){
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
    
    var id_empresa = $("#id_empresa").val();
    var url = "<?php echo site_url(); ?>Administrador/Sede_Evento";
    $.ajax({
      url: url,
      type: 'POST',
      data: {'id_empresa':id_empresa},
      success: function(data){
        $('#select_sede').html(data);
        Link();
      }
    });
  }

  function Link(){
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
    
    var id_empresa = $("#id_empresa").val();
    var url = "<?php echo site_url(); ?>Administrador/Link_Evento";

    $.ajax({
      url: url,
      type: 'POST',
      data: {'id_empresa':id_empresa},
      success: function(data){
        $('#div_link').html(data);
      }
    });
  }

  function Update_Evento(){
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

    var tipo_excel = $("#tipo_excel").val();
    var dataString = new FormData(document.getElementById('formularioe_ev'));
    var url="<?php echo site_url(); ?>Administrador/Update_Evento";

    if (Editar_Evento()) {
      $.ajax({
        url: url,
        data:dataString,
        type:"POST",
        processData: false,
        contentType: false,
        success:function (data) {
          if(data=="error"){ 
            Swal({
                title: 'Actualización Denegada',
                text: "¡Ya hay un evento activo para ese Link!",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
          }else{
            Buscar(tipo_excel);
            $("#acceso_modal_mod .close").click()
          }
        }
      });
    }
  }

  function Editar_Evento() {
    if($('#nom_evento').val()=="") { 
      Swal(
          'Ups!',
          'Debe ingresar Nombre',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#fec_agenda').val()=="") { 
      Swal(
          'Ups!',
          'Debe ingresar Fecha (Evento).',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#fec_ini').val()=="") { 
      Swal(
          'Ups!',
          'Debe ingresar Fecha Inicio.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#fec_fin').val()=="") { 
      Swal(
          'Ups!',
          'Debe ingresar Fecha Fin.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_empresa').val()=="0") { 
      Swal(
          'Ups!',
          'Debe seleccionar Empresa.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_sede').val()=="0") {  
      Swal(
          'Ups!',
          'Debe seleccionar Sede.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_estadoe').val()=="1") { 
      if($('#tipo_link').val()=="0") { 
        Swal(
            'Ups!',
            'Debe seleccionar Link.',
            'warning'
        ).then(function() { });
        return false;
      }
    }
    if($('#id_estadoe').val()=="0") { 
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
