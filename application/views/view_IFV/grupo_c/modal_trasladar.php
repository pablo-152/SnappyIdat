
<form id="formulario_trasladar" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header"> 
        <h5 class="modal-title" id="exampleModalLabel">Trasladar Alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Grupo: </label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control basic_t" id="id_grupo_t" name="id_grupo_t">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_grupo as $list){ ?>
                        <option value="<?php echo $list['id_grupo'] ?>"><?php echo $list['grupo']; ?></option>
                    <?php } ?>
                </select>
            </div> 
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_t" name="id_t" value="<?php echo $id; ?>">
        <button type="button" class="btn btn-primary" onclick="Trasladar();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    var ss = $(".basic_t").select2({
        tags: true
    });

    $('.basic_t').select2({
        dropdownParent: $('#acceso_modal')
    });

    function Trasladar(){
        Cargando();
        
        var dataString = new FormData(document.getElementById('formulario_trasladar'));
        var url="<?php echo site_url(); ?>AppIFV/Trasladar_Grupo_C";

        var id_grupo = $('#id_grupo').val(); 
        dataString.append('id_grupo', id_grupo);

        if (Valida_Trasladar()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Alumno();
                    $("#acceso_modal .close").click()
                }
            });    
        }  
    }

    function Valida_Trasladar() {
        if($('#id_grupo_t').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Grupo.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>