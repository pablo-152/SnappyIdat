<form class="form-horizontal" id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Modulo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Carrera:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_carrera" id="id_carrera">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_carrera as $list){ 
                        if($list['id_especialidad']==2){ ?>
                            <option value="<?php echo $list['id_carrera']; ?>"><?php echo $list['codigo']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Modulo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="modulo" name="modulo">
            </div>
        </div>  	           	                	        
    </div> 
    
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Asignacion_Modulo();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>

        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';  
    })

    function Insert_Asignacion_Modulo(){
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Insert_Asignacion_Modulo";
        if (Valida_Asignacion_Modulo()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
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
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>AppIFV/Asignacion_Modulo";
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

    function Valida_Asignacion_Modulo() {
        if($('#id_carrera').val().trim() === '0') {
            msgDate = 'Debe seleccionar carrera.';
            inputFocus = '#id_carrera';
            return false;
        }
        if($('#modulo').val() == '') {
            msgDate = 'Debe ingresar modulo.';
            inputFocus = '#modulo';
            return false;
        }
        return true;
    }
</script>
