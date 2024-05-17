const slidePage = document.querySelector(".slide-page");
const nextBtnFirst = document.querySelector(".firstNext");
const prevBtnSec = document.querySelector(".prev-1");
const nextBtnSec = document.querySelector(".next-1");
const prevBtnThird = document.querySelector(".prev-2");
const nextBtnThird = document.querySelector(".next-2");
const prevBtnFourth = document.querySelector(".prev-3");
const submitBtn = document.querySelector(".submit");
const progressText = document.querySelectorAll(".step p");
const progressCheck = document.querySelectorAll(".step .check");
const bullet = document.querySelectorAll(".step .bulletcapas");
let current = 1;

const nombre = document.getElementById('nombre'); 
const apellidop = document.getElementById('apellidop'); 
const apellidom = document.getElementById('apellidom'); 

nextBtnFirst.addEventListener("click", function(event){
  event.preventDefault();
    if ($('#nombre').val().trim() === '' && $('#apellidop').val().trim() === '' && $('#apellidom').val().trim() === '') {     
      progressMessage.text("No dejes los campos en blanco ").css("color", "red").css("font-size", "11px");
      $(".primerboton").css("background", "#0463ab");
      document.getElementById(`grupo__nombre`).classList.add('error');
      document.getElementById(`grupo__nombre`).classList.remove('success');
      document.getElementById(`grupo__apellidop`).classList.add('error');
      document.getElementById(`grupo__apellidop`).classList.remove('success');
      document.getElementById(`grupo__apellidom`).classList.add('error');
      document.getElementById(`grupo__apellidom`).classList.remove('success');


    }else if($('#nombre').val().trim() === '' && $('#apellidop').val().trim() === ''  ){
      progressMessage.text("No dejes los campos nombre y apelllido paterno en blanco ").css("color", "red").css("font-size", "11px");
      $(".primerboton").css("background", "#0463ab");
      document.getElementById(`grupo__nombre`).classList.add('error');
      document.getElementById(`grupo__nombre`).classList.remove('success');
      document.getElementById(`grupo__apellidop`).classList.add('error');
      document.getElementById(`grupo__apellidop`).classList.remove('success');

      //document.getElementById(`grupo__apellidom`).classList.remove('error');
      //document.getElementById(`grupo__apellidom`).classList.remove('success');

    }else if($('#apellidop').val().trim() === ''  && $('#apellidom').val().trim() === ''){
      progressMessage.text("No dejes los campos apellido paterno y materno en blanco ").css("color", "red").css("font-size", "11px");
      $(".primerboton").css("background", "#0463ab");
      document.getElementById(`grupo__apellidop`).classList.add('error');
      document.getElementById(`grupo__apellidop`).classList.remove('success');
      document.getElementById(`grupo__apellidom`).classList.add('error');
      document.getElementById(`grupo__apellidom`).classList.remove('success');

      //document.getElementById(`grupo__nombre`).classList.remove('error');
      //document.getElementById(`grupo__nombre`).classList.remove('success');

    }else if($('#apellidom').val().trim() === '' && $('#nombre').val().trim() === ''){
      progressMessage.text("No dejes los campos nombre y apellido materno en blanco ").css("color", "red").css("font-size", "11px");
      $(".primerboton").css("background", "#0463ab");
      document.getElementById(`grupo__apellidom`).classList.add('error');
      document.getElementById(`grupo__apellidom`).classList.remove('success');
      document.getElementById(`grupo__nombre`).classList.add('error');
      document.getElementById(`grupo__nombre`).classList.remove('success');

    }else if($('#apellidom').val().trim() === ''){
      progressMessage.text("No deje el campo apellido materno en blanco ").css("color", "red").css("font-size", "11px");
      $(".primerboton").css("background", "#0463ab");
      document.getElementById(`grupo__apellidom`).classList.add('error');
      document.getElementById(`grupo__apellidom`).classList.remove('success');

    }else if($('#nombre').val().trim() === ''){
      progressMessage.text("No dejes el campo nombre en blanco ").css("color", "red").css("font-size", "11px");
      $(".primerboton").css("background", "#0463ab");
      document.getElementById(`grupo__nombre`).classList.add('error');
      document.getElementById(`grupo__nombre`).classList.remove('success');

    }else if($('#apellidop').val().trim() === ''){
      progressMessage.text("No dejes el campo apellido paterno en blanco ").css("color", "red").css("font-size", "11px");
      $(".primerboton").css("background", "#0463ab");
      document.getElementById(`grupo__apellidop`).classList.add('error');
      document.getElementById(`grupo__apellidop`).classList.remove('success');

    }else if(expresiones.nombre.test(nombre.value) !== true) {
      document.getElementById(`grupo__nombre`).classList.add('error');
      document.getElementById(`grupo__nombre`).classList.remove('success');
      //$('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
    }else if(expresiones.apellidop.test(apellidop.value) !== true) {
      document.getElementById(`grupo__apellidop`).classList.add('error');
      document.getElementById(`grupo__apellidop`).classList.remove('success');
      //$('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
    }else if(expresiones.apellidom.test(apellidom.value) !== true) {
      document.getElementById(`grupo__apellidom`).classList.add('error');
      document.getElementById(`grupo__apellidom`).classList.remove('success');
      //$('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
    }else {
      slidePage.style.marginLeft = "-25%";
      bullet[current - 1].classList.add("active");
      progressCheck[current - 1].classList.add("active");
      progressText[current - 1].classList.add("active");
      current += 1;
      ///
      $(".primerboton").css("background", "#ab0f46");
      progressMessagetoggle.text("");
    }
});

