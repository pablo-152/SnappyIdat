<form id="from_proye" method="POST" enctype="multipart/form-data" class="formulario">
  <?php if(isset($get_id)){ ?>
        <input type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $get_id[0]['id_proyecto'] ?>">
  <?php } ?>

  <div class="modal-header">
      <h3 class="tile-title">Edición de Datos del Proyecto con <b>Código <?php echo $get_id[0]['cod_proyecto'];?></b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>

  <div class="modal-body" style="max-height:450px; overflow:auto;">
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
        <label class="control-label text-bold">Tipo:</label>
        <select  name="id_tipo" id="id_tipo" class="form-control" style="width: 100%;" onchange="Tipo()">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_tipo']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
            <?php foreach($row_t as $nivel){ ?>
                <option value="<?php echo $nivel['id_tipo']; ?>" <?php if (!(strcmp($nivel['id_tipo'], $get_id[0]['id_tipo']))){ echo "selected=\"selected\"";} ?>><?php echo $nivel['nom_tipo']; ?></option>
            <?php } ?>
        </select>
      </div>

      <div class=" form-group col-md-12" id="mempresa">
          <label class="control-label text-bold" >Empresas:&nbsp;&nbsp;&nbsp;</label>
          <?php foreach($list_empresa as $list){ ?>
              <label >
                  <input type="checkbox" id="id_empresa" name="id_empresa[]" value="<?php echo $list['id_empresa']; ?>" <?php foreach($get_empresa as $empresa){ if($empresa['id_empresa']==$list['id_empresa']){ echo "checked"; } } ?> class="check_empresa" onchange="Empresa(this)"><!-- onchange="Empresa(this)-->
                  <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
              </label>
          <?php } ?>
      </div>

      
      <div id="div_sedes" class="form-group col-md-12" style="display:none">
        <?php if($cantidad_empresa!=0){ ?>
          <label class="control-label text-bold" >Sedes:&nbsp;&nbsp;&nbsp;</label>
          <?php foreach($list_sede as $list){ 
            //if($list['id_empresa']==$get_id[0]['id_empresa']){ ?>
              <label>
                  <input type="checkbox" id="id_sede[]" name="id_sede[]" value="<?php echo $list['id_sede']; ?>" <?php foreach($get_sede as $sede){ if($sede['id_sede']==$list['id_sede']){ echo "checked"; } } ?> class="check_sede">
                  <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
              </label>
              <?php ///} ?>
          <?php } ?>
        <?php } ?>
      </div>

      <div class="form-group col-md-3" id="cmb_subtipo">
        <label class="control-label text-bold">Sub-Tipo:</label>
        <select  name="id_subtipo" id="id_subtipo" class="form-control" onchange="Cambio_Week()">
          <option  value=""  selected>Seleccione</option>
          <?php foreach($sub_tipo as $sub){
          if($get_id[0]['id_subtipo'] == $sub['id_subtipo']){ ?> 
          <option selected value="<?php echo $sub['id_subtipo']; ?>"><?php echo $sub['nom_subtipo'];?></option>
          <?php }else{?>
            <option value="<?php echo $sub['id_subtipo']; ?>"><?php echo $sub['nom_subtipo'];?></option>
          <?php } } ?>
        </select>
      </div>

      <div class="form-group col-md-3" id="msaters">
        <label class="control-label text-bold">Week Snappy Artes:</label>
        <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes" 
        value="<?php echo $get_id[0]['s_artes']; ?>" />
      </div>

      <div class="form-group col-md-3" id="msredes">
        <label class="control-label text-bold">Week Snappy Redes:</label>
        <input name="s_redes" type="number" class="form-control" id="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Redes"
        value="<?php echo $get_id[0]['s_redes']; ?>" />
      </div>

      <!--<div class="form-group col-md-3">
        <label class="control-label text-bold">Week Snappy Artes:</label>
        <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes" 
        value="<?php echo $get_id[0]['s_artes']; ?>" />
      </div>
      <div class="form-group col-md-3">
        <label class="control-label text-bold">Week Snappy Redes:</label>
        <input name="s_redes" type="number" class="form-control" id="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Redes"
        value="<?php echo $get_id[0]['s_redes']; ?>" />
      </div>
      <div class=" form-group col-md-12">
          <label class="control-label text-bold" >Empresas:&nbsp;&nbsp;&nbsp;</label>
          <?php foreach($list_empresa as $list){ ?>
              <label>
                  <input type="checkbox" id="id_empresa[]" name="id_empresa[]" value="<?php echo $list['id_empresa']; ?>" <?php foreach($get_empresa as $empresa){ if($empresa['id_empresa']==$list['id_empresa']){ echo "checked"; } } ?> class="check_empresa" onchange="Tipo()">
                  <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
              </label>
          <?php } ?>
      </div>
      <div id="div_sedes" class="form-group col-md-12">
        <?php if($cantidad_empresa!=0){ ?>
          <label class="control-label text-bold" >Sedes:&nbsp;&nbsp;&nbsp;</label>
          <?php foreach($list_sede as $list){ 
            //if($list['id_empresa']==$get_id[0]['id_empresa']){ ?>
              <label>
                  <input type="checkbox" id="id_sede[]" name="id_sede[]" value="<?php echo $list['id_sede']; ?>" <?php foreach($get_sede as $sede){ if($sede['id_sede']==$list['id_sede']){ echo "checked"; } } ?> class="check_sede">
                  <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
              </label>
              <?php  ?>
          <?php } ?>
        <?php } ?>
      </div>
      <div class="form-group col-md-3">
        <label class="control-label text-bold">Tipo:</label>
        <select  name="id_tipo" id="id_tipo" class="form-control" style="width: 100%;" onchange="Tipo()">
            <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_tipo']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
            <?php foreach($row_t as $nivel){ ?>
                <option value="<?php echo $nivel['id_tipo']; ?>" <?php if (!(strcmp($nivel['id_tipo'], $get_id[0]['id_tipo']))){ echo "selected=\"selected\"";} ?>><?php echo $nivel['nom_tipo']; ?></option>
            <?php } ?>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label class="control-label text-bold">Sub-Tipo:</label>
        <select  name="id_subtipo" id="id_subtipo" class="form-control">
          <option  value=""  selected>Seleccione</option>
          <?php foreach($sub_tipo as $sub){
          if($get_id[0]['id_subtipo'] == $sub['id_subtipo']){ ?> 
          <option selected value="<?php echo $sub['id_subtipo']; ?>"><?php echo $sub['nom_subtipo'];?></option>
          <?php } } ?>
        </select>
      </div>-->
      <input type="hidden" id="pagina" name="pagina" value="<?php echo $pagina ?>">
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

      <div class="form-group col-md-10">
        <label class="control-label text-bold">Descripción:</label>
        <input name="descripcion" type="text" maxlength="100" class="form-control" id="descripcion" value="<?php echo $get_id[0]['descripcion'] ?>">
      </div>
      
      <?php if($get_id[0]['id_tipo']==15 || $get_id[0]['id_tipo']==20 || $get_id[0]['id_tipo']==34){?>
        <div class="form-group col-md-2">
          <button class="btn " style="background-color:green;color:white" type="button" title="Duplicar" data-toggle="modal" data-target="#acceso_modal_eli" app_crear_eli="<?= site_url('Administrador/Modal_Duplicar') ?>/<?php echo $get_id[0]['id_proyecto'] ?>/<?php echo $get_id[0]['id_tipo'] ?>">Duplicar</button>
        </div>
      <?php }?>

      <div class="form-group col-md-12" id="div_duplicados">
          <?php if(count($list_duplicado)>0){?>
          <table id="example" class="table table-striped table-bordered" width="100%">
            <thead>
              <tr align="center" style="background-color: #E5E5E5;">
                <th align="center">Inicio</th>
                <th align="center">Snappy Redes</th>
                <th align="center">&nbsp;</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach($list_duplicado as $list) {  ?>
                <tr class="even pointer">
                  <td  align="center" ><?php echo $list['fecha_inicio']; ?></td>
                  <td  align="center" ><?php echo $list['snappy_redes']; ?></td>
                  <td  align="center" >
                  <img title="Eliminar" onclick="Delete_Duplicado('<?php echo $list['inicio']; ?>','<?php echo $list['snappy_redes']; ?>','<?php echo $list['cod_proyecto']; ?>','<?php echo $get_id[0]['id_proyecto'] ?>')" src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <?php }?>
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

          <div class="col-md-2" id="pendiente" <?php if($get_id[0]['status']==4){ ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php } ?>>
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
    <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $get_id[0]['id_proyecto'] ?>">
    <button type="button" class="btn btn-success" onclick="Update_Proyecto()">Guardar</button>&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
  </div>
</form>

<script type="text/javascript" src="<?= base_url() ?>template/docs/js/plugins/select2.min.js"></script>

<script>
  $(document).ready(function() {
    var id_tipo = $("#id_tipo").val();
    var div3 = document.getElementById("div_sedes");
    if(id_tipo==15 || id_tipo==20 || id_tipo==34){
      div3.style.display = "none";
    }else{
      div3.style.display = "block";
    }
  });

  function Cambio_Week(){
    var url = "<?php echo site_url(); ?>Administrador/Cambio_Week_Arte";
    var dataString = $("#from_proye").serialize();

    $.ajax({
      url: url,
      type: 'POST',
      //data: {'id_empresa':id_empresa},
      data:dataString,
      success:function (data) {
        $('#msaters').html(data);
      }
    });

    var url2 = "<?php echo site_url(); ?>Administrador/Cambio_Week_Red";
    var dataString2 = $("#from_proye").serialize();

    $.ajax({
      url: url2,
      type: 'POST',
      //data: {'id_empresa':id_empresa},
      data:dataString2,
      success:function (data) {
        $('#msredes').html(data);
      }
    });
  }

  function Empresa(){
    var url = "<?php echo site_url(); ?>Administrador/Empresa_Sede";
    var dataString = $("#from_proye").serialize();
    var id_tipo = $("#id_tipo").val();
    
    if(id_tipo==15 || id_tipo==20 || id_tipo==34){
      $("input[id=id_empresa]").change(function(){
          var elemento=this;
          var contador=0;
          var maxp=1;
          $("input[id=id_empresa]").each(function(){
              if($(this).is(":checked"))
                  contador++;
          });

          

          if(contador>maxp)
          {
              alert("Con tipo Facebook o Web solo debes seleccionar una empresa");

              $(elemento).prop('checked', false);
              contador--;
          }

          $("#seleccionados").html(contador);
        });

        contador_empresa=0;
        $(".check_empresa").each(function(){
          if($(this).is(":checked"))
          contador_empresa++;
        }); 

        if(contador_empresa==0){
          
        }else{
          var url2 = "<?php echo site_url(); ?>Administrador/subtipo";
          var dataString2 = $("#from_proye").serialize();

            $.ajax({
              url: url2,
              type: 'POST',
              data: dataString2,
              success:function (data) {
                $('#cmb_subtipo').html(data);
              }
            });
        }
    }else{

          contador_empresa=0;
          $(".check_empresa").each(function(){
            if($(this).is(":checked"))
            contador_empresa++;
          }); 

          if(contador_empresa==0){
            /*var url4 = "<?php echo site_url(); ?>Administrador/subtipo_vacio";
            var dataString4 = $("#from_proye").serialize();

              $.ajax({
                url: url4,
                type: 'POST',
                data: dataString4,
                success:function (data) {
                  $('#cmb_subtipo').html(data);
                }
              });*/
          }else{

            var url = "<?php echo site_url(); ?>Administrador/Empresa_Sede";
              var dataString = $("#from_proye").serialize();

              $.ajax({
                url: url,
                type: 'POST',
                //data: {'id_empresa':id_empresa},
                data:dataString,
                success:function (data) {
                  $('#div_sedes').html(data);
                }
              });

              var url2 = "<?php echo site_url(); ?>Administrador/subtipo";
          var dataString2 = $("#from_proye").serialize();

          $.ajax({
            url: url2,
            type: 'POST',
            data: dataString2,
            success:function (data) {
              $('#cmb_subtipo').html(data);
            }
          });

          /*var url2 = "<?php echo site_url(); ?>Administrador/subtipo";
          var dataString2 = $("#from_proye").serialize();

          $.ajax({
            url: url2,
            type: 'POST',
            data: dataString2,
            success:function (data) {
              $('#cmb_subtipo').html(data);
            }
          });*/
          }


        }
    
  }

  function Tipo(){
    var url = "<?php echo site_url(); ?>Administrador/Desaparecer_Sede";
    var id_tipo = $("#id_tipo").val();
    
    

    var url5 = "<?php echo site_url(); ?>Administrador/Refresca_Empresa";
      var dataString5 = $("#from_proye").serialize();

      $.ajax({
        url: url5,
        type: 'POST',
        //data: {'id_empresa':id_empresa},
        data:dataString5,
        success:function (data) {
          $('#mempresa').html(data);
        }
      });

    if(id_tipo==15 || id_tipo==20 || id_tipo==34){
      $.ajax({
        url: url,
        type: 'POST',
        data: {'id_tipo':id_tipo},
        //data:dataString,
        success:function (data) {
          $('#div_sedes').html(data);
        }
      });

      var url3 = "<?php echo site_url(); ?>Administrador/Refresca_Empresa";
      var dataString3 = $("#from_proye").serialize();

      $.ajax({
        url: url3,
        type: 'POST',
        //data: {'id_empresa':id_empresa},
        data:dataString3,
        success:function (data) {
          $('#mempresa').html(data);
        }
      });

      var url4 = "<?php echo site_url(); ?>Administrador/subtipo_xtipo";
            var dataString4 = $("#from_proye").serialize();

              $.ajax({
                url: url4,
                type: 'POST',
                data: dataString4,
                success:function (data) {
                  $('#cmb_subtipo').html(data);
                }
              });
      
      
      
      
    }else{

      var url3 = "<?php echo site_url(); ?>Administrador/Refresca_Empresa";
      var dataString3 = $("#from_proye").serialize();

      $.ajax({
        url: url3,
        type: 'POST',
        //data: {'id_empresa':id_empresa},
        data:dataString3,
        success:function (data) {
          $('#mempresa').html(data);
        }
      });

      var url = "<?php echo site_url(); ?>Administrador/Empresa_Sede";
      var dataString = $("#from_proye").serialize();
      var div3 = document.getElementById("div_sedes");
      $.ajax({
        url: url,
        type: 'POST',
        //data: {'id_empresa':id_empresa},
        data:dataString,
        success:function (data) {
          div3.style.display = "block";
          $('#div_sedes').html(data);
        }
      });

      var url2 = "<?php echo site_url(); ?>Administrador/subtipo_xtipo";
      var dataString2 = $("#from_proye").serialize();

        $.ajax({
          url: url2,
          type: 'POST',
          data: dataString2,
          success:function (data) {
            $('#cmb_subtipo').html(data);
          }
        });
          

      //Subtipo_Vacio();
    }

  }

  function Subtipo_Vacio(){
    /*contador_empresa=0;

    $(".check_empresa").each(function(){
        if($(this).is(":checked"))
        contador_empresa++;
      });*/ 
      
    //if(contador_empresa==0){
      var url4 = "<?php echo site_url(); ?>Administrador/subtipo_vacio";
      var dataString4 = $("#from_proye").serialize();

        $.ajax({
          url: url4,
          type: 'POST',
          data: dataString4,
          success:function (data) {
            $('#cmb_subtipo').html(data);
          }
        });
    //}
    var id_tipo = $("#id_tipo").val();
    if(id_tipo!=15 && id_tipo!=20 && id_tipo!=34){
      //alert("aquii");
      var url2 = "<?php echo site_url(); ?>Administrador/subtipo_xtipo";
      var dataString2 = $("#from_proye").serialize();

        $.ajax({
          url: url2,
          type: 'POST',
          data: dataString2,
          success:function (data) {
            $('#cmb_subtipo').html(data);
          }
        });
    }
  }

  function Agregar_Duplicado(){
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

      var dataString = new FormData(document.getElementById('formulario_dupli'));
      var url="<?php echo site_url(); ?>Teamleader/Agregar_Duplicado";

      if (Valida_Duplicado()) {
          $.ajax({
              url: url,
              data:dataString,
              type:"POST",
              processData: false,
              contentType: false,
              success:function (data) {
                  swal.fire(
                      'Registro Exitoso!',
                      'Haga clic en el botón!',
                      'success'
                  ).then(function() {
                        var dataString1 = new FormData(document.getElementById('formulario_dupli'));
                        var url1="<?php echo site_url(); ?>Teamleader/List_Duplicados";

                        $.ajax({    
                            type:"POST",
                            data:dataString1,
                            url:url1,
                            processData: false,
                            contentType: false,

                            success:function (resp) {
                                $('#div_duplicados').html(resp);
                                $("#acceso_modal_eli .close").click()

                            }
                        });
                  });
              }
          });
      }
  }

  function Valida_Duplicado(){
    
      if($('#s_redesd').val().trim()===""){
        Swal(
            'Ups!',
            'Debe ingresar Week Snappy Redes.',
            'warning'
        ).then(function() { });
        return false;
      }
      if($('#fec_agendad').val().trim()===""){
        Swal(
            'Ups!',
            'Debe ingresar Fecha Agenda.',
            'warning'
        ).then(function() { });
        return false;
      }
    
    return true;
  }

  function Delete_Duplicado(inicio,s_redes,cod_p,id){
        
        var fec_inicio = inicio;
        var snappy_redes = s_redes;
        var cod_proyecto = cod_p;
        var id_proyecto = id;
        var url="<?php echo site_url(); ?>Teamleader/Delete_Duplicado";
        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
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
                    url:url,
                    data: {'fec_inicio':fec_inicio,'snappy_redes':snappy_redes,'cod_proyecto':cod_proyecto},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                          
                          var url1="<?php echo site_url(); ?>Teamleader/List_Duplicados";

                          $.ajax({    
                              type:"POST",
                              data:{'id_proyecto':id_proyecto},
                              url:url1,

                              success:function (resp) {
                                  $('#div_duplicados').html(resp);
                                  $("#acceso_modal_eli .close").click()

                              }
                          });
                        });
                    }
                });
            }
        })
  }
