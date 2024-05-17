<form id="formulario_update" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Especialidad </b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Licenciamiento: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="licenciamiento_u" id="licenciamiento_u">
                    <option value="0" <?php if($get_id[0]['licenciamiento']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['licenciamiento']==1){ echo "selected"; } ?>>L14</option>
                    <option value="2" <?php if($get_id[0]['licenciamiento']==2){ echo "selected"; } ?>>L20</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="abreviatura_u" name="abreviatura_u" placeholder="Ingresar Código" maxlength="2" value="<?php echo $get_id[0]['abreviatura']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_especialidad_u" name="nom_especialidad_u" placeholder="Ingresar Nombre" maxlength="50" value="<?php echo $get_id[0]['nom_especialidad']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">N° Módulo: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nmodulo_u" name="nmodulo_u" onkeypress="return soloNumeros(event)" maxlength="1"  placeholder="Ingresar N° Módulo" value="<?php echo $get_id[0]['nmodulo']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
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
        <input type="hidden" id="id_especialidad" name="id_especialidad" value="<?php echo $get_id[0]['id_especialidad']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Especialidad();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
        
    </div>
</form>

<script>
    function Update_Especialidad(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Especialidad_Mod";

        if (Valida_Update_Especialidad()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        window.location = "<?php echo site_url(); ?>AppIFV/Especialidad";
                    }
                }
            });
        }
    }

    function Valida_Update_Especialidad() {
        if($('#licenciamiento_u').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#abreviatura_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar referencia corta.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_especialidad_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre de especialidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nmodulo_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar N° Módulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nmodulo_u').val()<1) {
            Swal(
                'Ups!',
                'Debe ingresar al menos un Módulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nmodulo_u').val()>4) {
            Swal(
                'Ups!',
                'Solo puede ingresar hasta 4 Módulos',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val() === '0') {
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