/**************************************************************************/

nextBtnSec.addEventListener("click", function(event){
  event.preventDefault();
  if ($('#myselect').val() == '0' && $('#dninumber').val().trim() === '' && $('input[name="c_sexo_pers"]:checked').length == 0) {     
    progressMessage.text("No dejes los campos en blanco ").css("color", "red").css("font-size", "11px");
    $(".segundoboton").css("background", "#0463ab");
    document.getElementById(`grupo__myselect`).classList.add('error');
    document.getElementById(`grupo__myselect`).classList.remove('success');
    document.getElementById(`grupo__dninumber`).classList.add('error');
    document.getElementById(`grupo__dninumber`).classList.remove('success');
    document.getElementById(`grupo__c_sexo_pers`).classList.add('error');
    document.getElementById(`grupo__c_sexo_pers`).classList.remove('success');
    $('#grupo__c_sexo_pers').css("border","1px solid red");
    $('.maninput').css("color","red");
    $('.maninput').css("position","relative");
    $('.maninput').css("left","-23px");
    $('.feminput').css("color","red");
    $('.feminput').css("position","relative");
    $('.feminput').css("left","-23px");

  }else if($('#myselect').val() == '0' && $('#dninumber').val().trim() === ''){
    progressMessage.text("No dejes los campos tipo de documento y número de documento en blanco ").css("color", "red").css("font-size", "11px");
    $(".segundoboton").css("background", "#0463ab");
    document.getElementById(`grupo__myselect`).classList.add('error');
    document.getElementById(`grupo__myselect`).classList.remove('success');
    document.getElementById(`grupo__dninumber`).classList.add('error');
    document.getElementById(`grupo__dninumber`).classList.remove('success');


  }else if($('#dninumber').val().trim() === '' && $('input[name="c_sexo_pers"]:checked').length == 0){
    progressMessage.text("No dejes los campos número de documento y sexo en blanco ").css("color", "red").css("font-size", "11px");
    $(".segundoboton").css("background", "#0463ab");
    document.getElementById(`grupo__dninumber`).classList.add('error');
    document.getElementById(`grupo__dninumber`).classList.remove('success');
    $('#grupo__c_sexo_pers').css("border","1px solid red");
    $('.maninput').css("color","red");
    $('.maninput').css("position","relative");
    $('.maninput').css("left","-23px");
    $('.feminput').css("color","red");
    $('.feminput').css("position","relative");
    $('.feminput').css("left","-23px");

  }else if($('input[name="c_sexo_pers"]:checked').length == 0){
    progressMessage.text("No deje el campo sexo en blanco ").css("color", "red").css("font-size", "11px");
    $(".segundoboton").css("background", "#0463ab");
    $('#grupo__c_sexo_pers').css("border","1px solid red");
    $('.maninput').css("color","red");
    $('.maninput').css("position","relative");
    $('.maninput').css("left","-23px");
    $('.feminput').css("color","red");
    $('.feminput').css("position","relative");
    $('.feminput').css("left","-23px");

  }else if($('#myselect').val() == '0'){
    progressMessage.text("No dejes el campo tipo de documento en blanco ").css("color", "red").css("font-size", "11px");
    $(".segundoboton").css("background", "#0463ab");
    document.getElementById(`grupo__myselect`).classList.add('error');
    document.getElementById(`grupo__myselect`).classList.remove('success');

  }else if($('#dninumber').val().trim() === ''){
    progressMessage.text("No dejes el campo número de documento en blanco ").css("color", "red").css("font-size", "11px");
    $(".segundoboton").css("background", "#0463ab");
    document.getElementById(`grupo__dninumber`).classList.add('error');
    document.getElementById(`grupo__dninumber`).classList.remove('success');

  }else if($('input[name="c_sexo_pers"]:checked').length == 0 && $('#myselect').val() == '0'){
    progressMessage.text("No dejes los campos tipo de documento y sexo en blanco ").css("color", "red").css("font-size", "11px");
    $(".segundoboton").css("background", "#0463ab");

    document.getElementById(`grupo__myselect`).classList.add('error');
    document.getElementById(`grupo__myselect`).classList.remove('success');
    $('#grupo__c_sexo_pers').css("border","1px solid red");
    $('.maninput').css("color","red");
    $('.maninput').css("position","relative");
    $('.maninput').css("left","-23px");
    $('.feminput').css("color","red");
    $('.feminput').css("position","relative");
    $('.feminput').css("left","-23px");
  }
  else {
    slidePage.style.marginLeft = "-50%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
    $(".segundoboton").css("background", "#ab0f46");
    progressMessagetoggle.text("");
  }
});



