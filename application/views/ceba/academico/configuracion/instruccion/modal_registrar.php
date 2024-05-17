
<form method="post" id="formulario" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Instrucción (Nueva)</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Grado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_grado" id="id_grado" onchange="Modulo()">
                    <option value="0">Seleccione</option>
                        <?php foreach($list_grado as $area){ ?>
                        <option value="<?php echo $area['id_grado']; ?>"><?php echo $area['descripcion_grado'];?></option>
                        <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Módulo: </label>
            </div>
            <div class="form-group col-md-4" id="munidad">
                <select class="form-control" name="id_unidad" id="id_unidad" onchange="Tema()">
                    <option  value="0"  selected>Seleccionar</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Tema: </label>
            </div>
            <div class="form-group col-md-4" id="mtema">
                <select class="form-control" name="id_tema" id="id_tema" >
                    <option  value="0"  selected>Seleccionar</option>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label class="form-group col text-bold">Registrado&nbsp;por: </label>
            </div>
            <div class="form-group col-md-3">
                <?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Imagen: </label>
            </div>
            <div class="form-group col-md-6 uno" align="left">   
                <input name="imagen_instru" id="imagen_instru" type="file" size="100" required data-allowed-file-extensions='["png|mp4"]'>
            </div>
        </div>

        <div class="form-group col-md-2">
            <label class="form-group col text-bold">Regla: </label>
        </div>
        <div class="form-group col-md-10">
            <textarea class="form-control" required id="regla"  maxlength="200" name="regla" placeholder= "Ingresar Regla" rows="4" cols="50"></textarea>
        </div>
    </div> 

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Instruccion();">
            <i class="glyphicon glyphicon-ok-sign"></i>Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Modulo(){
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
        
        var url = "<?php echo site_url(); ?>Ceba/Grado_Unidad";
        $.ajax({
            url: url,
            type: 'POST',
            data: $("#formulario").serialize(),
            success: function(data)             
            {
                $('#munidad').html(data);
            }
        });
        Tema();
    }

    function Tema(){
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

        var url = "<?php echo site_url(); ?>Ceba/Unidad_Tema";
        $.ajax({
            url: url,
            type: 'POST',
            data: $("#formulario").serialize(),
            success: function(data)             
            {
                $('#mtema').html(data);
            }
        });
    }

    function Insert_Instruccion(){
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

        var dataString = new FormData(document.getElementById('formulario'));
        var url="<?php echo site_url(); ?>Ceba/Insert_Instruccion";

        if (Valida_Insert_Instruccion()) {
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
                            text: "El registro ya existe",
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
                            window.location = "<?php echo site_url(); ?>Ceba/Instruccion";
                        });
                    }
                    
                }
            }); 
        }    
    }

    function Valida_Insert_Instruccion() {
        if($('#id_grado').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_unidad').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Unidad.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#id_tema').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tema.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
</script>
