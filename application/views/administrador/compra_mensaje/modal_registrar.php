<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Comra Mensaje (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha: </label> 
            </div> 
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_i" name="fecha_i" onkeypress="if(event.keyCode == 13){ Insert_Compra_Mensaje(); }">
            </div> 
            
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Monto: </label> 
            </div> 
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="monto_i" name="monto_i" placeholder="Monto" onkeypress="if(event.keyCode == 13){ Insert_Compra_Mensaje(); }">
            </div> 

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cantidad: </label> 
            </div> 
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros" id="cantidad_i" name="cantidad_i" placeholder="Cantidad" onkeypress="if(event.keyCode == 13){ Insert_Compra_Mensaje(); }">
            </div> 
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Compra_Mensaje();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numeros_punto').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.,]/g, '');
    });

    $('.solo_numeros').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Insert_Compra_Mensaje(){
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
        var url="<?php echo site_url(); ?>Administrador/Insert_Compra_Mensaje";

        if (Valida_Insert_Compra_Mensaje()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Compra_Mensaje();
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Insert_Compra_Mensaje() {
        /*if($('#fecha_i').val().trim() === '') { 
            Swal(
                'Ups!',
                'Debe ingresar Fecha.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#monto_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Monto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#monto_i').val() < '0') {
            Swal(
                'Ups!',
                'Debe ingresar Monto mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        if($('#cantidad_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Cantidad.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cantidad_i').val() < '0') {
            Swal(
                'Ups!',
                'Debe ingresar Cantidad mayor a 0.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>