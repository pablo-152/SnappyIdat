<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<!-- Navbar-->
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<style>
  .color_casilla{
    background-color: #E9E6E9;
  }
  .color_pendiente{
    background-color: #F2BBBB;
  }
</style>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Eventos (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group" >
            <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Nuevo_Evento') ?>">  <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Evento" />
            </a>

            <a onclick="Excel_Evento();">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
      <form method="post" id="formulario_excel" enctype="multipart/form-data" class="formulario" >
        <div class="heading-btn-group">
            <a onclick="Buscar(0);" id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Activos</span><i class="icon-arrow-down52"></i></a>
            <a onclick="Buscar(6);" id="todos" style="color: #000000; background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i> </a>
            <input type="hidden" id="tipo_excel">
            <?php if($id_nivel==1 || $id_nivel==6){ ?>
              <a class="form-group btn"><input name="archivo_excel" id="archivo_excel" type="file" data-allowed-file-extensions='["xls|xlsx"]' size="100"></a>
              <a class="form-group btn" href="<?= site_url('Administrador/Excel_Vacio_Evento') ?>" title="Estructura de Excel">
                <img height="36px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel"/>
              </a>
              <a class=" form-group  btn"><button class="btn btn-primary" type="button" onclick="Importar_Evento();">Importar</button></a>
            <?php } ?>
        </div>
      </form>

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
    $("#lista_eventos").addClass('active');
    document.getElementById("reventos").style.display = "block";

    Buscar(0);

    $("#acceso_modal_mod").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_mod"));
    });
  });

  function Buscar(status){
      Cargando();
      
      var url = "<?php echo site_url(); ?>Administrador/Busqueda_Evento/";
      frm = { 'status': status};
      
      $.ajax({
          type:"POST",
          url:url,
          data: frm,
          success:function (resp) {
              $('#tabla').html(resp);   
              $('#tipo_excel').val(status);
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

  function Excel_Evento(){
    var tipo_excel = $("#tipo_excel").val();
    window.location = "<?php echo site_url(); ?>Administrador/Excel_Evento/"+tipo_excel;
  }

  function Importar_Evento() {
    Cargando();

    var dataString = new FormData(document.getElementById('formulario_excel'));
    var url="<?php echo site_url(); ?>Administrador/Validar_Importar_Evento";
    var url2="<?php echo site_url(); ?>Administrador/Importar_Evento";

    if (Valida_Importar_Excel()){
        $.ajax({
            url: url,
            data:dataString,
            type:"POST",
            processData: false,
            contentType: false,
            success:function (data) {
              if(data!=""){
                swal.fire(
                    'Errores Encontrados!',
                    data.split("*")[0],
                    'error'
                ).then(function() {
                  if(data.split("*")[1]=="INCORRECTO"){
                    window.location = "<?php echo site_url(); ?>Administrador/Eventos";
                  }else{
                    Swal({
                        title: '¿Desea registrar de todos modos?',
                        text: "El archivo contiene errores y no se cargara esa(s) fila(s)",
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
                                url:url2,
                                data: dataString,
                                processData: false,
                                contentType: false,
                                success:function () {
                                    swal.fire(
                                        'Carga Exitosa!',
                                        'Haga clic en el botón!',
                                        'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>Administrador/Eventos";
                                    });
                                }
                            });
                        }
                    })
                  }
                });
              }else{
                swal.fire(
                    'Carga Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    window.location = "<?php echo site_url(); ?>Administrador/Eventos";
                });
              }
            }
        });
    }
  }

  function Valida_Importar_Excel() {
    if($('#archivo_excel').val() === '') {
      Swal(
        'Ups!',
        'Debe seleccionar archivo Excel.',
        'warning'
      ).then(function() { });
      return false;
    }
    return true;
  }
</script>

<?php $this->load->view('Admin/footer'); ?>
