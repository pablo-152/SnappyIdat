<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>Producto (Nuevo)</b></h5>
</div>

<div class="modal-body" style="max-height:650px; overflow:auto;"> 
    <div id="cuadros_modal" style="margin-bottom:60px;">
    </div>

    <div>
        <table id="example_modal" class="table table-hover table-bordered table-striped" width="100%"> 
            <thead>
                <tr style="background-color: #E5E5E5;">
                    <th class="text-center" width="20%">Código</th> 
                    <th class="text-center" width="50%">Descripción</th>
                    <th class="text-center" width="20%">Monto</th> 
                    <th class="text-center" width="10%"></th>
                    <th class="text-center" width="20%" style="display: none;">Tipo</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($list_producto as $list){ ?>                                           
                    <tr class="even pointer text-center">
                        <td><?php echo $list['cod_producto']; ?></td>
                        <td class="text-left"><?php echo $list['nom_sistema']; ?></td> 
                        <td class="text-right"><?php echo "s./ ".$list['monto']; ?></td>                                               
                        <td>
                            <button class="btn btn-primary btn-sm" type="button" onclick="Insert_Modal_Producto_Nueva_Venta('<?php echo $list['cod_producto']; ?>');">
                                Comprar
                            </button>
                        </td>
                        <td style="display: none;"><?php echo $list['id_tipo']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>      
    </div>  	        

    <div> 
        <h3>Lista de Productos Seleccionados</h3>
    </div>

    <div id="lista_modal_nueva_venta"> 
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">
        <i class="glyphicon glyphicon-remove-sign"></i> Cerrar
    </button>
</div>

<script>
    $(document).ready(function() {
        $('#example_modal thead tr').clone(true).appendTo( '#example_modal thead' );
        $('#example_modal thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
            }
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example_modal').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 10,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 3 ]
                }
            ]
        } );

        Lista_Modal_Nueva_Venta();
        Modal_Botones_Nueva_Venta();
    });

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

        var url="<?php echo site_url(); ?>AppIFV/Lista_Producto_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_modal_nueva_venta').html(resp);
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

        var url="<?php echo site_url(); ?>AppIFV/Modal_Botones_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#cuadros_modal').html(resp); 
            }
        });
    }

    function Insert_Modal_Producto_Nueva_Venta(cod_producto){ 
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

        var url="<?php echo site_url(); ?>AppIFV/Insert_Modal_Producto_Nueva_Venta";

        $.ajax({
            type:"POST",
            url:url,
            data:{'cod_producto':cod_producto},
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
                }else if(data=="error2"){ 
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡Solo puedes realizar la compra de 1 Producto!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    Lista_Producto_Nueva_Venta();
                    Lista_Modal_Nueva_Venta();
                    Botones_Nueva_Venta();
                    Modal_Botones_Nueva_Venta();
                }
            }
        });
    }
</script>