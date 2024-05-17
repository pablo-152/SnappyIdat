<form id="formulario_estado_fecha" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h3 class="tile-title" style="color: #715d74;font-size: 21px;"><b>Editar Mes Estado Bancario</b></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="form-group col-md-2">
            <label class="text-bold">Mes/Año:</label>
        </div>
        <div class="form-group col-md-3">
            <select id="mes_anioe" name="mes_anioe" class="form-control">
                <option value="0">Seleccione</option>
                <?php foreach($list_mes_anio as $list){ ?>
                    <option value="<?php echo $list['mes_anio']; ?>" <?php $array = explode("_",$mes_anio); if($array[1]==$list['mes_anio']){echo "selected";} ?>><?php echo $list['mes_anio']; ?></option>
                <?php } ?>
            </select>
        </div>

    </div> 
    
    <div class="modal-footer">
        <input type="hidden" id="MovementType" name="MovementType" value="<?php echo $MovementType ?>">
        <input type="hidden" id="Reference" name="Reference" value="<?php echo $Reference ?>">
        <input type="hidden" id="OperationNumber" name="OperationNumber" value="<?php echo $OperationNumber ?>">
        <input type="hidden" name="id_estado_bancarioe" id="id_estado_bancarioe" value="<?php echo $id_estado_bancario ?>">
        <input type="hidden" name="mes_anio_busqueda" id="mes_anio_busqueda" value="<?php echo $mes_anio ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Estado_Bancario_Fecha()" data-loading-text="Loading..." autocomplete="off">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    function Update_Estado_Bancario_Fecha(){
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

        var dataString = new FormData(document.getElementById('formulario_estado_fecha'));
        var url="<?php echo site_url(); ?>Administrador/Update_Estado_Bancario_Fecha";

        if (Valida_Update_Estado_Bancario_Fecha()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Estado_Bancario_Mes_Anio();
                        $("#acceso_modal_mod .close").click()
                    });
                }
            });       
        }
    }

    function Valida_Update_Estado_Bancario_Fecha() {
        if($('#mes_anioe').val() == '0') {
            Swal(
                'Ups!',
                'Debe selecionar mes.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
