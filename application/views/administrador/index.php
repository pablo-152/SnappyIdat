<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
    <!-- Navbar-->
   <?php $this->load->view('Admin/header'); ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php $this->load->view('Admin/nav'); ?>
      <main class="app-content">
      <!--<div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-book fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        </ul>
      </div>-->

      <input type="hidden" id="" name="" value="<?php echo $fondo[0]['estado']; ?>">
        <div class="row" >
        <div class="col-md-12" class="collapse" id="collapseExample" align="center">
         
            
                <?php 

                $total = count($fondo);
               // echo($total);

                if ($total>0) {
                  ?>
                <img src="<?= base_url().$fondo[0]['foto']; ?>">
                <?php } else {?>
                <img src="<?= base_url() ?>imgz/fondos.png">
                <?php }?>
          </div>
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
    <?php $this->load->view('Admin/footer'); ?>

    <script type="text/javascript">
 
function corregirpapeleta()
{
  frmlmotivocorregir.submit();
}
  

  </script>
