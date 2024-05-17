

<form id="formulario_inventarioe" method="POST" enctype="multipart/form-data"  class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Actualizar Código: </b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            
            <input type="hidden" readonly class="form-control"  id="hoy" name="hoy" value="<?php echo date('Y-m-d'); ?>" autofocus>
            <div class="form-group col-md-1">
                <label>Código:</label>
            </div>

            <div class="form-group col-md-1">
                <input type="text" readonly class="form-control" id="referencia" name="referencia" value="<?php echo $get_id[0]['codigo_barra'] ?>" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Tipo:</label>
            </div>

            <div class="form-group col-md-3">
                <select required class="form-control" disabled>
                    <option value="0"><?php echo $get_id[0]['nom_tipo_inventario'] ?></option>
                </select>
            </div>

            <div class="form-group col-md-1">
                <label>Sub-Tipo:</label>
            </div>

            <div class="form-group col-md-3">
                <select required class="form-control" disabled>
                    <option value="0"><?php echo $get_id[0]['nom_subtipo_inventario'] ?></option>
                </select>
            </div>
        </div>
        <div class="col-md-12 row">

            <div class="form-group col-md-1">
                <label>Descripción:</label>
            </div>

            <div class="form-group col-md-7">
                <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['producto_descripcion'] ?>" id="nom_subtipo_inventario" name="nom_subtipo_inventario" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Fec.&nbsp;Compra:</label>
            </div>

            <div class="form-group col-md-2">
                <input type="date" disabled class="form-control" value="<?php echo $get_id[0]['fec_compra'] ?>" id="fec_compra" name="fec_compra" placeholder="Ingresar Descripción" autofocus>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-1">
                <label>Proveedor:</label>
            </div>

            <div class="form-group col-md-4">
                <input type="text" disabled value="<?php echo $get_id[0]['proveedor'] ?>" class="form-control" id="nom_subtipo_inventario" name="nom_subtipo_inventario" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Garantía:</label>
            </div>

            <div class="form-group col-md-2">
                <input type="date" disabled value="<?php echo $get_id[0]['garantia_h'] ?>" class="form-control" id="nom_subtipo_inventario" name="nom_subtipo_inventario" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Precio&nbsp;U(S/.):</label>
            </div>

            <div class="form-group col-md-1">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['precio_u'] ?>" id="precio_u" name="precio_u" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Cantidad:</label>
            </div>

            <div class="form-group col-md-1">
                <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['cantidad'] ?>" id="cantidad" name="cantidad" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Total (S/.):</label>
            </div>

            <div class="form-group col-md-1">
                <input type="text" readonly value="<?php echo $get_id[0]['total'] ?>" class="form-control" id="total" name="total" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label title="Desvalorización" style="cursor:help">Desvalor(S/):</label>
            </div>

            <div class="form-group col-md-1">
                <input type="text" readonly value="<?php echo $get_id[0]['desvalorizacion'] ?>" class="form-control" id="desvalorizacion" name="desvalorizacion" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Gastos(S/.):</label>
            </div>

            <div class="form-group col-md-1">
                <input type="text"  class="form-control" readonly value="<?php echo $get_id[0]['gastos'] ?>" id="nom_subtipo_inventario" name="nom_subtipo_inventario" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Val.&nbsp;Act(S/):</label>
            </div>

            <div class="form-group col-md-1">
                <input type="text"  class="form-control"  readonly value="<?php echo $get_id[0]['valor_actual'] ?>" id="valor_actual" name="valor_actual" placeholder="Ingresar Descripción" autofocus>
            </div>

            <div class="form-group col-md-1">
                <label>Empresa:</label>
            </div>

            <div class="form-group col-md-1">
                <select disabled required class="form-control" name="id_empresa" id="id_empresa" onchange="Busca_Sede()">
                <option value="0">Seleccione</option>
                <?php foreach($list_empresa as $list){
                    if($get_id[0]['id_empresa']==$list['id_empresa']){?>
                        <option selected value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
                <?php }else{?> 
                    <option value="<?php echo $list['id_empresa']; ?>"><?php echo $list['cod_empresa'];?></option>
                    <?php } } ?>
                </select>
            </div>


            <div class="form-group col-md-1">
                <label>Sede:</label>
            </div>

            <div class="form-group col-md-1" id="div_sede">
                <select disabled required class="form-control" name="id_sede" id="id_sede">
                <option value="0">Seleccione</option>
                <?php foreach($list_sede as $list){
                    if($get_id[0]['id_sede']==$list['id_sede']){?>
                        <option selected value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede'];?></option>
                <?php }else{?> 
                    <option value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede'];?></option>
                    <?php } } ?>
                </select>
            </div>

            <div class="form-group col-md-1">
                <label>Local:</label>
            </div>

            <div class="form-group col-md-2" id="div_local">
                <select required class="form-control" name="id_local" id="id_local">
                <option value="0">Seleccione</option>
                <?php foreach($list_local as $list){
                    if($get_id[0]['id_local']==$list['id_inventario_local']){?>
                        <option selected value="<?php echo $list['id_inventario_local']; ?>"><?php echo $list['nom_local'];?></option>
                <?php }else{?> 
                    <option value="<?php echo $list['id_inventario_local']; ?>"><?php echo $list['nom_local'];?></option>
                    <?php } } ?>
                </select>
            </div>

            <div class="form-group col-md-1">
                <label>Estado:</label>
            </div>

            <div class="form-group col-md-2" >
                <select required class="form-control" name="id_estado" id="id_estado">
                <option value="0">Seleccione</option>
                <?php foreach($list_estado as $list){
                    if($get_id[0]['estado']==$list['id_status_general']){?>
                        <option selected value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
                <?php }else{?> 
                    <option value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
                    <?php } } ?>
                </select>
            </div>
        </div>      	                	        
    </div>

    <div class="modal-footer">
        <input name="id_inventario" type="hidden" class="form-control" id="id_inventario" value="<?php echo $get_id[0]['id_inventario']; ?>">
        
        <button type="button" class="btn btn-primary" onclick="Actualizar_Inventario()" data-loading-text="Loading..." autocomplete="off">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
        
    </div>
