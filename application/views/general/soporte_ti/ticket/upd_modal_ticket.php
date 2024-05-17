<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" style="color: #715d74;font-size: 21px;"><b>Edición de Datos de Ticket</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Tipo:</label>
                <select class="form-control" id="id_tipo_ticket" name="id_tipo_ticket">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_tipo_ticket as $list) { ?>
                        <option value="<?php echo $list['id_tipo_ticket']; ?>" <?php if ($list['id_tipo_ticket'] == $get_id[0]['id_tipo_ticket']) {
                                                                                    echo "selected";
                                                                                } ?>>
                            <?php echo $list['nom_tipo_ticket']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Solicitado Por:</label>
                <select class="form-control" id="id_solicitante" name="id_solicitante" onchange="Follow_Up();">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_solicitante as $list) { ?>
                        <option value="<?php echo $list['id_usuario']; ?>" <?php if ($list['id_usuario'] == $get_id[0]['id_solicitante']) {
                                                                                echo "selected";
                                                                            } ?>>
                            <?php echo $list['usuario_codigo']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Fecha:</label>
                <div>
                    <?php echo $get_id[0]['fecha_registro']; ?>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom:15px;">
            <label class="control-label text-bold">Follow Up:</label>
            <select class="form-control multivalue" id="follow_up" name="follow_up[]" multiple="multiple">
                <?php $base_array = explode(",", $get_id[0]['follow_up']);
                foreach ($list_follow_up as $list) { ?>
                    <option value="<?php echo $list['id_usuario']; ?>" <?php if (in_array($list['id_usuario'], $base_array)) {
                                                                            echo "selected";
                                                                        } ?>>
                        <?php echo $list['usuario_codigo']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="control-label text-bold">Empresa:</label>
                <select class="form-control" name="id_empresa" id="id_empresa" onchange="Proyecto();">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_empresa as $list) { ?>
                        <option value="<?php echo $list['id_empresa']; ?>" <?php if ($list['id_empresa'] == $get_id[0]['id_empresa']) {
                                                                                echo "selected";
                                                                            } ?>>
                            <?php echo $list['cod_empresa']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Proyecto:</label>
                <select class="form-control" name="id_proyecto_soporte" id="id_proyecto_soporte" onchange="Subproyecto();">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_proyecto as $list) { ?>
                        <option value="<?php echo $list['id_proyecto_soporte']; ?>" <?php if ($list['id_proyecto_soporte'] == $get_id[0]['id_proyecto_soporte']) {
                                                                                        echo "selected";
                                                                                    } ?>>
                            <?php echo $list['proyecto']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Sub-Proyecto:</label>
                <select class="form-control" name="id_subproyecto_soporte" id="id_subproyecto_soporte">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_subproyecto as $list) { ?>
                        <option value="<?php echo $list['id_subproyecto_soporte']; ?>" <?php if ($list['id_subproyecto_soporte'] == $get_id[0]['id_subproyecto_soporte']) {
                                                                                            echo "selected";
                                                                                        } ?>>
                            <?php echo $list['subproyecto']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-9">
                <label class="control-label text-bold">Descripción:</label>
                <input name="ticket_desc" type="text" maxlength="50" class="form-control" id="ticket_desc" value="<?php echo $get_id[0]['ticket_desc'] ?>" placeholder="Ingresar descripción">
            </div>

            <div class="form-group col-md-3">
                <label class="control-label text-bold">Prioridad:</label>
                <select class="form-control" name="prioridad" id="prioridad">
                    <option value="" <?php if ($get_id[0]['prioridad'] == "") {
                                            echo "selected";
                                        } ?>>Seleccione</option>
                    <option value="0" <?php if ($get_id[0]['prioridad'] == 0) {
                                            echo "selected";
                                        } ?>>0</option>
                    <option value="1" <?php if ($get_id[0]['prioridad'] == 1) {
                                            echo "selected";
                                        } ?>>1</option>
                    <option value="2" <?php if ($get_id[0]['prioridad'] == 2) {
                                            echo "selected";
                                        } ?>>2</option>
                    <option value="3" <?php if ($get_id[0]['prioridad'] == 3) {
                                            echo "selected";
                                        } ?>>3</option>
                    <option value="4" <?php if ($get_id[0]['prioridad'] == 4) {
                                            echo "selected";
                                        } ?>>4</option>
                    <option value="5" <?php if ($get_id[0]['prioridad'] == 5) {
                                            echo "selected";
                                        } ?>>5</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Observación:</label>
                <input name="ticket_obs" type="text" maxlength="50" class="form-control" id="ticket_obs" value="<?php echo $get_id[0]['ticket_obs'] ?>" placeholder="Ingresar observación">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" class="form-control" name="id_status_ticket_i" id="id_status_ticket_i" value="<?php echo $ultimo2; ?>">
        <input type="hidden" id="id_ticket" name="id_ticket" value="<?php echo $get_id[0]['id_ticket']; ?>">
        <button type="button" class="btn btn-success" onclick="Update_Ticket()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".multivalue").select2({
        tags: true
    });

    $('.multivalue').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    function Follow_Up() {
        Cargando();

        var url = "<?php echo site_url(); ?>General/Busca_Follow_Up_Ticket";
        var id_solicitante = $('#id_solicitante').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_solicitante': id_solicitante},
            success: function(data) {
                $('#follow_up').html(data);
            }
        });
    }

    function Proyecto() {
        Cargando();

        var url = "<?php echo site_url(); ?>General/Busca_Proyecto_Ticket";
        var id_empresa = $('#id_empresa').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa': id_empresa},
            success: function(data) {
                $('#id_proyecto_soporte').html(data);
                $('#id_subproyecto_soporte').html('<option value="0">Seleccione</option>');
            }
        });
    }

    function Subproyecto() {
        Cargando();

        var url = "<?php echo site_url(); ?>General/Busca_Subproyecto_Ticket";
        var id_empresa = $('#id_empresa').val();
        var id_proyecto_soporte = $('#id_proyecto_soporte').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_empresa': id_empresa,'id_proyecto_soporte': id_proyecto_soporte},
            success: function(data) {
                $('#id_subproyecto_soporte').html(data);
            }
        });
    }

    function Update_Ticket() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "<?php echo site_url(); ?>General/Update_Ticket";
        var id_ticket = $('#id_ticket').val();

        if (Valida_Update_Ticket()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    $("#acceso_modal_mod").modal('hide');
                    Insert_Historial();
                    window.location.reload();
                }
            });
        }
    }

    function Valida_Update_Ticket() {
        if ($('#id_tipo_ticket').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_solicitante').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Solicitante.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_empresa').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_proyecto_soporte').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Proyecto.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_subproyecto_soporte').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Subproyecto.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#ticket_desc').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#prioridad').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Prioridad.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#ticket_obs').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar la observación.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }

    function Status_I() {
        var id_status_ticket = $('#id_status_ticket_i').val();
        var div_colaborador = document.getElementById("div_colaborador_i");
        var div_horas = document.getElementById("div_horas_i");
        var div_minutos = document.getElementById("div_minutos_i");
        var div_revision = document.getElementById("div_revision_i");

        if (id_status_ticket == 20) {
            div_colaborador.style.display = "block";
            div_horas.style.display = "block";
            div_minutos.style.display = "block";
        } else if (id_status_ticket == 2 || id_status_ticket == 23) {
            div_horas.style.display = "block";
            div_minutos.style.display = "block";
        } else {
            div_colaborador.style.display = "none";
            div_horas.style.display = "none";
            div_minutos.style.display = "none";
        }

        if (id_status_ticket == 34) {
            div_revision.style.display = "block";
        } else {
            div_revision.style.display = "none";
        }
    }

    function Insert_Historial() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "<?php echo site_url(); ?>General/Insert_Historial_Ticket";
        var id_ticket = $('#id_ticket').val();

        if (Valida_Insert_Historial()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    $("#modal_form_vertical .close").click()
                    Lista_Historial_Ticket();
                }
            });
        }
    }

    function Valida_Insert_Historial() {
        if ($('#id_status_ticket_i').val() == 2) {
            if ($('#horas_i').val().trim() == '' && $('#minutos_i').val().trim() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Tiempo.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#horas_i').val() < 2) {
                Swal(
                    'Ups!',
                    'Debe ingresar Tiempo mayor o igual a 2h.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#id_status_ticket_i').val() == 23) {
            if ($('#horas_i').val().trim() == '' && $('#minutos_i').val().trim() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Tiempo.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#id_status_ticket_i').val() == 20) {
            if ($('#id_mantenimiento_i').val().trim() == '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar Programador.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        return true;
    }
</script>