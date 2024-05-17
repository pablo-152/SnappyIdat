<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title"><b>Editar Email: <?php echo $get_id[0]['alumno']; ?></b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;"> 
        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Email:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="email_alumno_u" name="email_alumno_u" placeholder="Email" value="<?php echo $get_id[0]['email_alumno']; ?>">
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_documento_firma" name="id_documento_firma" value="<?php echo $get_id[0]['id_documento_firma']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Email_Contrato_Efsrt();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Email_Contrato_Efsrt(){ 
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

        var tipo_excel = $('#tipo_excel').val();
        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Email_Contrato_Efsrt";

        if (Valida_Update_Email_Contrato_Efsrt()) { 
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Contrato_Efsrt(tipo_excel);
                    $("#acceso_modal_mod .close").click()
                }
            });
        }
    }

    function Valida_Update_Email_Contrato_Efsrt() {
        if($('#email_alumno_u').val().trim() === '') {
            Swal(
                'Ups!', 
                'Debe ingresar Email.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>