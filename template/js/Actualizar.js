$(document).ready(function() {
   
	cargamotivo();
	
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




function cargamotivo()
{
	$('#dpx-motivo1').val();
   // var texto_motivo = $( "#dpx-motivo1 option:selected" ).text();
    var value_motivo = $( "#dpx-motivo1 option:selected" ).val();
	//alert(value_motivo)
    var val_motivo =value_motivo.split("*");
    var id = val_motivo[0];
    var texto= "Máximo "+val_motivo[1]+" horas por día!!";
     // var texto= texto_motivo+": Máximo "+val_motivo[1]+" horas por día!!";
    $('#valor_motivo').val(val_motivo[0]);
    $('#dias').val(val_motivo[1]);
 
    if(id == null){
        $('#archivo_essalud_containera1').hide();
		$('#archivo_essalud_containera').hide();
        $('#serviciosporhora_obs_containera').hide();
        $('#visualizar_archivo').hide();
         $('#Justificación_containera').hide();

        return;
    }else if(id == 35){
        //bootbox.alert(value_motivo + ": maximo 3 horas por día!!");
        //document.getElementById("s_alerta").innerHTML = texto;
        $('#s_alertaa').text(texto);
        $('#archivo_essalud_containera1').hide();
		$('#archivo_essalud_containera').hide();
        $('#serviciosporhora_obs_containera').hide();
        $('#visualizar_archivo').hide();
        $('#Justificación_containera').hide();
        return;
    }else if(id == 19){
        //bootbox.alert(value_motivo + ": maximo 8 horas por día!");
        $('#s_alertaa').html(texto);
        $('#archivo_essalud_containera1').show();
		$('#archivo_essalud_containera').show();
        $('#serviciosporhora_obs_containera').show();
        $('#visualizar_archivo').show();
        $('#Justificación_containera').show();
        return;
    }else if(id == 49){
        //bootbox.alert(value_motivo +": maximo 3 horas por día!");
		$('#s_alertaa').html(texto);
		$('#archivo_essalud_containera1').show();
		$('#archivo_essalud_containera').show();
        $('#serviciosporhora_obs_containera').hide();
        $('#visualizar_archivo').show();
        $('#Justificación_containera').hide();
        return;
    }
     else if(id == 86){
         $('#s_alertaa').html(texto);
        $('#archivo_essalud_containera1').hide();
		$('#archivo_essalud_containera').hide();
        $('#serviciosporhora_obs_containera').hide();
        $('#visualizar_archivo').hide();
        $('#Justificación_containera').show();
        return;
    }
}

function calcularpapeletas()
{
	var dateper = $('#datep').val();
	var cod = $('#tipopermiso1').val();
	var dato_act_o = $('#dato_act_o').val();
	var codi_permiso_o = $('#codi_permiso_o').val();
	var url_dest=base_url+"Papeletas/validarpapelet";	
	
	if (codi_permiso_o!=cod || dato_act_o!=dateper)
	{
		if(cod == 1 || cod == 3) {		
			var texto= "Está permitido solo una papeleta por día";		
			$.ajax({
				url: url_dest,
				data: {'cod':cod,'datef':dateper},
				method: 'post',
				dataType: 'json',  
				success: function (data) {
					var dato = data;				
					validapapeleta(dato);	 
				},
				error: function (err) {
					alert(err);
				}
			});
		}
		else
		{
			validapapeleta(0);
		}
	}
	else
	{
		validapapeleta(0);
	}
}

function validapapeleta(dato)
{
	var cant_papeleta=dato;
	var origen = $('#origen_horas').val();
	//alert(origen+'jjjjj');
	var fecha = $('#datep').val();
	var horaInicial=devolverMinutos($('#horaini').val());
    var horaFinal=devolverMinutos($('#horafin').val());
	var hora_ini_o=devolverMinutos($('#hora_ini_o').val());
    var hora_ter_o=devolverMinutos($('#hora_ter_o').val());
    var id_papeleta= $('#id_papeleta').val();
    
	var url_dest=base_url+"Papeletas/compararminutosactualizar";
	if (hora_ini_o!=horaInicial || hora_ter_o!=horaFinal)
	{
		if(origen==1)
		{
			$.ajax({
				url: url_dest,
				data: {'horaInicial':horaInicial,'horaFinal':horaFinal,'fecha':fecha, 'cant_papeleta':cant_papeleta, 'id_papeleta':id_papeleta},
				method: 'post',
				//dataType: 'json',
				success: function (data) {
					var datototal=data.split("*")
					var minutos = datototal[0];
					var cant_papeletan=datototal[1];
					is_valid_time2(cant_papeleta, minutos);	 
				},
				error: function (err) {
					alert(err);
				}
			});
		}
		if(origen==2)
		{
			is_valid_time2(cant_papeleta, 0);
		}
	}
	else
	{
		is_valid_time2(cant_papeleta, 0);	
	}
}

function is_valid_time2(cant_papeletas, horav) {
	var date_input2=$('#datep'); //our date input has the name "date"
	var container2=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
	date_input2.datepicker({
		format: 'dd-mm-yyyy',
		container: container2,
		todayHighlight: true,
		autoclose: true,
		leftArrow: '<i class="fa fa-long-arrow-left"></i>',
		rightArrow: '<i class="fa fa-long-arrow-right"></i>'
	});
	
	var fechaayerymanana = function (message){
		var split = date_input2.val().split("-");
		var datep = new Date(split[2], split[1]-1, split[0]);
		var now = new Date();
		var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		var diatexto=diasSemana[now.getDay()];
		var timeDiff = now.getTime() - datep.getTime();
		var diffDays1 = Math.floor(timeDiff / (1000 * 3600 * 24)); 
		if (diatexto=="Lunes" && diffDays1>2){
			var diffDays=diffDays1-2;
		}
		else
		{
			var diffDays=diffDays1;
		}
	
		if(diffDays<-1 || diffDays>1)
		{
			if(message)
			{
				bootbox.alert("Las papeletas se presentarán hasta de las 72 horas antes del día de hoy.");
				inputFocus = '#datep';  
				return false;
			}
			return false;
		}
		return true;
	}

	    /*var fechaayerymanana = function (message){
		var htotal=$('#htotal').val();

		horas=parseInt(htotal);
		//var split = date_input.val().split("-");
		var split = $('#datep').val().split("-");
		var datep = new Date(split[2], split[1]-1, split[0]);
		//alert(split[2],+ '-'+split[1]-1,+ '-'+split[0],);
		var now = new Date();
		var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
		var diatexto=diasSemana[now.getDay()];
		var timeDiff = now.getTime() - datep.getTime();
		var diffDays1 = Math.abs(Math.floor(timeDiff / (1000 * 3600 * 24)));

		var numdia= Math.round(horas/24);
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
				inputFocus = '#datep';
				return false;
			}
			//alert('diffDays='+diffDays+ 'diffDays1='+diffDays1); 
			return false;
		}
		//alert('diffDays-t='+diffDays+ 'diffDays1-t='+diffDays1);
		return true;
}*/



	

	date_input2.change(function(){
		fechaayerymanana(true);
	});

	var id = $('#dpx-motivo1').val();
	var datePerm = moment($('#datep').val(), 'DD-MM-YYYY');

	//if (!datePerm.isValid() || datePerm.year() !== moment().year())
	if (!datePerm.isValid() )	
	{
		msgDate = 'La fecha de permiso: no es valida.';
		inputFocus = '#datep';    
		return false;
	}
	
	var combo=  $('#dpx-motivo1').val();
	var origen = $('#origen_horas').val();
	var motivo=0;
	var motivoT=0;
	var value_motivo = $( "#dpx-motivo1 option:selected" ).val();
	//alert(value_motivo)
    var val_motivo =value_motivo.split("*");
    var id = val_motivo[0];
    var horasmaximo= val_motivo[1];
	
	var dateper = $('#datep').val();
    var val_fecper =dateper.split("-");
    var dia = val_fecper[0];
    var mes = val_fecper[1];
	var anio = val_fecper[2];
	var diaactu = val_fecper[0]+"/"+val_fecper[1]+"/"+val_fecper[2];
	
	if ($('#dpx-motivo1').val()==null)
	{
		msgDate = 'Seleccione motivo de salida.';
		bootbox.alert(msgDate);
		inputFocus = '#dpx-motivo1';
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
	
	if ($('#serviciosporhora_obsa').val().trim() === '' && motivo== 19)
	{
		msgDate = 'Ingrese el lugar de la comisión.';
		bootbox.alert(msgDate);
		document.getElementById("serviciosporhora_obsa").focus();
		return false;
	}
	
	if ($('#justificaciona').val().trim() === '' && motivo == 19)
	{
		msgDate = 'Ingrese justificacion.';
		bootbox.alert(msgDate);
		inputFocus = '#justificaciona';
		return false;
	}

	/*if ($('#archivo_essaluda').val() === '' && motivo == 19)
	{
		msgDate = 'Adjuntar archivo de Comisión.';
		bootbox.alert(msgDate);
		inputFocus = '#archivo_essaluda';
		return false;
	}

	
	if ($('#archivo_essaluda').val() === '' && motivo == 49)
	{
		msgDate = 'Adjuntar archivo de Essalud.';
		bootbox.alert(msgDate);
		inputFocus = '#archivo_essaluda';
		return false;
	}*/

	


/*	if(!fechaayerymanana(false)){     
		msgDate = 'las papeletas se registrarán dentro de las 48 horas.';
		inputFocus = '#datep';    
		return false;
	}*/

	if ($('#tipopermiso1').val().trim()==null){
		msgDate = 'Seleccione tipo de permiso.';
		inputFocus = '#tipopermiso1';
		return false;
	}
	
	if (dia_semana(diaactu) === 'Sábado' || dia_semana(diaactu) === 'Domingo')
    {
        msgDate = 'La fecha debe ser entre Lunes y Viernes';
        bootbox.alert(msgDate);
       	inputFocus = '#date1'; 
        return false;
    }
	
    /*if ($('#horaini').val()==null || $('#horaini').val()==""){
		msgDate = 'Debe registrar la hora de inicio.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }

    if ($('#horafin').val()==null || $('#horafin').val()==""){
		msgDate = 'Debe registrar la hora de término.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime2';
		return false;
    }*/

      if (origen==1 && ($('#horaini').val()==null || $('#horaini').val()=="")){
		msgDate = 'Debe registrar la hora de inicio.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime1';
		return false;
    }

    if (origen==1 &&  ($('#horafin').val()==null || $('#horafin').val()=="")){
		msgDate = 'Debe registrar la hora de término.';
		bootbox.alert(msgDate);
		//inputFocus = '#datetime2';
		return false;
    }

    var horaInicial=devolverMinutos($('#horaini').val());
    var horaFinal=devolverMinutos($('#horafin').val());
	var horaInicialO=devolverMinutos($('#hora_ingreso_o').val());
    var horaFinalO=devolverMinutos($('#hora_fin_o').val());	
	
    if (horaInicial>=horaFinal){
		msgDate = 'La Hora de Inicio tiene que ser inferior a la Hora de Término';
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
	
//	alert(id)
	bootbox.confirm({
		title: "Modificar Papeleta",
		//message: "Estimado (a) "+usuario+", ¿Desea actualizar esta papeleta?",
		message: "¿Está seguro de actualizar los datos de la papeleta?",
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
				
				$('#dpx-motivo1').val();
				// var texto_motivo = $( "#dpx-motivo option:selected" ).text();
				var value_motivo = $( "#dpx-motivo1 option:selected" ).val();
				//alert(value_motivo)
				var val_motivo =value_motivo.split("*");
				var valor_motivo = val_motivo[0];	
				var dias=(val_motivo[1]);					
				var serviciosporhora_obsa = $('#serviciosporhora_obsa').val();
				var justificaciona =  $('#justificaciona').val();
				var tipopermiso1 =  $('#tipopermiso1').val();
				var id_papeleta = $('#id_papeleta').val();
				var datep =  $('#datep').val();
				var horaini =  $('#horaini').val();
				var horafin =  $('#horafin').val();
				var archivo_essaluda = $('#archivo_essaluda').val();
				//alert(archivo_essaluda);
				//var archivo_salud = $('#archivo_salud').val();
				var formData = new FormData($(".formulario")[0]);
				var url = base_url+"Papeletas/actualizarPapeleta";
				frm = { valor_motivo: valor_motivo, dias:val_motivo,serviciosporhora_obsa: serviciosporhora_obsa, justificaciona: justificaciona, tipopermiso1:tipopermiso1, datep:datep, archivo_essaluda:archivo_essaluda, id_papeleta:id_papeleta,horaini:horaini,horafin:horafin};
				$.ajax({
					url: url, 
					type: 'POST',
					dataType: 'html',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success: function (data) {
					 cargarDiv();
					$("#acceso_modal_mod").modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					},
					error: function() {
					  // console.log();
					}
				});
			}
		}
	});/**/
}
function devolverMinutos(horaMinutos)
{
	return (parseInt(horaMinutos.split(":")[0])*60)+parseInt(horaMinutos.split(":")[1]);
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
	
 $('#dpx-motivo1').on('change', function(e) {
    $('#dpx-motivo1').val();
	//alert($('#dpx-motivo1').val())
   // var texto_motivo = $( "#dpx-motivo1 option:selected" ).text();
    var value_motivo = $( "#dpx-motivo1 option:selected" ).val();
	//alert(value_motivo)
    var val_motivo =value_motivo.split("*");
    var id = val_motivo[0];
    var texto= "Máximo "+val_motivo[1]+" horas por día!!";
     // var texto= texto_motivo+": Máximo "+val_motivo[1]+" horas por día!!";
    $('#valor_motivo').val(val_motivo[0]);

    $('#dias').val(val_motivo[1]);
    if(id == null){
        $('#archivo_essalud_containera1').hide();
		$('#archivo_essalud_containera').hide();
        $('#serviciosporhora_obs_containera').hide();
        $('#visualizar_archivo').hide();
         $('#Justificación_containera').hide();
        return;
    }else if(id == 35){
        //bootbox.alert(value_motivo + ": maximo 3 horas por día!!");
        //document.getElementById("s_alerta").innerHTML = texto;
        $('#s_alertaa').text(texto);
        $('#archivo_essalud_containera1').hide();
		$('#archivo_essalud_containera').hide();
        $('#serviciosporhora_obs_containera').hide();
        $('#visualizar_archivo').hide();
        $('#Justificación_containera').hide();
        return;
    }else if(id == 19){
        //bootbox.alert(value_motivo + ": maximo 8 horas por día!");
         $('#s_alertaa').html(texto);
        $('#archivo_essalud_containera1').show();
		$('#archivo_essalud_containera').show();
        $('#serviciosporhora_obs_containera').show();
        $('#visualizar_archivo').show();
        $('#Justificación_containera').show();
        return;
    }else if(id == 49){
        //bootbox.alert(value_motivo +": maximo 3 horas por día!");
		$('#s_alertaa').html(texto);
		$('#archivo_essalud_containera1').show();
		$('#archivo_essalud_containera').show();
        $('#serviciosporhora_obs_containera').hide();
        $('#visualizar_archivo').show();
        $('#Justificación_containera').hide();
        
        return;
    }
    
});

$('#tipopermiso1').on('change', function(e){
$('#tipopermiso1').val();
	var cod = $.trim($('#tipopermiso1').val());
	//alert(cod+'tipopermiso1');
	var fecha = $('#datep').val();
	//alert(fecha+'datepfin');
	//alert(cod+'tipop');
	//var origen = $('#origen_horas').val();
	var origen = $.trim($('#origen_horas').val());
	var hini = $('#hora_ingreso_o').val();
	var hfin = $('#hora_fin_o').val();
	//alert(hfin+'hora_ingreso_o');
	//alert(hini+'hora_ingreso_o');
	//alert(origen+'origen_horas');
 	//var hfin = $('#hora_fin_o').val();
	var value_tipopermiso1 = $( "#tipopermiso1 option:selected" ).text();
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
				//alert (data);
				if (data==0) {
					$('#btnActualizar').show();
					$('#p_alertaa').text(texto);
					$('#horaini').val(hini);
					$('#horafin').val('');
					$("#horaini").attr("readonly","readonly");
					$("#horafin").removeAttr("readonly");
					//alert (horaini);
					//bootbox.alert(value_tipopermiso1 + ": Está permitido solo una papeleta por día");
					return;
				}else

				{
					//document.getElementById("btnActualizar").style.display="none";
					$('#p_alertaa').text(texto);
					// $('#btnActualizar').hide();
					//bootbox.alert("Está permitido solo una papeleta por día");
					return false;
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
				//alert (data);
				if (data==0) {
					$('#btnActualizar').show();
					$('#p_alertaa').text(texto);
					$('#horafin').val(hfin);
					$('#horaini').val('');
					$("#horafin").attr("readonly","readonly");
					$("#horaini").removeAttr("readonly");
					//bootbox.alert(value_tipopermiso1 + ": Está permitido solo una papeleta por día");
					return;
				}
				else{
					//document.getElementById("btnActualizar").style.display="none";
					// $('#btnActualizar').hide();
					$('#p_alertaa').text(texto);
					//            bootbox.alert("Está permitido solo una papeleta por día");
					return;
				}
			},
			error: function() {			
			}
		});
	}
	
	if (cod==2){
		var texto= "Está permitido más de una papeleta por día";	 
		$('#btnActualizar').show();
		$('#p_alertaa').text(texto);
		$('#horaini').val('');
		$('#horafin').val('');
		$("#horaini").removeAttr("readonly");
		$("#horafin").removeAttr("readonly");
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
				//alert (data);
				if (data==0) {
					$('#btnActualizar').show();
					$('#p_alertaa').text(texto);
					$("#horaini").attr("readonly","readonly");
					$("#horafin").attr("readonly","readonly");
					return;
				}
				else{$('#p_alertaa').text(texto);
					return false;
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
			  //	alert (data);
			   if (data==0) {
				   $('#btnActualizar').show();
					$('#p_alertaa').text(texto);
					$("#horaini").attr("readonly","readonly");
					$("#horafin").attr("readonly","readonly");
					return;
				 return;
			   }
			   else{$('#p_alertaa').text(texto);

					return;
				}
			  },
			  error: function() {
				 
				}
		   });
	 }

	if (cod==2){
		var texto= "Está permitido más de una papeleta por día";	 
		$('#btnActualizar').show();
		$('#p_alertaa').text(texto);
		$("#horaini").attr("readonly","readonly");
		$("#horafin").attr("readonly","readonly");
		
		//bootbox.alert(value_tipopermiso1 + ": Está permitido más de una papeleta por día")
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
