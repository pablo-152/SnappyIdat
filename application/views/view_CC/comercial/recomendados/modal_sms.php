<form class="formulario" id="formulario_sms" method="POST" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="tile-title"><b>Configurar SMS</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-12">
                <label class=" text-bold">Texto: </label> 
                <div class="col">
                    <textarea class="form-control" id="texto_sms" name="texto_sms" placeholder="Texto" rows="5"><?php echo $get_id[0]['observaciones']; ?></textarea>              
                </div>
            </div>
        </div> 
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Update_Configurar_Sms();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>&nbsp;&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</button>
    </div>
</form>

<script>
    function Update_Configurar_Sms(){
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
        
        var dataString = $("#formulario_sms").serialize();
        var url="<?php echo site_url(); ?>Administrador/Update_Configurar_Sms";

        if (Valida_Configurar_Sms()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Administrador/Recomendados";
                    });
                }
            });
        }
    }

    function Valida_Configurar_Sms() {
        if($('#texto_sms').val().trim() === "") { 
            Swal(
                'Ups!',
                'Debe ingresar Texto.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>