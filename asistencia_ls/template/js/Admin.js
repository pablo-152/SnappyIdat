$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';

    $("#btn_usuarios").on('click', function(e){
      // if (depenaprob()){
            bootbox.confirm({
                title: "Modificar Usuario vs Perfil",
                message: "¿Desea Actualizar Datos del Usuario ?",
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
                        $('#frm_usuarios').submit();
                    }
                }
            });
        //}
    });

    // 

    
    
$("#btnuser_Registro").on('click', function(e){
        if (usuarioVSrol())
        {
            bootbox.confirm({
                title: "Registro de usuario vs Perfil",
                message: "¿Desea registrar usuario?",
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
                        $('#frm_usuariosreg').submit();
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




    function usuarioVSrol() {
       // console.log("eee",$('#coduser').val());
         if ($('#coduser').val() ==null){
         msgDate = 'Seleccione Usuario.';
        inputFocus = '#coduser';
        return false;
        }

        if ($('#activo').val().trim() === ''){
          msgDate = 'Seleccione Activo.';
          inputFocus = '#activo';
          return false;
        }

         /*if ($('#dependencia').val()==null){
          msgDate = 'Seleccione Dependencia.';
          inputFocus = '#dependencia';
          return false;
        } */

         /*if ($('#subdependencia').val()==null){
          msgDate = 'Seleccione Subdependencia.';
          inputFocus = '#subdependencia';
          return false;
        } */

        if ($('#perfil').val()==null){
          msgDate = 'Seleccione Perfil.';
          inputFocus = '#perfil';
          return false;
        } 
         return true;
    }
   
$("#btn_actualizar").on('click', function(e){
        if (subdepen())
        {
            bootbox.confirm({
                title: "Modificar Subdependencia",
                message: "¿Desea actualizar Subdependencia?",
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

    
/// nuevo

$("#btn_actualizaraprob").on('click', function(e){
       if (depenaprob()) {
            bootbox.confirm({
                title: "Modificar Dependencia Aprobación",
                message: "¿Desea actualizar Niveles de Aprobación?",
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
                        $('#frm_actualizaraprob').submit();
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


    function depenaprob() {
        if ($('#codi_depe').val()==null){
          msgDate = 'Seleccione Dependencia.';
          inputFocus = '#codi_depe';
          return false;
        }  
        if ($('#llave').val()==null){
          msgDate = 'Seleccione llave.';
          inputFocus = '#llave';
          return false;
        } 
         return true;
    }
///////

});

function calculaubic(){
    var codi_depe = $('#codi_depe').val();
  //  alert(codi_depe);
     var url_dest=base_url+"Usuarios/validar_registro"; 

        $.ajax({
            url: url_dest,
            data: {'codi_depe':codi_depe},
            method: 'post',
            dataType: 'json',  
            success: function (data) {
                var dato = data;                
                validapasubdepen(dato);
            },
            error: function (err) {
                alert(err);
            }
        });
    
   /* else
    {
        validapasubdepen(0);
        //validareg(0,0);
    }*/
}

function validapasubdepen(dato){
    var cant_ubic=dato;
    var combo=  $('#codi_depe').val();
    var llave= $('#llave').val();
if (cant_ubic >= 1) {
        msgDate = 'Está permitido una dependencia por caso.';
        bootbox.alert(msgDate);
        return false;
    }
if ($('#codi_depe').val()==null){
        msgDate = 'Seleccione Dependencia.';
        bootbox.alert(msgDate);
        inputFocus = '#codi_depe';
        return false;
    }
if ($('#llave').val()==null){
        msgDate = 'Seleccione llave.';
        bootbox.alert(msgDate);
        inputFocus = '#llave';
        return false;
    }
bootbox.confirm({
        title: "Registro de Nivel de Aprobacion",
        message: "¿Está  seguro de Registrar Niveles de Aprobación?",
        buttons: {
            cancel: {
                label: 'Cancelar'
            },
            confirm: {
                label: 'Aceptar'
            }
        },
        callback: function (result) {
            if (result) {
               // alert(combo);
                var combo =  $('#codi_depe').val();
                var llave =  $('#llave').val();
                var formData = new FormData($(".formulario")[0]);
                //alert(formData)
                var url = base_url+"Usuarios/registrar_DepenAprob";
                frm = {combo:codi_depe, llave:llave };
               /* $.ajax({
                    url: url, 
                    type: 'POST',
                    dataType: 'html',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                }).done(function(contextResponse, statusResponse, response) {
                    //cargarDiv();
                    $("#acceso_modal").modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                })*/
                 $.ajax({
                    url: url, 
                    type: 'POST',
                    dataType: 'html',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                    $("#acceso_modal").modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    location.reload();
            },
            error: function (err) {
                console.log(err);
                  }
             });
            }
        }
    });
}

// configuracion
$("#btn_guardarconfig").on('click', function(e){
        if (guardar_conf()) {
            bootbox.confirm({
                title: "Registrar configuración",
                message: "¿Desea registrar Configuración?",
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
                        $('#frm_config').submit();
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


function guardar_conf() {
        if ($('#parametro').val().trim() === ''){//Val trim es para que el campo se obligatorio
          msgDate = 'Ingrese Parámetro.';
          inputFocus = '#parametro';
          return false;
        } 

        if ($('#descripcion').val().trim() === ''){
          msgDate = 'Ingrese Descripción.';
          inputFocus = '#descripcion';
          return false;
        } 

        if ($('#Descripcion_val').val().trim() === ''){
          msgDate = 'Ingrese Valor.';
          inputFocus = '#Descripcion_val';
          return false;
        }
        
        if ($('#Descripcion_men').val().trim() === ''){
          msgDate = 'Ingrese Mensaje.';
          inputFocus = '#Descripcion_men';
          return false;
        }

         return true;
    }

        function delete_config(e, url) {
                bootbox.confirm({
                    title: "Eliminar Configuración",
                    message: "¿Está  seguro de eliminar?",/*"+usuario+",*/
                    buttons: {
                        cancel: {
                            label: 'Cancelar'
                        },
                        confirm: {
                            label: 'Aceptar'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            $.get(url, function(data) {
                                // console.log(data);
                                //dataTable.row($(e).parents('tr')).remove().draw();
                                location.reload();
                            });
                        }
                    }
                });
        }

        $("#btn_actualizarconfig").on('click', function(e){
        if (actu_config()) {
            bootbox.confirm({
                title: "Modificar configuración",
                message: "¿Desea actualizar Configuración?",
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
        function actu_config() {
        if ($('#parametro').val().trim() === ''){//Val trim es para que el campo se obligatorio
          msgDate = 'Ingrese Parámetro.';
          inputFocus = '#parametro';
          return false;
        } 

        if ($('#descripcion').val().trim() === ''){
          msgDate = 'Ingrese Descripción.';
          inputFocus = '#descripcion';
          return false;
        } 

        if ($('#Descripcion_val').val().trim() === ''){
          msgDate = 'Ingrese Valor.';
          inputFocus = '#Descripcion_val';
          return false;
        }
        
        if ($('#Descripcion_men').val().trim() === ''){
          msgDate = 'Ingrese Mensaje.';
          inputFocus = '#Descripcion_men';
          return false;
        } 
        
         return true;
    }



/// subdependencia

function calcula_subdepen(){
    var codi_depe = $('#codi_depe').val();
  //alert(codi_depe);
     var url_dest=base_url+"Usuarios/validar_codisubdepen"; 

        $.ajax({
            url: url_dest,
            data: {'codi_depe':codi_depe},
            method: 'post',
            dataType: 'json',  
            success: function (data) {
                var dato = data;  
                //alert(dato)              
                validasubdependencia(dato);
            },
            error: function (err) {
                alert(err);
            }
        });
    
   /* else
    {
        validapasubdepen(0);
        //validareg(0,0);
    }*/
}

function validasubdependencia(dato){
    var cant_ubic=dato;
    //alert(cant_ubic);
    var combo=  $('#codi_depe').val();
    var subdepen =  $('#Descripcion_subdepen').val();
if (cant_ubic >= 1) {
        msgDate = 'Está permitido una Dependencia';
        bootbox.alert(msgDate);
        return false;
    }
if ($('#codi_depe').val()==null){
        msgDate = 'Seleccione Dependencia.';
        bootbox.alert(msgDate);
        inputFocus = '#codi_depe';
        return false;
    }
if ($('#Descripcion_subdepen').val()== '')
    {
        msgDate = 'Ingrese Subdependencia.';
        bootbox.alert(msgDate);
        inputFocus = '#Descripcion_subdepen';
        return false;
    }
bootbox.confirm({
        title: "Registro de Subdependencias",
        message: "¿Desea registrar esta Subdependencia?",
        buttons: {
            cancel: {
                label: 'Cancelar'
            },
            confirm: {
                label: 'Aceptar'
            }
        },
        callback: function (result) {
            if (result) {
               // alert(combo);
                var combo =  $('#codi_depe').val();
                var subdepen =  $('#Descripcion_subdepen').val();
                var formData = new FormData($(".formulario")[0]);
                //alert(formData)
                var url = base_url+"Usuarios/registrar_Usuario";
                frm = {combo:codi_depe, subdepen:Descripcion_subdepen };
               /* $.ajax({
                    url: url, 
                    type: 'POST',
                    dataType: 'html',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                }).done(function(contextResponse, statusResponse, response) {
                    //cargarDiv();
                    $("#acceso_modal").modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                })*/
                $.ajax({
                    url: url, 
                    type: 'POST',
                    dataType: 'html',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                    $("#acceso_modal").modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    location.reload();// refresca
            },
            error: function (err) {
                console.log(err);
                  }
             });
            }
        }
    });
}

 


/*$("#codi_depe").change(function(){
      var codi_depe = $(this).val();
      var url_dest=base_url+"Usuarios/validar_registro";
      console.log(url_dest);
      $.ajax({
       // type: "POST",
        url:url_dest,
        data:{codi_depe:codi_depe}
      }).done(function(result)
      { 

      if (result==0) {
           console.log("no existe");
        }

        else  {
        msgDate = 'solo esta permitido 1';
        bootbox.alert(msgDate);
        return false;
         }

        //now
      })
    });*/



 
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
function delete_depenaprob(e, url) {
        bootbox.confirm({
            title: "Eliminar Nivel de Aprobación",
            message: "¿Está  seguro de eliminar?",/*"+usuario+",*/
            buttons: {
                cancel: {
                    label: 'Cancelar'
                },
                confirm: {
                    label: 'Aceptar'
                }
            },
            callback: function (result) {
                if (result) {
                    $.get(url, function(data) {
                        // console.log(data);
                        //dataTable.row($(e).parents('tr')).remove().draw();
                        location.reload();
                    });
                }
            }
        });
}

function delete_row(e, url) {
        bootbox.confirm({
            title: "Eliminar Subdependencia",
            message: "¿Está  seguro de eliminar?",/*"+usuario+",*/
            buttons: {
                cancel: {
                    label: 'Cancelar'
                },
                confirm: {
                    label: 'Aceptar'
                }
            },
            callback: function (result) {
                if (result) {
                    $.get(url, function(data) {
                        // console.log(data);
                        //dataTable.row($(e).parents('tr')).remove().draw();
                        location.reload();
                    });
                }
            }
        });
}



