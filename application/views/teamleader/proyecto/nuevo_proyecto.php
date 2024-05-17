<div class="modal-content">
  <form id="from_proy" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
      <h3 class="tile-title"><b>Nuevo proyecto2</b></h3>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
      <div class="col-md-12 row">
        <div class="form-group col-md-4">
          <label class="text-bold">Solicitado Por:</label>
          <div class="col">
            <select  name="id_solicitante" id="id_solicitante"  Class="form-control">
                <option value="0">Seleccione</option>
                  <?php foreach($solicitado as $row_p){ ?>
                  <option value="<?php echo $row_p['id_usuario']; ?>"><?php echo $row_p['usuario_codigo'];?></option>
                <?php } ?>
            </select>
          </div>
        </div>

        <div class="form-group col-md-4">
          <label class="text-bold">Fecha:</label>
          <div class="col">
            <?php echo date('d/m/Y');?>
          </div>
        </div>

        <div class="form-group col-md-4">
          <label class="text-bold">Tipo:</label>
          <div class="col">
            <select  name="id_tipo" id="id_tipo"  Class="form-control" onchange="Tipo()">
                <option value="0">Seleccione</option>
                  <?php foreach($row_t as $row_t){ ?>
                  <option value="<?php echo $row_t['id_tipo']; ?>"><?php echo $row_t['nom_tipo'];?></option>
                <?php } ?>
            </select>
          </div>
        </div>

        <div id="lblempresa" class="form-group col-md-8">
          <label id="etiqueta_empresa" class="text-bold" >Empresas:&nbsp;&nbsp;&nbsp;</label>
        </div>
        <div class="form-group col-md-8" id="mempresa"  style="display:none">
            <label id="etiqueta_empresa" class="text-bold" >Empresas:&nbsp;&nbsp;&nbsp;</label>
            
              <?php foreach($list_empresa as $list){ ?>
                  <label class="col">
                      <input type="checkbox" id="id_empresa" name="id_empresa[]" value="<?php echo $list['id_empresa']; ?>" class="check_empresa" onchange="Empresa(this)"> 
                      <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
                  </label>
              <?php } ?>
            
        </div>

        <div id="div_sedes" class="form-group col-md-4">
        </div>

        

        <div class="form-group col-md-4" id="cmb_subtipo">
          <label class="text-bold">Sub-Tipo:</label>
          <div class="col">
            <select  name="id_subtipo" id="id_subtipo" value="0" Class="form-control">
                <option value="0">Seleccione</option>
              </select>
          </div>
        </div>

        
          <div class="form-group col-md-4" id="msaters">
            <label class=" text-bold">Week Snappy Artes:</label>
            <div class="col">
              <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes">
            </div>
          </div>

          <div class="form-group col-md-4" id="msredes">
            <label class="text-bold">Week Snappy Redes:</label><!-- tipo_subtipo_arte-->
            <div class="col">
              <input name="s_redes" type="number" class="form-control" id="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Redes">
            </div>
          </div>
        

        

        

        <div class="form-group col-md-4">
          <label class="text-bold">Prioridad:</label>
          <div class="col">
            <select class="form-control" name="prioridad" id="prioridad">
                <option value="0">Seleccione</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
          </div>
        </div>

        <div class="form-group col-md-4">
          <label class="text-bold">Descripción:</label>
          <div class="col">
            <input name="descripcion" type="text" maxlength="50" class="form-control" id="descripcion" placeholder="Ingresar descripción">
          </div>
        </div>

        <div class="form-group col-md-4">
          <label class="control-label text-bold">Agenda / Redes:</label>
          <div class="col">
            <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" />
          </div>
        </div>

        <div class="form-group col-md-8">
          <label class="control-label text-bold">Observaciones:</label>
            <div class="col">
                <textarea name="proy_obs" rows="8" class="form-control" id="proy_obs"></textarea>
                <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
            </div>
        </div>
      </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Proyecto()"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
    </div>
  </form>
</div>
  
<script type="text/javascript" src="<?= base_url() ?>template/docs/js/plugins/select2.min.js"></script>

