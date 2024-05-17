$(document).ready(function() {
    var msgDate = '';
    var inputFocus = '';
	var url_dest=base_url+"Papeletas/horaspermiso";
	$.ajax({
		url: url_dest,
		data: {'cod':'cod'},
		type: 'POST',
		dataType: 'html',
		success: function (resp) {
			horas=parseInt(resp);
			$('#htotal').val(resp);
		},
	});

});

function calcularpapeletas(){
	var dateper = $('#date1').val();
	var cod = $('#tipopermiso').val();
	var url_dest=base_url+"Papeletas/validarpapelet";	
	
	if(cod == 1 || cod == 3) {	
		$.ajax({
			url: url_dest,
			data: {'cod':cod,'datef':dateper},
			method: 'post',
			dataType: 'json',  
			success: function (data) {
				var dato = data;				
				validapapeleta(dato);
				//validareg(dato,0);
			},
			error: function (err) {
				alert(err);
			}
		});
	}
	else
	{
		validapapeleta(0);
		//validareg(0,0);
	}
}

function validapapeleta(dato)
{
	var cant_papeleta=dato;
	var origen = $('#origen_horas').val();
	var fecha = $('#date1').val();
	var horaInicial=devolverMinutos($('#datetime1').val());
    var horaFinal=devolverMinutos($('#datetime2').val());
	var url_dest=base_url+"Papeletas/compararminutos";
	if(origen==1)
	{
		$.ajax({
			url: url_dest,
			data: {'horaInicial':horaInicial,'horaFinal':horaFinal,'fecha':fecha, 'cant_papeleta':cant_papeleta},
			method: 'post',
			//dataType: 'json',
			success: function (data) {
				var datototal=data.split("*")
				var minutos = datototal[0];
				var cant_papeletan=datototal[1];
				validareg(cant_papeleta, minutos);
			},
			error: function (err) {
				alert(err);
			}
		});
	}
	if(origen==2)
	{
		validareg(cant_papeleta, 0);
	}
}

