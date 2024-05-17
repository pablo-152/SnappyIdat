<form method="post" id="formulario_pdf" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Resultado IFV (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Tipo: </label>
                <div class="col">
                    <select class="form-control" id="flag_referencia_i" name="flag_referencia_i" onchange="Flag_Referencia_I();">
                        <option value="">Seleccione</option>
                        <option value="0">Resultados IFV</option>
                        <option value="1">Triptico</option>
                    </select>
                </div>
            </div>

            <div id="div_triptico_i" class="form-group col-md-6" style="display:none">
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

            <div id="div_otro_i" class="form-group col-md-6" style="display:none">
                <label class="control-label text-bold">Referencia: </label>
                <div class="col">
                    <input maxlength="25" type="text" class="form-control" id="refe_comuimg_i" name="refe_comuimg_i" placeholder="Ingresar Referencia">
                </div>
            </div>
        </div>
        

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Activo de&nbsp;: </label>
                <div class="col">
                    <input type="date" class="form-control" id="inicio_comuimg_i" name="inicio_comuimg_i">
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Hasta&nbsp;: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fin_comuimg_i" name="fin_comuimg_i">
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>
                <input id="img_comuimg_i" name="img_comuimg_i" type="file" size="100" required data-allowed-file-extensions='["pdf|PDF"]'>
                <span style="color:#867A82;">PDF/Maximo 2Mb ó 2048kl</span>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Estado&nbsp;: </label>
                <div class="col">
                    <select class="form-control" name="estado_i" id="estado_i">
                        <option value="0">Seleccionar</option>
                        <?php foreach ($list_statusva as $list) { ?>
                        <?php if(1 == $list['id_statusav']){ ?>
                            <option selected value="<?php echo $list['id_statusav']; ?>"><?php echo $list['nom_status']; ?></option>
                            <?php }else{?>
                            <option value="<?php echo $list['id_statusav']; ?>"><?php echo $list['nom_status'];?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Comu_Img();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Comu_Img() {
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

        var dataString = new FormData(document.getElementById('formulario_pdf'));
        var url = "<?php echo site_url(); ?>AppIFV/Insert_ComuImg";
        var url2 = "<?php echo site_url(); ?>AppIFV/InsertarPDFIFV";

        if (Valida_Insert_Comu_Img()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
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
                        $.ajax({
                            url: url2,
                            data: dataString,
                            type: "POST",
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                swal.fire(
                                    'Registro Exitoso',
                                    'Haga clic en el botón!',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>AppIFV/PDF_Admision";
                                });
                            }
                        });
                    }
                }
            });
        }
    }

    function Valida_Insert_Comu_Img() {
        if ($('#flag_referencia').val() === '') {
            Swal(
                'Ups!',
                'Debe Seleccionar Tipo.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#flag_referencia').val() === '1') {
            if ($('#id_carrera').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe Seleccionar Carrera.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#flag_referencia').val() === '0') {
            if ($('#refe_comuimg_i').val() === '') {
                Swal(
                    'Ups!',
                    'Debe Ingresar Referencia.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#inicio_comuimg_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#fin_comuimg_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#img_comuimg_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Archivo.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#estado_i').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
    
    function Flag_Referencia_I(){
        var div1 = document.getElementById("div_triptico_i");
        var div2 = document.getElementById("div_otro_i");
        $('#id_carrera_i').val('0');
        $('#refe_comuimg_i').val('');

        if($('#flag_referencia_i').val()!=""){
            if($('#flag_referencia_i').val()=="1"){
                div1.style.display = "block";
                div2.style.display = "none";
            }
            if($('#flag_referencia_i').val()=="0"){
                div1.style.display = "none";
                div2.style.display = "block";
            }
        }else{
            div1.style.display = "none";
            div2.style.display = "none";
        }
    }
</script>

