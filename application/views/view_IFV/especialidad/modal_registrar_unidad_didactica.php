<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Unidad Didáctica (Nueva)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Módulo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_modulo_i" id="id_modulo_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_modulo as $list){?>
                        <option value="<?php echo $list['id_modulo']; ?>"><?php echo $list['modulo']; ?></option> 
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Competencia:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_competencia_i" name="id_competencia_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_competencia as $list){ ?>
                        <option value="<?php echo $list['id_competencia']; ?>"><?php echo $list['nom_competencia']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cod_unidad_didactica_i" name="cod_unidad_didactica_i" placeholder="Ingresar Código">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_unidad_didactica_i" name="nom_unidad_didactica_i" placeholder="Ingresar Nombre">
            </div>
            
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Créditos:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="creditos_i" name="creditos_i" placeholder="Ingresar Créditos" onkeypress="return soloNumeros(event)">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Pj Mínimo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="puntaje_minimo_i" name="puntaje_minimo_i" placeholder="Ingresar Puntaje Mínimo" onkeypress="return soloNumeros(event)">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ciclo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="ciclo_academico_i" name="ciclo_academico_i" placeholder="Ingresar Ciclo" onkeypress="return soloNumeros(event)">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Precedencia:</label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control" id="id_precedencia_i" name="id_precedencia_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_precedencia as $list){ ?>
                        <option value="<?php echo $list['id_unidad_didactica']; ?>"><?php echo $list['nom_unidad_didactica']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Reemplazada Por:</label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control" id="id_reemplazo_i" name="id_reemplazo_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_reemplazo as $list){ ?>
                        <option value="<?php echo $list['id_unidad_didactica']; ?>"><?php echo $list['nom_unidad_didactica']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Profesores:</label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control" id="id_profesor_i" name="id_profesor_i">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_especialidad" name="id_especialidad" value="<?php echo $id_especialidad; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Unidad_Didactica()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Unidad_Didactica(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Unidad_Didactica";

        if (Valida_Insert_Unidad_Didactica()) {
            $.ajax({
                url: url,
                data:dataString, 
                type:"POST",
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
                        Lista_Unidad_Didactica();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Unidad_Didactica() {
        if($('#id_modulo_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Módulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cod_unidad_didactica_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_unidad_didactica_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
