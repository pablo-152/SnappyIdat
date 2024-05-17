<div class="modal-content">
  <form class="form-horizontal" id="from_proy"  method="POST" enctype="multipart/form-data" action="<?= site_url('Administrador/update_proyecto')?>/<?php echo $get_id[0]['id_proyecto'] ?>" class="formulario">
    <?php if(isset($get_id)){ ?>
          <input  type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $get_id[0]['id_proyecto'] ?>">
    <?php } ?>

    <div class="modal-header">
        <h3 class="tile-title">Edición de Datos del Proyecto con <b>Código <?php echo $get_id[0]['cod_proyecto'];?></b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">
            <div class="form-group col-md-3">
              <label class="control-label text-bold">Solicitado Por:</label>
              <select  name="id_solicitante" id="id_solicitante"  Class="form-control">
                  <option value="0" >Seleccione</option>
                <?php foreach($solicitado as $row_p){
                    if($get_id[0]['id_solicitante'] == $row_p['id_usuario']){ ?>
                    <option selected value="<?php echo $row_p['id_usuario']; ?>"><?php echo $row_p['usuario_codigo'];?></option>  <?php }else{?>
                  <option value="<?php echo $row_p['id_usuario']; ?>"><?php echo $row_p['usuario_codigo'];?></option>
                  <?php } } ?>
              </select>
            </div>

            <div class="form-group col-md-3">
              <label class="control-label text-bold">Fecha:</label>
              <div>
              <?php echo $get_id[0]['fec_solicitante'] ?> 
              </div>
          </div>

          <div class="form-group col-md-3">
              <label class="control-label text-bold">Week Snappy Artes:</label>
            <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes" 
            value="<?php echo $get_id[0]['s_artes']; ?>" />
            <!--<select  name="s_artes" id="s_artes"  Class="form-control">
              </select>-->
            </div>

            <div class="form-group col-md-3">
              <label class="control-label text-bold">Week Snappy Redes:</label>
              <input name="s_redes" type="number" class="form-control" id="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Redes"
              value="<?php echo $get_id[0]['s_redes']; ?>" />
            </div>

            <div class="form-group col-md-12">
                        <label class="control-label text-bold" >Empresa:&nbsp;&nbsp;&nbsp;</label>
                        <label>
                            <input type="checkbox" id="GL0" name="GL0" value="1" <?php if($get_id[0]['GL0']==1){ echo "checked";} ?> class="minimal">
                            <span style="font-weight:normal">GL0</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="GL1" name="GL1" value="1" <?php if($get_id[0]['GL1']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">GL1</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="GL2" name="GL2" value="1" <?php if($get_id[0]['GL2']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">GL2</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="BL1" name="BL1" value="1" <?php if($get_id[0]['BL1']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">BL1</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="LL1" name="LL1" value="1" <?php if($get_id[0]['LL1']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">LL1</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="LL2" name="LL2" value="1" <?php if($get_id[0]['LL2']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">LL2</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="LS1" name="LS1" value="1" <?php if($get_id[0]['LS1']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">LS1</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="LS2" name="LS2" value="1" <?php if($get_id[0]['LS2']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">LS2</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="EP1" name="EP1" value="1" <?php if($get_id[0]['EP1']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">EP1</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="EP2" name="EP2" value="1" <?php if($get_id[0]['EP2']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">EP2</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="FV1" name="FV1" value="1" <?php if($get_id[0]['FV1']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">FV1</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="FV2" name="FV2" value="1" <?php if($get_id[0]['FV2']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">FV2</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="LA0" name="LA0" value="1" <?php if($get_id[0]['LA0']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">LA0</span>&nbsp;
                        </label>
                        <label>
                            <input type="checkbox" id="VJ1" name="VJ1" value="1" <?php if($get_id[0]['VJ1']==1){ echo "checked";} ?> class="minimal"/>
                            <span style="font-weight:normal">VJ1</span>&nbsp;
                        </label><!--
                        <label>
                            <input type="checkbox" onClick="marcar(this);" id="MarcarTodos" class="minimal">
                            Todas
                        </label>-->
              
            </div>
            <div class="form-group col-md-3">
              <label class="control-label text-bold">Tipo:</label>
              <select  name="id_tipo" id="id_tipo"  Class="chosen-select" style="width: 100%;">
                <option  value="" selected disabled>Seleccione</option>
                  <?php foreach($row_t as $row_t){
                      if($get_id[0]['id_tipo'] == $row_t['id_tipo']){ ?>
                      <option selected value="<?php echo $row_t['id_tipo']; ?>"><?php echo $row_t['nom_tipo'];?></option> 
                  <?php }else{?>
                  <option value="<?php echo $row_t['id_tipo']; ?>"><?php echo $row_t['nom_tipo'];?></option>
                  <?php } } ?>
              </select>
            </div>


            <div class="form-group col-md-3">
              <label class="control-label text-bold">Sub-Tipo:</label>
              <select  name="id_subtipo" id="id_subtipo"  Class="form-control">
                <option  value=""  selected>Seleccione</option>
                <?php foreach($sub_tipo as $sub){
                if($get_id[0]['id_subtipo'] == $sub['id_subtipo']){ ?> 
            <option selected value="<?php echo $sub['id_subtipo']; ?>"><?php echo $sub['nom_subtipo'];?></option>
            <?php } } ?>

              </select>
            </div>
            
            <div class="form-group col-md-3">
              <label class="control-label text-bold">Prioridad:</label>
              <select class="form-control" name="prioridad" id="prioridad">
                  <option value="0" <?php if (!(strcmp(0, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                  <option value="1" <?php if (!(strcmp(1, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>1</option>
                  <option value="2" <?php if (!(strcmp(2, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>2</option>
                  <option value="3" <?php if (!(strcmp(3, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>3</option>
                  <option value="4" <?php if (!(strcmp(4, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>4</option>
                  <option value="5" <?php if (!(strcmp(5, $get_id[0]['prioridad']))) {echo "selected=\"selected\"";} ?>>5</option>
                </select>
            </div>
            <div class="form-group col-md-3">
              <label class="control-label text-bold">Agenda / Redes:</label>
              <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha" type="date" value="<?php echo $get_id[0]['fec_agenda']; ?>" />
            </div>

            <div class="form-group col-md-12">
              <label class="control-label text-bold">Descripción:</label>
              <input name="descripcion" type="text" maxlength="50" class="form-control" id="descripcion" value="<?php echo $get_id[0]['descripcion'] ?>">
            </div>
            
              <div class=" form-group col-md-12" style="background-color:#C9C9C9;">
                <div class="row">
                <div class="col-md-3">
                  <label for="exampleInputNombnres">Status:</label>
                  <select class="form-control" name="status" id="status" onchange="muestradiv();">
                    <option value="0"<?php if (!(strcmp(0, $get_id[0]['status']))){echo "selected=\"selected\"";} ?>>Seleccione</option>
                    <?php
                    $total = count($row_s);
                    foreach($row_s as $row_s){ ?>
                  <option value="<?php echo $row_s['id_statusp']?>" <?php if (!(strcmp($row_s['id_statusp'], $get_id[0]['status']))) {echo "selected=\"selected\"";} ?>><?php echo $row_s['nom_statusp']?></option>
                    <?php } ?>
                  </select>
                </div>


                <div class="col-md-2" id="pendiente">
                        <label for="exampleInputPassword1">De:</label>
                        <select class="form-control" name="id_userpr" id="id_userpr">
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_userpr']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                      <?php
                      //$total = count($row_s);
                    foreach($usuario_subtipo as $row_c1){ ?>
                    <option value="<?php echo $row_c1['id_usuario']?>" <?php if (!(strcmp($row_c1['id_usuario'], $get_id[0]['id_userpr']))) {echo "selected=\"selected\"";} ?>><?php echo $row_c1['usuario_codigo']?></option>
                    <?php } ?>
                    </select>
                </div>

                <div class="col-md-2">
                      <label for="exampleInputPassword1">Colaborador:</label>
                      <select class="form-control" name="id_asignado" id="id_asignado">
                      <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_solicitante']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>

                      <?php
                      //$total = count($row_s);
                    foreach($usuario_subtipo1 as $row_c){ ?>
                    <option value="<?php echo $row_c['id_usuario']?>" <?php if (!(strcmp($row_c['id_usuario'], $get_id[0]['id_asignado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_c['usuario_codigo']?></option>
                    <?php } ?>
                    </select>
                </div>

                    <?php if ($get_id[0]['status']==5) { ?>
                <div class="col-md-2" id="fecha">
                        <label for="exampleInputPassword1">Fecha:</label><br>
                        <?php 
                            if ($get_id[0]['fec_termino']!='0000-00-00 00:00:00') 
                            {
                                echo date('d/m/Y', strtotime($get_id[0]['fec_termino']));
                            } 
                            else { echo date('d/m/Y'); }; ?>
                </div>
                <div class="col-md-3" id="imagen">
                        <label for="exampleInputFile">Archivo:</label>
                        <input class="form-control" name="foto" type="file" id="foto">
                </div>
                    <?php } else { ?>
                <div class="col-md-3" id="fecha">
                        <label for="exampleInputPassword1">Fecha:</label><br>
                        <?php 
                            if ($get_id[0]['fec_termino']!='0000-00-00 00:00:00') 
                            {
                                echo date('d/m/Y H:i:s', strtotime($get_id[0]['fec_termino']));
                            } 
                            else { echo date('d/m/Y'); }; ?>
                </div>
                <div class="col-md-3" id="imagen">
                        <label for="exampleInputFile">Archivo:</label>
                        <input class="form-control" name="foto" type="file" id="foto">
                </div>
                <?php } ?>
                </div>
              </div>

            <div class="form-group col-md-12">
                        <label class="control-label text-bold">Observaciones:</label>
                        <textarea name="proy_obs" rows="8" class="form-control" id="proy_obs" ><?php echo $get_id[0]['proy_obs']?></textarea>
                        <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
                </div>
        </div>                                          
    </div> 

    <div class="modal-footer">
      <button type="button" id="btnactuProyecto" class="btn btn-success">Guardar</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
  </form>
</div>

<script type="text/javascript" src="<?= base_url() ?>template/docs/js/plugins/select2.min.js"></script>

<script>
  $(".chosen-select").chosen({rtl: true}); 
  $(".chosen-select1").chosen({rtl: true});
  $(".chosen-select2").chosen({rtl: true});
  $(".chosen-select3").chosen({rtl: true});

  $(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
    status=document.getElementById("status").value;

    if(status==4){
      $('#pendiente').show();
    }else{
      $('#pendiente').hide();
    }
  });


    $("#btnactuProyecto").on('click', function(e){
      if (proyecto()) {
        bootbox.confirm({
          title: "Actualizar proyecto",
          message: "¿Desea actualizar proyecto?",
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
              $('#from_proy').submit();
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

  function proyecto() {
    /* if($('#prioridad').val()== "0") {
            msgDate = 'Dato Obligatorio.';
            inputFocus = '#prioridad';
            return false;
         }
     return true;*/
    id_solicitante=document.getElementById("id_solicitante").value;
    // fec_solicitante=document.getElementById("fec_solicitante").value;
    id_tipo=document.getElementById("id_tipo").value;
    id_subtipo=document.getElementById("id_subtipo").value;
    // prioridad=document.getElementById("prioridad").value;
    foto=document.getElementById("foto").value;

    status=document.getElementById("status").value;
    id_userpr=document.getElementById("id_userpr").value;

    if(id_solicitante=="0") {
      msgDate = 'Dato Obligatorio.';
      inputFocus = '#id_solicitante';
      return false;
    }
    
    if (id_tipo=="0") {
      msgDate = 'Dato Obligatorio.';
      inputFocus = '#id_tipo';
      return false;
    }
    
    if (id_subtipo=="0") {
     msgDate = 'Dato Obligatorio.';
      inputFocus = '#id_subtipo';
      return false;
    }

    if($('#prioridad').val()== "0") {
      msgDate = 'Dato Obligatorio.';
      inputFocus = '#prioridad';
      return false;
    }
    
    if(status==4){
      if(id_userpr=="0"){
        msgDate = 'Dato Obligatorio.';
        inputFocus = '#id_userpr';
        return false;
      }
    }

    if(status==5) {
      if(foto==""){
        msgDate = 'Tiene que adjuntar un archivo.';
        inputFocus = '#foto';
        return false;
      }
    }
  }
</script>

<script>
  var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function() {
      function set_tipo(id_tipo, id_subtipo, with_item) {
        $(id_tipo).change(function(){
          var iddep = $(id_tipo).val();
          if (Number.isInteger(Math.floor(iddep))) {
            var id_url = base_url+"/Administrador/subtipo/"+iddep;
            var items = "";
            i=0;
            $.getJSON(id_url, function(data) {
              $(id_subtipo).find("option").remove();
              if (with_item == true) {
                items="<option value='' disabled selected>Seleccione</option>";
              }
              $.each( data, function(key, val) { i++;
                items = items+"<option  value='" + val.id_subtipo + "'>" + val.nom_subtipo + "</option>";   
              });
              $(id_subtipo).find("option").remove();
              $(id_subtipo).append(items);
              $(".chosen-select1").val('').trigger("chosen:updated");
              $(".chosen-select2").val('').trigger("chosen:updated");
              $('.chosen-select1').chosen();
            });
          }
        });
      }

      function set_planilla(id_tipo, id_subtipo, s_artes, with_item) {
        $(id_subtipo).change(function(){
          var iddep = $(id_tipo).val();
          var idpla = $(id_subtipo).val();

          if (Number.isInteger(Math.floor(iddep))) {
            var id_url = base_url+"/Administrador/sub_tipo/"+iddep + "/" + idpla; 
            var items = "";
            i=0;
            $.getJSON(id_url, function(data) {
              console.log(data);
              $(s_artes).find("option").remove();
              $(s_artes).val(data[0].tipo_subtipo_arte);
              $("#s_redes").val(data[0].tipo_subtipo_redes);
              $(s_artes).find("option").remove();
              $(s_artes).append(items);
              $(".chosen-select2").val('').trigger("chosen:updated");
              $('.chosen-select2').chosen();
            });
          }
          dist = $(s_artes).val();
        });
      }
      set_tipo("#id_tipo", "#id_subtipo", true);
      set_planilla("#id_tipo", "#id_subtipo", "#s_artes", true);
    });
</script>

