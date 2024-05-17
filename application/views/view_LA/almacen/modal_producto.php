<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Producto (Nuevo)</b></h5>
</div>

<div class="modal-body" style="max-height:650px; overflow:auto;">
    <div id="div_producto" class="col-md-12 row">
        <?php foreach($list_producto as $list){ ?> 
            <div class="form-group col-md-4 text-center">
                <a onclick="Traer_Talla_Producto('<?php echo $list['id_producto']; ?>')">
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
    function Traer_Talla_Producto(id_producto){
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

        var url="<?php echo site_url(); ?>Laleli/Traer_Talla_Producto";
 
        $.ajax({
            type:"POST",
            url:url,
            data:{'id_producto':id_producto},
            success:function (data) {
                $('#div_producto').html(data);
            }
        });    
    }

    function Insert_Modal_Producto_Almacen(id_talla){
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

        var url="<?php echo site_url(); ?>Laleli/Insert_Modal_Producto_Almacen";
        var id_almacen = $("#id_almacen").val();

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_talla':id_talla,'id_almacen':id_almacen},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No hay esa cantidad de producto comprada!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    Lista_Temporal_Anadir_Producto();
                }
            }
        });
    }
</script>
