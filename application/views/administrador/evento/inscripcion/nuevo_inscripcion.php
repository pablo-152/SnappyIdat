


        <form class="needs-validation" id="formulario" method="POST" enctype="multipart/form-data" action="<?= site_url('Administrador/Insert_Evento')?>">
          <div class="modal-header">
              <h3 class="tile-title">Evento (Nuevo)</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
          </div>
        <div class="modal-body" style="overflow:auto;">
          <div class="col-md-12 row">
            <div class="form-group col-md-2">
              <label class="col-sm-3 control-label text-bold">Evento:</label>
            </div>
            <div class="form-group col-md-4">
              <input name="nom_evento" type="text" maxlength="50" class="form-control" id="nom_evento" placeholder="Ingresar evento">
            </div>
            <div class="form-group col-md-2">
              <label class="col-sm-3 control-label text-bold">Agenda&nbsp;/&nbsp;Redes:</label>
            </div>
            <div class="form-group col-md-4">
              <input class="form-control date" id="fec_agenda" name="fec_agenda" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" />
            </div>
            <div class="form-group col-md-2">
              <label class="col-sm-3 control-label text-bold">Activo&nbsp;de:</label>
            </div>
            <div class="form-group col-md-4">
              <input class="form-control date" id="fec_ini" name="fec_ini" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" />
            </div>
            <div class="form-group col-md-2">
              <label class="col-sm-3 control-label text-bold">Hasta:</label>
            </div>
            <div class="form-group col-md-4">
              <input class="form-control date" id="fec_fin" name="fec_fin" placeholder= "Seleccione fecha"  type="date" value="<?php echo date('d/m/Y');?>" />
            </div>
            <div class="form-group col-md-2">
              <label class="col-sm-3 control-label text-bold">Empresa:</label>
            </div>
            
            <div class=" form-group col-md-10">
              
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
              </label>
            </div>
            <div class="form-group col-md-2">
              <label class="col-sm-3 control-label text-bold">Link:</label>
            </div>
            <div class="form-group col-md-10">
              <input name="link" type="text" maxlength="50" class="form-control" id="link" placeholder="Ingresar link">
            </div>
            <div class="form-group col-md-12">
              <label class="col-sm-3 control-label text-bold">Observaciones:</label>
            </div>
            <div class="form-group col-md-12">
                <div class="col-xs-12">
                    <textarea name="obs_evento" rows="8" class="form-control" id="obs_evento"></textarea>
                    <span style="color: #C8C8C8;">Utilizar siempre la configuración: DD/MM/AAAA - Observaciones (Usuario)</span>
                </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
            <button type="button" id="btninsertEvento" class="btn btn-success">Guardar</button>&nbsp;&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    

<script>

$(".chosen-select").chosen({rtl: true});

// $('.chosen-select').chosen();
$(".chosen-select1").chosen({rtl: true});
$(".chosen-select2").chosen({rtl: true});
$(".chosen-select3").chosen({rtl: true});


$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
});

  $("#btninsertEvento").on('click', function(e){
        if (NuevoEvento()) {
            bootbox.confirm({
                title: "Registrar Evento",
                message: "¿Desea guardar el Evento?",
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
                        $('#formulario').submit();
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

  function NuevoEvento() {

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

      if($('#nom_evento').val()=="") { 
        Swal(
            'Ups!',
            'Debe ingresar Nombre.',
            'warning'
        ).then(function() { });
        return false;
      }
      if($('#fec_agenda').val()=="") { 
        Swal(
            'Ups!',
            'Debe ingresar Fecha Evento.',
            'warning'
        ).then(function() { });
        return false;
      }
      if($('#fec_ini').val()=="") { 
        Swal(
            'Ups!',
            'Debe ingresar Fecha Inicio.',
            'warning'
        ).then(function() { });
        return false;
      }
      if($('#fec_fin').val()=="") { 
        Swal(
            'Ups!',
            'Debe ingresar Fecha Fin.',
            'warning'
        ).then(function() { });
        return false;
      }
      if($('#link').val()=="") { 
        Swal(
            'Ups!',
            'Debe ingresar Link.',
            'warning'
        ).then(function() { });
        return false;
      }
      if($('#obs_evento').val()=="") { 
        Swal(
            'Ups!',
            'Debe ingresar Observaciones.',
            'warning'
        ).then(function() { });
        return false;
      }

    if (GL0==false && GL1==false && GL2==false && BL1==false && LL1==false && LL2==false && LS1==false
    && LS2==false && EP1==false && EP2==false && FV1==false && FV2==false && LA0==false && VJ1==false)
  {
      Swal(
          'Ups!',
          'Debe seleccionar Empresa.',
          'warning'
      ).then(function() { });
      return false;
    }
  
   
     return true;

  }
</script>



   




