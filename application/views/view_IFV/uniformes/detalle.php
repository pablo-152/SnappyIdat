<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .tabset > input[type="radio"] {
      position: absolute;
      left: -200vw;
    }

    .tabset .tab-panel {
      display: none;
    }

    .tabset > input:first-child:checked ~ .tab-panels > .tab-panel:first-child,
    .tabset > input:nth-child(3):checked ~ .tab-panels > .tab-panel:nth-child(2),
    .tabset > input:nth-child(5):checked ~ .tab-panels > .tab-panel:nth-child(3),
    .tabset > input:nth-child(7):checked ~ .tab-panels > .tab-panel:nth-child(4),
    .tabset > input:nth-child(9):checked ~ .tab-panels > .tab-panel:nth-child(5),
    .tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6){
      display: block;
    }


    .tabset > label {
      position: relative;
      display: inline-block;
      padding: 15px 15px 25px;
      border: 1px solid transparent;
      border-bottom: 0;
      cursor: pointer;
      font-weight: 600;
      background: #799dfd5c;
    }

    .tabset > label::after {
      content: "";
      position: absolute;
      left: 15px;
      bottom: 10px;
      width: 22px;
      height: 4px;
      background: #8d8d8d;
    }

    .tabset > label:hover,
    .tabset > input:focus + label {
      color: #06c;
    }

    .tabset > label:hover::after,
    .tabset > input:focus + label::after,
    .tabset > input:checked + label::after {
      background: #06c;
    }

    .tabset > input:checked + label {
      border-color: #ccc;
      border-bottom: 1px solid #fff;
      margin-bottom: -1px;
    }

    .tab-panel {
      padding: 30px 0;
      border-top: 1px solid #ccc;
    }

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

    table th {
      text-align: center;
    }

</style>

<style>
    .margintop{
      margin-top:5px ;
    }

    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px;
    }

    .color_casilla{
        border-color: #C8C8C8;
        color: #000;
        background-color: #C8C8C8 !important;
    }

    .img_class{ 
        position: absolute;
        width: 80px;
        height: 90px;
        top: 5%;
        left: 1%;
    }

    .boton_exportable{
      margin: 0 0 10px 0;
    }

    .cabecera_pagos{
      margin: 5px 0 0 5px;
    }
</style>

<?php 
  $foto = "";
  if(count($get_foto)>0){
      if($get_foto[0]['archivo']!=""){
          $foto = $get_foto[0]['archivo'];
          $array_foto = explode("/",$foto);
          $nombre_foto = $array_foto[3];
      }
  }
?>

