<form id="formulario_re"  method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <h3 class="tile-title">Editar Registro <b><?php echo $get_id[0]['cod_registro'];?></b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>

  <div class="modal-body" style="max-height:600px; overflow:auto;font-size: 13px;">
    <div class="col-md-12 row">
      <div class="form-group col-md-3">
        <label class="text-bold">Referencia:</label>
        <div class="col">
          <input name="cod_registro" type="text" class="form-control" id="cod_registro" value="<?php echo $get_id[0]['cod_registro']; ?>" readonly>
        </div>
        
      </div>

      <div class="form-group col-md-3">
        <label class="text-bold">Informe</label>
        <div class="col">
          <select  name="id_informe" id="id_informe" class="form-control">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_informe']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
            <?php foreach($list_informe as $list){ ?>
              <option value="<?php echo $list['id_informe']; ?>" <?php if (!(strcmp($list['id_informe'], $get_id[0]['id_informe']))){ echo "selected=\"selected\"";} ?>><?php echo $list['nom_informe']; ?></option>
            <?php } ?>
          </select>
        </div>
        
      </div>

      <div class="form-group col-md-3">
        <label class="text-bold">Fecha&nbsp;Inicial</label>
        <div class="col">
          <input disabled name="fecha_inicial" type="date" class="form-control" id="fecha_inicial" value="<?php echo $get_id[0]['fec_inicial'] ?>" >
        </div>
        
      </div>

      <div class="form-group col-md-3">
        <label class="text-bold">Usuario</label>
        <div class="col">
          <input disabled class="form-control" type="text" value="<?php if($get_id[0]['web']==1){ echo "Web"; } ?>">
          
        </div>
      </div>

      <div class="form-group col-md-6">
        <label class="text-bold">Nombres y Apellidos</label>
        <div class="col">
          <input name="nombres_apellidos" type="text" class="form-control" id="nombres_apellidos" value="<?php echo $get_id[0]['nombres_apellidos'] ?>" placeholder="Nombres y Apellidos">
        </div>
        
      </div>

      
      <div class="form-group col-md-3">
        <label class="text-bold">Contacto&nbsp;1</label>
        <div class="col">
          <input name="contacto1" type="text" class="form-control" id="contacto1" maxlength="9" value="<?php echo $get_id[0]['contacto1'] ?>" placeholder="Contacto1">
        </div>
        
      </div>


      <div class="form-group col-md-3">
        <label class="text-bold">Departamento</label>
        <div class="col">
          <select  name="id_departamento" id="id_departamento"  Class="form-control" onchange="Busca_Provincia()">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_departamento']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
            <?php foreach($list_departamento as $list){ ?>
              <option value="<?php echo $list['id_departamento']; ?>" <?php if (!(strcmp($list['id_departamento'], $get_id[0]['id_departamento']))){ echo "selected=\"selected\"";} ?>><?php echo $list['nombre_departamento']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group col-md-3" id="mregion">
        <label class="text-bold">Región</label>
        <div class="col" >
          <select  name="id_provincia" id="id_provincia"  Class="form-control" onchange="MDistrito()">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_provincia']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
            <?php foreach($list_provincia as $list){ ?>
              <option value="<?php echo $list['id_provincia']; ?>" <?php if (!(strcmp($list['id_provincia'], $get_id[0]['id_provincia']))){ echo "selected=\"selected\"";} ?>><?php echo $list['nombre_provincia']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group col-md-3" id="mdistrito">
        <label class="text-bold">Distrito</label>
        <div class="col" >
          <select  name="id_distrito" id="id_distrito"  Class="form-control" >
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_distrito']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
            <?php foreach($list_distrito as $list){ ?>
              <option value="<?php echo $list['id_distrito']; ?>" <?php if (!(strcmp($list['id_distrito'], $get_id[0]['id_distrito']))){ echo "selected=\"selected\"";} ?>><?php echo $list['nombre_distrito']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="form-group col-md-3">
        <label class="text-bold">Contacto&nbsp;2</label>
        <div class="col">
          <input name="contacto2" type="text" class="form-control" id="contacto2" maxlength="9" value="<?php if($get_id[0]['contacto2']==0){ echo ""; }else{ echo $get_id[0]['contacto2']; } ?>" placeholder="Contacto2">
        </div>
        
      </div>

      <div class="form-group col-md-3">
        <label class="text-bold">Correo:</label>
        <div class="col">
          <input name="correo" type="text" class="form-control" id="correo" value="<?php echo $get_id[0]['correo'] ?>" placeholder="Correo">
        </div>
      </div>

      <div class="form-group col-md-3">
        <label class="text-bold">Facebook:</label>
        <div class="col">
          <input name="facebook" type="text" class="form-control" id="facebook" value="<?php echo $get_id[0]['facebook'] ?>" placeholder="Facebook">
        </div>
        
      </div>

      <div class="form-group col-md-3">
          <label class="text-bold">Empresa: </label>
          <div class="col">
            <select class="form-control" name="id_empresa" id="id_empresa" onchange="Busca_Sede();">
                <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_empresa']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                <?php foreach($list_empresa as $list){ ?>
                    <option value="<?php echo $list['id_empresa']; ?>" <?php if (!(strcmp($list['id_empresa'], $get_id[0]['id_empresa']))) {echo "selected=\"selected\"";} ?>><?php echo $list['cod_empresa'];?></option>
                <?php } ?>
            </select>   
          </div>       
      </div>

      <div class="form-group col-md-3" id="msede">
          <label class="text-bold">Sede: </label>
          <div class="col">
            <select class="form-control" name="id_sede" id="id_sede" onchange="Producto_Interese();">
                <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_sede']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                <?php foreach($list_sede as $list){ 
                    if($list['id_empresa']==$get_id[0]['id_empresa']){ ?>
                        <option value="<?php echo $list['id_sede']; ?>" <?php if (!(strcmp($list['id_sede'], $get_id[0]['id_sede']))) {echo "selected=\"selected\"";} ?>><?php echo $list['cod_sede'];?></option>
                    <?php } ?>
                <?php } ?>
            </select>  
          </div>     
      </div>

      <div class="form-group col-md-1">
        <label class="text-bold">No&nbsp;mailing</label>
        <div class="col">
          <label>
            <input type="checkbox" id="mailing" name="mailing" value="1" <?php if($get_id[0]['mailing']==1){ echo "checked";} ?> class="minimal"> 
            <span style="font-weight:normal"><?php echo " "; ?></span>
          </label>
        </div>
      </div>
      

      <div id="div_producto_interese" class="form-group col-md-12 row">
      <div class="form-group col-md-12">
        <div>
          <label id="etiqueta_producto" class="text-bold" >Producto Interese:&nbsp;&nbsp;</label>
        </div>
        
        <div class="col-md-3">
          <?php
          $i=0;
          if(count($list_producto_interes)>0){
          ?> 
          <?php do{ ?>
              <label>
                <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list_producto_interes0[$i]['id_producto_interes']; ?>" <?php foreach($get_producto as $productos){ if($productos['id_producto_interes']==$list_producto_interes0[$i]['id_producto_interes']){ echo "checked"; } } ?> class="check_producto_interes">
                <span style="font-weight:normal"><?php echo $list_producto_interes0[$i]['nom_producto_interes']; ?></span>&nbsp;&nbsp;
              </label><br>

              <?php $i=$i+1;}while($i< count($list_producto_interes0)); ?>
        
          <?php } ?>
        </div>

        <div class="col-md-3">
          <?php
          $i=0;
          if(count($list_producto_interes)>6){
          ?> 
          <?php do{ ?>
              <label>
                <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list_producto_interes10[$i]['id_producto_interes']; ?>" <?php foreach($get_producto as $productos){ if($productos['id_producto_interes']==$list_producto_interes10[$i]['id_producto_interes']){ echo "checked"; } } ?> class="check_producto_interes">
                <span style="font-weight:normal"><?php echo $list_producto_interes10[$i]['nom_producto_interes']; ?></span>&nbsp;&nbsp;
              </label><br>

              <?php $i=$i+1;}while($i< count($list_producto_interes10)); ?>
        
          <?php } ?>
        </div>

        <div class=" col-md-3">
          <?php
          $i=0;
          if(count($list_producto_interes)>12){
          ?> 
          <?php do{ ?>
              <label>
                <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list_producto_interes20[$i]['id_producto_interes']; ?>" <?php foreach($get_producto as $productos){ if($productos['id_producto_interes']==$list_producto_interes20[$i]['id_producto_interes']){ echo "checked"; } } ?> class="check_producto_interes">
                <span style="font-weight:normal"><?php echo $list_producto_interes20[$i]['nom_producto_interes']; ?></span>&nbsp;&nbsp;
              </label><br>

              <?php $i=$i+1;}while($i< count($list_producto_interes20)); ?>
        
          <?php } ?>
        </div>

        <div class=" col-md-3">
          <?php
          $i=0;
          if(count($list_producto_interes)>18){
          ?> 
          <?php do{ ?>
              <label>
                <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list_producto_interes30[$i]['id_producto_interes']; ?>" <?php foreach($get_producto as $productos){ if($productos['id_producto_interes']==$list_producto_interes30[$i]['id_producto_interes']){ echo "checked"; } } ?> class="check_producto_interes">
                <span style="font-weight:normal"><?php echo $list_producto_interes30[$i]['nom_producto_interes']; ?></span>&nbsp;&nbsp;
              </label><br>

              <?php $i=$i+1;}while($i< count($list_producto_interes30)); ?>
        
          <?php } ?>
        </div>

      </div>
        
      </div>                         
  </div>

  <div class="modal-footer">
    <input  type="hidden" name="id_registro" id="id_registro" value="<?php echo $get_id[0]['id_registro'] ?>">
    <button type="button" id="btnactuInscripcion" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>

<script>
  /*function Empresa(id){
    Swal(
        'Ups!',
        'Te recomendamos crear una “Accion” informando el motivo de este cambio',
        'warning'
    ).then(function() { 
      $(".check_empresa").prop('checked',false);
      $(id).prop('checked',true);
    });

    var id_empresa=$(id).val();

    var url = "<?php echo site_url(); ?>CursosCortos/Empresa_Sede_Uno";
    var dataString = $("#formulario").serialize();

    $.ajax({
      url: url,
      type: 'POST',
      data: {'id_empresa':id_empresa},
      //data:dataString,
      success:function (data) {
        $('#div_sedes').html(data);
      }
    });
  }

  function Producto_Interes(){
    Swal(
        'Ups!',
        'Te recomendamos crear una “Accion” informando el motivo de este cambio',
        'warning'
    ).then(function() { });
  }*/
  $('#duplicado').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

  function Producto_Interese(){
    var id_empresa=$('#id_empresa').val();
    var id_sede=$('#id_sede').val();

    if(id_empresa!=0 && id_sede!=0){
      var url = "<?php echo site_url(); ?>CursosCortos/Empresa_Sede_Producto_Interese";

      $.ajax({
        url: url,
        type: 'POST',
        data: {'id_empresa':id_empresa,'id_sede':id_sede},
        success:function (data) {
          $('#div_producto_interese').html(data);
        }
      });
    }
  }

  function Busca_Provincia(){
      var dataString = new FormData(document.getElementById('formulario_re'));
      var url="<?php echo site_url(); ?>CursosCortos/Muestra_Provincia";
      
      $.ajax({
          type:"POST",
          url: url,
          data:dataString,
          processData: false,
          contentType: false,
          success:function (resp) {
            $('#mregion').html(resp);
          }
      });

      MDistrito();
    }

    function MDistrito(){
      var dataString = new FormData(document.getElementById('formulario_re'));
      var url="<?php echo site_url(); ?>CursosCortos/Muestra_Distrito";
      
      $.ajax({
          type:"POST",
          url: url,
          data:dataString,
          processData: false,
          contentType: false,
          success:function (resp) {
            $('#mdistrito').html(resp);
          }
      });
    }

    function Busca_Sede(){
      var dataString1 = new FormData(document.getElementById('formulario_re'));
      var url1="<?php echo site_url(); ?>CursosCortos/Empresa_Sede_Registro";
      
      $.ajax({
          type:"POST",
          url: url1,
          data:dataString1,
          processData: false,
          contentType: false,
          success:function (resp) {
            $('#msede').html(resp);
          }
      });

      Producto_Interese();
    }
</script>

<script>
    /*var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function() {
        function set_tipo(empresa, sede, with_item) {
            $(empresa).change(function(){
                var id_empresa = $(empresa).val();
                if (Number.isInteger(Math.floor(id_empresa))) {
                    var id_url = base_url+"/CursosCortos/Empresa_Sede_Combo/"+id_empresa;
                    var items = "";
                    console.log(id_url);
                        i=0;
                        $.getJSON(id_url, function(data) {
                            $(sede).find("option").remove();
                            if (with_item == true) {
                                items="<option value='0' selected>Seleccione</option>";
                            }
                            $.each( data, function(key, val) { i++;
                            items = items+"<option  value='" + val.id_sede + "'>" + val.cod_sede + "</option>";   
                            });
                            $(sede).find("option").remove();
                            $(sede).append(items);
                            $(".chosen-select1").val('').trigger("chosen:updated");
                            $(".chosen-select2").val('').trigger("chosen:updated");
                            $('.chosen-select1').chosen();
                        });
                    }
            });
        }
        set_tipo("#empresa", "#sede", true);
    });*/
</script>

<script>
    /*var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function() {
        function set_tipo(departamento, provincia, with_item) {
            $(departamento).change(function(){
                var id_departamento = $(departamento).val();
                if (Number.isInteger(Math.floor(id_departamento))) {
                    var id_url = base_url+"/CursosCortos/Departamento_Provincia/"+id_departamento;
                    var items = "";
                    console.log(id_url);
                        i=0;
                        $.getJSON(id_url, function(data) {
                            $(provincia).find("option").remove();
                            if (with_item == true) {
                                items="<option value='0' selected>Seleccione</option>";
                            }
                            $.each( data, function(key, val) { i++;
                            items = items+"<option  value='" + val.id_provincia + "'>" + val.nombre_provincia + "</option>";   
                            });
                            $(provincia).find("option").remove();
                            $(provincia).append(items);
                            $(".chosen-select1").val('').trigger("chosen:updated");
                            $(".chosen-select2").val('').trigger("chosen:updated");
                            $('.chosen-select1').chosen();
                        });
                    }
            });
        }
        set_tipo("#departamento", "#provincia", true);
    });*/
</script>

<script>
    /*var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function() {
        function set_tipo(provincia, distrito, with_item) {
            $(provincia).change(function(){
                var id_provincia = $(provincia).val();
                if (Number.isInteger(Math.floor(id_provincia))) {
                    var id_url = base_url+"/CursosCortos/Provincia_Distrito/"+id_provincia;
                    var items = "";
                    console.log(id_url);
                        i=0;
                        $.getJSON(id_url, function(data) {
                            $(distrito).find("option").remove();
                            if (with_item == true) {
                                items="<option value='0' selected>Seleccione</option>";
                            }
                            $.each( data, function(key, val) { i++;
                            items = items+"<option  value='" + val.id_distrito + "'>" + val.nombre_distrito + "</option>";   
                            });
                            $(distrito).find("option").remove();
                            $(distrito).append(items);
                            $(".chosen-select1").val('').trigger("chosen:updated");
                            $(".chosen-select2").val('').trigger("chosen:updated");
                            $('.chosen-select1').chosen();
                        });
                    }
            });
        }
        set_tipo("#provincia", "#distrito", true);
    });*/
</script>

<script>
  $("#btnactuInscripcion").on('click', function(e){
    var id_registro=$('#id_registro').val();
    var dataString = new FormData(document.getElementById('formulario_re'));
    var url="<?php echo site_url(); ?>CursosCortos/Update_Registro_Mail";
    if (valida_edicion()) {
      bootbox.confirm({
        title: "Actualizar Registro",
        message: "¿Desea actualizar datos de registro?",
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
              $.ajax({
                  type:"POST",
                  url: url,
                  data:dataString,
                  processData: false,
                  contentType: false,
                  success:function () {
                      swal.fire(
                          'Actualización Exitosa!',
                          '',
                          'success'
                      ).then(function() {
                          window.location = "<?php echo site_url(); ?>CursosCortos/Historial_Registro_Mail/"+id_registro;
                          
                      });
                  }
              });
            }
        } 
      });
    }
  });

  function valida_edicion() {
    if($('#id_empresa').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Empresa.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_sede').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Sede.',
          'warning'
      ).then(function() { });
      return false;
    }

    return true;
  }
</script>


