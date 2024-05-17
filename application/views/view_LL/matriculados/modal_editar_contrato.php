
<form id="formulario_update_contrato" method="post" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Contrato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Vencido: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="checkbox" id="vencido_cu" name="vencido_cu" value="1" <?php if($get_id[0]['vencido']==1){ echo "checked"; } ?>> 
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_documento_firma" name="id_documento_firma" value="<?php echo $get_id[0]['id_documento_firma']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Contrato();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Update_Contrato(){ 
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
            })
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
        
        var dataString = new FormData(document.getElementById('formulario_update_contrato'));
        var url="<?php echo site_url(); ?>LittleLeaders/Update_Contrato_Matriculados";

        $.ajax({
            type:"POST",
            url:url,
            data: dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                Lista_Contratos();
                $("#acceso_modal_mod .close").click()
            }
        });        
    }
</script>