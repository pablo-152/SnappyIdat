<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
          
          <div class="page-title" style="background-color: #C1C1C1;">
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;">
            <span class="text-semibold"><b>Mailing (Lista)</b></span></h4>
          </div>
  
          <div class="heading-elements">
            <div class="heading-btn-group" >
              <a type="button" id="btn_asignar" name="btn_asignar"><img src="<?= base_url() ?>template/img/enviar.PNG" alt="Nueva Asignación" />
              </a>
              <a onclick="Exportar_Mailing();">
                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" style="margin-left:5px"/>
              </a>
            </div>
          </div>
        </div>    
      </div>
    </div>

    <div class="container-fluid" style="margin-top: 25px;">
      <div class="heading-btn-group">
            <a onclick="Buscar(this,0);"  id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Buscar(this,1);"  id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i> </a>
        </div>

        <div class="row">
            <div class="col-lg-12" id="tabla">
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    $("#inscripcion").addClass('treeview-item-active');

    Buscar();
  });
</script>

<script>
    $(document).ready(function() {
      $("#comercial").addClass('active');
      $("#hcomercial").attr('aria-expanded','true');
      $("#mailings").addClass('active');
      document.getElementById("rcomercial").style.display = "block";
    });
</script>

<?php $this->load->view('Admin/footer'); ?>

<script>
  function Buscar(e,parametro){
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

      var url = "<?php echo site_url(); ?>Administrador/Busqueda_Mailing";
      frm = { 'parametro': parametro};
      $.ajax({
          url: url, 
          type: 'POST',
          data: frm,
      }).done(function(contextResponse, parametroResponse, response) {
          $("#tabla").html(contextResponse);
      })

      var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');
      if(parametro==0){
            todos.style.color = '#000000';
            activos.style.color = '#ffffff';
      }else if(parametro==1){
          
            todos.style.color = '#ffffff';
            activos.style.color = '#000000';
      }
  }

  function Exportar_Mailing(){
    $('#formularioxls').submit();
  }

</script>

