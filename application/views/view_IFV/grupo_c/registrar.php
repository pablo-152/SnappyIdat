<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Grupo (Nuevo)</b></span></h4>
        </div>
      </div>

      <div class="heading-elements">
        <div class="heading-btn-group"> 
            <a type="button" href="<?= site_url('AppIFV/Grupo_C') ?>">
              <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
            </a>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
      <div class="col-md-12 row">
        <div class="form-group col-md-1">
          <label class="control-label text-bold">Código:</label>
          <input type="text" class="form-control" id="cod_grupo" name="cod_grupo" placeholder="Código" maxlength="6">
        </div>

        <div class="form-group col-md-1">
          <label class="control-label text-bold">Grupo:</label>
          <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo">
        </div>

        <div class="form-group col-md-4">
          <label class="control-label text-bold">Especialidad:</label>
          <select class="form-control" id="id_especialidad" name="id_especialidad" onchange="Grupo_Modulo();">
            <option value="0" >Seleccione</option>
            <?php foreach($list_especialidad as $list){ ?>
                <option value="<?php echo $list['id_especialidad']; ?>"><?php echo $list['nom_especialidad']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div id="grupo_modulo" class="form-group col-md-2">
          <label class="control-label text-bold">Modulo:</label>
          <select class="form-control" id="id_modulo" name="id_modulo">
            <option value="0">Seleccione</option>
          </select>
        </div>

        <div id="grupo_ciclo" class="form-group col-md-2">
          <label class="control-label text-bold">Ciclo:</label>
          <select class="form-control" id="id_ciclo" name="id_ciclo">
            <option value="0">Seleccione</option> 
          </select>
        </div>
      </div>

      <div class="col-md-12 row">
          <div class="form-group col-md-1">
              <label>Año:</label>
              <select class="form-control" id="anio" name="anio">
                  <option value="0">Seleccione</option>
              </select>
          </div>
        <div class="form-group col-md-1">
            <input type="hidden" id="list_semanas" value="<?php echo htmlspecialchars(json_encode($list_semanas)); ?>">
          <label class="control-label text-bold">Sem.&nbsp;Ini.:</label>
          <select class="form-control" id="semana_inicio" name="semana_inicio">
            <option value="0">Seleccione</option>
          </select>  
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Inicio Clases:</label>
          <input type="date" class="form-control" id="inicio_clase" name="inicio_clase">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Fin Clases:</label>
          <input type="date" class="form-control" id="fin_clase" name="fin_clase">
        </div>

        <div id="grupo_turno" class="form-group col-md-2">
          <label class="control-label text-bold">Turno:</label>
          <select class="form-control" id="id_turno" name="id_turno">
            <option value="0">Seleccione</option>
          </select>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Sección:</label>
          <select class="form-control" id="id_seccion" name="id_seccion">
            <option value="0">Seleccione</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
            <option value="H">H</option>
            <option value="I">I</option>
            <option value="J">J</option>
            <option value="K">K</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="N">N</option>
            <option value="O">O</option>
            <option value="P">P</option>
            <option value="Q">Q</option>
            <option value="R">R</option>
            <option value="S">S</option> 
            <option value="T">T</option>
            <option value="U">U</option>
            <option value="V">V</option>
            <option value="W">W</option>
            <option value="X">X</option>
            <option value="Y">Y</option>
            <option value="Z">Z</option>
          </select>
        </div>

        <div id="grupo_salon" class="form-group col-md-2">
          <label class="control-label text-bold">Salón:</label>
          <select class="form-control" id="id_salon" name="id_salon">
            <option value="0" >Seleccione</option> 
          </select>
        </div>
      </div>

      <div class="col-md-12 row esconder_examen">
        <div class="form-group col-md-10">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Inicio Campaña:</label>
          <input type="date" class="form-control" id="inicio_campania" name="inicio_campania">
        </div>
      </div>

      <div class="col-md-12 row esconder_examen">
        <div class="form-group col-md-2">
          <label class="control-label text-bold">Examenes Admisión:</label>
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Primer Examen</label>
          <input type="date" class="form-control" id="primer_examen" name="primer_examen">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Segundo Examen</label>
          <input type="date" class="form-control" id="segundo_examen" name="segundo_examen">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Tercer Examen</label>
          <input type="date" class="form-control" id="tercer_examen" name="tercer_examen">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Cuarto Examen</label>
          <input type="date" class="form-control" id="cuarto_examen" name="cuarto_examen">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Quinto Examen</label>
          <input type="date" class="form-control" id="quinto_examen" name="quinto_examen">
        </div>
      </div>

      <div id="parte_media" class="esconder_examen">
        <div class="col-md-12 row" style="margin-top:25px;">
          <?php $i=1; while($i<=20){ ?>
            <div class="form-group" style="width:4%;text-align:center;display:inline-block;">
              <label class="control-label text-bold">S<?php echo $i; ?></label>
              <input type="text" class="form-control solo_numeros" id="s<?php echo $i; ?>" name="s<?php echo $i; ?>" placeholder="S<?php echo $i; ?>">
            </div>
          <?php $i++; } ?>
          <div class="form-group" style="width:4%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">+1</label>
            <input type="text" class="form-control solo_numeros" id="mas1" name="mas1" placeholder="+1">
          </div>
        </div>

        <div class="col-md-12 row">
          <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Matriculados</label>
            <input type="text" class="form-control solo_numeros" id="c_matriculados_1" name="c_matriculados_1" placeholder="Matriculados">
          </div>

          <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Proyección</label>
            <input type="text" class="form-control solo_numeros" id="c_proyeccion" name="c_proyeccion" placeholder="Proyección">
          </div>

          <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Postulados</label>
            <input type="text" class="form-control solo_numeros" id="c_postulados" name="c_postulados" placeholder="Postulados">
          </div>

          <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Rechazados</label>
            <input type="text" class="form-control solo_numeros" id="c_rechazados" name="c_rechazados" placeholder="Rechazados">
          </div>

          <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Admitidos</label>
            <input type="text" class="form-control solo_numeros" id="c_admitidos" name="c_admitidos" placeholder="Admitidos">
          </div>

          <div class="form-group" style="width:10%;text-align:center;display:inline-block;">
            <label class="control-label text-bold">Matriculados</label>
            <input type="text" class="form-control solo_numeros" id="c_matriculados_2" name="c_matriculados_2" placeholder="Matriculados">
          </div>
        </div>
      </div>

      <div class="col-md-12 row" style="margin-top:25px;">
        <div class="form-group col-md-2">
          <label class="control-label text-bold">Matricula Regular Inicio</label>
          <input type="date" class="form-control" id="matricula_regular_ini" name="matricula_regular_ini">
        </div>

        <div class="form-group col-md-2">
          <label class="control-label text-bold">Matricula Regular Fin</label>
          <input type="date" class="form-control" id="matricula_regular_fin" name="matricula_regular_fin">
        </div>

        <div class="form-group col-md-2 esconder_extemporanea">
          <label class="control-label text-bold">Matricula Extemporanea Inicio</label>
          <input type="date" class="form-control" id="matricula_extemporanea_ini" name="matricula_extemporanea_ini">
        </div>

        <div class="form-group col-md-2 esconder_extemporanea">
          <label class="control-label text-bold">Matricula Extemporanea Fin</label>
          <input type="date" class="form-control" id="matricula_extemporanea_fin" name="matricula_extemporanea_fin">
        </div>
      </div>
      
      <div class="modal-footer"> 
        <button type="button" class="btn btn-primary" onclick="Insert_Grupo_C();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Grupo_C') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#grupos").addClass('active');
    $("#hgrupos").attr('aria-expanded', 'true');
    $("#grupos_c").addClass('active');
		document.getElementById("rgrupos").style.display = "block";

    Esconder();
  });
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>

