<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<!-- Navbar-->
<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>

<link href="<?= base_url() ?>template/css/AdminLTE.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>template/inputfiles/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/piexif.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/plugins/sortable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/fr.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/js/locales/es.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/fas/theme.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.js" type="text/javascript"></script>
<style>
  /*
    CSS for the main interaction
    */
  .tabset>input[type="radio"] {
    position: absolute;
    left: -200vw;
  }

  .tabset .tab-panel {
    display: none;
  }

  .tabset>input:first-child:checked~.tab-panels>.tab-panel:first-child,
  .tabset>input:nth-child(3):checked~.tab-panels>.tab-panel:nth-child(2),
  .tabset>input:nth-child(5):checked~.tab-panels>.tab-panel:nth-child(3),
  .tabset>input:nth-child(7):checked~.tab-panels>.tab-panel:nth-child(4),
  .tabset>input:nth-child(9):checked~.tab-panels>.tab-panel:nth-child(5),
  .tabset>input:nth-child(11):checked~.tab-panels>.tab-panel:nth-child(6) {
    display: block;
  }

  /*
    Styling
    */

  .tabset>label {
    position: relative;
    display: inline-block;
    padding: 15px 15px 25px;
    border: 1px solid transparent;
    border-bottom: 0;
    cursor: pointer;
    font-weight: 600;
    background: #799dfd5c;
  }

  .tabset>label::after {
    content: "";
    position: absolute;
    left: 15px;
    bottom: 10px;
    width: 22px;
    height: 4px;
    background: #8d8d8d;
  }

  .tabset>label:hover,
  .tabset>input:focus+label {
    color: #06c;
  }

  .tabset>label:hover::after,
  .tabset>input:focus+label::after,
  .tabset>input:checked+label::after {
    background: #06c;
  }

  .tabset>input:checked+label {
    border-color: #ccc;
    border-bottom: 1px solid #fff;
    margin-bottom: -1px;
  }

  .tab-panel {
    padding: 30px 0;
    border-top: 1px solid #ccc;
  }

  /*
    Demo purposes only
    */
  *,
  *:before,
  *:after {
    box-sizing: border-box;
  }

  .tabset {
    margin: 8px 15px;
  }

  .contenedor1 {
    position: relative;
    height: 80px;
    width: 80px;
    float: left;

  }

  .contenedor1 img {
    position: absolute;
    left: 0;
    transition: opacity 0.3s ease-in-out;
    height: 80px;
    width: 80px;
  }

  .contenedor1 img.top:hover {
    opacity: 0;
    height: 80px;
    width: 80px;
  }

  .label_tabla {
    font-size: 16px;
  }
