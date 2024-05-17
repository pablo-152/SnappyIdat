<style>
  .grande{
    width: 20px !important;
    height: 20px !important;
  }
</style>

<form class="formulario" id="formulario_ev" method="POST" enctype="multipart/form-data" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Evento (Nuevo)</b></h5>
  </div>

  <div class="modal-body" style="overflow:auto;">
    <div class="col-md-12 row">
      <div class="form-group col-md-2">
        <label class="control-label text-bold">Evento:</label>
      </div>
      <div class="form-group col-md-10">
        <input name="nom_evento" type="text" maxlength="35" class="form-control" id="nom_evento" placeholder="Ingresar evento" onkeypress="if(event.keyCode == 13){ Insert_Evento(); }"> 
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Fecha(Evento):</label>
      </div>
      <div class="form-group col-md-4">
        <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" onkeypress="if(event.keyCode == 13){ Insert_Evento(); }" />
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Hora(Evento):</label>
      </div>
      <div class="form-group col-md-4">
        <input class="form-control" id="hora_evento" name="hora_evento" placeholder= "Seleccione fecha" type="time" value="<?php echo date('H:i');?>" onkeypress="if(event.keyCode == 13){ Insert_Evento(); }" />
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Activo de:</label>
      </div>
      <div class="form-group col-md-4">
        <input class="form-control date" id="fec_ini" name="fec_ini" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" onkeypress="if(event.keyCode == 13){ Insert_Evento(); }" />
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Hasta:</label>
      </div>
      <div class="form-group col-md-4">
        <input class="form-control date" id="fec_fin" name="fec_fin" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" onkeypress="if(event.keyCode == 13){ Insert_Evento(); }" />
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Empresa:</label>
      </div>
      <div class="form-group col-md-4">
        <select class="form-control" id="id_empresa" name="id_empresa" onchange="Sede();">
          <option value="0">Seleccione</option>
          <?php foreach($list_empresa as $list){ ?>
            <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Sede:</label>
      </div>
      <div id="select_sede" class="form-group col-md-4">
        <select class="form-control" id="id_sede" name="id_sede">
          <option value="0">Seleccione</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Link:</label>
      </div>
      <div id="div_link" class="form-group col-md-10">
        <select class="form-control" id="tipo_link" name="tipo_link">
          <option value="0">Seleccione</option>
        </select>
        <!--<input name="link" type="text" maxlength="50" class="form-control" id="link" placeholder="Ingresar link" onkeypress="if(event.keyCode == 13){ Insert_Evento(); }">-->
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Informe:</label>
        <br>
        <input type="checkbox" class="grande" id="informe" name="informe" value="1" onkeypress="if(event.keyCode == 13){ Insert_Evento(); }">
      </div>

      <div class="form-group col-md-10">
        <label class="control-label text-bold">Enviar autorizaciones a solo estos usuarios:</label>
        <select class="form-control multivalue" id="autorizaciones" name="autorizaciones[]" multiple="multiple">
          <?php foreach($list_usuario as $list){ ?>
            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
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
                  <option value="<?php echo $list['id_objetivo']; ?>">
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
              <option value="0">Seleccione</option>
              <?php foreach($list_estado as $list){ ?>
                  <option value="<?php echo $list['id_estadoe']; ?>" <?php if($list['id_estadoe']==1){ echo "selected"; } ?>>
                    <?php echo $list['nom_estadoe']; ?>
                  </option>
              <?php } ?>
          </select>
      </div>

      <div class="form-group col-md-12">
        <label class="control-label text-bold">Observaciones:</label>
      </div>
      <div class="form-group col-md-12">
        <textarea name="obs_evento" rows="8" class="form-control" id="obs_evento"></textarea>
        <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="Insert_Evento();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>
    
<script>
  var ss = $(".multivalue").select2({
    tags: true
  });

  $('.multivalue').select2({
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

  function Insert_Evento(){
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
    var dataString = new FormData(document.getElementById('formulario_ev'));
    var url="<?php echo site_url(); ?>Administrador/Insert_Evento";

    if (NuevoEvento()) {
      $.ajax({
        url: url,
        data:dataString,
        type:"POST",
        processData: false,
        contentType: false,
        success:function (data) {
          if(data=="error"){ 
            Swal({
                title: 'Registro Denegado',
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

  function NuevoEvento() {
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



   




