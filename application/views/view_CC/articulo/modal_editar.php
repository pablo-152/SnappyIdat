<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Artículo</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <select class="form-control" name="anio_u" id="anio_u">
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==$get_id[0]['anio']){ echo "selected"; } ?>>
                            <?php echo $list['nom_anio']; ?>
                        </option> 
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombre_u" name="nombre_u" placeholder="Nombre" value="<?php echo $get_id[0]['nombre']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Ref.:</label>
            </div>
            <div class="form-group col-md-2">
                <input type="text" class="form-control" id="referencia_u" name="referencia_u" placeholder="Referencia" value="<?php echo $get_id[0]['referencia']; ?>" autofocus>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Tipo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_tipo_u" id="id_tipo_u">
                    <option value="0" <?php if($get_id[0]['id_tipo']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_tipo']==1){ echo "selected"; } ?>>Administrativos</option>
                    <option value="2" <?php if($get_id[0]['id_tipo']==2){ echo "selected"; } ?>>Puntuales</option>
                    <option value="3" <?php if($get_id[0]['id_tipo']==3){ echo "selected"; } ?>>Regulares</option>
                </select>
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Público:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_publico_u" id="id_publico_u">
                    <option value="0" <?php if($get_id[0]['id_publico']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_publico']==1){ echo "selected"; } ?>>Adultos</option>
                    <option value="2" <?php if($get_id[0]['id_publico']==2){ echo "selected"; } ?>>Bebes</option>
                    <option value="3" <?php if($get_id[0]['id_publico']==3){ echo "selected"; } ?>>Directo</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Monto:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="monto_u" name="monto_u" placeholder="Monto" value="<?php echo $get_id[0]['monto']; ?>" autofocus>
            </div>

            <div class="form-group col-md-3 text-center">
                <label class="control-label text-bold margintop">Obligatorio estar al día:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="checkbox" id="obligatorio_dia_u" name="obligatorio_dia_u" value="1" <?php if($get_id[0]['obligatorio_dia']==1){ echo "checked"; } ?>>
            </div>

            <div class="form-group col-md-12"> 
                <label class="control-label text-bold margintop">Descuento:</label>
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Ref.:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="desc_referencia_u" name="desc_referencia_u" placeholder="Referencia" value="<?php echo $get_id[0]['desc_referencia']; ?>" autofocus>
            </div>

            <div class="form-group col-md-2">
                <input type="number" class="form-control" id="desc_porcentaje_u" name="desc_porcentaje_u" placeholder="Porcentaje" value="<?php echo $get_id[0]['desc_porcentaje']; ?>" onchange="Porcentaje_Update();" autofocus>
            </div>

            <div class="form-group col-md-2"> 
                <input type="number" class="form-control" id="desc_monto_u" name="desc_monto_u" placeholder="Monto" value="<?php echo $get_id[0]['desc_monto']; ?>" onchange="Monto_Update();" autofocus>
            </div>

            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="desc_resultado_u" name="desc_resultado_u" placeholder="Resultado" readonly value="<?php echo $get_id[0]['desc_resultado']; ?>" autofocus>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_u" id="estado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_estado as $list){ ?>
                        <option value="<?php echo $list['id_status']; ?>" <?php if($list['id_status']==$get_id[0]['estado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_status']; ?>
                        </option> 
                    <?php } ?>
                </select>
            </div>
        </div>  		           	                	        
    </div> 

    <div class="modal-footer">
        <input type="hidden" class="form-control" id="id_articulo" name="id_articulo" value="<?php echo $get_id[0]['id_articulo']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Articulo()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Porcentaje_Update(){
        var monto = $("#monto_u").val();
        var desc_porcentaje = $("#desc_porcentaje_u").val();

        if(monto>0 && desc_porcentaje>0){
            var descuento = (Number(monto)*Number(desc_porcentaje))/100;
            $("#desc_resultado_u").val(descuento);
        }
    }

    function Monto_Update(){
        var monto = $("#monto_u").val();
        var desc_monto = $("#desc_monto_u").val();

        if(monto>0 && desc_monto>0){
            var descuento = Number(monto)-Number(desc_monto);
            $("#desc_resultado_u").val(descuento);
        }
    }

    function Update_Articulo(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var tipo_excel = $('#tipo_excel').val();
        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>CursosCortos/Update_Articulo";

        if (Valida_Update_Articulo()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Articulo(tipo_excel);
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Articulo() {
        if($('#referencia_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>