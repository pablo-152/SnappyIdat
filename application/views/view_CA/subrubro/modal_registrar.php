<style>
    .tamanio{
        height: 20px;
        width: 20px;
    }
</style>

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Sub-Rubro (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Rubro:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_rubro_i" name="id_rubro_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_rubro as $list){ ?>
                        <option value="<?php echo $list['id_rubro']; ?>"><?php echo $list['nom_rubro']; ?></option>
                    <?php } ?>
                </select> 
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_subrubro_i" name="nom_subrubro_i" placeholder="Nombre">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Sem Contabilizar:</label>
                <input type="checkbox" class="tamanio" id="sin_contabilizar_i" name="sin_contabilizar_i" value="1" style="margin-left:20px;">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Enviado Original:</label>
                <input type="checkbox" class="tamanio" id="enviado_original_i" name="enviado_original_i" value="1" style="margin-left:20px;">
            </div>

            <div class="form-group col-md-4">
                <label class="control-label text-bold">Sem Doc. Físico:</label>
                <input type="checkbox" class="tamanio" id="sin_documento_fisico_i" name="sin_documento_fisico_i" value="1" style="margin-left:20px;">
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Subrubro();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Subrubro(){
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
        var url="<?php echo site_url(); ?>Ca/Insert_Subrubro";

        if (Valida_Insert_Subrubro()) {
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
                        Lista_Subrubro();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Subrubro() {
        if($('#id_rubro_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Rubro.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#nom_subrubro_i').val().trim() === '') {
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
