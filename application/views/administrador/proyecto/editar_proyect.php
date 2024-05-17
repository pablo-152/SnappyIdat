<form id="from_proy" method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <h3 class="tile-title">Edición de Datos del Proyecto con <b>Código <?php echo $get_id[0]['cod_proyecto'];?></b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>

  <div class="modal-body" style="max-height:450px; overflow:auto;">
    <div class="col-md-12 row">
      <div class="form-group col-md-4">
        <label class="text-bold">Solicitado Por:</label>
          <select class="form-control" name="id_solicitante" id="id_solicitante">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_solicitante']))) { echo "selected=\"selected\""; } ?>>Seleccione</option>
              <?php foreach ($solicitado as $list) { ?>
                <option value="<?php echo $list['id_usuario']; ?>" <?php if (!(strcmp($list['id_usuario'], $get_id[0]['id_solicitante']))) { echo "selected=\"selected\""; } ?>>
                  <?php echo $list['usuario_codigo']; ?>
                </option>
              <?php } ?>
          </select>
      </div>

      <div class="form-group col-md-4">
        <label class="text-bold">Fecha:</label>
        <div class="col">
          <input type="date" class="form-control" value="<?php echo $get_id[0]['fecha']; ?>" disabled>
        </div>
      </div>
    </div>

    <div class="col-md-12 row">
      <!--ANTES-->
      <!--<div class=" form-group col-md-6" id="mempresa">
          <label class="text-bold" >Empresas:&nbsp;&nbsp;&nbsp;</label>
          <div class="col">
            <?php foreach($list_empresa as $list){ ?>
                <label>
                    <input type="checkbox" id="id_empresa" name="id_empresa[]" value="<?php echo $list['id_empresa']; ?>" <?php foreach($get_empresa as $empresa){ if($empresa['id_empresa']==$list['id_empresa']){ echo "checked"; } } ?>
                    <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
                </label>
            <?php } ?>
          </div>
      </div>-->

      <!--AHORA-->
      <div class="form-group col-md-4">
        <label class="control-label text-bold label_tabla">Empresa:</label>
        <select name="id_empresa" id="id_empresa" class="form-control" onchange="Empresa();">
          <option value="0">Seleccione</option>
          <?php foreach($list_empresa as $list){ ?>
              <option value="<?php echo $list['id_empresa']; ?>" <?php  if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; }  ?>>
                <?php echo $list['cod_empresa']; ?>
              </option>
          <?php } ?>
        </select>
      </div>
      
      <div id="div_sedes" class="form-group col-md-8" style="display:none">
        <?php if($get_id[0]['id_empresa']!=0){ ?>
          <label class="text-bold" >Sedes:&nbsp;&nbsp;&nbsp;</label>
          <div class="col">
            <?php foreach($list_sede as $list){ ?>
                <label>
                    <input type="checkbox" id="id_sede[]" name="id_sede[]" value="<?php echo $list['id_sede']; ?>" <?php foreach($get_sede as $sede){ if($sede['id_sede']==$list['id_sede']){ echo "checked"; } } ?> class="check_sede">
                    <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
                </label>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>

    <div class="col-md-12 row">
      <div class="form-group col-md-3">
        <label class="text-bold">Tipo:</label>
        <div class="col">
          <select  name="id_tipo" id="id_tipo" class="form-control" style="width: 100%;" onchange="Tipo()">
              <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_tipo']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
              <?php foreach($row_t as $nivel){ ?>
                  <option value="<?php echo $nivel['id_tipo']; ?>" <?php if (!(strcmp($nivel['id_tipo'], $get_id[0]['id_tipo']))){ echo "selected=\"selected\"";} ?>><?php echo $nivel['nom_tipo']; ?></option>
              <?php } ?>
          </select>
        </div>
        
      </div>

      <div class="form-group col-md-4" id="cmb_subtipo">
        <label class="text-bold">Sub-Tipo:</label>
        <input type="hidden" id="subtipobd" name="subtipobd" value="<?php echo $get_id[0]['id_subtipo']; ?>">
        <div class="col">
          <select  name="id_subtipo" id="id_subtipo" class="form-control" onchange="Cambio_Week()">
            <option  value=""  selected>Seleccione</option>
            <?php foreach($sub_tipo as $sub){
            if($get_id[0]['id_subtipo'] == $sub['id_subtipo']){ ?> 
            <option selected value="<?php echo $sub['id_subtipo']; ?>"><?php echo $sub['nom_subtipo'];?></option>
            <?php }else{?>
              <option value="<?php echo $sub['id_subtipo']; ?>"><?php echo $sub['nom_subtipo'];?></option>
            <?php } } ?>
          </select>
        </div>
        
      </div>

      <div class="form-group col-md-2" id="msaters">
        <label class="text-bold">Snappy Artes:</label>
        <div class="col">
          <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Artes"   value="<?php echo $get_id[0]['s_artes']; ?>" readonly>
        </div>
      </div>

      <div class="form-group col-md-2" id="msredes">
        <label class="text-bold">Snappy Redes:</label>
        <div class="col">
          <input name="s_redes" type="number" class="form-control" id="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Redes" value="<?php echo $get_id[0]['s_redes']; ?>" readonly>
        </div>
      </div>
    </div>
      
    <div class="col-md-12 row">
      <div class="form-group col-md-3">
        <label class="text-bold">Prioridad:</label>
        <div class="col">
          <select class="form-control" name="prioridad" id="prioridad">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
            <option value="1" <?php if (!(strcmp(1, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>1</option>
            <option value="2" <?php if (!(strcmp(2, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>2</option>
            <option value="3" <?php if (!(strcmp(3, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>3</option>
            <option value="4" <?php if (!(strcmp(4, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>4</option>
            <option value="5" <?php if (!(strcmp(5, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>5</option>
          </select>
        </div>
      </div>

      <div class="form-group col-md-6">
        <label class="text-bold">Descripción:</label>
        <div class="col">
          <input name="descripcion" type="text" maxlength="50" class="form-control" id="descripcion" value="<?php echo $get_id[0]['descripcion'] ?>">
        </div>
        
      </div>

      <div id="div_fecha_agenda" class="form-group col-md-3">
        <label class="text-bold">Agenda / Redes:</label>
        <div class="col">
          <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha" type="date" value="<?php echo $get_id[0]['fec_agenda']; ?>" />
        </div>
      </div>
    </div>

    <?php if($get_id[0]['id_tipo']==15 || $get_id[0]['id_tipo']==34){?>
      <div class="form-group col-md-4">
        <button class="btn " style="background-color:green;color:white" type="button" title="Duplicar" data-toggle="modal" data-target="#acceso_modal_eli" app_crear_eli="<?= site_url('Administrador/Modal_Duplicar') ?>/<?php echo $get_id[0]['id_proyecto'] ?>/<?php echo $get_id[0]['id_tipo'] ?>">Duplicar</button>
      </div>
      <div class="col">
      
      </div>
    <?php }?>
      
    <div class="form-group col-md-12" id="div_duplicados">
        <?php if(count($list_duplicado)>0){?>
        <table id="example" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr align="center" style="background-color: #E5E5E5;">
              <th align="center">Inicio</th>
              <th align="center">Snappy Redes</th>
              <th align="center">&nbsp;</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($list_duplicado as $list) {  ?>
              <tr class="even pointer">
                <td  align="center" ><?php echo $list['fecha_inicio']; ?></td>
                <td  align="center" ><?php echo $list['snappy_redes']; ?></td>
                <td  align="center" >
                <img title="Eliminar" onclick="Delete_Duplicado('<?php echo $list['inicio']; ?>','<?php echo $list['snappy_redes']; ?>','<?php echo $list['cod_proyecto']; ?>','<?php echo $get_id[0]['id_proyecto'] ?>')" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php }?>
    </div>

    <div class=" form-group col-md-12" style="background-color:#C9C9C9;">
      <div class="row">
        <div class="col-md-4">
          <label class="text-bold">Status:</label>
          <div class="col">
            <select class="form-control" name="status" id="status" onchange="muestradiv();">
              <option value="0"<?php if (!(strcmp(0, $get_id[0]['status']))){echo "selected=\"selected\"";} ?>>Seleccione</option>
              <?php
              $total = count($row_s);
              foreach($row_s as $row_s){ ?>
              <option value="<?php echo $row_s['id_statusp']?>" <?php if (!(strcmp($row_s['id_statusp'], $get_id[0]['status']))) {echo "selected=\"selected\"";} ?>><?php echo $row_s['nom_statusp']?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-4" id="pendiente" <?php if($get_id[0]['status']==4){ ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>>
          <label class="text-bold">De:</label>
          <div class="col">
            <select class="form-control" name="id_userpr" id="id_userpr">
              <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_userpr']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                <?php foreach($usuario_subtipo as $row_c1){ ?>
              <option value="<?php echo $row_c1['id_usuario']?>" <?php if (!(strcmp($row_c1['id_usuario'], $get_id[0]['id_userpr']))) {echo "selected=\"selected\"";} ?>><?php echo $row_c1['usuario_codigo']?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <label class="text-bold">Colaborador:</label>
          <div class="col">
            <select class="form-control" name="id_asignado" id="id_asignado">
              <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_solicitante']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
              <?php foreach($usuario_subtipo1 as $row_c){ ?>
              <option value="<?php echo $row_c['id_usuario']?>" <?php if (!(strcmp($row_c['id_usuario'], $get_id[0]['id_asignado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_c['usuario_codigo']?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <?php if ($get_id[0]['status']==5) { ?>
          <div class="col-md-4" id="fecha">
            <label class="text-bold">Fecha:</label>
            <div class="col">
              <?php 
                if ($get_id[0]['fec_termino']!='0000-00-00 00:00:00') 
                {
                    echo date('d/m/Y', strtotime($get_id[0]['fec_termino']));
                } 
                else { echo date('d/m/Y'); }; ?>
            </div>
          </div>

          <div class="col-md-4" id="imagen">
            <label class="text-bold">Archivo:</label>
            <div class="col">
              <input class="form-control" name="foto" type="file" id="foto" accept=".png, .jpg, .jpeg, .pdf">
            </div>  
          </div>
          <?php } else { ?>
          <div class="col-md-3" id="fecha">
            <label class="text-bold">Fecha:</label>
            <div class="col">
              <?php  if ($get_id[0]['fec_termino']!='0000-00-00 00:00:00') 
                {
                    echo date('d/m/Y H:i:s', strtotime($get_id[0]['fec_termino']));
                } 
                else { echo date('d/m/Y'); }; ?>
            </div>
          </div>
          
          <div class="col-md-4" id="imagen">
            <label class="text-bold">Archivo:</label>
            <div class="col">
              <input class="form-control" name="foto" type="file" id="foto" accept=".png, .jpg, .jpeg, .pdf">
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <div class="form-group col-md-12">
      <label class="control-label text-bold">Observaciones:</label>
      <div class="col">
        <textarea name="proy_obs" rows="8" class="form-control" id="proy_obs" ><?php echo $get_id[0]['proy_obs']?></textarea>
        <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
      </div>
    </div>
 
    <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_nivel']==4 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
      <div class="form-group col-md-2">
        <label class="control-label text-bold">Hora:</label>
        <div class="col">
          <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $get_id[0]['hora']; ?>">
        </div>
      </div>

      <div class="form-group col-md-12">
        <label class="control-label text-bold">Copy:</label>
        <div class="col">
          <textarea name="copy" rows="8" class="form-control" id="copy" placeholder="Copy"><?php echo $get_id[0]['copy']?></textarea>
        </div>
      </div>
    <?php } ?>
  </div> 

  <div class="modal-footer">
    <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $get_id[0]['id_proyecto'] ?>">
    <input type="hidden" id="fec_agenda_hidden" name="fec_agenda_hidden" value="<?php echo $get_id[0]['fec_agenda']; ?>">
    <button type="button" class="btn btn-primary" onclick="Update_Proyecto()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>

<script type="text/javascript" src="<?= base_url() ?>template/docs/js/plugins/select2.min.js"></script>

<script>
  document.querySelector("#id_solicitante").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;

     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#id_empresa").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#id_tipo").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#id_subtipo").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#prioridad").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#descripcion").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#fec_agenda").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#status").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#id_userpr").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#id_asignado").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  document.querySelector("#proy_obs").addEventListener("keypress", function (e) {
     var key = e.which || e.keyCode;
     if (key == 13) { 
         Update_Proyecto();
     }
  })
  
  $(document).ready(function() {
    var fec_agenda_hidden = $("#fec_agenda_hidden").val();
    if(fec_agenda_hidden=="0000-00-00"){
      $('#div_fecha_agenda').hide();
    }else{
      $('#div_fecha_agenda').show();
    }

    var id_tipo = $("#id_tipo").val();
    var div3 = document.getElementById("div_sedes");
    if(id_tipo==15 || id_tipo==34){
      div3.style.display = "none";
    }else{
      div3.style.display = "block";
    }
  });

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
    //ANTES
    /*var url2 = "<?php echo site_url(); ?>Administrador/subtipo_xtipo";
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
    }

    var url = "<?php echo site_url(); ?>Administrador/Refresca_Empresa";
    $.ajax({
      url: url,
      type: 'POST',
      success: function(data) {
        $('#mempresa').html(data);
      }
    });*/

    //AHORA
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
    var div3 = document.getElementById("div_sedes");
    
    if(id_tipo == 15 || id_tipo == 34){
      $('#div_sedes').html('');
      div3.style.display = "none";
    }else{
      div3.style.display = "block";

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

  function Empresa(id){
    //ANTES
    /*var id_tipo = $("#id_tipo").val();

    if(id_tipo == 15 || id_tipo == 34){
      $(".check_empresa").prop('checked',false);
      $(id).prop('checked',true);
    }else{
      var div3 = document.getElementById("div_sedes");
      div3.style.display = "block";
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
    }*/

    //AHORA
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
    if(id_tipo == 15 || id_tipo == 34){
      $('#div_fecha_agenda').show();
      var d = new Date();
      var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
      $("#fec_agenda").val(strDate);
    }else{
      $('#div_fecha_agenda').hide();
      $("#fec_agenda").val('');
    }
  }

  function muestradiv(){
    var status=document.getElementById("status").value;
    var pendiente = document.getElementById("pendiente");

    if(status==4){
      pendiente.style.display = "block";
    }else {
      pendiente.style.display = "none";
    }
  }
</script>

<script>
  function Update_Proyecto(){
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

      var id_proyecto = $("#id_proyecto").val();

      var dataString = new FormData(document.getElementById('from_proy'));
      var url="<?php echo site_url(); ?>Administrador/update_proyecto";

      if (proyecto()) {
          $.ajax({
              url: url,
              data:dataString,
              type:"POST",
              processData: false,
              contentType: false,
              success:function (data) {
                  swal.fire(
                      'Actualización Exitosa!',
                      'Haga clic en el botón!',
                      'success'
                  ).then(function() {
                      window.location = "<?php echo site_url(); ?>Administrador/Detalle_Proyecto/"+id_proyecto;
                  });
              }
          });
      }
  }

  function proyecto() {
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
    /*if (contador_empresa == 0) {
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
    }*/
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
    if ($('#id_tipo').val() === "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Tipo.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#id_subtipo').val() === "" && $('#subtipobd').val() === "0") {
      Swal(
        'Ups!',
        'Debe seleccionar Subtipo.',
        'warning'
      ).then(function() {});
      return false;
    }
    if ($('#prioridad').val() === "0") {
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

  function Agregar_Duplicado(){
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

      var dataString = new FormData(document.getElementById('formulario_dupli'));
      var url="<?php echo site_url(); ?>Administrador/Agregar_Duplicado";

      if (Valida_Duplicado()) {
          $.ajax({
              url: url,
              data:dataString,
              type:"POST",
              processData: false,
              contentType: false,
              success:function (data) {
                  swal.fire(
                      'Registro Exitoso!',
                      'Haga clic en el botón!',
                      'success'
                  ).then(function() {
                        var dataString1 = new FormData(document.getElementById('formulario_dupli'));
                        var url1="<?php echo site_url(); ?>Administrador/List_Duplicados";

                        $.ajax({    
                            type:"POST",
                            data:dataString1,
                            url:url1,
                            processData: false,
                            contentType: false,

                            success:function (resp) {
                                $('#div_duplicados').html(resp);
                                $("#acceso_modal_eli .close").click()

                            }
                        });
                  });
              }
          });
      }
  }

  function Valida_Duplicado(){
    
      if($('#s_redesd').val().trim()===""){
        Swal(
            'Ups!',
            'Debe ingresar Week Snappy Redes.',
            'warning'
        ).then(function() { });
        return false;
      }
      if($('#fec_agendad').val().trim()===""){
        Swal(
            'Ups!',
            'Debe ingresar Fecha Agenda.',
            'warning'
        ).then(function() { });
        return false;
      }
    
    return true;
  }

  function Delete_Duplicado(inicio,s_redes,cod_p,id){
        
        var fec_inicio = inicio;
        var snappy_redes = s_redes;
        var cod_proyecto = cod_p;
        var id_proyecto = id;
        var url="<?php echo site_url(); ?>Administrador/Delete_Duplicado";
        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: {'fec_inicio':fec_inicio,'snappy_redes':snappy_redes,'cod_proyecto':cod_proyecto},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                          
                          var url1="<?php echo site_url(); ?>Administrador/List_Duplicados";

                          $.ajax({    
                              type:"POST",
                              data:{'id_proyecto':id_proyecto},
                              url:url1,

                              success:function (resp) {
                                  $('#div_duplicados').html(resp);
                                  $("#acceso_modal_eli .close").click()

                              }
                          });
                        });
                    }
                });
            }
        })
  }
</script>

