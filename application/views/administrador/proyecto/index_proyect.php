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
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Proyectos (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group" >
            <a type="button" href="<?= site_url('Administrador/Registrar_Proyecto') ?>">  
              <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo">
            </a>

            <a style="margin-left:5px;" onclick="Modal_Asignar_Disenador();">  <!-- data-toggle="modal" data-target="#acceso_modal_pequeno" app_crear_peq="<?= site_url('Administrador/Modal_Asignar_Disenador') ?>"-->
              <img src="<?= base_url() ?>template/img/asignar.png" alt="Asignar">
            </a>

            <a style="margin-left:5px;" onclick="Exportar_Proyectos();">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar" />
            </a>
          </div>
        </div>
      </div>    
    <div></div>
      
    </div>
  </div>

    
  <div class="container-fluid">
    <div class="x_panel">

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="color:#fff;background:#000f9f">
          <div class="inner" align="center">
            <h3 style="font-size: 32px;">
              <?php echo $row_st[0]['total'];?><!-- | <span style="font-size: 32px;"><?php echo $row_st[0]['artes'] + $row_st[0]['redes'];?></span>-->
            </h3> 
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="color:#fff;background:#000f9f">
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($row_s as $row_s) {  ?>
                <tr >
                  <td>&nbsp;</td>
                  <td style="text-align: center;">&nbsp;</td>
                  <td style="text-align: center;">&nbsp;</td>
                </tr>
                <?php  } ?>
              </tbody>
            </table>
            <br>
          </div>
          <center><a onclick="Buscar(1);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Solicitado<i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
          
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box " style="color:#fff;background:#cddb00">
          <div class="inner" align="center">
            <h3 style="font-size: 32px;"><?php echo $row_at[0]['total'];?><!-- | <span style="font-size: 32px;"><?php echo $row_at[0]['artes'] + $row_at[0]['redes'];?></span>--></h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead  style="color:#fff;background:#cddb00">
                <tr align="center">
                  <td></td>
                  <td><img src="<?= base_url() ?>images/sp-b.png" width="18" height="18" title="Totales"/></td>
                  <td><img src="<?= base_url() ?>images/tt-b.png" width="18" height="18" title="Snappy’s"/></td>
                </tr> 
              </thead>
              <tbody>
                <?php foreach($row_a as $row_a) {  ?>
                <tr>
                  <td> <?php echo $row_a['usuario_codigo']; ?></td>
                  <td style="text-align: center;"><?php if ($row_a['artes']!=null || $row_a['redes']!=null) echo $row_a['total']; else echo "0"; ?></td>
                  <td style="text-align: center;"><?php echo $row_a['artes']+$row_a['redes']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <br>
          </div>                                            
          <center><a onclick="Buscar(2);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;"> Asignados  <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
          
        </div>
      </div>

      <div class="col-lg-2 col-xs-12" style="color:#fff;">
        <div class="small-box " style="color:#fff;background:#37b5e7">
          <div class="inner" align="center">
            <h3 style="font-size: 32px;">
              <?php echo $row_ett[0]['total'];?><!-- | <span style="font-size: 32px;"><?php echo $row_ett[0]['artes'] + $row_ett[0]['redes'];?></span>-->
            </h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="color:#fff;background:#37b5e7">
                <tr align="center">
                  <td></td>
                  <td><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" title="Totales"/></td>
                  <td><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" title="Snappy’s"/></td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($row_et as $row_et) {  ?>
                <tr>
                  <td> <?php echo $row_et['usuario_codigo']; ?></td>
                  <td style="text-align: center;"><?php if ($row_et['artes']!=null || $row_et['redes']!=null) echo $row_et['total']; else echo "0"; ?></td>
                  <td style="text-align: center;"><?php echo $row_et['artes']+$row_et['redes']; ?></td>
                </tr>
              <?php  } ?>
              </tbody>
            </table>
            <br>
          </div> 
          <center><a onclick="Buscar(3);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;"> En Trámite<i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>                                           
          
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="color:#fff;background:#f18a00">
          <div class="inner" align="center">
            <h3 style="font-size: 32px;"><?php echo $row_prt[0]['total'];?><!-- | <span style="font-size: 32px;"><?php echo $row_prt[0]['artes'] + $row_prt[0]['redes'];?></span>--></h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="color:#fff;background:#f18a00">
                <tr align="center">                                                        
                  <td>&nbsp;</td>
                  <td><img src="<?= base_url() ?>images/sp-b.png" width="22" height="22" title="Totales"/></td>
                  <td><img src="<?= base_url() ?>images/tt-b.png" width="22" height="22" title="Snappy’s"/></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($row_pr as $row_pr) {  ?>
                <tr >
                  <td> <?php echo $row_pr['usuario_codigo']; ?></td>
                  <td style="text-align: center;"><?php if ($row_pr['artes']!=null || $row_pr['redes']!=null) echo $row_pr['total']; else echo "0"; ?></td>
                  <td style="text-align: center;"><?php echo $row_pr['artes']+$row_pr['redes']; ?></td>
                </tr>
                <?php  } ?>
              </tbody>
            </table>
            <br>
          </div>
          <center><a onclick="Buscar(4);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;"> Pendientes <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
          
        </div>
      </div>

      <div class="col-lg-4 col-xs-12">
        <div class="small-box bg-snappy" style="color:#fff;background:#3BB9AE">
          <?php
          $ts=0;
          $tu=0;
          foreach($row_tp2 as $row_tp2){
          $ts=$ts+$row_tp2['artest'] + $row_tp2['redest'];
          $tu=$tu+ $row_tp2['artes'] + $row_tp2['redes'];
          } 
          ?>
          <div align="center">
            <h3>WEEK Snappy's</h3>
            Terminados - Enviados - Archivados
          </div>
          <div class="row">
            <div class="col-lg-8 ">
              <table class="table-total" align="center">
                <thead style="color:#fff;background:#3BB9AE">
                  <tr align="center">
                    <td>&nbsp;</td>
                    <td><img src="<?= base_url() ?>images/spt-b.png" width="20" height="20" title="Tickets"/></td>
                    <td><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" title="Totales"/></td>
                    <td><img src="<?= base_url() ?>images/porcentaje-b.png" width="20" height="20" title="Porcentaje"/></td>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($row_tp as $row_tp) {  ?>
                    <tr>
                      <td><?php echo $row_tp['usuario_codigo']; ?></td>
                      <td style="text-align: center;"><?php if ($row_tp['artest']=="" && $row_tp['redest']=="") {echo "0";} else {echo $row_tp['total'] ;} ?></td>
                      <td style="text-align: center;"><?php echo $row_tp['artest'] + $row_tp['redest']; ?></td>
                      <td style="text-align: center;"><?php if($row_tp['artes']!=0 && $row_tp['artes']!=""){ echo round((($row_tp['artest'] + $row_tp['redest'])/($row_tp['artes'] + $row_tp['redes']))*100); }else{ echo 0; } ?> %</td>
                      <td></td>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
            </div>

            <div class="col-lg-3">
              <table id="" width="90%" class="table-total" align="center">
                <thead style="color:#fff;background:#3BB9AE">
                  <tr align="center">
                    <td width="45%" rowspan="4"><span style="text-align: center; font-size: 38px;font-weight: bold;"><?php echo $ts; ?></span><br>
                    <span style="text-align: center; font-size: 32px;"><?php if($tu!=0 && $tu!=""){ echo round(($ts/$tu)*100); }else{ echo 0; } ?> %</span>
                    </td>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <br>
          <center><a onclick="Buscar(5);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;"> Terminados <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
          
        </div>
      </div>

    </div>
    <form method="post" id="formulario_excel" enctype="multipart/form-data" class="formulario" >
      <div class="heading-btn-group">
          <a onclick="Buscar(0);"  id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Activos</span><i class="icon-arrow-down52"></i></a>
          <?php if($sesion['id_usuario']==1 || $sesion['id_usuario']==5 || $sesion['id_usuario']==7 || $sesion['id_usuario']==35 || $sesion['id_usuario']==71){ ?>
          <a class=" form-group  btn "><input name="archivo_excel" id="archivo_excel" type="file" data-allowed-file-extensions='["xls|xlsx"]'  size="100"  ></a>
          
          <a class=" form-group  btn" href="<?= site_url('Administrador/Excel_Vacio_Proyecto2') ?>" target="_blank" title="Estructura de Excel"><img height="36px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel" /></a>
        
          <a class=" form-group  btn"><button class="btn btn-primary" type="button" onclick="Importar_Proyectos();">Importar</button></a>
          <?php } ?>
      </div>
    </form>
    
    <div class="row">
      <div class="col-lg-12" id="tabla">
      </div>
    </div>
  </div>
</div>

<div id="acceso_modal_pequeno" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title"><b>Asignar <span id="span_cantidad">0</span> proyectos a:</b></h5>
            </div>

            <div class="modal-body" style="max-height:450px; overflow:auto;">
                <div class="col-md-12 row">
                    <div class="form-group col-md-12">
                        <label class="control-label text-bold">Diseñador: </label>
                        <select class="form-control" id="id_disenador" name="id_disenador">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_disenador as $list){ ?>
                                <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div> 
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="Asignar_Disenador();">
                    <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                </button>    
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
      $("#comunicacion").addClass('active');
      $("#hcomunicacion").attr('aria-expanded','true');
      $("#proyectos").addClass('active');
      document.getElementById("rcomunicacion").style.display = "block";
  
      Buscar(0);
    });

    $(".img_post").click(function () {
      window.open($(this).attr("data-imagen"), 'popUpWindow',"height=" + $(this).attr("data-imagen").naturalHeight + ",width=" + $(this).attr("data-imagen").naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    
    $("#acceso_modal_pequeno").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_crear_peq"));
    });
</script>

<?php $this->load->view('Admin/footer'); ?>

<script>
  // ADMINISTRDOR
  function Nuevo(){
    //var status = status;
    //alert(status);
      var url = "<?php echo site_url(); ?>Administrador/nuevo_proyect/";
        frm = { };
        $.ajax({
          url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
          $("#nuevo_proyect").html(contextResponse);
        })

  }

  // TEAMLIDER
  function Nuevo_Proy(){
      var url = "<?php echo site_url(); ?>Teamleader/nuevo_proyTeam/";
        frm = { };
        $.ajax({
          url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
          $("#nuevo_proyect").html(contextResponse);
        })

  }

  function Buscar(status){
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

    var url="<?php echo site_url(); ?>Administrador/Busqueda";

    $.ajax({
        type:"POST",
        url:url,
        data: {'status':status},
        success:function (resp) {
            $('#tabla').html(resp);
        }
    });
  }

  function Modal_Asignar_Disenador(){
    var cantidad = $("#cantidad").val();
    if(cantidad>0){
      $('#acceso_modal_pequeno').modal('show');
    }else{
      Swal({
          title: 'Acceso Denegado',
          text: "¡No se ha seleccionado ningún proyecto!",
          type: 'error',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK',
      });
    }
  }

  function Asignar_Disenador(){
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

      var url="<?php echo site_url(); ?>Administrador/Asignar_Disenador";
      var cadena = $("#cadena").val();
      var cantidad = $("#cantidad").val();
      var prueba= $("#prueba").val();
      var id_disenador = $("#id_disenador").val();

      if (Valida_Asignar_Disenador()) {
          $.ajax({
              type:"POST",
              url:url,
              data:{'cadena':cadena,'cantidad':cantidad,'prueba':prueba,'id_disenador':id_disenador},
              success:function (data) {
                  Buscar(0);
                  $("#acceso_modal_pequeno").modal("hide");
                  $("#id_disenador").val(0);
              }
          });
      }
  }

  function Valida_Asignar_Disenador() {
      if($('#id_disenador').val().trim() === '0') {
          Swal(
              'Ups!',
              'Debe seleccionar Diseñador.',
              'warning'
          ).then(function() { });
          return false;
      }
      return true;
  }

  function Exportar_Proyectos(){
    var id_status = $("#id_status").val();
    window.location ="<?php echo site_url(); ?>Administrador/Excel_proyec2/"+id_status;
    /*var url = "<?php echo site_url(); ?>Administrador/Excel_proyec2";
    frm = { 'id_status': id_status};
    $.ajax({
        url: url, 
        type: 'POST',
        data: frm,
    })*/
  }

  function Importar_Proyectos() {
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

      var dataString = new FormData(document.getElementById('formulario_excel'));
      var url="<?php echo site_url(); ?>Administrador/Validar_Importar_Proyectos";
      var url2="<?php echo site_url(); ?>Administrador/Importar_Proyectos";

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
                      window.location = "<?php echo site_url(); ?>Administrador/proyectos";
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
                                          window.location = "<?php echo site_url(); ?>Administrador/proyectos";
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
                      window.location = "<?php echo site_url(); ?>Administrador/proyectos";
                  });
                }
              }
          });
      }else{
          bootbox.alert(msgDate)
          var input = $(inputFocus).parent();
          $(input).addClass("has-error");
          $(input).on("change", function () {
              if ($(input).hasClass("has-error")) {
                  $(input).removeClass("has-error");
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
