<input type="hidden" name="id_status" id="id_status" value="<?php echo $status?> ">

<!--<a href="<?= site_url('Administrador/Excel_proyec') ?>/<?php echo $status?> ">
  <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
</a>-->

<table id="example" class="table table-striped table-bordered" width="100%">
  <thead>
    <tr style="background-color: #E5E5E5;">
      <th>Pri</th>
      <th>Código</th>
      <th>Status</th>
      <th>Empresa(s)</th>
      <th>Tipo</th>
      <th>SubTipo</th>
      <th>Descripción</th>
      <th>Snappy's</th>
      <th>Agenda</th>
      <th>Usuario</th>
      <th>Fecha</th>
      <th>Usuario</th>
      <th>Fecha</th>
      <th type="hidden">&nbsp;</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($row_p as $row_p) {  ?>
      <tr class="even pointer">
        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['prioridad']; ?></td>
        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo utf8_encode($row_p['cod_proyecto']); ?></td>
        <td style="background-color:<?php echo $row_p['color']; ?>"><?php echo $row_p['nom_statusp']; ?></td>
        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
        <?php
          $cadena="";
          foreach($list_empresa as $empresa){
              if($empresa['id_usuario']==$list['id_usuario']){
                  //echo $empresa['cod_empresa'].",";
                  $cadena=$cadena.$empresa['cod_empresa'].",";
              }
          }
          echo substr($cadena,0,-1);
        ?></td>
        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['nom_tipo']; ?></td>
        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['nom_subtipo']; ?></td>
        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo substr($row_p['descripcion'],0,30); ?></td>
        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['s_artes']+$row_p['s_redes']; ?></td>
        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_agenda']!='0000-00-00') echo date('d/m/Y', strtotime($row_p['fec_agenda'])); ?></td>
        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['ucodigo_solicitado']; ?></td>
        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_solicitante']!='0000-00-00') echo date('d/m/Y', strtotime($row_p['fec_solicitante'])); ?></td>
        <td <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php echo $row_p['ucodigo_asignado']; ?></td>
        <td align="center" <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>><?php if ($row_p['fec_termino']!='0000-00-00 00:00:00') echo date('d/m/Y', strtotime($row_p['fec_termino']));?></td>
        <td align="center"
        <?php if($row_p['proy_obs']!='') { echo "style='background-color: #37A0CF;'";} ?>>
      <!-- <a href="<?= site_url('Administrador/editar_proyect') ?>/<?php echo $row_p['id_proyecto']; ?>"> 
        <img src="<?= base_url() ?>images/editar.png" 
        onClick="Editar('<?php echo $row_p['id_proyecto']; ?>')" style="cursor:pointer; cursor: hand;" width="22" height="22" />
        </a>-->
       <?php
         if ($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){?>
        <!-- Administrador-->
     <a type="button" title="Editar Proyecto" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/editar_proyect') ?>/<?php echo $row_p['id_proyecto']; ?>"> <img src="<?= base_url() ?>images/editar.png" 
       style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>
      
     <?php }
     elseif ($_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_nivel']==4){?>
    <!-- TEAMLEADER-->
     <a type="button" title="Editar Proyecto" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Teamleader/editar_proyect') ?>/<?php echo $row_p['id_proyecto']; ?>"> <img src="<?= base_url() ?>images/editar.png" 
       style="cursor:pointer; cursor: hand;" width="22" height="22" /></a>

      <?php } ?>
       &nbsp;
        <?php if ($row_p['imagen']!='') { ?>
      <img src="<?= base_url() ?>template/img/ver.png" data-toggle="modal" data-target="#dataUpdate" data-imagen="<?php echo $row_p['imagen']?>" title="Ver Imágen" style="cursor:pointer; cursor: hand;" width="22" height="22" />
    <?php }
    ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

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
        pageLength: 25
    } );

} );
</script>
  


<div class="modal fade bd-example-modal-lg" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Imágen Subida</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div align="center" id="capital2"></div>
        <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url()."archivo/" ?>'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#dataUpdate').on(
  'show.bs.modal', function (event)
  {
    var button = $(event.relatedTarget)
    var imagen = button.data('imagen')
    var imagen2 = imagen.substr(-3)
    var rutapdf= $("#rutafoto").val(); // ruta de la imagen
    var nombre_archivo= rutapdf+imagen // tuta y nombre del archivo
  
    if (imagen2=="PDF" || imagen2=="pdf")
    {
      document.getElementById("capital2").innerHTML = "<iframe height='350px' width='350px' src='"+nombre_archivo+"'></iframe>";
    }
    else
    {
      document.getElementById("capital2").innerHTML = "<img src='"+nombre_archivo+"'>";
    }
    var modal = $(this)
    modal.find('.modal-title').text('Imágen de Fondo')
    $('.alert').hide();//Oculto alert
  }
)



/*function Editar(e,id_proyecto){
   // var id_proyecto = id_proyecto;
   //alert(id_proyecto);
     var url = "<?php echo site_url(); ?>Administrador/Editar_proyect/";
      frm = {};
      $.ajax({
         url: url, 
          type: 'POST',
          data: frm,
      }).done(function(contextResponse, statusResponse, response) {
         $("#nuevo_proyect").html(contextResponse);
      })
}*/

  </script>