<form id="formulario_asignar_documento" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Asignar Documento:</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-lg-2 text-right">
                <label class="control-label text-bold">Año: </label>
            </div>
            <div class="form-group col-lg-4">
                <select name="id_anio_i" id="id_anio_i" class="form-control" onchange="Listar_Nombres();">
                    <option value="0">Seleccione</option>
                    <?php foreach($get_list_anio as $list){?>
                        <option value="<?php echo $list['id_anio']; ?>"><?php echo $list['nom_anio'];?></option>    
                    <?php }?>
                </select>
            </div>
            <div class="form-group col-lg-2 text-right">
                <label class="control-label text-bold">Nombre: </label>
            </div>
            <div class="form-group col-lg-4" id="cmb_nombre">
                <select name="nombre" id="nombre" class="form-control">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 row" id="datos">
            <div class="form-group col-lg-2 text-right">
                <label class="control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="referencia_u" name="referencia_u" readonly>
            </div>
            <div class="form-group col-lg-2 text-right">
                <label class="control-label text-bold">Obligatorio: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="referencia_u" name="referencia_u" readonly>
            </div>
            <input type="hidden" id="id_documento" name="id_documento">
            <input type="hidden" id="id_empresa" name="id_empresa">
        </div>
    </div> 

    <div class="modal-footer">
        <input type="hidden" id="id_colaborador" name="id_colaborador" value="<?php echo $id_colaborador ?>">
        <input type="hidden" id="id_sede" name="id_sede" value="<?php echo $id_sede ?>">
        <button type="button" class="btn btn-primary" onclick="Asignar_Documento_Colaborador();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>
<script>

    function Listar_Nombres(){
        var dataString = new FormData(document.getElementById('formulario_asignar_documento'));
        var url="<?php echo site_url(); ?>Colaborador/Lista_Nombre_Documento_x_Anio";
        $.ajax({
            url: url,
            data:dataString,
            type:"POST",
            processData: false,
            contentType: false,
            success:function (data) {
                $('#cmb_nombre').html(data);
            }
        });
    }

    function Listar_Datos(){
        var dataString = new FormData(document.getElementById('formulario_asignar_documento'));
        var url="<?php echo site_url(); ?>Colaborador/Lista_Datos_Documento_x_Anio_Nombre";
        $.ajax({
            url: url,
            data:dataString,
            type:"POST",
            processData: false,
            contentType: false,
            success:function (data) {
                $('#datos').html(data);
            }
        });
    }

    function Asignar_Documento_Colaborador(){
        var dataString = new FormData(document.getElementById('formulario_asignar_documento'));
        var url="<?php echo site_url(); ?>Colaborador/Asignar_Documento_Colaborador";
        if(Valida_Asignar_Documento_Colaborador()){
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    $('#acceso_modal').modal('hide');
                    Lista_Documento();
                }
            });
        }   
    }

    function Valida_Asignar_Documento_Colaborador(){
        if($('#id_anio_i').val() === "0"){
            Swal(
                'Ups!',
                'Debe seleccionar el Año',
                'warning'
            ).then(function() {
            });
            return false;
        }
        if($('#nombre').val() === "0"){
            Swal(
                'Ups!',
                'Debe seleccionar el Nombre',
                'warning'
            ).then(function() {
            });
            return false;
        }
        return true;
    }
</script>