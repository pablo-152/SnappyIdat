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
</style>


<div class="panel panel-flat">
    <div class="panel-heading">
      <div class="row">
        <div class="x_panel">
          <div class="page-title" style="background-color: #C1C1C1;">
            
            <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 4%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> Retirar Alumno</b></span></h4>
          </div>
  
          <div class="heading-elements">
            <div class="heading-btn-group">

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
      <form id="form-retiro" method="POST" enctype="multipart/form-data" class="formulario">
        <div class="row">
          <div class="col-md-12 row">
              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Código&nbsp;Arpay:</label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Codigo']; ?>">
              </div>

              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">Especialidad: </label>
              </div>
              <div class="form-group col-md-3">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Especialidad']; ?>">
              </div>
          </div> 
          <div class="col-md-12 row">
              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">A.&nbsp;Paterno: </label>
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Paterno']; ?>">
              </div>

              <div class="form-group col-md-1">
                <label class="col-sm-3 control-label text-bold margintop">A.&nbsp;Materno: </label>
              </div>
              <div class="form-group col-md-2">
                  <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Materno']; ?>">
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
              <label class="col-sm-3 control-label text-bold margintop">Grupo: </label>
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
            </div>
            <div class="form-group col-md-1">
              <label class="col-sm-3 control-label text-bold margintop">Turno: </label>
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Turno']; ?>">
            </div>
              <div class="form-group col-md-1">
              <label class="col-sm-3 control-label text-bold margintop">Módulo: </label>
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Modulo']; ?>">
            </div>
          </div>

          <div class="col-md-12 row" style="background-color:#c1c1c1;margin-left: auto;">
            <div class="form-group col-md-12">
            </div>
            <div class="form-group col-md-2">
              <label class=" control-label text-bold margintop">¿Desde cuando no asiste? </label>
            </div>
            <div class="form-group col-md-2">
              <input type="date" class="form-control" id="fecha_nasiste" name="fecha_nasiste">
            </div>

            <div class="form-group col-md-1">
            </div>

            <div class="form-group col-md-2">
              <label class="control-label text-bold margintop">Motivo del retiro: </label>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="id_motivo" id="id_motivo" onchange="Motivo()">
                <option value="0">Seleccione</option>
                <?php foreach($list_motivo as  $list){?> 
                  <option value="<?php echo $list['id_motivo'] ?>"><?php echo $list['nom_motivo'] ?></option>  
                <?php } ?>
              </select>
            </div>
            <div class="form-group col-md-4">
            </div>
            <div id="div_otro" style="display:none">
              <div class="form-group col-md-2" >
                <label class=" control-label text-bold margintop">¿Cual sería? </label>
              </div>
              <div class="form-group col-md-10">
                <input type="text" class="form-control" id="otro_motivo" name="otro_motivo">
              </div>
            </div>
            <div class="form-group col-md-12" >
            </div>
            <div class="form-group col-md-2" >
              <label class=" control-label text-bold margintop">¿Presento FUT de retiro? </label>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="fut" id="fut">
                <option value="0">Seleccione</option>
                <option value="1">SI</option>
                <option value="2">NO</option>
              </select>
            </div>
            <div class="form-group col-md-1" >
              <label class=" control-label text-bold margintop">Fecha:</label>
            </div>
            <div class="form-group col-md-2">
              <input type="date" class="form-control" id="fecha_fut" name="fecha_fut">
            </div>
            <div class="form-group col-md-2" >
              <label class=" control-label text-bold margintop">Tkt o Boleta:</label>
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" id="tkt_boleta" name="tkt_boleta">
            </div>
            <div class="form-group col-md-12" >
            </div>
            <div class="form-group col-md-1" >
              <label class=" control-label text-bold margintop">Pagos:</label>
            </div>
            <div class="form-group col-md-1">
              <input type="text" class="margintop form-control " disabled value="<?php echo $get_id[0]['Matricula']; ?>">
            </div>
            <div class="form-group col-md-2" >
              <label class=" control-label text-bold margintop">¿Pagos pendientes? </label>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="pago_pendiente" id="pago_pendiente">
                <option value="0">Seleccione</option>
                <option value="1">SI</option>
                <option value="2">NO</option>
              </select>
            </div>
            <div class="form-group col-md-1" >
              <label class=" control-label text-bold margintop">Monto:</label>
            </div>
            <div class="form-group col-md-1">
              <input type="text" class="margintop form-control" id="monto" name="monto" onkeypress="return soloNumeros(event)">
            </div>
            
          </div>
          <div class="col-md-12 row">
            <div class="form-group col-md-12">
            </div>
            <div class="form-group col-md-2">
              <label class=" control-label text-bold margintop">¿Alumno&nbsp;contactado&nbsp;telefonicamente? </label>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="contacto" id="contacto">
                <option value="0">Seleccione</option>
                <option value="1">Si</option>
                <option value="2">No</option>
                <option value="3">Incomunicado</option>
              </select>
            </div>
            <div class="form-group col-md-1">
              <label class="control-label text-bold margintop">Fecha: </label>
            </div>
            <div class="form-group col-md-2">
              <input type="date" class="form-control" id="fecha_contacto" name="fecha_contacto">
            </div>
            <div class="form-group col-md-1" >
              <label class=" control-label text-bold margintop">Hora:</label>
            </div>
            <div class="form-group col-md-1">
              <input type="time" class="form-control" id="hora_contacto" name="hora_contacto">
            </div>
            <div class="form-group col-md-12" >
              <label class=" control-label text-bold margintop">Resuma de una forma clara contenido de ese contacto</label>
            </div>
            <div class="form-group col-md-12" >
              <textarea class="form-control" name="resumen" id="resumen" cols="4" rows="4"></textarea>
            </div>
            <div class="form-group col-md-2">
              <label class="control-label text-bold margintop">¿Posibilidad&nbsp;de&nbsp;reincorporacion?: </label>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="p_reincorporacion" id="p_reincorporacion">
                <option value="0">Seleccione</option>
                <option value="1">Si</option>
                <option value="2">No</option>
              </select>
            </div>
            <div class="form-group col-md-12">
            </div>
            <div class="form-group col-md-12" >
              <label class=" control-label text-bold margintop">Creado por: <?php echo $_SESSION['usuario'][0]['usuario_codigo']." ".date('d/m/Y h:i a', time()); ?></label><br>
              <label class=" control-label text-bold margintop">Administración:</label><br>
              <label class=" control-label text-bold margintop">Sec. Académica:</label>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $get_id[0]['Id']; ?>">
            <button type="button" class="btn btn-primary" onclick="Guardar_Retiro()" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar </button>
          </div>
        </div>
      </form>

    </div>
</div>

<script>
function Motivo(){
  var div = document.getElementById("div_otro");
  $('#otro_motivo').val('');
  if($('#id_motivo').val()==1){
    div.style.display = "block";
  }else{
    div.style.display = "none";
  }
  
  
}
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>