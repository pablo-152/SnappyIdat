<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel']; 
?>

<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<style>
  .fondo_ref{
    background-color:#715d74 !important;
    color:white;
  }

  .grande_check{
    width: 20px;
    height: 20px;
  }
</style>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Dep. Comercial (Nuevo)</b></span></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <form id="formulario_r"  method="POST" enctype="multipart/form-data" class="formulario">
      <div class="col-md-12 row">
        <div class="form-group col-md-3">
          <label class="control-label text-bold">Referencia:</label>
          <input name="cod_registro" type="text" value="<?php echo $codigo ?>" class="form-control fondo_ref" id="cod_registro" readonly>
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Tipo</label>
          <select name="id_informe" id="id_informe" class="form-control">
            <option value="0" >Seleccione</option>
            <?php foreach($list_informe as $list){ ?>
                <option value="<?php echo $list['id_informe']; ?>"><?php echo $list['nom_informe'];?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Fecha&nbsp;Contacto</label>
          <input  name="fecha_inicial" type="date" class="form-control" value="<?php echo  $hoy?>" id="fecha_inicial" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }">
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Usuario</label><br>
          
          <input name="" type="text" class="form-control" id="" value ="<?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?>" readonly>
        </div>

        <div class="form-group col-md-6">
          <label class="control-label text-bold">Nombres y Apellidos</label>
          <input name="nombres_apellidos" type="text" class="form-control" id="nombres_apellidos" placeholder="Nombres y Apellidos" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }">
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">DNI</label>
          <input name="dni" type="text" class="form-control" id="dni" placeholder="DNI" maxlength="8" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }">
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Contacto 1</label>
          <input name="contacto1" type="text" class="form-control" id="contacto1" maxlength="9" placeholder="Contacto Principal" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }">
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Contacto 2</label>
          <input name="contacto2" type="text" class="form-control" id="contacto2" maxlength="9" placeholder="Contacto 2" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }">
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Departamento</label>
          <select  name="id_departamento" id="id_departamento"  Class="form-control" onchange="Busca_Provincia()">
            <option value="0" >Seleccione</option>
            <?php foreach($list_departamento as $list){ ?>
              <option value="<?php echo $list['id_departamento']; ?>"><?php echo $list['nombre_departamento'];?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-3" id="mregion">
          <label class="control-label text-bold">Provincia</label>
          <select  name="id_provincia" id="id_provincia" class="form-control">
            <option value="0" >Seleccione</option>
          </select>
        </div>

        <div class="form-group col-md-3" id="mdistrito">
          <label class="control-label text-bold">Distrito</label>
          <select  name="id_distrito" id="id_distrito"  Class="form-control">
            <option value="0" >Seleccione</option>
          </select>
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Correo:</label>
          <input name="correo" type="text" class="form-control" id="correo" placeholder="Correo" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }">
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">Facebook:</label>
          <input name="facebook" type="text" class="form-control" id="facebook" placeholder="Facebook" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }">
        </div>

        <div class="form-group col-md-1">
          <label class="control-label text-bold">Empresa:</label>
          <select  name="id_empresa" id="id_empresa" class="form-control" onchange="Busca_Sede()">
            <option value="0" >Seleccione</option>
            <?php foreach($list_empresas as $list){ ?>
              <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group col-md-1" id="msede">
          <label class="control-label text-bold">Sede:</label>
          <select  name="id_sede" id="id_sede" class="form-control" onchange="Producto_Interese();">
            <option value="0" >Seleccione</option>
          </select>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold" title="Registros adicionales independientes del actual!">N°&nbsp;Duplicados</label>
          <input name="duplicado" type="text" class="form-control" id="duplicado" maxlength="9"  placeholder="Cantidad" title="Registros adicionales independientes del actual!" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">No mailing&nbsp;&nbsp;</label>
          <div class="col">
            <label>
              <input type="checkbox" id="mailing" name="mailing" value="1" class="minimal" onkeypress="if(event.keyCode == 13){ Insert_Registro(); }"> 
              <span style="font-weight:normal"><?php echo " "; ?></span>
            </label>
          </div>
        </div>

        <div id="div_producto_interese" class="form-group col-md-12 row">
          <input type="hidden" id="cant_interes" name="cant_interes" value="0">
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
        <button type="button" class="btn btn-primary" onclick="Insert_Registro();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <a type="button" class="btn btn-default" href="<?= site_url('Administrador/Registro') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#comercial").addClass('active');
    $("#hcomercial").attr('aria-expanded','true');
    $("#registro").addClass('active');
    document.getElementById("rcomercial").style.display = "block";
  });
</script>

<?php $this->load->view('Admin/footer'); ?>

<script>
  $('#duplicado').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $('#dni').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  function Busca_Sede(){
    $(document)
    .ajaxStart(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    })
    .ajaxStop(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            timeout: 100,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    });
    
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

    if(id_empresa!=0){
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

  function Busca_Provincia(){
    $(document)
    .ajaxStart(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    })
    .ajaxStop(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            timeout: 100,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    });

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
    $(document)
    .ajaxStart(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    })
    .ajaxStop(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            timeout: 100,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    });

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

  function Insert_Registro(){
    $(document)
    .ajaxStart(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    })
    .ajaxStop(function () {
        $.blockUI({
            message: '<svg> ... </svg>',
            fadeIn: 800,
            timeout: 100,
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                zIndex: 1201,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
    });

    var dataString = new FormData(document.getElementById('formulario_r'));
    var url="<?php echo site_url(); ?>Administrador/Insert_Registro_Mail";

    cod_registro =document.getElementById("cod_registro").value;
    mensaje="El registro con el código <b>"+cod_registro+"</b> ha sido creado correctamente."

    if (Valida_Registro_Mail()) {
      $.ajax({
          type:"POST",
          url: url,
          data:dataString,
          processData: false,
          contentType: false,
          success:function (data) {
            if(data=="error"){
              Swal({
                  title: 'Registro Denegado',
                  text: "¡El registro ya existe!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              });
            }else{
              swal.fire(
                  'Registro Exitoso!',
                  'Haga clic en el botón!',
                  'success'
              ).then(function() {
                  window.location = "<?php echo site_url(); ?>Administrador/Registro";
              });
            }
          }
      });
    }
  }

  function Valida_Registro_Mail() {
    emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
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
    if($('#contacto1').val()=="" && $('#correo').val()==""){
      Swal(
          'Ups!',
          'Debe ingresar Contacto 1 o Correo.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#correo').val()!=""){
      if(!emailRegex.test($('#correo').val())){
        Swal(
            'Ups!',
            'Debe ingresar Correo Válido.',
            'warning'
        ).then(function() { });
        return false;
      }
    }
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
    if($('#cant_interes').val()>0){
      $(".check_producto").each(function(){
        if($(this).is(":checked"))
        contador_producto++;
      });
      if(contador_producto>1){
        Swal(
            'Ups!',
            'Solo puede seleccionar un producto de interés.',
            'warning'
        ).then(function() { });
        return false;
      }
    }
    /*$(".check_producto").each(function(){
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
    }*/
    return true;
  }
</script>