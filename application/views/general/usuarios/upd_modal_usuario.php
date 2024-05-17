<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate action="javascript:void(0);">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #715d74;font-size: 21px;"><b>Actualizar Usuario</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body">
        <div class="col-md-12 row">
            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Perfil:</label>
                <div class="col">
                    <select class="form-control" name="id_nivel_u" id="id_nivel_u">
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['id_nivel']))) {
                                                echo "selected=\"selected\"";
                                            } ?>>Seleccione</option>
                        <?php foreach ($list_nivel as $tipo) { ?>
                            <option value="<?php echo $tipo['id_nivel']; ?>" <?php if (!(strcmp($tipo['id_nivel'], $get_id[0]['id_nivel']))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>><?php echo $tipo['nom_nivel']; ?></option>
                        <?php } ?> 
                    </select>
                </div>
            </div>



            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Apellido Paterno:</label>
                <div class="col">
                    <input type="text" required class="form-control" id="usuario_apater_u" name="usuario_apater_u" value="<?php echo $get_id[0]['usuario_apater']; ?>" placeholder="Ingresar A. Paterno" autofocus>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold" for="usuario_amater">Apellido Materno:</label>
                <div class="col">
                    <input type="text" required class="form-control" id="usuario_amater_u" name="usuario_amater_u" value="<?php echo $get_id[0]['usuario_amater']; ?>" placeholder="Ingresar A. Materno" autofocus>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold" for="usuario_nombres">Nombres:</label>
                <div class="col">
                    <input type="text" required class="form-control" id="usuario_nombres_u" name="usuario_nombres_u" value="<?php echo $get_id[0]['usuario_nombres']; ?>" placeholder="Ingresar Nombres" autofocus>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold" for="emailp">Correo:</label>
                <div class="col">
                    <input type="email" required class="form-control" id="emailp_u" name="emailp_u" aria-describedby="emailHelp" placeholder="Email" value="<?php echo $get_id[0]['emailp']; ?>">
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Celular:</label>
                <div class="col">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i> </div>
                    </div>
                    <input type="text" required maxlength="9" class="form-control" id="num_celp_u" name="num_celp_u" maxlength="9" placeholder="Ingresar Celular" autofocus value="<?php echo $get_id[0]['num_celp']; ?>">
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Codigo GLL:</label>
                <div class="col">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-code" aria-hidden="true"></i></div>
                    </div>
                    <input type="text" required maxlength="5" class="form-control" id="codigo_gllg_u" name="codigo_gllg_u" placeholder="Ingresar Código" value="<?php echo $get_id[0]['codigo_gllg']; ?>">
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Inicio Funciones:</label>
                <div class="col">
                    <input class="form-control" type="date" id="ini_funciones_u" name="ini_funciones_u" value="<?php echo $get_id[0]['ini_funciones']; ?>" />
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Termino Funciones:</label>
                <div class="col">
                    <input class="form-control" type="date" id="fin_funciones_u" name="fin_funciones_u" value="<?php echo $get_id[0]['fin_funciones']; ?>" />
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Status:</label>
                <div class="col">
                    <select class="form-control" name="id_status_u" id="id_status_u">
                        <option value="0" <?php if (!(strcmp(0, $get_id[0]['estado']))) {
                                                echo "selected=\"selected\"";
                                            } ?>>Seleccione</option>
                        <?php foreach ($list_estado as $estado) { ?>
                            <option value="<?php echo $estado['id_status']; ?>" <?php if (!(strcmp($estado['id_status'], $get_id[0]['estado']))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>><?php echo $estado['nom_status']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold" for="usuario_codigo">Usuario:</label>
                <div class="col">
                    <input type="text" required class="form-control" id="usuario_codigo_u" name="usuario_codigo_u" placeholder="Ingresar Usuario" aria-describedby="inputGroupPrepend2" value="<?php echo $get_id[0]['usuario_codigo']; ?>">
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Clave:</label>
                <div class="col">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend2"><i class="fa fa-key" aria-hidden="true"></i></span>
                    </div>
                    <input type="password" required class="form-control" id="usuario_password_u" name="usuario_password_u" placeholder="Ingresar Clave " aria-describedby="inputGroupPrepend2">
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Week Snappy Artes:</label>
                <div class="col">
                    <input type="text" required class="form-control" id="artes_u" name="artes_u" min="1" maxlength="3" value="<?php echo $get_id[0]['artes'] ?>" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Artes" autofocus>
                </div>
            </div>


            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Week Snappy Redes:</label>
                <div class="col">
                    <input type="text" required class="form-control" id="redes_u" name="redes_u" min="1" maxlength="3" value="<?php echo $get_id[0]['redes'] ?>" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Ingresar Redes" autofocus>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Clave Asistencia:</label>
                <div class="col">
                    <input type="text" class="form-control" id="clave_asistencia_u" name="clave_asistencia_u" maxlength="6" placeholder="Ingresar Clave Asistencia" value="<?php echo $get_id[0]['clave_asistencia']; ?>">
                </div>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label class="col-sm-3 control-label text-bold">Observaciones: </label>

                <div class="col">
                    <textarea name="observaciones_u" required rows="4" class="form-control" id="observaciones_u"><?php echo $get_id[0]['observaciones']; ?></textarea>
                </div>
            </div>
            <div class=" form-group col-md-12">
                <label class="control-label text-bold">Empresas:&nbsp;&nbsp;&nbsp;</label>
                <div class="col">
                    <?php foreach ($list_empresa as $list) { ?>
                        <label>
                            <input type="checkbox" id="id_empresa_u[]" name="id_empresa_u[]" value="<?php echo $list['id_empresa']; ?>" <?php foreach ($get_empresa as $empresa) {
                                                                                                                                        if ($empresa['id_empresa'] == $list['id_empresa']) {
                                                                                                                                            echo "checked";
                                                                                                                                        }
                                                                                                                                    } ?> class="check_empresa" onchange="Traer_Usuario_Sede_U()">
                            <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
                        </label>
                    <?php } ?>
                </div>
            </div>

            <div id="div_sedes" class="form-group col-md-12">
                <?php if ($cantidad_empresa != 0) { ?>
                    <label class="control-label text-bold">Sedes:&nbsp;&nbsp;&nbsp;</label>
                    <div class="col">
                        <?php foreach ($list_sede as $list) { ?>
                            <label>
                                <input type="checkbox" id="id_sede_u[]" name="id_sede_u[]" value="<?php echo $list['id_sede']; ?>" <?php foreach ($get_sede as $sede) {
                                                                                                                                    if ($sede['id_sede'] == $list['id_sede']) {
                                                                                                                                        echo "checked";
                                                                                                                                    }
                                                                                                                                } ?> class="check_sede">
                                <span style="font-weight:normal"><?php echo $list['cod_sede']; ?></span>&nbsp;&nbsp;
                            </label>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $get_id[0]['id_usuario']; ?>">
        <button type="button" style="background-color:#715d74;border-color:#715d74" class="btn btn-primary" onclick="Update_Usuario();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>


<script>
    function pulsar(e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            //document.querySelector("#submit").click();
            Update_Usuario();
        }
    }
    $('#num_celp').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#codigo_gllg').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#artes').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#redes').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });

    function Traer_Usuario_Sede_U() {
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
        var url = "<?php echo site_url(); ?>General/Traer_Usuario_Sede_U";

        $.ajax({
            url: url,
            type: 'POST',
            data: dataString,
            processData: false,
            contentType: false,
            success: function(data) {
                $('#div_sedes').html(data);
            }
        });
    }

    function Update_Usuario() {
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
        var url = "<?php echo site_url(); ?>General/Update_Usuario";

        if (Valida_Update_Usuario()) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function() {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>General/Usuario";
                    });
                }
            });
        }
    }

    function Valida_Update_Usuario() {
        if ($('#id_nivel_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Perfil.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#usuario_apater_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar A. Paterno.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#usuario_amater_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar A. Materno.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#usuario_nombres_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombres.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#emailp_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Correo.',
                'warning'
            ).then(function() {});
            return false;
        }

        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if ((re.test($('#emailp_u').val())) == false) {
            Swal(
                'Ups!',
                'Ingresar correo válido.',
                'warning'
            ).then(function() {});
            return false;
        }

        if ($('#num_celp_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Celular.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#codigo_gllg_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#codigo_gllg_u').val().length < 5) {
            Swal(
                'Ups!',
                'Debe ingresar Código GLL con 5 dígitos.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#ini_funciones_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_status_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Status.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#usuario_codigo_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Usuario.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>