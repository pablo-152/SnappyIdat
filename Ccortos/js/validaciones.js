//modal aparecer
const formulario = document.getElementById('pro-form');

function popupToggle(){
    const popup = document.getElementById('popup');
    popup.classList.toggle('active')
    formulario.reset();
    
    document.getElementById(`grupo__nombre`).classList.remove('success');
    document.getElementById(`grupo__nombre`).classList.remove('error');
    document.getElementById(`grupo__apellidop`).classList.remove('success');
    document.getElementById(`grupo__apellidop`).classList.remove('error');
    document.getElementById(`grupo__apellidom`).classList.remove('success');
    document.getElementById(`grupo__apellidom`).classList.remove('error');

    document.getElementById(`grupo__c_sexo_pers`).classList.remove('error');
    document.getElementById(`grupo__c_sexo_pers`).classList.remove('success');
    $('#grupo__c_sexo_pers').css("border","0px solid ");
    $('.maninput').css("color","black");
    $('.feminput').css("color","black");
    progressMessagetoggle = $("#progress-message");
    progressMessagetoggle.text("");

}
// validar logeo
const form = document.getElementById('form');
const username = document.getElementById('username');
const password = document.getElementById('password');
form.addEventListener('submit',(event)=>{
    event.preventDefault();
    validate();
})
const sendData = (usernameVal, sRate, count) =>{
    if(sRate === count){                    
            let timerInterval
            Swal.fire({
            title: 'Bien hecho! '+usernameVal,
            icon: 'success',
            html: 'Vas a entrar a la tienda virtual <b></b>',
            timer: 2000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                    b.textContent = Swal.getTimerLeft()
                    }
                }
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
            }).then((result) => {
            location.href = `intranetusu/index.html`
            })
    }
}
const successMsg = (usernameVal) => {
    let formCon = document.getElementsByClassName('inputBox');
    var count = formCon.length - 1;
    for( var i = 0; i < formCon.length; i++){
        if(formCon[i].className === "inputBox success"){
            var sRate = 0 + i;
            console.log(sRate);
            sendData(usernameVal, sRate, count);
        }else{
            return false;
        }
    }
}
const validate = () => {
        const usernameVal = username.value.trim();
        const passwordVal = password.value.trim();
        if(usernameVal === ""){
            setErrorMsg(username, 'Campo en blanco');
        } else if (usernameVal.length < 3) {
            setErrorMsg(username, '3 caracteres como minimo');
        } else {
            setSuccessMsg(username);
        }
        if(passwordVal === ""){
            setErrorMsg(password, 'Campo contraseña en blanco');
        } else if (passwordVal.length < 6) {
            setErrorMsg(password, 'Debe tener 6 dígitos');
        } else {
            setSuccessMsg(password);
        }
        successMsg(usernameVal);
}
function setErrorMsg(input, errormsgs){
    const formControl =input.parentElement;
    const small = formControl.querySelector('small');
    formControl.className = "inputBox error"; 
    small.innerText =errormsgs;
}
function setSuccessMsg(input){
    const formControl =input.parentElement;
    formControl.className = "inputBox success"; 
}



