<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Recomendado</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">DNI Alumno:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="DNI Alumno" disabled value="<?php echo $get_id[0]['dni_alumno']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Código" disabled value="<?php echo $get_id[0]['codigo']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Especialidad:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Especialidad" disabled value="<?php echo $get_id[0]['especialidad']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Validado:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="validado1" name="validado1" placeholder="Validado" maxlength="15" value="<?php echo $get_id[0]['validado1']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Registro:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Registro" disabled value="<?php echo $get_id[0]['registro']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">DNI Reco.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="DNI Recomendado" disabled value="<?php echo $get_id[0]['dni_recomendado']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Celular:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Celular" disabled value="<?php echo $get_id[0]['celular']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Correo Elec.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" placeholder="Correo Electrónico" disabled value="<?php echo $get_id[0]['correo']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="estado_r" name="estado_r" placeholder="Estado" maxlength="15" value="<?php echo $get_id[0]['estado_r']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Validado:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="validado2" name="validado2" placeholder="Validado" value="<?php echo $get_id[0]['validado2']; ?>">
            </div>
        </div>  		           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_recomendado" name="id_recomendado" value="<?php echo $get_id[0]['id_recomendado']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Recomendados()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Recomendados(){
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
        var url="<?php echo site_url(); ?>Administrador/Update_Recomendados";

        if (Valida_Update_Recomendados()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Administrador/Recomendados";
                    });
                }
            });
        }
    }

    function Valida_Update_Recomendados() {
        /*if($('#validado1').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Validado.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        return true;
    }
</script>