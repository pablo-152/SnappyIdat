<form id="formulario_pos" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Detalles del Postulante: <b><?php echo $get_id[0]['apellido_pat']; ?></b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <?php echo $get_id[0]['codigo']; ?>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">DNI: </label>
            </div>
            <div class="form-group col-md-4">
                <input disabled value="<?php echo $get_id[0]['nr_documento']; ?>" class="form-control" required type="text" id="nr_documento" name="nr_documento" maxlength="8" onkeypress="return soloNumeros(event)" placeholder= "Ingresar Nro Documento" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombres: </label>
            </div>
            <div class="form-group col-md-4">
                <input disabled value="<?php echo $get_id[0]['nombres']; ?>" class="form-control" required type="text" id="nombres" name="nombres" placeholder= "Ingresar Nombres" />
            </div>
        </div>
            
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Apellido Paterno: </label>
            </div>
            <div class="form-group col-md-4">
                <input disabled value="<?php echo $get_id[0]['apellido_pat']; ?>" class="form-control" required  id="apellido_pat" name="apellido_pat" placeholder= "Ingresar Apellido Paterno" type="text" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Apellido Materno: </label>
            </div>
            <div class="form-group col-md-4">
                <input disabled value="<?php echo $get_id[0]['apellido_mat']; ?>" class="form-control" required  id="apellido_mat" name="apellido_mat" placeholder= "Ingresar Apellido Materno" type="text" />
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Interés: </label>
            </div>
            <div class="form-group col-md-4">
                <input disabled value="<?php echo $get_id[0]['interese']; ?>" class="form-control" required  id="interese" name="interese" placeholder= "Ingresar Interés" type="text" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Carrera: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_carrera" id="id_carrera" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_carrera as $list){ ?>
                        <option value="<?php echo $list['id_carrera']; ?>" <?php if($list['id_carrera']==$get_id[0]['id_carrera']){ echo "selected"; } ?>>
                            <?php echo $list['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['email']; ?>" class="form-control" required  id="emaile" name="emaile" placeholder= "Ingresar Apellido Materno" type="text" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inicio&nbsp;de&nbsp;Examen: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['hora_inicio']; ?>" class="form-control" required  id="hora_inicioe" name="hora_inicioe" placeholder= "Ingresar Apellido Materno" type="time" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular: </label>
            </div>
            <div class="form-group col-md-4">
                <input disabled value="<?php echo $get_id[0]['celular']; ?>" class="form-control" required  id="celular" name="celular" placeholder= "Ingresar celular" onkeypress="return soloNumeros(event)" type="text" maxlength="9"/>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grupo: </label>
            </div>
            <div class="form-group col-md-4">
                <input disabled value="<?php echo $get_id[0]['grupo']; ?>" class="form-control" required id="grupo" name="grupo" placeholder= "Ingresar Grupo" type="text" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado" id="estado">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status_general']; ?>" <?php if($list['id_status_general']==$get_id[0]['estado']){ echo "selected"; } ?>>
                        <?php echo $list['nom_status']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Observaciones: </label>
            </div>
            <div class="form-group col-md-10">
                <textarea class="form-control" id="observaciones" name="observaciones" rows="5" placeholder="Ingresar Observaciones"><?php echo $get_id[0]['observaciones']; ?></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input  type="hidden" class="form-control" name="id_postulantee" id="id_postulantee" value="<?php echo $get_id[0]['id_postulante']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Postulante_Efsrt();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function soloNumeros(e) {
        var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        letras = "0123456789",
        especiales = [8, 37, 39, 46],
        tecla_especial = false;

        for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
        }
    }

    
    function Update_Postulante_Efsrt(){
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

        var tipo_excel = $("#tipo_excel").val(); 
        var dataString = new FormData(document.getElementById('formulario_pos'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Postulante_Efsrt"; 

        if (Valida_Update_Postulante_Efsrt()) {
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Swal(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Postulantes_Efsrt(tipo_excel);
                        $("#acceso_modal_mod .close").click()
                    }); 
                }
            });     
        }
    }

    function Valida_Update_Postulante_Efsrt() {
        /*if($('#nr_documento').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar número de documento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nombres').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombres.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#apellido_pat').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar A. Paterno.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#apellido_mat').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar A. Materno.',
                'warning'
            ).then(function() { });
            return false;
        }*/if($('#emaile').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Correo Electrónico.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#hora_inicioe').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Hora de inicio de examen.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }/*if($('#fec_inscripcion').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inscripción.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#grupo').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Grupo.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }
</script>