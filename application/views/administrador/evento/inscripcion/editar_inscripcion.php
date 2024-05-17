<form id="formulario_inscripcion"  method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h3 class="tile-title">Edición de Datos de <b><?php echo $get_id[0]['cod_inscripcion'];?></b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    
    <div class="modal-body" >
        <div class="col-md-12 row">
          <div class="form-group col-md-2">
            <label class="control-label text-bold">Empresa:</label>
          </div>
          <div class="form-group col-md-2">
            <input type="text" class="form-control" readonly value="<?php echo $get_id[0]['cod_empresa']; ?>" >
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Evento:</label>
          </div>
          <div class="form-group col-md-6">
            <input type="text" class="form-control" readonly value="<?php echo $get_id[0]['nom_evento']; ?>" >
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Nombres:</label>
          </div>
          <div class="form-group col-md-4">
            <input name="nombres" type="text" maxlength="100" class="form-control" id="nombres" value="<?php echo $get_id[0]['nombres'] ?>" placeholder="Ingresar Nombres" onkeypress="if(event.keyCode == 13){ Update_Inscripcion(); }">
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Alumno:</label>
          </div>
          <div class="form-group col-md-4">
            <input name="alumno" type="text" maxlength="100" class="form-control" id="alumno" value="<?php echo $get_id[0]['alumno'] ?>" placeholder="Ingresar Alumno" onkeypress="if(event.keyCode == 13){ Update_Inscripcion(); }">
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Correo:</label>
          </div>
          <div class="form-group col-md-4">
            <input name="correo" type="text" maxlength="100" class="form-control" id="correo" value="<?php echo $get_id[0]['correo'] ?>" placeholder="Ingresar Correo" onkeypress="if(event.keyCode == 13){ Update_Inscripcion(); }">
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Celular:</label>
          </div>
          <div class="form-group col-md-4">
            <input type="text" class="form-control" id="celular" name="celular" maxlength="9" value="<?php echo $get_id[0]['celular'] ?>" placeholder="Ingresar Celular" onkeypress="if(event.keyCode == 13){ Update_Inscripcion(); }">
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">DNI:</label>
          </div>
          <div class="form-group col-md-4">
            <input type="text" class="form-control" id="dni" name="dni" maxlength="8" value="<?php echo $get_id[0]['dni'] ?>" placeholder="Ingresar DNI" onkeypress="if(event.keyCode == 13){ Update_Inscripcion(); }">
          </div>

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Grado:</label>
          </div>
          <div class="form-group col-md-4">
              <?php if($get_id[0]['id_empresa']==6){ ?>
                <select class="form-control" id="id_anio_escuela">
                  <option value="0">Seleccione</option>
                  <option value="1" <?php if($get_id[0]['id_grado_escuela']==1){ echo "selected"; } ?>>Sin Especificar</option>
                  <option value="2" <?php if($get_id[0]['id_grado_escuela']==2){ echo "selected"; } ?>>Administración Empresas</option>
                  <option value="3" <?php if($get_id[0]['id_grado_escuela']==3){ echo "selected"; } ?>>Contabilidad con Mención en Finanzas</option>
                  <option value="4" <?php if($get_id[0]['id_grado_escuela']==4){ echo "selected"; } ?>>Desarrollo de Sistemas de Información</option>
                  <option value="5" <?php if($get_id[0]['id_grado_escuela']==5){ echo "selected"; } ?>>Enfermería Técnica</option>
                  <option value="6" <?php if($get_id[0]['id_grado_escuela']==6){ echo "selected"; } ?>>Farmacia Técnica</option>
                </select>
              <?php }else{ ?>
                <select class="form-control" name="id_anio_escuela" id="id_anio_escuela" >
                  <option value="0">Seleccione</option>
                  <?php foreach($list_grado as $list){ 
                  if($get_id[0]['id_grado_escuela'] == $list['id_anio_escuela']){ ?>
                  <option selected value="<?php echo $list['id_anio_escuela'] ; ?>">
                  <?php echo $list['nom_anio_escuela'];?></option>
                  <?php }else
                  {?>
                  <option value="<?php echo $list['id_anio_escuela']; ?>"><?php echo $list['nom_anio_escuela'];?></option>
                  <?php }} ?>
                </select>
              <?php } ?>
          </div>

          <!--<div class="form-group col-md-2">
            <label class="control-label text-bold">Conversatorio:</label>
          </div>
          <div class="form-group col-md-4">
              <select class="form-control" name="id_conversatorio" id="id_conversatorio">
                  <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_conversatorio']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                  <?php foreach($list_conversatorio as $list){ ?>
                      <option value="<?php echo $list['id_conversatorio']; ?>" <?php if (!(strcmp($list['id_conversatorio'], $get_id[0]['id_conversatorio']))) {echo "selected=\"selected\"";} ?>>
                      <?php echo $list['nom_conversatorio'];?></option>
                  <?php } ?>
              </select>
          </div>-->

          <div class="form-group col-md-2">
            <label class="control-label text-bold">Estado:</label>
          </div>
          <div class="form-group col-md-4">
            <?php if($get_id[0]['id_estadoi']==1){ ?>
              <select class="form-control" name="id_estadoi" id="id_estadoi">
                  <?php foreach($list_estado as $list){ if($list['id_estadoi']==1){ ?>
                      <option value="<?php echo $list['id_estadoi']; ?>" <?php if (!(strcmp($list['id_estadoi'], $get_id[0]['id_estadoi']))) {echo "selected=\"selected\"";} ?>>
                      <?php echo $list['nom_estadoi'];?></option>
                  <?php }} ?>
              </select>
            <?php } ?>
            <?php if($get_id[0]['id_estadoi']==2){ ?>
              <select class="form-control" name="id_estadoi" id="id_estadoi">
                  <?php foreach($list_estado as $list){ if($list['id_estadoi']!=4 && $list['id_estadoi']!=5){ ?>
                      <option value="<?php echo $list['id_estadoi']; ?>" <?php if (!(strcmp($list['id_estadoi'], $get_id[0]['id_estadoi']))) {echo "selected=\"selected\"";} ?>>
                      <?php echo $list['nom_estadoi'];?></option>
                  <?php }} ?>
              </select>
            <?php } ?>
            <?php if($get_id[0]['id_estadoi']==3){ ?>
              <select class="form-control" name="id_estadoi" id="id_estadoi">
                  <?php foreach($list_estado as $list){ if($list['id_estadoi']!=2){ ?>
                      <option value="<?php echo $list['id_estadoi']; ?>" <?php if (!(strcmp($list['id_estadoi'], $get_id[0]['id_estadoi']))) {echo "selected=\"selected\"";} ?>>
                      <?php echo $list['nom_estadoi'];?></option>
                  <?php }} ?>
              </select>
            <?php } ?>
            <?php if($get_id[0]['id_estadoi']==4){ ?>
              <select class="form-control" name="id_estadoi" id="id_estadoi">
                  <?php foreach($list_estado as $list){ if($list['id_estadoi']==1 || $list['id_estadoi']==4){ ?>
                      <option value="<?php echo $list['id_estadoi']; ?>" <?php if (!(strcmp($list['id_estadoi'], $get_id[0]['id_estadoi']))) {echo "selected=\"selected\"";} ?>>
                      <?php echo $list['nom_estadoi'];?></option>
                  <?php }} ?>
              </select>
            <?php } ?>
            <?php if($get_id[0]['id_estadoi']==5){ ?>
              <select class="form-control" name="id_estadoi" id="id_estadoi">
                  <?php foreach($list_estado as $list){ if($list['id_estadoi']==1 || $list['id_estadoi']==5){ ?>
                      <option value="<?php echo $list['id_estadoi']; ?>" <?php if (!(strcmp($list['id_estadoi'], $get_id[0]['id_estadoi']))) {echo "selected=\"selected\"";} ?>>
                      <?php echo $list['nom_estadoi'];?></option>
                  <?php }} ?>
              </select>
            <?php } ?>
          </div>   
          
          <div class="form-group col-md-12">
            <label class="control-label text-bold">Observaciones:</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="5" placeholder="Ingresar Observaciones"><?php echo $get_id[0]['observaciones']; ?></textarea>
          </div>
        </div>
    </div>

    <div class="modal-footer">
      <input type="hidden" id="id_inscripcion" name="id_inscripcion" value="<?php echo $get_id[0]['id_inscripcion'] ?>">
      <input type="hidden" id="hay_conversatorio" name="hay_conversatorio" value="<?php echo $get_id[0]['id_conversatorio']; ?>">
      <input type="hidden" id="fecha_activa" name="fecha_activa" value="<?php echo $get_id[0]['fec_agenda']; ?>">
      <input type="hidden" id="fecha_hoy" name="fecha_hoy" value="<?php echo date('Y-m-d'); ?>">
      <input type="hidden" id="id_evento_detalle" name="id_evento_detalle" value="<?php echo $id_evento; ?>">
      <button type="button" class="btn btn-primary" onclick="Update_Inscripcion();">Guardar</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
  $('#celular').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $('#dni').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  function Update_Inscripcion(){
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

    var dataString = new FormData(document.getElementById('formulario_inscripcion'));
    var url="<?php echo site_url(); ?>Administrador/Update_Inscripcion";
    var id_evento = $('#id_evento_detalle').val();

    if(valida_inscripcion()){
      $.ajax({
        url: url,
        data:dataString,
        type:"POST",
        processData: false,
        contentType: false,
        success:function (data) {
          swal.fire(
            'Actualización Exitosa',
            'Haga clic en el botón!',
            'success'
          ).then(function() {
            if(id_evento==""){
              window.location = "<?php echo site_url(); ?>Administrador/Inscripcion";
            }else{
              window.location = "<?php echo site_url(); ?>Administrador/Detalle_Evento/"+id_evento;
            }
          });
        }
      });
    }
  }

  function valida_inscripcion() {
    nombres=document.getElementById("nombres").value;
    id_estadoi=document.getElementById("id_estadoi").value;
    correo=document.getElementById("correo").value;
    celular=document.getElementById("celular").value;
    id_anio_escuela=document.getElementById("id_anio_escuela").value;
    dni=document.getElementById("dni").value;
    //id_conversatorio=document.getElementById("id_conversatorio").value;
    fecha_activa=document.getElementById("fecha_activa").value;
    fecha_hoy=document.getElementById("fecha_hoy").value;

    var num = celular.split('');
    
    if(nombres=="") {
      Swal(
          'Ups!',
          'Debe ingresar Nombres.',
          'warning'
      ).then(function() { });
      return false;
    }
    /* if(id_conversatorio=='0') {
      Swal(
          'Ups!',
          'Debe seleccionar Conservatorio.',
          'warning'
      ).then(function() { });
      return false;
    }*/
    if(celular!=""){
      if(num[0]!=9){
        Swal(
          'Ups!',
          'Formato de Celular Inválido.',
          'warning'
        ).then(function() { });
        return false;
      }
      if(celular.length!=9){
        Swal(
          'Ups!',
          'Formato de Celular Inválido.',
          'warning'
        ).then(function() { });
        return false;
      }
    }
    if(dni!=""){
      if(dni.length!=8){
        Swal(
          'Ups!',
          'Formato de DNI Inválido.',
          'warning'
        ).then(function() { });
        return false;
      }
    }
    if (fecha_activa>fecha_hoy && (id_estadoi==4 || id_estadoi==5)) {
      Swal(
          'Ups!',
          'No puede seleccionar ese Estado.',
          'warning'
      ).then(function() { });
      return false;
    }
    if(id_anio_escuela==0) {
      Swal(
          'Ups!',
          'Debe seleccionar Grado.',
          'warning'
      ).then(function() { });
      return false;
    }
    return true;
  }
</script>


