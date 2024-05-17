<form id="formulario_archivo" method="POST" enctype="multipart/form-data"   class="formulario">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel"><b>Subir Archivo</b></h5>
    </div>

    <div class="modal-body" >
        <div class="col-lg-12 row">
            <div class="form-group col-lg-6">
                <label class="text-bold">Nombre del documento: </label>
                <div class="col">
                    <input type="text" class="form-control" id="nom_documento" name="nom_documento" placeholder="Nombre de Documento" maxlength="20" onkeypress="if(event.keyCode == 13){ Insert_Archivo_Cargo(); }">
                </div> 
            </div>

            <div class="form-group col-lg-6">
                <label class="text-bold">Archivo: </label>
                <div class="col">
                    <div class="col">
                        <input type="file" id="documento" name="documento" onchange="Validar_Extension();">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Archivo_Cargo();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar 
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> 
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Validar_Extension(){
        var archivoInput = document.getElementById('documento'); 
        var archivoRuta = archivoInput.value; 
        var extPermitidas = /(.jpg|.JPG|.png|.PNG|.jpeg|.JPEG|.xls|.xlsx|.pdf|.PDF)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivo con extensión .jpg, .png, .jpeg, .xls, .xlsx y .pdf.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{
            return true;
        }
    }

    function Insert_Archivo_Cargo(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_archivo'));
        var url="<?= site_url(); ?>Ca/Insert_Archivo_Cargo_Temporal";

        if (Valida_Archivo_Cargo()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Existe un documento con el mismo nombre!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }
                    else if(data=="cantidad"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡Solo se puede adjuntar 5 documentos por cargo!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        var url = "<?= site_url(); ?>Ca/Lista_Archivo_Cargo_Temporal";

                        $.ajax({
                            type:"POST",
                            url: url,
                            success:function (data) {
                                $('#div_temporal').html(data);
                                $("#acceso_modal .close").click()
                            }
                        });
                    }
                }
            });
        }
    }

    function Valida_Archivo_Cargo(){
        if($('#nom_documento').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar nombre del documento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#documento').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe adjuntar documento.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>


