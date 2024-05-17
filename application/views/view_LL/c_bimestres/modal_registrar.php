<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Bimestre (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Descripción">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha de Inicio:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_inicio_i" name="fecha_inicio_i" placeholder="Inicio">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha de Fin:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_fin_i" name="fecha_fin_i" placeholder="Fin">
            </div>
        </div>
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_C_Bimestres()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>

    function Insert_C_Bimestres(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>LittleLeaders/Insert_C_Bimestres";

        if (Valida_Insert_C_Bimestres()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_C_Bimestres();
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Insert_C_Bimestres() {
        
        if($('#descripcion_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Descripción.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
