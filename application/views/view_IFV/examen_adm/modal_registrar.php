<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Examen de Admisión (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Nombre:</label>
                <input type="text" class="form-control" id="nom_examen" name="nom_examen">
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha Examen:</label>
                <input type="date" class="form-control" id="fec_limite" name="fec_limite">
            </div>
            
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Publicación de Resultados:</label>
                <input type="date" class="form-control" id="fec_resultados" name="fec_resultados">
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_examen_ifv();" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_examen_ifv(){
        var dataString = $("#formulario").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Insert_examen_ifv";
        if (Examen_ifv()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Examen";
                    });
                }
            });
        }
    }

    function Examen_ifv() {
        if($('#nom_examen').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_limite').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Límite.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#fec_resultados').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha de Publicación de Resultados.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
