<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<!-- Navbar-->
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>
<style>

</style>
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Inscripciones (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                      <a onclick="Exportar_Inscripcion();">
                        <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                      </a>
                      <div class="box-body table-responsive" id="excel">
                      </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    
    <div class="container-fluid">
        <div class="heading-btn-group">
            <a onclick="Buscar(0);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Buscar(6);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i> </a>
        </div>

        <div class="row">
            <div class="col-lg-12" id="tabla">
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    $("#eventos").addClass('active');
    $("#heventos").attr('aria-expanded','true');
    $("#inscripcion").addClass('active');
    document.getElementById("reventos").style.display = "block";
    
    Buscar(0); 

    $("#acceso_modal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_per"));
    });
    $("#acceso_modal_mod").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_mod"));
    });
    $("#acceso_modal_eli").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_eli"));
    });
  });

  function Buscar(status){
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

      var url = "<?php echo site_url(); ?>Administrador/Busqueda_Inscripcion/";
      frm = { 'status': status};
      
      $.ajax({
          type:"POST",
          url:url,
          data: frm,
          success:function (resp) {
              $('#tabla').html(resp);   
          }
      });

      var activos = document.getElementById('activos');
      var todos = document.getElementById('todos');
      if(status==0){
        todos.style.color = '#000000';
        activos.style.color = '#ffffff';
      }else if(status==6){
        todos.style.color = '#ffffff';
        activos.style.color = '#000000';
      }
  }

  function Exportar_Inscripcion(){
    $('#formularioxls').submit();
  }
</script>

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

<div class="modal fade bd-example-modal-lg" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Imagen Subida</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div align="center" id="capital2"></div>
        <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url()."archivo/" ?>'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#dataUpdate').on(
    'show.bs.modal', function (event){
      var button = $(event.relatedTarget)
      var imagen = button.data('imagen')
      var imagen2 = imagen.substr(-3)
      var rutapdf= $("#rutafoto").val(); // ruta de la imagen
      var nombre_archivo= rutapdf+imagen // tuta y nombre del archivo
    
      if (imagen2=="PDF" || imagen2=="pdf")
      {
        document.getElementById("capital2").innerHTML = "<iframe height='350px' width='350px' src='"+nombre_archivo+"'></iframe>";
      }
      else
      {
        document.getElementById("capital2").innerHTML = "<img src='"+nombre_archivo+"'>";
      }
      var modal = $(this)
      modal.find('.modal-title').text('Imágen de Fondo')
      $('.alert').hide();//Oculto alert
    }
  )
</script>

<?php $this->load->view('Admin/footer'); ?>
