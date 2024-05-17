<form id="formulario_usuario" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate action="javascript:void(0);">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Seleccionar <?php if($accion==3){echo "Administrador"; }else{echo "Alumno"; }?></b></h5>
    </div>

    <div class="modal-body">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="form-group col text-bold">Como Registrar:</label>
                <div class="col">
                    <input type="radio" name="estado" id="estadosi" value="1" checked="checked" onclick="Como_Registrar('1')">
                    Digitar
                    <input type="radio" name="estado" id="estadono" value="2"  onclick="Como_Registrar('2')"> 
                    Buscar
                </div>
            </div>
            <div class="form-group col-md-12">
            </div>
            <div class="form-group col-md-4 mb-3" id="div_digitar">
                <label class="form-group col text-bold">Código de <?php if($accion==3){echo "Administrador"; }else{echo "Alumno"; }?>:</label>
                <div class="col">
                    <input  type="text" required class="form-control" id="cod_alumno" name="cod_alumno" placeholder="Ingresar Código" autofocus>
                </div>
            </div>
            <div class="form-group col-md-4 mb-3" id="div_buscar" style="display:none">
                <label class="form-group col text-bold"><?php if($accion==3){echo "Administrador"; }else{echo "Alumno"; }?>:</label>
                <div class="col" id="cmb_buscar">
                    <input type="hidden" id="buscar" name="buscar" value="0">
                    <select  class="form-control" name="InternalStudentId" id="InternalStudentId" required>
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Validar('<?php echo $accion; ?>');">
            <i class="glyphicon glyphicon-ok-sign"></i> Aceptar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Como_Registrar(c){
		var div1 = document.getElementById("div_buscar");
		var div2 = document.getElementById("div_digitar");
        $('#InternalStudentId').val('0');
        $('#cod_alumno').val('');
		if(c==1){
			div1.style.display = "none";
			div2.style.display = "block";
		}else{
			div1.style.display = "block";
			div2.style.display = "none";
            if($('#buscar').val()=="0"){
                $(document).ajaxStart(function () {
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
                var url="<?php echo site_url(); ?>AppIFV/Buscar_Alumno_Cmb/"+<?php echo $accion; ?>;
                $.ajax({
                    type:"POST",
                    url: url,
                    success:function (data) {
                        $('#cmb_buscar').html(data);
                    }
                });
            }
		}
	}


    function Validar(a)
    {
		
        var url="<?php echo site_url(); ?>AppIFV/Buscar_Alumno";
        var codigo=$('#cod_alumno').val();
		var codigo_d=$('#InternalStudentId').val();
		var accion=a;
        var cod=codigo;
		if ($('#estadosi').is(":checked")){
			if(cod.trim()===""){
            Swal(
                    '',
                    '<b>Debe ingresar código de alumno para validar!</b>',
                    'warning'
                ).then(function() { });
            }else{
                $(document).ajaxStart(function () {
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
                $.ajax({
                    type:"POST",
                    url: url,
                    data:{'codigo':cod,'accion':accion},
                    success:function (data) {
                        var cadena = data;
                        validacion = cadena.substr(0, 1);
                        mensaje = cadena.substr(1);
                        if(validacion==1){
                            Swal(
                                'Sin Resultados',
                                mensaje,
                                'error'
                            ).then(function() { });
                        }if(validacion==3){
                            Swal(
                                'Sin Resultados',
                                mensaje,
                                'error'
                            ).then(function() { });
                        }if(validacion==""){
                            var url="<?php echo site_url(); ?>AppIFV/Consulta_Almuno_Temporal_Biblioteca";
                            $.ajax({
                                url:url,
                                type:"POST",
                                success:function (data) {
                                    $('#div_alumno').html(data);
                                    $("#acceso_modal_mod .close").click()
                                }
                            });
                        }
                    }
                });
            }
		}else{
            if($('#InternalStudentId').val()==="0"){
            Swal(
                    '',
                    '<b>Debe seleccionar alumno para validar!</b>',
                    'warning'
                ).then(function() { });
            }else{
                $(document).ajaxStart(function () {
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
                $.ajax({
                    type:"POST",
                    url: url,
                    data:{'codigo':codigo_d,'accion':accion},
                    success:function (data) {
                        var cadena = data;
                        validacion = cadena.substr(0, 1);
                        mensaje = cadena.substr(1);
                        if(validacion==1){
                            Swal(
                                'Sin Resultados',
                                mensaje,
                                'error'
                            ).then(function() { });
                        }if(validacion==3){
                            Swal(
                                'Sin Resultados',
                                mensaje,
                                'error'
                            ).then(function() { });
                        }if(validacion==""){
                            var url="<?php echo site_url(); ?>AppIFV/Consulta_Almuno_Temporal_Biblioteca";
                            $.ajax({
                                url:url,
                                type:"POST",
                                success:function (data) {
                                    $('#div_alumno').html(data);
                                    $("#acceso_modal_mod .close").click()
                                }
                            });
                        }
                    }
                });
            }
        }
        
        
        
    }
</script>