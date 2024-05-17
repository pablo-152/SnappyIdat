<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
    <!-- Navbar-->
   <?php $this->load->view('Admin/header'); ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php $this->load->view('Admin/nav'); ?>
      <main class="app-content">
      <!--<div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-book fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        </ul>
      </div>-->

       <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
             <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                      <div class="row tile-title line-head" style="background-color: #C1C1C1;">
                          <div class="col" style="vertical-align: middle;">
                              <b>Lista de Fondos de Intranet</b>
                          </div>
                          <div class="col" align="right">
                              <!--<button class="btn btn-info" type="button" title="Nuevo Fondo" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Snappy/modal_img') ?>"><i class="fa fa-plus"></i> Nuevo Fondo </button>-->
                              <a title="Nuevo Fondo" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal" 
                              app_crear_per="<?= site_url('Snappy/modal_img') ?>">
                                  <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                              </a>
                              <a href="<?= site_url('Snappy/Excel_Fondo') ?>">
                                  <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                              </a>
                          </div>
                      </div>
                    </div>
                        <table class="table table-bordered table-striped" id="example" width="100%">
                            <thead>
                              <tr style="background-color: #E5E5E5;">
                                  <th width="80%"><div align="center">Titulo Fondo</div></th>
                                  <th width="20%">&nbsp;</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                                 <?php foreach($confg_foto as $cof) {  ?>                                           
                                <tr class="even pointer">
                                <td align="center"><?php echo $cof["nom_fintranet"];?></td>
                                <td align="center">
                                    <button class="btn btn-primary btn-sm" type="button" title="Editar Papeleta" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Snappy/update_img') ?>/<?php echo $cof["id_fintranet"]; ?>"><i class="fa fa-edit"></i>
                                    </button>
                                      &nbsp;
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $cof["foto"]?>" title="Ver Imágen"> <i class="fa fa-search-plus"></i>
                                    </button>
                                     &nbsp;
                                     <?php
                               if ($cof['estado']!=2) {  ?>
                                    <button class="btn btn-danger btn-sm" onClick="Eliminar('<?php echo $cof["id_fintranet"]; ?>',2)" title="Desactivar Fondo Intranet"><i class="fa fa-times"></i>
                                    </button>
                                   <?php } else { ?>
                                    <button class="btn btn-success btn-sm" onClick="Eliminar('<?php echo $cof["id_fintranet"]; ?>',1)" title="Activar Fondo Intranet"><i class="fa fa-check" aria-hidden="true"></i> 
                                    </button>
                                      <?php } ?>
                                  </td>
                                </tr>
                              <?php  } ?>
                         </tbody>
                        </table>
                 
                 </div>
               </div>
             </div>
            </div>
          </div>
        </div>
      </div>

    
    </main>

    <div id="acceso_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="acceso_modal_mod" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="acceso_modal_eli" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

<script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example thead tr').clone(true).appendTo( '#example thead' );
    $('#example thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        
        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    var table = $('#example').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        pageLength: 100
    } );

} );
</script>
<?php $this->load->view('Admin/footer'); ?>


<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

    <script type="text/javascript">
 
function corregirpapeleta()
{
  frmlmotivocorregir.submit();
}
  

  </script>
  <!-- <center><a id="signedDocument" class="" href="#" role="button"></a> </center>
    <br>
    <center><input type="hidden" id="argumentos" value="" /></center> 
    <hr>
    <div id="addComponent"></div>
  </div>-->
  
  <div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Imagen de Fondo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
      <div id="datos_ajax"></div>
      <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url() ?>'>
            <div align="center" id="capital2"></div>        
      </div>
      <div class="modal-footer">      
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script >
  $('#dataUpdate').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var imagen = button.data('imagen') // Extraer la información de atributos de datos
    var rutapdf= $("#rutafoto").val();
    var nombre_archivo= rutapdf+imagen
    document.getElementById("capital2").innerHTML = "<img src='"+nombre_archivo+"'>";
    //('src', ""+nombre_archivo+".pdf");
    var modal = $(this)
    modal.find('.modal-title').text('Imágen de Fondo')
    $('.alert').hide();//Oculto alert

  })

  function Eliminar(id,estado){
    bootbox.confirm({
      title: "Actualizar estado",
      message: "¿Está seguro de actualizar estado",
      buttons: {
        cancel: {
          label: 'Cancelar'
        },
        confirm: {
          label: 'Aceptar'
        }
      },
      callback: function (result) {
        if (result) {
          var url = "<?php echo site_url(); ?>" + "/Snappy/eliminarfoto/";
          frm = { id: id, estado:estado };
          $.ajax({
            url: url, 
            type: 'POST',
            dataType: 'html',
            data: frm,
          }).done(function(contextResponse, statusResponse, response) {
            location.reload(true);
            //$("#acceso_modal").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
          });/**/
        }
      }
    });
  }  

</script>

