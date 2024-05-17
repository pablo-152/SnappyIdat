<form id="formulario_accion"  method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <h3 class="tile-title"><b>Nueva Acción</b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>

  <div class="modal-body" style="max-height:600px; overflow:auto;">
    <div class="col-md-12 row">
    
      <div class="form-group col-md-6">
        <label class="text-bold">Fecha</label>
        <div class="col">
          <input type="date" class="form-control" id="fecha_accion" name="fecha_accion" value="<?php echo date('Y-m-d'); ?>">
        </div>
      </div>

      <div class="form-group col-md-6">
        <label class=" text-bold">Comentario</label>
        <div class="col">
          <input type="text" class="form-control" id="comentario" name="comentario" maxlength="35">
        </div>
      </div>
      
      
      <div class="form-group col-md-6">
        <label class=" text-bold">Observaciones:</label>
        <div class="col">
        <textarea class="form-control" id="observacion" name="observacion" rows="5" placeholder="Observaciones"></textarea>
        </div>
          
      </div>

      <div class="form-group col-md-6">
        <label class=" text-bold">Acción:</label>
        <div class="col">
          <!--<input type="hidden" class="form-control" readonly id="accionbd" name="accionbd"  value="<?php echo $get_id[0]['id_accion'] ?>">-->
          <select  name="id_accion" id="id_accion" class="form-control">
            <option value="0">Seleccione</option>
            <?php foreach($list_accion as $list){?> 
                <option value="<?php echo $list['id_accion']; ?>" ><?php echo $list['nom_accion'];?></option>
                <?php }  ?>
          </select>
        </div>
      </div>
      

      <div class="form-group col-md-6">
        <label class=" text-bold">Estado:</label>
        <div id="mstatus" class="col">
          <select class="form-control" id="id_status" name="id_status">
            <option value="0" >Seleccione</option>
            <?php foreach($list_estado as $list){?> 
                <option value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
              <?php } ?>
          </select>
        </div> 
      </div> 

                               
  </div>

  <div class="modal-footer">
    <input type="hidden" id="id_centro" name="id_centro" value="<?php echo $id_centro ?>">
    <button type="button" onclick="Insert_Historial_Centro();" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>


<script>
  function Insert_Historial_Centro(){
    var id_centro = $("#id_centro").val();
    var dataString = new FormData(document.getElementById('formulario_accion'));
    var url="<?php echo site_url(); ?>AppIFV/Insert_historial_centro";

    if (Valida_Accion()) {
      $.ajax({
            type:"POST",
            url:url,
            data:dataString,
            processData: false,
            contentType: false,
          success:function (data) {
            if(data=="error"){
              Swal({
                  title: 'Registro Denegado',
                  text: "¡Existe un registro con misma observación, acción y estado!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              });
            }else if(data=="error2"){
              Swal({
                  title: 'Registro Denegado',
                  text: "¡Existe un registro con el mismo comentario!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              });
            }else{
              swal.fire(
                  'Registro Exitoso!',
                  '',
                  'success'
              ).then(function() {
                  window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Centro/"+id_centro;
              });
            } 
          }
      });
    }
  }

  function Valida_Accion() {
      if($('#id_accion').val()=="0"){
        Swal(
            'Ups!',
            'Debe seleccionar Acción.',
            'warning'
        ).then(function() { });
        return false;
      }
      if($('#id_status').val()=="0"){
        Swal(
            'Ups!',
            'Debe seleccionar Estado.',
            'warning'
        ).then(function() { });
        return false;
      }
      return true;
    
  }
</script>
