<form id="formulario_insert" method="post" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Nuevo Web IFV</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Tipo: </label>
                <div class="col">
                    <select class="form-control" id="flag_referencia_i" name="flag_referencia_i" onchange="Flag_Referencia_I();">
                        <option value="">Seleccione</option>
                        <?php foreach($list_tipo as $list){?> 
                            <option value="<?php echo $list['id'] ?>"><?php echo $list['tipo'] ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6 mostrar_carrera_i">
                <label class="control-label text-bold">Carrera: </label>
                <div class="col">
                    <select class="form-control" id="id_carrera_i" name="id_carrera_i">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_carrera as $list){?> 
                            <option value="<?php echo $list['id_carrera'] ?>"><?php echo $list['nombre'] ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6 mostrar_referencia_i">
                <label class="control-label text-bold">Referencia: </label>
                <div class="col">
                    <input type="text" class="form-control" id="refe_comuimg_i" name="refe_comuimg_i" placeholder="Ingresar Referencia" maxlength="25">
                </div>
            </div>
        </div>
        
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Activo de: </label>
                <div class="col">
                    <input type="date" class="form-control" id="inicio_comuimg_i" name="inicio_comuimg_i">
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Hasta: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fin_comuimg_i" name="fin_comuimg_i">
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class="control-label text-bold">Archivo:</label>
                <input type="file" id="img_comuimg_i" name="img_comuimg_i" onchange="validarExt_I();">
                <p style="color:#867A82;">Maximo 2Mb ó 2048kl</p>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Web_IFV();" >
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Flag_Referencia_I();
    });

    function Flag_Referencia_I(){
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

        var flag_referencia = $('#flag_referencia_i').val();

        if(flag_referencia==1){
            $('.mostrar_carrera_i').show();
            $('.mostrar_referencia_i').hide();
            $('#refe_comuimg_i').val('');
        }else if(flag_referencia==""){
            $('.mostrar_carrera_i').hide();
            $('.mostrar_referencia_i').hide();
            $('#refe_comuimg_i').val('');
            $('#id_carrera_i').val('0');
        }else{
            $('.mostrar_carrera_i').hide();
            $('.mostrar_referencia_i').show();
            $('#id_carrera_i').val('0');
        }
    }

    function validarExt_I(){
        var flag_referencia = $('#flag_referencia_i').val();
        var archivoInput = document.getElementById('img_comuimg_i'); 
        var archivoRuta = archivoInput.value; 

        if(flag_referencia==0 || flag_referencia==1 || flag_referencia==3){
            var extPermitidas = /(.pdf|.PDF)$/i;
            var texto = "extensión .pdf";
        }else{
            var extPermitidas = /(.jpg|.JPG)$/i;
            var texto = "extensión .jpg.";
        }
        
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivo con "+texto,
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false; 
        }else{
            return true;
        }
    }

    function Insert_Web_IFV(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Web_IFV";
        //var url2 = "<?php echo site_url(); ?>AppIFV/Insert_Archivos";

        if (Valida_Insert_Web_IFV()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: 'Existe un registro que coincide con las fechas de publicación ingresada, por favor verificar!',
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        /*$.ajax({  
                            url: url2,
                            data: dataString,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            success: function(data) {*/
                                Lista_Web_IFV(1);
                                $("#acceso_modal .close").click()
                            //}
                        //});
                    }
                }
            });
        }    
    }

    function Valida_Insert_Web_IFV() {
        if ($('#flag_referencia_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#flag_referencia_i').val().trim() === '1') {
            if ($('#id_carrera_i').val().trim() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar Carrera.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#flag_referencia_i').val().trim() === '0'  || $('#flag_referencia_i').val().trim() === '2' || $('#flag_referencia_i').val().trim() === '3') {
            if ($('#refe_comuimg_i').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Referencia.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#inicio_comuimg_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#fin_comuimg_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>