<script>
  /*$(document).ready(function() {
    $( "#id_empresa[]" ).prop( "disabled", true );
  });*/

  function Cambio_Week(){
    var url = "<?php echo site_url(); ?>Administrador/Cambio_Week_Arte";
    var dataString = $("#from_proy").serialize();

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
    var dataString2 = $("#from_proy").serialize();

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
    var dataString = $("#from_proy").serialize();
    var id_tipo = $("#id_tipo").val();
    
    if(id_tipo==0){
      
      Swal(
              'Ups!',
              'Debe seleccionar previamente Tipo.',
              'warning'
          ).then(function() { });

          var url3 = "<?php echo site_url(); ?>Administrador/Refresca_Empresa";
      var dataString3 = $("#from_proy").serialize();

      $.ajax({
        url: url3,
        type: 'POST',
        //data: {'id_empresa':id_empresa},
        data:dataString3,
        success:function (data) {
          $('#mempresa').html(data);
        }
      });
      
    }else{
      if(id_tipo==15 || id_tipo==34){

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

              var url3 = "<?php echo site_url(); ?>Administrador/Refresca_Empresa";
              var dataString3 = $("#from_proy").serialize();

              document.getElementById("s_artes").value = "";
              document.getElementById("s_redes").value = "";
              document.getElementById("id_tipo").value = "0";

              $.ajax({
                url: url3,
                type: 'POST',
                //data: {'id_empresa':id_empresa},
                data:dataString3,
                success:function (data) {
                  $('#mempresa').html(data);
                }
              });

              $(elemento).prop('checked', false);
              contador--;

              var url4 = "<?php echo site_url(); ?>Administrador/subtipo_vacio";
              var dataString4 = $("#from_proy").serialize();

                $.ajax({
                  url: url4,
                  type: 'POST',
                  data: dataString4,
                  success:function (data) {
                    $('#cmb_subtipo').html(data);
                  }
                });
          }

          $("#seleccionados").html(contador);

          
        });

        contador_empresa=0;
        $(".check_empresa").each(function(){
          if($(this).is(":checked"))
          contador_empresa++;
        }); 

        /*if(contador_empresa==0){
          var url4 = "<?php echo site_url(); ?>Administrador/subtipo_vacio";
          var dataString4 = $("#from_proy").serialize();

            $.ajax({
              url: url4,
              type: 'POST',
              data: dataString4,
              success:function (data) {
                $('#cmb_subtipo').html(data);
              }
            });
        }else{
          var url2 = "<?php echo site_url(); ?>Administrador/subtipo";
          var dataString2 = $("#from_proy").serialize();

            $.ajax({
              url: url2,
              type: 'POST',
              data: dataString2,
              success:function (data) {
                $('#cmb_subtipo').html(data);
              }
            });
        }*/

        

        

        

      }else{

        contador_empresa=0;
        $(".check_empresa").each(function(){
          if($(this).is(":checked"))
          contador_empresa++;
        }); 

        if(contador_empresa==0){
          
          /*var url4 = "<?php echo site_url(); ?>Administrador/subtipo_vacio";
          var dataString4 = $("#from_proy").serialize();

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
            var dataString = $("#from_proy").serialize();

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
        var dataString2 = $("#from_proy").serialize();

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
      Cambio_Week();
    }
    
      
    
  }

  function Tipo(){
    
    var id_tipo = $("#id_tipo").val();
    //alert(id_tipo);
    if(id_tipo==0){
      document.getElementById("mempresa").style.display = "none";
      document.getElementById("lblempresa").style.display = "block";
    }else{
      document.getElementById("lblempresa").style.display = "none";
      document.getElementById("mempresa").style.display = "block";
    }
    if(id_tipo==15 || id_tipo==34){
      
      var url = "<?php echo site_url(); ?>Administrador/Desaparecer_Sede";
      var dataString = $("#from_proy").serialize();
            $.ajax({
            url: url,
            type: 'POST',
            //data: {'id_empresa':id_empresa},
            data:dataString,
            success:function (data) {
              $('#div_sedes').html(data);
            }
          });

      var url3 = "<?php echo site_url(); ?>Administrador/Refresca_Empresa";
      var dataString3 = $("#from_proy").serialize();

      $.ajax({
        url: url3,
        type: 'POST',
        //data: {'id_empresa':id_empresa},
        data:dataString3,
        success:function (data) {
          $('#mempresa').html(data);
        }
      });

      $(".check_empresa").each(function(){
          if($(this).is(":checked"))
          contador_empresa++;
        }); 

        /*var url4 = "<?php echo site_url(); ?>Administrador/subtipo_vacio";
          var dataString4 = $("#from_proy").serialize();

            $.ajax({
              url: url4,
              type: 'POST',
              data: dataString4,
              success:function (data) {
                $('#cmb_subtipo').html(data);
              }
            });*/

            var url4 = "<?php echo site_url(); ?>Administrador/subtipo_xtipo";
            var dataString4 = $("#from_proy").serialize();

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
      var dataString3 = $("#from_proy").serialize();

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
      var dataString = $("#from_proy").serialize();

      $.ajax({
        url: url,
        type: 'POST',
        //data: {'id_empresa':id_empresa},
        data:dataString,
        success:function (data) {
          $('#div_sedes').html(data);
        }
      });

      var url2 = "<?php echo site_url(); ?>Administrador/subtipo_xtipo";
      var dataString2 = $("#from_proy").serialize();

        $.ajax({
          url: url2,
          type: 'POST',
          data: dataString2,
          success:function (data) {
            $('#cmb_subtipo').html(data);
          }
        });
    }
    Cambio_Week();
  }
