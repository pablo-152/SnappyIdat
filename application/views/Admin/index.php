<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
    <!-- Navbar-->
   <?php include "/../Admin/header.php"; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
      <?php include "/../Admin/nav.php"; ?>
      <main class="app-content">
      <div class="app-title">
      </div>
      
        <div class="row">
        <div class="col-md-12" class="collapse" id="collapseExample">
          <div class="tile">
            <h3 class="tile-title line-head">Usuarios vs Perfil</h3>
            <div class="tile-body" >

              <!--<form class="row" id="buscar_general" name="buscar_general" method="get">-->
                <div class="row">
                 <div class="form-group col-md-2">
                  <label class="control-label text-bold">Sistema:</label>
                   <select  name="sistema" id="sistema"  Class="form-control">
                    <!-- <option value="0000" disabled selected>Seleccione</option>-->
                    <?php foreach($sistema as $sm){ ?>
                  <option value="<?php echo $sm['Codi_Sistema']; ?>"><?php echo $sm['Descripcion'];?></option>
                   <?php } ?>
                 </select>
                  </div>

                 <div class="form-group col-md-3">
                  <label class="control-label text-bold">Dependencia:</label>
                   <select  name="depen" id="depen"  Class="form-control" >
                   <option value="0000" selected>Todos</option>
                    <?php foreach($depen_sistema as $dp){ ?>
                  <option value="<?php echo $dp['CODI_DEPE_TDE']; ?>"><?php echo $dp['DESC_DEPE_TDE'];?></option>
                   <?php } ?>
                 </select>
                  </div>
              
                 
                  <div class="form-group col-md-1 align-self-end">
                  <input type="hidden" id="h_rol" name="h_rol" value="<?php echo $rol; ?>" />
                  <button class="btn btn-primary" id="busqued" name="busqued" onclick="cargarDiv()"><i class="fa fa-search"></i>Buscar</button>
                 </div>


                <div class="col-md-12" class="collapse" id="collapseExample">
             <!-- <div class="row">
                <div class="form-group col-md-4"></div> 
                <label class="col-sm- text-bold" >Año:</label>
                   <div class="form-group col-md-2">
                     <select   name="idanios" id="idanios" required="true" class="chosen-select3" >
                     <option  value=""  disabled>Seleccione</option>
                      <?php foreach($anios as $pr)
                      {
                       if($pr['ANIO'] == date('Y'))
                      { 
                     ?>
                  <option selected value="<?php echo $pr['ANIO']; ?>"><?php echo $pr['ANIO'];?></option>
                   <?php }
                   else
                    {
                      ?>  
                  <option value="<?php echo $pr['ANIO']; ?>"><?php echo $pr['ANIO'];?></option>
                   <?php 
                    }
                } ?>
                </select>

                  </div>

                 <label class="text-bold">Mes:</label>
                <div class="form-group col-md-2">
                   <select id="idmes" name="idmes" value= <?php echo date('M'); ?>; style="width: 100%;" class="chosen-select4">
                    </select>
                </div>
               
            </div>-->
             <!--<div class="form-group col-md-6">
                <label class="control-label" for="first-name">depen:</label>
                   <select  name="idedep" id="idedep" Class="chosen-select" style="width: 100%;">
                        <option  value="0"  disabled>Seleccione</option>
                    <?php foreach($dependencia as $dp){ ?>
                    <option selected value="<?php echo $dp['CODI_DEPE_TDE']; ?>"><?php echo $dp['DESC_DEPE_TDE'];?></option>
                   <?php } ?>
                 </select>    
            </div>

              <div class="form-group col-md-6">
                <label class="control-label" for="first-name">Subdependencia:</label> 
                  <select id="isdub" name="isdub"  class="chosen-select1" style="width: 100%">
                 </select>    
            </div>-->


        </div>


                <!--</form>-->
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
             <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 class="tile-title line-head">Listado de Usuarios vs Perfil del Sistema</h2>
                        <div class="clearfix"></div>
                    </div>
                    <?php if($_SESSION['usuario'][0]["ROLASISTENCIA"]==8 || $_SESSION['usuario'][0]["ROLASISTENCIA"]==4 ){?>   <?php } ?>
                     <?php  if ($_SESSION['usuario'][0]["ROLASISTENCIA"]==0){?>
                        <div class="toolbar">
                           <div align="right" id="d_aprobar" style="display: none">
                            <button class="btn btn-info" id="baprobar" name="baprobar" type="button" title="Nuevo Usuario" data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Usuarios/registar_rol') ?>"><i class="fa fa-plus"></i>Nuevo Usuario</button>
                            </div>
                        </div><?php } ?>
                        <br>
                        <div id="contenido" name="contenido">
              

                     </div>
                 </div>
               </div>
             </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  

