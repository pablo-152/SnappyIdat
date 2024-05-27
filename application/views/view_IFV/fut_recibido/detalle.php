<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>


<style>
  .fondo_ref{
    background-color:#f38a0b !important;
    color:white;
  }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;">
                    <span class="text-semibold"><b>Historial del Fut Recibido N° de Código <?php echo $get_id[0]['cod_fut']; ?> </b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a type="button" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('AppIFV/Modal_Detalle_Fut') ?>/<?php echo $get_id[0]['id_envio']; ?>" style="margin-right:5px;">
                          <img src="<?= base_url() ?>template/img/nuevo.png">
                        </a>
                        <a type="button" href="<?= site_url('AppIFV/Fut_Recibido') ?>">
                          <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <div class="container-fluid" style="margin-top:15px;margin-bottom:15px;">
      <div class="col-md-12 row">
          <div class="form-group col-md-2">
              <label class="text-bold">DNI:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['Dni']; ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-2">
              <label class="text-bold">Código:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['Codigo']; ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-2">
              <label class="text-bold">Nombre:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_alumno']; ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-2">
              <label class=" text-bold">Ap. Paterno:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['Apellido_Paterno']; ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-3">
              <label class="text-bold">Ap. Materno:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['Apellido_Materno'] ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-3">
              <label class="text-bold">Email:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['email'] ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-2">
              <label class="text-bold">Especialidad:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['abreviatura']; ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-2">
              <label class="text-bold">Grupo:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['Grupo']; ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-2">
              <label class="text-bold">Ciclo:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['Ciclo']; ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-2">
              <label class="text-bold">Sección:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['Seccion']; ?>" readonly>
              </div>
          </div>

          <div class="form-group col-md-2">
              <label class="text-bold">Producto:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_producto']; ?>" readonly>
              </div>
          </div>
        
          <div class="form-group col-md-4">
              <label class="text-bold">Asunto:</label>
              <div class="col">
                <input type="text" class="form-control" value="<?php echo $get_id[0]['asunto']; ?>" readonly>
              </div>
          </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12" id="tabla">
          <table class="table table-hover table-bordered table-striped" id="example" width="100%">
            <thead>
              <tr style="background-color: #E5E5E5;">
                <th class="text-center">Observaciones</th>
                <th class="text-center" width="8%">Fecha</th>
                <th class="text-center" width="10%">Estado</th>
                <th class="text-center" width="5%"></th>
              </tr>
            </thead> 

            <tbody >
              <?php foreach($list_detalle_fut as $list) {  ?> 
                <tr class="even pointer text-center">
                  <td class="text-left"><?php echo $list['observ_envio_det']; ?></td>
                  <td><?php echo date('d/m/Y',strtotime(substr($list['fec_reg'],0,10)))?></td>
                  <td><?php echo $list['nom_status']; ?></td>
                  <td>
                      <?php if($list['estado_envio_det']!="65"){?> 
                        <img title="Editar" data-toggle="modal" data-dismiss="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('AppIFV/Modal_Update_Detalle_Fut') ?>/<?php echo $list['id_envio_det']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                        <a href="#" class="" title="Eliminar" onclick="Delete_Detalle_Fut('<?php echo $list['id_envio_det']; ?>','<?php echo $list['id_envio']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>
                      <?php }?>
                      <?php if($list['pdf_envio_det']!=""){?> 
                        <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $list['id_envio_det']; ?>">
                          <img src="<?= base_url() ?>template/img/descarga_peq.png">
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
        $("#tramites").addClass('active');
        $("#rtramites").attr('aria-expanded', 'true');
        $("#trami_fv_gut").addClass('active');
        document.getElementById("rtramites").style.display = "block";

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
            order: [0,"desc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 100,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 3 ]
                }
            ]
        });
    } );

    function Delete_Detalle_Fut(id,id_registro){
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Detalle_Fut";

        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
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
                    data: {'id_historial':id,'id_fut':id_registro},
                    success:function (data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Historial_Fut_Recibido/"+id_registro;
                        });
                    }
                });
            }
        })
    }
    
	  $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Fut_Recibido/" + image_id);
    });
</script>
<?php $this->load->view('view_IFV/footer'); ?>
