<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_CA/header'); ?>
<?php $this->load->view('view_CA/nav'); ?>

<style>
    .tamanio{
        height: 20px;
        width: 20px;
    }

    .margintop{
        margin-top:5px ;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Despesa (Nuevo)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">   
                        <a type="button" href="<?= site_url('Ca/Despesa') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-1">
                    <select class="form-control" id="tipo_despesa_i" name="tipo_despesa_i">
                        <option value="0">Seleccione</option>
                        <option value="4">Black</option>
                        <option value="3">Crédito</option>
                        <option value="2">Gasto</option>
                        <option value="1">Ingreso</option>
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Tipo Pago:</label>
                </div>
                <div class="form-group col-lg-1">
                    <select class="form-control" id="id_tipo_pago_i" name="id_tipo_pago_i">
                        <option value="0">Seleccione</option>
                        <option value="1">Cuenta Bancaria</option>
                        <option value="2">Efectivo/Transferencia</option>
                        <option value="3">Cheque</option>
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Rubro:</label>
                </div>
                <div class="form-group col-lg-1">
                    <select class="form-control" name="id_rubro_i" id="id_rubro_i" onchange="Traer_Subrubro_I();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_rubro as $list){ ?>
                            <option value="<?php echo $list['id_rubro']; ?>"><?php echo $list['nom_rubro']; ?></option> 
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Sub-Rubro:</label>
                </div>
                <div id="select_subrubro_i" class="form-group col-lg-1">
                    <select class="form-control" name="id_subrubro_i" id="id_subrubro_i">
                        <option value="0">Seleccione</option>
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Descriçao:</label>
                </div>
                <div class="form-group col-lg-4">
                    <input type="text" class="form-control" id="descripcion_i" name="descripcion_i" placeholder="Descripción" maxlength="30" onkeypress="if(event.keyCode == 13){ Insert_Despesa(); }">
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Documento:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" id="documento_i" name="documento_i" placeholder="Documento" onkeypress="if(event.keyCode == 13){ Insert_Despesa(); }">
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Data Doc.:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="date" class="form-control" id="fec_documento_i" name="fec_documento_i" value="<?php echo date('Y-m-d'); ?>" onblur="Fecha_Documento();" onkeypress="if(event.keyCode == 13){ Insert_Despesa(); }">
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Mes (Gasto):</label>
                </div>
                <div class="form-group col-lg-2">
                    <select class="form-control basic" id="mes_gasto_i" name="mes_gasto_i">
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Data Pag.:</label> 
                </div>
                <div class="form-group col-lg-2">
                    <input type="date" class="form-control" id="fec_pago_i" name="fec_pago_i" onblur="validarFecha('fec_pago_i');" onkeypress="if(event.keyCode == 13){ Insert_Despesa(); }">
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Valor:</label>
                </div>
                <div class="form-group col-lg-1">
                    <input type="number" class="form-control" id="valor_i" name="valor_i" placeholder="Valor" onkeypress="if(event.keyCode == 13){ Insert_Despesa(); }">
                </div>

                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Sem Contabilizar:</label>
                    <input type="checkbox" class="tamanio" id="sin_contabilizar_i" name="sin_contabilizar_i" value="1" style="margin-left:20px;" onclick="Sin_Contabilizar();">
                </div>

                <div class="form-group col-lg-1 text-right ver_sin_contabilizar">
                    <label class="control-label text-bold margintop">Colaborador:</label>
                </div>
                <div class="form-group col-lg-2 ver_sin_contabilizar">
                    <select class="form-control" name="id_colaborador" id="id_colaborador">
                        <option value="0">Seleccione</option>
                        <option value="999999">Sin Designar</option>
                        <?php foreach($list_colaborador as $list){ ?>
                            <option value="<?= $list['id_usuario'] ?>"><?= $list['usuario_codigo']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Enviado Original:</label>
                    <input type="checkbox" class="tamanio" id="enviado_original_i" name="enviado_original_i" value="1" style="margin-left:20px;" onclick="Comprobar()">
                </div>

                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Sem Doc. Físico:</label>
                    <input type="checkbox" class="tamanio" id="sin_documento_fisico_i" name="sin_documento_fisico_i" value="1" style="margin-left:20px;" onclick="Comprobar()">
                </div>
            </div> 

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold">Observaçoes:</label>
                </div>
                <div class="form-group col-lg-11">
                    <textarea class="form-control" id="observaciones_i" name="observaciones_i" placeholder="Observaciones" rows="2"></textarea>
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Documento:</label>
                </div>
                <div class="form-group col-lg-5">
                    <input type="file" id="archivo_i" name="archivo_i" onchange="Validar_Archivo('archivo_i');">
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Pagamento:</label>
                </div>
                <div class="form-group col-lg-5">
                    <input type="file" id="pagamento_i" name="pagamento_i" onchange="Validar_Archivo('pagamento_i');">
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Doc. & Pagamento:</label>
                </div>
                <div class="form-group col-lg-5">
                    <input type="file" id="doc_pagamento_i" name="doc_pagamento_i" onchange="Validar_Archivo('doc_pagamento_i');">
                </div>
            </div>
            
            <div class="modal-footer">
                <input type="hidden" id="anio" name="anio" value="<?=$list_anio[0]['nom_anio']?>">
                <button type="button" class="btn btn-primary" onclick="Insert_Despesa();"><i class="glyphicon glyphicon-ok-sign"></i>Guardar</button>
                <a type="button" class="btn btn-default" href="<?= site_url('Ca/Despesa') ?>"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a> 
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded','true');
        $("#despesas_index").addClass('active');
        document.getElementById("rcontabilidad").style.display = "block";

        /*var currentDate = new Date();
        var formattedDate = currentDate.toISOString().split('T')[0];
        $('#fec_documento_i').val(formattedDate);
        var array = formattedDate.split('-');
        $('#mes_gasto_i').val(array[1]+'/'+array[0]);*/
        Mes_Gasto();
        Sin_Contabilizar();
    });

    var ss = $(".basic").select2({
        tags: true,
    });

    function Mes_Gasto(){
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

        var url="<?php echo site_url(); ?>Ca/Mes_Gasto"; 
        var fec_documento = $('#fec_documento_i').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'fec_documento':fec_documento},
            success:function (data) {
                $('#mes_gasto_i').html(data);
            }
        });
    }

    function Traer_Subrubro_I(){ 
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

        var url="<?php echo site_url(); ?>Ca/Traer_Subrubro_I";  
        var id_rubro = $('#id_rubro_i').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_rubro':id_rubro},
            success:function (data) {
                $('#select_subrubro_i').html(data);
                $("#sin_contabilizar_i").prop("checked", false);
                $("#enviado_original_i").prop("checked", false);
                $("#sin_documento_fisico_i").prop("checked", false);
            }
        });
    }

    function Traer_Checkbox(){ 
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

        var url="<?php echo site_url(); ?>Ca/Traer_Checkbox"; 
        var id_subrubro = $('#id_subrubro_i').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_subrubro':id_subrubro},
            success:function (data) {
                if(data.split("*")[0]==1){
                    $("#sin_contabilizar_i").prop("checked", true);
                    $('.ver_sin_contabilizar').show();
                }else{
                    $("#sin_contabilizar_i").prop("checked", false);
                    $('.ver_sin_contabilizar').hide();
                    $('#id_colaborador').val(0);
                }

                if(data.split("*")[1]==1){
                    $("#enviado_original_i").prop("checked", true);
                }else{
                    $("#enviado_original_i").prop("checked", false);
                }

                if(data.split("*")[2]==1){
                    $("#sin_documento_fisico_i").prop("checked", true);
                }else{
                    $("#sin_documento_fisico_i").prop("checked", false);
                }
            }
        });
    }

    function Fecha_Documento(){
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

        var id_tipo_pago = $('#id_tipo_pago_i').val();
        var fec_documento = $('#fec_documento_i').val();

        validarFecha('fec_documento_i');

        if(id_tipo_pago==1 && fec_documento!=""){
            $('#fec_pago_i').val(fec_documento);
        }

        Mes_Gasto();

        /*var array = fec_documento.split('-');
        $('#mes_gasto_i').val(array[1]+'/'+array[0]);*/
    }

    function validarFecha(id){
        var anio_aceptado = $('#anio').val();
        var fecha = new Date($('#'+id).val());

        if (isNaN(fecha.getTime())) {
            Swal(
                'Ups!',
                'Por favor, ingresa una fecha válida.',
                'warning'
            ).then((result) => {
                document.getElementById(`${id}`).value = '';
                if (id === 'fec_documento_i') document.getElementById('mes_gasto_i').value = '0';
            });
            return;
        }  
        
        /*if (fecha.getFullYear() != anio_aceptado) {
            Swal(
                'Ups!',
                'Por favor, ingresa un año actual.',
                'warning'
            ).then((result) => {
                document.getElementById(`${id}`).value = '';
                if (id === 'fec_documento_i') document.getElementById('mes_gasto_i').value = '0';
            });
            return;
        }*/
    }

    function Comprobar(){
        var checkbox1 = document.getElementById("enviado_original_i");
        var checkbox2 = document.getElementById("sin_documento_fisico_i");
        checkbox1.onclick = function(){
            if(checkbox1.checked != false){
                checkbox2.checked =null;
            }
        }
        checkbox2.onclick = function(){
            if(checkbox2.checked != false){
                checkbox1.checked=null;
            }
        }
    }

    function Validar_Archivo(archivo){ 
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Ca/Validar_Archivo_Roto"; 
        
        dataString.append('archivo', archivo);

        $.ajax({
            url: url,
            data:dataString,
            type:"POST",
            processData: false,
            contentType: false,
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "Asegurese de ingresar archivos en buen estado.",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                    $('#'+archivo).val('');
                    return false;
                }else{
                   return true;
                }
            }
        });
    }

    function Sin_Contabilizar(){
        if($('#sin_contabilizar_i').is(':checked')) {
            $('.ver_sin_contabilizar').show();
        }else{
            $('.ver_sin_contabilizar').hide();
            $('#id_colaborador').val(0);
        }
    }

    function Insert_Despesa(){
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>Ca/Insert_Despesa";

        if (Valida_Insert_Despesa()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso',
                        data,
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>Ca/Despesa";
                    });
                }
            });
        }
    }

    function Valida_Insert_Despesa() {
        if ($('#enviado_original_i').prop('checked') && $('#sin_documento_fisico_i').prop('checked')) {
            Swal(
                'Ups!', 
                'Debe seleccionar uno de los 2.',
                'warning'
            ).then(function() { });
            return false;
        } 
        if($('#tipo_despesa_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_tipo_pago_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un tipo de pago.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_rubro_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un rubro.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_subrubro_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un sub-Rubro.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#descripcion_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar una descripcion.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fec_documento_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar una fecha.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#mes_gasto_i').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un mes.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#valor_i').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar una valor.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#sin_contabilizar_i').is(':checked')) {
            if($('#id_colaborador').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar colaborador.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
</script>

<?php $this->load->view('view_CA/footer'); ?>