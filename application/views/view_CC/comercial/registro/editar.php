<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed'); 
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_CC/header'); ?>
<?php $this->load->view('view_CC/nav'); ?>

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
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Registro <b><?php echo $get_id[0]['cod_registro']; ?></b></span></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <form id="formulario_re" method="POST" enctype="multipart/form-data" class="formulario">
      <div class="col-md-12 row">
        <div class="form-group col-md-3">
          <label class="text-bold">Referencia:</label>
          <div class="col">
            <input name="cod_registro" type="text" class="form-control fondo_ref" id="cod_registro" value="<?php echo $get_id[0]['cod_registro']; ?>" readonly>
          </div>
          
        </div>

        <div class="form-group col-md-3">
          <label class="text-bold">Tipo</label>
          <div class="col">
            <?php if($get_id[0]['id_evento']>0){ ?>
              <input type="text" class="form-control" value="<?php echo $get_id[0]['nom_informe']; ?>" readonly>
              <input type="hidden" id="id_informe" name="id_informe" value="<?php echo $get_id[0]['id_informe']; ?>">
            <?php }else{ ?>
              <select name="id_informe" id="id_informe" class="form-control">
                <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_informe']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                <?php foreach($list_informe as $list){ ?>
                  <option value="<?php echo $list['id_informe']; ?>" <?php if (!(strcmp($list['id_informe'], $get_id[0]['id_informe']))){ echo "selected=\"selected\"";} ?>><?php echo $list['nom_informe']; ?></option>
                <?php } ?>
              </select>
            <?php } ?>
          </div>
        </div>

        <div class="form-group col-md-3">
          <label class="text-bold">Fecha&nbsp;Contacto</label>
          <div class="col">
            <input disabled name="fecha_inicial" type="date" class="form-control" id="fecha_inicial" value="<?php echo $get_id[0]['fec_inicial'] ?>" >
          </div>
          
        </div>

        <div class="form-group col-md-3">
          <label class="text-bold">Usuario</label>
          <div class="col">
            <input disabled class="form-control" type="text" value="<?php if($get_id[0]['web']==1){ echo "Web"; }else{ echo $get_id[0]['usuario_codigo']; } ?>">
          </div>
        </div>

        <div class="form-group col-md-6">
          <label class="text-bold">Nombres y Apellidos</label>
          <div class="col">
            <input name="nombres_apellidos" type="text" class="form-control" id="nombres_apellidos" value="<?php echo $get_id[0]['nombres_apellidos'] ?>" placeholder="Nombres y Apellidos" onkeypress="if(event.keyCode == 13){ Update_Registro(); }">
          </div>
        </div>

        <div class="form-group col-md-3">
          <label class="control-label text-bold">DNI</label>
          <input name="dni" type="text" class="form-control" id="dni" placeholder="DNI" maxlength="8" value="<?php echo $get_id[0]['dni']; ?>" onkeypress="if(event.keyCode == 13){ Update_Registro(); }">
        </div>

        <div class="form-group col-md-3">
          <label class="text-bold">Contacto&nbsp;1</label>
          <div class="col">
            <input name="contacto1" type="text" class="form-control" id="contacto1" maxlength="9" value="<?php echo $get_id[0]['contacto1'] ?>" placeholder="Contacto1" onkeypress="if(event.keyCode == 13){ Update_Registro(); }">
          </div>
        </div>

        <div class="form-group col-md-3">
          <label class="text-bold">Contacto&nbsp;2</label>
          <div class="col">
            <input name="contacto2" type="text" class="form-control" id="contacto2" maxlength="9" value="<?php if($get_id[0]['contacto2']==0){ echo ""; }else{ echo $get_id[0]['contacto2']; } ?>" placeholder="Contacto2" onkeypress="if(event.keyCode == 13){ Update_Registro(); }">
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
          <label class="text-bold">Provincia</label>
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
          <label class="text-bold">Correo:</label>
          <div class="col">
            <input name="correo" type="text" class="form-control" id="correo" value="<?php echo $get_id[0]['correo'] ?>" placeholder="Correo" onkeypress="if(event.keyCode == 13){ Update_Registro(); }">
          </div>
        </div>

        <div class="form-group col-md-3">
          <label class="text-bold">Facebook:</label>
          <div class="col">
            <input name="facebook" type="text" class="form-control" id="facebook" value="<?php echo $get_id[0]['facebook'] ?>" placeholder="Facebook" onkeypress="if(event.keyCode == 13){ Update_Registro(); }">
          </div>
          
        </div>

        <div class="form-group col-md-1" style="display: none;">
            <label class="text-bold">Empresa: </label>
            <div class="col">
              <select class="form-control" name="id_empresa" id="id_empresa" onchange="Busca_Sede();">
                  <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_empresa']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                  <?php foreach($list_empresas as $list){ ?>
                      <option value="<?php echo $list['id_empresa']; ?>" <?php if (!(strcmp($list['id_empresa'], $get_id[0]['id_empresa']))) {echo "selected=\"selected\"";} ?>><?php echo $list['cod_empresa'];?></option>
                  <?php } ?>
              </select>   
            </div>       
        </div>

        <div class="form-group col-md-1" id="msede" style="display: none;">
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
              <input type="checkbox" id="mailing" name="mailing" value="1" <?php if($get_id[0]['mailing']==1){ echo "checked";} ?> class="minimal" onkeypress="if(event.keyCode == 13){ Update_Registro(); }"> 
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
              <input type="hidden" id="cant_interes" name="cant_interes" value="<?php echo count($list_producto_interes) ?>">
              <?php
              $i=0;
              if(count($list_producto_interes)>0){
              ?> 
              <?php do{ ?>
                  <label>
                    <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list_producto_interes0[$i]['id_producto_interes']; ?>" <?php foreach($get_producto as $productos){ if($productos['id_producto_interes']==$list_producto_interes0[$i]['id_producto_interes']){ echo "checked"; } } ?> class="check_producto_interes grande_check">
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
                    <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list_producto_interes10[$i]['id_producto_interes']; ?>" <?php foreach($get_producto as $productos){ if($productos['id_producto_interes']==$list_producto_interes10[$i]['id_producto_interes']){ echo "checked"; } } ?> class="check_producto_interes grande_check">
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
                    <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list_producto_interes20[$i]['id_producto_interes']; ?>" <?php foreach($get_producto as $productos){ if($productos['id_producto_interes']==$list_producto_interes20[$i]['id_producto_interes']){ echo "checked"; } } ?> class="check_producto_interes grande_check">
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
                    <input type="checkbox" id="id_producto[]" name="id_producto[]" value="<?php echo $list_producto_interes30[$i]['id_producto_interes']; ?>" <?php foreach($get_producto as $productos){ if($productos['id_producto_interes']==$list_producto_interes30[$i]['id_producto_interes']){ echo "checked"; } } ?> class="check_producto_interes grande_check">
                    <span style="font-weight:normal"><?php echo $list_producto_interes30[$i]['nom_producto_interes']; ?></span>&nbsp;&nbsp;
                  </label><br>

                  <?php $i=$i+1;}while($i< count($list_producto_interes30)); ?>
            
              <?php } ?>
            </div>

          </div>
        </div>
      </div>     
      
      <div class="modal-footer">
        <input  type="hidden" name="importacion_evento" id="importacion_evento" value="<?php echo $get_id[0]['importacion_evento'] ?>">
        <input  type="hidden" name="id_registro" id="id_registro" value="<?php echo $get_id[0]['id_registro'] ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Registro();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <a class="btn btn-default" href="<?= site_url('CursosCortos/Historial_Registro_Mail') ?>/<?php echo $get_id[0]['id_registro']; ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
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

