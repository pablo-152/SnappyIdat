<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
    <!-- Navbar-->
   <?php $this->load->view('Admin/header'); ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php $this->load->view('Admin/nav'); ?>
      <main class="app-content">
      <div class="row">
        <div class="col-md-12" class="collapse" id="collapseExample">
          <div class="tile">
            <h3 class="tile-title line-head">Edición de Datos del Proyecto con <b>Código <?php echo $get_id[0]['cod_proyecto'];?></b></h3>
        <div class="tile-body" >
        <form class="form-horizontal" id="from_proy" method="POST" enctype="multipart/form-data" action="<?= site_url('Administrador/insert_proyecto')?>" class="formulario">
          <?php if(isset($get_id)){ ?>
               <input  type="hidden" name="id_proyecto" id="id_proyecto" value="<?php echo $get_id[0]['id_proyecto'] ?>">
          <?php } ?> 

              <div class="row">
                <div class="form-group col-md-4">
                  <label class="control-label text-bold">Solicitado Por:</label>
                  <select  name="id_solicitante" id="id_solicitante"  Class="form-control">
                      <option  value="" selected disabled>Seleccione</option>
                     <?php foreach($solicitado as $row_p){
                        if($get_id[0]['id_solicitante'] == $row_p['id_usuario']){ ?>
                         <option selected value="<?php echo $row_p['id_usuario']; ?>"><?php echo $row_p['usuario_codigo'];?></option>  <?php }else{?>
                       <option value="<?php echo $row_p['id_usuario']; ?>"><?php echo $row_p['usuario_codigo'];?></option>
                       <?php } } ?>
                  </select>
                </div>

                <div class="form-group col-md-3">
                  <label class="control-label text-bold">Fecha:</label>
                   <input class="form-control date" id="fec_solicitante" name="fec_solicitante" type="date" value="<?php echo $get_id[0]['fec_solicitante'] ?>"/>  
                </div>

                <div class="form-group col-md-12">
                         <div class="col-xs-12">
                            <label class="control-label text-bold" >Empresa:&nbsp;&nbsp;&nbsp;</label>
                            <label>
                                <input type="checkbox" id="GL0" name="GL0" value="1" <?php if($get_id[0]['GL0']==1){ echo "checked";} ?> class="minimal">
                                <span style="font-weight:normal">GL0</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="GL1" name="GL1" value="1" <?php if($get_id[0]['GL1']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">GL1</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="GL2" name="GL2" value="1" <?php if($get_id[0]['GL2']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">GL2</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="BL1" name="BL1" value="1" <?php if($get_id[0]['BL1']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">BL1</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="LL1" name="LL1" value="1" <?php if($get_id[0]['LL1']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">LL1</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="LL2" name="LL2" value="1" <?php if($get_id[0]['LL2']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">LL2</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="LS1" name="LS1" value="1" <?php if($get_id[0]['LS1']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">LS1</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="LS2" name="LS2" value="1" <?php if($get_id[0]['LS2']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">LS2</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="EP1" name="EP1" value="1" <?php if($get_id[0]['EP1']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">EP1</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="EP2" name="EP2" value="1" <?php if($get_id[0]['EP2']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">EP2</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="FV1" name="FV1" value="1" <?php if($get_id[0]['FV1']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">FV1</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="FV2" name="FV2" value="1" <?php if($get_id[0]['FV2']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">FV2</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="LA0" name="LA0" value="1" <?php if($get_id[0]['LA0']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">LA0</span>&nbsp;&nbsp;&nbsp;
                            </label>
                            <label>
                                <input type="checkbox" id="VJ1" name="VJ1" value="1" <?php if($get_id[0]['VJ1']==1){ echo "checked";} ?> class="minimal"/>
                                <span style="font-weight:normal">VJ1</span>&nbsp;&nbsp;&nbsp;
                            </label><!--
                            <label>
                                <input type="checkbox" onClick="marcar(this);" id="MarcarTodos" class="minimal">
                                Todas
                            </label>-->
                        </div>
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
                  <label class="control-label text-bold">Week Snappy Artes:</label>
                 <input name="s_artes" type="number" class="form-control" id="s_artes" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes">
                 <!--<select  name="s_artes" id="s_artes"  Class="form-control">
                  </select>-->
                </div>

                 <div class="form-group col-md-3">
                  <label class="control-label text-bold">Week Snappy Redes:</label>
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
                  <input name="descripcion" type="text" maxlength="30" class="form-control" id="descripcion" value="<?php echo $get_id[0]['descripcion'] ?> ">
                </div>

                 <div class="form-group col-md-3">
                  <label class="control-label text-bold">Agenda / Redes:</label>
                   <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" />
                </div>
                 <div class="form-group col-md-12">
                        <div class="col-xs-12">
                            <label class="control-label text-bold">Observaciones:</label>
                            <textarea name="proy_obs" rows="10" class="form-control" id="proy_obs" > <?php echo $get_id[0]['proy_obs']?> </textarea>
                            <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
                        </div>
                    </div>

                <div class="box-footer">
                    <button type="button" id="btninsertProyecto" class="btn btn-success">Guardar</button>&nbsp;&nbsp;
                    <button onClick="Cancelar()" type="button" class="btn btn-danger">Cancelar</button>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    
    </main>

    <div id="acceso_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="acceso_modal_mod" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="acceso_modal_eli" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>
    <?php $this->load->view('Admin/footer'); ?>


<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>


<script>
/*$(document).ready(function() {

    var msgDate = '';
    var inputFocus = '';
    var date_input=$('#fec_solicitante');
     var date_input=$('#fec_agenda');


    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        leftArrow: '<i class="fa fa-long-arrow-left"></i>',
        rightArrow: '<i class="fa fa-long-arrow-right"></i>'

    });

});*/


$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
});

  $("#btninsertProyecto").on('click', function(e){
        if (nuevo()) {
            bootbox.confirm({
                title: "Registrar fondo Snappy",
                message: "¿Desea guardar el fondo?",
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
     if($('#descripcion').val().trim() === '') {
            msgDate = 'Ingrese descripcion.';
            inputFocus = '#descripcion';
            return false;
         }

   if($('#proy_obs').val().trim() === '') {
          msgDate = 'Ingrese observaciones.';
          inputFocus = '#proy_obs';
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
                      console.log(id_url);
                        i=0;
                        $.getJSON(id_url, function(data) {
                            $(s_artes).find("option").remove();
                           // items = items + "<option value='99'> SELECCIONE  </option>";
                            if (with_item) {
                                items = "<input type='text' value=8>";
                            }
                          $.each( data, function(key, val) { i++;
                           items = items+"<input  value='" + val.tipo_subtipo_arte + "'>" ;  
                            });
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



   




