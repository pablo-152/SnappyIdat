<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Bimestre</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="descripcion_u" name="descripcion_u" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha de Inicio:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_inicio_u" name="fecha_inicio_u" placeholder="Descripción" value="<?php echo $get_id[0]['fecha_inicio']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha de Fin:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_fin_u" name="fecha_fin_u" placeholder="Descripción" value="<?php echo $get_id[0]['fecha_fin']; ?>">
            </div>
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_bimestre" name="id_bimestre" value="<?php echo $get_id[0]['id_bimestre']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_C_Bimestres()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>

    function Update_C_Bimestres(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>LittleLeaders/Update_C_Bimestres";

        if (Valida_Update_C_Bimestres()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_C_Bimestres();
                    $("#acceso_modal_mod .close").click()
                }
            });
        }
    }

    function Valida_Update_C_Bimestres() {
        if($('#descripcion_u').val().trim() === '') {
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