<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h5 class="modal-title" style="color: #715d74;font-size: 21px;"><b>Nuevo Historial</b></h5>
  </div>

  <div class="modal-body" style="max-height:520px; overflow:auto;"> 
    <div class="col-md-12 row">
      <div id="mstatus" class="form-group col-md-3">
        <label class="text-bold">Status:</label>
        <select class="form-control" name="id_status_ticket_i" id="id_status_ticket_i" onchange="Status_I()">
          <option value="0" selected>Seleccione</option>
          <?php foreach($list_status as $list){ 
            //if($list['id_status_general']!=1){ ?>
              <option value="<?php echo $list['id_status_general']; ?>" 
              <?php if($list['id_status_general']==$ultimo){ echo "selected"; } ?>>
                <?php echo $list['nom_status']; ?>
              </option>
            <?php //} ?>
          <?php } ?>
        </select>
      </div>

      <div id="div_horas_i" class="form-group col-md-2" style="display: none;">
        <label class="text-bold">Horas:</label>
        <input class="form-control" type="number" id="horas_i" name="horas_i" placeholder="Horas">
      </div>

      <div id="div_minutos_i" class="form-group col-md-2" style="display: none;">
        <label class="text-bold">Minutos:</label>
        <input class="form-control" type="number" id="minutos_i" name="minutos_i" placeholder="Minutos">
      </div>

      <div id="div_colaborador_i" class="form-group col-md-3" style="display: none;">
        <label class="text-bold">Colaborador:</label>
        <select class="form-control" name="id_mantenimiento_i" id="id_mantenimiento_i">
          <option value="0">Seleccione</option>
          <?php foreach($list_mantenimiento as $list){ ?>
            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label class="text-bold">Fecha:</label>
        <div class="col">
          <?php echo date('d/m/Y');?>
        </div>
      </div>

      <div id="div_revision_i" class="form-group col-md-2" style="display:<?php if($ultimo==34){echo "block";}else{echo "none";}?>">
        <label class="text-bold">Mes:</label>
        <?php if(date('m')=="01"){ echo "Enero";}
        if(date('m')=="02"){ echo "Febrero";}
        if(date('m')=="03"){ echo "Marzo";}
        if(date('m')=="04"){ echo "Abril";}
        if(date('m')=="05"){ echo "Mayo";}
        if(date('m')=="06"){ echo "Junio";}
        if(date('m')=="07"){ echo "Julio";}
        if(date('m')=="08"){ echo "Agosto";}
        if(date('m')=="09"){ echo "Septiembre";}
        if(date('m')=="10"){ echo "Octubre";}
        if(date('m')=="11"){ echo "Noviembre";}
        if(date('m')=="12"){ echo "Diciembre";} echo substr(date('Y'), 2,2);?>
        
      </div>

      <div class="form-group col-md-12">
        <label class="text-bold">Observaciones:</label>
        <textarea name="ticket_obs" rows="5" class="form-control" id="ticket_obs"></textarea>
      </div>

      <div class="form-group col-md-12">
        <div class="col-xs-12"> 
            <label class="control-label text-bold">Archivos:</label>
            <input type="file" name="files_i[]" id="files_insert" multiple/>
        </div>
      </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_ticket" name="id_ticket" value="<?php echo $id_ticket; ?>">
        <input type="hidden" id="cod_ticket" name="cod_ticket" value="<?php echo $get_id[0]['cod_ticket']; ?>">
        <button type="button" class="btn btn-success" onclick="Insert_Historial()">Guardar</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
  </div>
</form>

<script>
    function Status_I(){
        var id_status_ticket=$('#id_status_ticket_i').val();
        var div_colaborador = document.getElementById("div_colaborador_i");
        var div_horas = document.getElementById("div_horas_i");
        var div_minutos = document.getElementById("div_minutos_i");
        var div_revision = document.getElementById("div_revision_i");

        if(id_status_ticket==20){
          div_colaborador.style.display = "block";
          div_horas.style.display = "block";
          div_minutos.style.display = "block";
        }else if(id_status_ticket==2 || id_status_ticket==23){
          div_horas.style.display = "block";
          div_minutos.style.display = "block";
        }else{
          div_colaborador.style.display = "none";
          div_horas.style.display = "none";
          div_minutos.style.display = "none";
        }

        if(id_status_ticket==34){
          div_revision.style.display = "block";
        }else{
          div_revision.style.display = "none";
        }
    }

    function Insert_Historial(){
      Cargando();

      var dataString = new FormData(document.getElementById('formulario_insert'));
      var url="<?php echo site_url(); ?>General/Insert_Historial_Ticket";
      var id_ticket=$('#id_ticket').val();

      if (Valida_Insert_Historial()) { 
          $.ajax({
              url: url,
              data:dataString,
              type:"POST",
              processData: false,
              contentType: false,
              success:function (data) {
                  $("#modal_form_vertical .close").click()
                  Lista_Historial_Ticket();
              }
          });
      }
    }

    function Valida_Insert_Historial() {
      if($('#id_status_ticket_i').val() == '0'){
          Swal(
              'Ups!',
              'Debe seleccionar Estado.',
              'warning'
          ).then(function() { });
          return false;
      }
      if($('#id_status_ticket_i').val()==2){
        if($('#horas_i').val().trim() == '' && $('#minutos_i').val().trim() == ''){
            Swal(
                'Ups!',
                'Debe ingresar Tiempo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#horas_i').val()<2){
            Swal(
                'Ups!',
                'Debe ingresar Tiempo mayor o igual a 2h.',
                'warning'
            ).then(function() { });
            return false;
        }
      }
      if($('#id_status_ticket_i').val()==23){
        if($('#horas_i').val().trim() == '' && $('#minutos_i').val().trim() == ''){
            Swal(
                'Ups!',
                'Debe ingresar Tiempo.',
                'warning'
            ).then(function() { });
            return false;
        }
      }
      if($('#id_status_ticket_i').val()==20){
        if($('#id_mantenimiento_i').val().trim() == '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Programador.',
                'warning'
            ).then(function() { });
            return false;
        }
      }
      return true;
    }
</script>




   




