<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Sección (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Curso:</label>                 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_grado_i" id="id_grado_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['id_grado']; ?>"><?php echo $list['nom_grado']; ?></option>
                    <?php } ?>
                </select>
            </div>   

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_seccion_i" name="nom_seccion_i" placeholder="Ingresar Nombre">
            </div>
            
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Estado:</label>                 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_i" id="estado_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==2){ echo "selected"; } ?>>
                            <?php echo $list['nom_status'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>           	                	        
        </div> 
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Seccion();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>    
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Seccion(){
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

        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>CursosCortos/Insert_Seccion";

        if (Valida_Insert_Seccion()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
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
                        ).then(function(){
                            Lista_Seccion();
                            $("#acceso_modal .close").click()
                        });
                    }
                }
            });
        }    
    }

    function Valida_Insert_Seccion() {
        if($('#id_grado_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Curso.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_seccion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Estado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