</script>

<script>
  $(".chosen-select").chosen({rtl: true}); 
  $(".chosen-select1").chosen({rtl: true});
  $(".chosen-select2").chosen({rtl: true});
  $(".chosen-select3").chosen({rtl: true});

  $(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
  });

  function muestradiv(){
    var status=document.getElementById("status").value;
    var pendiente = document.getElementById("pendiente");

    if(status==4){
      pendiente.style.display = "block";
    }else {
      pendiente.style.display = "none";
    }
  }

  function Update_Proyecto(){
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

      var dataString = new FormData(document.getElementById('from_proye'));
      var url="<?php echo site_url(); ?>Teamleader/Update_Proyecto";

      if (proyecto()) {
          $.ajax({
              url: url,
              data:dataString,
              type:"POST",
              processData: false,
              contentType: false,
              success:function (data) {
                  swal.fire(
                      'Actualización Exitosa!',
                      'Haga clic en el botón!',
                      'success'
                  ).then(function() {
                    if($('#pagina').val()==1){
                      window.location = "<?php echo site_url(); ?>Teamleader/Busqueda";
                    }else{
                      window.location = "<?php echo site_url(); ?>Teamleader/proyectos";
                    }
                      
                  });
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
  }

  function proyecto() {
    var contador_empresa=0;
    id_solicitante=document.getElementById("id_solicitante").value;
    id_tipo=document.getElementById("id_tipo").value;
    id_subtipo=document.getElementById("id_subtipo").value;

    status=document.getElementById("status").value;
    id_userpr=document.getElementById("id_userpr").value;

    if(id_solicitante=="0") {
      msgDate = 'Debe seleccionar solicitante.';
      inputFocus = '#id_solicitante';
      return false;
    }
    
    $(".check_empresa").each(function(){
      if($(this).is(":checked"))
      contador_empresa++;
    }); 

    if(contador_empresa==0){
      msgDate = 'Debe seleccionar una empresa para poder crear el proyecto.';
      inputFocus = '#etiqueta_empresa';
      return false;
    }
  
    if (id_tipo=="0") {
      msgDate = 'Debe seleccionar tipo.';
      inputFocus = '#id_tipo';
      return false;
    }
    
    if (id_subtipo=="0") {
     msgDate = 'Debe seleccionar subtipo.';
      inputFocus = '#id_subtipo';
      return false;
    }

    if($('#prioridad').val()== "0") {
      msgDate = 'Debe seleccionar prioridad.';
      inputFocus = '#prioridad';
      return false;
    }

    if($('#descripcion').val()=="") { 
      msgDate = 'Debe ingresar descripcion.';
      inputFocus = '#descripcion';
      return false;
    }

    if(id_tipo==15 || id_tipo==20 || id_tipo==34) { 
      if($('#fec_agenda').val()=="") { 
        msgDate = 'Debe ingresar Agenda/Redes.';
        inputFocus = '#fec_agenda';
        return false;
      }
    }

    if($('#id_tipo').val()==15 || $('#id_tipo').val()==20 || $('#id_tipo').val()==34){
      if(contador_empresa!=1) { 
        Swal(
            'Ups!',
            'Solo debe seleccionar una empresa.',
            'warning'
        ).then(function() { });
        return false;
      }
    }

    if(status==4){
      if(id_userpr=="0"){
        msgDate = 'Debe seleccionar colaborador.';
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
    return true;
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
              //  console.log(id_url);
                      i=0;
                  $.getJSON(id_url, function(data) {
                    $(id_subtipo).find("option").remove();
                    if (with_item == true) {
                        items="<option value='' disabled selected>Seleccione</option>";
                              //$(dist_select).append("<option value=''>Seleccione</option>");
                          }
                  //console.log(data);
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
          }//// ok 1

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
                  //alert(idanio);
              });
          }
          set_tipo("#id_tipo", "#id_subtipo", true);
        set_planilla("#id_tipo", "#id_subtipo", "#s_artes", true);
  });
</script>

