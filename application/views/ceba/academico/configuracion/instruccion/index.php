<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('ceba/header'); ?>
<?php $this->load->view('ceba/nav'); ?>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Instrucciones (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <a title="Nuevo grado" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ceba/Modal_Instruccion') ?>">
              <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo area" />
            </a>

            <a onclick="Exportar_Instruccion();">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid" style="margin-bottom: 15px;">
    <div class="row col-md-12 col-sm-12 col-xs-12">
      <button type="button" class="btn" style="background:#343a40;color:#ffffff;" onclick="BuscadorIns(1);" title="Registrar">
        1 Secundaria
      </button>

      <button type="button" class="btn" style="background:#343a40;color:#ffffff;" onclick="BuscadorIns(2);" title="Registrar">
        2 Secundaria
      </button>
      <button type="button" class="btn" style="background:#343a40;color:#ffffff;" onclick="BuscadorIns(3);" title="Registrar">
        3 Secundaria
      </button>
      <button type="button" class="btn" style="background:#343a40;color:#ffffff;" onclick="BuscadorIns(4);" title="Registrar">
        4 Secundaria
      </button>
      <button type="button" class="btn" style="background:#343a40;color:#ffffff;" onclick="BuscadorIns(5);" title="Registrar">
        Inactivos
      </button>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12" id="lista_temas">
        <form method="post" id="formularioxls" enctype="multipart/form-data" action="<?= site_url('Ceba/Excel_Instruccion') ?>" class="formulario">
          <input type="hidden" name="parametro" id="parametro" value="<?php echo $parametro ?> ">
        </form>

        <table class="table table-hover table-bordered table-striped" id="example" width="100%">
          <thead>
            <tr style="background-color: #E5E5E5;">
              <th class="text-center" width="10%">Grado</th>
              <th class="text-center" width="8%">Módulo</th>
              <th class="text-center" width="20%">Tema</th>
              <th class="text-center" width="32%">Descripción</th>
              <th class="text-center" width="8%" title="Creado Por">Cre. Por</th>
              <th class="text-center" width="8%" title="Fecha Creación">Fec. Cre.</th>
              <th class="text-center" width="8%">Estado</th>
              <th class="text-center" width="6%"></th>
            </tr>
          </thead>

          <tbody >
            <?php foreach ($list_instruccion as $list) {  ?>
              <tr class="even pointer">
                <td nowrap ><?php echo $list['descripcion_grado']; ?></td>
                <td class="text-center" nowrap ><?php echo $list['nom_unidad']; ?></td>
                <td class="text-center" nowrap ><?php echo $list['referencia']; ?></td>
                <td nowrap ><?php echo substr($list['regla'], 0, 30); ?></td>
                <td class="text-center" nowrap ><?php echo $list['usuario_codigo']; ?></td>
                <td class="text-center" nowrap ><?php echo $list['fecha_registro']; ?></td>
                <td class="text-center" nowrap ><?php echo $list['nom_status']; ?></td>
                <td class="text-center" nowrap >
                  <img title="Editar Instruccion" data-toggle="modal" data-dismiss="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ceba/Modal_Update_Instruccion') ?>/<?php echo $list["id_instruccion"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;width:22px;height:22px;" />

                  <a style="cursor:pointer;" class="" data-toggle="modal" data-target="#slide" data-imagen="<?php echo $list['imagen'] ?>" title="Ver Imagen"> <img title="Imagen 1" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>

                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div id="clockdate">
        <div class="clockdate-wrapper">
          <div id="clock"></div>
          <div id="date"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#configuracion").addClass('active');
    $("#hconfiguracion").attr('aria-expanded', 'true');
    $("#instrucciones").addClass('active');
    document.getElementById("rconfiguracion").style.display = "block";
  });
</script>

<script>
  $(document).ready(function() {
    $('#example thead tr').clone(true).appendTo('#example thead');
    $('#example thead tr:eq(1) th').each(function(i) {
      var title = $(this).text();

      if(title==""){
        $(this).html('');
      }else{
        $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
      }

      $('input', this).on('keyup change', function() {
        if (table.column(i).search() !== this.value) {
          table
            .column(i)
            .search(this.value)
            .draw();
        }
      });
    });

    var table = $('#example').DataTable({
      ordering:false,
      orderCellsTop: true,
      fixedHeader: true,
      pageLength: 25
    });

  });
</script>

<?php $this->load->view('ceba/footer'); ?>
<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

<div class="modal fade" id="slide" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Imagen</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

      </div>

      <div class="modal-body">


        <input type="hidden" name="rutaslide" id="rutaslide" value='<?php echo base_url() ?>'>

        <div align="center" id="capitalslide"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#slide').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var imagen = button.data('imagen') // Extraer la información de atributos de datos
    var rutapdf = $("#rutaslide").val();
    var nombre_archivo = rutapdf + imagen

    var alto = nombre_archivo.naturalHeight;
    var ancho = nombre_archivo.naturalWidth;

    if (imagen != "") {
      document.getElementById("capitalslide").innerHTML = "<img src='" + nombre_archivo + "' height='400px' width='400px'>";

    } else {
      document.getElementById("capitalslide").innerHTML = "No se ha registrado ningún archivo";
    }



    var modal = $(this)
    modal.find('.modal-title').text('Imagen')
    $('.alert').hide(); //Oculto alert

  })
</script>

<?php $this->load->view('ceba/validaciones'); ?>