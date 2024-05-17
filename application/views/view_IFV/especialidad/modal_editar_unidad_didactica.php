<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Unidad Didáctica</b></h5> 
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Módulo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_modulo_u" id="id_modulo_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_modulo as $list){?>
                        <option value="<?php echo $list['id_modulo']; ?>" <?php if($list['id_modulo']==$get_id[0]['id_modulo']){ echo "selected"; } ?>>
                            <?php echo $list['modulo']; ?>
                        </option> 
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Competencia:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_competencia_u" name="id_competencia_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_competencia as $list){ ?>
                        <option value="<?php echo $list['id_competencia']; ?>" <?php if($list['id_competencia']==$get_id[0]['id_competencia']){ echo "selected"; } ?>>
                            <?php echo $list['nom_competencia']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Código:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cod_unidad_didactica_u" name="cod_unidad_didactica_u" placeholder="Ingresar Código" value="<?php echo $get_id[0]['cod_unidad_didactica']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_unidad_didactica_u" name="nom_unidad_didactica_u" placeholder="Ingresar Nombre" value="<?php echo $get_id[0]['nom_unidad_didactica']; ?>">
            </div>
            
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Créditos:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="creditos_u" name="creditos_u" placeholder="Ingresar Créditos" onkeypress="return soloNumeros(event)" value="<?php echo $get_id[0]['creditos']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Pj Mínimo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="puntaje_minimo_u" name="puntaje_minimo_u" placeholder="Ingresar Puntaje Mínimo" onkeypress="return soloNumeros(event)" value="<?php echo $get_id[0]['puntaje_minimo']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Ciclo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="ciclo_academico_u" name="ciclo_academico_u" placeholder="Ingresar Ciclo" onkeypress="return soloNumeros(event)" value="<?php echo $get_id[0]['ciclo_academico']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Precedencia:</label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control" id="id_precedencia_u" name="id_precedencia_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_precedencia as $list){ ?>
                        <option value="<?php echo $list['id_unidad_didactica']; ?>" <?php if($list['id_unidad_didactica']==$get_id[0]['id_precedencia']){ echo "selected"; } ?>>
                            <?php echo $list['nom_unidad_didactica']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Reemplazada Por:</label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control" id="id_reemplazo_u" name="id_reemplazo_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_reemplazo as $list){ ?>
                        <option value="<?php echo $list['id_unidad_didactica']; ?>" <?php if($list['id_unidad_didactica']==$get_id[0]['id_reemplazo']){ echo "selected"; } ?>>
                            <?php echo $list['nom_unidad_didactica']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Profesores:</label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control" id="id_profesor_u" name="id_profesor_u">
                    <option value="0">Seleccione</option>
                </select>
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
        <input type="hidden" id="id_unidad_didactica" name="id_unidad_didactica" value="<?php echo $get_id[0]['id_unidad_didactica']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Unidad_Didactica()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Unidad_Didactica(){
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
        var url="<?php echo site_url(); ?>AppIFV/Update_Unidad_Didactica";

        if (Valida_Update_Unidad_Didactica()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actulización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        }); 
                    }else{
                        Lista_Unidad_Didactica(); 
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Unidad_Didactica() {
        if($('#id_modulo_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Módulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cod_unidad_didactica_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Código.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_unidad_didactica_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#estado_u').val().trim() === '0') {
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