<style type="text/css">
  .modal-content {
    position: relative;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 6px;
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
    box-shadow: 0 3px 9px rgba(0,0,0,.5);
}
</style>

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
    <?php include "/../Admin/footer.php"; ?>

     <script>
        $(document).ready(function() {
      $("#1").addClass('treeview is-expanded');
      $("#1_3").addClass('treeview-item-active');


       $("#acceso_modal").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            var sistema =  $('#sistema').val();
            var depen =  $('#depen').val();
            var  data="cod="+sistema+","+depen

            $(this).find(".modal-content").load(link.attr("app_crear_per"),data);
        });
			
         /*$("#acceso_modal").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_per"));
        });*/
        $("#acceso_modal_mod").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_mod"));
        });
        $("#acceso_modal_eli").on("show.bs.modal", function(e) {
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("app_crear_eli"));
        });
		
		cargarDiv();
      });
    </script>

<script type="text/javascript">
function cargarDiv(){
      var sistema =  $('#sistema').val();
      var depen =  $('#depen').val();
      var rol = $('#h_rol').val();
      var url = "<?php echo site_url(); ?>" + "/Usuarios/index_1";
      frm = {sistema: sistema, depen:depen };
      $.ajax({
         url: url, 
          type: 'POST',
          data: frm,
      }).done(function(contextResponse, statusResponse, response) {
 $("#contenido").html(contextResponse);
          $('#sampleTable').DataTable();

      if (depen=="0000"  ){
         // alert(rol+'-'+estado);
          //if (tcount>0){
               $("#d_aprobar").css("display", "block");
               $("#baprobar").attr("disabled", true);
              //  alert('ingreso');
          } else {
              $("#d_aprobar").css("display", "block");
             $("#baprobar").attr("disabled", false); 
             //alert('no ingresp');       
            //$("#d_aprobar").css("display", "none");
          }

      })
    }
    

    $('#depen').on('change', function() {
      
        if(this.value=="0000"){
           $("#d_aprobar").css("display", "block");
             $("#baprobar").attr("disabled", true); 

        }
        else{
          $("#d_aprobar").css("display", "block");
             $("#baprobar").attr("disabled", false); 

        }

      });

    ///

    /* $(document).ready(function(){
    $(document).ready(function() {
         function set_aniomes(idanios, idmes, with_item) {
           $(idanios).change(function(){
             var idanio = $(idanios).val();
              if (Number.isInteger(Math.floor(idanio))) {
                 var id_url = base_url+"/Usuarios/det_anio/"+idanio;
                 var items = "";
               console.log(id_url);
                        i=0;
                   $.getJSON(id_url, function(data) {
                     $(idmes).find("option").remove();
                     if (with_item == true) {
                         items="<option value='00' selected>todos</option>";
                                
                            }
                         $.each( data, function(key, val) { i++;
                         
                             items = items+"<option  value='" + val.MES + "'>" + val.MES + "</option>"; 
                            });
                            $(idmes).find("option").remove();
                            $(idmes).append(items);
                            $(".chosen-select1").val('').trigger("chosen:updated");
                            $(".chosen-select2").val('').trigger("chosen:updated");
                             $(".chosen-select3").val('').trigger("chosen:updated");
                            $('.chosen-select1').chosen();
                        });
                    }
                });
            }//// ok 1
           set_aniomes("#idanios", "#idmes", true);
           
       });
    });*/

    
 /*var base_url = "<?php echo site_url(); ?>";
    // alert(base_url)
     $(document).ready(function(){
         function set_dependencia(idedep, isdub, with_item) {
           $(idedep).change(function(){
             var id_dep = $(idedep).val();
              console.log(id_dep);
              if (Number.isInteger(Math.floor(id_dep))) {
                  var id_url = base_url+"/Usuarios/det_depen/"+id_dep;
                 var items = "";
               console.log(id_url);
                        i=0;
                   $.getJSON(id_url, function(data) {
                     $(isdub).find("option").remove();
                     if (with_item == true) {
                         items="<option value='00' selected>todos</option>";
                                
                            }
                    //console.log(data);
                         $.each( data, function(key, val) { i++;
                         
                             items = items+"<option  value='" + val.CODI_SUBDEPEN + "'>" + val.DESC_SUBDEPEN + "</option>"; 
                            });
                            $(isdub).find("option").remove();
                            $(isdub).append(items);
                            $(".chosen-select1").val('').trigger("chosen:updated");
                            $(".chosen-select2").val('').trigger("chosen:updated");
                             $(".chosen-select3").val('').trigger("chosen:updated");
                            $('.chosen-select1').chosen();
                        });
                    }
                    //dist = $(MES).val();
                });
            }//// ok 1
           set_dependencia("#idedep", "#isdub", true);
         // set_condicion("#idanios", "#idmes", "#tipo", true);
           
       });*/

          

  

</script>

