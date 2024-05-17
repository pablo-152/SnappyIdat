<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<!-- Navbar-->
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Evento (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group" >
            <a href="<?= site_url('Administrador/Pdf_Evento') ?>/<?php echo $get_id[0]['id_evento']; ?>" target="_blank">
                <img title="Descargar" src="<?= base_url() ?>template/img/descargar_informe.png" style="cursor:pointer; cursor: hand;">
            </a>
            
            <a type="button" href="<?= site_url('Administrador/Eventos') ?>">
                <img style="margin-right:5px;margin-left:5px;" src="<?= base_url() ?>template/img/icono-regresar.png">
            </a>

            <a href="<?= site_url('Administrador/Excel_Detalle_Evento') ?>/<?php echo $get_id[0]['id_evento']; ?>">
              <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
      <div class="row">
          <div class="col-lg-12">
            <table id="example" class="table table-hover table-bordered table-striped" width="100%">
              <thead>
                <tr style="background-color: #E5E5E5;">
                  <th class="text-center" width="3%"></th>
                  <th class="text-center" width="6%" title="Código">Cod.</th>
                  <th class="text-center" width="14%">Evento</th>
                  <th class="text-center" width="5%" title="Empresa">Emp.</th>
                  <th class="text-center" width="20%">Nombre</th>
                  <th class="text-center" width="12%">Correo</th>
                  <th class="text-center" width="6%" title="Celular">Cel.</th>
                  <th class="text-center" width="14%">Grado/Prog. Estudios</th>
                  <th class="text-center" width="6%">Comercial</th>
                  <th class="text-center" width="6%" title="Fecha Registro">F. Reg.</th>
                  <th class="text-center" width="6%">Estado</th>
                  <th class="text-center" width="2%"></th>
                </tr>
              </thead>

              <tbody> 
                <?php $i=count($list_detalle); foreach($list_detalle as $list){ ?> 
                  <tr class="even pointer">
                    <td class="text-center"><?php echo $i; ?></td>
                    <td class="text-center"><?php echo $list['cod_registro']; ?></td>
                    <td><?php echo $list['nom_evento']; ?></td>
                    <td class="text-center"><?php echo $list['cod_empresa']; ?></td>
                    <td><?php echo substr($list['nombres_apellidos'],0,50); ?></td>
                    <td><?php echo $list['correo']; ?></td>
                    <td class="text-center"><?php echo $list['contacto1']; ?></td>
                    <td><?php echo substr($list['productosf'],0,42); ?></td>
                    <td><?php echo ""; ?></td>
                    <td class="text-center"><?php echo $list['fec_inicial']; ?></td>
                    <td class="text-center"><span class="badge" style="background:<?php echo $list['col_status']; ?>;"><?php echo $list['nom_status']; ?></span></td>
                    <td class="text-center">
                      <a title="Detalle" href="<?= site_url('Administrador/Historial_Evento') ?>/<?php echo $list['id_registro']; ?>/<?php echo $list['id_evento']; ?>"> 
                        <img src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;">
                      </a>
                    </td> 
                  </tr>
                <?php $i--; } ?>
              </tbody>
            </table>
          </div>
      </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#eventos").addClass('active');
    $("#heventos").attr('aria-expanded','true');
    $("#lista_eventos").addClass('active');
    document.getElementById("reventos").style.display = "block";

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
      order: [[1,"desc"]],
      orderCellsTop: true,
      fixedHeader: true,
      pageLength: 50,
      "aoColumnDefs" : [ 
          {
              'bSortable' : false,
              'aTargets' : [ 0,11 ]
          } 
      ]
    });
  });
</script>

<?php $this->load->view('Admin/footer'); ?>
