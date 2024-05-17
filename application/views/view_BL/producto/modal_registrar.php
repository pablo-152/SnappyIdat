<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Producto (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <select class="form-control" name="anio_i" id="anio_i">
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>>
                            <?php echo $list['nom_anio']; ?>
                        </option> 
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Nombre:</label> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nombre_i" name="nombre_i" placeholder="Nombre">
            </div>
 
            <div class="form-group col-md-1 text-center">
                <label class="control-label text-bold margintop">Ref.:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="referencia_i" name="referencia_i" placeholder="Referencia">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Artículo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control multivalue_i" name="id_articulo_i[]" id="id_articulo_i" multiple="multiple">
                    <?php foreach($list_articulo as $list){ ?>
                        <option value="<?php echo $list['id_articulo']; ?>"><?php echo $list['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Público:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_publico_i" id="id_publico_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Adultos</option>
                    <option value="2">Bebes</option>
                    <option value="3">Directo</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Inicio Pag.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_pag_i" name="inicio_pag_i">
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Fin Pag.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fin_pag_i" name="fin_pag_i">
            </div>
        </div>
            
        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="form-group col text-bold margintop">Grado:</label>                 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_grado_i" id="id_grado_i">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_grado as $list){ ?>
                        <option value="<?php echo $list['id_grado']; ?>"><?php echo $list['nom_grado']; ?></option>
                    <?php } ?>
                </select>
            </div> 
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Producto()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    var ss = $(".multivalue_i").select2({
        tags: true
    });

    $('.multivalue_i').select2({
        dropdownParent: $('#acceso_modal')
    });

    function Insert_Producto(){
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
        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Producto";

        if (Valida_Insert_Producto()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        Lista_Producto(tipo_excel);
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Producto() {
        if($('#referencia_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Referencia.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_articulo_i').val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Artículo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_grado_i').val().trim() === '0') {
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
