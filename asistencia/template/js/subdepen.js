$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
    $("#btn_guardar").on('click', function(e){
        if (subdepen())
        {
            bootbox.confirm({
                title: "Registro de Subdependencias",
                message: "¿Desea registrar esta Subdependencia?",
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
                        $('#frm_subdepen').submit();
                    }
                }
            });
        } else {
            bootbox.alert(msgDate);
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    });
        
    function subdepen() {

        if ($('#codi_depe').val()==null){
          msgDate = 'Seleccione Dependencia.';
          inputFocus = '#codi_depe';
          return false;
        }  

        if ($('#Descripción_subdepen').val().trim() === '')
        {
                msgDate = 'Ingrese Subdependencia.';
                inputFocus = '#Descripción_subdepen';
                return false;
        }
                
         return true;
    }
});

 
// validacion caracteres especiales
function especial(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789áéíóúabcdefghijklmnñopqrstuvwxyz:/";
    especiales = "8-37-39-46";

    tecla_especial = false
    for(var i in especiales){
         if(key == especiales[i]){
             tecla_especial = true;
             break;
         }
     }
    /* if(letras.indexOf(tecla)==-1 && !tecla_especial){
         return false;
     }*/
}





