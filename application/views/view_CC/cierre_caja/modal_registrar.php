<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
?>
<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
        <h5 class="modal-title"><b>Cierre de Caja (Nuevo)</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;"> 
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Vendedor: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_vendedor_i" id="id_vendedor_i" onchange="Saldo_Fecha();">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_usuario as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>" <?php if($list['id_usuario']==$id_usuario){ echo "selected"; } ?>>
                            <?php echo $list['usuario_codigo']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Caja:</label>                 
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fecha_i" name="fecha_i" value="<?php echo date('Y-m-d'); ?>" onblur="Saldo_Fecha();"> 
            </div>      
        </div>
            
        <div id="lista_saldo" class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Saldo Automático:</label>                 
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="saldo_automatico_i" name="saldo_automatico_i" placeholder="Saldo Automático" value="<?php echo $get_saldo[0]['saldo_automatico']; ?>" readonly>
            </div>  

            <div class="form-group col-md-2">
                <label class="form-group col text-bold">Monto Entregado:</label>                   
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control solo_numeros_punto" id="monto_entregado_i" name="monto_entregado_i" placeholder="Monto Entregado" value="<?php echo $get_saldo[0]['saldo_automatico']; ?>" onkeypress="if(event.keyCode == 13){ Insert_Cierre_Caja(); }">
            </div>  
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Entrega a: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_entrega_i" id="id_entrega_i"> 
                    <option value="0">Seleccione</option>
                    <?php foreach($list_usuario as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                    <?php } ?>
                </select>
            </div> 

            <?php if($id_usuario==1 || $id_nivel==6){ ?>
                <div class="form-group col-md-2">
                    <label class="form-group col text-bold">Cofre:</label>                 
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" id="cofre_i" name="cofre_i" placeholder="Cofre" maxlength="30" onkeypress="if(event.keyCode == 13){ Insert_Cierre_Caja(); }">
                </div>  
            <?php } ?>
        </div> 
    </div>

    <div class="modal-footer">
        <input type="hidden" id="productos_i" name="productos_i" value="<?php echo $get_producto[0]['productos']; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Cierre_Caja();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>    
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $('.solo_numeros_punto').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.,]/g, '');
    });

    function Saldo_Fecha(){
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

        var url="<?php echo site_url(); ?>CursosCortos/Saldo_Fecha"; 
        var id_vendedor = $("#id_vendedor_i").val(); 
        var fecha = $("#fecha_i").val(); 

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_vendedor':id_vendedor,'fecha':fecha},
            success:function (resp) {
                $('#lista_saldo').html(resp);
                Productos_Fecha();
            }
        });
    }

    function Productos_Fecha(){
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

        var url="<?php echo site_url(); ?>CursosCortos/Productos_Fecha"; 
        var id_vendedor = $("#id_vendedor_i").val(); 
        var fecha = $("#fecha_i").val(); 

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_vendedor':id_vendedor,'fecha':fecha},
            success:function (resp) {
                $('#productos_i').val(resp);
            }
        });
    }

    function Insert_Cierre_Caja(){ 
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

        var dataString = $("#formulario_insert").serialize();
        var url="<?php echo site_url(); ?>CursosCortos/Insert_Cierre_Caja"; 

        if (Valida_Insert_Cierre_Caja()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    if(data=="movimiento"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡No hay movimientos para este vendedor!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else if(data.split("*")[0]=="no_cierre"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "Hay una caja del día "+data.split("*")[1]+" pendiente de cerrar. Tiene que cerrar esa antes.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        //window.open('<?php echo site_url(); ?>CursosCortos/Pdf_Cierre_Caja/'+data, '_blank'); 
                        Lista_Cierre_Caja(1);
                        $("#acceso_modal .close").click()
                    }
                }
            });
        }    
    }

    function Valida_Insert_Cierre_Caja() {
        if($('#id_vendedor_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Vendedor.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha_i').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Caja.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_entrega_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Entrega.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>
