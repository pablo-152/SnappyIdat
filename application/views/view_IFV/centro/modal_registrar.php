<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $sesion['id_nivel'];
$usuario_codigo = $sesion['usuario_codigo'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    #div_especialidad{
        background-color:#d8d7d75c;
        padding-top:25px;
        padding-bottom:25px;
    }

    #parte_especialidad{
        width: 19.7%;
        display: inline-block;
        vertical-align: text-top;
    }
    
    #p_especialidad{
        font-weight: bold;
        width: 100%;
        text-overflow: ellipsis;
    }

    .input_little{
        width: 40px;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;height:80px">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Centro de EFSRT (Nuevo)</b></span></h4>
                </div>

                <div class="heading-elements" style="position: absolute;top: 50%;margin: -25px 0 0 -25px;">
                    <div class="heading-btn-group">
                        <a title="Nueva Dirección" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal"  data-target="#modal_full" modal_full="<?= site_url('AppIFV/Modal_agregar_direccion_temporal') ?>">
                            <img style="margin-top: -6%;" src="<?= base_url() ?>template/img/direccion.png" alt="Exportar Excel" width="60">
                        </a>
                        <a type="button" href="<?= site_url('AppIFV/Centro') ?>">
                            <img style="margin-top:-4px" class="top" src="<?= base_url() ?>template/img/icono-regresar.png" width="60">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <form id="formulario_centro" method="POST"  enctype="multipart/form-data" class="formulario">
                <div class="col-lg-12">
                    <div class="col-md-12 row">
                        <div class="form-group col-md-1">
                            <input type="hidden" class="form-control" id="hoy" name="hoy" value="<?php echo date('Y-m-d'); ?>">
                            <label class="control-label text-bold">Ref.:</label>
                            <input type="text" style="background-color:#715d74;color:white" readonly class="form-control" id="referencia" name="referencia" value="<?php echo $referencia; ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label text-bold">Nombre Comercial:</label>
                            <input type="text" class="form-control" id="nom_comercial" name="nom_comercial">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label text-bold">Empresa: <span style="color:#939393;font-size:13px">(.SAC o .EIRL)</span></label></label>
                            <input type="text" class="form-control" id="empresa" name="empresa">
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Convenio:</label>
                            <input type="text" style="background-color:#bdd7ee" readonly class="form-control" id="convenio" name="convenio">
                            <input type="hidden" class="form-control" id="estado" name="estado">
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Ruc:</label>
                            <input type="text" class="form-control" maxlength="11" id="ruc" name="ruc">
                        </div>

                        <div class="form-group col-md-3" >
                            <label class="control-label text-bold">Web:</label>
                            <input type="text" class="form-control" id="web" name="web">
                        </div>
                    
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold" title="Contacto Princial" style="cursor:help">Cont. Principal (CP):</label>
                            <input type="text" class="form-control" id="persona" name="persona">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold" title="Celular de Contacto Princial" style="cursor:help">Celular (CP):</label>
                            <input type="text" class="form-control" maxlength="9" id="celular" name="celular">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label text-bold" title="Correo de Contacto Princial" style="cursor:help">Correo (CP):</label>
                            <input type="text" class="form-control" id="correo" name="correo">
                        </div>
                    </div>

                    <div id="div_direccion">
                        <input type="hidden" id="direccion_bd" name="direccion_bd" value="0">
                    </div>

                    

                    <div class="col-md-12">
                        <label class="control-label text-bold">Centros Prácticas para:</label>
                    </div>

                    <div id="div_especialidad" class="form-group col-md-12">
                        <div class="form-group col-md-12 div_especilidad">
                            <?php foreach($list_especialidad as $list){ ?>
                                <div id="parte_especialidad" >
                                    <p id="p_especialidad" class="control-label text-bold"><?php echo $list['nom_tipo_especialidad']." ".$list['abreviatura'] ?></p>
                                    <p><input type="text" class="input_little" id="total_<?php echo $list['id_especialidad']; ?>" name="total_<?php echo $list['id_especialidad']; ?>" 
                                    readonly></p>
                                    <?php 
                                        foreach($list_producto as $prod){
                                            if($prod['id_tipo_especialidad']==$list['id_tipo_especialidad'] && $prod['id_especialidad']==$list['id_especialidad']){?>
                                                <label>
                                                    <input type="text" class="input_little" id="input_<?php echo $prod['id_producto']; ?>" name="input_<?php echo $prod['id_producto']; ?>"
                                                    readonly>
                                                    <input type="checkbox" id="id_producto_<?php echo $prod['id_producto']; ?>" name="id_producto_<?php echo $prod['id_producto']; ?>" 
                                                    value="<?php echo $prod['id_producto']."-".$list['id_especialidad']; ?>" class="check_especialidad_<?php echo $list['id_especialidad']; ?>"
                                                    onclick="Activar_Cantidad('<?php echo $prod['id_producto']; ?>','<?php echo $list['id_especialidad']; ?>');">
                                                    <span style="font-weight:normal"><?php echo $prod['nom_producto']; ?></span>&nbsp;&nbsp;
                                                </label><br>
                                            <?php }  ?>
                                        <?php }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group col-md-12 row">
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Fecha Firma:</label>
                                <input type="date" class="form-control" id="fecha_firma" name="fecha_firma">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Validad de:</label>
                                <input type="date" class="form-control" id="val_de" name="val_de">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">A:</label>
                                <input type="date" class="form-control" id="val_a" name="val_a" onchange="Cambio_Convenio()">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Documento:</label>
                                <input name="documento" id="documento" type="file" size="100" required data-allowed-file-extensions='["jpeg|png|jpg|pdf|gif"]'>
                            </div>

                            <?php if($id_nivel==1 || $id_nivel==6 || $id_nivel==7 || $id_nivel==12){?> 
                                <div class="form-group col-md-3">
                                    <input type="checkbox" id="asf" name="asf" value="1" onclick="Cambio_Convenio()">
                                    <span style="font-weight:normal"><b>Activo sin firma&nbsp;&nbsp;&nbsp;&nbsp;</b><?php 
                                    $mifecha = new DateTime();
                                    echo $usuario_codigo."&nbsp;".$mifecha->format('d/m/Y') ?></span>
                                </div>
                            <?php } ?>
                            

                            <div class="form-group col-md-12">
                                <label class="control-label text-bold">Observaciones:</label>
                                <textarea class="form-control" id="observaciones_admin" name="observaciones_admin" rows="5"></textarea></br>
                                <button class="btn " onclick="Cancelar_Especialidad()" style="background-color:red;color:white;float: right;" type="button" title="Cancelar" >Cancelar</button>
                                <button class="btn " onclick="Guardar_Especialidad()" style="background-color:green;color:white;float: right;margin-right:3px" type="button" title="Guardar" >Guardar</button>
                            </div>
                            
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label text-bold">Observaciones:</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="5"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="Insert_Centro();" data-loading-text="Loading..." autocomplete="off">
                        <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#practicas").addClass('active');
        $("#hpracticas").attr('aria-expanded', 'true');
        $("#centros").addClass('active');
		document.getElementById("rpracticas").style.display = "block";

        $('#convenio').val('Inactivo');
                $('#estado').val('49');
    });