function validareg(cant_papeletas, horav)
{	
	var combo=  $('#dpx-motivo').val();
	var origen = $('#origen_horas').val();
	var motivo=0;
	var motivoT=0;
	var value_motivo = $( "#dpx-motivo option:selected" ).val();
	//alert(value_motivo)
    var val_motivo =value_motivo.split("*");
    var id = val_motivo[0];
    var horasmaximo= val_motivo[1];
    var dateper = $('#date1').val();
    var val_fecper =dateper.split("-");
    var dia = val_fecper[0];
    var mes = val_fecper[1];
	var anio = val_fecper[2];
	var diaactu = val_fecper[0]+"/"+val_fecper[1]+"/"+val_fecper[2];
	var id = $('#dpx-motivo').val();
    var datePerm = moment($('#date1').val(), 'DD-MM-YYYY');
	var horaInicial=devolverMinutos($('#datetime1').val());
    var horaFinal=devolverMinutos($('#datetime2').val());
	var horaInicialO=devolverMinutos($('#hora_ingreso_o').val());
    var horaFinalO=devolverMinutos($('#hora_fin_o').val());	

	if ($('#dpx-motivo').val()==null)
	{
		msgDate = 'Seleccione motivo de salida.';
		bootbox.alert(msgDate);
		inputFocus = '#dpx-motivo';
		return false;
	}
	else 
	{
		motivoT=combo.split("*")
		motivo=motivoT[0];
	}
	
	if (horav >= 1)
	{
		msgDate = 'Ya existe una papeleta dentro del rango de horas elegido.';
		bootbox.alert(msgDate);
		return false;
	}
	
	if (cant_papeletas >= 1)
	{
		msgDate = 'Está permitido solo una papeleta por día.';
		bootbox.alert(msgDate);
		return false;
	}
	
    //if (!datePerm.isValid() || datePerm.year() !== moment().year())
    if (!datePerm.isValid() )	
    {
        msgDate = 'La fecha de permiso: no es valida.';
        bootbox.alert(msgDate);
        inputFocus = '#date1';    
        return false;
    }

    if ($('#serviciosporhora_obs').val().trim() === '' && motivo== 19)
	{
		msgDate = 'Ingrese el lugar de la comisión.';
		bootbox.alert(msgDate);
		inputFocus = '#serviciosporhora_obs';
		return false;
	}
	
    if ($('#justificacion').val().trim() === '' && motivo == 19)
    {
            msgDate = 'Ingrese justificacion.';
            bootbox.alert(msgDate);
            inputFocus = '#justificacion';
			$( "#justificacion" ).focus();
            return false;
    }
    
   /* if ($('#archivo_essalud').val() === '' && motivo == 49)
    {
            msgDate = 'Adjuntar archivo Essalud.';
            bootbox.alert(msgDate);
            inputFocus = '#archivo_essalud';
            return false;
    }*/

    if ($('#tipopermiso').val()==null){
		msgDate = 'Seleccione tipo de permiso.';
		bootbox.alert(msgDate);
		inputFocus = '#tipopermiso';
		return false;
    }

	if (dia_semana(diaactu) === 'Sábado' || dia_semana(diaactu) === 'Domingo')
    {
        msgDate = 'La fecha debe ser entre Lunes y Viernes';
        bootbox.alert(msgDate);
       	inputFocus = '#date1'; 
        return false;
    }
	
  /*  if ($('#datetime1').val()==null || $('#datetime1').val()==""){
		msgDate = 'Debe registrar la hora de inicio.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }

    if ($('#datetime2').val()==null || $('#datetime2').val()==""){
		msgDate = 'Debe registrar la hora de término.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime2';
		return false;
    }*/
    if(origen==1 && ($('#datetime1').val()==null || $('#datetime1').val()=="")){
		msgDate = 'Debe registrar la hora de inicio.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime2';
		return false;
    }

    
      

	if(origen==1 && ($('#datetime2').val()==null || $('#datetime2').val()=="")){
		msgDate = 'Debe registrar la hora de término.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime2';
		return false;
    }


    if (horaInicial>=horaFinal){
		msgDate = 'La hora inicial tiene que ser inferior a la hora final';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }
	
	if (horaInicial<horaInicialO){
		msgDate = 'La Hora de Inicio no debe ser menor a la Hora de Ingreso';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }
	
	if (horaInicial>horaFinalO){
		msgDate = 'La Hora de Inicio no debe ser mayor a la Hora de Salida';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }
	
	if (horaFinalO<horaFinal){
		msgDate = 'La Hora de Término no debe ser mayor a la Hora de Salida';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }
	
	if (horaFinal<horaInicialO){
		msgDate = 'La Hora de Término no debe ser menor a la Hora de Ingreso';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }

    if ((horaFinal-horaInicial)>(horasmaximo*60)){
		msgDate = 'La diferencia de horas es mayor al máximo de horas del permitido según el motivo de salida.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }

    var fechaayerymanana = function (message){
		var htotal=$('#htotal').val();

		horas=parseInt(htotal);
		//var split = date_input.val().split("-");
		var split = $('#date1').val().split("-");
		var date1 = new Date(split[2], split[1]-1, split[0]);
		//alert(split[2],+ '-'+split[1]-1,+ '-'+split[0],);
		var now = new Date();
		var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		var diatexto=diasSemana[now.getDay()];
		var timeDiff = now.getTime() - date1.getTime();
		var diffDays1 = Math.abs(Math.floor(timeDiff / (1000 * 3600 * 24)));
		//var diffDays1 = Math.floor(timeDiff / (1000 * 3600 * 24));
		/*total de dias permitido por el sistema*/
		var numdia= Math.round(horas/24);

		//alert( 'dias'+numdia);
		//nuevo
		/*var numdiap=-numdia;
		
		if (diatexto=="Lunes" && diffDays1>numdia)
		{
			var diffDays=diffDays1-2;
		}
		else
		{
			if (diatexto=="Viernes" && diffDays1>numdia)
			{
				var diffDays=diffDays1+2;
			}
			else
			{
				var diffDays=diffDays1;
			}
		}
		//if(diffDays<-1 || diffDays>1){
		if(diffDays>0 || diffDays<numdiap){
			return false;
		}
		return true;
	}*/


	//nuevo
    // 
		if (diatexto=="Lunes" && diffDays1>numdia){
			var diffDays=diffDays1-2;
		}
		else
		{


			if (diatexto=="Viernes" && diffDays1>numdia)
			{
				var diffDays=diffDays1+2;
			}
			else
			{
				var diffDays=diffDays1;
			}
		}
		//if(diffDays<-1 || diffDays>1){
		//if(diffDays>1) anulado 23
		if(diffDays>numdia){	
			if(message){
				bootbox.alert("Las papeletas se presentarán hasta "+horas+" horas antes del día de hoy1.");
				inputFocus = '#date1';
				return false;
			}
			//alert('diffDays='+diffDays+ 'diffDays1='+diffDays1); 
			return false;
		}
		//alert('diffDays-t='+diffDays+ 'diffDays1-t='+diffDays1);
		return true;
}

    if(!fechaayerymanana(false)){
		var htotal=$('#htotal').val();
        msgDate = 'Las papeletas se presentarán hasta '+htotal+' horas antes del día de hoy2.';
        bootbox.alert(msgDate);
        inputFocus = '#date1';    
        return false;
    }
    
	
	$(':file').change(function()
	{
		//obtenemos un array con los datos del archivo
		var file = $("#imagen")[0].files[0];
		//obtenemos el nombre del archivo
		var fileName = file.name;
		//obtenemos la extensión del archivo
		fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
		//obtenemos el tamaño del archivo
		var fileSize = file.size;
		//obtenemos el tipo de archivo image/png ejemplo
		var fileType = file.type;
	});
	
	bootbox.confirm({
		title: "Registrar Papeleta",
		//message: "Estimado (a) "+usuario+", ¿Desea registrar esta papeleta?",
		message: "¿Está  seguro de registrar la papeleta?",
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
				$('#dpx-motivo').val();
				// var texto_motivo = $( "#dpx-motivo option:selected" ).text();
				var value_motivo = $( "#dpx-motivo option:selected" ).val();
				//alert(value_motivo)
				var val_motivo =value_motivo.split("*");
				var valor_motivo = val_motivo[0];
				var dias=(val_motivo[1]);
				var serviciosporhora_obs = $('#serviciosporhora_obs').val();
				var justificacion =  $('#justificacion').val();
				var tipopermiso =  $('#tipopermiso').val();
				var date1 =  $('#date1').val();
				var datetime1 =  $('#datetime1').val();
				var datetime2 =  $('#datetime2').val();
				var origen_horas =  $('#origen_horas').val();
				var archivo_essalud = $('#archivo_essalud').val();
				var formData = new FormData($(".formulario")[0]);
				//alert(formData)
				var url = base_url+"Papeletas/registrarPapeleta";
				frm = { valor_motivo: valor_motivo,dias:val_motivo, serviciosporhora_obs: serviciosporhora_obs, justificacion: justificacion, tipopermiso:tipopermiso, date1:date1, datetime1:datetime1, datetime2:datetime2, origen_horas:origen_horas, archivo_essalud:archivo_essalud };
				$.ajax({
					url: url, 
					type: 'POST',
					dataType: 'html',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
				}).done(function(contextResponse, statusResponse, response) {
					cargarDiv();
					location.reload(true);
					
					$("#acceso_modal").modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
				})
			}
		}
	});
}

