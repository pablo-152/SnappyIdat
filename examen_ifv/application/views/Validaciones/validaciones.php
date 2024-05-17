<script>
$(document).ready(function() {
    /**/var msgDate = '';
    var inputFocus = '';
 /* Validaeb();
    Validasp();
    Validag();
    ValidaRC();
    ValidaE();
    ValidaA();
*/
});

    function Insert_Grado(){
        var dataString = $("#formulario").serialize();
        
        //var url="<?php echo site_url(); ?>Admision/Ad6";
        if (Valida_Grado()) {
                        $('#formulario').submit();
                  
                }
           
        else{
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
    function Valida_Grado() {
        if($('#id_grado').val().trim() === '0') {
            /*msgDate = 'Debe seleccionar grado';
            inputFocus = '#id_grado';*/
            alert("Tiene que seleccionar Grado");
            return false;
        }
        return true;

    }

    function Insert_Tutorial(){
        var dataString = $("#formulario1").serialize();
        //alert(dataString);
        if (Valida_Tutorial()) {
            $('#formulario1').submit();
                  
        }
                
    }
    function Valida_Tutorial() {
    return true;

    }
    function Avanzar_Unidades(){
        var dataString = $("#formulario").serialize();
        //alert(dataString);
        if (Valida_Unidades()) {
            $('#formulario').submit();
                  
        }
                
    }
    function Valida_Unidades() {
    return true;

    }
    function Finalizar_Registro(){
        var dataString = $("#formulario").serialize();
        //alert(dataString);
        if (Valida_Finalizar()) {
            $('#formulario').submit();
                  
        }
                
    }
    function Valida_Finalizar() {
    return true;

    }
</script>