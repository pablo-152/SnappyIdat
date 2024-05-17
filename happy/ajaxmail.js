// Archivo javascript que manipulará Ajax con jQuery
$(function(){
    $("#enviar").click(function(evt){
        evt.preventDefault();
        var nombre = $("#nombre").val();
        var email = $("#email").val();
        var telefono = $("#telefono").val();
        var message = $("#message").val();

          $.ajax({
            url: "enviaremail.php",
            method: "POST",
            data: { nombre: nombre, email: email, telefono: telefono, message: message },
            success: function(dataresponse, statustext, response){
                var mensaje = "";
                if(dataresponse=="ok") mensaje = "Gracias por contactarnos.";
                else mensaje = "Faltan algunos datos, revise por favor." + dataresponse;
                $("#respuesta").html("<p><strong>" + mensaje + "</strong></p>");

                location.reload();
            },
            error: function(request, errorcode, errortext){
                
                $("#respuesta").html("<p>Ocurrió el siguiente error: <strong>" + errortext + "</strong></p>");
            }
        });
    });
});