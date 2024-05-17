<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
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
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Proyecto <?php echo $get_id[0]['cod_proyecto']; ?></b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <?php if ($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                <!-- Administrador-->
                <a type="button" title="Editar Proyecto" href="<?= site_url('Administrador/Editar_proyect') ?>/<?php echo $get_id[0]['id_proyecto']; ?>"> 
                  <img title="Editar Ticket" style="margin-right:5px;cursor:pointer;"  src="<?= base_url() ?>template/img/editar_grande.png" alt="">
                </a>
            <?php }elseif ($_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_nivel']==4){ ?>
              <!-- TEAMLEADER-->
              <a type="button" title="Editar Proyecto" href="<?= site_url('Teamleader/Editar_proyect') ?>/<?php echo $get_id[0]['id_proyecto']; ?>"> 
                <img title="Editar Ticket" style="margin-right:5px;cursor:pointer;"  src="<?= base_url() ?>template/img/editar_grande.png" alt="">
              </a>
            <?php } ?>

            <?php if ($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                <!-- Administrador-->
                <a type="button" href="<?= site_url('Administrador/proyectos') ?>">
                  <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
                </a>
            <?php }elseif ($_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_nivel']==4){ ?>
              <!-- TEAMLEADER-->
              <a type="button" href="<?= site_url('Teamleader/proyectos') ?>">
                <img src="<?= base_url() ?>template/img/icono-regresar.png">
              </a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="col-md-12 row">
      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Solicitado por:</label>
        <select disabled class="form-control">
          <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_solicitante']))) { echo "selected=\"selected\""; } ?>>Seleccione</option>
            <?php foreach ($solicitado as $list) { ?>
              <option value="<?php echo $list['id_usuario']; ?>" <?php if (!(strcmp($list['id_usuario'], $get_id[0]['id_solicitante']))) { echo "selected=\"selected\""; } ?>>
                <?php echo $list['usuario_codigo']; ?>
              </option>
            <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Fecha:</label>
        <input type="date" class="form-control" value="<?php echo $get_id[0]['fecha']; ?>" readonly>
      </div>

      <div class="form-group col-md-1">
        <label class="control-label text-bold label_tabla">Empresa:</label>
        <select disabled class="form-control">
          <option value="0">Seleccione</option>
          <?php foreach($list_empresas as $list){ ?>
              <option value="<?php echo $list['id_empresa']; ?>" <?php if($list['id_empresa']==$get_id[0]['id_empresa']){ echo "selected"; } ?>><?php echo $list['cod_empresa']; ?></option>
          <?php } ?>
        </select>
      </div>
      
      <?php if($get_id[0]['id_tipo']!=15 && $get_id[0]['id_tipo']!=34){ ?>
        <div class="form-group col-md-7">
          <label class="control-label text-bold label_tabla" >Sede:</label>
          <div class="col">
            <?php foreach($list_sede as $list){ ?>
                <label class="col">
                    <input type="checkbox" value="<?php echo $list['id_sede']; ?>" <?php foreach($get_sede as $sede){ if($sede['id_sede']==$list['id_sede']){ echo "checked"; } } ?> onclick="return false;">
                    <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
                </label>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>

    <div class="col-md-12 row">
      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Tipo:</label>
        <select disabled class="form-control">
          <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_tipo']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
          <?php foreach($list_tipo as $list){ ?>
              <option value="<?php echo $list['id_tipo']; ?>" <?php if (!(strcmp($list['id_tipo'], $get_id[0]['id_tipo']))){ echo "selected=\"selected\"";} ?>><?php echo $list['nom_tipo']; ?></option>
          <?php } ?>
        </select>
      </div>
      
      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Sub-Tipo:</label>
        <select disabled class="form-control">
          <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_subtipo']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
          <?php foreach($list_subtipo as $list){ ?>
              <option value="<?php echo $list['id_subtipo']; ?>" <?php if (!(strcmp($list['id_subtipo'], $get_id[0]['id_subtipo']))){ echo "selected=\"selected\"";} ?>><?php echo $list['nom_subtipo']; ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-1">
        <label class="control-label text-bold label_tabla">S.&nbsp;Artes:</label>
        <input type="number" class="form-control" placeholder="Ingresar Artes" value="<?php echo $get_id[0]['s_artes']; ?>" readonly>
      </div>

      <div class="form-group col-md-1">
        <label class="control-label text-bold label_tabla">S.&nbsp;Redes:</label>
        <input type="number" class="form-control" placeholder="Ingresar Artes" value="<?php echo $get_id[0]['s_redes']; ?>" readonly>
      </div>
      
      <div class="form-group col-md-1">
        <label class="control-label text-bold label_tabla">Prioridad:</label>
        <select disabled class="form-control">
          <option value="0" <?php if (!(strcmp(0, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
          <option value="1" <?php if (!(strcmp(1, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>1</option>
          <option value="2" <?php if (!(strcmp(2, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>2</option>
          <option value="3" <?php if (!(strcmp(3, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>3</option>
          <option value="4" <?php if (!(strcmp(4, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>4</option>
          <option value="5" <?php if (!(strcmp(5, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>5</option>
        </select>
      </div>

      <div class="form-group col-md-5">
        <label class="control-label text-bold label_tabla">Descripción:</label>
        <input type="text" maxlength="50" class="form-control" value="<?php echo $get_id[0]['descripcion'] ?>" readonly>
      </div>    
    </div>
      
    <div class="col-md-12 row">
      <?php if($get_id[0]['fec_agenda']!="0000-00-00"){ ?>
        <div class="form-group col-md-2">
          <label class="control-label text-bold label_tabla">Agenda&nbsp;/&nbsp;Redes:</label>
          <div class="col">
            <input type="date" class="form-control" value="<?php if($get_id[0]['fec_agenda']=="0000-00-00"){ echo ""; }else{ echo $get_id[0]['fec_agenda']; } ?>" readonly>
          </div>
        </div>
      <?php } ?>
    </div>

    <?php if($get_id[0]['id_tipo']==15 || $get_id[0]['id_tipo']==20 || $get_id[0]['id_tipo']==34){?>
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
          <select disabled class="form-control">
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
          <select disabled class="form-control">
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
          <select disabled class="form-control">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_solicitante']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
            <?php foreach($usuario_subtipo1 as $row_c){ ?>
            <option value="<?php echo $row_c['id_usuario']?>" <?php if (!(strcmp($row_c['id_usuario'], $get_id[0]['id_asignado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_c['usuario_codigo']?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <?php if ($get_id[0]['status']==5) { ?>
        <div class="col-md-1" id="fecha">
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
      <?php }else{ ?>
        <div class="col-md-1" id="fecha">
          <label class="text-bold">Fecha:</label>
          <div class="col">
            <?php  if ($get_id[0]['fec_termino']!='0000-00-00 00:00:00') 
              {
                  echo date('d/m/Y H:i:s', strtotime($get_id[0]['fec_termino']));
              } 
              else { echo date('d/m/Y'); }; ?>
          </div>
        </div>
      <?php } ?>

      <?php if($get_id[0]['imagen']!=""){ ?>
        <div class="col-md-2" id="imagen">
          <label class="text-bold">Archivo:</label>
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
        <textarea rows="5" class="form-control" readonly placeholder="Observaciones"><?php echo $get_id[0]['proy_obs']?></textarea>
        <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
      </div>
    </div>
      
    <div class="col-md-12 row" style="margin-top:15px;">
      <div class="col-md-2">
        <label class="control-label text-bold">Hora:</label>
        <input type="time" class="form-control" value="<?php echo $get_id[0]['hora']; ?>" readonly>
      </div>

      <div class="col-md-2">
        <input type="checkbox" <?php if($get_id[0]['publicidad_pagada']==1){ echo "checked"; } ?> disabled>
        <label class="control-label text-bold">Publicidad pagada</label>
      </div>
    </div>

    <div class="col-md-12 row" style="margin-top:15px;margin-bottom:25px;">
      <?php if($get_id[0]['id_tipo']==15 || $get_id[0]['id_tipo']==34){ ?>
        <div class="col-md-12">
          <label class="control-label text-bold">Copy:</label>
          <textarea rows="3" class="form-control" readonly placeholder="Copy"><?php echo $get_id[0]['copy']?></textarea>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#comunicacion").addClass('active');
    $("#hcomunicacion").attr('aria-expanded', 'true');
    $("#proyectos").addClass('active');
    document.getElementById("rcomunicacion").style.display = "block";

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
</script>

<?php $this->load->view('Admin/footer'); ?>