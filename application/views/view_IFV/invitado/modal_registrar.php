<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Invitado (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_i" name="fecha_i">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Persona:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="persona_i" name="persona_i" placeholder="Persona">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">DNI:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="dni_i" name="dni_i" placeholder="DNI" maxlength="8">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inst./Empresa:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="inst_empresa_i" name="inst_empresa_i" placeholder="Inst./Empresa">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Invitado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="invitado_i" name="invitado_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_invitado as $list){ ?>
                        <option value="<?php echo $list['Codigo']; ?>"><?php echo $list['nom_invitado']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Invitado()">
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

    function Insert_Invitado(){
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
        var url="<?php echo site_url(); ?>AppIFV/Insert_Invitado";

        if (Valida_Insert_Invitado()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>AppIFV/Invitado";
                }
            });
        }
    }

    function Valida_Insert_Invitado() {
        if($('#fecha_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#persona_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Persona.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#dni_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar DNI.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#invitado_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Invitado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
