<form id="formulario_pos" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Actualización del Postulante <b><?php echo $get_id[0]['apellido_pat']; ?></b></h5>
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
                <input value="<?php echo $get_id[0]['nr_documento']; ?>" class="form-control" required type="text" id="nr_documento" name="nr_documento" maxlength="8" onkeypress="return soloNumeros(event)" placeholder= "Ingresar Nro Documento" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombres: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['nombres']; ?>" class="form-control" required type="text" id="nombres" name="nombres" placeholder= "Ingresar Nombres" />
            </div>
        </div>
            
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Apellido Paterno: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['apellido_pat']; ?>" class="form-control" required  id="apellido_pat" name="apellido_pat" placeholder= "Ingresar Apellido Paterno" type="text" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Apellido Materno: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['apellido_mat']; ?>" class="form-control" required  id="apellido_mat" name="apellido_mat" placeholder= "Ingresar Apellido Materno" type="text" />
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Interés: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['interese']; ?>" class="form-control" required  id="interese" name="interese" placeholder= "Ingresar Interés" type="text" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Carrera: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_carrera" id="id_carrera" >
                    <option value="0">Seleccione</option>
                    <?php foreach($list_carrera as $list){ 
                    if($get_id[0]['id_carrera'] == $list['id_carrera']){ ?>
                    <option selected value="<?php echo $list['id_carrera'] ; ?>">
                    <?php echo $list['nombre'];?></option>
                    <?php }else
                    {?>
                    <option value="<?php echo $list['id_carrera']; ?>"><?php echo $list['nombre'];?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo Electrónico: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['email']; ?>" class="form-control" required  id="email" name="email" placeholder= "Ingresar Apellido Materno" type="text" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['celular']; ?>" class="form-control" required  id="celular" name="celular" placeholder= "Ingresar celular" onkeypress="return soloNumeros(event)" type="text" maxlength="9"/>
            </div>

            
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha Inscripción: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['fecha_inscripcion']; ?>" class="form-control" required id="fec_inscripcion" name="fec_inscripcion" placeholder= "Ingresar Apellido Materno" type="date" />
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Grupo: </label>
            </div>
            <div class="form-group col-md-4">
                <input value="<?php echo $get_id[0]['grupo']; ?>" class="form-control" required id="grupo" name="grupo" placeholder= "Ingresar Grupo" type="text" />
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado" id="estado" >
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ 
                    if($get_id[0]['estado'] == $list['id_status_general']){ ?>
                    <option selected value="<?php echo $list['id_status_general'] ; ?>">
                    <?php echo $list['nom_status'];?></option>
                    <?php }else
                    {?>
                    <option value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input  type="hidden" class="form-control" name="id_postulante" id="id_postulante" value="<?php echo $get_id[0]['id_postulante']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Postulante()"  data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function soloNumeros(e) {
        var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        //letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
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

    
    function Update_Postulante(){
        var dataString = new FormData(document.getElementById('formulario_pos'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Postulante";

        if (valida_postulante()) {
            bootbox.confirm({
                title: "Actualizar Postulante",
                message: "¿Desea ctualizar datos de postulante?",
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
                        $.ajax({
                            type:"POST",
                            url:url,
                            data: dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data=="error"){
                                    Swal(
                                        'Actualización Denegada!',
                                        'Existe un postulante con el mismo número documento.',
                                        'error'
                                    ).then(function() {
                                    });
                                }else{
                                    Swal(
                                        'Actualización Exitosa!',
                                        '',
                                        'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                                    });
                                }
                            }
                        });
                    }
                } 
            });        
        }
    }

    function valida_postulante() {
        if($('#nr_documento').val().trim() === '') {
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
        }if($('#email').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Correo Electrónico.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_inscripcion').val().trim() === '') {
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
        }
        if($('#estado').val() === '0') {
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