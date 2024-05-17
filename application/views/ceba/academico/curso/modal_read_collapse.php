
    <form class="form-horizontal" id="from_foto" method="POST" enctype="multipart/form-data" action="<?= site_url('Ceba/Modal_Read_Collapse')?>"  class="formulario">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">DETALLES DE TEMA <b><?php echo $id_tema; ?></b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" style="max-height:450px; overflow:auto;">
       <!------------------------------------------------>
        <div class="box-body table-responsive">
           <a align="left" ali href="<?= site_url('Ceba/Excel_Tema_Primero_Secundaria') ?>"> <!--OJO CAMBIAR EXCEL-->
             <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
           </a>

             <br>
             <br>
           <table id="exampleTable" class="exampleTable" class="display">
               <thead> 
                   <tr>
                       <th>Tipo</th>
                       <th>Orden</th>
                       <th>Tiempo</th>
                       <th>Usuario</th>
                       <th>Fecha - Hora</th>
                       <th>Estado</th>
                       <!--<th >&nbsp;</th>-->
                   </tr>
               </thead>
               <tbody>
               <!--
                 <?php foreach($list_read_collapse as $list) {  ?>
                   <tr class="even pointer">
                     <td></td>
                     <td  align="center"><?php echo $list['descripcion_grado']; ?></td>  
                     <td  align="center"><?php echo $list['nom_unidad']; ?></td> 
                     <td  align="center"><?php echo $list['referencia']; ?></td> 
                     <td  align="center"><?php echo $list['descripcion_area']; ?></td>
                     <td  align="center"><?php echo $list['descripcion_asignatura']; ?></td>                 
                     <td  align="center"><?php echo $list['nom_status']; ?></td> 
                     --> 
                     <!--
                     <td   align="center">              
                       <img title="Editar Tema 1 secundaria" data-toggle="modal"  data-dismiss="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Ceba/Modal_Update_Tema') ?>/<?php echo $list["id_tema"]; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;width:15px;height:15px;" />

                       <img title="Eliminar" data-id="<?php echo $list["id_tema"]; ?>" id="delete_tema" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;width:15px;height:15px;" />

                       <a style="color:#715D74;width:15px;height:15px;" title="Visualizar"  data-toggle="modal"data-target="#staticBackdrop"  staticBackdrop="<?= site_url('Ceba/Modal_Tema_View') ?>/<?php echo $list["id_tema"]; ?>"  >
                       <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                       </a>
                     </td>
                 
                   </tr>
                 <?php } ?>
                     -->

               </tbody> 
           </table> 
           
   </div>  



        <div class="modal-footer">
            <input name="id_curso" type="hidden" class="form-control" id="id_curso" value="">
            
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
            </button>
            <!--<button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                
            </button>-->

            
            
        </div>
    </form>

<script>

$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
	
});

$("#createProductBtn").on('click', function(e){
    if (valida_curso()) {
        bootbox.confirm({
            title: "Actualizar Curso",
            message: "¿Desea ctualizar el curso?",
            buttons: {
                cancel: {
                    label: 'Cancelar'
                },
                confirm: {
                    label: 'Confirmar'
                }
            },
            callback: function (result) {
                if (result) {
                    $('#from_foto').submit();
                }
            } 
        });        
}
else{
        bootbox.alert(msgDate)
        var input = $(inputFocus).parent();
        $(input).addClass("has-error");
        $(input).on("change", function () {
            if ($(input).hasClass("has-error")) {
                $(input).removeClass("has-error");
            }
        });
    }

});

</script>