<form id="formulario_mes" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Agregar Mes</h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Mes: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="mes" name="mes">
                    <?php foreach($list_mes as $list){ ?>
                        <option value="<?php echo $list['cod_mes']; ?>" <?php if($list['cod_mes']==date('m')){ echo "selected"; } ?>><?php echo $list['nom_mes']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Año: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="anio" name="anio">
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['nom_anio']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>  	           	                	        
    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="id_estado_bancario" name="id_estado_bancario" value="<?php echo $id_estado_bancario; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Mes_Detalle_Estado_Bancario();">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    function Insert_Mes_Detalle_Estado_Bancario(){
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
        
        var dataString = $("#formulario_mes").serialize();
        var url="<?php echo site_url(); ?>Administrador/Insert_Mes_Detalle_Estado_Bancario";

        var id = $("#id_estado_bancario").val();

        if (Valida_Mes_Detalle_Estado_Bancario()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
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
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Administrador/Detalle_Estado_Bancario/"+id;
                        });
                    }
                }
            });       
        }
    }

    function Valida_Mes_Detalle_Estado_Bancario() {
        if($('#mes').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Mes.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#anio').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Año.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
