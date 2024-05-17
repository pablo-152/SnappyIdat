
function setPapeletaID(papeletaID) { 
	$("#papeletaID").val(papeletaID);
}
function ingresoPapeleta(id){
	bootbox.alert(id);
}

function delete_row(e, url) {
		bootbox.confirm({
          //  title: "Papeletas",
            message: "Desea eliminar Papeleta.",/*"+usuario+",*/
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
                    $.get(url, function(data) {
                    	// console.log(data);
                    	//dataTable.row($(e).parents('tr')).remove().draw();
                        location.reload();
                    });
                }
            }
        });
}

// agregar mensaje
function desaprobar(e){
	bootbox.confirm({
            title: "Registro de Papeletas",
            message: "Desea Desaprobar Papeleta?",
            inputType: 'email',
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
                    $(e).parents('form')[0].submit();
                } else {
                	console.log('!');
                }
            }
    });
}
function aprobar(e){
	bootbox.confirm({
            title: "Registro de Papeletas",
            message: "Desea aprobar papeleta ?",
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
                     //initInvoker('W',256)
                    $(e).parents('form')[0].submit();
                   
                } else {
                	console.log('!');
                }
            }
    });
}

function corregir(e){
	bootbox.confirm({
            title: "Registro de Papeletas",
            message: "Desea enviar a corregir?",
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
                    $(e).parents('form')[0].submit();
                } else {
                	console.log('!');
                }
            }
    });
}

$(document).ready(function() {

    var msgDate = '';
    var inputFocus = '';
    var date_input=$('#fecha_ini');


    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        leftArrow: '<i class="fa fa-long-arrow-left"></i>',
        rightArrow: '<i class="fa fa-long-arrow-right"></i>'

    });

});

$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
    var date_input=$('#fecha_fin');

    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
        format: 'dd-mm-yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        leftArrow: '<i class="fa fa-long-arrow-left"></i>',
        rightArrow: '<i class="fa fa-long-arrow-right"></i>'

    });
        
   
});

