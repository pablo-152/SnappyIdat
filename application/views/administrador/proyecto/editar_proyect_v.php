<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<style>
  .img-presentation-small-actualizar {
    width: 100%;
    height: 200px;
    object-fit: cover;
    cursor: pointer;
    margin: 5px;
  }

  .img-presentation-small-actualizar_support {
    width: 100%;
    height: 150px;
    object-fit: cover;
    cursor: pointer;
    margin: 5px;
  }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Edición <?php echo $get_id[0]['cod_proyecto'];?></b></span></h4>
                </div>

                <div class="heading-elements">
                  <div class="heading-btn-group">
                    <a type="button" href="<?= site_url('Administrador/Detalle_Proyecto') ?>/<?php echo $get_id[0]['id_proyecto']; ?>">
                      <img src="<?= base_url() ?>template/img/icono-regresar.png">
                    </a>
                  </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
      <form id="from_proy" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $get_id[0]['id_proyecto'] ?>">

        <div class="col-md-12 row">
          <div class="form-group col-md-2">
            <label class="text-bold">Solicitado por:</label>
              <select class="form-control" name="id_solicitante" id="id_solicitante">
                <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_solicitante']))) { echo "selected=\"selected\""; } ?>>Seleccione</option>
                  <?php foreach ($solicitado as $list) { ?>
                    <option value="<?php echo $list['id_usuario']; ?>" <?php if (!(strcmp($list['id_usuario'], $get_id[0]['id_solicitante']))) { echo "selected=\"selected\""; } ?>>
                      <?php echo $list['usuario_codigo']; ?>
                    </option>
                  <?php } ?>
              </select>
          </div>

          <div class="form-group col-md-2">
            <label class="text-bold">Fecha:</label>
            <div class="col">
              <input type="date" class="form-control" value="<?php echo $get_id[0]['fecha']; ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-1">
            <label class="control-label text-bold label_tabla">Empresa:</label>
            <select name="id_empresa" id="id_empresa" class="form-control" onchange="Empresa();">
              <option value="0">Seleccione</option>
              <?php foreach($list_empresab as $list){ ?>
                  <option value="<?php echo $list['id_empresa']; ?>" <?php  if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; }  ?>>
                    <?php echo $list['cod_empresa']; ?>
                  </option>
              <?php } ?>
            </select>
          </div>

          <div id="div_sedes" class="form-group col-md-7" style="display:none">
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
          <div class="form-group col-md-2">
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

          <div class="form-group col-md-2" id="cmb_subtipo">
            <label class="text-bold">Sub-Tipo:</label>
            <input type="hidden" id="subtipobd" name="subtipobd" value="<?php echo $get_id[0]['id_subtipo']; ?>">
            <div class="col">
              <select  name="id_subtipo" id="id_subtipo" class="form-control" onchange="Cambio_Week()">
                <option  value="0"  selected>Seleccione</option>
                <?php foreach($sub_tipo as $sub){
                if($get_id[0]['id_subtipo'] == $sub['id_subtipo']){ ?> 
                <option selected value="<?php echo $sub['id_subtipo']; ?>"><?php echo $sub['nom_subtipo'];?></option>
                <?php }else{?>
                  <option value="<?php echo $sub['id_subtipo']; ?>"><?php echo $sub['nom_subtipo'];?></option>
                <?php } } ?>
              </select>
            </div>
          </div>

          <div class="form-group col-md-1" id="msaters">
            <label class="text-bold" title="Snappy Artes">S.&nbsp;Artes:</label>
            <div class="col">
              <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Artes"   value="<?php echo $get_id[0]['s_artes']; ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-1" id="msredes">
            <label class="text-bold" title="Snappy Redes">S.&nbsp;Redes:</label>
            <div class="col">
              <input name="s_redes" type="number" class="form-control" id="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Redes" value="<?php echo $get_id[0]['s_redes']; ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-1">
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

          <div class="form-group col-md-5">
            <label class="text-bold">Descripción:</label>
            <div class="col">
              <input name="descripcion" type="text" maxlength="50" class="form-control" id="descripcion" value="<?php echo $get_id[0]['descripcion'] ?>" onkeypress="if(event.keyCode == 13){ Update_Proyecto(); }">
            </div>
          </div>
        </div>

        <div class="col-md-12 row">
          <div id="div_agenda_redes" class="form-group col-md-2">
            <label class="text-bold">Agenda / Redes:</label>
            <div class="col">
              <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha" type="date" value="<?php echo $get_id[0]['fec_agenda']; ?>" onkeypress="if(event.keyCode == 13){ Update_Proyecto(); }" min="<?php echo date('Y-m-d')?>"/>
            </div>
          </div>
        </div>

        <?php if($get_id[0]['id_tipo']==15 || $get_id[0]['id_tipo']==22 || $get_id[0]['id_tipo']==20 || $get_id[0]['id_tipo']==34){?>
          <div class="col-md-12 row">
            <div class="form-group col-md-4">
              <button class="btn " style="background-color:green;color:white" type="button" title="Duplicar" data-toggle="modal" data-target="#acceso_modal_eli" app_crear_eli="<?= site_url('Administrador/Modal_Duplicar') ?>/<?php echo $get_id[0]['id_proyecto'] ?>/<?php echo $get_id[0]['id_tipo'] ?>">Duplicar</button>
            </div>
          </div>

          <div class="col-md-12 row" id="div_duplicados">
          </div>
        <?php } ?>

        <div class="col-md-12" style="background-color:#C9C9C9;padding:10px 10px;">
            <div class="col-md-2">
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

            <div class="col-md-2" id="pendiente" <?php if($get_id[0]['status']==4){ ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>>
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

            <div class="col-md-2">
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
              <div class="col-md-2" id="fecha">
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

              <div class="col-md-2" id="imagen">
                <label class="text-bold">Archivo:</label>
                <div class="col">
                  <input class="form-control" name="foto" type="file" id="foto" accept=".png, .jpg, .jpeg, .pdf">
                </div>  
              </div>
              <?php } else { ?>
              <div class="col-md-2" id="fecha">
                <label class="text-bold">Fecha:</label>
                <div class="col">
                  <?php  if ($get_id[0]['fec_termino']!='0000-00-00 00:00:00') 
                    {
                        echo date('d/m/Y H:i:s', strtotime($get_id[0]['fec_termino']));
                    } 
                    else { echo date('d/m/Y'); }; ?>
                </div>
              </div>
              
              <div class="col-md-2" id="imagen">
                <label class="text-bold">Archivo:</label>
                <div class="col">
                  <input class="form-control" name="foto" type="file" id="foto" accept=".png, .jpg, .jpeg, .pdf">
                </div>
              </div>
            <?php } ?>

            <?php if($get_id[0]['imagen']!=""){ ?>
              <div class="col-md-2">
                <label class="text-bold">Descargar Archivo:</label>
                <div id="lista_escogida"><!--<img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" src="<?php echo $get_id[0]['imagen']?>">--></div>
                <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_proyecto']?>">
                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                </a>
              </div>
            <?php } ?>
        </div>

        <div class="col-md-12 row" style="margin-top:15px;">
          <div class="col-md-12">
            <label class="control-label text-bold">Observaciones:</label>
            <textarea name="proy_obs" rows="5" class="form-control" id="proy_obs" ><?php echo $get_id[0]['proy_obs']?></textarea>
            <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
          </div>
        </div>

        <div class="col-md-12 row" style="margin-top:15px;">
          <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_nivel']==4 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
            <div class="col-md-2">
              <label class="control-label text-bold">Hora:</label>
              <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $get_id[0]['hora']; ?>" onkeypress="if(event.keyCode == 13){ Update_Proyecto(); }">
            </div>
          <?php } ?>

          <div class="col-md-2">
            <input type="checkbox" id="publicidad_pagada" name="publicidad_pagada" value="1" <?php if($get_id[0]['publicidad_pagada']==1){ echo "checked"; } ?>>
            <label class="control-label text-bold">Publicidad pagada</label>
          </div>
        </div>

        <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_nivel']==4 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
          <div class="col-md-12 row" style="margin-top:15px;">
            <div class="col-md-12" id="divcopye" <?php if($get_id[0]['id_tipo']==15 || $get_id[0]['id_tipo']==22 || $get_id[0]['id_tipo']==20 || $get_id[0]['id_tipo']==34){ echo "style='display:block'"; }else{echo "style='display:none'"; }?>>
              <label class="control-label text-bold">Copy:</label>
              <textarea name="copy" rows="3" class="form-control" id="copy" placeholder="Copy"><?php echo $get_id[0]['copy']?></textarea>
            </div>
          </div>
        <?php } ?>
      </form>
    </div>

    <div class="modal-footer">
      <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $get_id[0]['id_proyecto'] ?>">
      <input type="hidden" id="fec_agenda_hidden" name="fec_agenda_hidden" value="<?php echo $get_id[0]['fec_agenda']; ?>">
      <input type="hidden" id="fec_actual" value="<?php echo date('Y-m-d'); ?>">
      <button type="button" class="btn btn-primary" onclick="Update_Proyecto();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
      <a href="<?= site_url('Administrador/Detalle_Proyecto') ?>/<?php echo $get_id[0]['id_proyecto'] ?>"><button type="button" class="btn btn-default" ><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button></a>
    </div>
