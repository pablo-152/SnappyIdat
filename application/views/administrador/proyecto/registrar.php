<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>

<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Proyecto (Nuevo)</b></span></h4>
        </div>
      </div>
    </div>
  </div>


  <div class="container-fluid">
    <form id="from_proy" method="POST" enctype="multipart/form-data" class="formulario">
      <div class="col-md-12 row">
        <?php if($id_nivel==2 ||$id_nivel==6){ ?>
          <div class="form-group col-md-2">
            <label class="control-label text-bold label_tabla">Solicitado por:</label>
            <select class="form-control" name="id_solicitante" id="id_solicitante">
              <option value="0">Seleccione</option>
                <?php foreach ($solicitado as $list) { ?>
                  <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$id_usuario){ echo "selected"; } ?>>
                    <?php echo $list['usuario_codigo']; ?>
                  </option>
                <?php } ?>
            </select>
          </div>
        <?php }else{ ?>
          <div class="form-group col-md-2">
            <label class="control-label text-bold label_tabla">Solicitado por:</label>
            <select class="form-control" disabled>
              <option value="0">Seleccione</option>
                <?php foreach ($solicitado as $list) { ?>
                  <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$id_usuario){ echo "selected"; } ?>>
                    <?php echo $list['usuario_codigo']; ?>
                  </option>
                <?php } ?>
            </select>

            <input type="hidden" name="id_solicitante" id="id_solicitante" value="<?php echo $id_usuario; ?>">
          </div>
        <?php } ?>

        <div class="form-group col-md-2">
          <label class="control-label text-bold label_tabla">Fecha:</label>
          <div class="col">
            <?php echo date('d-m-Y'); ?>
          </div>
        </div>

        <div class="form-group col-md-1">
          <label class="control-label text-bold label_tabla">Empresa:</label>
          <select name="id_empresa" id="id_empresa" class="form-control" onchange="Empresa();">
            <option value="0">Seleccione</option>
            <?php foreach($list_empresas as $list){ ?>
                <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div id="div_sedes" class="form-group col-md-7">
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-2">
          <label class="control-label text-bold label_tabla">Tipo:</label>
          <select name="id_tipo" id="id_tipo" class="form-control" onchange="Tipo();">
            <option value="0">Seleccione</option>
            <?php foreach($list_tipo as $list){ ?>
                <option value="<?php echo $list['id_tipo']; ?>"><?php echo $list['nom_tipo']; ?></option>
            <?php } ?>
          </select>
        </div>
        
        <div class="form-group col-md-2" id="cmb_subtipo">
          <label class="control-label text-bold label_tabla">Sub-Tipo:</label>
          <select name="id_subtipo" id="id_subtipo" class="form-control"  onchange="Cambio_Week();">
            <option value="0">Seleccione</option>
          </select>
        </div>

        <div class="form-group col-md-1" id="msaters">
          <label class="control-label text-bold label_tabla" title="Snappy Artes">S.&nbsp;Artes:</label>
          <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Artes" <?php if($id_usuario==1 || $id_usuario==34){ echo "";} else{echo "readonly";}?>>
        </div>

        <div class="form-group col-md-1" id="msredes">
          <label class="control-label text-bold label_tabla" title="Snappy Redes">S.&nbsp;Redes:</label>
          <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Redes" <?php if($id_usuario==1 || $id_usuario==34){ echo "";} else{echo "readonly";}?>>
        </div>
        

        <div class="form-group col-md-1">
          <label class="control-label text-bold label_tabla">Prioridad:</label>
          <select class="form-control" name="prioridad" id="prioridad">
            <option value="0">Seleccione</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </div>
      
        <div class="form-group col-md-5">
          <label class="control-label text-bold label_tabla">Descripción:</label>
          <input name="descripcion" type="text" maxlength="50" class="form-control" id="descripcion" placeholder="Descripción" onkeypress="if(event.keyCode == 13){ Insert_Proyecto(); }">
        </div>
      </div>

      <div class="col-md-12 row">
        <div id="div_fecha_agenda" class="form-group col-md-2">
          <label class="control-label text-bold label_tabla">Agenda / Redes:</label>
          <input class="form-control date" id="fec_agenda" name="fec_agenda" type="date" value="<?php echo date('Y-m-d'); ?>" onkeypress="if(event.keyCode == 13){ Insert_Proyecto(); }" />
        </div>
      </div>

      <div class="col-md-12 row">
        <div class="form-group col-md-12">
          <label class="control-label text-bold">Observaciones:</label>
          <textarea name="proy_obs" rows="5" class="form-control" id="proy_obs" placeholder="Observaciones"></textarea>
          <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
        </div>
      </div>

      <div class="form-group col-md-12" id="divcopy" style="display:none">
          <label class="control-label text-bold">Copy:</label>
          <div class="col">
            <textarea name="copy" rows="3" class="form-control" id="copy" placeholder="Copy"></textarea>
          </div>
      </div>

      <div class="modal-footer">
        <input type="hidden" id="fec_actual" value="<?php echo date('Y-m-d'); ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Proyecto()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <?php if ($id_nivel==1 ||$id_nivel==6){ ?>
            <!-- Administrador-->
            <a type="button" class="btn btn-default" href="<?= site_url('Administrador/proyectos') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
        <?php }elseif ($id_nivel==2 ||$id_nivel==4){ ?>
          <!-- TEAMLEADER-->
          <a type="button" class="btn btn-default" href="<?= site_url('Teamleader/proyectos') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
        <?php } ?>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#comunicacion").addClass('active');
    $("#hcomunicacion").attr('aria-expanded', 'true');
    $("#proyectos").addClass('active');
    document.getElementById("rcomunicacion").style.display = "block";
    $('#div_fecha_agenda').hide();
  });
