<style>
    .grande_check{
        width: 20px;
        height: 20px;
        margin: 0 10px 0 0 !important;
    }

    .label_check{
        position: relative;
        top: -4px;
    }
</style>

<form id="formulario_update_doc" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Anular Documento Recibido</b></h5>
    </div>
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_motivo" id="id_motivo" class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="1">Documento Ilegible</option>
                    <option value="2">Documento Incompleto</option>
                    <option value="3">Otros</option>
                </select>
            </div>
            
        </div>
  		           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_doc_cargado" name="id_doc_cargado" value="<?php echo $get_id[0]['id_doc_cargado']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Documento_Recibido_Anular()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Update_Documento_Recibido_Anular(){
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

        var dataString = new FormData(document.getElementById('formulario_update_doc'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Documento_Recibido_Anular";

        if (Valida_Update_Documento_Recibido_Anular()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa',
                        'Documento Anulado!',
                        'success'
                    ).then(function() {
                        Lista_Documento_Recibido($('#tipo_i').val());
                        $("#acceso_modal_mod .close").click()
                    });
                }
            });
        }
    }

    function Valida_Update_Documento_Recibido_Anular() {
        if($('#id_motivo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Motivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>