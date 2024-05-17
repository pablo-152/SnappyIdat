<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('view_CC/header'); ?>
<?php $this->load->view('view_CC/nav'); ?>

<style>
  .fondo_ref{
    background-color:#715d74 !important;
    color:white;
  }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;">
                    <span class="text-semibold"><b>Registro <?php echo $get_id[0]['cod_registro']; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                    <?php /*if($get_id[0]['id_evento']>0){ ?>
                      <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('CursosCortos/Modal_Historial_Registro_Mail_Evento') ?>/<?php echo $get_id[0]['id_registro']; ?>">  <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nueva Acción" />
                      </a>
                    <?php }else{*/ ?>
                      <a type="button" style="margin-right:5px;" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('CursosCortos/Modal_Historial_Registro_Mail') ?>/<?php echo $get_id[0]['id_registro']; ?>">  <img src="<?= base_url() ?>template/img/nuevo.png" alt="Nueva Acción" />
                      </a>
                    <?php //} ?>

                    <a type="button" style="margin-right:5px;" href="<?= site_url('CursosCortos/Vista_Editar_Registro') ?>/<?php echo $get_id[0]['id_registro']; ?>">  <img src="<?= base_url() ?>template/img/editar_grande.png" alt="Nueva Acción" />
                    </a>
                    
                    <a type="button" href="<?= site_url('CursosCortos/Registro') ?>">
                      <img src="<?= base_url() ?>template/img/icono-regresar.png">
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container-fluid">
      <div class="col-md-12 row">
          <div class="form-group col-md-2">
            <label class="text-bold">Referencia:</label>
            <div class="col">
              <input type="text" class="form-control fondo_ref" value="<?php echo $get_id[0]['cod_registro']; ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-2">
            <label class="text-bold">Tipo:</label>
            <div class="col">
              <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_informe']; ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-2">
            <label class=" text-bold">Estado:</label>
            <div class="col">
            <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_status']; ?>" readonly>
          </div>
          </div>

          <div class="form-group col-md-3">
            <label class="text-bold">Cliente:</label>
            <div class="col">
            <input type="text" class="form-control" value="<?php echo $get_id[0]['nombres_apellidos'] ?>" readonly>
          </div>
          </div>

          <div class="form-group col-md-3">
            <label class="text-bold">DNI:</label>
            <div class="col">
              <input type="text" class="form-control" value="<?php echo $get_id[0]['dni'] ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-3">
            <label class="text-bold">Departamento:</label>
            <div class="col">
            <input type="text" class="form-control" value="<?php echo $get_id[0]['nombre_departamento']; ?>" readonly>
          </div>
          </div>
        
          <div class="form-group col-md-2">
            <label class="text-bold">Provincia:</label>
            <div class="col">
              <input type="text" class="form-control" value="<?php echo $get_id[0]['nombre_provincia']; ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-2">
            <label class="text-bold">Distrito:</label>
            <div class="col">
              <input type="text" class="form-control" value="<?php echo $get_id[0]['nombre_distrito']; ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-2">
            <label class="text-bold">Contacto 1:</label>
            <div class="col">
            <input type="text" class="form-control" maxlength="9" value="<?php echo $get_id[0]['contacto1'] ?>" readonly>
          </div>
          </div>

          <div class="form-group col-md-3">
            <label class="text-bold">Correo:</label>
            <div class="col">
              <input type="text" class="form-control" value="<?php echo $get_id[0]['correo'] ?>" readonly>
            </div>
          </div>

          <div class="form-group col-md-3">
            <label class="col-sm-3 control-label text-bold">Facebook:</label>
            <div class="col">
              <input type="text" class="form-control" value="<?php echo $get_id[0]['facebook'] ?>" readonly>
            </div>
          </div>
          
          <div class="form-group col-md-2">
            <label class="col-sm-3 control-label text-bold">Contacto2:</label>
            <div class="col">
              <input type="text" class="form-control" maxlength="9" value="<?php if($get_id[0]['contacto2']==0){ echo ""; }else{ echo $get_id[0]['contacto2']; } ?>" readonly>
            </div>
          </div>
          
          <div class="form-group col-md-2">
            <label class="text-bold">Fecha Contacto:</label>
            <div class="col">
            <input type="date" class="form-control" value="<?php echo $get_id[0]['fec_inicial'] ?>" readonly>
          </div>
          </div>
          
          <!--<div class="form-group col-md-1">
            <label class="text-bold">Empresa:</label>
            <div class="col">
            <input type="text" class="form-control" value="<?php echo $get_id[0]['cod_empresa']; ?>" readonly>
          </div>
          </div>
          
          <div class="form-group col-md-1">
            <label class="text-bold">Sedes:</label>
            <div class="col">
              <input type="text" class="form-control" value="<?php echo $get_id[0]['cod_sede'];//substr($sede,0,-1); ?>" readonly>
            </div>
          </div>-->
          
          <div class="form-group col-md-2">
            <label class="text-bold">Intereses:</label>
            <div class="col">
              <?php 
                $producto="";
                foreach($list_producto as $list){
                  $producto=$producto.$list['nom_producto_interes'].",";
                }
              ?>
              <input type="text" class="form-control" value="<?php echo substr($producto,0,-1); ?>" readonly>
            </div>
          </div>
          
          <div class="form-group col-md-4">
            <label class="text-bold">Comentario:</label>
            <div class="col">
              <input type="text" class="form-control" value="<?php echo substr($get_id[0]['ultimo_comentario'],0,45); ?>" readonly>
            </div>
          </div>
      </div>

      <div class="col-lg-12" id="tabla">
        <table id="example" class="table table-hover">
          <thead>
            <tr style="background-color: #E5E5E5;">
              <th class="text-center">Id</th>
              <th class="text-center" width="8%">Fecha</th>
              <th class="text-center" width="10%">Usuario</th>
              <th class="text-center" width="12%">Tipo</th>
              <th class="text-center" width="12%">Acción</th>
              <th class="text-center">Observaciones</th>
              <th class="text-center" width="10%">Estado</th>
                <th class="text-center" width="5%"></th>
            </tr>
          </thead>

          <tbody >
            <?php foreach($list_historial_registro as $list) {  ?> 
              <tr class="even pointer text-center">
                <td><?php echo $list['fecha_accion']; ?></td>
                <td><?php echo $list['fec_accion']; ?></td>
                <td class="text-left"><?php if($list['user_reg']!=0){ echo $list['usuario_codigo']; }else{ echo "Web"; } ?></td>
                <td class="text-left"><?php echo $list['nom_informe']; ?></td>
                <td class="text-left" nowrap><?php if(strlen($list['nom_accion'])>0){echo $list['nom_accion'];}else{echo "Comentario";} ?></td>
                <td class="text-left"><?php echo $list['observacion']; ?></td>
                <td class="text-left"><?php echo $list['nom_status']; ?></td>
                <td>
                <?php //if($list['estado']!=57){ ?>
                  <?php if(($list['id_evento']>0) && ($id_nivel==1 || $id_nivel==6 || $id_nivel==7 || $id_nivel==9 || $id_nivel==12)){ ?>
                    <img title="Editar" data-toggle="modal" data-dismiss="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('CursosCortos/Modal_Update_Historial_Registro_Mail_Evento') ?>/<?php echo $list['id_historial']; ?>/<?php echo $get_id[0]['id_registro']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                  <?php }elseif($id_nivel==1 || $id_nivel==6 || $id_nivel==7 || $id_nivel==9){ ?>
                    <img title="Editar" data-toggle="modal" data-dismiss="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('CursosCortos/Modal_Update_Historial_Registro_Mail') ?>/<?php echo $list['id_historial']; ?>/<?php echo $get_id[0]['id_registro']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;width:22px;height:22px;" />
                  <?php } ?>
                <?php //} ?>
                <?php if($id_nivel==1 || $id_nivel==6 || $id_nivel==7 || $id_nivel==9){ ?> 
                  <a href="#" class="" title="Eliminar" onclick="Delete_Historial_Mail('<?php echo $list['id_historial']; ?>','<?php echo $get_id[0]['id_registro']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>
                  <?php } ?>
                </td>
                
              </tr>
            <?php } ?>
          </tbody>
        </table>
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
          order: [0,"desc"],
          orderCellsTop: true,
          fixedHeader: true,
          pageLength: 100,
          "aoColumnDefs" : [ 
              {
                  'bSortable' : false,
                  'aTargets' : [ 7 ]
              },
              {
                  'targets' : [ 0 ],
                  'visible' : false
              } 
          ]
      });

      $("#comercial").addClass('active');
      $("#hcomercial").attr('aria-expanded','true');
      $("#registro").addClass('active');
      document.getElementById("rcomercial").style.display = "block";

  } );
</script>

<script>
  function Delete_Historial_Mail(id,id_registro){
        var id = id;
        var id_registro = id_registro;
        var url="<?php echo site_url(); ?>CursosCortos/Delete_Historial_Mail";
        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
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
                    data: {'id_historial':id},
                    success:function (data) {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                          window.location = "<?php echo site_url(); ?>CursosCortos/Historial_Registro_Mail/"+id_registro;
                        });
                    }
                });
            }
        })
    }
</script>

<?php $this->load->view('view_CC/footer'); ?>