</script>

<?php $this->load->view('Admin/footer'); ?>

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
    Fecha_Agenda();

    var url = "<?php echo site_url(); ?>Administrador/subtipo_xtipo";
    var dataString = $("#from_proy").serialize();

    $.ajax({
      url: url,
      type: 'POST',
      data: dataString,
      success: function(data) {
        $('#cmb_subtipo').html(data);
      }
    });

    Cambio_Week();

    var id_tipo = $("#id_tipo").val();
    
    if(id_tipo == 15 || id_tipo == 20 || id_tipo == 34){
      $('#div_sedes').html('');
      $('#divcopy').show();
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
      $("#copy").val('')
      $('#divcopy').hide();
    }
  }

  function Empresa(){
    Cargando();

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

    Tipo();
  }

  function Fecha_Agenda(){
    var id_tipo = $("#id_tipo").val();
    if(id_tipo == 15 || id_tipo == 20 || id_tipo == 34 || id_tipo == 22){
      $('#div_fecha_agenda').show();
      var d = new Date();
      var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
      $("#fec_agenda").val(strDate);
    }else{
      $('#div_fecha_agenda').hide();
      $("#fec_agenda").val('');
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
      var id_tipo = $("#id_tipo").val();
      var fec_agenda = $("#fec_agenda").val();
      var fec_actual = $("#fec_actual").val();

      if(id_tipo==15 || id_tipo==20 || id_tipo==34){
        if(fec_agenda==fec_actual){
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
        }else{
          Swal({
              title: '¿Desea registrar de todos modos?',
              text: "Estas poniendo una fecha anterior a la de hoy. Estas seguro?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si',
              cancelButtonText: 'No',
          }).then((result) => {
              if (result.value) {
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
          })
        }
      }else{
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
  }

  function nuevo() {
    /*var contador_empresa = 0;
    $(".check_empresa").each(function() {
      if ($(this).is(":checked"))
        contador_empresa++;
    });*/
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
    if ($('#id_empresa').val() == "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Empresa.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#id_tipo').val() != "15" && $('#id_tipo').val() != "20" && $('#id_tipo').val() != "34") {
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
    if ($('#id_tipo').val() == 15 || $('#id_tipo').val() == 20 || $('#id_tipo').val() == 34) {
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