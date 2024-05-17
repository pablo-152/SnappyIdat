<?php
  $sesion =  $_SESSION['usuario'][0];
  defined('BASEPATH') or exit('No direct script access allowed');
  $id_nivel = $_SESSION['usuario'][0]['id_nivel'];
  $id_usuario = $_SESSION['usuario'][0]['id_usuario'];
?>

<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>

<style>
    th {
         text-align: center; 
    }

    .melon{
      background-color: #f8cbad;
    }

    table tbody tr td:nth-child(5){
      background-color: #fbe5d6;
    }

    .violeta{
      background-color: #d9bde3;
    }

    table tbody tr td:nth-child(9){
      background-color: #f1d7fc;
    }

    .azulino{
      background-color: #bdd7ee;
    }

    table tbody tr td:nth-child(13){
      background-color: #deebf7;
    }
    
    .celeste{
      background-color: #34a69d;
      color: white;
    }

    .help{
      cursor:help;
    }
</style>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Soporte TI - Informe (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <?php if($id_usuario==7 || $id_usuario==1 || $id_usuario==5){ ?>
              <a onclick="Bloquear_Ticket();" style="cursor:pointer;margin-right:5px;">
                <img src="<?= base_url() ?>template/img/bloquear.png">
              </a>
            <?php } ?>
            <a onclick="Excel_General();">
              <img src="<?= base_url() ?>template/img/excel.png">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="col-md-12 row" style="margin-top:15px;margin-bottom:15px;">
      <div class="form-group col-md-2">
        <label class="control-label text-bold label_tabla">Año:</label>
        <select class="form-control" name="anio_informe" id="anio_informe" onchange="Buscar_Informe();">
          <?php foreach ($list_anio as $list){ ?>
            <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>>
              <?php echo $list['nom_anio']; ?>
            </option>
          <?php } ?>
        </select>
      </div>
    </div>
  </div>
  
  <div class="container-fluid">
    <div class="row">
      <form method="post" id="frm_informe" enctype="multipart/form-data" class="formulario">
        <div id="list_informe" class="col-lg-12">
          <table id="example" class="table table-hover table-bordered table-striped" width="100%">
            <thead>
              <tr style="font-weight: bold;">
                <td class="text-center" rowspan="2">Semana</td>
                <td class="text-center melon" colspan="4">Bugs</td>
                <td class="text-center violeta" colspan="4">Improve</td>
                <td class="text-center azulino" colspan="4">News</td>
                <td class="text-center celeste" colspan="4">TOTALES</td>
                <td class="text-center" colspan="7">Estado</td>
              </tr>
              <tr style="font-weight: bold;"> 
                <th class="text-center melon help" title="Solicitados">SOL</td>
                <th class="text-center melon help" title="Terminados">TER</td>
                <th class="text-center melon help" title="Revisados">RVS</td>
                <th class="text-center melon">Horas</td>
                <th class="text-center violeta help" title="Solicitados">SOL</td>
                <th class="text-center violeta help" title="Terminados">TER</td>
                <th class="text-center violeta help" title="Revisados">RVS</td>
                <th class="text-center violeta">Horas</td>
                <th class="text-center azulino help" title="Solicitados">SOL</td>
                <th class="text-center azulino help" title="Terminados">TER</td>
                <th class="text-center azulino help" title="Revisados">RVS</td>
                <th class="text-center azulino">Horas</td>
                <th class="text-center celeste help" title="Solicitados">SOL</th>
                <th class="text-center celeste help" title="Terminados">TER</th>
                <th class="text-center celeste help" title="Revisados">RVS</th>
                <th class="text-center celeste">Horas</th>
                <th class="text-center">Estado</th>
                <th class="text-center help" title="Solicitados">Soli</th>
                <th class="text-center help" title="Asignados">Asig</th>
                <th class="text-center help" title="En Trámite">Trám</th>
                <th class="text-center">Pend.&nbsp;Resp.</th>
                <th class="text-center"></th>
                <th class="text-center"></th>
              </tr>
            </thead>

            <?php foreach ($list_informe as $list) { ?>
              <tr class="text-center">
                <td align="left"><?php echo "<b>".$list['semana']."</b> (".$list['primer']." - ".$list['ultimo'].")"; ?></td>
                <td><?php echo $list['bug_solici']; ?></td>
                <td><?php echo $list['bug_termi']; ?></td>
                <td><?php echo $list['bug_revi']; ?></td>
                <td class="text-right">
                    <?php
                        $h = 0;
                        $m = 0;
                        $h = $list['hr_bug_ter_rev'];
                        $minutes = $list['min_bug_ter_rev'];
                        $zero    = new DateTime('@0');
                        $offset  = new DateTime('@' . $minutes * 60);
                        $diff    = $zero->diff($offset);
                        $hora = $diff->format('%h');
                        $minuto = $diff->format('%i');
                        echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT);
                        /*echo ($h + $hora) . ":" . $minuto;
                        if ($h != 0) {
                        echo " hr";
                        } else {
                        echo " min";
                        }*/
                    ?>
                </td>
                <td><?php echo $list['improve_solici']; ?></td>
                <td><?php echo $list['improve_termi']; ?></td>
                <td><?php echo $list['improve_revi']; ?></td>
                <td class="text-right">
                    <?php
                        $h = 0;
                        $m = 0;
                        $h = $list['hr_improve_ter_rev'];
                        $minutes = $list['min_improve_ter_rev'];
                        $zero    = new DateTime('@0');
                        $offset  = new DateTime('@' . $minutes * 60);
                        $diff    = $zero->diff($offset);
                        $hora = $diff->format('%h');
                        $minuto = $diff->format('%i');
                        echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT);
                        /*echo ($h + $hora) . ":" . $minuto;
                        if ($h != 0) {
                        echo " hr";
                        } else {
                        echo " min";
                        }*/
                    ?>
                </td>
                <td><?php echo $list['new_solici']; ?></td>
                <td><?php echo $list['new_termi']; ?></td>
                <td><?php echo $list['new_revi']; ?></td>
                <td class="text-right">
                    <?php
                        $h = 0;
                        $m = 0;
                        $h = $list['hr_new_ter_rev'];
                        $minutes = $list['min_new_ter_rev'];
                        $zero    = new DateTime('@0');
                        $offset  = new DateTime('@' . $minutes * 60);
                        $diff    = $zero->diff($offset);
                        $hora = $diff->format('%h');
                        $minuto = $diff->format('%i');
                        echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT);
                        /*echo ($h + $hora) . ":" . $minuto;
                        if ($h != 0) {
                        echo " hr";
                        } else {
                        echo " min";
                        }*/
                    ?>
                </td>
                <td><?php echo $list['total_solicitado']; ?></td>
                <td><?php echo $list['total_terminado']; ?></td>
                <td><?php echo $list['total_revisado']; ?></td>
                <td class="text-right">
                    <?php
                        $h = 0;
                        $m = 0;
                        $h = $list['hr_total_ter'];
                        $minutes = $list['min_total_ter'];
                        $zero    = new DateTime('@0');
                        $offset  = new DateTime('@' . $minutes * 60);
                        $diff    = $zero->diff($offset);
                        $hora = $diff->format('%h');
                        $minuto = $diff->format('%i');
                        echo str_pad(($h+$hora),2,"0",STR_PAD_LEFT).":".str_pad($minuto,2,"0",STR_PAD_LEFT);
                        /*echo ($h + $hora) . ":" . $minuto;
                        if ($h != 0) {
                        echo " hr";
                        } else {
                        echo " min";
                        }*/
                    ?>
                </td>
                <td><span class='badge' <?php if($list['estado_semana']=="Pendiente"){ echo "style='background:#0070C0;color:white;'"; }else{echo "style='background:#C00000;color:white;'"; }?>><?php echo $list['estado_semana'] ?></span></td>
                <td><?php echo $list['t_estado_soli']; ?></td>
                <td><?php echo $list['t_estado_asig']; ?></td>
                <td><?php echo $list['t_estado_trami']; ?></td>
                <td><?php echo $list['t_estado_pendresp']; ?></td>
                <td><input required type="checkbox" id="id_informe[]" name="id_informe[]" value="<?php echo $list['semana'] . "-" . $list['anio']; ?>"></td>
                <td>
                    <a href="<?= site_url('General/Excel_Informe_Periodo') ?>/<?php echo $list['semana'] ?>/<?php echo $list['anio'] ?>" title="Exportar Excel">
                        <img height="20px" src="<?= base_url() ?>template/img/excel_tabla.png" alt="Exportar Excel" />
                    </a>
                </td>
              </tr>
            <?php } ?>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $("#soporteti").addClass('active');
    $("#hsoporteti").attr('aria-expanded', 'true');
    $("#informeti").addClass('active');
    $("#hinformeti").attr('aria-expanded', 'true');
    $("#hlist_informe").addClass('active');
    document.getElementById("rsoporteti").style.display = "block";
    document.getElementById("rinformeti").style.display = "block";
  });
  
