<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('Admin/header'); ?>

<?php $this->load->view('Admin/nav'); ?>
<style>


  .page-title{
    background-color: #C1C1C1;
    height:80px;
  }

  .page-title h4{
    font-size:40px; 
    color:white; 
    position: absolute;
    top: 40%;
    left: 5%;
    margin: -25px 0 0 -25px;
  }

  .heading-elements{
    position: absolute;
    top: 50%;
    margin: -25px 0 0 -25px;
  }
</style>
<!--<link href="<?=base_url() ?>template/css/AdminLTE.css" rel="stylesheet" type="text/css">-->


<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        
        <div class="page-title">
          <h4 ><span class="text-semibold"><b>Folder <?php echo $folder ?> - Lado <?php echo $lado ?></b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group">
            <a style="margin-left:5px;margin-right:5px" target="_blank" href="<?= site_url('Administrador/Pdf_Resumen_Venta/') ?><?php echo $folder ?>/<?php echo $lado ?>">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
            <a type="button" href="<?= site_url('Administrador/Informe') ?>" >
                <img style="margin-top:-4px" src="<?= base_url() ?>template/img/icono-regresar.png" width="60">
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
                  <th width="3%"><div align="center">Empresa</div></th>
                  <th width="3%"><div align="center">Sede</div></th>
                  <th width="3%"><div align="center">Año</div></th>
                  <th width="3%"><div align="center">Código</div></th>
                  <th><div align="center">A.&nbsp;Paterno</div></th>
                  <th><div align="center">A.&nbsp;Materno</div></th>
                  <th><div align="center">Nombres</div></th>
                  <th><div align="center">DNI</div></th>
                  <th><div align="center">Grado/Especialidad</div></th>
                  <th><div align="center">Sección/Grupo</div></th>
                  <th><div align="center">Estado</div></th>
                  <th width="3%"><div align="center" title="Documentos">Doc</div></th>
                  <th width="3%"><div align="center" title="DNI">Dni</div></th>
                  <th width="3%"><div align="center" title="Certificado de Estudios">Ces</div></th>
                  <th width="3%"><div align="center" title="Foto">Fto</div></th>
                </tr>
            </thead>
            <tbody>
              <?php foreach($list_detalle as $list) {  ?>
                <tr class="even pointer">
                  <td><?php echo $list['cod_empresa']; ?></td>
                  <td><?php echo $list['cod_sede']; ?></td>
                  <td><?php echo $list['anio']; ?></td>
                  <td><?php echo $list['codigo']; ?></td>
                  <td><?php echo $list['alum_apater']; ?></td>
                  <td><?php echo $list['alum_amater']; ?></td>
                  <td nowrap><?php echo $list['alum_nom']; ?></td>
                  <td><?php echo $list['dni_alumno']; ?></td>
                  <td><?php echo $list['grado']; ?></td>
                  <td><?php echo $list['seccion']; ?></td>
                  <td nowrap><span class="badge" style="background:#f44336;color: white;"><?php echo $list['estado_arpay']; ?></span></td>
                  <td align="center"><?php echo $list['doc']; ?></td>
                  <td align="center"><?php echo $list['dni']; ?></td>
                  <td align="center" ><?php echo $list['certificado']; ?></td>
                  <td align="center"><?php echo $list['cfoto']; ?></td>
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


