<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
    <!-- Navbar-->
   <?php $this->load->view('general/header'); ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php $this->load->view('general/nav'); ?>
      <main class="app-content">
     
      <link href="<?=base_url() ?>template/css/boton.css" rel="stylesheet" type="text/css">
       
        <input type="hidden" id="" name="" value="<?php echo $fondo[0]['estado']; ?>">
        <div class="row">
    <div class="col-md-12" class="collapse" id="collapseExample" align="center">
    <?php if(count($fondo)>0){ ?>
      <div class="row">
        <div class="col-12 blog-details">
          <div class="blog-details-img">
            <img class="img-fluid" src="<?=base_url().$fondo[0]['foto']; ?>" alt="Intro" width="600" height="600">
            <!--<a href="#" class="action-buttonn animaterr yellowoow posicionamiento">
              <img class="img-fluid-boton" src="<?= base_url() ?>template/img/notify.png " alt="Intro" width="100" height="100">
              <img class="ws" src="<?= base_url() ?>assets//img_modal_alumno/elementopopup-03.png" alt="" srcset="">
              <svg width="20" height="50" viewBox="0 50 200 100">
                <text x="0" y="100" style="fill: white;stroke:#fa0400;stroke-width: 16px;font-size: 320px;font-weight: bold;font-family: 'GothamCond-Bold';">
                  <?php echo $cant_avisos ?>
                </text>
              </svg>
            </a>-->
          </div>

          <div class="blog-details-img">
            <!--<a href="#" class="action-buttonn animaterr yellowoow posicionamiento2">
              <img class="img-fluid-boton" src="<?= base_url() ?>template/img/notify.png " alt="Intro" width="100" height="100">
              <img class="ws" src="<?= base_url() ?>assets//img_modal_alumno/elementopopup-03.png" alt="" srcset="">
              <svg width="20" height="50" viewBox="0 50 200 100">
                <text x="0" y="100" style="fill: white;stroke:#fa0400;stroke-width: 16px;font-size: 320px;font-weight: bold;font-family: 'GothamCond-Bold';">
                  <?php echo $cant_avisos ?>
                </text>
              </svg>
            </a>-->
          </div>
        </div>
      </div>
    <?php }else{ ?>
      <img src="<?= base_url() ?>fondos/fondo.png">
    <?php } ?>
  </div>
        
    </main>
    <!-- Aprobar general -->
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
    <?php $this->load->view('general/footer'); ?>
