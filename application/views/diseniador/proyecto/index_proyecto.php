<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
  <div class="panel-heading" >
    <div class="row" >
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Proyectos</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group" >
            <a onclick="Exportar_Proyectos();">
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
        <div class="small-box" style="background-color:#000f9f;color:white;">
          <div class="inner" align="center">
            <h3>
              <span style="font-size: 37px;"><?php echo $row_s[0]['total'];?> </span>| <span style="font-size: 32px;"><?php echo $row_s[0]['artes'] + $row_s[0]['redes'];?></span>
            </h3> 
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="background-color:#000f9f;color:white;">
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
          <center><a style="color:white" onclick="Buscar(1);" class="small-box-footer" style="cursor:pointer; cursor: hand;">Solicitado<i class="fa fa-arrow-circle-down"></i>
          </a></center>
        </div>
      </div>
    
      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="background-color:#cddb00;color:white;">
          <div class="inner" align="center">
            <h3><span style="font-size: 37px;"><?php echo $row_a[0]['total'];?></span> | <span style="font-size: 30px;"><?php echo $row_a[0]['artes'] + $row_a[0]['redes'];?></span></h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="background-color:#cddb00;color:white;">
                <tr align="center">
                  <td></td>
                  <td><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></td>
                  <td><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></td>
                </tr> 
              </thead>
              <tbody>
                <?php foreach($row_a as $row_a) {  ?>
                <tr>
                  <td> <?php echo $row_a['usuario_codigo']; ?></td>
                  <td  style="text-align: center;" > <?php echo $row_a['total']; ?></td>
                  <td  style="text-align: center;" > <?php echo $row_a['artes']+$row_a['redes']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>

            <br>
          </div> 
          <center>
          <a style="color:white" onclick="Buscar(2);" class="small-box-footer" style="cursor:pointer; cursor: hand;"> Asignados  
            <i class="fa fa-arrow-circle-down"></i>
          </a></center>                                           
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="background-color:#37b5e7;color:white;">
          <div class="inner" align="center">
            <h3>
              <span style="font-size: 37px;"><?php if ($row_et[0]['artes']!=null || $row_et[0]['redes']!=null) echo $row_et[0]['total']; else echo "0"; ?> </span>| <span style="font-size: 30px;"><?php echo $row_et[0]['artes'] + $row_et[0]['redes'];?></span>
            </h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead style="background-color:#37b5e7;color:white;">
                <tr align="center">
                  <td></td>
                  <td><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></td>
                  <td><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></td>
                </tr>
              </thead>
              <tbody>
              <?php foreach($row_et as $row_et) {  ?>
                <tr>
                  <td><?php echo $row_et['usuario_codigo']; ?></td>
                  <td style="text-align: center;"> <?php if ($row_et['artes']!=null || $row_et['redes']!=null) echo $row_et['total']; else echo "0"; ?></td>
                  <td style="text-align: center;"> <?php echo $row_et['artes']+$row_et['redes']; ?></td>
                </tr>
              <?php  } ?>
              </tbody>
            </table>
            <br>
          </div>  
          <center>
          <a onclick="Buscar(3);" class="small-box-footer" style="cursor:pointer; cursor: hand;color:white"> En Trámite 
            <i class="fa fa-arrow-circle-down"></i>
          </a></center>                                          
        </div>
      </div>
      
      <div class="col-lg-2 col-xs-12">
        <div class="small-box "  style="background-color:#f18a00;color:white;">
          <div class="inner" align="center">
            <h3><span style="font-size: 37px;"><?php if ($row_pr[0]['artes']!=null || $row_pr[0]['redes']!=null) echo $row_pr[0]['total']; else echo "0"; ?></span> | <span style="font-size: 30px;"><?php echo $row_pr[0]['artes'] + $row_pr[0]['redes'];?></span></h3>
          </div>
          <div>
            <table id="" class="table-total" align="center">
              <thead  style="background-color:#f18a00;color:white;">
                <tr align="center">                                                        
                  <td></td>
                  <td><img src="<?= base_url() ?>images/sp-b.png" width="20" height="20" /></td>
                  <td><img src="<?= base_url() ?>images/tt-b.png" width="20" height="20" /></td>
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
          <a onclick="Buscar(4);" class="small-box-footer" style="cursor:pointer; cursor: hand;color:white"> Pendientes 
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
            <div class="col-lg-6">
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
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

            <div class="col-lg-6">
              <table id="" width="90%" class="table-total" align="center">
                <thead style="color:#fff;background:#3BB9AE">
                  <tr align="center">
                    <td>
                      <span style="text-align: center; font-size: 35px;font-weight: bold;"><?php echo $ts; ?> |</span> 
                      <span style="text-align: center; font-size: 32px;"><?php if($tu!=0 && $tu!="") echo round(($ts/$tu)*100); ?>%</span>
                    </td>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <br>
          <center>
          <a onclick="Buscar(5);" class="small-box-footer" style="cursor:pointer; cursor: hand;color:white"> Terminados 
            <i class="fa fa-arrow-circle-down"></i>
          </a></center>
        </div>
      </div>
    </div>
  
    <div class="row">
      <div class="col-lg-12" id="tabla" style="margin-top:20px;overflow-x:auto;">
      </div>
    </div>
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
      $("#comunicacion").addClass('active');
      $("#hcomunicacion").attr('aria-expanded','true');
      $("#proyectos").addClass('active');
      document.getElementById("rcomunicacion").style.display = "block";

      Buscar(0);
  } );

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

      var url="<?php echo site_url(); ?>Diseniador/Busqueda";

      $.ajax({
          type:"POST",
          url:url,
          data:{'status':status},
          success:function (resp) {
              $('#tabla').html(resp);
          }
      });
  }

  function Exportar_Proyectos(){
    var id_status = $("#id_status").val();
    window.location ="<?php echo site_url(); ?>Diseniador/Excel_Proyectos/"+id_status;
  }
</script>

<?php $this->load->view('Admin/footer'); ?>