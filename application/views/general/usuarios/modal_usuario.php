<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate action="javascript:void(0);">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Usuario (Nuevo)</b></h5>
    </div>

    <div class="modal-body">
        <div class="col-md-12 row">
            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Perfil:</label>
                <div class="col">
                    <select  class="form-control" name="id_nivel_i" id="id_nivel_i" required>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_nivel as $tipo){ ?>
                            <option value="<?php echo $tipo['id_nivel']; ?>"><?php echo $tipo['nom_nivel'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Apellido Paterno:</label>
                <div class="col">
                    <input  type="text" required class="form-control" id="usuario_apater_i" name="usuario_apater_i" placeholder="Ingresar A. Paterno" autofocus>
                </div>
            </div>
                    
            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Apellido Materno:</label>
                <div class="col">
                    <input  type="text" required class="form-control" id="usuario_amater_i" name="usuario_amater_i" placeholder="Ingresar A. Materno" autofocus>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Nombres:</label>
                <div class="col">
                    <input  type="text" required class="form-control" id="usuario_nombres_i" name="usuario_nombres_i" placeholder="Ingresar Nombres" autofocus>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold" for="emailp" >Correo:</label>
                <div class=" col">
                    <input type="email" required class="form-control"  id="emailp_i" name="emailp_i" aria-describedby="emailHelp" placeholder="Email">
                </div>     
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Celular:</label>
                <div class=" col">
                    
                    <input type="text" required maxlength="9" class="form-control" id="num_celp_i" name="num_celp_i" maxlength="9" placeholder="Ingresar Celular"    autofocus>
                </div>          
                </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Codigo GLL:</label>
                <div class="input-group col">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-code" aria-hidden="true"></i></div>
                    </div>
                    <input  type="text" required maxlength="5" class="form-control" id="codigo_gllg_i" name="codigo_gllg_i" placeholder="Ingresar Código" autofocus >
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Inicio Funciones:</label> 
                <div class="col">
                    <input class="form-control" type="date" id="ini_funciones_i" name="ini_funciones_i"/>
                </div>          
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold" for="usuario_codigo" >Usuario:</label>
                <div class="col">
                    
                    <input type="text" required class="form-control" id="usuario_codigo_i" name="usuario_codigo_i" placeholder="Ingresar Usuario" aria-describedby="inputGroupPrepend2" required>
                </div>
            </div>
                    
            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Clave:</label>
                <div class="col">
                    <input type="password" required class="form-control" id="usuario_password_i" name="usuario_password_i" placeholder="Ingresar Clave " aria-describedby="inputGroupPrepend2" required>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                    <label class="form-group col text-bold">Week Snappy Artes:</label>
                <div class="col">
                <input  type="text" required class="form-control" id="artes_i" name="artes_i" min="1" maxlength="3"   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"   placeholder="Ingresar Artes" autofocus>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                    <label class="form-group col text-bold">Week Snappy Redes:</label>
                <div class="col">
                <input  type="text" required class="form-control" id="redes_i" name="redes_i" min="1" maxlength="3"   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"   placeholder="Ingresar Redes" autofocus>
                </div>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label class="form-group col text-bold">Clave Asistencia:</label>
                <div class="col">
                    <input type="text" class="form-control" id="clave_asistencia_i" name="clave_asistencia_i" maxlength="6" placeholder="Ingresar Clave Asistencia">
                </div>
            </div>

            <div class="form-group col-md-12 mb-3">
                <label class="form-group col text-bold">Observaciones: </label>
                <div class="col">
                    <textarea name="observaciones_i" rows="5" class="form-control" id="observaciones_i" placeholder="Observaciones"></textarea>
                </div>
            </div>

            <div class=" form-group col-md-12">
                <label class="control-label text-bold" >Empresas:&nbsp;&nbsp;&nbsp;</label>
                <div class="col">
                    <?php foreach($list_empresa as $list){ ?>
                        <label>
                            <input type="checkbox" id="id_empresa_i[]" name="id_empresa_i[]" value="<?php echo $list['id_empresa']; ?>" class="check_empresa" onchange="Traer_Usuario_Sede_I()">
                            <span style="font-weight:normal"><?php echo $list['cod_empresa']; ?></span>&nbsp;&nbsp;
                        </label>
                    <?php } ?>
                </div>
            </div>

            <div id="div_sedes" class="form-group col-md-12">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Usuario();">
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
            Insert_Usuario();
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

    function Traer_Usuario_Sede_I(){
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
        var url="<?php echo site_url(); ?>General/Traer_Usuario_Sede_I";

        $.ajax({
            url: url,
            type: 'POST',
            data:dataString,
            processData: false,
            contentType: false, 
            success:function (data) {
                $('#div_sedes').html(data);
            }
        });
    }

    function Insert_Usuario(){
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
        var url="<?php echo site_url(); ?>General/Insert_Usuario";

        if(Valida_Insert_Usuario()){
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
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>General/Usuario";
                        });
                    }
                }
            });
        }
    }

    function Valida_Insert_Usuario() {
        if ($('#id_nivel_i').val() === '0'){
            Swal(
                'Ups!',
                'Debe seleccionar Perfil.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#usuario_apater_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar A. Paterno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#usuario_amater_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar A. Materno.',
                'warning'
            ).then(function() { });
            return false;
        }  
        if($('#usuario_nombres_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombres.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#emailp_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Correo.',
                'warning'
            ).then(function() { });
            return false;
        }

        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  
        if((re.test($('#emailp_i').val()))==false){
            Swal(
                'Ups!',
                'Ingresar correo válido.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#num_celp_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Celular.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#codigo_gllg_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#codigo_gllg_i').val().length<5){
            Swal(
                'Ups!',
                'Debe ingresar Código GLL con 5 dígitos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#ini_funciones_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Inicio.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#usuario_codigo_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Usuario.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#usuario_password_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Clave.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>