<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Documento (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sub-Rubro:</label>
            </div>
            <div class="form-group col-md-6">
                <select class="form-control" id="id_subrubro_i" name="id_subrubro_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_subrubro as $list){ ?>
                        <option value="<?php echo $list['id_subrubro']; ?>"><?php echo $list['nom_subrubro']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Descripción">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="file" id="documento_i" name="documento_i">
            </div>
        </div>

        <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
            <div class="col-md-12 row">
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Visible:</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="checkbox" id="visible_i" name="visible_i" value="1" checked style="width:20px;height:20px;">
                </div>
            </div>
        <?php }else{ ?>
            <input type="hidden" id="visible_i" name="visible_i" value="1">
        <?php } ?>
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Documento()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Documento(){
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
        var url="<?php echo site_url(); ?>Ca/Insert_Documento";

        if (Valida_Insert_Documento()) {
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
                        Lista_Documento();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Documento() {
        if($('#id_subrubro_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Sub-Rubro.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#documento_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Documento.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