const correo = document.getElementById('correo');
const contraseña = document.getElementById('contraseña');
const rcontraseña = document.getElementById('rcontraseña');
nextBtnThird.addEventListener("click", function(event){

  event.preventDefault();
  if(expresionestr.passworde.test(rcontraseña.value) !== true && expresionestr.password.test(contraseña.value) !== true && expresionestr.correo.test(correo.value) !== true) {
    document.getElementById(`grupo__correo`).classList.add('error');
    document.getElementById(`grupo__correo`).classList.remove('success');
    document.getElementById(`grupo__contraseña`).classList.add('error');
    document.getElementById(`grupo__contraseña`).classList.remove('success');
    document.getElementById(`grupo__rcontraseña`).classList.add('error');
    document.getElementById(`grupo__rcontraseña`).classList.remove('success');
    $(".tercerboton").css("background", "#0463ab");

    //$('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
  }else if(expresionestr.password.test(contraseña.value) !== true && expresionestr.passworde.test(rcontraseña.value) !== true) {
    document.getElementById(`grupo__contraseña`).classList.add('error');
    document.getElementById(`grupo__contraseña`).classList.remove('success');
    document.getElementById(`grupo__rcontraseña`).classList.add('error');
    document.getElementById(`grupo__rcontraseña`).classList.remove('success');
    $(".tercerboton").css("background", "#0463ab");
    //$('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
  }else if(expresionestr.correo.test(correo.value) !== true) {
    document.getElementById(`grupo__correo`).classList.add('error');
    document.getElementById(`grupo__correo`).classList.remove('success');
    $(".tercerboton").css("background", "#0463ab");

    //$('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
  }else if(expresionestr.password.test(contraseña.value) !== true) {
    document.getElementById(`grupo__contraseña`).classList.add('error');
    document.getElementById(`grupo__contraseña`).classList.remove('success');
    $(".tercerboton").css("background", "#0463ab");

    //$('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
  }else if(expresionestr.passworde.test(rcontraseña.value) !== true) {
    document.getElementById(`grupo__rcontraseña`).classList.add('error');
    document.getElementById(`grupo__rcontraseña`).classList.remove('success');
    $(".tercerboton").css("background", "#0463ab");

    //$('#valcontrdos').text("La contraseña tiene que ser de 4 a 12 dígitos").css("color", "red");
  }else {
    slidePage.style.marginLeft = "-75%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
    ///
    $(".tercerboton").css("background", "#ab0f46");
    progressMessagetoggle.text("");
  }

});