</script>

<script>
  $(".chosen-select").chosen({rtl: true});
  $(".chosen-select1").chosen({rtl: true});
  $(".chosen-select2").chosen({rtl: true});
  $(".chosen-select3").chosen({rtl: true});

  

  function Insert_Proyecto(){
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

    var dataString = $("#from_proy").serialize();
    var url="<?php echo site_url(); ?>Administrador/insert_proyecto";

    if (nuevo()) {
        $.ajax({
          type:"POST",
          url: url,
          data:dataString,
          success:function (data) {
            swal.fire(
              'Tu proyecto se ha grabado correctamente con el código',
              data,
              'success'
            ).then(function() {
              //window.location = "<?php echo site_url(); ?>Administrador/proyectos";
              location.reload(true);
            });
          }
        });  
    }
  }

  function nuevo() {
    var contador_empresa=0;
    var contador_sede=0;

    if($('#id_solicitante').val()=="0") { 
        Swal(
            'Ups!',
            'Debe seleccionar Solicitante.',
            'warning'
        ).then(function() { });
        return false;
    }

    $(".check_empresa").each(function(){
      if($(this).is(":checked"))
      contador_empresa++;
    }); 

    if(contador_empresa==0){
      Swal(
          'Ups!',
          'Debe seleccionar Empresa.',
          'warning'
      ).then(function() { });
      return false;
    }

    if($('#cant_sedes').val()!=0){
      $(".check_sede").each(function(){
        if($(this).is(":checked"))
        contador_sede++;
      }); 

      if($('#id_tipo').val()!="15" && $('#id_tipo').val()!="34" ){
        if(contador_sede==0){
          Swal(
              'Ups!',
              'Debe seleccionar Sede.',
              'warning'
          ).then(function() { });
          return false;
        }
      }
    }

    if($('#id_tipo').val()=="0") { 
      Swal(
          'Ups!',
          'Debe seleccionar Tipo.',
          'warning'
      ).then(function() { });
      return false;
    }

    if($('#id_subtipo').val()=="0") { 
      Swal(
          'Ups!',
          'Debe seleccionar Subtipo.',
          'warning'
      ).then(function() { });
      return false;
    }

    if($('#prioridad').val()=="0") { 
      Swal(
          'Ups!',
          'Debe seleccionar Prioridad.',
          'warning'
      ).then(function() { });
      return false;
    }

    if($('#descripcion').val()=="") { 
      Swal(
          'Ups!',
          'Debe ingresar Descripción.',
          'warning'
      ).then(function() { });
      return false;
    }

    if($('#id_tipo').val()==15 || $('#id_tipo').val()==34) { 
      if($('#fec_agenda').val()=="") { 
        Swal(
            'Ups!',
            'Debe ingresar Agenda/Redes.',
            'warning'
        ).then(function() { });
        return false;
      }
    }

    if($('#id_tipo').val()==15 || $('#id_tipo').val()==34){
      if(contador_empresa!=1) { 
        Swal(
            'Ups!',
            'Solo debe seleccionar una empresa.',
            'warning'
        ).then(function() { });
        return false;
      }
    }

    

    return true;
  }
</script>

<script>
  function Sub_Tipo(){
    var url = "<?php echo site_url(); ?>Administrador/subtipo";
    var dataString = $("#from_proy").serialize();

      $.ajax({
        url: url,
        type: 'POST',
        data: dataString,
        success:function (data) {
          $('#cmb_subtipo').html(data);
        }
      });
  }

  /*var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function() {

         function set_tipo(id_tipo, id_subtipo, with_item) {
           $(id_tipo).change(function(){
             var iddep = $(id_tipo).val();
             var iddep = $(id_tipo).val();
              if (Number.isInteger(Math.floor(iddep))) {
                 var id_url = base_url+"/Administrador/subtipo/"+iddep;
                 var items = "";
               //  console.log(id_url);
                        i=0;
                   $.getJSON(id_url, function(data) {
                     $(id_subtipo).find("option").remove();
                     if (with_item == true) {
                         items="<option value='0'>Seleccione</option>";
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
                      console.log(id_url);
                        i=0;
                        $.getJSON(id_url, function(data) {
                          console.log(data);
                            $(s_artes).find("option").remove();
                           // items = items + "<option value='99'> SELECCIONE  </option>";
                            
                          
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
       });*/
 

</script>



   




