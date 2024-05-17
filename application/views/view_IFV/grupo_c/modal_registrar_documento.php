
<form method="post" id="formulario_doc_insert" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Documento (Nuevo)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_documento_c" name="nom_documento_c" placeholder="Ingresar Nombre">
            </div> 
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Documento();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Documento(){
        Cargando();
        
        var dataString = new FormData(document.getElementById('formulario_doc_insert'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Documento_Grupo_C";

        var id_grupo = $('#id_grupo').val(); 
        dataString.append('id_grupo', id_grupo);

        if (Valida_Insert_Documento()) {
            Swal({
                title: '¿Quieres registrar este documento a todos los grupos?',
                text: "El registro será registrado en todos los grupos",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    dataString.append('tipo_registro', 1);
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: dataString,
                        processData: false,
                        contentType: false,
                        success:function (data) {
                            Lista_Documento();
                            $("#acceso_modal .close").click()
                        }
                    });
                }else{
                    dataString.append('tipo_registro', 2);
                    $.ajax({
                        type:"POST",
                        url:url,
                        data: dataString,
                        processData: false,
                        contentType: false,
                        success:function (data) {
                            Lista_Documento();
                            $("#acceso_modal .close").click()
                        }
                    });
                }
            })     
        }  
    }

    function Valida_Insert_Documento() {
        if($('#nom_documento_c').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>