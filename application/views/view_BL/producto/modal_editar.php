<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario"> 
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar Producto</b></h5>
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
                <input type="text" class="form-control" id="nombre_u" name="nombre_u" placeholder="Nombre" value="<?php echo $get_id[0]['nombre']; ?>">
            </div>

            <div class="form-group col-md-1 text-center">
                <label class="control-label text-bold margintop">Ref.:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="referencia_u" name="referencia_u" placeholder="Referencia" value="<?php echo $get_id[0]['referencia']; ?>"> 
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Artículo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control multivalue_u" name="id_articulo_u[]" id="id_articulo_u" multiple="multiple">
                    <?php $base_array = explode(",",$get_id[0]['id_articulo']); 
                    foreach($list_articulo as $list){ ?>
                        <option value="<?php echo $list['id_articulo']; ?>" <?php if(in_array($list['id_articulo'],$base_array)){ echo "selected=\"selected\""; } ?>>
                            <?php echo $list['nombre']; ?>
                        </option>
                    <?php } ?>
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
                <label class="control-label text-bold margintop">Inicio Pag.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_pag_u" name="inicio_pag_u" value="<?php echo $get_id[0]['inicio_pag']; ?>">
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Fin Pag.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fin_pag_u" name="fin_pag_u" value="<?php echo $get_id[0]['fin_pag']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="form-group col text-bold margintop">Grado:</label>                 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_grado_u" id="id_grado_u">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['id_grado']; ?>" <?php if($list['id_grado']==$get_id[0]['id_grado']){ echo "selected"; } ?>>
                            <?php echo $list['nom_grado']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div> 

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
        <input type="hidden" class="form-control" id="id_producto" name="id_producto" value="<?php echo $get_id[0]['id_producto']; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Producto()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    var ss = $(".multivalue_u").select2({
        tags: true
    });

    $('.multivalue_u').select2({
        dropdownParent: $('#acceso_modal_mod')
    });

    function Update_Producto(){
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
        var url="<?php echo site_url(); ?>BabyLeaders/Update_Producto";

        if (Valida_Update_Producto()) {
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
                        Lista_Producto(tipo_excel);
                        $("#acceso_modal_mod .close").click()
                    }
                }
            });
        }
    }

    function Valida_Update_Producto() {
        if($('#referencia_u').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_articulo_u').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Artículo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_grado_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Grado.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>