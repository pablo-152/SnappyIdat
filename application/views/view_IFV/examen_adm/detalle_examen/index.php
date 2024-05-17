<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('view_IFV/nav'); ?>


<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold">
                        <b>Preguntas&nbsp;<?php echo $get_area[0]['nombre'] ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a style="margin-right:5px;" title="Nueva Pregunta" style="cursor:pointer; cursor: hand;" data-toggle="modal" data-target="#acceso_modal"  app_crear_per="<?= site_url('AppIFV/Modal_Pregunta') ?>/<?php echo $id_area ?>/<?php echo $id_examen ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a type="button" href="<?= site_url('AppIFV/Detalle_Examen') ?>/<?php echo $id_examen ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered" >
                    <thead class="text-center">
                        <tr style="background-color: #E5E5E5;">
                            <th width="5%"><div >Orden</div></th>
                            <th width="50%"><div >Pregunta</div></th>
                            <th width="1%"><div ></div></th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        <?php foreach($list_pregunta as $list) {  ?>                                           
                            <tr class="even pointer">                                    
                                <td  ><?php echo $list['orden']; ?></td>
                                <td  align="left"><?php echo $list['pregunta']; ?></td>
                                <td nowrap>
                                    <img title="Editar Datos Empresa" data-toggle="modal"  data-target="#acceso_modal_mod"   app_crear_mod="<?= site_url('AppIFV/Modal_Update_Pregunta') ?>/<?php echo $list["id_pregunta"]; ?>/<?php echo $id_area ?>/<?php echo $id_examen ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;"  width="22" height="22" />
                                    <a width="22" height="22" style="cursor:pointer;" class="" data-toggle="modal" data-target="#repaso" data-imagen="<?php echo $list['img']?>" title="Ver Imágen"> <i class="fa fa-search-plus" ></i></a>
                                    
                                    <a href="#" class="" title="Eliminar" onclick="Delete_Pregunta_Admision('<?php echo $list['id_pregunta']; ?>','<?php echo $list['id_area']; ?>','<?php echo $list['id_examen']; ?>')"  role="button"> <img title="Eliminar"  src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="clockdate" >
          <div class="clockdate-wrapper">
              <div id="clock"></div>
              <div id="date"></div>
          </div>
      </div>   
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

    var table=$('#example').DataTable( {
        "order": [[ 2, "Orden" ]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 25
    } );

    $(document).ready(function() {
        $("#examenadmision").addClass('active');
        $("#hexamenadmision").attr('aria-expanded', 'true');
        $("#examenf").addClass('active');
		document.getElementById("rexamenadmision").style.display = "block";
    });
    

   
} );
</script>

<script>
$(document).ready(function() {
    /**/var msgDate = '';
    var inputFocus = '';
});
var base_url = "<?php echo site_url(); ?>";

</script>


<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>

<script>
    

</script>

<div class="modal fade" id="repaso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Repaso</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      
      <div class="modal-body">
      
      <input type="hidden" name="rutarepaso" id="rutarepaso" value= '<?php echo base_url() ?>'>

      <div align="center" id="capitalrepaso"></div>        
      </div>

      <div class="modal-footer">      
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
$('#repaso').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que activó el modal
    var imagen = button.data('imagen') // Extraer la información de atributos de datos
    var rutapdf= $("#rutarepaso").val();
    var nombre_archivo= rutapdf+imagen
    
    
    if (imagen!=""){
          document.getElementById("capitalrepaso").innerHTML = "<img src='"+nombre_archivo+"' height='400px' width='400px'>";
        
    }
    else
    {
        document.getElementById("capitalrepaso").innerHTML = "No se ha registrado ningún archivo";
    }

    //('src', ""+nombre_archivo+".pdf");
    var modal = $(this)
    modal.find('.modal-title').text('Imagen')
    $('.alert').hide();//Oculto alert

  })
</script>