<script>
  $('.solo_numeros').bind('keyup paste', function(){ 
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  function Grupo_Modulo(){
    Cargando();
    
    var id_especialidad = $('#id_especialidad').val();
    var url = "<?php echo site_url(); ?>AppIFV/Grupo_Modulo";
    
    $.ajax({
      type:"POST",
      url: url,
      data: {'id_especialidad':id_especialidad}, 
      success:function (resp) {
        $('#grupo_modulo').html(resp);
        $('#grupo_ciclo').html('<label class="control-label text-bold">Ciclo</label><select class="form-control" id="id_ciclo" name="id_ciclo"><option value="0">Seleccione</option></select>')
        Grupo_Turno(); 
        Grupo_Salon();
      }
    });
  }

  function Grupo_Ciclo(){
    Cargando();

    Parte_Media();
    
    var id_modulo = $('#id_modulo').val().split('-');
    var url = "<?php echo site_url(); ?>AppIFV/Grupo_Ciclo";
    
    $.ajax({
      type:"POST",
      url: url,
      data: {'id_modulo':id_modulo[0]},
      success:function (resp) {
        $('#grupo_ciclo').html(resp);
      }
    });
  }

  function Grupo_Turno(){
    Cargando();
    
    var id_especialidad = $('#id_especialidad').val();
    var url = "<?php echo site_url(); ?>AppIFV/Grupo_Turno";
    
    $.ajax({
      type:"POST",
      url: url,
      data: {'id_especialidad':id_especialidad},
      success:function (resp) {
        $('#grupo_turno').html(resp);
      }
    });
  }

  function Grupo_Salon(){
    Cargando();
    
    var id_especialidad = $('#id_especialidad').val();
    var url = "<?php echo site_url(); ?>AppIFV/Grupo_Salon";
    
    $.ajax({
      type:"POST",
      url: url,
      data: {'id_especialidad':id_especialidad},
      success:function (resp) {
        $('#grupo_salon').html(resp);
      }
    });
  }
  
  function Parte_Media(){
    Cargando();

    var grupo = $('#grupo').val();
    var id_especialidad = $('#id_especialidad').val();
    var id_modulo = $('#id_modulo').val().split('-');
    var url = "<?php echo site_url(); ?>AppIFV/Parte_Media";
    
    $.ajax({
      type:"POST",
      url: url,
      data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo[0]},
      success:function (resp) {
        $('#parte_media').html(resp);
      }
    });
  }
  
  function Esconder(){ 
    Cargando();

    var modulo = $('#id_modulo').val().split('-');
    var ciclo = $('#id_ciclo').val().split('-');

    if(modulo[1]=="M1" && ciclo[1]=="C1"){
      $('.esconder_extemporanea').hide();
      $('.esconder_examen').show();
    }else{
      $('.esconder_extemporanea').show();
      $('.esconder_examen').hide();
    }
  }

  function validar_Archivo_Adjunto(v){
    var archivoInput = document.getElementById(v);
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.png)$/i;
    if(!extPermitidas.exec(archivoRuta)){
        Swal({
            title: 'Archivo Denegado',
            text: "Asegurese de ingresar foto con extensiones .png.",
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        }); 
        archivoInput.value = '';
        return false;
    }
  }

  function Valida_Horario_Pdf(v){
    var archivoInput = document.getElementById(v);
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.pdf)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      Swal({
          title: 'Archivo Denegado',
          text: "Asegurese de ingresar foto con extensiones .pdf.",
          type: 'error',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK',
      }); 
      archivoInput.value = '';
      return false;
    }
  }

  function Insert_Grupo_C(){
    Cargando();

    var dataString = new FormData(document.getElementById('formulario'));
    var url="<?php echo site_url(); ?>AppIFV/Insert_Grupo_C";

    if (Valida_Insert_Grupo_C()) {
      $.ajax({
          type:"POST",
          url: url,
          data:dataString, 
          processData: false,
          contentType: false,
          success:function (data) {
            if(data=="error"){
              Swal({
                  title: 'Registro Denegado',
                  text: "¡El registro ya existe!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              }); 
            }else{
              window.location = "<?php echo site_url(); ?>AppIFV/Grupo_C";
            }
          }
      });
    }
  }

  function Valida_Insert_Grupo_C() {
    if($('#cod_grupo').val().trim() === ''){
      Swal(
          'Ups!',
          'Debe ingresar Código.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#grupo').val().trim() === ''){
      Swal(
          'Ups!',
          'Debe ingresar Grupo.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_especialidad').val().trim() === '0'){
      Swal(
          'Ups!',
          'Debe seleccionar Especialidad.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_modulo').val().trim() === '0'){
      Swal(
          'Ups!',
          'Debe seleccionar Modulo.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_ciclo').val().trim() === '0'){
      Swal(
          'Ups!',
          'Debe seleccionar Ciclo.', 
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#inicio_clase').val().trim() === ''){
      Swal(
          'Ups!',
          'Debe ingresar Inicio Clases.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#fin_clase').val().trim() === ''){
      Swal(
          'Ups!',
          'Debe ingresar Fin Clases.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_turno').val().trim() === '0'){
      Swal(
          'Ups!',
          'Debe seleccionar Turno.',
          'warning'
      ).then(function() { });
      return false;
    }
    if($('#id_seccion').val().trim() === '0'){
      Swal(
          'Ups!',
          'Debe seleccionar Sección.',
          'warning'
      ).then(function() { });
      return false;
    }
    return true;
  }
//Añadido recientemente
  var listSemanas = JSON.parse(document.getElementById('list_semanas').value);
  const selectAnio = document.getElementById('anio');
  const aniosUnicos = new Set();

  for (let i = 0; i < listSemanas.length; i++) {
      const year = listSemanas[i].anio;
      aniosUnicos.add(year);
  }

  for (const year of aniosUnicos){
      const option = document.createElement("option");
      option.text = year;
      option.value = year;
      selectAnio.add(option);
  }
  //Añaldido Recientemente
  selectAnio.addEventListener("change", function() {
      document.getElementById('inicio_clase').value = "";
      document.getElementById('fin_clase').value = "";
      const selectSemanaInicio = document.getElementById('semana_inicio');
      const selectedValue = parseInt(this.value);
      if (!isNaN(selectedValue)) {
          selectSemanaInicio.innerHTML = '';
          const option1 = document.createElement("option");
          option1.text = "Selecione";
          option1.value = 0;
          selectSemanaInicio.add(option1)
          for (var i = 0; i < listSemanas.length; i++) {
              if(listSemanas[i].anio == selectedValue){
                  const option = document.createElement("option");
                  option.text = "Sem. "+ listSemanas[i].nom_semana;
                  option.value = listSemanas[i].nom_semana;
                  selectSemanaInicio.add(option);
              }
          }
      } else {
          console.log("No se ha seleccionado un valor válido.");
      }
  });

  /*document.getElementById('anio').addEventListener('change',function () {
      var anioInicio = parseInt(this.value)
      document.getElementById('semana_inicio').clean();
      for (var i = 0; i < listSemanas.length; i++) {
          if(listSemanas[i].anio == anioInicio){
              const option = document.createElement("option");
              option.text = "Semana "+ listSemanas[i].nom_semana;
              option.value = listSemanas[i].nom_semana;
              document.getElementById('semana_inicio').add(option);
          }
      }
  });*/

  document.getElementById('semana_inicio').addEventListener('change', function() {
      var semanaInicio = parseInt(this.value);

      // Obtener los datos de la variable list_semanas

      const currentDate = new Date();
      const year = currentDate.getFullYear();
      const dataanio = document.getElementById('anio').value;
      // Buscar la fecha de inicio correspondiente a la semana seleccionada
      var fechaInicio = null;
      for (var i = 0; i < listSemanas.length; i++) {
          if(listSemanas[i].anio == dataanio){
              if (listSemanas[i].nom_semana == semanaInicio) {
                  fechaInicio = listSemanas[i].fec_inicio;
                  break;
              }
          }
      }
      //console.log('Fecha de inicio: ' + fechaInicio);
      document.getElementById('inicio_clase').value = fechaInicio;
      //document.getElementById('inicio_clase').value = calcularFechaPorFecha(fechaInicio).inicio;
      document.getElementById('fin_clase').value = calcularFechaPorFecha(fechaInicio).fin;
  });

  /*function calcularFechaPorSemana(semana) {
    var year = new Date().getFullYear();
    var startDate = new Date(year, 0, 1);
    var dayOfWeek = startDate.getDay();
    var daysToAdd = (semana - 2) * 7 + (dayOfWeek > 0 ? 8 - dayOfWeek : 1);

    startDate.setDate(startDate.getDate() + daysToAdd);

    var endDate = new Date(startDate);
    endDate.setDate(endDate.getDate() + 19 * 7); 
    
    while (endDate.getDay() !== 5) {
      endDate.setDate(endDate.getDate() + 1);
    }

    return {
      inicio: startDate.toISOString().split('T')[0],
      fin: endDate.toISOString().split('T')[0]
    };
  }*/
  function calcularFechaPorFecha(fecha) {
      var startDate = new Date(fecha);
      var dayOfWeek = startDate.getDay();
      var daysToAdd = (dayOfWeek > 0 ? 8 - dayOfWeek : 1);


      startDate.setDate(startDate.getDate() + daysToAdd);

      var endDate = new Date(startDate);

      endDate.setDate(endDate.getDate() + 19 * 7);
      while (endDate.getDay() !== 4) {
          endDate.setDate(endDate.getDate()+1);
      }

      return {
          inicio: startDate.toISOString().split('T')[0],
          fin: endDate.toISOString().split('T')[0]
      };
  }

</script>