//avance de progress bar
var progress = $("#progress"),
progressMessage = $("#progress-message");
function progTo(value) {
    for(c=value-20;c<=value;c++) {
        progress.attr("value", c);
    }
}
$("#pro-form .progresoinput").keyup(function() {
    var numValid = 0;
    $("#pro-form .progresoinput[required]").each(function() {
        if (this.validity.valid) {
            numValid++;
        }
    });
    if (numValid == 0) {
        progTo(0);
        progressMessage.text("llena el formulario porfavor").css("color", "black").css("font-size", "11px");
    }
    if (numValid == 1) {
        progTo(10);
        progressMessage.text("Bien comenzaste").css("color", "black").css("font-size", "11px");
    }
    if (numValid == 2) {
        progTo(20);
        progressMessage.text("").css("color", "black").css("font-size", "11px");
    }
    if (numValid == 3) {
        progTo(30);
        progressMessage.text("").css("color", "black").css("font-size", "11px");
    }
    if (numValid == 4) {
        progTo(60);
        progressMessage.text("Bien vamos a la mitad").css("color", "black").css("font-size", "11px");
    }
   /* if (numValid == 5) {
        progTo(70);
        progressMessage.text("").css("color", "black").css("font-size", "11px");
    }
    */
    if (numValid == 5) {
        progTo(80);
        progressMessage.text("").css("color", "black").css("font-size", "11px");
    }
    if (numValid == 6) {
        progTo(90);
        progressMessage.text("").css("color", "black").css("font-size", "11px");
    }
    if (numValid == 7) {
        progTo(100);
        progressMessage.text("Listo, dale click a registrarse").css("color", "black").css("font-size", "11px");
    }
});
// mostrar data al finalizar
$(document).on('keyup', '.customInputs1', function() {
    var inputValue = $(this).val();
    $('#nombrel').html('<span>Nombre:</span>' + ' <span> ' + inputValue + '</span>');
});
$(document).on('keyup', '.customInputs2', function() {
    var inputValue = $(this).val();
    $('#apellidopl').html('<span>Apellido Paterno:</span>' + ' <span> ' + inputValue + '</span>');
});
$(document).on('keyup', '.customInputs3', function() {
    var inputValue = $(this).val();
$('#apellidoml').html('<span>Apellido Materno:</span>' + ' <span> ' + inputValue + '</span>');
});
$(document).on('change', '.customselect', function() {
    var selectvalue =$( "#myselect" ).val();
$('#selectdninumber').html(selectvalue);
});
$(document).on('change', '.customInputs4', function() {
    var selectvalue =$( "#myselect" ).val();
    var inputValue = $(this).val();
$('#dninumberl').html('<span id="selectdninumber" >'+selectvalue+':</span>' + ' <span> ' + inputValue + '</span>');
});
$(document).on('change', '.customInputsradio', function() {
    var inputValue = $('input[name=c_sexo_pers]:checked').val();
$('#sexol').html('<span>Sexo:</span>' + ' <span> ' + inputValue + '</span>');
});
$(document).on('keyup', '.customInputs5', function() {
    var inputValue = $(this).val();
$('#correol').html('<span>Correo:</span>' + ' <span> ' + inputValue + '</span>');
});
/*
$(document).on('keyup', '.customInputs6', function() {
    var inputValue = $(this).val();
$('#nombreusuariol').html('<span>Usuario:</span>' + ' <span> ' + inputValue + '</span>');
});
*/
$(document).on('keyup', '.customInputs7', function() {
    var inputValue = $(this).val();
    var count =inputValue.length;
    var words ="************************************************************************************************************************************************************************************************";
    var print   = words.substr(0,count)
$('#contraseñal').html('<span>Password:</span>' + ' <span> ' + print + '</span>');
});
//validar datos 
// keyup and blur events
       /*********** 1 ***********/
       const inputspr = document.querySelectorAll('.primeravistainputs');
       const expresiones = {
           // Letras y espacios, pueden llevar acentos.
           nombre:  /^[a-zA-ZÀ-ÿ\s]{1,40}$/, 
           apellidop:  /^[a-zA-ZÀ-ÿ\s]{1,40}$/, 
           apellidom:  /^[a-zA-ZÀ-ÿ\s]{1,40}$/,  // Letras y espacios, pueden llevar acentos.
       }

       const campospv = {
           nombre: false,
           apellidop: false,
           apellidom: false,
       }

       const validarFormularioprimeravista = (e) => {
           switch (e.target.name) {
               case "nombre":
                   validarCampoprimeravista(expresiones.nombre, e.target, 'nombre');
               break;
               case "apellidop":
                   validarCampoprimeravista(expresiones.apellidop, e.target, 'apellidop');
               break;
               case "apellidom":
                   validarCampoprimeravista(expresiones.apellidom, e.target, 'apellidom');
               break;
           }
       }
       const validarCampoprimeravista = (expresion, input, campo) => {
               if(expresion.test(input.value)){
                   document.getElementById(`grupo__${campo}`).classList.remove('error');
                   document.getElementById(`grupo__${campo}`).classList.add('success');
                 
                campospv[campo] = true;
               } else {
                   document.getElementById(`grupo__${campo}`).classList.add('error');
                   document.getElementById(`grupo__${campo}`).classList.remove('success');
                campospv[campo] = false;
               }
       }

       inputspr.forEach((input) => {
           input.addEventListener('keyup', validarFormularioprimeravista);
           input.addEventListener('blur', validarFormularioprimeravista);
       });



       /*********** 2 ***********/
       const inputsg = document.querySelectorAll('.segundavistainputs');
       const expresionesg = {
           dninumber: /^\d{1,8}$/ // 1 a 8 numeros.
       }
       const campossg = {
        dninumber: false,
       }
       const validarFormulariosegundavista = (e) => {
           switch (e.target.name) {
               case "dninumber":
                   validarCamposegundavista(expresionesg.dninumber, e.target, 'dninumber');
               break;
           }
       }
       const validarCamposegundavista = (expresion, input, campo) => {
               if(expresion.test(input.value)){
                   document.getElementById(`grupo__${campo}`).classList.remove('error');
                   document.getElementById(`grupo__${campo}`).classList.add('success'); 
                campossg[campo] = true;
               } else {
                   document.getElementById(`grupo__${campo}`).classList.add('error');
                   document.getElementById(`grupo__${campo}`).classList.remove('success');
                campossg[campo] = false;
               }
       }

       inputsg.forEach((input) => {
           input.addEventListener('keyup', validarFormulariosegundavista);
           input.addEventListener('blur', validarFormulariosegundavista);
       });


       function Validate(val) {
            v2 = $('input[name="c_sexo_pers"]:checked');
            flag2 = true;
            if(val>=2 || val==0) {
                if(v2.length == 0) {
                    $('#grupo__c_sexo_pers').css("border","1px solid red");
                    $('.maninput').css("color","red");
                    $('.maninput').css("position","relative");
                    $('.maninput').css("left","-23px");
                    $('.feminput').css("color","red");
                    $('.feminput').css("position","relative");
                    $('.feminput').css("left","-23px");
                    document.getElementById(`grupo__c_sexo_pers`).classList.add('error');
                    document.getElementById(`grupo__c_sexo_pers`).classList.remove('success');
                    flag2 = false;
                }
                else {
                    $('#grupo__c_sexo_pers').css("border","1px solid green");
                    $('.maninput').css("color","green");
                    $('.maninput').css("position","relative");
                    $('.maninput').css("left","-23px");
                    $('.feminput').css("color","green");
                    $('.feminput').css("position","relative");
                    $('.feminput').css("left","-23px");
                    document.getElementById(`grupo__c_sexo_pers`).classList.remove('error');
                    document.getElementById(`grupo__c_sexo_pers`).classList.add('success'); 
                    flag2 = true;
                }
            }
            flag = flag2;
            return flag;
        }

        function Validateselect(val) {
            v1 = document.getElementById("myselect");
            flag1 = true;
            if(val>=1 || val==0) {
                if(v1.value == "0") {
                v1.style.borderColor = "red";
                document.getElementById(`grupo__myselect`).classList.add('error');
                document.getElementById(`grupo__myselect`).classList.remove('success');
                flag1 = false;
                }
                else{
                v1.style.borderColor = "green";
                document.getElementById(`grupo__myselect`).classList.remove('error');
                document.getElementById(`grupo__myselect`).classList.add('success'); 
                flag1 = true;
                }
            }          
            flag = flag1 ;
            return flag;
        }

       /*********** 3 ***********/


