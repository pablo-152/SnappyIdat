<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .grande_check_i{ 
        width: 20px;
        height: 20px;
    }
</style>

<div class="panel panel-flat">
  <div class="panel-heading">
    <div class="row">
      <div class="x_panel">
        <div class="page-title" style="background-color: #C1C1C1;">
          <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Salón (Nuevo)</b></span></h4>
        </div>
      </div>

      <div class="heading-elements">
          <div class="heading-btn-group">
              <a type="button" href="<?= site_url('AppIFV/Salon') ?>" >
                  <img src="<?= base_url() ?>template/img/icono-regresar.png">
              </a>
          </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Planta:</label>
                <select class="form-control" id="planta_i" name="planta_i">
                    <option value="0">Seleccione</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ref.:</label>
                <input type="text" class="form-control" id="referencia_i" name="referencia_i" placeholder="Referencia">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
                <select class="form-control" id="id_tipo_salon_i" name="id_tipo_salon_i" onchange="Descripcion_I();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_tipo_salon as $list){ ?>
                        <option value="<?php echo $list['id_tipo_salon']; ?>"><?php echo $list['nom_tipo_salon']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Descripción:</label>
                <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Descripción">
            </div>
        </div>

        <div class="col-md-12 row">
            <?php foreach($list_especialidad as $list){ ?>
                <div class="form-group col-md-2">
                    <input type="checkbox" class="grande_check_i" id="<?php echo $list['abreviatura']."_i"; ?>" name="<?php echo $list['abreviatura']."_i"; ?>" value="1">
                    <label class="form-group text-bold"><?php echo $list['abreviatura']; ?></label><span>&nbsp;</span>
                </div>
            <?php } ?>
        </div>  
        
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Capacidad Alum.:</label>
                <input type="text" class="form-control solo_numeros" id="capacidad_i" name="capacidad_i" placeholder="Capacidad Alumno">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Disponibilidad Alum.:</label>
                <input type="text" class="form-control solo_numeros" id="disponible_i" name="disponible_i" placeholder="Disponiblidad Alumno">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Aforo CP Dbl:</label>
                <input type="text" class="form-control solo_numeros" id="aforodbl_i" name="aforodbl_i" placeholder="Aforo CP Dbl">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Aforo CP Ind:</label>
                <input type="text" class="form-control solo_numeros" id="aforoind_i" name="aforoind_i" placeholder="Aforo CP Ind">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Carpetas (Tp):</label>
                <select class="form-control" id="carpetatp_i" name="carpetatp_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Dobles</option>
                    <option value="2">Individuales</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Carpetas (Cant):</label>
                <input type="text" class="form-control solo_numeros" id="carpetacant_i" name="carpetacant_i" placeholder="Carpetas (Cant)">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Pintura:</label>
                <input type="text" class="form-control" id="pintura_i" name="pintura_i" placeholder="Pintura" maxlength="40">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Chapa:</label>
                <input type="text" class="form-control" id="chapa_i" name="chapa_i" placeholder="Chapa" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Pizarra:</label>
                <input type="text" class="form-control" id="pizarra_i" name="pizarra_i" placeholder="Pizarra" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Proyector:</label>
                <input type="text" class="form-control" id="proyector_i" name="proyector_i" placeholder="Proyector" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Puerta:</label>
                <input type="text" class="form-control" id="puerta_i" name="puerta_i" placeholder="Puerta" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tacho:</label>
                <input type="text" class="form-control" id="tacho_i" name="tacho_i" placeholder="Tacho" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cortinas:</label>
                <input type="text" class="form-control" id="cortina_i" name="cortina_i" placeholder="Cortinas" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Iluminación:</label>
                <input type="text" class="form-control" id="iluminacion_i" name="iluminacion_i" placeholder="Iluminación" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Mueble:</label>
                <input type="text" class="form-control" id="mueble_i" name="mueble_i" placeholder="Mueble" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Mesa Profesor:</label>
                <input type="text" class="form-control" id="mesa_profesor_i" name="mesa_profesor_i" placeholder="Mesa Profesor" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Enchufes:</label>
                <input type="text" class="form-control" id="enchufe_i" name="enchufe_i" placeholder="Enchufes" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Computadora:</label>
                <input type="text" class="form-control" id="computadora_i" name="computadora_i" placeholder="Computadora" maxlength="20">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Silla Profesor:</label>
                <input type="text" class="form-control" id="silla_profesor_i" name="silla_profesor_i" placeholder="Silla Profesor" maxlength="20">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Observaciones:</label>
                <textarea class="form-control" id="observaciones_i" name="observaciones_i" placeholder="Observaciones" rows="4" maxlength="40"></textarea>
            </div>
        </div>
      
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Insert_Salon()">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <a type="button" class="btn btn-default" href="<?= site_url('AppIFV/Salon') ?>">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </a>
        </div>
    </form>
  </div>
</div>

<script>
    $(document).ready(function() {
      $("#configuraciones").addClass('active');
      $("#hconfiguraciones").attr('aria-expanded', 'true');
      $("#salones").addClass('active');
      document.getElementById("rconfiguraciones").style.display = "block";
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Descripcion_I(){
        var combo = document.getElementById("id_tipo_salon_i");
        var selected = combo.options[combo.selectedIndex].text;
        $("#descripcion_i").val(selected);
    }

    function Insert_Salon(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Salon";

        if (Valida_Insert_Salon()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
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
                        window.location = "<?php echo site_url(); ?>AppIFV/Salon";
                    }
                }
            });
        }
    }

    function Valida_Insert_Salon() {
        var contador_i = 0;

        $(".grande_check_i").each(function() {
        if ($(this).is(":checked"))
            contador_i++;
        });

        if($('#planta_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Planta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#referencia_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_salon_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_salon_i').val() != '9') {
            if (contador_i == 0) {
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos una Especialidad.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if($('#capacidad_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Capacidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#disponible_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Disponibilidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>