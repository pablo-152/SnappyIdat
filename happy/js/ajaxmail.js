// Archivo javascript que manipulará Ajax con jQuery
$(function(){
    $("#btnOk").click(function(evt){
        evt.preventDefault();
        var nombre = $("#txtNombre").val();
        var correo = $("#txtCorreo").val();
        var opcion = $("#cmbMedio").val();
        var peticion = false;
        if($("#chkPeticion").prop("checked")) peticion = true;
        $.ajax({
            url: "datos.php",
            method: "POST",
            data: { nom: nombre, cor: correo, opc: opcion, pet: peticion },
            success: function(dataresponse, statustext, response){
                var mensaje = "";
                if(dataresponse=="ok") mensaje = "Gracias por sus datos.";
                else mensaje = "Faltan algunos datos, revise por favor." + dataresponse;
                $("#respuesta").html("<p><strong>" + mensaje + "</strong></p>");
            },
            error: function(request, errorcode, errortext){
                $("#respuesta").html("<p>Ocurrió el siguiente error: <strong>" + errortext + "</strong></p>");
            }
        });
    });
});