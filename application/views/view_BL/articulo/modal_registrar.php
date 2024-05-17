<style>
    .margintop{
        margin-top:5px ;
    }
</style>

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Artículo (Nuevo)</b></h5>
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
                <input type="text" class="form-control" id="nombre_i" name="nombre_i" placeholder="Nombre" autofocus>
            </div>

            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Ref.:</label>
            </div>
            <div class="form-group col-md-2">
                <input type="text" class="form-control" id="referencia_i" name="referencia_i" placeholder="Referencia" autofocus>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Tipo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_tipo_i" id="id_tipo_i">
                    <option value="0">Seleccione</option>
                    <option value="1">Administrativos</option>
                    <option value="2">Puntuales</option>
                    <option value="3">Regulares</option>
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
                <label class="control-label text-bold margintop">Monto:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="monto_i" name="monto_i" placeholder="Monto" autofocus>
            </div>

            <div class="form-group col-md-3 text-center">
                <label class="control-label text-bold margintop">Obligatorio estar al día:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="checkbox" id="obligatorio_dia_i" name="obligatorio_dia_i" value="1">
            </div>

            <div class="form-group col-md-12">
                <label class="control-label text-bold margintop">Descuento:</label>
            </div>
 
            <div class="form-group col-md-2 text-center">
                <label class="control-label text-bold margintop">Ref.:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="desc_referencia_i" name="desc_referencia_i" placeholder="Referencia" autofocus>
            </div>

            <div class="form-group col-md-2">
                <input type="number" class="form-control" id="desc_porcentaje_i" name="desc_porcentaje_i" placeholder="Porcentaje" onchange="Porcentaje_Insert();" autofocus>
            </div>

            <div class="form-group col-md-2">
                <input type="number" class="form-control" id="desc_monto_i" name="desc_monto_i" placeholder="Monto" onchange="Monto_Insert();" autofocus>
            </div>

            <div class="form-group col-md-3">
                <input type="text" class="form-control" id="desc_resultado_i" name="desc_resultado_i" placeholder="Descuento" readonly autofocus>
            </div>
        </div>	           	                	        
    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Articulo()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Porcentaje_Insert(){
        var monto = $("#monto_i").val();
        var desc_porcentaje = $("#desc_porcentaje_i").val();

        if(monto>0 && desc_porcentaje>0){
            var descuento = (Number(monto)*Number(desc_porcentaje))/100;
            $("#desc_resultado_i").val(descuento);
        }
    }

    function Monto_Insert(){
        var monto = $("#monto_i").val();
        var desc_monto = $("#desc_monto_i").val();

        if(monto>0 && desc_monto>0){
            var descuento = Number(monto)-Number(desc_monto); 
            $("#desc_resultado_i").val(descuento);
        }
    }

    function Insert_Articulo(){
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
        var url="<?php echo site_url(); ?>BabyLeaders/Insert_Articulo";

        if (Valida_Insert_Articulo()) {
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
                        Lista_Articulo(tipo_excel);
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }
    }

    function Valida_Insert_Articulo() {
        if($('#referencia_i').val().trim() === '') {
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
