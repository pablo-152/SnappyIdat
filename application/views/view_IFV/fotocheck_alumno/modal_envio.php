<form id="formulario_envio" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Envío</b></h5>
    </div> 

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <?php if ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==7){ ?>
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Fecha:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="date" class="form-control" id="fecha_u" name="fecha_u" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Usuario:</label>
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control" id="id_usuario_u" name="id_usuario_u" onchange="UsuarioM();">
                        <option value="0">Seleccione</option>
                        <option value="1" selected>PVieira</option>
                        <option value="7">VHilario</option>
                        <option value="30">MSchiaffino</option>
                        <option value="35">LBecerra</option>
                        <option value="69">KHuapaya</option>
                        <option value="71">SVillarreal</option>                    
                    </select>
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Cargo:</label>
                </div>
                <div id="select_cargo" name="select_cargo" class="form-group col-md-6">
                    <select class="form-control" id="id_cargo_u" name="id_cargo_u" >
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>  	 
        <?php }else{ ?> 
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Fecha:</label>
                </div>
                <div class="form-group col-md-3">
                    <input type="date" class="form-control" id="fecha_u" name="fecha_u" value="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Usuario:</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="id_usuario_u" name="id_usuario_u" value="<?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?>" disabled>
                </div>
            </div> 

            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Cargo:</label>
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control" id="id_cargo_u" name="id_cargo_u">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_cargo_sesion as $list){ ?>
                            <option value="<?php echo $list['id_cargo']; ?>"><?php echo $list['cod_cargo']." - ".$list['desc_cargo'];  ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        <?php } ?>	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="fecha_actual" value="<?php echo date('Y-m-d'); ?>">
        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_nivel']==6 || $_SESSION['usuario'][0]['id_usuario']==7){ ?>
            <button type="button" class="btn btn-primary" onclick="Guardar_Envio2()">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
        <?php }else{ ?>
            <button type="button" class="btn btn-primary" onclick="Guardar_Envio()">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
        <?php } ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"> 
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>    
    function UsuarioM(){
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

        var usuario_encomienda=$('#id_usuario_u').val();
        var url="<?php echo site_url(); ?>AppIFV/Traer_Cargo_De";

        $.ajax({
            url: url,
            data: {'usuario_encomienda':usuario_encomienda},
            type:"POST",
            success:function (data) {
                $('#select_cargo').html(data);
            }
        });
    }
    
    function Guardar_Envio2() {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var tipo_excel = $('#tipo_excel').val();
        var cantidad=$('#cantidad').val();
        var cadena=$('#cadena').val();
        var fecha_u=$('#fecha_u').val();
        var id_usuario_u=$('#id_usuario_u').val();
        var id_cargo_u=$('#id_cargo_u').val();

        if (Valida_Envio2()) {
            var url = "<?php echo site_url(); ?>AppIFV/Guardar_Envio";

            if (cantidad > 0) {
                Swal({
                    title: '¿Realmente desea actualizar ' + cantidad + ' registros?',
                    text: "Los registros serán actualizados",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({ 
                            type:"POST",
                            url:url,
                            data:{'cadena':cadena,'cantidad':cantidad,'fecha_u':fecha_u,'id_usuario_u':id_usuario_u,'id_cargo_u':id_cargo_u},
                            success: function(data) {
                                if (data == "error") {
                                    Swal({
                                        title: 'Actualización Denegada!',
                                        text: 'Una o más asignaciones ya existen. Por favor verificar',
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                } else {
                                    Lista_Fotocheck_Alumnos(tipo_excel);
                                    $("#LargeLabelModal .close").click()
                                }
                            }
                        });
                    }
                })
            } else {
                Swal({
                    title: 'Ups!',
                    text: 'Debe seleccionar al menos un registro.',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
            }
        }
    }

    function Valida_Envio2() {
        if ($('#id_usuario_u').val() == 0) {
            Swal(
                'Ups!',
                'Debe seleccionar un usuario.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }

    function Guardar_Envio() {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var tipo_excel = $('#tipo_excel').val();
        var cantidad=$('#cantidad').val();
        var cadena=$('#cadena').val();
        var fecha_u=$('#fecha_u').val();
        var id_cargo_u=$('#id_cargo_u').val();

        if (Valida_Envio()) {
            var url = "<?php echo site_url(); ?>AppIFV/Guardar_Envio";

            if (cantidad > 0) {
                Swal({
                    title: '¿Realmente desea actualizar ' + cantidad + ' registros?',
                    text: "Los registros serán actualizados",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type:"POST",
                            url:url,
                            data:{'cadena':cadena,'cantidad':cantidad,'fecha_u':fecha_u,'id_cargo_u':id_cargo_u},
                            success: function(data) {
                                if (data == "error") {
                                    Swal({
                                        title: 'Actualización Denegada!',
                                        text: 'Una o más asignaciones ya existen. Por favor verificar',
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                } else {
                                    Lista_Fotocheck_Alumnos(tipo_excel);
                                    $("#LargeLabelModal .close").click()
                                }
                            }
                        });
                    }
                })
            } else {
                Swal({
                    title: 'Ups!',
                    text: 'Debe seleccionar al menos un registro.',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
            }
        }
    }

    function Valida_Envio() {
        if ($('#fecha_u').val() < $('#fecha_actual').val()) {
            Swal(
                'Ups!',
                'No debe ingresar una fecha pasada.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#id_cargo_u').val() == 0) {
            Swal(
                'Ups!',
                'Debe seleccionar un cargo.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>

