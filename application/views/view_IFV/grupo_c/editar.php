  <?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .tabset > input[type="radio"] {
        position: absolute;
        left: -200vw;
    }

    .tabset .tab-panel {
        display: none;
    }

    .tabset > input:first-child:checked ~ .tab-panels > .tab-panel:first-child,
    .tabset > input:nth-child(3):checked ~ .tab-panels > .tab-panel:nth-child(2),
    .tabset > input:nth-child(5):checked ~ .tab-panels > .tab-panel:nth-child(3),
    .tabset > input:nth-child(7):checked ~ .tab-panels > .tab-panel:nth-child(4),
    .tabset > input:nth-child(9):checked ~ .tab-panels > .tab-panel:nth-child(5),
    .tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6){
        display: block;
    }


    .tabset > label {
        position: relative;
        display: inline-block;
        padding: 15px 15px 25px;
        border: 1px solid transparent;
        border-bottom: 0;
        cursor: pointer;
        font-weight: 600;
        background: #799dfd5c;
    }

    .tabset > label::after {
        content: "";
        position: absolute;
        left: 15px;
        bottom: 10px;
        width: 22px;
        height: 4px;
        background: #8d8d8d;
    }

    .tabset > label:hover,
    .tabset > input:focus + label {
        color: #06c;
    }

    .tabset > label:hover::after,
    .tabset > input:focus + label::after,
    .tabset > input:checked + label::after {
        background: #06c;
    }

    .tabset > input:checked + label {
        border-color: #ccc;
        border-bottom: 1px solid #fff;
        margin-bottom: -1px;
    }

    .tab-panel {
        padding: 30px 0;
        border-top: 1px solid #ccc;
    }

    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    .tabset {
        margin: 8px 15px;
    }

    .contenedor1 {
        position: relative;
        height: 80px;
        width: 80px;
        float: left;
    }

    .contenedor1 img {
        position: absolute;
        left: 0;
        transition: opacity 0.3s ease-in-out;
        height: 80px;
        width: 80px;
    }

    .contenedor1 img.top:hover {
        opacity: 0;
        height: 80px;
        width: 80px;
    }

    table th {
        text-align: center;
    }

    .margintop{
        margin-top:5px ;
    }

    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px;
    }

    .color_casilla{
        border-color: #C8C8C8;
        color: #000;
        background-color: #C8C8C8 !important;
    }

    .img_class{ 
        position: absolute;
        width: 80px;
        height: 90px;
        top: 5%;
        left: 1%;
    }

    .boton_exportable{
        margin: 0 0 10px 0;
    }

    .cabecera_pagos{
        margin: 5px 0 0 5px;
    }

    .tamanio{
        height: 20px;
        width: 20px;
    }

    .margintop{
        margin-top:5px ;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Grupo</b></span></h4>
                </div>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group"> 
                    <a type="button" href="<?= site_url('AppIFV/Detalle_Grupo_C') ?>/<?php echo $get_id[0]['id_grupo']; ?>">
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
                    <input type="text" class="form-control" id="cod_grupo" name="cod_grupo" placeholder="Código" maxlength="6" value="<?php echo $get_id[0]['cod_grupo']; ?>">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold">Grupo:</label>
                    <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo" value="<?php echo $get_id[0]['grupo']; ?>">
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Especialidad:</label>
                    <select class="form-control" id="id_especialidad" name="id_especialidad" onchange="Grupo_Modulo();">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_especialidad as $list){ ?>
                        <option value="<?php echo $list['id_especialidad']; ?>" <?php if($list['id_especialidad']==$get_id[0]['id_especialidad']){ echo "selected"; } ?>>
                            <?php echo $list['nom_especialidad']; ?>
                        </option>
                    <?php } ?>
                    </select> 
                </div>

                <div id="grupo_modulo" class="form-group col-md-2">
                    <label class="control-label text-bold">Modulo:</label>
                    <select class="form-control" id="id_modulo" name="id_modulo" onchange="Grupo_Ciclo();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_modulo as $list){ ?>
                        <option value="<?php echo $list['id_modulo']."-".$list['modulo']; ?>" <?php if($list['id_modulo']==$get_id[0]['id_modulo']){ echo "selected"; } ?>>
                          <?php echo $list['modulo']; ?>
                        </option>
                    <?php } ?>
                    </select>
                </div>

                <div id="grupo_ciclo" class="form-group col-md-2">
                    <label class="control-label text-bold">Ciclo:</label>
                    <select class="form-control" id="id_ciclo" name="id_ciclo" onchange="Esconder();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_ciclo as $list){ ?>
                        <option value="<?php echo $list['id_ciclo']."-".$list['ciclo']; ?>" <?php if($list['id_ciclo']==$get_id[0]['id_ciclo']){ echo "selected"; } ?>>
                            <?php echo $list['ciclo']; ?>
                        </option>
                    <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label>Año:</label>
                    <select class="form-control" id="anio" name="anio" >
                        <option value="<?php echo $get_id[0]['anio_inicio']; ?>"><?php echo $get_id[0]['anio_inicio']; ?></option>
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <input type="hidden" id="list_semanas" value="<?php echo htmlspecialchars(json_encode($list_semanas)); ?>">
                    <label class="control-label text-bold">Sem.&nbsp;Ini.:</label>
                    <select class="form-control" id="semana_inicio" name="semana_inicio" onchange="CalculoDia();">
                    <option value="<?php echo $get_id[0]['semana_inicio']; ?>">Sem. <?php echo $get_id[0]['semana_inicio']; ?></option>
                    </select>  
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Inicio Clases:</label> 
                    <input type="date" class="form-control" id="inicio_clase" name="inicio_clase" value="<?php echo $get_id[0]['inicio_clase']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Fin Clases:</label>
                    <input type="date" class="form-control" id="fin_clase" name="fin_clase" value="<?php echo $get_id[0]['fin_clase']; ?>">
                </div>

                <div id="grupo_turno" class="form-group col-md-2">
                    <label class="control-label text-bold">Turno:</label>
                    <select class="form-control" id="id_turno" name="id_turno">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_turno as $list){ ?>
                        <option value="<?php echo $list['id_turno']; ?>" <?php if($list['id_turno']==$get_id[0]['id_turno']){ echo "selected"; } ?>>
                            <?php echo $list['nom_turno']; ?>
                        </option>
                    <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Sección:</label>
                    <select class="form-control" id="id_seccion" name="id_seccion">
                    <option value="0" <?php if($get_id[0]['id_seccion']=="0"){ echo "selected"; } ?>>Selccione</option>
                    <option value="A" <?php if($get_id[0]['id_seccion']=="A"){ echo "selected"; } ?>>A</option>
                    <option value="B" <?php if($get_id[0]['id_seccion']=="B"){ echo "selected"; } ?>>B</option>
                    <option value="C" <?php if($get_id[0]['id_seccion']=="C"){ echo "selected"; } ?>>C</option>
                    <option value="D" <?php if($get_id[0]['id_seccion']=="D"){ echo "selected"; } ?>>D</option>
                    <option value="E" <?php if($get_id[0]['id_seccion']=="E"){ echo "selected"; } ?>>E</option>
                    <option value="F" <?php if($get_id[0]['id_seccion']=="F"){ echo "selected"; } ?>>F</option>
                    <option value="G" <?php if($get_id[0]['id_seccion']=="G"){ echo "selected"; } ?>>G</option>
                    <option value="H" <?php if($get_id[0]['id_seccion']=="H"){ echo "selected"; } ?>>H</option>
                    <option value="I" <?php if($get_id[0]['id_seccion']=="I"){ echo "selected"; } ?>>I</option>
                    <option value="J" <?php if($get_id[0]['id_seccion']=="J"){ echo "selected"; } ?>>J</option>
                    <option value="K" <?php if($get_id[0]['id_seccion']=="K"){ echo "selected"; } ?>>K</option>
                    <option value="L" <?php if($get_id[0]['id_seccion']=="L"){ echo "selected"; } ?>>L</option>
                    <option value="M" <?php if($get_id[0]['id_seccion']=="M"){ echo "selected"; } ?>>M</option>
                    <option value="N" <?php if($get_id[0]['id_seccion']=="N"){ echo "selected"; } ?>>N</option>
                    <option value="O" <?php if($get_id[0]['id_seccion']=="O"){ echo "selected"; } ?>>O</option>
                    <option value="P" <?php if($get_id[0]['id_seccion']=="P"){ echo "selected"; } ?>>P</option>
                    <option value="Q" <?php if($get_id[0]['id_seccion']=="Q"){ echo "selected"; } ?>>Q</option>
                    <option value="R" <?php if($get_id[0]['id_seccion']=="R"){ echo "selected"; } ?>>R</option>
                    <option value="S" <?php if($get_id[0]['id_seccion']=="S"){ echo "selected"; } ?>>S</option>
                    <option value="T" <?php if($get_id[0]['id_seccion']=="T"){ echo "selected"; } ?>>T</option>
                    <option value="U" <?php if($get_id[0]['id_seccion']=="U"){ echo "selected"; } ?>>U</option>
                    <option value="V" <?php if($get_id[0]['id_seccion']=="V"){ echo "selected"; } ?>>V</option>
                    <option value="W" <?php if($get_id[0]['id_seccion']=="W"){ echo "selected"; } ?>>W</option>
                    <option value="X" <?php if($get_id[0]['id_seccion']=="X"){ echo "selected"; } ?>>X</option>
                    <option value="Y" <?php if($get_id[0]['id_seccion']=="Y"){ echo "selected"; } ?>>Y</option>
                    <option value="Z" <?php if($get_id[0]['id_seccion']=="Z"){ echo "selected"; } ?>>Z</option>
                    </select>
                </div>

                <div id="grupo_salon" class="form-group col-md-2">
                  <label class="control-label text-bold">Salón:</label>
                  <select class="form-control" id="id_salon" name="id_salon">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_salon as $list){ ?>
                        <option value="<?php echo $list['id_salon']; ?>" <?php if($list['id_salon']==$get_id[0]['id_salon']){ echo "selected"; } ?>>
                          <?php echo $list['nom_salon']; ?>
                        </option>
                    <?php } ?>
                  </select>
                </div>
            </div>

            <div class="col-md-12 row"> 
              <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
              <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
                <select class="form-control" id="estado_grupo" name="estado_grupo">
                  <option value="0"<?php if($get_id[0]['estado_grupo']==0){ echo "selected"; } ?>>Seleccione</option>
                  <?php foreach($list_grupo_manual as $list){ ?>
                      <option value="<?php echo $list['id_maestro_detalle']; ?>" <?php if($list['id_maestro_detalle']==$get_id[0]['estado_grupo']){ echo "selected"; } ?>>
                        <?php echo $list['nom_maestro_detalle']; ?>
                      </option>
                  <?php } ?>
                </select>
              </div>
              <?php }else{ ?>
                  <input type="hidden" id="estado_grupo" name="estado_grupo" value="<?php echo $get_id[0]['estado_grupo']; ?>">
              <?php } ?>

              <div class="form-group col-md-2">
                  <input type="checkbox" class="tamanio" id="salir_matriculados" name="salir_matriculados" value="1" <?php if($get_id[0]['salir_matriculados']==1){ echo "checked"; } ?>>
                  <label class="control-label text-bold">Salir en Alumnos (Admisión)</label>
              </div>
            </div>
  
            <div class="modal-footer">
              <input type="hidden" id="actual_horario_pdf" name="actual_horario_pdf" value="<?php echo $get_id[0]['horario_pdf']; ?>">
              <input type="hidden" id="id_grupo" name="id_grupo" value="<?php echo $get_id[0]['id_grupo']; ?>">
              <button type="button" class="btn btn-primary" onclick="Update_Grupo_C();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
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
        Parte_Media();

        var fechaInicio = document.getElementById('inicio_clase').value;
        var fechaInicioObj = new Date(fechaInicio);
        var numeroSemana = Math.ceil(((fechaInicioObj - new Date(fechaInicioObj.getFullYear(), 0, 1)) / 86400000 + 1) / 7);
        //document.getElementById('semana_inicio').value = numeroSemana.toString();
    }); 
