<form id="formulario_reenvio" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Reenviar Informe Sunat</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Empresa: </label>  
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_empresa_r" name="id_empresa_r">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_c_empresa as $list){ ?>
                        <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cd_empresa']; ?></option>
                    <?php } ?>
                </select>
            </div> 

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Mes: </label> 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_mes_r" name="id_mes_r">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_mes as $list){ ?>
                        <option value="<?php echo $list['id_mes']; ?>"><?php echo $list['nom_mes']; ?></option>
                    <?php } ?>
                </select>
            </div> 

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Año: </label> 
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_anio_r" name="id_anio_r">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list['nom_anio']; ?>"><?php echo $list['nom_anio']; ?></option>
                    <?php } ?>
                </select>
            </div> 
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Reenviar_Informe_Sunat();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Reenviar_Informe_Sunat(){
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

        var dataString = new FormData(document.getElementById('formulario_reenvio'));
        var url="<?php echo site_url(); ?>Administrador/Reenviar_Informe_Sunat";

        if (Valida_Reenviar_Informe_Sunat()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    //Consulta();
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Reenviar_Informe_Sunat() {
        if($('#id_empresa_r').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_mes_r').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Mes.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_anio_r').val().trim() === '0') {
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