<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
            
          <div class="page-title" style="background-color: #C1C1C1;">
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Fondos Extranet (Lista)</b></span></h4>
          </div>

          <div class="heading-elements">
            <div class="heading-btn-group" >
              <a title="Nuevo Fondo" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('General/Modal_Fondo_Extranet') ?>">
                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
              </a>
              <a href="<?= site_url('General/Excel_Fondo_Extranet') ?>">
                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="container-fluid">
      <div class="row">
        <div id="lista_fondo_extranet" class="col-lg-12">
        </div>
      </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Imagen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div align="center" id="capital2"></div>
                <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url(); ?>'>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
      $("#configuracion").addClass('active');
      $("#hconfiguracion").attr('aria-expanded','true');
      $("#fondos_extranet").addClass('active');
      document.getElementById("rconfiguracion").style.display = "block";

      Lista_Fondo_Extranet();
  });

  function Lista_Fondo_Extranet(){
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

      var url="<?php echo site_url(); ?>General/Lista_Fondo_Extranet";

      $.ajax({
          type:"POST",
          url:url,
          success:function (resp) {
              $('#lista_fondo_extranet').html(resp);
          }
      });
  }

  function Cambiar_Estado_Fondo_Extranet(id,estado){
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

      var url="<?php echo site_url(); ?>General/Cambiar_Estado_Fondo_Extranet";

      $.ajax({
          type:"POST",
          data: {'id_fondo':id,'estado':estado},
          url:url,
          success:function (data) {
              Lista_Fondo_Extranet();
          }
      });
  }  

  $('#dataUpdate').on(
      'show.bs.modal', function (event){
          var button = $(event.relatedTarget)
          var imagen = button.data('imagen')
          var imagen2 = imagen.substr(-3)
          var rutapdf= $("#rutafoto").val(); // ruta de la imagen
          var nombre_archivo= rutapdf+imagen // tuta y nombre del archivo
      
          if (imagen2=="PDF" || imagen2=="pdf"){
              document.getElementById("capital2").innerHTML = "<iframe height='350px' width='350px' src='"+nombre_archivo+"'></iframe>";
          }else{
              document.getElementById("capital2").innerHTML = "<img height='400px' width='650px' src='"+nombre_archivo+"'>";
          }
          var modal = $(this)
          modal.find('.modal-title').text('Imagen')
          $('.alert').hide();//Oculto alert
      }
  )
</script>

<?php $this->load->view('general/footer'); ?>

