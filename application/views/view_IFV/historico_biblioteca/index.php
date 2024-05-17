<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<!--<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Lista Biblioteca (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nueva Módulo" style="cursor:pointer;margin-right:5px;" href="<?= site_url('AppIFV/Modal_Lista_Biblioteca') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('AppIFV/Excel_Lista_Biblioteca') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_biblioteca" class="col-lg-12">
            </div>
        </div>
    </div>
</div>-->
<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Historia (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            

            <a onclick="Exportar_Historia_Biblioteca();">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row" id="">
      <div class="col-lg-3 col-xs-12">
        <div class="small-box" style="color:#fff;background:#fff">
          <div class="inner" align="center">
            <br><br>
            <h3 style="font-size: 32px;">
              
            </h3>
            <br><br>
          </div>
          
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="color:#fff;background:#c5e0b4">
          <div class="inner" align="center">
            <br><br>
            <h3 style="font-size: 32px;">
              <?php echo $list_dashboard[0]['disponible']; ?>
            </h3>
            <br><br>
          </div>
          <center style="background-color: #00C000;"><a onclick="Buscar(this,2);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Solicitar </a></center>
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="color:#fff;background:#bdd7ee">
          <div class="inner" align="center">
            <br><br>
            <h3 style="font-size: 32px;">
              <?php echo $list_dashboard[0]['por_devolver']; ?>
            </h3>
            <br><br>
          </div>
          <center style="background-color: #0070c0;"><a onclick="Buscar(this,3);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Por Devolver </a></center>
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="color:#fff;background:#f8cbad">
          <div class="inner" align="center">
            <br><br>
            <h3 style="font-size: 32px;">
              <?php echo $list_dashboard[0]['perdido']; ?>
            </h3>
            <br><br>
          </div>
          <center style="background-color: #ff0000;"><a onclick="Buscar(this,3);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Perdido </a></center>
        </div>
      </div>

    </div>
  </div>


  <div class="container-fluid" style="margin-top:15px;margin-bottom:15px;">
    <!--<div class="row col-md-12 col-sm-12 col-xs-12">
        <?php if($_SESSION['usuario'][0]['id_nivel']==9){ ?>
            
            <a onclick="Buscar(this,0);"  id="activos" style="color: #ffffff;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Activos </span><i class="icon-arrow-down52"></i></a>
            
        <?php }else{ ?>
        
        <a onclick="Buscar(this,0);"  id="activos" style="color: #ffffff;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Activos </span><i class="icon-arrow-down52"></i></a>
        <a onclick="Buscar(this,5);"  id="terminados" style="color: #ffffff;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Terminados </span><i class="icon-arrow-down52"></i></a>
        
        <a onclick="Buscar(this,7);"  id="revisados" style="color: #ffffff;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Revisados </span><i class="icon-arrow-down52"></i></a>
        
        <?php if($id_usuario==5){ ?>
          
          <a onclick="Buscar(this,8);"  id="completados" style="color: #ffffff;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Completados </span><i class="icon-arrow-down52"></i></a>
        <?php } ?>
        
        <a onclick="Buscar(this,6);"  id="todos" style="color: #ffffff;background-color: #0070c0;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Todos </span><i class="icon-arrow-down52"></i></a>
        <?php if($id_usuario==5){ ?> 
          
          <a onclick="Completados();" style="color: #ffffff;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>COMPLETAR </span></a>
          <a onclick="Cancelados();" style="color: #ffffff;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>CANCELAR </span></a>
        <?php } ?>
      <?php } ?>
    </div>-->
  </div>

  <div class="container-fluid">
    <div class="row">
      <div id="tabla" class="col-lg-12">
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $("#bibliotecas").addClass('active');
        $("#hbibliotecas").attr('aria-expanded', 'true');
        $("#historias_biblioteca").addClass('active');
		document.getElementById("rbibliotecas").style.display = "block";
        Cargar_Historico_Biblioteca();
        //Lista_Biblioteca();
    });
    function Exportar_Historia_Biblioteca(){
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Historia_Biblioteca";
    }

    
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>

