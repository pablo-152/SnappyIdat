<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Producto (Nuevo)</b></h5>
</div>

<div class="modal-body" style="max-height:650px; overflow:auto;">
    <div id="div_producto" class="col-md-12 row">
        <?php foreach($list_tipo_producto as $list){ ?> 
            <div class="form-group col-md-4 text-center">
                <a onclick="Traer_Producto_Retirar('<?php echo $list['id_tipo_producto']; ?>')">
                    <img src="<?= base_url().$list['foto']; ?>" width="250" height="250">
                </a>
            </div>
        <?php } ?>               	        
    </div> 
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
    </button>
</div>

<script>
    function Traer_Producto_Retirar(id_tipo_producto,id_almacen){
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

        var id_almacen =  $('#id_almacen').val();
        var url="<?php echo site_url(); ?>Laleli/Traer_Producto_Retirar";
 
        $.ajax({
            type:"POST",
            url:url,
            data:{'id_tipo_producto':id_tipo_producto,'id_almacen':id_almacen},
            success:function (data) {
                $('#div_producto').html(data);
            }
        });    
    }

    function Insert_Modal_Retirar_Producto_Almacen(cod_producto){
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

        var url="<?php echo site_url(); ?>Laleli/Insert_Modal_Retirar_Producto_Almacen";
        var id_almacen = $("#id_almacen").val();

        $.ajax({
            type:"POST",
            url:url,
            data: {'cod_producto':cod_producto,'id_almacen':id_almacen},
            success:function (data) {
                Lista_Temporal_Retirar_Producto();
            }
        });
    }
</script>
