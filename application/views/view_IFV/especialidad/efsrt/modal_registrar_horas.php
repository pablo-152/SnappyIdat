<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>EFSRT (Horas)</b></h5>
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
                <label class="control-label text-bold">Horas:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="horas_i" name="horas_i" placeholder="Ingresar Horas">
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_especialidad" name="id_especialidad" value="<?php echo $id_especialidad; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Horas();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Horas(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Horas_EFSRT";

        if (Valida_Insert_Horas()) {
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
                        Lista_Horas_EFSRT();
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Horas() {
        if($('#id_modulo_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Módulo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#horas_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar una cantidad de horas.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