function devolverMinutos(horaMinutos)
{
	return (parseInt(horaMinutos.split(":")[0])*60)+parseInt(horaMinutos.split(":")[1]);
}

/*
function ver_valor(valor)
{
	console.log('funcion valor ',valor);
}
*/

$('#dpx-motivo').on('change', function(e) {

    $('#dpx-motivo').val();
   // var texto_motivo = $( "#dpx-motivo option:selected" ).text();
    var value_motivo = $( "#dpx-motivo option:selected" ).val();
	//alert(value_motivo)
    var val_motivo =value_motivo.split("*");
    var id = val_motivo[0];
    var texto= "Máximo "+val_motivo[1]+" horas por día!!";
     // var texto= texto_motivo+": Máximo "+val_motivo[1]+" horas por día!!";
     $('#dias').val(val_motivo[1]);
    $('#valor_motivo').val(val_motivo[0]);
 
    if(id == null){
        $('#archivo_essalud_container').hide();
        $('#serviciosporhora_obs_container').hide();
        $('#visualizar_archivo').hide();
         $('#Justificación_container').hide();

        return;
    }else if(id == 35){
        //bootbox.alert(value_motivo + ": maximo 3 horas por día!!");
        //document.getElementById("s_alerta").innerHTML = texto;
        $('#s_alerta').text(texto);
        $('#archivo_essalud_container').hide();
        $('#serviciosporhora_obs_container').hide();
		$('#serviciosporhora_obs').val('');
        $('#visualizar_archivo').hide();
        $('#Justificación_container').hide();
		$('#justificacion').val('');
        return;
    }else if(id == 19){
        //bootbox.alert(value_motivo + ": maximo 8 horas por día!");
         $('#s_alerta').html(texto);
        $('#archivo_essalud_container').show();
        $('#serviciosporhora_obs_container').show();
        $('#visualizar_archivo').show();
        $('#Justificación_container').show();
        return;
    }else if(id == 49){
        //bootbox.alert(value_motivo +": maximo 3 horas por día!");
         $('#s_alerta').html(texto);
        $('#archivo_essalud_container').show();
        $('#serviciosporhora_obs_container').hide();
		$('#serviciosporhora_obs').val('');
        $('#visualizar_archivo').show();
        $('#Justificación_container').hide();
		$('#justificacion').val('');
        return;
    }

    else if(id == 86){
        //bootbox.alert(value_motivo +": maximo 3 horas por día!");
        $('#s_alerta').html(texto);
        $('#archivo_essalud_container').hide();
        $('#serviciosporhora_obs_container').hide();
        $('#visualizar_archivo').hide();
        $('#Justificación_container').show();
        return;
    }

});