</script>

<script>
    $('#ruc').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#celular').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    $('#contacto_dir').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#celular_dir').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Carrera(id){
        $(".check_carrera").prop('checked',false);
        $(id).prop('checked',true);

        var id_carrera=$(id).val();

        var url = "<?php echo site_url(); ?>AppIFV/Carrera_Asignacion";

        $.ajax({
        url: url,
        type: 'POST',
        data: {'id_carrera':id_carrera},
        success:function (data) {
            $('#div_asignacion').html(data);
        }
        });
    }

    function Cambio_Convenio(){
        var en_bd=parseFloat($('#direccion_bd').val());
        var v_d=$('#val_de').val();
        var v_a=$('#val_a').val();

        var convenio = document.getElementById('convenio');
        
        const date1 = new Date($('#hoy').val()),
        date2 = new Date($('#val_a').val()),
        time_difference = difference(date1,date2);
        var nivel=<?php echo $id_nivel; ?>;
        if(nivel==1 || nivel==6 || nivel==7 || nivel==12){
            if ($('#asf').is(":checked")){
                $('#convenio').val('Activo s/f');
                $('#estado').val('55');
                convenio.style.backgroundColor  = '#c5e0b4';
                convenio.style.color  = 'white';
            }else{
                if(en_bd==0){
                if(v_a!=""){
                    $('#convenio').val('Sin Convenio');
                    $('#estado').val('51');
                    convenio.style.backgroundColor  = '#eaeaa3';
                    convenio.style.color  = 'black';
                }else if(v_a==""){
                    $('#convenio').val('Inactivo'); 
                    $('#estado').val('49');
                    convenio.style.backgroundColor  = '#bdd7ee';
                    convenio.style.color  = 'black';
                }
            }else{
                if(time_difference>=0){
                    $('#convenio').val('Activo');
                    $('#estado').val('48');
                    convenio.style.backgroundColor  = '#c5e0b4';
                    convenio.style.color  = 'white';
                }
                else if(time_difference<0){
                    $('#convenio').val('Renovar');
                    $('#estado').val('50');
                    convenio.style.backgroundColor  = 'red';
                    convenio.style.color  = 'white';
                }else if(v_a!=""){
                    //$('#convenioe').val('Sin Convenio');
                    $('#estado').val('51');
                    $('#convenio').val('Sin Convenio');
                    convenio.style.backgroundColor  = '#eaeaa3';
                    convenio.style.color  = 'black';
                }else if(v_a==""){
                    //$('#convenioe').val('Inactivo'); 
                    $('#estado').val('49');
                    $('#convenio').val('Inactivo');
                    convenio.style.backgroundColor  = '#bdd7ee';
                    convenio.style.color  = 'black';
                }
                    
            } 
            }
        }else{
            if(en_bd==0){
                if(v_a!=""){
                    $('#convenio').val('Sin Convenio');
                    $('#estado').val('51');
                    convenio.style.backgroundColor  = '#eaeaa3';
                    convenio.style.color  = 'black';
                }else if(v_a==""){
                    $('#convenio').val('Inactivo'); 
                    $('#estado').val('49');
                    convenio.style.backgroundColor  = '#bdd7ee';
                    convenio.style.color  = 'black';
                }
            }else{
                if(time_difference>=0){
                    $('#convenio').val('Activo');
                    $('#estado').val('48');
                    convenio.style.backgroundColor  = '#c5e0b4';
                    convenio.style.color  = 'white';
                }
                else if(time_difference<0){
                    $('#convenio').val('Renovar');
                    $('#estado').val('50');
                    convenio.style.backgroundColor  = 'red';
                    convenio.style.color  = 'white';
                }else if(v_a!=""){
                    //$('#convenioe').val('Sin Convenio');
                    $('#estado').val('51');
                    $('#convenio').val('Sin Convenio');
                    convenio.style.backgroundColor  = '#eaeaa3';
                    convenio.style.color  = 'black';
                }else if(v_a==""){
                    //$('#convenioe').val('Inactivo'); 
                    $('#estado').val('49');
                    $('#convenio').val('Inactivo');
                    convenio.style.backgroundColor  = '#bdd7ee';
                    convenio.style.color  = 'black';
                }
                    
            } 
        }
        
    }
    
    function difference(date1, date2) {  
        const date1utc = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
        const date2utc = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());
            day = 1000*60*60*24;
        return(date2utc - date1utc)/day
    }