</script>

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

  function Update_Grupo_C(){
    Cargando();

    var id_grupo = $('#id_grupo').val();
    var dataString = new FormData(document.getElementById('formulario')); 
    var url="<?php echo site_url(); ?>AppIFV/Update_Grupo_C";

    if (Valida_Update_Grupo_C()) {
      $.ajax({
          type:"POST",
          url: url,
          data:dataString,
          processData: false,
          contentType: false,
          success:function (data) {
            if(data=="error"){
              Swal({
                  title: 'Actualización Denegada',
                  text: "¡El registro ya existe!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              });
            }else if(data=="no_matriculado"){
              Swal({
                  title: 'Actualización Denegada',
                  text: "¡No puede cambiar ese estado si tiene alumnos matriculados!",
                  type: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'OK',
              });
            }else{
              window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Grupo_C/"+id_grupo; 
            }
          }
      });
    }
  }

  function Valida_Update_Grupo_C() {
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
                    option.text = "Semana "+ listSemanas[i].nom_semana;
                    option.value = listSemanas[i].nom_semana;
                    selectSemanaInicio.add(option);
                }
            }
        } else {
            console.log("No se ha seleccionado un valor válido.");
        }
    });
  
  /*document.getElementById('semana_inicio').addEventListener('change', function() {
    var semanaInicio = parseInt(this.value);
    document.getElementById('inicio_clase').value = calcularFechaPorSemana(semanaInicio).inicio;
    document.getElementById('fin_clase').value = calcularFechaPorSemana(semanaInicio).fin;
  });*/
    document.getElementById('semana_inicio').addEventListener('change', function() {
        var semanaInicio = parseInt(this.value);

        // Obtener los datos de la variable list_semanas
        var listSemanas = JSON.parse(document.getElementById('list_semanas').value);
        const dataanio = document.getElementById('anio').value;
        // Buscar la fecha de inicio correspondiente a la semana seleccionada
        var fechaInicio = null;
        for (var i = 0; i < listSemanas.length; i++) {
            if(listSemanas[i].anio == dataanio) {
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

  function CalculoDia(){
      semana = document.getElementById('semana_inicio').value;
      alert(semana);
  }
    function calcularFechaPorFecha(fecha) {
        var startDate = new Date(fecha);
        var dayOfWeek = startDate.getDay();
        var daysToAdd = (dayOfWeek > 0 ? 8 - dayOfWeek : 1);

        startDate.setDate(startDate.getDate() + daysToAdd);

        var endDate = new Date(startDate);
        endDate.setDate(endDate.getDate() + (19 * 7+3));

        /*while (endDate.getDay() !== 5) {
            endDate.setDate(endDate.getDate() + 1);
        }*/

        return {
            inicio: startDate.toISOString().split('T')[0],
            fin: endDate.toISOString().split('T')[0]
        };
    }

  /*function calcularFechaPorSemana(semana) {
    var year = new Date().getFullYear();
    var startDate = new Date(year, 0, 1);
    var dayOfWeek = startDate.getDay();
    var daysToAdd = (semana - 2) * 7 + (dayOfWeek > 0 ? 8 - dayOfWeek : 1);
    //var daysToAdd = (semana - 1) * 7 + (dayOfWeek > 0 ? 8 - dayOfWeek : 1);

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
</script>