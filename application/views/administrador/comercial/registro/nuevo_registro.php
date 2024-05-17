<form id="formulario_r"  method="POST" enctype="multipart/form-data" class="formulario">
  <div class="modal-header">
      <h5 class="tile-title"><b>Dep. Comercial (Nuevo)</b></h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>

  <div class="modal-body" style="max-height:520px; overflow:auto;font-size: 13px;">
    <div class="col-md-12 row">
      <div class="form-group col-md-2">
        <label class="control-label text-bold">Referencia:</label>
        <input name="cod_registro" type="text" value="<?php echo $codigo ?>" class="form-control" id="cod_registro" readonly>
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Informe</label>
        <select name="id_informe" id="id_informe" class="form-control">
          <option value="0" >Seleccione</option>
          <?php foreach($list_informe as $list){ ?>
              <option value="<?php echo $list['id_informe']; ?>"><?php echo $list['nom_informe'];?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Fecha&nbsp;Contacto</label>
        <input  name="fecha_inicial" type="date" class="form-control" value="<?php echo  $hoy?>" id="fecha_inicial">
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold">Usuario</label><br>
        
        <input name="" type="text" class="form-control" id="" value ="<?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?>" readonly>
      </div>

      <div class="form-group col-sm-8">
        <label class="control-label text-bold">Nombres y Apellidos</label>
        <input name="nombres_apellidos" type="text" class="form-control" id="nombres_apellidos" placeholder="Nombres y Apellidos">
      </div>

      <div class="form-group col-sm-4">
        <label class="control-label text-bold">Contacto&nbsp;Principal</label>
        <input name="contacto1" type="text" class="form-control" id="contacto1" maxlength="9" placeholder="Contacto Principal">
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Departamento</label>
        <select  name="id_departamento" id="id_departamento"  Class="form-control" onchange="Busca_Provincia()">
          <option value="0" >Seleccione</option>
          <?php foreach($list_departamento as $list){ ?>
            <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento'];?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-4" id="mregion">
        <label class="control-label text-bold">Región</label>
        <select  name="id_provincia" id="id_provincia" class="form-control">
          <option value="0" >Seleccione</option>
        </select>
      </div>

      <div class="form-group col-md-4" id="mdistrito">
        <label class="control-label text-bold">Distrito</label>
        <select  name="id_distrito" id="id_distrito"  Class="form-control">
          <option value="0" >Seleccione</option>
        </select>
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Contacto&nbsp;2</label>
        <input name="contacto2" type="text" class="form-control" id="contacto2" maxlength="9" placeholder="Contacto 2">
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Correo:</label>
        <input name="correo" type="text" class="form-control" id="correo" placeholder="Correo">
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Facebook:</label>
        <input name="facebook" type="text" class="form-control" id="facebook" placeholder="Facebook">
      </div>

      <div class="form-group col-md-4">
        <label class="control-label text-bold">Empresa:</label>
        <select  name="id_empresa" id="id_empresa" class="form-control" onchange="Busca_Sede()">
          <option value="0" >Seleccione</option>
          <?php foreach($list_empresa as $list){ ?>
            <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group col-md-4" id="msede">
        <label class="control-label text-bold">Sede:</label>
        <select  name="id_sede" id="id_sede" class="form-control" onchange="Producto_Interese();">
          <option value="0" >Seleccione</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label class="control-label text-bold" title="Registros adicionales independientes del actual!">N°&nbsp;Duplicados</label>
        <input name="duplicado" type="text" class="form-control" id="duplicado" maxlength="9"  placeholder="Cantidad" title="Registros adicionales independientes del actual!">
      </div>

      <div class="form-group col-md-2">
        <br>
        <label class="control-label text-bold">No mailing&nbsp;&nbsp;</label>
        <label>
          <input type="checkbox" id="mailing" name="mailing" value="1" class="minimal"> 
          <span style="font-weight:normal"><?php echo " "; ?></span>
        </label>
      </div>

      <div id="div_producto_interese" class="form-group col-md-12 row">
      </div>

      <div class="form-group col-md-12">
        <label class="control-label text-bold">Comentario:</label>
        <textarea name="observacion" rows="1" maxlength="35" class="form-control" id="observacion" placeholder="Ingrese Comentario"></textarea>
      </div>

      <div class="form-group col-md-12">
        <label class="control-label text-bold">Observaciones:</label>
        <textarea name="mensaje" rows="5" class="form-control" id="mensaje" placeholder="Observaciones"></textarea>
      </div>                           
  </div>

  <div class="modal-footer">
    <button type="button" id="btnactuInscripcion" class="btn btn-primary"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
  </div>
</form>

<script>
  /*function Empresa(id){
    $(".check_empresa").prop('checked',false);
    $(id).prop('checked',true);

    var id_empresa=$(id).val();

    var url = "<?php echo site_url(); ?>Administrador/Empresa_Sede_Mail";
    var dataString = $("#formulario").serialize();

    $.ajax({
      url: url,
      type: 'POST',
      data: {'id_empresa':id_empresa},
      data:dataString,
      success:function (data) {
        $('#div_sedes').html(data);
      }
    });
  }*/

  $('#duplicado').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

  function Busca_Sede(){
      var dataString1 = new FormData(document.getElementById('formulario_r'));
      var url1="<?php echo site_url(); ?>Administrador/Empresa_Sede_Registro";
      
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
  function Producto_Interese(){
    var id_empresa=$('#id_empresa').val();
    var id_sede=$('#id_sede').val();

    if(id_empresa!=0 && id_sede!=0){
      var url = "<?php echo site_url(); ?>Administrador/Empresa_Sede_Producto_Interese";

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
</script>

<script>
    /*var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function() {
        function set_tipo(empresa, sede, with_item) {
            $(empresa).change(function(){
                var id_empresa = $(empresa).val();
                if (Number.isInteger(Math.floor(id_empresa))) {
                    var id_url = base_url+"/Administrador/Empresa_Sede_Combo/"+id_empresa;
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
  function Cambiar_Accion(){
    var id_accion=$('#id_accion').val();

    if(id_accion==5){
      $('#id_status').val(18);
    }else if(id_accion==1){
      $('#id_status').val(14);
    }else{
      $('#id_status').val(0);
    }

    if(id_accion==2 || id_accion==3 || id_accion==4){
      $('#fecha_accion').attr('readonly', false);
    }else{
      $('#fecha_accion').attr('readonly', true);
    }
  }
</script>

<script>
    var base_url = "<?php echo site_url(); ?>";
    /*$(document).ready(function() {
        
    });*/

    /*function set_tipo(departamento, provincia, with_item) {
        $(departamento).change(function(){
            var id_departamento = $(departamento).val();
            if (Number.isInteger(Math.floor(id_departamento))) {
                var id_url = base_url+"/Administrador/Departamento_Provincia/"+id_departamento;
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
    set_tipo("#departamento", "#provincia", true);*/
    function Busca_Provincia(){
      var dataString = new FormData(document.getElementById('formulario_r'));
      var url="<?php echo site_url(); ?>Administrador/Muestra_Provincia";
      
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
      var dataString = new FormData(document.getElementById('formulario_r'));
      var url="<?php echo site_url(); ?>Administrador/Muestra_Distrito";
      
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

</script>

<script>
    /*var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function() {
        function set_tipo(provincia, distrito, with_item) {
            $(provincia).change(function(){
                var id_provincia = $(provincia).val();
                if (Number.isInteger(Math.floor(id_provincia))) {
                    var id_url = base_url+"/Administrador/Provincia_Distrito/"+id_provincia;
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
  $(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
  });

  $("#btnactuInscripcion").on('click', function(e){

    var dataString = new FormData(document.getElementById('formulario_r'));
    var url="<?php echo site_url(); ?>Administrador/Insert_Registro_Mail";

    cod_registro =document.getElementById("cod_registro").value;
    mensaje="El registro con el código <b>"+cod_registro+"</b> ha sido creado correctamente."
    if (Valida_Registro_Mail()) {
      bootbox.confirm({
        title: "Registrar Registro Mail",
        message: "¿Desea registrar datos de registro mail?",
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
                          'Registro Exitoso!',
                          '',
                          'success'
                      ).then(function() {
                          window.location = "<?php echo site_url(); ?>Administrador/Registro ";
                          
                      });
                  }
              });
              /*swal.fire(
                        'Registro Exitoso!',
                        mensaje,
                        'success'
                    ).then(function() {
                      $('#formulario').submit();
                    });*/
                
            }
        } 
      });
    }else{
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

  function Valida_Registro_Mail() {
    var contador_producto=0;
    if($('#id_informe').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Informe.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#nombres_apellidos').val()==""){
      Swal(
          'Ups!',
          'Debe ingresar Nombres.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#contacto1').val()==""){
      Swal(
          'Ups!',
          'Debe ingresar Contacto.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_departamento').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Departamento.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_provincia').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Región.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_distrito').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Distrito.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#correo').val()==""){
      Swal(
          'Ups!',
          'Debe ingresar Correo.',
          'warning'
      ).then(function() { });
      return false;
    }
    /*if($('#facebook').val()==""){
      Swal(
          'Ups!',
          'Debe ingresar Facebook.',
          'warning'
      ).then(function() { });
      return false;
    }*/
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
    if($('#id_status').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Estado.',
          'warning'
      ).then(function() { });
      return false;
    }

    $(".check_producto").each(function(){
      if($(this).is(":checked"))
      contador_producto++;
    });

    if(contador_producto==0){
      Swal(
          'Ups!',
          'Debe seleccionar Producto de Interés.',
          'warning'
      ).then(function() { });
      return false;
    }
    
    
    return true;
  }
</script>

   




