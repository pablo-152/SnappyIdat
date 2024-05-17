<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('Admin/header'); ?>

<?php $this->load->view('Admin/nav'); ?>
<!--<link href="<?=base_url() ?>template/css/AdminLTE.css" rel="stylesheet" type="text/css">-->
<style>

  table {
    table-layout: fixed;
    margin: 0rem auto;
    width: 100%;
    /*border-collapse: collapse;*/
  }

  th:last-child {width: 5%;}

  table thead{
      background-color:#e5e5e5;
      font-weight: bold;
      font-size: 12px;
  }


  table tbody tr td{
      font-size: 12px;
  }

</style>

<div class="panel panel-flat" id="nuevo_proyect">
  <div class="panel-heading" >
    <div class="row" >
      <div class="x_panel">
        
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Proyectos</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group" >
            <a style="margin-right:5px;" type="button" href="<?= site_url('Administrador/Registrar_Proyecto') ?>"><img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Proyecto" /></a>
            <!--<a style="margin-right:5px;" type="button" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Teamleader/nuevo_proyTeam') ?>">  <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nuevo Proyecto" />-->
            
            <a onclick="exportar1();">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>    
      
    </div>
  </div>

    
  <div class="container-fluid">
    <div class="x_panel">

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="background-color:#000f9f;color:#ffffff">
          <div class="inner" align="center">
            <h3>
              <?php echo $row_st[0]['total'];?> | <span style="font-size: 32px;"><?php echo $row_st[0]['artes'] + $row_st[0]['redes'];?></span>
            </h3> 
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="background-color:#000f9f;color:#ffffff">
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
          <center>
          <a onclick="Buscar(this,1);" class="small-box-footer" style="cursor:pointer; cursor: hand;color:white">Solicitado <i class="fa fa-arrow-circle-down"></i>
          </a></center>
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box " style="background-color:#cddb00;color:#ffffff">
          <div class="inner" align="center">
            <h3><?php echo $row_at[0]['total'];?> | <span style="font-size: 32px;"><?php echo $row_at[0]['artes'] + $row_at[0]['redes'];?></span></h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="background-color:#cddb00;color:#ffffff">
                <tr>
                  <td></td>
                  <td style="text-align: center;"><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></td>
                  <td style="text-align: center;"><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></td>
                </tr> 
              </thead>
              <tbody>
                <?php foreach($row_a as $row_a) {  ?>
                <tr>
                  <td> <?php echo $row_a['usuario_codigo']; ?></td>
                  <td style="text-align: center;"> <?php echo $row_a['total']; ?></td>
                  <td style="text-align: center;"> <?php echo $row_a['artes']+$row_a['redes']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <br>
          </div>   
          <center>
          <a onclick="Buscar(this,2);" class="small-box-footer" style="cursor:pointer; cursor: hand;color:white"> Asignados  
            <i class="fa fa-arrow-circle-down"></i>
          </a>
          </center>                                         
        </div>
      </div>

      <div class="col-lg-2 col-xs-12" style="color:#fff;">
        <div class="small-box " style="background-color:#37b5e7;color:#ffffff">
          <div class="inner" align="center">
            <h3>
              <?php echo $row_ett[0]['total'];?> | <span style="font-size: 32px;"><?php echo $row_ett[0]['artes'] + $row_ett[0]['redes'];?></span>
            </h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="background-color:#37b5e7;color:#ffffff">
                <tr>
                  <td></td>
                  <td style="text-align: center;"><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></td>
                  <td style="text-align: center;"><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($row_et as $row_et) {  ?>
                <tr>
                  <td> <?php echo $row_et['usuario_codigo']; ?></td>
                  <td style="text-align: center;"> <?php echo $row_et['total']; ?></td>
                  <td style="text-align: center;"> <?php echo $row_et['artes']+$row_et['redes']; ?></td>
                </tr>
              <?php  } ?>
              </tbody>
            </table>
            <br>
          </div>   
          <center>
          <a onclick="Buscar(this,3);" class="small-box-footer" style="cursor:pointer; cursor: hand;color:white"> En Trámite 
            <i class="fa fa-arrow-circle-down"></i>
          </a></center>                                         
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box "  style="background-color:#f18a00;color:#ffffff">
          <div class="inner" align="center">
            <h3><?php echo $row_prt[0]['total'];?> | <span style="font-size: 32px;"><?php echo $row_prt[0]['artes'] + $row_prt[0]['redes'];?></span></h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead  style="background-color:#f18a00;color:#ffffff">
                <tr>                                                        
                  <td></td>
                  <td style="text-align: center;"><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></td>
                  <td style="text-align: center;"><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></td>
                </tr>
              </thead>
              <tbody>
                <?php foreach($row_pr as $row_pr) {  ?>
                <tr >
                  <td> <?php echo $row_pr['usuario_codigo']; ?></td>
                  <td style="text-align: center;"> <?php if ($row_pr['artes']!=null || $row_pr['redes']!=null) echo $row_pr['total']; else echo "0"; ?></td>
                  <td style="text-align: center;"> <?php echo $row_pr['artes']+$row_pr['redes']; ?></td>
                </tr>
                <?php  } ?>
              </tbody>
            </table>
            <br>
          </div>
          <center>
          <a onclick="Buscar(this,4);" class="small-box-footer" style="cursor:pointer; cursor: hand;color:white"> Pendientes 
            <i class="fa fa-arrow-circle-down"></i>
          </a></center>
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
                    <td><img src="<?= base_url() ?>images/spt-b.png" width="20" height="20" /></td>
                    <td><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></td>
                    <td><img src="<?= base_url() ?>images/porcentaje-b.png" width="20" height="20" /></td>
                    <!--<td width="45%" rowspan="4"><span ><?php echo $ts; ?></span>
                    <span style=""><?php if($tu!=0 && $tu!="") echo round(($ts/$tu)*100); ?> %</span>
                    </td>-->
                    <!--<td width="45%" rowspan="4"><span style="text-align: center; font-size: 38px;font-weight: bold;"><?php echo $ts; ?></span><br>
                    <span style="text-align: center; font-size: 32px;"><?php if($tu!=0 && $tu!="") echo round(($ts/$tu)*100); ?> %</span>
                    </td>-->
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($row_tp as $row_tp) {  ?>
                    <tr>
                      <td><?php echo $row_tp['usuario_codigo']; ?></td>
                      <td style="text-align: center;"><?php if ($row_tp['artest']=="" && $row_tp['redest']=="") {echo "0";} else {echo $row_tp['total'] ;} ?></td>
                      <td style="text-align: center;"><?php echo $row_tp['artest'] + $row_tp['redest']; ?></td>
                      <td style="text-align: center;"><?php if($row_tp['artes']!=0 && $row_tp['artes']!="") echo round((($row_tp['artest'] + $row_tp['redest'])/($row_tp['artes'] + $row_tp['redes']))*100); ?> %</td>
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
                    <span style="text-align: center; font-size: 32px;"><?php if($tu!=0 && $tu!="") echo round(($ts/$tu)*100); ?> %</span>
                    </td>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <br>
          <center>
          <a onclick="Buscar(this,5);"class="small-box-footer" style="cursor:pointer; cursor: hand;color:white"> Terminados 
            <i class="fa fa-arrow-circle-down"></i>
          </a></center>
          <!--<a onclick="Buscar(this,5);" class="small-box-footer" style="cursor:pointer; cursor: hand;"> Terminados 
            <i class="fa fa-arrow-circle-down"></i>-->
          </a>
        </div>
      </div>

    </div>
    <form method="post" id="formulario_excel" enctype="multipart/form-data" class="formulario" >
      <div class="heading-btn-group">
          <a onclick="Buscar(this,0);"  id="activos" style="color: #ffffff;background-color: #00C000;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Activos</span><i class="icon-arrow-down52"></i></a>
          <a onclick="Buscar(this,6);"  id="todos" style="color: #ffffff;background-color: #0070c0;height: 32px;width: 150px;padding: 5px;" class=" form-group  btn "><span>Todos</span><i class="icon-arrow-down52"></i></a>
          
          <?php if($sesion['id_usuario']==1 || $sesion['id_usuario']==5 || $sesion['id_usuario']==7 || $sesion['id_usuario']==34 || $sesion['id_usuario']==35 || $sesion['id_usuario']==71){ ?>
              
                
                  <a class=" form-group  btn "><input name="archivo_excel" id="archivo_excel" type="file" data-allowed-file-extensions='["xls|xlsx"]'  size="100" required ></a>

                  <a class=" form-group  btn " href="<?= site_url('Administrador/Excel_Vacio_Proyecto2') ?>" title="Estructura de Excel">
                    <img height="40px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel" />
                  </a>

                  <button class="btn btn-primary form-group" type="button" onclick="Importar_Proyectos();">Importar</button>
                
             
            <?php } ?>
        
      </div>
    </form>
    <div class="row">
      <div class="col-lg-12" id="tabla">
        
      </div>
    </div>
  </div>
</div>



<!--<style type="text/css">
     td, th {
         padding: 1px;
         padding-top: 5px;
         padding-right: 8px;
        padding-bottom: 1px;
         padding-left: 8px;
         line-height: 1;
         vertical-align: top;
     }

     .table-total {
         border-spacing: 0;
         border-collapse: collapse;
         }

    .active1 {
    color: #fff;
    background-color: #009245;
    height: 30px;
    width: 110px;
    padding: 5px;
    cursor: default;
  }

  .active2 {
    color: white;
    background-color: #C10010;
    height: 30px;
    width: 110px;
    padding: 5px;
    cursor: default;
  }
</style>-->

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
     // $("#4").addClass('treeview is-expanded');
      $("#1_4").addClass('treeview-item-active');
      
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
    
    Buscar(0);
      });
    </script>



