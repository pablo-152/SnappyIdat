
    <div class="modal-content">

        <form class="form-horizontal" id="from_proy" method="POST" enctype="multipart/form-data" action="<?= site_url('Administrador/insert_proyecto')?>" class="formulario">

           <div class="modal-header">
             <h3 class="tile-title">Nuevo proyecto</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" >
  
          <div class="col-md-12 row">
                <div class="form-group col-md-4">
                  <label class="control-label text-bold">Solicitado Por:</label>
                  <select  name="id_solicitante" id="id_solicitante"  Class="form-control">
                      <option value="0">Seleccione</option>
                       <?php foreach($solicitado as $row_p){ ?>
                       <option value="<?php echo $row_p['id_usuario']; ?>"><?php echo $row_p['usuario_codigo'];?></option>
                      <?php } ?>
                  </select>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label text-bold">Fecha:</label>
                  <div>
                    <?php echo date('d/m/Y');?>
                  </div>
                </div>

                <div class=" form-group col-md-12">
                            <label class="control-label text-bold" >Empresa:&nbsp;&nbsp;&nbsp;</label>
                                <label>
                                    <input type="checkbox" id="GL0" name="GL0" value="1" class="minimal">
                                    <span style="font-weight:normal">GL0</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="GL1" name="GL1" value="1" class="minimal"/>
                                    <span style="font-weight:normal">GL1</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="GL2" name="GL2" value="1" class="minimal"/>
                                    <span style="font-weight:normal">GL2</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="BL1" name="BL1" value="1" class="minimal"/>
                                    <span style="font-weight:normal">BL1</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="LL1" name="LL1" value="1" class="minimal"/>
                                    <span style="font-weight:normal">LL1</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="LL2" name="LL2" value="1" class="minimal"/>
                                    <span style="font-weight:normal">LL2</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="LS1" name="LS1" value="1" class="minimal"/>
                                    <span style="font-weight:normal">LS1</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="LS2" name="LS2" value="1" class="minimal"/>
                                    <span style="font-weight:normal">LS2</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="EP1" name="EP1" value="1" class="minimal"/>
                                    <span style="font-weight:normal">EP1</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="EP2" name="EP2" value="1" class="minimal"/>
                                    <span style="font-weight:normal">EP2</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="FV1" name="FV1" value="1" class="minimal"/>
                                    <span style="font-weight:normal">FV1</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="FV2" name="FV2" value="1" class="minimal"/>
                                    <span style="font-weight:normal">FV2</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="LA0" name="LA0" value="1" class="minimal"/>
                                    <span style="font-weight:normal">LA0</span>&nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="checkbox" id="VJ1" name="VJ1" value="1" class="minimal"/>
                                    <span style="font-weight:normal">VJ1</span>&nbsp;&nbsp;
                                </label><!--
                                <label>
                                    <input type="checkbox" onClick="marcar(this);" id="MarcarTodos" class="minimal">
                                    Todas
                                </label>-->
                </div>

                 <div class="form-group col-md-3">
                  <label class="control-label text-bold">Tipo:</label>
                   <select  name="id_tipo" id="id_tipo"  Class="form-control">
                      <option value="0">Seleccione</option>
                       <?php foreach($row_t as $row_t){ ?>
                       <option value="<?php echo $row_t['id_tipo']; ?>"><?php echo $row_t['nom_tipo'];?></option>
                      <?php } ?>
                  </select>
                </div>

                 <div class="form-group col-md-3">
                  <label class="control-label text-bold">Sub-Tipo:</label>
                  <select  name="id_subtipo" id="id_subtipo"  Class="form-control">
                  </select>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label text-bold">Week Snappy Artes:</label>
                 <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes">
                 <!--<select  name="s_artes" id="s_artes"  Class="form-control">
                  </select>-->
                </div>

                 <div class="form-group col-md-3">
                  <label class="control-label text-bold">Week Snappy Redes:</label><!-- tipo_subtipo_arte-->
                  <input name="s_redes" type="number" class="form-control" id="s_redes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Redes">
                </div>
                 <div class="form-group col-md-3">
                  <label class="control-label text-bold">Prioridad:</label>
                  <select class="form-control" name="prioridad" id="prioridad">
                      <option value="0">Seleccione</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label text-bold">Descripción:</label>
                  <input name="descripcion" type="text" maxlength="50" class="form-control" id="descripcion" placeholder="Ingresar descripción">
                </div>

                 <div class="form-group col-md-3">
                  <label class="control-label text-bold">Agenda / Redes:</label>
                   <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" />
                </div>

                 <div class="form-group col-md-12">
                        <div class="col-xs-12">
                            <label class="control-label text-bold">Observaciones:</label>
                            <textarea name="proy_obs" rows="8" class="form-control" id="proy_obs"></textarea>
                            <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
                        </div>
                    </div>
                  </div>

                <div class="modal-footer">
                    <button type="button" id="btninsertProyecto" class="btn btn-success">Guardar</button>&nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>



              </div>
              </form>
            </div>

    
