<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<?php $this->load->view('view_LL/header'); ?>
<?php $this->load->view('view_LL/nav'); ?>

<style>
    .grande_check_u{ 
        width: 20px;
        height: 20px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Salón</b></span></h4>
                </div>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a type="button" href="<?= site_url('LittleLeaders/Salon') ?>" >
                        <img src="<?= base_url() ?>template/img/icono-regresar.png">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Planta:</label>
                    <select class="form-control" id="planta_u" name="planta_u">
                        <option value="0" <?php if($get_id[0]['planta']==0){ echo "selected"; } ?>>Seleccione</option>
                        <option value="1" <?php if($get_id[0]['planta']==1){ echo "selected"; } ?>>1</option>
                        <option value="2" <?php if($get_id[0]['planta']==2){ echo "selected"; } ?>>2</option>
                        <option value="3" <?php if($get_id[0]['planta']==3){ echo "selected"; } ?>>3</option>
                        <option value="4" <?php if($get_id[0]['planta']==4){ echo "selected"; } ?>>4</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Ref.:</label>
                    <input type="text" class="form-control" id="referencia_u" name="referencia_u" placeholder="Referencia" value="<?php echo $get_id[0]['referencia']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Tipo:</label>
                    <select class="form-control" id="id_tipo_salon_u" name="id_tipo_salon_u" onchange="Descripcion_U();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo_salon as $list){ ?>
                            <option value="<?php echo $list['id_tipo_salon']; ?>" <?php if($list['id_tipo_salon']==$get_id[0]['id_tipo_salon']){ echo "selected"; } ?>>
                                <?php echo $list['nom_tipo_salon']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Descripción:</label>
                    <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <?php foreach($list_especialidad as $list){ ?>
                    <div class="form-group col-md-2">
                        <input type="checkbox" class="grande_check_u" id="<?php echo $list['abreviatura']."_u"; ?>" name="<?php echo $list['abreviatura']."_u"; ?>" value="1" <?php if($get_id[0][strtolower($list['abreviatura'])]==1){ echo "checked"; } ?>>
                        <label class="form-group text-bold"><?php echo $list['abreviatura']; ?></label><span>&nbsp;</span>
                    </div>
                <?php } ?>
            </div>  
            
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Capacidad:</label>
                    <input type="text" class="form-control solo_numeros" id="capacidad_u" name="capacidad_u" placeholder="Capacidad" value="<?php echo $get_id[0]['capacidad']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Disponible:</label>
                    <input type="text" class="form-control solo_numeros" id="disponible_u" name="disponible_u" placeholder="Disponible" value="<?php echo $get_id[0]['disponible']; ?>">
                </div>

                <div class="form-group col-md-4">
                    <label class="control-label text-bold">Pintura:</label>
                    <input type="text" class="form-control" id="pintura_u" name="pintura_u" placeholder="Pintura" maxlength="40" value="<?php echo $get_id[0]['pintura']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Chapa:</label>
                    <input type="text" class="form-control" id="chapa_u" name="chapa_u" placeholder="Chapa" maxlength="20" value="<?php echo $get_id[0]['chapa']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Pizarra:</label>
                    <input type="text" class="form-control" id="pizarra_u" name="pizarra_u" placeholder="Pizarra" maxlength="20" value="<?php echo $get_id[0]['pizarra']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Proyector:</label>
                    <input type="text" class="form-control" id="proyector_u" name="proyector_u" placeholder="Proyector" maxlength="20" value="<?php echo $get_id[0]['proyector']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Puerta:</label>
                    <input type="text" class="form-control" id="puerta_u" name="puerta_u" placeholder="Puerta" maxlength="20" value="<?php echo $get_id[0]['puerta']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Tacho:</label>
                    <input type="text" class="form-control" id="tacho_u" name="tacho_u" placeholder="Tacho" maxlength="20" value="<?php echo $get_id[0]['tacho']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Cortinas:</label>
                    <input type="text" class="form-control" id="cortina_u" name="cortina_u" placeholder="Cortinas" maxlength="20" value="<?php echo $get_id[0]['cortina']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Iluminación:</label>
                    <input type="text" class="form-control" id="iluminacion_u" name="iluminacion_u" placeholder="Iluminación" maxlength="20" value="<?php echo $get_id[0]['iluminacion']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Mueble:</label>
                    <input type="text" class="form-control" id="mueble_u" name="mueble_u" placeholder="Mueble" maxlength="20" value="<?php echo $get_id[0]['mueble']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Mesa Profesor:</label>
                    <input type="text" class="form-control" id="mesa_profesor_u" name="mesa_profesor_u" placeholder="Mesa Profesor" maxlength="20" value="<?php echo $get_id[0]['mesa_profesor']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Enchufes:</label>
                    <input type="text" class="form-control" id="enchufe_u" name="enchufe_u" placeholder="Enchufes" maxlength="20" value="<?php echo $get_id[0]['enchufe']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Computadora:</label>
                    <input type="text" class="form-control" id="computadora_u" name="computadora_u" placeholder="Computadora" maxlength="20" value="<?php echo $get_id[0]['computadora']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Silla Profesor:</label>
                    <input type="text" class="form-control" id="silla_profesor_u" name="silla_profesor_u" placeholder="Silla Profesor" maxlength="20" value="<?php echo $get_id[0]['silla_profesor']; ?>">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Estado:</label>
                    <select class="form-control" id="estado_salon_u" name="estado_salon_u">
                        <option value="0" <?php if($get_id[0]['estado_salon']==0){ echo "selected"; } ?>>Seleccione</option>
                        <option value="1" <?php if($get_id[0]['estado_salon']==1){ echo "selected"; } ?>>Activo</option>
                        <option value="2" <?php if($get_id[0]['estado_salon']==2){ echo "selected"; } ?>>Inactivo</option>
                        <option value="3" <?php if($get_id[0]['estado_salon']==3){ echo "selected"; } ?>>Clausurado</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-12">
                    <label class="control-label text-bold">Observaciones:</label>
                    <textarea class="form-control" id="observaciones_u" name="observaciones_u" placeholder="Observaciones" rows="4" maxlength="40"><?php echo $get_id[0]['observaciones']; ?></textarea>
                </div>
            </div>
        
            <div class="modal-footer">
                <input type="hidden" id="id_salon" name="id_salon" value="<?php echo $get_id[0]['id_salon']; ?>">
                <button type="button" class="btn btn-primary" onclick="Update_Salon();">
                    <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                </button>
                <button type="button" class="btn btn-default" href="<?= site_url('LittleLeaders/Salon') ?>">
                    <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
                </button>
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

    function Descripcion_U(){
        var combo = document.getElementById("id_tipo_salon_u");
        var selected = combo.options[combo.selectedIndex].text;
        $("#descripcion_u").val(selected);
    }

    function Update_Salon(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>LittleLeaders/Update_Salon";

        if (Valida_Update_Salon()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actulización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        window.location = "<?php echo site_url(); ?>LittleLeaders/Salon";
                    }
                }
            });
        }
    }

    function Valida_Update_Salon() {
        var contador_u = 0;

        $(".grande_check_u").each(function() {
        if ($(this).is(":checked"))
            contador_u++;
        });

        if($('#planta_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Planta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#referencia_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_salon_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if (contador_u == 0) {
            Swal(
                'Ups!',
                'Debe seleccionar al menos una Especialidad.',
                'warning'
            ).then(function() {});
            return false;
        }
        if($('#capacidad_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Capacidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#disponible_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Disponibilidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_salon_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_LL/footer'); ?>