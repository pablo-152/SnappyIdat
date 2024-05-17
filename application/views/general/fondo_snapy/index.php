<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('general/header'); ?>

<?php $this->load->view('general/nav'); ?>


<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
            
          <div class="page-title" style="background-color: #C1C1C1;">
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Fondos de Intranet (Lista)</b></span></h4>
          </div>

          <div class="heading-elements">
            <div class="heading-btn-group" >
              <a title="Nuevo Fondo" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('General/modal_img') ?>">
                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
              </a>
              <a href="<?= site_url('General/Excel_Fondo') ?>">
                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <table class="table  table-hover table-bordered table-striped" id="example" width="100%">
            <thead>
              <tr>
                  <th class="text-center" width="42%">Empresa</th>
                  <th class="text-center" width="46%">Título Fondo</th>
                  <td class="text-center" width="12%"></td>
              </tr>
            </thead>
            
            <tbody>
              <?php foreach($confg_foto as $cof) {  ?>                                           
                <tr class="even pointer">
                <td class="text-left"><?php echo $cof["nom_empresa"]; ?></td>
                <td class="text-left"><?php echo $cof["nom_fintranet"]; ?></td>
                <td class="text-center">
                    <img title="Editar Datos Festivo" data-toggle="modal" data-target="#acceso_modal_mod"  app_crear_mod="<?= site_url('General/update_img') ?>/<?php echo $cof["id_fintranet"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"   width="22" height="22" />
                      &nbsp;
                      <!--<a width="22" height="22" type="button" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $cof["foto"]?>" title="Ver Imágen"><i class="glyphicon glyphicon-zoom-in"></i></a>-->
                      <img src="<?= base_url() ?>template/img/ver.png" width="21px" height="21px" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $cof["foto"]?>" title="Ver Imagen" style="cursor:pointer; cursor: hand;"/>
                      &nbsp;
                    <?php if($cof['estado']!=2){ ?>
                      <a style="color:red" onclick="Eliminar('<?php echo $cof['id_fintranet']; ?>','<?php echo $cof['id_empresa']; ?>',2)" title="Desactivar Fondo Intranet">
                        <img src="<?= base_url() ?>template/img/x.png" width="21px" height="21px">
                      </a>
                    <?php }else{ ?>
                      <a style="color:green" onclick="Eliminar('<?php echo $cof['id_fintranet']; ?>','<?php echo $cof['id_empresa']; ?>',1)" title="Activar Fondo Intranet">
                        <img src="<?= base_url() ?>template/img/check.png" width="21px" height="21px">
                      </a>
                    <?php } ?>
                  </td>
                </tr>
              <?php  } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

<div id="acceso_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>

<div id="acceso_modal_mod" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>

<div id="acceso_modal_eli" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>

<script>
  $(document).ready(function() {
      $("#configuracion").addClass('active');
      $("#hconfiguracion").attr('aria-expanded','true');
      $("#fondo_s").addClass('active');
      document.getElementById("rconfiguracion").style.display = "block";
  });
</script>

<?php $this->load->view('general/footer'); ?>

<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

<!--<script type="text/javascript">
  function corregirpapeleta(){
    frmlmotivocorregir.submit();
  }
</script>-->
  
<div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Imagen de Fondo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
      <div id="datos_ajax"></div>
      <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url() ?>'>
            <div align="center" id="capital2"></div>        
      </div>
      <div class="modal-footer">      
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script >
  

  $('#dataUpdate').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var imagen = button.data('imagen') // Extraer la información de atributos de datos
    var rutapdf= $("#rutafoto").val();
    var nombre_archivo= rutapdf+imagen
    document.getElementById("capital2").innerHTML = "<img src='"+nombre_archivo+"'>";
    //('src', ""+nombre_archivo+".pdf");
    var modal = $(this)
    modal.find('.modal-title').text('Imagen de Fondo')
    $('.alert').hide();//Oculto alert

  })

  function Eliminar(id,id_empresa,estado){
    bootbox.confirm({
      title: "<b>Actualizar estado</b>",
      message: "¿Está seguro de actualizar estado",
      buttons: {
        cancel: {
          label: 'Cancelar'
        },
        confirm: {
          label: 'Aceptar'
        }
      },
      callback: function (result) {
        if (result) {
          var url = "<?php echo site_url(); ?>" + "/Snappy/eliminarfoto/";
          frm = { id: id, id_empresa:id_empresa,estado:estado};
          $.ajax({
            url: url, 
            type: 'POST',
            dataType: 'html',
            data: frm,
          }).done(function(contextResponse, statusResponse, response) {
            swal.fire(
                'Fondo Actualizado!',
                '',
                'success'
            ).then(function() {
                window.location = "<?php echo site_url(); ?>General/Fondo_snappy";
                
            });
          });/**/
        }
      }
    });
  }  
</script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

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
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 2 ]
        } ]
        });
    });
</script>