</div>

<script>
  $(document).ready(function() {
    $("#comunicacion").addClass('active');
    $("#hcomunicacion").attr('aria-expanded', 'true');
    $("#proyectos").addClass('active');
    document.getElementById("rcomunicacion").style.display = "block";

    var id_tipo = $("#id_tipo").val();
    var div3 = document.getElementById("div_sedes");
    if(id_tipo==15 || id_tipo==22  || id_tipo==20 || id_tipo==34){
      div3.style.display = "none";
      $('#div_agenda_redes').show();
    }else{
      div3.style.display = "block";
      $('#div_agenda_redes').hide();
    }

    Lista_Duplicado();
  });

  function Lista_Duplicado(){
    Cargando();

    var url = "<?php echo site_url(); ?>Administrador/List_Duplicados";
    var id_proyecto = <?= $get_id[0]['id_proyecto']; ?>;

    $.ajax({    
        url:url,
        type:"POST",
        data: {'id_proyecto':id_proyecto},
        success:function (resp) {
            $('#div_duplicados').html(resp);
        }
    });
  }

  function Delete_Duplicado(id_agenda,id_redes){
    Cargando();

    var url="<?php echo site_url(); ?>Administrador/Delete_Duplicado";
    
    Swal({
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
                data: {'id_calendar_agenda':id_agenda,'id_calendar_redes':id_redes},
                success:function () {
                    Lista_Duplicado();
                }
            });
        }
    })
  }

  $(".img_post").click(function () {
    window.open($(this).attr("src"), 'popUpWindow', "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
  });

  $(document).on('click', '#download_file', function () {
    image_id = $(this).data('image_id');
    window.location.replace("<?php echo site_url(); ?>Administrador/Descargar_Imagen_Proyecto/" + image_id);
  });

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
    
    if(id_tipo == 15 || id_tipo == 20 || id_tipo == 34 || id_tipo == 22){
      $('#div_agenda_redes').show();
      $('#divcopye').show();
      $('#div_sedes').html('');
      div3.style.display = "none";
    }else{
      $('#div_agenda_redes').hide();
      $('#fec_agenda').val('');
      $('#divcopye').hide();
      $("#copy").val('');
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

  function muestradiv(){
    var status=document.getElementById("status").value;
    var pendiente = document.getElementById("pendiente");

    if(status==4){
      pendiente.style.display = "block";
    }else {
      pendiente.style.display = "none";
    }
  }

  function Update_Proyecto(){
      Cargando();
      
      var id=$('#id_proyecto').val();
      var dataString = new FormData(document.getElementById('from_proy'));
      var url="<?php echo site_url(); ?>Administrador/update_proyecto";

      if (proyecto()) {
        var id_tipo = $("#id_tipo").val();
        var fec_agenda = $("#fec_agenda").val();
        var fec_actual = $("#fec_actual").val();

        if(id_tipo==15 || id_tipo==22  || id_tipo==20 || id_tipo==34){
          if(fec_agenda==fec_actual){
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
                      window.location = "<?php echo site_url(); ?>Administrador/Detalle_Proyecto/"+id;
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
                            window.location = "<?php echo site_url(); ?>Administrador/Detalle_Proyecto/"+id;
                        });
                      }
                  });
                }
            })
          }
        }else{
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
                    window.location = "<?php echo site_url(); ?>Administrador/Detalle_Proyecto/"+id;
                });
              }
          });
        }
      }
  }

  function proyecto() {
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
    if ($('#id_tipo').val() != "15" && $('#id_tipo').val() != "20" && $('#id_tipo').val() != "34" && $('#id_tipo').val() != "22") {
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
    if ($('#id_subtipo').val() === "0" && $('#subtipobd').val() === "0") {
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
    if($('#status').val() === '0') {
        Swal(
            'Ups!',
            'Debe seleccionar status.',
            'warning'
        ).then(function() { });
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

<?php $this->load->view('Admin/footer'); ?>

