<form id="formulario_insert_estudiante" class="formulario" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Curso (Nuevo)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <input type="hidden" name="id_curso" id="id_curso" value="<?php echo $id_curso; ?>">

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Alumno: </label>
            </div>

            <div class="form-group col-md-10">
                <select class="form-control" name="id_alumno" id="id_alumno">
                <option value="0">Seleccione</option>
                    <?php foreach($list_alumno as $list){ ?>
                        <option value="<?php echo $list['id_alumno']; ?>"><?php echo $list['alum_nom']." ".$list['alum_apater']." ".$list['alum_amater']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Alumno_Curso();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Alumno_Curso(){
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
        
        var dataString = new FormData(document.getElementById('formulario_insert_estudiante'));
        var url="<?php echo site_url(); ?>Ceba/Insert_Alumno_Curso";
        var id = $('#id_curso').val();

        if (Valida_Insert_Alumno_Curso()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Ceba/Detalles_Curso/"+id;
                        });
                    }
                }
            });       
        }
    }

    function Valida_Insert_Alumno_Curso() {
        if($('#id_alumno').val().trim() === '0') {
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