<script>
  $(document).ready(function() {

      // Setup - add a text input to each footer cell
      $('#example thead tr').clone(true).appendTo( '#example thead' );
      $('#example thead tr:eq(1) th').each( function (i) {
          var title = $(this).text();
          
          $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
  
          $( 'input', this ).on( 'keyup change', function () {
              if ( table.column(i).search() !== this.value ) {
                  table
                      .column(i)
                      .search( this.value )
                      .draw();
              }
          } );
      } ); 

      var table = $('#example').DataTable( {
          orderCellsTop: true,
          fixedHeader: true,
          dom: 'Bfrtip',
          pageLength: 50
      } );

  } );
</script>

<?php $this->load->view('Admin/footer'); ?>

<script>
  // TEAMLIDER
  function Nuevo(){
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

  function Buscar(e,status){
    /*if(status==0){
        $("#activos").removeClass();
        $("#todos").removeClass();
        $("#activos").addClass("active1");
        $("#todos").addClass("active2");
    }
    else if(status==6){
      $("#activos").removeClass();
      $("#todos").removeClass();
      $("#activos").addClass("active2" );
      $("#todos").addClass("active1"); 
    }
    else{
      $("#activos").removeClass();
      $("#todos").removeClass();
      $("#activos").addClass("active1");
      $("#todos").addClass("active2");
    }*/
     
      var url = "<?php echo site_url(); ?>Administrador/Busqueda/";
        frm = { 'status': status};
        

        $.ajax({
            type:"POST",
            url: url,
            data:frm,
            success:function (data) {
              $("#tabla").html(data);
            }
        }); 


  }

  function exportar(){
      status=document.getElementById("id_status").value;
      //alert(status);
      var url = "<?php echo site_url(); ?>Administrador/Excel_proyec/";
        frm = { 'status': status};
        $.ajax({
          url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
          //$("#tabla").html(contextResponse);
        })
  }

  function exportar1(){
    var id_status = $("#id_status").val();
    window.location ="<?php echo site_url(); ?>Administrador/Excel_proyec2/"+id_status;
  }
</script>

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
        <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url(); ?>'>
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
      modal.find('.modal-title').text('Imagen Subida')
      $('.alert').hide();//Oculto alert
    }
  )

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
                      //window.location = "<?php echo site_url(); ?>Administrador/proyectos";
                      location.reload(true);
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
                                          //window.location = "<?php echo site_url(); ?>Administrador/proyectos";
                                          location.reload(true);
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
                    //window.location = "<?php echo site_url(); ?>Administrador/proyectos";
                    location.reload(true);
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