</script>

<script>
  function Buscar_Informe() {
      $(document)
      .ajaxStart(function () {
          //screen.fadeIn();
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
          });/**/
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
      var id = $('#anio_informe').val();
      var url="<?php echo site_url(); ?>General/Buscar_Informe";
      $.ajax({
          type:"POST",
          url:url,
          data: {'anio':id},
          success:function (data) {
              $('#list_informe').html(data);
          }
      });

     
  }

  function Excel_General() {
      
      var id = $('#anio_informe').val();
      window.location = "<?php echo site_url(); ?>General/Excel_Informe/"+id;
  }

  function seleccionart() {
    if (document.getElementById('total').checked) {
      var inp = document.getElementsByTagName('input');
      for (var i = 0, l = inp.length; i < l; i++) {
        if (inp[i].type == 'checkbox' && inp[i].name.split('[]')[0] == 'id_informe')
          inp[i].checked = 1;
      }
    } else {
      var inp = document.getElementsByTagName('input');
      for (var i = 0, l = inp.length; i < l; i++) {
        if (inp[i].type == 'checkbox' && inp[i].name.split('[]')[0] == 'id_informe')
          inp[i].checked = 0;
      }
    }
  }

  function Bloquear_Ticket(){
      $(document)
      .ajaxStart(function() {
        //screen.fadeIn();
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
        }); /**/
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

      var contador = 0;
      var contadorf = 0;
      var dataString = $("#frm_informe").serialize();
      var url = "<?php echo site_url(); ?>General/Bloquear_Ticket";

      $("input[type=checkbox]").each(function() {
        if ($(this).is(":checked"))
          contador++;
      });

      contadorf = contador;

      if (contadorf > 0) {
        Swal({
            title: '¿Realmente desea bloquear tickets',
            text: "¿Desea bloquear los tickets revisados de la(s) " + contadorf + " semana(s) seleccionada(s)?",
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
                    data: dataString,
                    success:function () {
                        Buscar_Informe();
                    }
                });
            }
        })
      } else {
        Swal(
          'Ups!',
          'Debe seleccionar al menos 1 Período.',
          'warning'
        ).then(function() {});
        return false;
      }
  }
</script>

<?php $this->load->view('general/footer'); ?>