</style>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Historial Ticket&nbsp;&nbsp;<?php echo $get_id[0]['cod_ticket'] ?></b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <a type="button" style="margin-right: 5px;" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('General/Modal_Nuevo_Historial_Ticket') ?>/<?php echo $get_id[0]['id_ticket']; ?>"> <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Ticket" />
            </a>

            <?php if ($sesion['id_usuario'] == 1 || $sesion['id_usuario'] == 5 || $sesion['id_usuario'] == 7 || $sesion['id_usuario'] == 48 || $sesion['id_usuario'] == 81 || $sesion['id_usuario'] == 85 || $sesion['id_usuario'] == 33) {
              if ($get_id[0]['bloqueado'] != 1) { ?>
                <img title="Editar Ticket" style="margin-right:5px;cursor:pointer;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('General/Modal_Update_Ticket') ?>/<?php echo $get_id[0]['id_ticket']; ?>" src="<?= base_url() ?>template/img/editar_grande.png" alt="">
              <?php } ?>
            <?php } ?>

            
            <?php if ($tipo==1){ ?>
              <a type="button" href="<?= site_url('General/Ticket') ?>">
                <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
              </a>
            <?php }else{ ?>
              <a type="button" href="<?= site_url('General/Busqueda') ?>">
                <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
              </a>
            <?php } ?>
            

            <a href="<?= site_url('General/Excel_Historial_Ticket') ?>/<?php echo $get_id[0]['id_ticket']; ?>" style="margin-left: 5px;">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 col-xs-12">
        <div class="small-box bg-snappy" style="color:#fff;background:#3BB9AE">
          <div class="inner" align="center">
            <h3>
              <?php if ($hora_total[0]['cantidad'] != "0") {
                $hym = intdiv($hora_total[0]['minuto_total'], 60);
                $min_conv = $hora_total[0]['minuto_total'] % 60;
                echo ($hora_total[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
              } else {
                echo "00 min";
              } ?>
            </h3>
          </div>

          <a class="small-box-footer" style="cursor:pointer; cursor: hand;">Horas Totales
            <i class="fa fa-arrow-circle-down"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Tipo:</label>
        <div class="col">
          <select disabled class="form-control" name="id_tipo_ticket" id="id_tipo_ticket">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_tipo_ticket']))) {
                                echo "selected=\"selected\"";
                              } ?>>Seleccione</option>
            <?php foreach ($list_tipo_ticket as $list) { ?>
              <option value="<?php echo $list['id_tipo_ticket']; ?>" <?php if (!(strcmp($list['id_tipo_ticket'], $get_id[0]['id_tipo_ticket']))) {
                                                                        echo "selected=\"selected\"";
                                                                      } ?>><?php echo $list['nom_tipo_ticket']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      

      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Solicitado por:</label>
        <div class="col">
        <select disabled class="form-control" name="id_solicitante" id="id_solicitante">
          <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_solicitante']))) {
                              echo "selected=\"selected\"";
                            } ?>>Seleccione</option>
          <?php foreach ($list_usuario as $list) { ?>
            <option value="<?php echo $list['id_usuario']; ?>" <?php if (!(strcmp($list['id_usuario'], $get_id[0]['id_solicitante']))) {
                                                                  echo "selected=\"selected\"";
                                                                } ?>><?php echo $list['usuario_codigo']; ?></option>
          <?php } ?>
        </select>
      </div>
      </div>
      

      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Empresa:</label>
        <div class="col">
        <select disabled class="form-control" name="id_empresa" id="id_empresa">
          <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_empresa']))) {
                              echo "selected=\"selected\"";
                            } ?>>Seleccione</option>
          <?php foreach ($list_empresa_ticket as $list) { ?>
            <option value="<?php echo $list['id_empresa']; ?>" <?php if (!(strcmp($list['id_empresa'], $get_id[0]['id_empresa']))) {
                                                                  echo "selected=\"selected\"";
                                                                } ?>><?php echo $list['cod_empresa']; ?></option>
          <?php } ?>
        </select>
      </div>
      </div>
      

      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Proyecto:</label>
        <div class="col">
        <select disabled class="form-control" name="id_proyecto_soporte" id="id_proyecto_soporte">
          <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_proyecto_soporte']))) {
                              echo "selected=\"selected\"";
                            } ?>>Seleccione</option>
          <?php foreach ($list_proyecto as $list) { ?>
            <option value="<?php echo $list['id_proyecto_soporte']; ?>" <?php if (!(strcmp($list['id_proyecto_soporte'], $get_id[0]['id_proyecto_soporte']))) {
                                                                          echo "selected=\"selected\"";
                                                                        } ?>><?php echo $list['proyecto']; ?></option>
          <?php } ?>
        </select>
      </div>
      </div>
      

      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Sub-Proyecto:</label>
        <div class="col">
        <select disabled class="form-control" name="id_subproyecto_soporte" id="id_subproyecto_soporte">
          <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_subproyecto_soporte']))) {
                              echo "selected=\"selected\"";
                            } ?>>Seleccione</option>
          <?php foreach ($list_subproyecto as $list) { ?>
            <option value="<?php echo $list['id_subproyecto_soporte']; ?>" <?php if (!(strcmp($list['id_subproyecto_soporte'], $get_id[0]['id_subproyecto_soporte']))) {
                                                                              echo "selected=\"selected\"";
                                                                            } ?>><?php echo $list['subproyecto']; ?></option>
          <?php } ?>
        </select>
      </div>
      </div>
      

      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Prioridad:</label>
        <div class="col">
        <select disabled class="form-control" name="prioridad" id="prioridad">
          <option value="0" <?php if ($get_id[0]['prioridad'] == 0) {echo "selected";} ?>>0</option>
          <option value="1" <?php if ($get_id[0]['prioridad'] == 1) {echo "selected";} ?>>1</option>
          <option value="2" <?php if ($get_id[0]['prioridad'] == 2) {echo "selected";} ?>>2</option>
          <option value="3" <?php if ($get_id[0]['prioridad'] == 3) {echo "selected";} ?>>3</option>
          <option value="4" <?php if ($get_id[0]['prioridad'] == 4) {echo "selected";} ?>>4</option>
          <option value="5" <?php if ($get_id[0]['prioridad'] == 5) {echo "selected";} ?>>5</option>
        </select>
      </div>
      </div>
      

      <div class="form-group col-md-1">
        <label class="control-label text-bold label_tabla">Descripción:</label>
      </div>
      <div class="form-group col-md-7">
        <input name="ticket_desc" type="text" maxlength="50" class="form-control" id="ticket_desc" value="<?php echo $get_id[0]['ticket_desc'] ?>" placeholder="Ingresar descripción" readonly>
      </div>
    </div>

    <div id="lista_historial" class="col-lg-12">
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#soporteti").addClass('active');
    $("#hsoporteti").attr('aria-expanded', 'true');
    $("#tickets").addClass('active');
    document.getElementById("rsoporteti").style.display = "block";

    Lista_Historial_Ticket();
  });

    function Lista_Historial_Ticket(){
      Cargando();

      var url="<?php echo site_url(); ?>General/Lista_Historial_Ticket";
      var id_ticket = '<?= $get_id[0]['id_ticket']; ?>';

      $.ajax({
          type:"POST",
          url:url,
          data:{'id_ticket':id_ticket},
          success:function (data) {
              $('#lista_historial').html(data);
          }
      });
    }

    function Delete_Historial_Ticket(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>General/Delete_Historial_Ticket";

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
              type: "POST",
              url: url,
              data: {'id_historial': id,},
              success: function() {
                  Lista_Historial_Ticket();
              }
            });
          }
        })
    }

    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>General/Descargar_Archivo/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>General/Delete_Archivo',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>

<?php $this->load->view('general/footer'); ?>