$('#tipopermiso').change();
$('#tipopermiso').on('change', function(e){
 var cod = $('#tipopermiso').val();
 var fecha = $('#date1').val();
 var origen = $('#origen_horas').val();
 var hini = $('#origen_ingreso').val();
 var hfin = $('#origen_fin').val();
 var value_tipopermiso = $( "#tipopermiso option:selected" ).text();
 var url_dest=base_url+"Papeletas/validarpapelet"; 

if(origen==1)
{	
	if(cod == 1){
	var texto= "Está permitido solo una papeleta por día";
		 $.ajax({
			  url: url_dest,
			  data: {'cod':cod,'datef':fecha},
			  type: 'POST',
			  success: function (data) {
				//alert (data)0;
			   if (data==0) {
				 $('#p_alerta').text(texto);
				 $('#btnRegistrar').show();
				 $('#datetime1').val(hini);
				 $('#datetime2').val('');
				 $("#datetime1").attr("readonly","readonly");
				 $("#datetime2").removeAttr("readonly");
				 //bootbox.alert(value_tipopermiso + ": Está permitido solo una papeleta por día");
				 return;
			   }
			   else{
				//document.getElementById("btnRegistrar").style.display="none";
			   // $('#btnRegistrar').hide();
			   $('#p_alerta').text(texto);
				//bootbox.alert("Está permitido solo una papeleta por día");
				 return;
			   }
			},
			  error: function() {
				 
				}
		   });
	 }
	 if(cod == 3){
	var texto= "Está permitido solo una papeleta por día";
		 $.ajax({
			  url: url_dest,
			  data: {'cod':cod,'datef':fecha},
			  type: 'POST',
			  success: function (data) {
			   if (data==0) {
				 $('#p_alerta').text(texto);
				 $('#btnRegistrar').show();
				 $('#datetime2').val(hfin);
				 $('#datetime1').val('');
				 $("#datetime2").attr("readonly","readonly");
				 $("#datetime1").removeAttr("readonly");
				 //bootbox.alert(value_tipopermiso + ": Está permitido solo una papeleta por día");
				 return;
			   }
			   else{
				//document.getElementById("btnRegistrar").style.display="none";
			   // $('#btnRegistrar').hide();
			   $('#p_alerta').text(texto);
				//bootbox.alert("Está permitido solo una papeleta por día");
				 return;
			   }
			  },
			  error: function() {
				 
				}
		   });
	 }

	if (cod==2){
		var texto= "Está permitido más de una papeleta por día";
		$('#p_alerta').text(texto);
		$('#btnRegistrar').show();
		$('#datetime2').val('');
		$('#datetime1').val('');
		$("#datetime1").removeAttr("readonly");
		$("#datetime2").removeAttr("readonly");
		//bootbox.alert(value_tipopermiso + ": Está permitido más de una papeleta por día")
		return;
	}
}
if (origen==2)
{
	if(cod == 1){
	var texto= "Está permitido solo una papeleta por día";
		 $.ajax({
			  url: url_dest,
			  data: {'cod':cod,'datef':fecha},
			  type: 'POST',
			  success: function (data) {
				//alert (data)0;
			   if (data==0) {
				 $('#p_alerta').text(texto);
				 $('#btnRegistrar').show();
				 //bootbox.alert(value_tipopermiso + ": Está permitido solo una papeleta por día");
				 return;
			   }
			   else{
				//document.getElementById("btnRegistrar").style.display="none";
			   // $('#btnRegistrar').hide();
			   $('#p_alerta').text(texto);
				//bootbox.alert("Está permitido solo una papeleta por día");
				 return;
			   }
			},
			  error: function() {
				 
				}
		   });
	 }
	 if(cod == 3){
	var texto= "Está permitido solo una papeleta por día";
		 $.ajax({
			  url: url_dest,
			  data: {'cod':cod,'datef':fecha},
			  type: 'POST',
			  success: function (data) {
			   if (data==0) {
				   $('#p_alerta').text(texto);
				 //$('#btnRegistrar').show();
				 //bootbox.alert(value_tipopermiso + ": Está permitido solo una papeleta por día");
				 return;
			   }
			   else{
				document.getElementById("btnRegistrar").style.display="none";
			   // $('#btnRegistrar').hide();
			   $('#p_alerta').text(texto);
				//bootbox.alert("Está permitido solo una papeleta por día");
				 return;
			   }
			  },
			  error: function() {
				 
				}
		   });
	 }

	if (cod==2){
		var texto= "Está permitido más de una papeleta por día";
		$('#p_alerta').text(texto);
		$('#btnRegistrar').show();
		//bootbox.alert(value_tipopermiso + ": Está permitido más de una papeleta por día")
		return;
	}
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

function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg': case 'pdf':
            return true;
        break;
        default:
            return false;
        break;
    }
}

function fs_numeros(e) {
	
        tecla = (document.all) ? e.keyCode : e.which; 

		if (tecla < 48 || tecla > 57) {
			return false;
			
		}
		
        if (tecla==8 || tecla!=13) return true;
}

function fs_hora(e) {
	
        tecla = (document.all) ? e.keyCode : e.which; 

		if (tecla < 48 || tecla > 57) {
			return false;
			
		}
		
        if (tecla==8 || tecla!=13) return true;
}

function dia_semana(fecha){ 
    fecha=fecha.split('/');
    if(fecha.length!=3){
            return null;
    }
    //Vector para calcular día de la semana de un año regular.
    var regular =[0,3,3,6,1,4,6,2,5,0,3,5]; 
    //Vector para calcular día de la semana de un año bisiesto.
    var bisiesto=[0,3,4,0,2,5,0,3,6,1,4,6]; 
    //Vector para hacer la traducción de resultado en día de la semana.
    var semana=['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    //Día especificado en la fecha recibida por parametro.
    var dia=fecha[0];
    //Módulo acumulado del mes especificado en la fecha recibida por parametro.
    var mes=fecha[1]-1;
    //Año especificado por la fecha recibida por parametros.
    var anno=fecha[2];
    //Comparación para saber si el año recibido es bisiesto.
    if((anno % 4 == 0) && !(anno % 100 == 0 && anno % 400 != 0))
        mes=bisiesto[mes];
    else
        mes=regular[mes];
    //Se retorna el resultado del calculo del día de la semana.
    return semana[Math.ceil(Math.ceil(Math.ceil((anno-1)%7)+Math.ceil((Math.floor((anno-1)/4)-Math.floor((3*(Math.floor((anno-1)/100)+1))/4))%7)+mes+dia%7)%7)];
}