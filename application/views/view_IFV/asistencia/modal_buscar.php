<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Registrar Ingreso</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alumno:</label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control basic" name="alumno" id="alumno" onchange="Traer_Pendientes();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_alumno as $list){  ?>
                        <option value="<?php echo $list['Codigoa']; ?>"><?php echo $list['nombres']; ?></option> 
                    <?php } ?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="documentos_pendientes" name="documentos_pendientes">
        <button type="button" class="btn btn-primary" onclick="Insert_Alumno_FV_Modal()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    var ss = $(".basic").select2({
        tags: true,
    });

    $('.basic').select2({
        dropdownParent: $('#acceso_modal')
    });

    function Traer_Pendientes(){
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

        var url="<?php echo site_url(); ?>AppIFV/Traer_Pendientes";
        var alumno = $('#alumno').val();

        $.ajax({
            type:"POST",
            url: url,
            data: {'alumno':alumno},
            success:function (data) {
                $('#documentos_pendientes').val(data);
            }
        });
    }

    function Insert_Alumno_FV_Modal(){
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
        var url = "<?php echo site_url(); ?>AppIFV/Insert_Alumno_FV_Modal";
        var url2 = "<?php echo site_url(); ?>AppIFV/ReInsert_Alumno_FV_Modal";
        var url3 = "<?php echo site_url(); ?>AppIFV/Update_Alumno_FV_Modal";
        var documentos_pendientes = $('#documentos_pendientes').val();
        var alumno = $('#alumno').val();

        if(Valida_Insert_Alumno_FV_Modal()){
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success: function(data){
                    if(data=="error"){
                        swal.fire(
                            'Registro Denegado',
                            '¡No se encontró el alumno!',
                            'error'
                        ).then(function() {
                            $('#div_busqueda').html('');
                        });
                    }else if(data=="repetido"){
                        Swal({
                            title: '¿Realmente desea registrar nuevamente el ingreso',
                            text: "El registro será registrado nuevamente",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    type: "POST",
                                    url: url2,
                                    data: dataString,
                                    processData: false,
                                    contentType: false,
                                    success:function (data) {
                                        $('#div_busqueda').html(data);
                                        $("#acceso_modal .close").click()
                                        Lista_Registro_Ingreso();
                                        Botones_Bajos();
                                        if($('#simbolo').val()==1){
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==2){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==3){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_error").modal("show");
                                            $("#alumno_condicionado").val(codigo_alumno);
                                        }
                                    }
                                });
                            }
                        })
                    }else if(data=="pagos"){
                        swal.fire(
                            'Registro Denegado',
                            '¡Pendiente Pago Mat + Cuota 1!',
                            'error'
                        ).then(function() {
                            $('#div_busqueda').html('');
                        });
                    }else if(data=="cuotas"){
                        swal.fire(
                            '¡No apto para ingreso!',
                            'Pendiente pagos',
                            'error'
                        ).then(function() {
                            $('#div_busqueda').html('');
                        });
                    }else if(data=="reingreso"){
                        Swal({
                            title: '¿Realmente desea registrar nuevamente el ingreso',
                            text: "El registro será registrado nuevamente",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si',
                            cancelButtonText: 'No',
                        }).then((result) => {
                            if (result.value) {
                                $.ajax({
                                    type: "POST",
                                    url: url2,
                                    data: dataString,
                                    processData: false,
                                    contentType: false,
                                    success:function (data) {
                                        $('#div_busqueda').html(data);
                                        $("#acceso_modal .close").click()
                                        Lista_Registro_Ingreso();
                                        Botones_Bajos();
                                        if($('#simbolo').val()==1){
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==2){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==3){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_error").modal("show");
                                            $("#alumno_condicionado").val(codigo_alumno);
                                        }
                                    }
                                });
                            }else{
                                $.ajax({
                                    type: "POST",
                                    url: url3,
                                    data: dataString,
                                    processData: false,
                                    contentType: false,
                                    success:function (data) {
                                        $('#div_busqueda').html(data);
                                        $("#acceso_modal .close").click()
                                        Lista_Registro_Ingreso();
                                        Botones_Bajos();
                                        if($('#simbolo').val()==1){
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==2){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_mod").modal("show");
                                            $("#alumno_observacion").val(codigo_alumno);
                                        }else if($('#simbolo').val()==3){
                                            $("#modal_ver").modal("show");
                                            //$("#acceso_modal_error").modal("show");
                                            $("#alumno_condicionado").val(codigo_alumno);
                                        }
                                    }
                                });
                            }
                        })
                    }else if(data=="duplicidad"){
                        swal.fire(
                            '¡Registro Denegado!',
                            'No se puede hacer más de 10 registros manuales',
                            'error' 
                        ).then(function() {
                            $('#div_busqueda').html('');
                        });
                    }else{
                        $('#div_busqueda').html(data);
                        $("#acceso_modal .close").click()
                        Lista_Registro_Ingreso();
                        Botones_Bajos();
                        if($('#simbolo').val()==1){
                            //$("#acceso_modal_mod").modal("show");
                            $("#alumno_observacion").val(codigo_alumno);
                        }else if($('#simbolo').val()==2){
                            $("#modal_ver").modal("show");
                            //$("#acceso_modal_mod").modal("show");
                            $("#alumno_observacion").val(codigo_alumno);
                        }else if($('#simbolo').val()==3){
                            $("#modal_ver").modal("show");
                            //$("#acceso_modal_error").modal("show");
                            $("#alumno_condicionado").val(codigo_alumno);
                        }
                    }
                }  
            });
        }
        
        $('#codigo_alumno').val('');
        $('#codigo_alumno').focus();
    }

    function Valida_Insert_Alumno_FV_Modal() {
        if($('#alumno').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