</script>

<script>
    function Provincia(){
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
        var url = "<?php echo site_url(); ?>AppIFV/Busca_Provincia";
        var id_departamento = $('#departamento').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento},
            success: function(data){
                $('#mprovincia').html(data);
            }
        });
    }

    function Distrito(){
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
        var url = "<?php echo site_url(); ?>AppIFV/Busca_Distrito";
        var id_departamento = $('#departamento').val();
        var id_provincia = $('#provincia').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_departamento':id_departamento,'id_provincia':id_provincia},
            success: function(data){
                $('#mdistrito').html(data);
            }
        });
    }

    function Activar_Cantidad(id,especialidad){
        if($('#id_producto_'+id).is(':checked')){
            $('#input_'+id).attr('readonly',false);
            Activar_Total(especialidad);
        }else{
            $('#input_'+id).attr('readonly',true);
            $('#input_'+id).val('');
            Activar_Total(especialidad);
        }
    }

    function Activar_Total(especialidad){
        var contador = 0;
        $(".check_especialidad_"+especialidad).each(function() {
        if ($(this).is(":checked"))
            contador++;
        });

        if(contador==0){
            $('#total_'+especialidad).attr('readonly',true);
            $('#total_'+especialidad).val('');
        }else{
            $('#total_'+especialidad).attr('readonly',false);
        }
    }

    function Agregar_Direccion() {
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

        var dataString = new FormData(document.getElementById('formulario_direccionr'));
        var url="<?php echo site_url(); ?>AppIFV/Preguardar_Direccion_Centro";
        if (Valida_Direccion()) {
            $.ajax({
                type:"POST",
                url: url,
                data:dataString,
                processData: false,
                contentType: false,
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
                    }else{
                        var url2="<?php echo site_url(); ?>AppIFV/List_Preguardado_Direccion";
                        var dataString2 = new FormData(document.getElementById('formulario_centro'));
                        
                        $.ajax({
                            type:"POST",
                            url: url2,
                            data:dataString2,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                            $('#div_direccion').html(data);
                            $("#modal_full .close").click();
                        }
                        });
                    }
                    
                    
                    
                }
            });
        }
        
    }

    function Valida_Direccion() {
        if($('#direccion').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar dirección.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#departamento').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar departamento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#provincia').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar provincia.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#distrito').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar distrito.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#celular_dir').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Celular.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#celular_dir').val().length!=9) {
            Swal(
                'Ups!',
                'N° de Celular inválido.',
                'warning'
            ).then(function() { });
            return false;
        }
        
        return true;
    }

    function Eliminar_Direccion_Temporal(id) {
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
        var id_direccion_temporal=id;
        var url="<?php echo site_url(); ?>AppIFV/Delete_Direccion_Temporal";
        $.ajax({
            type:"POST",
            url: url,
            data:{'id_direccion_temporal':id_direccion_temporal},
            success:function () {
                var url2="<?php echo site_url(); ?>AppIFV/List_Preguardado_Direccion";
                var dataString2 = new FormData(document.getElementById('formulario_centro'));
                
                $.ajax({
                    type:"POST",
                    url: url2,
                    data:dataString2,
                    processData: false,
                    contentType: false,
                    success:function (data) {
                    $('#div_direccion').html(data);
                }
                });
        }
        });
        
    }

    function Insert_Centro(){
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
        var dataString = new FormData(document.getElementById('formulario_centro'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Centro";
        if (Valida_Centro()) {
            Swal({
                title: 'Registrar Centro',
                text: "¿Realmente desea registrar centro?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url: url,
                        data:dataString,
                        processData: false,
                        contentType: false,
                        success:function (data) {
                            if(data=="error"){
                                Swal({
                                    title: 'Registro Denegado',
                                    text: "¡La ultima dirección está duplicado!",
                                    type: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK',
                                });
                            }else{
                                swal.fire(
                                'Registro Exitoso!',
                                'Haga clic en el botón!',
                                'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>AppIFV/Centro";
                                    
                                });
                            }
                            
                            
                        }
                    });
                }
            })

            
        }
    }

    function Valida_Centro() {
        var nombre=$('#empresa').val();
        if($('#nom_comercial').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre Comercial.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#empresa').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Empresa.',
                'warning'
            ).then(function() { });
            return false;
        }else{
            if(nombre.endsWith(".SAC") || nombre.endsWith(".sac") || nombre.endsWith(".EIRL") || nombre.endsWith(".eirl")){
            }else{
                Swal(
                    'Ups!',
                    'El nombre de empresa debe terminar con <B>.SAC o .EIRL</B>',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#ruc').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar RUC.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#celular').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Cont. Principal (CP).',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#celular').val().length!=9) {
            Swal(
                'Ups!',
                'Cont. Principal (CP) inválido.',
                'warning'
            ).then(function() { });
            return false;
        }
        /*cant_telefono = document.getElementById("telefono").value;
        
        if($('#telefono').val().trim() != "") {
            if($('#telefono').val().trim() == "0" || cant_telefono.length!=9) {
                Swal(
                    'Ups!',
                    'Número de teléfono inválido.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }

        var cp =document.getElementById("cp").checked;
        if($('#direccion').val().trim() != '' || $('#departamento').val() != '0' || $('#provincia').val() != '0' || $('#distrito').val() != '0' || cp==true){
            
        
            if($('#direccion').val().trim() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar dirección.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#departamento').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar departamento.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#provincia').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar provincia.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#distrito').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar distrito.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }*/

        if($('#cant_especialidad_general').val() == '0' || $('#cant_especialidad').val() == '0') {
            Swal(
                'Ups!',
                'Debe registrar centros de prácticas para.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Guardar_Especialidad(){
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
        var dataString = new FormData(document.getElementById('formulario_centro'));
        var url="<?php echo site_url(); ?>AppIFV/Preguardar_Especialidad";
        if (Valida_Especialidad()) {
            Swal({
                title: 'Registrar Especialidad',
                text: "¿Realmente desea registrar especialidades?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url: url,
                        data:dataString,
                        processData: false,
                        contentType: false,
                        success:function (data) {
                            swal.fire(
                                'Registro Exitoso!',
                                'Haga clic en el botón!',
                                'success'
                                ).then(function() {
                                    //window.location = "<?php echo site_url(); ?>AppIFV/Centro";
                                    var url2="<?php echo site_url(); ?>AppIFV/List_Preguardado_Especialidad";
                                    var dataString2 = new FormData(document.getElementById('formulario_centro'));
                                    
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function (data) {
                                        $('#div_especialidad').html(data);
                                        //$("#ModalUpdate .close").click()
                                    }
                                    });
                                    
                                });
                            
                        }
                    });
                }
            })

            
        }
    }

    function Valida_Especialidad() {
        /*if($('#fecha_firma').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar fecha firma.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#val_de').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Valida de.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#val_a').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar Valida a.',
                'warning'
            ).then(function() { });
            return false;
        }*/
        //var cp =document.getElementById("cp").checked;
        if($('#direccion_bd').val()>0) {
            if($('#fecha_firma').val() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar fecha firma.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#val_de').val() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Valida de.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#val_a').val() == '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Valida a.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        
        return true;
    }

    function Cancelar_Especialidad(){
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
        var dataString = new FormData(document.getElementById('formulario_centro'));
        var url2="<?php echo site_url(); ?>AppIFV/Cancelar_Preguardado_Especialidad";
        var dataString2 = new FormData(document.getElementById('formulario_centro'));
        
        $.ajax({
            type:"POST",
            url: url2,
            data:dataString2,
            processData: false,
            contentType: false,
            success:function (data) {
            $('#div_especialidad').html(data);
            //$("#ModalUpdate .close").click()
        }
        });
    }
</script>


<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>



