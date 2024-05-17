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
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Detalle Mensaje (Lista)</b></span></h4>
        </div>

        <div class="heading-elements">
          <div class="heading-btn-group" >
            <a type="button" href="<?= site_url('Administrador/Mensaje') ?>" >
                <img style="margin-right:5px;margin-left:5px;" src="<?= base_url() ?>template/img/icono-regresar.png">
            </a>

            <a href="<?= site_url('Administrador/Excel_Detalle_Evento') ?>/<?php echo $id_mensaje; ?>">
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
                  <th class="text-center">Números</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach($list_mensaje as $list) {  ?>
                  <tr class="even pointer text-center">
                    <td><?php echo $list['numero']; ?></td>
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
    $("#comercial").addClass('active');
    $("#hcomercial").attr('aria-expanded', 'true');
    $("#smensaje_sms").addClass('active');
    $("#hmensaje_sms").attr('aria-expanded', 'true');
    $("#lista_mensajes").addClass('active');
    document.getElementById("rmensaje_sms").style.display = "block";
    document.getElementById("rcomercial").style.display = "block";

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
      pageLength: 21
    });
  });
</script>

<?php $this->load->view('Admin/footer'); ?>
