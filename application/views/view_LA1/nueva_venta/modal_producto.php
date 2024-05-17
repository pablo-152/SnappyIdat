<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Producto (Nuevo)</b></h5>
</div>

<div class="modal-body" style="max-height:650px; overflow:auto;"> 
    <div id="div_producto" class="col-md-12 row">
        <?php foreach($list_tipo_producto as $list){ ?> 
            <div class="form-group col-md-4 text-center">
                <a onclick="Traer_Producto_Nueva_Venta('<?php echo $list['id_tipo_producto']; ?>')">
                    <img src="<?= base_url().$list['foto']; ?>" width="250" height="250">
                </a>
            </div>
        <?php } ?>               	        
    </div> 

    <div> 
        <h3>Lista de Productos Seleccionados</h3>
    </div>

    <div id="lista_modal_nueva_venta"> 
        <table class="table table-hover table-bordered table-striped" id="example" width="100%">
            <thead>
                <tr style="background-color: #E5E5E5;">
                    <th class="text-center">Código</th>
                    <th class="text-center">Artículo</th>
                    <th class="text-center">Talla/Ref</th>
                    <th class="text-center">Estado</th> 
                    <th class="text-center">Venta</th>
                    <th class="text-center">Descuento</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Sub-Total</th>
                    <th class="text-center"></th>
                </tr>
            </thead>

            <tbody>
                <?php $cantidad=0; $subtotal=0; 
                    foreach($list_nueva_venta as $list){ ?>                                           
                    <tr class="even pointer text-center">
                        <td><?php echo $list['codigo']; ?></td>
                        <td class="text-left"><?php echo $list['descripcion']; ?></td>
                        <td><?php echo $list['talla']; ?></td>
                        <td><?php echo ""; ?></td>
                        <td><?php echo ""; ?></td>
                        <td><?php echo ""; ?></td>
                        <td><?php echo $list['cantidad']; ?></td>    
                        <td><?php echo number_format(($list['precio']*$list['cantidad']),2); ?></td>                                            
                        <td>
                            <a title="Eliminar">
                                <img onclick="Delete_Producto_Nueva_Venta('<?php echo $list['id_nueva_venta_producto']; ?>')" src="<?= base_url() ?>template/img/eliminar.png">
                            </a>
                        </td>
                    </tr>
                <?php $cantidad=$cantidad+$list['cantidad']; $subtotal=$subtotal+($list['cantidad']*$list['precio']); } ?>
                <tr class="text-center">
                    <td colspan="6"></td>
                    <td><?php echo $cantidad; ?></td>    
                    <td><?php echo number_format($subtotal,2); ?></td>                                                 
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
    </button>
</div>

<script>
    function Lista_Modal_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli1/Lista_Modal_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_modal_nueva_venta').html(resp);
            }
        });
    }

    function Lista_Modal_Producto_Nueva_Venta(id_tipo_producto){
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

        var url="<?php echo site_url(); ?>Laleli1/Lista_Modal_Producto_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_tipo_producto':id_tipo_producto},
            success:function (resp) {
                $('#lista_modal_producto').html(resp);
            }
        });
    }

    function Modal_Botones_Nueva_Venta(){
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

        var url="<?php echo site_url(); ?>Laleli1/Modal_Botones_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#cuadros_modal').html(resp);
            }
        });
    }

    function Traer_Producto_Nueva_Venta(id_tipo_producto){
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

        var url="<?php echo site_url(); ?>Laleli1/Traer_Producto_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                $('#div_producto').html(data);
                Lista_Modal_Producto_Nueva_Venta(id_tipo_producto);
                Modal_Botones_Nueva_Venta();
            }
        });    
    }

    function Volver_Producto_Nueva_Venta(){ 
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

        var url="<?php echo site_url(); ?>Laleli1/Volver_Producto_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                $('#div_producto').html(data);
            }
        });    
    }

    function Delete_Modal_Producto_Nueva_Venta(cod_producto,id_tipo_producto){
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

        var url="<?php echo site_url(); ?>Laleli1/Delete_Modal_Producto_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            data:{'cod_producto':cod_producto},
            success:function (resp) {
                Lista_Producto_Nueva_Venta();
                Lista_Modal_Producto_Nueva_Venta(id_tipo_producto);
                Lista_Modal_Nueva_Venta();
                Botones_Nueva_Venta(); 
                Modal_Botones_Nueva_Venta();
            }
        });
    }

    function Insert_Modal_Producto_Nueva_Venta(cod_producto,id_tipo_producto){
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

        var url="<?php echo site_url(); ?>Laleli1/Insert_Modal_Producto_Nueva_Venta";
        var id_alumno =  $("#id_alumno").val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_alumno':id_alumno,'cod_producto':cod_producto},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡Código inválido!",
                        type: 'error', 
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="no_encomienda"){ 
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No se puede encomendar este producto!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="no_stock"){ 
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No hay stock disponible para este producto, realizar otra venta para encomendarlo!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    Lista_Producto_Nueva_Venta();
                    Lista_Modal_Producto_Nueva_Venta(id_tipo_producto);
                    Lista_Modal_Nueva_Venta();
                    Botones_Nueva_Venta();
                    Modal_Botones_Nueva_Venta();
                }
            }
        });
    }
</script>
