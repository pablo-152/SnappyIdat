<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">   
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title"><b>Pago (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Banco: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_banco_i" name="id_banco_i">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cuenta&nbsp;Bancaria: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="cuenta_bancaria_i" name="cuenta_bancaria_i" placeholder="Ingresar Cuenta Bancaria">
            </div>
        </div>           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $id_colaborador; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Pago_Colaborador();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Insert_Pago_Colaborador(){
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
        var url="<?php echo site_url(); ?>LeadershipSchool/Insert_Pago_Colaborador";

        if (Valida_Insert_Pago_Colaborador()) {
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
                        Lista_Pago();  
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Pago_Colaborador() {
        if($('#id_banco_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Banco.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cuenta_bancaria_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Cuenta Bancaria.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
