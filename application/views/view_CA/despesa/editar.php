<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_CA/header'); ?>
<?php $this->load->view('view_CA/nav'); ?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Despesa <?php echo $get_id[0]['referencia']; ?> (Editar)</b></span></h4>
                </div>

                <div class="heading-elements"> 
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('Ca/Despesa') ?>" >
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="div_editar" class="container-fluid">
        <form id="formulario_update" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-1">
                    <select class="form-control" disabled>
                        <option value="0" <?php if($get_id[0]['tipo_despesa']==0){ echo "selected"; } ?>>Seleccione</option>
                        <option value="4" <?php if($get_id[0]['tipo_despesa']==4){ echo "selected"; } ?>>Black</option>
                        <option value="3" <?php if($get_id[0]['tipo_despesa']==3){ echo "selected"; } ?>>Crédito</option>
                        <option value="2" <?php if($get_id[0]['tipo_despesa']==2){ echo "selected"; } ?>>Gasto</option>
                        <option value="1" <?php if($get_id[0]['tipo_despesa']==1){ echo "selected"; } ?>>Ingreso</option>
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Tipo Pago:</label>
                </div>
                <div class="form-group col-lg-1">
                    <select class="form-control" disabled>
                        <option value="0" <?php if($get_id[0]['id_tipo_pago']==0){ echo "selected"; } ?>>Seleccione</option>
                        <option value="1" <?php if($get_id[0]['id_tipo_pago']==1){ echo "selected"; } ?>>Cuenta Bancaria</option>
                        <option value="2" <?php if($get_id[0]['id_tipo_pago']==2){ echo "selected"; } ?>>Efectivo/Transferencia</option>
                        <option value="3" <?php if($get_id[0]['id_tipo_pago']==3){ echo "selected"; } ?>>Cheque</option>
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Rubro:</label>
                </div>
                <div class="form-group col-lg-1">
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_rubro as $list){ ?>
                            <option value="<?php echo $list['id_rubro']; ?>" <?php if($list['id_rubro']==$get_id[0]['id_rubro']){ echo "selected"; } ?>>
                                <?php echo $list['nom_rubro']; ?>
                            </option> 
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Sub-Rubro:</label>
                </div>
                <div class="form-group col-lg-1">
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        <?php foreach($list_subrubro as $list){ ?>
                            <option value="<?php echo $list['id_subrubro']; ?>" <?php if($list['id_subrubro']==$get_id[0]['id_subrubro']){ echo "selected"; } ?>>
                                <?php echo $list['nom_subrubro']; ?>
                            </option> 
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Descriçao:</label>
                </div>
                <div class="form-group col-lg-4">
                    <input type="text" class="form-control" placeholder="Descripción" maxlength="30" disabled value="<?php echo $get_id[0]['descripcion']; ?>">
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Documento:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" placeholder="Documento" disabled value="<?php echo $get_id[0]['documento']; ?>">
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Data Doc.:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="date" class="form-control" disabled value="<?php echo $get_id[0]['fec_documento']; ?>" onblur="Fecha_Documento();">
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Mes (Gasto):</label> 
                </div>
                <div class="form-group col-lg-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['mes_gasto']; ?>">
                </div>

                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Data Pag:</label>
                </div>
                <div class="form-group col-lg-2">
                    <input type="date" class="form-control" disabled value="<?php echo $get_id[0]['fec_pago']; ?>">
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold margintop">Valor:</label>
                </div>
                <div class="form-group col-lg-1">
                    <input type="number" class="form-control" placeholder="Valor" disabled value="<?php echo $get_id[0]['valor']; ?>">
                </div>

                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Sem Contabilizar:</label>
                    <input type="checkbox" class="tamanio" value="1" disabled <?php if($get_id[0]['sin_contabilizar']==1){ echo "checked"; } ?> style="margin-left:20px;">
                </div>

                <?php if($get_id[0]['sin_contabilizar']==1){ ?>
                    <div class="form-group col-lg-1 text-right">
                        <label class="control-label text-bold margintop">Colaborador:</label>
                    </div>
                    <div class="form-group col-lg-2">
                        <select class="form-control" disabled>
                            <option value="0">Seleccione</option>
                            <option value="999999" <?php if($list['id_usuario']=="999999"){ echo "selected"; } ?>>Sin Designar</option>
                            <?php foreach($list_colaborador as $list){ ?>
                                <option value="<?= $list['id_usuario'] ?>" 
                                    <?php if($list['id_usuario']==$get_id[0]['id_colaborador']){ echo "selected"; } ?>>
                                    <?= $list['usuario_codigo']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>

                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Enviado Original:</label>
                    <input type="checkbox" class="tamanio" value="1" disabled <?php if($get_id[0]['enviado_original']==1){ echo "checked"; } ?> style="margin-left:20px;">
                </div>

                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Sem Doc. Físico:</label>
                    <input type="checkbox" class="tamanio" value="1" disabled <?php if($get_id[0]['sin_documento_fisico']==1){ echo "checked"; } ?> style="margin-left:20px;">
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-1 text-right">
                    <label class="control-label text-bold">Observaçoes:</label>
                </div>
                <div class="form-group col-lg-11">
                    <textarea class="form-control" id="observaciones_u" name="observaciones_u" placeholder="Observaciones" rows="2" disabled><?php echo $get_id[0]['observaciones']; ?></textarea>
                </div>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Documento:</label>
                </div>
                <div class="form-group col-lg-4">
                    <button type="button" onclick="Abrir('archivo_u')">Seleccionar archivo</button>
                    <input type="file" id="archivo_u" name="archivo_u" disabled onchange="Nombre_Archivo(this,'span_archivo')" style="display: none">
                    <span id="span_archivo"><?php if($get_id[0]['archivo']!=""){ echo $get_id[0]['nom_archivo']; }else{ echo "No se eligió archivo"; } ?></span>
                </div>

                <?php if($get_id[0]['archivo']!=""){ ?>
                    <div id="i_1" class="col-lg-2">
                        <label class="text-bold" style="margin-right: 25px;">Descargar/Eliminar:</label>
                        <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',1)">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Pagamento:</label>
                </div>
                <div class="form-group col-lg-4">
                    <button type="button" onclick="Abrir('pagamento_u')">Seleccionar archivo</button>
                    <input type="file" id="pagamento_u" name="pagamento_u" disabled onchange="Nombre_Archivo(this,'span_pagamento')" style="display: none">
                    <span id="span_pagamento"><?php if($get_id[0]['pagamento']!=""){ echo $get_id[0]['nom_pagamento']; }else{ echo "No se eligió archivo"; } ?></span>
                </div>
                    
                <?php if($get_id[0]['pagamento']!=""){ ?>
                    <div id="i_2" class="col-lg-2">
                        <label class="text-bold" style="margin-right: 25px;">Descargar/Eliminar:</label>
                        <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',2)">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <div class="col-lg-12 row" style="margin-bottom:15px;">
                <div class="form-group col-lg-2 text-right">
                    <label class="control-label text-bold">Doc. & Pagamento:</label>
                </div>
                <div class="form-group col-lg-4">
                    <button type="button" onclick="Abrir('doc_pagamento_u')">Seleccionar archivo</button>
                    <input type="file" id="doc_pagamento_u" name="doc_pagamento_u" disabled onchange="Nombre_Archivo(this,'span_doc_pagamento')" style="display: none">
                    <span id="span_doc_pagamento"><?php if($get_id[0]['doc_pagamento']!=""){ echo $get_id[0]['nom_doc_pagamento']; }else{ echo "No se eligió archivo"; } ?></span>
                </div>
                    
                <?php if($get_id[0]['doc_pagamento']!=""){ ?>
                    <div id="i_2" class="col-lg-2">
                        <label class="text-bold" style="margin-right: 25px;">Descargar/Eliminar:</label>
                        <a style="cursor:pointer;" title="Descargar" class="download" type="button" onclick="Descargar_Archivo('<?php echo $get_id[0]['id_despesa']; ?>',3)">
                            <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                        </a>
                    </div>
                <?php } ?>
            </div>
    
            <div class="modal-footer">
                <input type="hidden" class="form-control" id="id_despesa" name="id_despesa" value="<?php echo $get_id[0]['id_despesa']; ?>"> 
                <?php if($_SESSION['usuario'][0]['id_nivel']!=13){ ?>
                    <button type="button" class="btn btn-primary" onclick="Div_Editar();" style="background-color: #000;"><i class="glyphicon glyphicon-ok-sign"></i>Editar</button>
                <?php } ?>
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

        Sin_Contabilizar();
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
        var fec_documento = $('#fec_documento_u').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'fec_documento':fec_documento},
            success:function (data) {
                $('#mes_gasto_u').html(data);
            }
        });
    }

    function Traer_Subrubro_U(){  
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

        var url="<?php echo site_url(); ?>Ca/Traer_Subrubro_U"; 
        var id_rubro = $('#id_rubro_u').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_rubro':id_rubro},
            success:function (data) {
                $('#select_subrubro_u').html(data);
                $("#sin_contabilizar_u").prop("checked", false);
                $("#enviado_original_u").prop("checked", false);
                $("#sin_documento_fisico_u").prop("checked", false);
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
        var id_subrubro = $('#id_subrubro_u').val();

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_subrubro':id_subrubro},
            success:function (data) {
                if(data.split("*")[0]==1){
                    $("#sin_contabilizar_u").prop("checked", true);
                    $('.ver_sin_contabilizar').show();
                }else{
                    $("#sin_contabilizar_u").prop("checked", false);
                    $('.ver_sin_contabilizar').hide();
                    $('#id_colaborador').val(0);
                }

                if(data.split("*")[1]==1){
                    $("#enviado_original_u").prop("checked", true);
                }else{
                    $("#enviado_original_u").prop("checked", false);
                }

                if(data.split("*")[2]==1){
                    $("#sin_documento_fisico_u").prop("checked", true);
                }else{
                    $("#sin_documento_fisico_u").prop("checked", false);
                }
            }
        });
    }

    function Abrir(id) {
        var file = document.getElementById(id);
        file.dispatchEvent(new MouseEvent('click', {
            view: window,
            bubbles: true,
            cancelable: true
        }));
    }

    function Nombre_Archivo(element,glosa,archivo) {
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Ca/Validar_Archivo_Roto"; 
        var glosa = document.getElementById(glosa);
        
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
                    //$('#'+archivo).val('');
                    glosa.innerText = "No se eligió archivo";
                    return false;
                }else{
                    glosa.innerText = element.files[0].name;
                    return true;
                }
            }
        });
        
        /*var glosa = document.getElementById(glosa);
        if(element=="") {
            glosa.innerText = "No se eligió archivo";
        } else {
            glosa.innerText = element.files[0].name;
        }*/
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

        var id_tipo_pago = $('#id_tipo_pago_u').val();
        var fec_documento = $('#fec_documento_u').val();

        validarFecha('fec_documento_u');

        if(id_tipo_pago==1 && fec_documento!=""){
            $('#fec_pago_u').val(fec_documento);
        }

        Mes_Gasto();

        /*var array = fec_documento.split('-');
        $('#mes_gasto_u').val(array[1]+'/'+array[0]);*/
    }

    function validarFecha(id){
        var anio_aceptado = $('#anio').val();
        var fecha = new Date($('#'+id).val());

        console.log(isNaN(fecha.getTime()));

        if (isNaN(fecha.getTime())) {
            Swal(
                'Ups!',
                'Por favor, ingresa una fecha válida.',
                'warning'
            ).then((result) => {
                document.getElementById(`${id}`).value = '';
                if (id === 'fec_documento_u') document.getElementById('mes_gasto_u').value = '0';
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
                if (id === 'fec_documento_u') document.getElementById('mes_gasto_u').value = '0';
            });
            return;
        }*/
    }

    function Comprobar(){
        var checkbox1 = document.getElementById("enviado_original_u");
        var checkbox2 = document.getElementById("sin_documento_fisico_u");
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

    function Sin_Contabilizar(){
        if($('#sin_contabilizar_u').is(':checked')) {
            $('.ver_sin_contabilizar').show();
        }else{
            $('.ver_sin_contabilizar').hide();
            $('#id_colaborador').val(0);
        }
    }

    function Div_Editar(){
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

        var id_despesa = $('#id_despesa').val();
        var url = "<?php echo site_url(); ?>Ca/Div_Editar_Despesa";
    
        $.ajax({
            type:"POST",
            data:{'id_despesa':id_despesa},
            url: url,
            success:function (resp) {
                $('#div_editar').html(resp);
            }
        });
    }

    function Update_Despesa(){
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

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url="<?php echo site_url(); ?>Ca/Update_Despesa";

        if (Valida_Update_Despesa()){
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>Ca/Despesa";
                }
            });
        }
    }

    function Valida_Update_Despesa() {
        if ($('#enviado_original_u').prop('checked') && $('#sin_documento_fisico_u').prop('checked')) {
            Swal(
                'Ups!',
                'Debe seleccionar uno de los 2.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#tipo_despesa_u').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar un tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#sin_contabilizar_u').is(':checked')) {
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

    function Descargar_Archivo(id,orden){
        window.location.replace("<?php echo site_url(); ?>Ca/Descargar_Archivo_Despesa/"+id+"/"+orden);
    }
    
    function Delete_Archivo(id,orden){
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

        var image_id = id;
        var file_col = $('#i_'+orden);

        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Ca/Delete_Archivo_Despesa',
            data: {'image_id': image_id,'orden':orden},
            success: function (data) {
                file_col.remove();            
            }
        });
    }
</script>

<?php $this->load->view('view_CA/footer'); ?>