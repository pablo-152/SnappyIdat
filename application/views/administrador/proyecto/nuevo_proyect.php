<div class="modal-content">
  <form id="from_proy" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
      <h3 class="tile-title"><b>Nuevo proyecto</b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
      <div class="col-md-12 row">
        <div class="form-group col-md-4">
          <label class="text-bold">Solicitado Por:</label>
          <div class="col">
            <select name="id_solicitante" id="id_solicitante" Class="form-control">
              <option value="0">Seleccione</option>
              <?php foreach ($solicitado as $row_p) { ?>
                <option value="<?php echo $row_p['id_usuario']; ?>"><?php echo $row_p['usuario_codigo']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group col-md-4">
          <label class="text-bold">Fecha:</label>
          <div class="col">
            <?php echo date('d/m/Y'); ?>
          </div>
        </div>
      </div>

      <!--<div id="lblempresa" class="form-group col-md-8">
        <label id="etiqueta_empresa" class="text-bold">Empresas:&nbsp;&nbsp;&nbsp;</label>
      </div>-->

      <div class="col-md-12 row">
        <div class="form-group col-md-8" id="mempresa">
          <label id="etiqueta_empresa" class="text-bold">Empresas:&nbsp;&nbsp;&nbsp;</label>

          <?php foreach ($list_empresa as $list) { ?>
            <label class="col">
              <input type="checkbox" id="id_empresa" name="id_empresa[]" value="<?php echo $list['id_empresa']; ?>" class="check_empresa" onchange="Empresa(this)">
              <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
            </label>
          <?php } ?>
        </div>

        <div id="div_sedes" class="form-group col-md-4">
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-3">
          <label class="text-bold">Tipo:</label>
          <div class="col">
            <select name="id_tipo" id="id_tipo" Class="form-control" onchange="Tipo();">
              <option value="0">Seleccione</option>
              <?php foreach ($row_t as $row_t) { ?>
                <option value="<?php echo $row_t['id_tipo']; ?>"><?php echo $row_t['nom_tipo']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group col-md-3" id="cmb_subtipo">
          <label class="text-bold">Sub-Tipo:</label>
          <div class="col">
            <select name="id_subtipo" id="id_subtipo" value="0" class="form-control" onchange="Cambio_Week();">
              <option value="0">Seleccione</option>
            </select>
          </div>
        </div>

        <div class="form-group col-md-3" id="msaters">
          <label class=" text-bold">Week Snappy Artes:</label>
          <div class="col">
            <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes">
          </div>
        </div>

        <div class="form-group col-md-3" id="msredes">
          <label class="text-bold">Week Snappy Redes:</label><!-- tipo_subtipo_arte-->
          <div class="col">
            <input name="s_redes" type="number" class="form-control" id="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Redes">
          </div>
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-3">
          <label class="text-bold">Prioridad:</label>
          <div class="col">
            <select class="form-control" name="prioridad" id="prioridad">
              <option value="0">Seleccione</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
        </div>

        <div class="form-group col-md-6">
          <label class="text-bold">Descripción:</label>
          <div class="col">
            <input name="descripcion" type="text" maxlength="50" class="form-control" id="descripcion" placeholder="Ingresar descripción">
          </div>
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Agenda / Redes:</label>
          <div class="col">
            <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder="Seleccione fecha" type="date" value="<?php echo date('d/m/Y'); ?>" />
          </div>
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="control-label text-bold">Observaciones:</label>
        <div class="col">
          <textarea name="proy_obs" rows="8" class="form-control" id="proy_obs"></textarea>
          <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="Insert_Proyecto()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;

      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
    </div>
  </form>
</div>

<script type="text/javascript" src="<?= base_url() ?>template/docs/js/plugins/select2.min.js"></script>

<script>
  function Cambio_Week() {
    var url = "<?php echo site_url(); ?>Administrador/Cambio_Week_Arte";
    var dataString = $("#from_proy").serialize();

    $.ajax({
      url: url,
      type: 'POST',
      data: dataString,
      success: function(data) {
        $('#msaters').html(data);
      }
    });

    var url2 = "<?php echo site_url(); ?>Administrador/Cambio_Week_Red";
    var dataString2 = $("#from_proy").serialize();

    $.ajax({
      url: url2,
      type: 'POST',
      data: dataString2,
      success: function(data) {
        $('#msredes').html(data);
      }
    });
  }

  function Tipo(){
    var url2 = "<?php echo site_url(); ?>Administrador/subtipo_xtipo";
    var dataString2 = $("#from_proy").serialize();

    $.ajax({
      url: url2,
      type: 'POST',
      data: dataString2,
      success: function(data) {
        $('#cmb_subtipo').html(data);
      }
    });

    Cambio_Week();

    var id_tipo = $("#id_tipo").val();

    if(id_tipo == 15 || id_tipo == 34){
      $('#div_sedes').html('');

      var url = "<?php echo site_url(); ?>Administrador/Refresca_Empresa";
      $.ajax({
        url: url,
        type: 'POST',
        success: function(data) {
          $('#mempresa').html(data);
        }
      });
    }
  }

  function Empresa(id){
    var id_tipo = $("#id_tipo").val();

    if(id_tipo == 15 || id_tipo == 34){
      $(".check_empresa").prop('checked',false);
      $(id).prop('checked',true);
    }else{
      var url = "<?php echo site_url(); ?>Administrador/Empresa_Sede";
      var dataString = $("#from_proy").serialize();

      $.ajax({
        url: url,
        type: 'POST',
        data: dataString,
        success: function(data) {
          $('#div_sedes').html(data);
        }
      });
    }
  }
</script>

<script>
  function Insert_Proyecto() {
    $(document)
    .ajaxStart(function() {
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
    .ajaxStop(function() {
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

    var dataString = $("#from_proy").serialize();
    var url = "<?php echo site_url(); ?>Administrador/insert_proyecto";

    if (nuevo()) {
      $.ajax({
        type: "POST",
        url: url,
        data: dataString,
        success: function(data) {
          swal.fire(
            'Tu proyecto se ha grabado correctamente con el código',
            data,
            'success'
          ).then(function() {
            window.location = "<?php echo site_url(); ?>Administrador/proyectos";
          });
        }
      });
    }
  }

  function nuevo() {
    var contador_empresa = 0;
    $(".check_empresa").each(function() {
      if ($(this).is(":checked"))
        contador_empresa++;
    });
    var contador_sede = 0;
    $(".check_sede").each(function() {
      if ($(this).is(":checked"))
        contador_sede++;
    });

    if ($('#id_solicitante').val() == "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Solicitante.',
        'warning'
      ).then(function() {});
      return false;
    }
    if (contador_empresa == 0) {
      Swal(
        'Ups!',
        'Debe seleccionar Empresa.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#id_tipo').val() == 15 || $('#id_tipo').val() == 34) {
      if (contador_empresa != 1) {
        Swal(
          'Ups!',
          'Solo debe seleccionar una empresa.',
          'warning'
        ).then(function() {});
        return false;
      }
    }
    if ($('#id_tipo').val() != "15" && $('#id_tipo').val() != "34") {
      if (contador_sede == 0) {
        Swal(
          'Ups!',
          'Debe seleccionar Sede.',
          'warning'
        ).then(function() {});
        return false;
      }
    }
    if ($('#id_tipo').val() == "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Tipo.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#id_subtipo').val() == "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Subtipo.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#prioridad').val() == "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Prioridad.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#descripcion').val() == "") {
      Swal(
        'Ups!',
        'Debe ingresar Descripción.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#id_tipo').val() == 15 || $('#id_tipo').val() == 34) {
      if ($('#fec_agenda').val() == "") {
        Swal(
          'Ups!',
          'Debe ingresar Agenda/Redes.',
          'warning'
        ).then(function() {});
        return false;
      }
    }
    return true;
  }
</script>