const inputtr = document.querySelectorAll('.terceravistainputs');
const expresionestr = {
	password: /^.{4,12}$/, // 4 a 12 digitos.
    passworde: /^.{4,12}$/, // 4 a 12 digitos.

	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}
const campostr = {
	password: false,
	correo: false,
    password: false,

}
const validarFormulariotr = (e) => {
	switch (e.target.name) {
		case "contraseña":
			validarCampo(expresionestr.password, e.target, 'contraseña');
			validarPassword2();
		break;
		case "rcontraseña":
			validarPassword2(e.target);
		break;
		case "correo":
			validarCampo(expresionestr.correo, e.target, 'correo');
		break;
	}
}

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
        document.getElementById(`grupo__${campo}`).classList.remove('error');
        document.getElementById(`grupo__${campo}`).classList.add('success'); 
		campostr[campo] = true;
	} else {
        document.getElementById(`grupo__${campo}`).classList.add('error');
        document.getElementById(`grupo__${campo}`).classList.remove('success');
        $('#valcontr').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
        $('#smallcorreo').text("Ingrese un correo válido.").css("color", "#e74c3c");

        campostr[campo] = false;
	}
}

const validarPassword2 = (input) => {
	const inputPassword1 = document.getElementById('contraseña');
	const inputPassword2 = document.getElementById('rcontraseña');
	if(inputPassword1.value !== inputPassword2.value){
        document.getElementById(`grupo__rcontraseña`).classList.add('error');
        document.getElementById(`grupo__rcontraseña`).classList.remove('success');
        //document.getElementById('valcontr').text("Las contraseñas no son iguales").css("color", "red").css("font-size", "11px");
        $('#valcontrdos').text("Ambas contraseñas deben ser iguales").css("color", "#e74c3c");

		campostr['password'] = false;
	}else if($('#rcontraseña').val() === "") {
        document.getElementById(`grupo__rcontraseña`).classList.add('error');
        document.getElementById(`grupo__rcontraseña`).classList.remove('success');
        $('#valcontrdos').text("El campo no debe estar vacio").css("color", "#e74c3c");
        //$('#password').val('');
        //$('#rcontraseña').val('');
		campostr['password'] = false;
    }else if(expresionestr.password.test(rcontraseña.value) !== true) {
        document.getElementById(`grupo__rcontraseña`).classList.add('error');
        document.getElementById(`grupo__rcontraseña`).classList.remove('success');
        $('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "#e74c3c");
		campostr['password'] = false;
    } else {
        document.getElementById(`grupo__rcontraseña`).classList.remove('error');
        document.getElementById(`grupo__rcontraseña`).classList.add('success');
        campostr['password'] = true;
	}
}

inputtr.forEach((input) => {
	input.addEventListener('keyup', validarFormulariotr);
	input.addEventListener('blur', validarFormulariotr);
});
