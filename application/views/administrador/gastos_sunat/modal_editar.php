<style>
    .color_casilla{
        border-color: #715D74;
        color: #FFF;
        background-color: rgba(113,93,116,0.5) !important;
    }

    .grande_check{
        width: 20px;
        height: 20px;
    }
</style>

<form id="formulario" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar (Gasto <?php echo $get_gasto[0]['Pedido']; ?>)</b></h5>
    </div>
    
    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha Emisión Comprobante:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control color_casilla" placeholder="Fecha Emisión Comprobante" disabled value="<?php echo $get_gasto[0]['Fecha_Documento']; ?>">
            </div>
        
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Mes/Año Doc.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control color_casilla" placeholder="Mes/Año Doc." disabled value="<?php echo $get_gasto[0]['Mes_Anio_Doc']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Doc.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control color_casilla" placeholder="Tipo Doc." disabled value="<?php echo $get_gasto[0]['Tipo_Documento']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nr. Doc.:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control color_casilla" placeholder="Nr. Doc." disabled value="<?php echo $get_gasto[0]['Numero_Recibo']; ?>">
            </div>
        </div>  

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Operación:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control color_casilla" placeholder="Operación" disabled value="<?php echo $get_gasto[0]['Operacion']; ?>">
            </div>
        </div>  
        
        <div class="col-md-12 row">
            <?php if($validar==1){ ?>
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Fecha Pago en Banco:</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?php echo $get_id[0]['fecha_pago']; ?>" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                </div>
            <?php }else{ ?>
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Fecha Pago en Banco:</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?php echo $get_gasto[0]['Fecha_Documento']; ?>" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                </div>
            <?php } ?>

            <?php if($get_gasto[0]['CostTypeId']==34 || $get_gasto[0]['CostTypeId']==71 || $get_gasto[0]['CostTypeId']==121 || $get_gasto[0]['Ruc_Proveedor']!=""){ ?>
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">RUC Beneficiario:</label>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" placeholder="RUC Beneficiario" disabled value="<?php if($get_gasto[0]['CostTypeId']==34){ echo $get_ruc[1]['Ruc']; }elseif($get_gasto[0]['CostTypeId']==71){ echo $get_ruc[0]['Ruc']; }elseif($get_gasto[0]['CostTypeId']==121){ echo $get_ruc[2]['Ruc']; }else{ echo $get_gasto[0]['Ruc_Proveedor']; } ?>" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                </div>
            <?php }else{ ?>
                <?php if($ruc_subrubro!=""){ ?>
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">RUC Beneficiario:</label>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="RUC Beneficiario" disabled value="<?php echo $ruc_subrubro; ?>" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                    </div>
                <?php }else{ ?>
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold">RUC Beneficiario:</label>
                    </div>
                    <div class="form-group col-md-4">
                        <?php if($validar==1){ ?>
                            <input type="text" class="form-control" id="ruc_beneficiario" name="ruc_beneficiario" placeholder="RUC Beneficiario" maxlength="11" value="<?php echo $get_id[0]['ruc_beneficiario']; ?>" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                        <?php }else{ ?>
                            <input type="text" class="form-control" id="ruc_beneficiario" name="ruc_beneficiario" placeholder="RUC Beneficiario" maxlength="11" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>  

        <div class="col-md-12 row">
            <?php if($obliga_documento==1){ ?>
                <div class="form-group col-md-6">
                    <input type="file" id="documento" name="documento" onchange="validarExt();"> 
                </div>
            <?php } ?>	  

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Validar Documento:</label>
            </div>
            <div class="form-group col-md-4">
                <?php if($validar==1){ ?>
                    <input type="checkbox" class="grande_check" id="validar_documento" name="validar_documento" <?php if($get_id[0]['validar_documento']==1){ echo "checked";} ?> value="1" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                <?php }else{ ?>
                    <input type="checkbox" class="grande_check" id="validar_documento" name="validar_documento" value="1" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                <?php } ?>
            </div>
        </div>

        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==10 || 
        $_SESSION['usuario'][0]['id_usuario']==42 || $_SESSION['usuario'][0]['id_usuario']==43 || $_SESSION['usuario'][0]['id_usuario']==63 || 
        $_SESSION['usuario'][0]['id_usuario']==71 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">No Declarado:</label>
            </div>
            <div class="form-group col-md-4"> 
                <?php if($validar==1){ ?>
                    <input type="checkbox" class="grande_check" id="no_declarado" name="no_declarado" <?php if($get_id[0]['no_declarado']==1){ echo "checked";} ?> value="1" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                <?php }else{ ?>
                    <input type="checkbox" class="grande_check" id="no_declarado" name="no_declarado" value="1" onkeypress="if(event.keyCode == 13){ Update_Gasto_Sunat(); }">
                <?php } ?>
            </div>
        </div>
        <?php }else{ ?>
            <?php if($validar==1){ ?>
                <input type="hidden" id="no_declarado" name="no_declarado" value="<?php echo $get_id[0]['no_declarado']; ?>">
            <?php }else{ ?>
                <input type="hidden" id="no_declarado" name="no_declarado" value="0">
            <?php } ?>
        <?php } ?>
    </div> 

    <div class="modal-footer">
        <?php if($validar==1){ ?>
            <input type="hidden" id="id_gasto" name="id_gasto" value="<?php echo $get_id[0]['id_gasto']; ?>">
            <input type="hidden" id="documento_actual" name="documento_actual" value="<?php echo $get_id[0]['documento']; ?>">
        <?php } ?>
        <input type="hidden" id="id" name="id" value="<?php echo $get_gasto[0]['Id']; ?>">
        <input type="hidden" id="obliga_documento" name="obliga_documento" value="<?php echo $obliga_documento; ?>">
        <input type="hidden" id="tipo_gasto" name="tipo_gasto" value="<?php echo $get_gasto[0]['CostTypeId']; ?>">
        <input type="hidden" id="tipo_validacion" name="tipo_validacion" value="<?php echo $validar; ?>">
        <button type="button" class="btn btn-primary" onclick="Update_Gasto_Sunat();">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</form>

<script>
    $('#ruc_beneficiario').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function validarExt(){
        var archivoInput = document.getElementById('documento'); 
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpeg|.png|.jpg|.pdf)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar documento con extensiones .jpeg, .png, .jpg o .pdf.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{   
            return true;
        }
    }

    function Update_Gasto_Sunat() {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "<?php echo site_url(); ?>Administrador/Update_Gastos_Sunat";

        if (Valida_Gastos_Sunat()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Gastos_Sunat(1);
                        $("#acceso_modal_mod .close").click()
                    });
                }
            });
        }
    }

    function Valida_Gastos_Sunat() {
        /*if($('#tipo_gasto').val()!=34 && $('#tipo_gasto').val()!=71 && $('#tipo_gasto').val()!=121){
            if($('#fecha_pago').val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Fecha Pago en Banco.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ruc_beneficiario').val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar RUC Beneficiario.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#ruc_beneficiario').val().length != '11'){
                Swal(
                    'Ups!',
                    'Debe ingresar RUC Beneficiario válido.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }*/
        if($('#tipo_validacion').val().trim() === '0'){
            if($('#obliga_documento').val() === '1') {
                if($('#documento').val() === '') {
                    Swal(
                        'Ups!',
                        'Debe ingresar Documento.',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
        }
        return true;
    }
</script>
