    <form class="form-horizontal" id="from_foto" method="POST" enctype="multipart/form-data" action="<?= site_url('Snappy/Insert_fondo')?>"  class="formulario">

    <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Nuevo Fondo de Intranet</h5>
      </div>
<div class="modal-body" >
    <div class="col-md-12 row">
        
        <div class="form-group col-md-4">
                <label class="col-sm-6 control-label text-bold">Nombre: </label>
        </div>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="nom_fintranet" name="nom_fintranet" placeholder="Nombre del Fondo de Intranet" >
        </div>     

        <div class="form-group col-md-4">
                <label class="col-sm-3 control-label text-bold">Imagen: </label>
            </div>
         <div class="form-group col-md-8" id="archivo_essalud_container" align="left">
            
             <input name="productImage" id="productImage" type="file" class="file" data-allowed-file-extensions='["png|jpg|pdf"]'  size="100" required >
        </div>
    </div>
</div>

    <div class="modal-footer">
    <button type="button" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Guardar </button>
    <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cancelar</button>
            
       
    </div>

</form>

<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

<script>
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

	$("#createProductBtn").on('click', function(e){
        if (img()) {
            bootbox.confirm({
                title: "Registrar fondo Snappy",
                message: "¿Desea guardar el fondo?",
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
                        $('#from_foto').submit();
                    }
                } 
            });
        }
        else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    });

    function img() {
        if($('#nom_fintranet').val().trim() === '') {
            msgDate = 'Ingrese Nombre.';
            inputFocus = '#nom_fintranet';
            return false;
        }

        if($('#productImage').val().trim() === '') {
            msgDate = 'Adjuntar Imagen.';
            inputFocus = '#productImage';
            return false;
        }
        return true;
    }
</script>