<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
          <div class="page-title" style="background-color: #C1C1C1;">
            <?php if($foto!=""){ ?>
              <a onclick="Descargar_Foto_Matriculados_C('<?php echo $get_foto[0]['id_detalle']; ?>');"><img class="img_class" src="<?php echo base_url().$get_foto[0]['archivo']; ?>"></a>
            <?php } ?>
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 8%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['Nombre_Completo']; ?></b></span></h4>
          </div>
  
          <div class="heading-elements">
            <div class="heading-btn-group">
                <!--<a title="Agregar Foto" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Update_Matriculados_C') ?>/<?php echo $get_id[0]['Id']; ?>" style="margin-right:5px;">
                  <img class="top" src="<?= base_url() ?>template/img/agregar_foto.png" alt="">
                </a>-->
                
                <a title="Duplicar Documento" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Documento_Duplicado') ?>/<?php echo $get_id[0]['Id']; ?>">
                  <img class="top" src="<?= base_url() ?>template/img/copy.png" alt="">
                </a>
                <a type="button" href="<?= site_url('AppIFV/Matriculados_C') ?>">
                  <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                </a>
            </div>
          </div>
        </div>    
      </div>
    </div>

    <?php
      $fec_de = new DateTime($get_id[0]['Fecha_Cumpleanos']);
      $fec_hasta = new DateTime(date('Y-m-d'));
      $diff = $fec_de->diff($fec_hasta); 
    ?>

    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12 row">
              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Código:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Codigo']; ?>">
              </div>

              <div class="form-group col-md-1">
              </div>

              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Alumno:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Alumno']; ?>">
              </div>

              <div class="form-group col-md-3">
              </div>

              <div class="form-group col-md-1">
                  <input type="text" class="margintop form-control color_casilla" disabled value="<?php echo $get_id[0]['Matricula']; ?>">
              </div>
          </div> 

          <div class="col-md-12 row">
              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Ap.&nbsp;Paterno: </label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Paterno']; ?>">
              </div>

              <div class="form-group col-md-1">
              </div>

              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Ap.&nbsp;Materno: </label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Materno']; ?>">
              </div>

              <div class="form-group col-md-1">
              </div>
                
              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Nombres: </label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Nombre']; ?>">
              </div>
          </div> 

          <div class="col-md-12 row">
              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">DNI:</label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Dni']; ?>">
              </div>

              <div class="form-group col-md-1">
              </div> 

              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Celular:</label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Celular']; ?>">
              </div>

              <div class="form-group col-md-1">
              </div>

              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Correo:</label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Email']; ?>">
              </div>
          </div>

          <div class="col-md-12 row">
              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Especialidad: </label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Especialidad']; ?>">
              </div>

              <div class="form-group col-md-1">
              </div>

              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Módulo: </label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Modulo']; ?>">
              </div>

              <div class="form-group col-md-1">
              </div>

              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Turno: </label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Turno']; ?>">
              </div>
          </div>
      </div>

      <div class="row">
        <div class="tabset">
          <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier2" checked>
          <label for="tab4">Detalles</label>

          <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier3">
          <label for="tab5">Ingresos</label>   

          <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier4">
          <label  for="tab6">Documentos</label>

          <input type="radio" name="tabset" id="tab7" aria-controls="rauchbier5">
          <label for="tab7">Pagos</label>

          <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $get_id[0]['Id']; ?>">  
          
          <div class="tab-panels">
            <!-- DETALLE -->
            <section id="rauchbier2" class="tab-panel">
              <div class="box-body table-responsive">
                <div class="panel panel-flat content-group-lg">
                  <div class="panel-heading">
                    <h5 class="panel-title"><b>Detalles</b></h5>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                      </ul>
                    </div>
                  </div>

                  <div class="panel-body" style="padding-bottom:0px;">
                      <div class="col-md-12 row">
                        <div class="form-group col-md-2">
                          <label class="col-sm-3 control-label text-bold">Fecha&nbsp;de&nbsp;Nacimiento:</label>
                        </div>
                        <div class="form-group col-md-1">
                          <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Cumpleanos']; ?>">
                        </div>

                        <div class="form-group col-md-1">
                          <label class=" col-sm-3 control-label text-bold">Edad:</label>
                        </div>
                        <div class="form-group col-md-1">
                          <input type="text" class="form-control" disabled value="<?php echo $diff->y; ?>">
                        </div>
                      </div>
                  </div>
                </div>
              </div> 

              <!--<div class="box-body table-responsive">
                <div class="panel panel-flat content-group-lg panel-collapsed">
                  <div class="panel-heading">
                    <h5 class="panel-title"><b>Fotos</b></h5>
                    <div class="heading-elements">
                      <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="reload"></a></li>
                        <li><a data-action="close"></a></li>
                      </ul>
                    </div>
                  </div>

                  <div class="panel-body" style="padding-bottom:0px;">
                      <div id="lista_foto">
                      </div>
                  </div>
                </div>
              </div>-->
            </section>

            <!-- INGRESOS -->
            <section id="rauchbier3" class="tab-panel">
              <div class="modal-content">
                <div id="div_doc">
                  <table id="example_ingreso" class="table table-hover table-bordered table-striped" width="100%">
                    <thead>
                      <tr style="background-color: #E5E5E5;">
                        <th>Orden</th>
                        <th class="text-center" width="10%">Fecha</th>
                        <th class="text-center" width="10%">Hora</th>
                        <th class="text-center" width="10%">Obs</th>
                        <th class="text-center" width="15%">Tipo</th>
                        <th class="text-center" width="15%">Estado</th>
                        <th class="text-center" width="15%">Autorización</th>
                        <th class="text-center" width="15%">Registro</th>
                        <th class="text-center" width="5%"></th> 
                      </tr>
                    </thead>
                    
                    <tbody>
                    <?php foreach($list_registro_ingreso as $list) {  ?>
                          <tr class="even pointer text-center">
                            <td><?php echo $list['orden']; ?></td> 
                            <td><?php echo $list['fecha_ingreso']; ?></td> 
                            <td><?php echo $list['hora_ingreso']; ?></td>  
                            <td><?php echo $list['obs']; ?></td>  
                            <td><?php echo $list['tipo_desc']; ?></td> 
                            <td><?php echo $list['nom_estado_reporte']; ?></td>
                            <td><?php echo $list['usuario_codigo']; ?></td> 
                            <td><?php echo $list['estado_ing']; ?></td>
                            <td>
                              <?php if($list['obs']=="Si"){ ?>
                                  <a title="Historial"  data-toggle="modal" data-target="#acceso_modal_mod" 
                                  app_crear_mod="<?= site_url('AppIFV/Modal_Historial_Registro_Ingreso') ?>/<?php echo $list['codigo']; ?>">
                                      <img title="Historial" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;"/>
                                  </a> 
                              <?php } ?>
                          </td>
                          </tr>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>

            <!-- DOCUMENTOS -->
            <section id="rauchbier4" class="tab-panel">
                <div class="boton_exportable">
                    <a title="Excel" href="<?= site_url('AppIFV/Excel_Documento_Alumno') ?>/<?php echo $get_id[0]['Id']; ?>">
                        <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                    </a> 
                </div>

                <div class="modal-content">
                    <div id="lista_documentos">
                    </div>
                </div>
            </section>

            <!-- PAGOS -->
            <section id="rauchbier4" class="tab-panel">
              <div class="boton_exportable">
                  <a title="Excel" onclick="Excel_Pago_Matriculados();">
                      <img src="<?= base_url() ?>template/img/boton_excel_tabla.png">
                  </a>
              </div>

              <div class="modal-content">
                <div class="heading-btn-group cabecera_pagos">
                    <a onclick="Lista_Pagos(2);" id="pendientes" style="color:#ffffff;background-color:#C00000;" class="form-group btn clase_boton"><span>Pendientes</span><i class="icon-arrow-down52"></i></a>
                    <a onclick="Lista_Pagos(1);" id="todos" style="color:#000000; background-color:#0070c0;" class="form-group btn clase_boton"><span>Todos</span><i class="icon-arrow-down52"></i> </a>
                    <input type="hidden" id="tipo_excel" value="2">
                </div>

                <div id="lista_pagos">
                </div>
              </div>
            </section>
          </div>
        </div> 
      </div>
    </div>
</div>

<script>
  $(document).ready(function() {
      $("#calendarizaciones").addClass('active');
      $("#hcalendarizaciones").attr('aria-expanded', 'true');
      $("#matriculados_c").addClass('active');
		  document.getElementById("rcalendarizaciones").style.display = "block";

      $('#example_ingreso thead tr').clone(true).appendTo('#example_ingreso thead');
      $('#example_ingreso thead tr:eq(1) th').each(function(i) {
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

      var table = $('#example_ingreso').DataTable({
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 100,
          "aoColumnDefs" : [ 
              {
                  'bSortable' : false,
                  'aTargets' : [ 2 ]
              },
              {
                  'targets' : [ 0 ],
                  'visible' : false
              } 
          ]
      });

      //Lista_Foto();
      Lista_Documentos();  
      Lista_Pagos(2);
  } );

  function Descargar_Foto_Matriculados_C(id){
      window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Foto_Matriculados_C/"+id);
  }

  /*function Lista_Foto(){
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

      var id_alumno = $('#id_alumno').val();
      var url="<?php echo site_url(); ?>AppIFV/Lista_Foto";

      $.ajax({
          type:"POST",
          url:url,
          data: {'id_alumno':id_alumno},
          success:function (data) {
              $('#lista_foto').html(data);
          }
      });
  }

  function Delete_Foto_Matriculados(id){
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

      var url="<?php echo site_url(); ?>AppIFV/Delete_Foto_Matriculados";
      
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
                  data: {'id_foto':id},
                  success:function () {
                      Swal(
                          'Eliminado!',
                          'El registro ha sido eliminado satisfactoriamente.',
                          'success'
                      ).then(function() {
                          Lista_Foto();
                      });
                  }
              });
          }
      })
  }*/

  function Lista_Documentos(){
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

      var id_alumno = $("#id_alumno").val();
      var url="<?php echo site_url(); ?>AppIFV/Lista_Documento_Alumno";

      $.ajax({
          type:"POST",
          url:url,
          data: {'id_alumno':id_alumno},
          success:function (data) {
              $('#lista_documentos').html(data);
          }
      });
  }

  function Delete_Documento_Alumno(id_detalle){
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

      var url="<?php echo site_url(); ?>AppIFV/Delete_Documento_Alumno";

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
                  data: {'id_detalle':id_detalle},
                  success:function (data) {
                      Swal(
                          'Eliminado!',
                          'El registro ha sido eliminado satisfactoriamente.',
                          'success'
                      ).then(function() {
                          Lista_Documentos();
                      });
                  }
              });
          }
      })
  } 

  function Lista_Pagos(estado){
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

      var id_alumno = $('#id_alumno').val();
      var url="<?php echo site_url(); ?>AppIFV/Lista_Pago_Matriculados";

      $.ajax({
          type:"POST", 
          url:url,
          data: {'id_alumno':id_alumno,'estado':estado},
          success:function (data) {
              $('#lista_pagos').html(data);
              $('#tipo_excel').val(estado);
          }
      });

      var pendientes = document.getElementById('pendientes');
      var todos = document.getElementById('todos');

      if(estado==1){
          pendientes.style.color = '#000000';
          todos.style.color = '#FFFFFF';
      }else{
          pendientes.style.color = '#FFFFFF';
          todos.style.color = '#000000';
      }
  }

  function Excel_Pago_Matriculados(){
      var id_alumno = $('#id_alumno').val();
      var tipo_excel=$('#tipo_excel').val();
      window.location ="<?php echo site_url(); ?>AppIFV/Excel_Pago_Matriculados/"+id_alumno+"/"+tipo_excel;
  }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>