<?php $this->load->view('view_CC/footer'); ?>

<script>
  $('#duplicado').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $('#dni').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  function Producto_Interese(){
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

  function Update_Registro(){
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

    var id_registro=$('#id_registro').val();
    var dataString = new FormData(document.getElementById('formulario_re'));
    var url="<?php echo site_url(); ?>CursosCortos/Update_Registro_Mail";

    var contacto1=$('#contacto1').val();
    var correo=$('#correo').val();

    if (Valida_Registro_Mail()) {
      if(contacto1=="" && correo==""){
        var url2="<?php echo site_url(); ?>CursosCortos/Delete_Registro_Mail";

        Swal({
            title: '¿Desea actualizar de todos modos?',
            text: "Teniendo en cuenta que no tenemos cualquier contacto vamos pasar este registro a Eliminado. Está seguro?",
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
                  url: url2,
                  data: {'id_registro':id_registro},
                  success:function (data) {
                    swal.fire(
                        'Eliminación Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>CursosCortos/Registro";
                    });
                  }
              });
            }
        })
      }else{
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
              if(data=="error"){
                Swal({
                    title: 'Actualización Denegada',
                    text: "¡El registro ya existe!",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
              }else{
                swal.fire(
                    'Actualización Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    window.location = "<?php echo site_url(); ?>CursosCortos/Historial_Registro_Mail/"+id_registro;
                });
              }
            }
        });
      }
    }
  }

  function Valida_Registro_Mail() {
    emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    var contador_producto=0;
    if($('#importacion_evento').val()=="0"){
      if($('#id_informe').val()=="0"){
        Swal(
            'Ups!',
            'Debe seleccionar Informe.',
            'warning'
        ).then(function() { });
        return false;
      }
    }
    if($('#nombres_apellidos').val()==""){
      Swal(
          'Ups!',
          'Debe ingresar Nombres.',
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
      $(".check_producto_interes").each(function(){
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
    /*if($('#id_status').val()=="0"){
      Swal(
          'Ups!',
          'Debe seleccionar Estado.',
          'warning'
      ).then(function() { });
      return false;
    }
    $(".check_producto_interes").each(function(){
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