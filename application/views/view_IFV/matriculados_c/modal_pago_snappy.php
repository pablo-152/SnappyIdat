<form id="formulario_insert_pago_pendiente" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Pago Pendiente (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Producto:</label>
            </div>
            <div class="form-group col-md-10">
                <select class="form-control" id="id_producto_p" name="id_producto_p">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_producto as $list){ ?>
                        <option value="<?php echo $list['id_producto']; ?>"><?php echo $list['nom_sistema']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Pago_Snappy();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
        </button>
    </div>
</form>

<script>
    function Insert_Pago_Snappy(){
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

        var tipo_excel = $('#tipo_excel_sp').val(); 
        var dataString = new FormData(document.getElementById('formulario_insert_pago_pendiente'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Pago_Snappy";

        var id_alumno = $('#id_alumno').val();
        dataString.append('id_alumno', id_alumno);

        if (Valida_Insert_Pago_Snappy()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Pagos_Snappy(tipo_excel);
                    $("#acceso_modal .close").click()
                }
            });
        }
    }

    function Valida_Insert_Pago_Snappy() {
        if($('#id_producto_p').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Producto.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>