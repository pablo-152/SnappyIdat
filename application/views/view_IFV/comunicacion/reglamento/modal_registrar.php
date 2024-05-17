<form method="post" id="formulario_reglamento" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Reglamento Interno (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Referencia&nbsp;: </label>
            </div>
            <div class="form-group col-md-6">
                <input maxlength="25" type="text" class="form-control" id="referencia" name="referencia" placeholder="Ingresar Referencia" autofocus>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Activo de&nbsp;: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio" name="inicio" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Hasta&nbsp;: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fin" name="fin"  autofocus>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>
                <input id="archivo" name="archivo" type="file" size="100" required data-allowed-file-extensions='["pdf|PDF"]'>
                <span style="color:#867A82;">PDF/Maximo 2Mb ó 2048kl</span>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button id="btn_producto" name="btn_producto" type="button" onclick="Insert_Reglamento();" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Reglamento() {
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
        var dataString = new FormData(document.getElementById('formulario_reglamento'));
        var url = "<?php echo site_url(); ?>AppIFV/Insertar_Reglamento";
        var url2 = "<?php echo site_url(); ?>AppIFV/InsertarPDF_Reglamento";
        if (valida_insert_reglamento()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    $.ajax({
                        url: url2,
                        data: dataString,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            swal.fire(
                                'Su PDF Reglamento Interno se ha guardado correctamente',
                                '',
                                'success'
                            ).then(function() {
                                window.location = "<?php echo site_url(); ?>AppIFV/PDF_Reglamento";
                            });
                        }
                    });
                }
            });
        }
    }

    function valida_insert_reglamento() {
        if ($('#referencia').val() === '') {
            Swal(
                'Ups!',
                'Debe Ingresar una Referencia.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#inicio').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#fin').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Fecha Fin.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#archivo').val() === '') {
            Swal(
                'Ups!',
                'Debe adjuntar Archivo.',
                'warning'
            ).then(function() {});
            return false;
        }
        return true;
    }
</script>
