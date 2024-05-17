<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Unidad (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_unidad_i" name="nom_unidad_i" placeholder="Nombre">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inicio Clases:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_clase_i" name="inicio_clase_i">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fin Clases:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fin_clase_i" name="fin_clase_i">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inicio&nbsp;Matrícula:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_matricula_i" name="inicio_matricula_i">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fin Matrícula:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fin_matricula_i" name="fin_matricula_i">
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Unidad()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Unidad(){
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
        var url="<?php echo site_url(); ?>Ceba2/Insert_Unidad";

        if (Valida_Insert_Unidad()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Unidad();
                        $("#acceso_modal .close").click()
                    });
                }
            });
        }
    }

    function Valida_Insert_Unidad() {
        if($('#nom_unidad_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_clase_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Inicio Clases.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fin_clase_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fin Clases.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_matricula_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Inicio Matrícula.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fin_matricula_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fin Matrícula.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
