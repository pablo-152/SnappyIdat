<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<style>
  .col-xs-12 {
      width: 12.5%;
  }

  .x_x_panel{
      display: flex;
      width: 165px;
      flex-direction: row;
      text-align: center;
      justify-content: space-between;
      position: absolute;
      color: #fff;
      top: 50%;
      right: 532px;
      margin-top: -40px;
  }

  .x_x_panel h3{ 
      margin: 0px 0px 0px 0px;
  }

  .x_x_panel h4{ 
      margin: 0px 0px 0px 0px;
      font-size: 15px;
  }

  .x_x_panel .lab{
      width: 80px;
      height: 80px;
      display: grid;
      align-content: center;
  }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
          <div class="page-title" style="background-color: #C1C1C1;">
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Dep. Comercial (Lista)</b></span></h4>
          </div>

          <?php if($id_nivel!=15){ ?>
            <div id="div_datos_comercial" class="x_x_panel">
                <div class="lab" style="background-color: #F8CBAD;">
                  <h4>STATUS</h4> 
                  <h3><?php echo $get_datos_comercial[0]['status_sin_definir'];  ?></h3>
                  <h4>Sin Definir</h4>
                </div>
                <div class="lab" style="background-color: #F3E9CC;">
                  <h4>INTERESE</h4>
                  <h3><?php echo $get_datos_comercial[0]['interese_sin_definir'];  ?></h3>
                  <h4>Sin Definir</h4>
                </div>           
            </div>
          <?php } ?>
  
          <div class="heading-elements">
            <div class="heading-btn-group">
              <?php if($id_nivel==15){ ?>
                <a type="button" href="<?= site_url('Administrador/Vista_Registro_Mail_Secretaria') ?>" title="Nuevo"><img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Proyecto"></a>

                <a href="<?= site_url('Administrador/Excel_Dep_Comercial_Secretaria') ?>" style="margin-left:5px;">
                  <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                </a>
              <?php }else{ ?>
                <a title="Actualizar Datos" onclick="Actualizar_Datos_Comercial();" style="cursor:pointer;margin-right:30px;margin-left:5px;">
                  <img src="<?= base_url() ?>template/img/actualizar_datos.png" alt="Actualizar Datos">
                </a>

                <a type="button" href="<?= site_url('Administrador/Vista_Registro_Mail') ?>" title="Nuevo"><img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Proyecto"></a>
                
                <a style="cursor:pointer;margin-left:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Administrador/Modal_Registro_Mail_Mailing') ?>">
                  <img src="<?= base_url() ?>template/img/mailing.png" alt="Mailing">
                </a>

                <a style="cursor:pointer;margin-right:5px;margin-left:5px;" title="Duplicar" onclick="Duplicar();">
                  <img src="<?= base_url() ?>template/img/copy.png" alt="Duplicar">
                </a>

                <a onclick="Excel_Dep_Comercial();">
                  <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                </a>
              <?php } ?>
            </div>
          </div>
        </div>    
      </div>
    </div>

    <div id="inicio" class="container-fluid">
    </div>

    <div id="tabla" class="container-fluid">
      <input type="hidden" id="anio_busqueda" value="<?php echo date('Y'); ?>">
      <input type="hidden" id="tipo_excel" value="1">
    </div>
</div>

<script>
  $(document).ready(function() {
    $("#comercial").addClass('active');
    $("#hcomercial").attr('aria-expanded','true');
    $("#registro").addClass('active');
    document.getElementById("rcomercial").style.display = "block";

    <?php if($id_nivel!=15){ ?>
      //Cargar_Cabecera();
      Buscar(0);
    <?php }else{ ?> 
      Buscar(2);
    <?php } ?>
  });
</script>

<script>
  /*function Cargar_Cabecera(){
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

      var url = "<?php echo site_url(); ?>Administrador/Cargar_Cabecera";

      $.ajax({
          type:"POST",
          url:url,
          success:function (data) {
              $('#inicio').html(data);
          }
      });
  }*/

  function Buscar(parametro){
      Cargando();

      if(parametro==2){
        var url = "<?php echo site_url(); ?>Administrador/Busqueda_Registro";

        $.ajax({
            type:"POST",
            url:url,
            data: {'parametro':parametro,'anio':<?= date('Y'); ?>},
            success:function (data) {
                $('#tabla').html(data);
            }
        });
      }else{
        if(parametro==3){
          var parametro = $('#tipo_excel').val();
        }
        var anio = $('#anio_busqueda').val();
        var url = "<?php echo site_url(); ?>Administrador/Busqueda_Registro";

        $.ajax({
            type:"POST",
            url:url,
            data: {'parametro':parametro,'anio':anio},
            success:function (data) {
                $('#tabla').html(data);
                $("#tipo_excel").val(parametro);

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
        });
      }
  }

  function Actualizar_Datos_Comercial(){ 
      Cargando();

      var url = "<?php echo site_url(); ?>Administrador/Actualizar_Datos_Comercial";

      $.ajax({
        type:"POST",
        url:url,
        success:function (resp) {
          $("#div_datos_comercial").html(resp);
        }
      }); 
  }

  function Duplicar(){
    var contador=0;
    var contadorf=0;
    
    $("input[type=checkbox]").each(function(){
        if($(this).is(":checked"))
            contador++;
    });

    if(contador==1){
      Cargando();

      var dataString = $("#formulario_registro").serialize();
      var url = "<?php echo site_url(); ?>Administrador/Duplicar_Registro";

      $.ajax({
        type:"POST",
        url:url,
        data:dataString,
        success:function (data) {
          swal.fire(
            'Duplicado Exitoso!',
            'Haga clic en el botón!',
            'success'
          ).then(function() {
            window.location = "<?php echo site_url(); ?>Administrador/Registro";
          });
        }
      }); 
    }else if(contador>1){
        Swal(
            'Ups!',
            'Solo debe seleccionar un Registro.',
            'warning'
        ).then(function() { });
        return false;
    }else{
        Swal(
            'Ups!',
            'Debe seleccionar Registro.',
            'warning'
        ).then(function() { });
        return false;
    }
  }

  function Importar_Comercial() {
    Cargando();

    var dataString = new FormData(document.getElementById('formulario_excel'));
    var url="<?php echo site_url(); ?>Administrador/Validar_Importar_Comercial";
    var url2="<?php echo site_url(); ?>Administrador/Importar_Comercial";
    //var url3 = "<?php echo site_url(); ?>Administrador/Importar_Comercial_Sin_Validaciones"

    if (Valida_Importar_Excel()){
      /*$.ajax({
          url: url3,
          data:dataString,
          type:"POST",
          processData: false,
          contentType: false,
          success:function (data) {
            swal.fire(
              'Carga Exitosa!',
              'Haga clic en el botón!',
              'success'
            ).then(function() {
              window.location = "<?php echo site_url(); ?>Administrador/Registro";
            });
          }
      });*/
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
                  window.location = "<?php echo site_url(); ?>Administrador/Registro";
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
                                      window.location = "<?php echo site_url(); ?>Administrador/Registro";
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
                  window.location = "<?php echo site_url(); ?>Administrador/Registro";
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

  function Excel_Dep_Comercial(){
      Cargando();
      var tipo_excel = $("#tipo_excel").val();
      var anio = $('#anio_busqueda').val();
      window.location = "<?php echo site_url(); ?>Administrador/Excel_Dep_Comercial/"+tipo_excel+"/"+anio;
  }
</script>

<?php $this->load->view('Admin/footer'); ?>