<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Unidad</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_unidad_u" name="nom_unidad_u" placeholder="Nombre" value="<?php echo $get_id[0]['nom_unidad']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inicio Clases:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_clase_u" name="inicio_clase_u" value="<?php echo $get_id[0]['inicio_clase']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fin Clases:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fin_clase_u" name="fin_clase_u" value="<?php echo $get_id[0]['fin_clase']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inicio&nbsp;Matrícula:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_matricula_u" name="inicio_matricula_u" value="<?php echo $get_id[0]['inicio_matricula']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fin Matrícula:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fin_matricula_u" name="fin_matricula_u" value="<?php echo $get_id[0]['fin_matricula']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="estado_u" name="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>   		           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_unidad" name="id_unidad" value="<?php echo $get_id[0]['id_unidad']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Unidad()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Unidad(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Ceba2/Update_Unidad";

        if (Valida_Update_Unidad()) {
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
                        Lista_Unidad();
                        $("#acceso_modal_mod .close").click()
                    });
                }
            });
        }
    }

    function Valida_Update_Unidad() {
        if($('#nom_unidad_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_clase_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Inicio Clases.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fin_clase_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fin Clases.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_matricula_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Inicio Matrícula.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fin_matricula_u').val().trim() === '') {
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