</form>
<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

<script>
    
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';

        if($('#fec_compra').val().trim() !="" && $('#precio_u').val().trim() !="" && $('#cantidad').val().trim() !="" && $('#desvalorizacion').val().trim() !=""){
        
        f1 = $('#fec_compra').val();
        f2 = $('#hoy').val();
        total=$('#precio_u').val()*$('#cantidad').val();
        aF1 = f1.split("-");
        aF2 = f2.split("-");
        
        numMeses = aF2[0]*12 + aF2[1] - (aF1[0]*12 + aF1[1]);
        if (aF2[2]<aF1[2]){
            numMeses = numMeses - 1;
        }

        if(numMeses>0){
            valor_actual=total-((($('#desvalorizacion').val()/100)*numMeses)*total);
            $('#valor_actual').val(valor_actual.toFixed(2));
        }else{
            $('#valor_actual').val(total.toFixed(2));
        }
    }
    });

    function Busca_Sede(){
        var dataString = new FormData(document.getElementById('formulario_inventarioe'));
        var url="<?php echo site_url(); ?>Snappy/Busca_Sede_Local_Inventario";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#div_sede').html(data);
                
            }
        });
        Busca_Local();
    }

    function Busca_Local(){
        var dataString = new FormData(document.getElementById('formulario_inventarioe'));
        var url="<?php echo site_url(); ?>Snappy/Busca_Local_Inventario";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#div_local').html(data);
                
            }
        });
    }

    function Actualizar_Inventario(){
        var dataString = new FormData(document.getElementById('formulario_inventarioe'));
        var url="<?php echo site_url(); ?>Snappy/Update_Inventario";

        if (valida_inventarioe()) {
            bootbox.confirm({
                title: "Editar Datos de Código",
                message: "¿Desea actualizar datos del código?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            type:"POST",
                            url: url,
                            data:dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                swal.fire(
                                    'Actualización Exitosa!',
                                    '',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>Snappy/Inventario";
                                    
                                });
                                
                            }
                        });
                    }
                } 
            });        
        }else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    

    function valida_inventarioe() {
        if($('#id_local').val()== '0') {
            Swal(
                'Ups!',
                'Debe seleccionar local.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_estado').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar estado.',
                'warning'
            ).then(function() { });
            return false;
        }

        
        return true;
    }
</script>
