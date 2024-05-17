<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>

<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script><script type="text/javascript" src="<?= base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Producto (Nuevo)</b></span></h4>
                </div>
                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a type="button" href="<?= site_url('Snappy/Producto') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <form id="formulario_productoi" method="POST" enctype="multipart/form-data"  class="horizontal">
        <div class="container-fluid">

            <div class="row">
            <input type="hidden" readonly class="form-control"  id="hoy" name="hoy" value="<?php echo date('Y-m-d'); ?>" autofocus>
                <div class="col-md-9">
                    <div class="form-group col-md-1">
                        <label title="Referencia" style="cursor:help">Refer.:</label>
                    </div>
                    

                    <div class="form-group col-md-2">
                        <input type="text" readonly class="form-control" id="referencia" name="referencia" value="" autofocus>
                    </div>

                    <div class="form-group col-md-1">
                        <label>Tipo:</label>
                    </div>

                    <div class="form-group col-md-3">
                        <select required class="form-control" name="id_tipo_inventario" id="id_tipo_inventario" onchange="Busca_Subtipo()">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo as $list){ ?>
                            <option value="<?php echo $list['id_tipo_inventario']; ?>"><?php echo $list['nom_tipo_inventario'];?></option>
                        <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        <label nowrap>SubTipo:</label>
                    </div>

                    <div class="form-group col-md-3" id="div_subtipo">
                        <select required class="form-control" name="id_subtipo_inventario" id="id_subtipo_inventario">
                        <option value="0">Seleccione</option>
                        
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="col">
                        <input type="hidden" readonly class="form-control"  id="id_estado" name="id_estado" autofocus>
                        <input type="text" readonly class="form-control"  id="estado" name="estado" autofocus>
                    </div>
                </div>
                
                <div class="col-md-9">
                    
                    <div class="form-group col-md-2 ">
                        <label>Descripción:</label>
                    </div>

                    <div class="form-group col-md-10" >
                        <input type="text"   class="form-control"  id="producto_descripcion" name="producto_descripcion" autofocus onkeypress="if(event.keyCode == 13){ Insert_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-2">
                        <label>Fecha&nbsp;Compra:</label>
                    </div>

                    <div class="form-group col-md-3 ">
                        <input type="date"   class="form-control"  id="fec_compra" name="fec_compra" onchange="Calculo_Desvalorizacion()" autofocus onkeypress="if(event.keyCode == 13){ Insert_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-2">
                        <label>Proveedor:</label>
                    </div>

                    <div class="form-group col-md-5 ">
                        <input type="text"   class="form-control"  id="proveedor" name="proveedor" autofocus onkeypress="if(event.keyCode == 13){ Insert_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-2 ">
                        <label>Garantía hasta:</label>
                    </div>

                    <div class="form-group col-md-3 ">
                        <input type="date"   class="form-control"  id="garantia_h" name="garantia_h" autofocus onkeypress="if(event.keyCode == 13){ Insert_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-2">
                        <label title="Precio Unitario" style="cursor:help">Precio Unit.(S/):</label>
                    </div>

                    <div class="form-group col-md-2 ">
                        <input type="text" class="form-control"  id="precio_u" name="precio_u" onchange="Calculo_Desvalorizacion()" autofocus onkeypress="if(event.keyCode == 13){ Insert_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-1">
                        <label title="Cantidad" style="cursor:help">Cant.:</label>
                    </div>

                    <div class="form-group col-md-2">
                        <input type="text" class="form-control"  id="cantidad" name="cantidad" onchange="Cargar_Codigos()" autofocus onkeypress="if(event.keyCode == 13){ Insert_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-1">
                        <label>Total&nbsp;(S/):</label>
                    </div>

                    <div class="form-group col-md-2 ">
                        <input type="text" readonly class="form-control"  id="total" name="total" autofocus>
                    </div>

                    <div class="form-group col-md-1">
                        <label title="Desvalorización (%)" style="cursor:help">Desval(%):</label>
                    </div>

                    <div class="form-group col-md-2">
                        <input type="text"  class="form-control" id="desvalorizacion" name="desvalorizacion" placeholder="%" onchange="Calculo_Desvalorizacion()" autofocus onkeypress="if(event.keyCode == 13){ Insert_ProductoI(); }">
                        <!--<input type="text"  class="form-control" onchange="Calcular_VActual()" id="desvalorizacion" name="desvalorizacion" placeholder="%" autofocus>-->
                        
                    </div>

                    <div class="form-group col-md-1 ">
                        <label>Gastos(S/.):</label>
                    </div>

                    <div class="form-group col-md-2 ">
                        <input type="text"  class="form-control"  id="gastos" name="gastos" maxlength="5" placeholder="Ingresar Gastos" autofocus onkeypress="if(event.keyCode == 13){ Insert_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-1">
                        <label title="Valor Actual" style="cursor:help">V.&nbsp;Act(S/):</label>
                    </div>

                    <div class="form-group col-md-2" >
                        <input type="text" readonly class="form-control"  id="valor_actual" name="valor_actual" placeholder="Valor" autofocus>
                    </div>
                    

                    
                </div>

                <div class="col-md-3">
                    <div class="col" style="margin-right:10px;">
                        <label class="text-bold">Imagen: </label>
                        <input type="file" id="imagenr" name="imagenr" data-allowed-file-extensions='["JPG|jpg|png|PNG|jpeg|JPEG"]'>
                    </div>
                </div>
                <div class="col-md-12">
                    <span>&nbsp;</span>
                </div>

                <div class="col-md-12" id="tabla_codigo">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                                    <thead>
                                        <tr >
                                            <th width="10%"><div align="center"></div></th>
                                            <th width="20%"><div align="center">Código</div></th>
                                            <th width="20%"><div align="center">Sede</div></th>
                                            <th width="10%"><div align="center">Estado</div></th>
                                            <th width="10%"><div align="center">LCheck</div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <span>&nbsp;</span>
                </div>


                <div class="col-md-12" >
                    <div class="form-group col-md-1">
                        <label>Observ.:</label>
                    </div>
                    <div class="form-group col-md-11">
                        
                        <textarea name="producto_obs" rows="4" class="form-control" id="producto_obs"></textarea>
                    </div>
                </div>

                <div class="col-md-12" >
                    <div class="form-group col-md-1">
                        <label>Archivos:</label>
                    </div>
                    <div class="form-group col-md-11">
                        
                        <input type="file" class="form-control" name="archivos[]" id="archivos" multiple autofocus/>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Insert_ProductoI()" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
    </form>
</div>

<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>

<script>
    $(document).ready(function() {
        $("#inventario").addClass('active');
        $("#hinventario").attr('aria-expanded','true');
        $("#inv_producto").addClass('active');
        document.getElementById("rinventario").style.display = "block";
    });
</script>


<script>
    $('#precio_u').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#cantidad').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#desvalorizacion').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#gastos').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#valor_actual').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

    $(function(){
        $('#precio_u').on('change', calcularTotal);
        $('#cantidad').on('change', calcularTotal);
        //$('#desvalorizacion').on('change', Calcular_VActual);
    });
    
    function calcularTotal() {
        if($('#precio_u').val().trim() !="" && $('#cantidad').val().trim() !=""){
            var pu=$('#precio_u').val();
            var cantidad=$('#cantidad').val();
            var total=pu*cantidad;
            $('#total').val(total.toFixed(2));
            //$('#valor_actual').val(total.toFixed(2));
            Calculo_Desvalorizacion();
        }
    }

    function Cargar_Codigos(){
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

        var dataString = new FormData(document.getElementById('formulario_productoi'));
        var url="<?php echo site_url(); ?>Snappy/Cargar_Codigos";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#tabla_codigo').html(data);
                
            }
        });

        Calculo_Desvalorizacion();
    }

    function Calculo_Desvalorizacion(){
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
    }

    $('#archivos').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['png','jpeg','jpg','xls','xlsx','pdf'],
    });

    function Busca_Subtipo(){
        var dataString = new FormData(document.getElementById('formulario_productoi'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Subtipo_Inventario";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#div_subtipo').html(data);
                
            }
        });
    }

    

    function Insert_ProductoI(){
        var dataString = new FormData(document.getElementById('formulario_productoi'));
        var url="<?php echo site_url(); ?>Snappy/Insert_Producto_Inventario";
        if (valida_productoi()) {
            bootbox.confirm({
                title: "Registrar Producto",
                message: "¿Desea registrar nuevo producto?",
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
                                if(data=="error"){
                                    swal.fire(
                                    'Registro Denegado!',
                                    'Existe un registro con el mismo tipo,subtipo, fecha de compra y garantía',
                                    'error'
                                ).then(function() {
                                    
                                    
                                });
                                }else{
                                    swal.fire(
                                    'Registro Exitoso!',
                                    'Código de referencia '+data,
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>Snappy/Producto";
                                    
                                });
                                }
                                
                            }
                        });
                    }
                } 
            });      
        }
    }
    
    function valida_productoi() {
        if($('#id_tipo_inventario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_subtipo_inventario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar subtipo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#fec_compra').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar fecha de compra.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#precio_u').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar precio unitario.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#cantidad').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar cantidad.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#desvalorizacion').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar porcentaje de desvalorización.',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }
</script>

<?php $this->load->view('Admin/footer'); ?>