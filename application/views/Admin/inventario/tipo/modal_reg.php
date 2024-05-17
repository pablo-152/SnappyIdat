
<form id="formulario_tipo" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Tipo (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">

            <div class="form-group col-md-2">
                <label>Nombre</label>
            </div>

            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_tipo_inventario" name="nom_tipo_inventario" placeholder="Ingresar Nombre" autofocus onkeypress="if(event.keyCode == 13){ Insert_TipoI(); }">
            </div>

            

        </div>  	           	                	        
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_TipoI()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>


    function Insert_TipoI(){
        var dataString = new FormData(document.getElementById('formulario_tipo'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Tipo_Inventario";
        if (valida_tipo()) {
            bootbox.confirm({
                title: "Registrar Tipo",
                message: "¿Desea registrar nuevo tipo?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            type:"POST",
                            url: url,
                            data:dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data=="error"){
                                    swal.fire(
                                    'Registro Denegado!',
                                    'Existe un registro con el mismo nombre',
                                    'error'
                                ).then(function() {
                                    
                                    
                                });
                                }else{
                                    swal.fire(
                                    'Registro Exitoso!',
                                    '',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>Snappy/Tipo_Inventario";
                                    
                                });
                                }
                                
                            }
                        });
                    }
                } 
            });      
        }else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }


    

    function valida_tipo() {
        if($('#nom_tipo_inventario').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
</script>
