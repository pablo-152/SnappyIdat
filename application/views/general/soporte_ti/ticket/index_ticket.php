<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
$id_usuario = $_SESSION['usuario'][0]['id_usuario'];
?>

<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Tickets (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <?php if ($sesion['id_usuario'] == 1 || $sesion['id_usuario'] == 5 || $sesion['id_usuario']==7
              || $sesion['id_usuario'] == 48 || $sesion['id_usuario'] == 81 || $sesion['id_usuario'] == 85
              || $sesion['id_usuario'] == 82 || $sesion['id_usuario'] == 33) { ?>
              <a title="Nuevo Ticket" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('General/Modal_Ticket') ?>">
                <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel"/>
              </a>
            <?php } ?>  

            <a onclick="Exportar_Ticket();">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="color:#fff;background:#000f9f">
          <div class="inner" align="center">
            <br><br>
            <h3 style="font-size: 32px;">
              <?php echo $solicitado[0]['total']; ?>
            </h3>
            <br><br>
          </div>
          <center><a onclick="Lista_Ticket(1);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Solicitados <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="color:#fff;background:#f18a00">
          <div class="inner" align="center">
            <br><br>
            <h3 style="font-size: 32px;">
              <?php echo $presupuesto[0]['total']; ?>
            </h3>
            <br><br>
          </div>
          <center><a onclick="Lista_Ticket(2);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Presupuesto <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="small-box" style="color:#fff;background:#cddb00">
          <div class="inner" align="center">
            <br><br>
            <h3 style="font-size: 32px;">
              <?php echo $tramite[0]['total']; ?>
            </h3>
            <br><br>
          </div>
          <center><a onclick="Lista_Ticket(3);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">En trámite <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
        </div>
      </div>

      <div class="col-lg-2 col-xs-12" style="color:#fff;background:#37b5e7">
        <div class="small-box bg-gray">
          <div class="inner" align="center">
            <br><br>
            <h3 style="font-size: 32px;">
              <?php echo $pendiente[0]['total']; ?>
            </h3>
            <br><br>
          </div>
          <center><a onclick="Lista_Ticket(4);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Pend. Respuesta <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
        </div>
      </div>

      <?php if($sesion['id_usuario']==5 || $sesion['id_usuario']==35 || $sesion['id_usuario']==71){ ?>
        <div class="col-lg-2 col-xs-12">
          <div class="small-box bg-snappy" style="color:#fff;background:#3BB9AE;padding-top:12px;">
            <div class="inner" align="center">
              <h3 style="font-size: 32px;">
                <?php echo $terminado[0]['total']; ?> | <span style="font-size: 32px;">
                  <?php if ($terminado[0]['total'] != "0") {
                    $hym = intdiv($tiempo_total[0]['minuto_total'], 60);
                    $min_conv = $tiempo_total[0]['minuto_total'] % 60;
                    echo ($tiempo_total[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
                  } ?></span>
              </h3>
            </div>

            <div class="row">
              <div class="col-lg-12">
                <table class="table-total" align="center">
                  <tbody>
                    <tr style="font-size: 20px;" align="center">
                      <td>Bug:</td>
                      <td><?php echo $terminado_bug[0]['cantidad']; ?></td>
                      <td><?php if ($terminado_bug[0]['cantidad'] != "0") {
                            $hym = intdiv($terminado_bug[0]['minuto_total'], 60);
                            $min_conv = $terminado_bug[0]['minuto_total'] % 60;
                            echo ($terminado_bug[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
                          } ?></td>
                    </tr>
                    <tr style="font-size: 20px;" align="center">
                      <td>Improve:</td>
                      <td><?php echo $terminado_improve[0]['cantidad']; ?></td>
                      <td><?php if ($terminado_improve[0]['cantidad'] != "0") {
                            $hym = intdiv($terminado_improve[0]['minuto_total'], 60);
                            $min_conv = $terminado_improve[0]['minuto_total'] % 60;
                            echo ($terminado_improve[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
                          } ?></td>
                    </tr>
                    <tr style="font-size: 20px;" align="center">
                      <td>New:</td>
                      <td><?php echo $terminado_new[0]['cantidad']; ?></td>
                      <td><?php if ($terminado_new[0]['cantidad'] != "0") {
                            $hym = intdiv($terminado_new[0]['minuto_total'], 60);
                            $min_conv = $terminado_new[0]['minuto_total'] % 60;
                            echo ($terminado_new[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
                          } ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <br>
            <center><a onclick="Lista_Ticket(5);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Terminados <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
          </div>
        </div>

        <div class="col-lg-2 col-xs-12">
          <div class="small-box" style="color:#fff;background:#343399;padding-top:1px;">
            <div class="inner" align="center">
              <br><br>
              <h3 style="font-size: 32px;" id="titulo_reporte">
                <?php echo $pago[0]['total']; ?> | <span style="font-size: 32px;">
                  <?php if ($pago[0]['total'] != "0") {
                    $hym = intdiv($pago[0]['minutos'], 60);
                    $min_conv = $pago[0]['minutos'] % 60;
                    echo ($pago[0]['horas'] + $hym) . "h" . " " . $min_conv . "min";
                  }else{ echo 0; } ?></span>
              </h3>
              <br><br>
            </div>
            <center><a class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Pagos <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
          </div>
        </div>
      <?php }else{ ?>
        <div class="col-lg-4 col-xs-12">
          <div class="small-box bg-snappy" style="color:#fff;background:#3BB9AE;padding-top:12px;">
            <div class="inner" align="center">
              <h3 style="font-size: 32px;">
                <?php echo $terminado[0]['total']; ?> | <span style="font-size: 32px;">
                  <?php if ($terminado[0]['total'] != "0") {
                    $hym = intdiv($tiempo_total[0]['minuto_total'], 60);
                    $min_conv = $tiempo_total[0]['minuto_total'] % 60;
                    echo ($tiempo_total[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
                  } ?></span>
              </h3>
            </div>

            <div class="row">
              <div class="col-lg-12">
                <table class="table-total" align="center">
                  <tbody>
                    <tr style="font-size: 20px;" align="center">
                      <td>Bug:</td>
                      <td><?php echo $terminado_bug[0]['cantidad']; ?></td>
                      <td><?php if ($terminado_bug[0]['cantidad'] != "0") {
                            $hym = intdiv($terminado_bug[0]['minuto_total'], 60);
                            $min_conv = $terminado_bug[0]['minuto_total'] % 60;
                            echo ($terminado_bug[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
                          } ?></td>
                    </tr>
                    <tr style="font-size: 20px;" align="center">
                      <td>Improve:</td>
                      <td><?php echo $terminado_improve[0]['cantidad']; ?></td>
                      <td><?php if ($terminado_improve[0]['cantidad'] != "0") {
                            $hym = intdiv($terminado_improve[0]['minuto_total'], 60);
                            $min_conv = $terminado_improve[0]['minuto_total'] % 60;
                            echo ($terminado_improve[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
                          } ?></td>
                    </tr>
                    <tr style="font-size: 20px;" align="center">
                      <td>New:</td>
                      <td><?php echo $terminado_new[0]['cantidad']; ?></td>
                      <td><?php if ($terminado_new[0]['cantidad'] != "0") {
                            $hym = intdiv($terminado_new[0]['minuto_total'], 60);
                            $min_conv = $terminado_new[0]['minuto_total'] % 60;
                            echo ($terminado_new[0]['hora_total'] + $hym) . "h" . " " . $min_conv . "min";
                          } ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <br>
            <center><a onclick="Lista_Ticket(5);" class="small-box-footer" style="color:#fff;cursor:pointer; cursor: hand;">Terminados <i class="glyphicon glyphicon-circle-arrow-down"></i></a></center>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php if($sesion['id_usuario']==33 ||$sesion['id_usuario']==5 || $sesion['id_usuario']==35 || $sesion['id_usuario']==71){ ?>
    <div class="container-fluid" style="margin-top:15px;">
      <div class="col-md-12 row">
        <div class="form-group col-md-2">
          <label class="control-label text-bold label_tabla">Mes:</label>
          <select class="form-control" name="mes_reporte" id="mes_reporte">
            <option value="0">Seleccione</option>
            <?php foreach ($list_mes as $list) { ?>
              <option value="<?php echo $list['cod_mes']; ?>" <?php if($list['cod_mes']==date('m')){ echo "selected"; } ?>><?php echo $list['nom_mes']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold label_tabla">Año:</label>
          <select class="form-control" name="anio_reporte" id="anio_reporte">
            <option value="0">Seleccione</option>
            <?php foreach ($list_anio as $list) { ?>
              <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['nom_anio']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-2">
          <button type="button" style="margin-top:25px;" class="btn btn-success" onclick="Reporte_Pagos();">Buscar</button>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="container-fluid" style="margin-top:15px;margin-bottom:15px;">
    <div class="row col-md-12 col-sm-12 col-xs-12">
      <?php if($_SESSION['usuario'][0]['id_nivel']==9){ ?>
        <a onclick="Lista_Ticket(0);" id="activos" style="color: #000000;background-color: #00C000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Activos </span><i class="icon-arrow-down52"></i></a>
        <a onclick="Lista_Ticket(5);" id="terminados" style="color: #000000;background-color: #7F7F7F;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Terminados </span><i class="icon-arrow-down52"></i></a>
        <!--<a onclick="Lista_Ticket(6);" id="todos" style="color: #000000;background-color: #0070c0;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Todos </span><i class="icon-arrow-down52"></i></a>-->
      <?php }else{ ?> 
        <a onclick="Lista_Ticket(0);" id="activos" style="color: #000000;background-color: #00C000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Activos </span><i class="icon-arrow-down52"></i></a>
        <a onclick="Lista_Ticket(5);" id="terminados" style="color: #000000;background-color: #7F7F7F;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Terminados </span><i class="icon-arrow-down52"></i></a>
        <a onclick="Lista_Ticket(7);" id="revisados" style="color: #000000;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Revisados </span><i class="icon-arrow-down52"></i></a>
        <?php if($id_usuario==5 || $id_usuario==33){ ?>
          <a onclick="Lista_Ticket(8);"  id="completados" style="color: #000000;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Completados </span><i class="icon-arrow-down52"></i></a>
        <?php } ?>
        <!--<a onclick="Lista_Ticket(6);"  id="todos" style="color: #000000;background-color: #0070c0;height:32px;width:150px;padding:5px;" class="form-group btn "><span>Todos </span><i class="icon-arrow-down52"></i></a>-->
        <?php if($id_usuario==5 || $id_usuario==33){ ?> 
          <a onclick="Completados();" style="color: #000000;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>COMPLETAR </span></a>
          <a onclick="Cancelados();" style="color: #000000;background-color: #C00000;height:32px;width:150px;padding:5px;" class="form-group btn "><span>CANCELAR </span></a>
        <?php } ?>
      <?php } ?>
    </div>
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
    $("#soporteti").addClass('active');
    $("#hsoporteti").attr('aria-expanded', 'true');
    $("#tickets").addClass('active');
    document.getElementById("rsoporteti").style.display = "block";

    Lista_Ticket(0);
  });
</script>

<?php $this->load->view('general/footer'); ?>

<script>
function Lista_Ticket(status) {
    Cargando();

    var url="<?php echo site_url(); ?>General/Lista_Ticket";

    $.ajax({
        type:"POST",
        url:url,
        data:{'status':status},
        success:function (data) {
            $('#tabla').html(data);
        }
    });

    /** */
    var id_nivel=<?php echo $_SESSION['usuario'][0]['id_nivel']; ?>;
    var id_usuario=<?php echo $_SESSION['usuario'][0]['id_usuario']; ?>;
    
    var activos = document.getElementById('activos');
    var terminados = document.getElementById('terminados');
    //var todos = document.getElementById('todos');
    if(id_nivel!=9){
        var revisados = document.getElementById('revisados');
    }
    if(id_usuario==5){
        var completados = document.getElementById('completados');
    }
    if(status == 0){
        activos.style.color = '#FFFFFF';
        terminados.style.color = '#000000';
        if(id_nivel!=9){
            revisados.style.color = '#000000';
            if(id_usuario==5){
              completados.style.color = '#000000';
            }
        }
        //todos.style.color = '#000000';
    }else if(status == 5){
        activos.style.color = '#000000';
        terminados.style.color = '#FFFFFF';
        revisados.style.color = '#000000';
        if(id_usuario==5){
            completados.style.color = '#000000';
        }
        //todos.style.color = '#000000';
    /*}else if(status == 6){
        activos.style.color = '#000000';
        terminados.style.color = '#000000';
        revisados.style.color = '#000000';
        if(id_usuario==5){
            completados.style.color = '#000000';
        }
        todos.style.color = '#FFFFFF';*/
    }else if(status == 7){
        activos.style.color = '#000000';
        terminados.style.color = '#000000';
        revisados.style.color = '#FFFFFF';
        if(id_usuario==5){
            completados.style.color = '#000000';
        }
        //todos.style.color = '#000000';
    }else if(status == 8){
        activos.style.color = '#000000';
        terminados.style.color = '#000000';
        revisados.style.color = '#000000';
        if(id_usuario==5){
            completados.style.color = '#FFFFFF';
        }
        //todos.style.color = '#000000';
    }else{
        activos.style.color = '#000000';
        terminados.style.color = '#000000';
        revisados.style.color = '#000000';
        if(id_usuario==5){
          completados.style.color = '#000000';
        }
        //todos.style.color = '#000000';
    }
}

function Exportar_Ticket() {
    $('#formularioxls').submit();
}

function Reporte_Pagos() {
    var mes_reporte = $("#mes_reporte").val();
    var anio_reporte = $("#anio_reporte").val();
    var url="<?php echo site_url(); ?>General/Reporte_Pagos";
    $.ajax({
        type:"POST",
        url:url,
        data: {'mes_reporte':mes_reporte,'anio_reporte':anio_reporte},
        success:function (data) {
            $('#titulo_reporte').html(data);
        }
    });
}
</script>