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
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Base de Datos - Informe (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <a style="margin-left:5px;" href="<?= site_url('Administrador/Excel_informe_Alumno_BD') ?>">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>    
    <div></div>
      
    </div>
  </div>

    
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12"  >
        <table class="table table-hover table-bordered table-striped" id="example" width="100%">
            <thead >
                <tr>
                  <th width="3%"><div align="center" >Empresa</div></th>
                  <th width="3%"><div align="center" >Sede</div></th>
                  <th width="3%"><div align="center" >Año</div></th>
                  <th width="3%"><div align="center" >Folder</div></th>
                  <th><div align="center">Del</div></th>
                  <th><div align="center">Al</div></th>
                  <th><div align="center">Estado</div></th>
                  <th width="3%"><div align="center"  title="Documentos">Doc</div></th>
                  <th width="3%"><div align="center"  title="DNI">Dni</div></th>
                  <th width="3%"><div align="center"  title="Certificado de Estudios">Cert</div></th>
                  <th width="3%"><div align="center"  title="Foto">Fto</div></th>
                  <th width="3%"><div align="center">A</div></th>
                  <th width="3%"><div align="center">B</div></th>
                </tr>
            </thead>
            <tbody>
              <?php foreach($list_informe as $list) {  ?>
                <tr class="even pointer">
                  <td align="center"><?php echo $list['cod_empresa']; ?></td>
                  <td><?php echo $list['cod_sede']; ?></td>
                  <td align="center"><?php echo $list['anio']; ?></td>
                  <td align="center"><?php echo $list['folder']; ?></td>
                  <td align="center"><?php echo $list['del']; ?></td>
                  <td align="center"><?php echo $list['al']; ?></td>
                  <td><?php if($list['estado_g']=="Incompleto"){?> <span class="badge" style="background:#C00000;color: white;"><?php echo $list['estado_g'] ?></span><?php }
                  else{?> <span class="badge" style="background:#4caf50;color: white;"><?php echo $list['estado_g'] ?></span><?php } ?></td>
                  <td align="center"><?php echo $list['doc']; ?></td>
                  <td align="center"><?php echo $list['dni']; ?></td>
                  <td align="center"><?php echo $list['ces']; ?></td>
                  <td align="center"><?php echo $list['foto']; ?></td>
                  <td align="center">
                    <?php if($list['del']=="00001"){?> 
                        <a title="Detalle Lado A" href="<?= site_url('Administrador/Detalle_Folder/A/') ?><?php echo $list['folder'] ?>">
                            <img title="Editar" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                        </a>
                    <?php }?>
                  </td>
                  <td align="center">
                    <?php if($list['del']=="00026" || $list['al']=="00050"){?> 
                      <a title="Detalle Lado B" href="<?= site_url('Administrador/Detalle_Folder/B/') ?><?php echo $list['folder'] ?>">
                          <img title="Editar" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                      </a>
                      <?php }?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
      $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
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

        var table = $('#example').DataTable({
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
        });

        $("#base_dato").addClass('active');
        $("#hbase_dato").attr('aria-expanded','true');
        $("#informe_bd").addClass('active');
		    document.getElementById("rbase_dato").style.display = "block";
    });

    $('#tipo_folder').bind('keyup paste', function(){
      var tipo_folder=$('#tipo_folder').val();
      $('#tipo_folder_f').val(anio);
    });



    
</script>

<?php $this->load->view('Admin/footer'); ?>