<script type="text/javascript" src="<?= base_url() ?>template/docs/js/plugins/select2.min.js"></script>
<script>

$(".chosen-select").chosen({rtl: true});

// $('.chosen-select').chosen();
$(".chosen-select1").chosen({rtl: true});
$(".chosen-select2").chosen({rtl: true});
$(".chosen-select3").chosen({rtl: true});
/*function Cancelar(){
     var url = "<?php echo site_url(); ?>Administrador/proyectos/";
      frm = { };
      $.ajax({
         url: url, 
          type: 'POST',
          data: frm,
      }).done(function(contextResponse, statusResponse, response) {
        // $("#nuevo_proyect").html(contextResponse);
          window.location.href=url;
      })

}*/

$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
});

  $("#btninsertProyecto").on('click', function(e){
        if (nuevo()) {
            bootbox.confirm({
                title: "Registrar Proyectos",
                message: "¿Desea guardar el Proyectos?",
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
         
    } else {
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

  function nuevo() {

    GL0=document.getElementById("GL0").checked;
    GL1=document.getElementById("GL1").checked;
    GL2=document.getElementById("GL2").checked;
    BL1=document.getElementById("BL1").checked;
    LL1=document.getElementById("LL1").checked;
    LL2=document.getElementById("LL2").checked;
    LS1=document.getElementById("LS1").checked;
    LS2=document.getElementById("LS2").checked;
    EP1=document.getElementById("EP1").checked;
    EP2=document.getElementById("EP2").checked;
    FV1=document.getElementById("FV1").checked;
    FV2=document.getElementById("FV2").checked;
    LA0=document.getElementById("LA0").checked;
    VJ1=document.getElementById("VJ1").checked;

     if($('#id_solicitante').val()=="0") { 
          msgDate = 'Dato Obligatorio.';
          inputFocus = '#id_solicitante';
          return false;
       }

       if($('#id_tipo').val()=="0") { 
          msgDate = 'Dato Obligatorio.';
          inputFocus = '#id_tipo';
          return false;
       }
       if($('#id_subtipo').val()=="0") { 
          msgDate = 'Dato Obligatorio.';
          inputFocus = '#id_subtipo';
          return false;
       }
       if($('#prioridad').val()=="0") { 
          msgDate = 'Dato Obligatorio.';
          inputFocus = '#prioridad';
          return false;
       }

    if (GL0==false && GL1==false && GL2==false && BL1==false && LL1==false && LL2==false && LS1==false
    && LS2==false && EP1==false && EP2==false && FV1==false && FV2==false && LA0==false && VJ1==false)
  {
    msgDate='Debe seleccionar una empresa para poder crear el proyecto.';
    inputFocus = '#GL0';
    //alert("Debe seleccionar una empresa para poder crear el proyecto.")
    //document.getElementById("GL0").focus();
    return false;
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
                            /* if (with_item) {
                                items = "<input type='text' value=8>";
                            }*/
                          /* $.each( data, function(key, val) {
                            i++;
                            items = items+"<input  value='" + val.tipo_subtipo_arte + "'>" ;
                            $(s_artes).val(val.tipo_subtipo_arte);
                          }); */
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



   