submitBtn.addEventListener("click", function(){
  Insert_Usuario();
  bullet[current - 1].classList.add("active");
  progressCheck[current - 1].classList.add("active");
  progressText[current - 1].classList.add("active");
  current += 1;

});

function Insert_Usuario(){
  var dataString = $("#pro-form").serialize();
  //var url="<?php echo site_url(); ?>Ingreso/Validacion";
    if (Valida_Usuario()) {
                    //alert("Si existe");
                //$('#pro-form').submit();
                //window.location = "intranetusu/index.html";
                //location.href = `intranetusu/index.html`  

                setTimeout(function(){
                  //alert("Your Form Successfully Signed up");
                                      let timerInterval
                                      Swal.fire({
                                      //title: 'Bien hecho! '+usernameVal,
                                      title: 'Bien hecho!',
                                      icon: 'success',
                                      html: 'Redirecionando <b></b>',
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
                },1000);
    }else{
  }
}

function Valida_Usuario() {

  /*
  if($('#nombre').val().trim() === '') {
    alert('¡UPS! \rDebes ingresar tu Nombre');
    return false;
    }
  if($('#apellidop').val().trim() === '') {
    alert('¡UPS! \rDebes ingresar tu Apellido Paterno');
    return false;
    }
  if($('#apellidom').val().trim() === '') {
    alert('¡UPS! \rDebes ingresar tu Apellido Materno');
    return false;
    }
  if($('#myselect').val() == '') {
    alert('¡UPS! \rTienes que seleccionar un tipo de documento');
    return false;
    }
  if($('#dninumber').val().trim() === '') {
    alert('¡UPS! \rDebes ingresar tu nùmero de DNI');
    return false;
    }
  var condiciones = $("#c_sexo_pers").is(":checked");
  if (!condiciones) {
      alert("¡UPS! \rDebes seleccionar tu sexo.");
      return false;
  }

  if($('#correo').val().trim() === '') {
    alert('¡UPS! \rDebes ingresar tu correo');
    return false;
    }
  if($('#contraseña').val().trim() === '') {
    alert('Las contraseñas no deben estar vacías');
    $('#contraseña').val('');
    $('#rcontraseña').val('');
    return false;
    }
  if($('#contraseña').val() != $('#rcontraseña').val()) {
    alert('Las contraseñas deben ser iguales');
    $('#contraseña').val('');
    $('#rcontraseña').val('');
    return false;
  }
  if ($('#contraseña').val().length<4){
    alert('Contraseña debe tener mínimo 4 dígitos');
    return false;
  }
  if($('#rcontraseña').val().trim() === "") {
      alert('Las contraseñas no deben estar vacías');
      $('#contraseña').val('');
      $('#rcontraseña').val('');
    // inputFocus = '#password';
      return false;
  }
  */
  return true;
}




prevBtnSec.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "0%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});
prevBtnThird.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-25%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});
prevBtnFourth.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-50%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});
