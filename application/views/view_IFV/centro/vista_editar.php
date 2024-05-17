<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    #div_especialidade{
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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Editar Centro - <?php echo $get_id[0]['referencia'] ?></b></span></h4>
                </div>

                <div class="heading-elements" style="position: absolute;top: 50%;margin: -25px 0 0 -25px;">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('AppIFV/Detalle_Centro') ?>/<?php echo $get_id[0]['id_centro']; ?>" >
                            <img style="margin-top:-4px" src="<?= base_url() ?>template/img/icono-regresar.png" width="60">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <form id="formulario_centroe" method="POST"  enctype="multipart/form-data" class="formulario">
                <div class="col-lg-12">
                    <div class="col-md-12 row">
                        <div class="form-group col-md-1">
                            <label class="control-label text-bold">Ref.:</label>
                            <input type="hidden" class="form-control" id="hoy" name="hoy" value="<?php echo date('Y-m-d'); ?>">
                            <input type="text" class="form-control" style="background-color:#715d74;color:white" readonly id="referenciae" name="referenciae" value="<?php echo $get_id[0]['referencia']; ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label text-bold">Nombre Comercial:</label>
                            <input type="text" class="form-control" id="nom_comerciale" name="nom_comerciale" value="<?php echo $get_id[0]['nom_comercial']; ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label text-bold">Empresa: <span style="color:#939393;font-size:13px">(.SAC o .EIRL)</span></label>
                            <input type="text" class="form-control" id="empresae" name="empresae" value="<?php echo $get_id[0]['empresa']; ?>">
                        </div>

                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Convenio:</label>
                            <select <?php if($nivel!=1 && $nivel!=2 && $nivel!=6 && $nivel!=7){ echo "disabled"; } ?> id="convenioe" name="convenioe" class="form-control" onchange="Estado();" style="background-color:<?php if($get_id[0]['id_statush']==48){echo "#c5e0b4"; }if($get_id[0]['id_statush']==49){echo "#bdd7ee";}if($get_id[0]['id_statush']==50){echo "red";}if($get_id[0]['id_statush']==51){echo "#eaeaa3";}?>;color:<?php if($get_id[0]['id_statush']==48){echo "white"; }if($get_id[0]['id_statush']==50){echo "white";}?>">
                                <?php foreach($list_estado as $list){
                                    if($list['id_status_general']==$get_id[0]['id_statush']){?>
                                        <option style="background-color:#fff;color:black" selected  value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
                                    <?php }else{?>
                                        <option style="background-color:#fff;color:black" value="<?php echo $list['id_status_general']; ?>"><?php echo $list['nom_status'];?></option>
                                    <?php } } ?>
                            </select>
                            <input type="hidden" class="form-control" id="estado" name="estado" value="<?php echo $get_id[0]['estado'] ?>">
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Ruc:</label>
                            <input type="text" class="form-control" maxlength="11" id="ruce" name="ruce" value="<?php echo $get_id[0]['ruc']; ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label text-bold">Web:</label>
                            <input type="text" class="form-control" id="webe" name="webe" value="<?php echo $get_id[0]['web']; ?>">
                        </div>
                    
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold" title="Contacto Princial" style="cursor:help">Cont. Principal (CP):</label>
                            <input type="text" class="form-control" id="persona" name="persona" value="<?php echo $get_id[0]['persona'] ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold" title="Celular de Contacto Princial" style="cursor:help">Celular (CP):</label>
                            <input type="text" class="form-control" maxlength="9" id="celular" name="celular" value="<?php if($get_id[0]['celular_pprin']!=0){echo $get_id[0]['celular_pprin'];} ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label text-bold" title="Correo de Contacto Princial" style="cursor:help">Correo (CP):</label>
                            <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $get_id[0]['correo_pprin'] ?>">
                        </div>
                    </div>

                    <input type="hidden" id="direccion_bd" name="direccion_bd" value="<?php echo $i; ?>">
                    
                    <div class="col-md-12 row">
                        <div class="form-group col-md-5">
                        </div>

                        <div class="form-group col-md-12 mt-3">
                            <label class="control-label text-bold">Centros Prácticas para:</label>
                        </div>
                    </div>
                    
                    <div id="div_especialidade" class="col-md-12">
                        <div class="form-group col-md-12 div_especilidad">
                            <?php 
                            foreach($list_especialidad as $list){ 
                                $p_esp = array_search($list['id_especialidad'],array_column($v_cen_esp,'id_especialidad')); 
                                $p_esp_tot = array_search($list['id_especialidad'],array_column($v_cen_esp_tot,'id_especialidad')); 
                                
                                if(is_numeric($p_esp)){
                                    $contador_esp = 1;
                                }else{
                                    $contador_esp = 0;
                                }

                                if(is_numeric($p_esp_tot)){
                                    $cantidad_esp = $v_cen_esp_tot[$p_esp_tot]['total'];
                                }else{
                                    $cantidad_esp = "";
                                }
                                ?>
                                <div id="parte_especialidad">
                                    <p id="p_especialidad"><?php echo $list['nom_tipo_especialidad']." ".$list['abreviatura'] ?></p><br>
                                    <p><input type="text" class="input_little" id="total_<?php echo $list['id_especialidad']; ?>" name="total_<?php echo $list['id_especialidad']; ?>" 
                                    <?php if($contador_esp==0){ echo "readonly"; }?> value="<?php echo $cantidad_esp; ?>"></p>
                                    <?php foreach($list_producto as $prod){
                                        if($prod['id_tipo_especialidad']==$list['id_tipo_especialidad'] && $prod['id_especialidad']==$list['id_especialidad']){
                                            $posicion = array_search($prod['id_producto'],array_column($v_cen_esp,'id_producto'));

                                            if(is_numeric($posicion)){
                                                $cantidad = $v_cen_esp[$posicion]['cantidad'];
                                            }else{
                                                $cantidad = "";
                                            }
                                            ?>
                                            <label>
                                                <input type="text" class="input_little" id="input_<?php echo $prod['id_producto']; ?>" name="input_<?php echo $prod['id_producto']; ?>" 
                                                <?php if($prod['id_centro_especialidad']==""){ echo "readonly"; }?> value="<?php echo $cantidad; ?>">
                                                <input type="checkbox" id="id_producto_<?php echo $prod['id_producto']; ?>" <?php if($prod['id_centro_especialidad']!=""){ echo "checked"; }?> 
                                                name="id_producto_<?php echo $prod['id_producto']; ?>" value="<?php echo $prod['id_producto']."-".$list['id_especialidad']; ?>" class="check_especialidad_<?php echo $list['id_especialidad']; ?>" 
                                                onclick="Activar_Cantidad('<?php echo $prod['id_producto']; ?>','<?php echo $list['id_especialidad']; ?>');">
                                                <span style="font-weight:normal"><?php echo $prod['nom_producto']; ?></span>&nbsp;&nbsp;
                                            </label><br>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="form-group col-md-12" >
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Fecha Firma:</label>
                                <input type="date" class="form-control" id="fecha_firmae" name="fecha_firmae" value="<?php echo $get_id[0]['fec_firma'] ?>">
                            </div>
                            
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Validad de:</label>
                                <input type="date" class="form-control" id="val_dee" name="val_dee" value="<?php echo $get_id[0]['val_de'] ?>">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">A:</label>
                                <input type="date" class="form-control" id="val_ae" name="val_ae" onchange="Cambio_Convenio()" value="<?php echo $get_id[0]['val_a'] ?>">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Documento:</label>
                                <input name="documentoe" id="documentoe" type="file" size="100" required data-allowed-file-extensions='["jpeg|png|jpg|pdf|gif"]'>
                            </div>
                            <?php if($nivel==1 || $nivel==6 || $nivel==7 || $nivel==12){?> 
                                <div class="form-group col-md-3">
                                    <input type="checkbox" id="asf" name="asf" value="1" <?php if($get_id[0]['firmasf']==1){echo "checked"; }?> onclick="Cambio_Convenio()">
                                    <span style="font-weight:normal"><b>Activo sin firma&nbsp;&nbsp;&nbsp;&nbsp;</b><?php 
                                    echo $get_id[0]['usuario_codigo']."&nbsp;".$get_id[0]['fecha_registro'] ?></span>
                                </div>
                            <?php } ?>
                                    
                            <div class="form-group col-md-12">
                                <label class="control-label text-bold">Observaciones:</label>
                                <textarea class="form-control" id="observaciones_admine" name="observaciones_admine" rows="5"><?php echo $get_id[0]['observaciones_admin'] ?></textarea>
                                </br>
                                <button class="btn " onclick="Cancelar_Update_Especialidad()" style="background-color:red;color:white;float: right;" type="button" title="Cancelar" >Cancelar</button>
                                <button class="btn " onclick="Update_Especialidad()" style="background-color:green;color:white;float: right;margin-right:3px" type="button" title="Guardar" >Guardar</button>
                                    
                                <?php if($get_id[0]['documento']!=""){?>
                                <span>&nbsp;</span>
                                    <iframe style="width:500px;height:120px" id="pdf" src="<?php echo base_url().$get_id[0]['documento']; ?>" > </iframe>
                                <?php }?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group col-md-12">
                            <label class="control-label text-bold">Observaciones:</label>
                            <textarea class="form-control" id="observacionese" name="observacionese" rows="5"><?php echo $get_id[0]['observaciones']; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <input type="hidden" name="id_ultimo_historial" id="id_ultimo_historial" value="<?php echo $get_id[0]['id_ultimo_h'] ?>">
                        <input type="hidden" id="id_centro" name="id_centro" value="<?php echo $get_id[0]['id_centro']; ?>">
                        <button type="button" class="btn btn-primary" onclick="Update_Centro();" data-loading-text="Loading..." autocomplete="off">
                            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                        </button>
                        <a href="<?= site_url('AppIFV/Centro') ?>">
                        <button type="button" class="btn btn-default" >
                            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
                        </button></a>
                    </div>
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

    });
</script>

<script>
    function Cambio_Convenio(){
        var en_bd=parseFloat($('#direccion_bd').val());
        var v_a=$('#val_ae').val();
        
        const date1 = new Date($('#hoy').val()),
        date2 = new Date($('#val_ae').val()),
        time_difference = difference(date1,date2);

        var convenioe = document.getElementById('convenioe');
        
        var nivel=<?php echo $nivel; ?>;
        if(nivel==1 || id_nivel==6 || id_nivel==7 || id_nivel==12){
            
            if ($('#asf').is(":checked")){
                $('#convenioe').val('55');
                $('#estado').val('55');
                convenioe.style.backgroundColor  = '#c5e0b4';
                convenioe.style.color  = 'black';
            }else{
                if(en_bd==0){
                    if(time_difference>=0){
                        //$('#convenioe').val('Activo');
                        $('#estado').val('48');
                        $('#convenioe').val('48');
                        convenioe.style.backgroundColor  = '#c5e0b4';
                        convenioe.style.color  = 'white';
                    }else if(time_difference<0){
                        //$('#convenioe').val('Renovar');
                        $('#estado').val('50');
                        $('#convenioe').val('50');
                        convenioe.style.backgroundColor  = 'red';
                        convenioe.style.color  = 'white';
                    }
                }else{
                    if(time_difference>=0){
                        //$('#convenioe').val('Activo');
                        $('#estado').val('48');
                        $('#convenioe').val('48');
                        convenioe.style.backgroundColor  = '#c5e0b4';
                    }
                    else if(time_difference<0){
                        //$('#convenioe').val('Renovar');
                        $('#estado').val('50');
                        $('#convenioe').val('50');
                        convenioe.style.backgroundColor  = 'red';
                    }else if(v_a!=""){
                        //$('#convenioe').val('Sin Convenio');
                        $('#estado').val('51');
                        $('#convenioe').val('51');
                        convenioe.style.backgroundColor  = '#eaeaa3';
                        convenioe.style.color  = 'black';
                    }else if(v_a==""){
                        //$('#convenioe').val('Inactivo'); 
                        $('#estado').val('49');
                        $('#convenioe').val('49');
                        convenioe.style.backgroundColor  = '#bdd7ee';
                    }
                        
                }
            }
        }else{
            
            if(en_bd==0){
                if(time_difference>=0){
                    //$('#convenioe').val('Activo');
                    $('#estado').val('48');
                    $('#convenioe').val('48');
                    convenioe.style.backgroundColor  = '#c5e0b4';
                    convenioe.style.color  = 'white';
                }else if(time_difference<0){
                    //$('#convenioe').val('Renovar');
                    $('#estado').val('50');
                    $('#convenioe').val('50');
                    convenioe.style.backgroundColor  = 'red';
                    convenioe.style.color  = 'white';
                }
            }else{
                if(time_difference>=0){
                    //$('#convenioe').val('Activo');
                    $('#estado').val('48');
                    $('#convenioe').val('48');
                    convenioe.style.backgroundColor  = '#c5e0b4';
                }
                else if(time_difference<0){
                    //$('#convenioe').val('Renovar');
                    $('#estado').val('50');
                    $('#convenioe').val('50');
                    convenioe.style.backgroundColor  = 'red';
                }else if(v_a!=""){
                    //$('#convenioe').val('Sin Convenio');
                    $('#estado').val('51');
                    $('#convenioe').val('51');
                    convenioe.style.backgroundColor  = '#eaeaa3';
                    convenioe.style.color  = 'black';
                }else if(v_a==""){
                    //$('#convenioe').val('Inactivo'); 
                    $('#estado').val('49');
                    $('#convenioe').val('49');
                    convenioe.style.backgroundColor  = '#bdd7ee';
                }
                    
            }
        }
        
        
    }

    function Estado(){
        var c=$('#convenioe').val();

        var convenioe = document.getElementById('convenioe');
        
        

        
        if(c==48){
            //$('#convenioe').val('Activo');
            $('#estado').val('48');
            $('#convenioe').val('48');
            convenioe.style.backgroundColor  = '#c5e0b4';
            convenioe.style.color  = 'white';
        }else if(c==50){
            //$('#convenioe').val('Renovar');
            $('#estado').val('50');
            $('#convenioe').val('50');
            convenioe.style.backgroundColor  = 'red';
            convenioe.style.color  = 'white';
        }else if(c==51){
            //$('#convenioe').val('Sin Convenio');
            $('#estado').val('51');
            $('#convenioe').val('51');
            convenioe.style.backgroundColor  = '#eaeaa3';
            convenioe.style.color  = 'black';
        }else if(c==49){
            //$('#convenioe').val('Inactivo'); 
            $('#estado').val('49');
            $('#convenioe').val('49');
            convenioe.style.backgroundColor  = '#bdd7ee';
        }
        else if(c==53){
            //$('#convenioe').val('Inactivo'); 
            $('#estado').val('53');
            $('#convenioe').val('53');
            convenioe.style.backgroundColor  = '';
            convenioe.style.color  = 'black';
        }
        
        
    }

    function difference(date1, date2) {  
        const date1utc = Date.UTC(date1.getFullYear(), date1.getMonth(), date1.getDate());
        const date2utc = Date.UTC(date2.getFullYear(), date2.getMonth(), date2.getDate());
            day = 1000*60*60*24;
        return(date2utc - date1utc)/day
    }

    $('#ruce').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#celular').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('.input_little').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    function Provincia(){
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

    function Update_Centro(){
        var dataString = $("#formulario_centroe").serialize();
        var url="<?php echo site_url(); ?>AppIFV/Update_Centro";
        var id=$('#id_centro').val();
        if (Valida_Centro()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Detalle_Centro/"+id;
                    });
                }
            });
        }
    }

    function Valida_Centro() {
        var nombre=$('#empresae').val();
        if($('#nom_comerciale').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Nombre Comercial.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#empresae').val().trim() === '') {
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
        if($('#ruce').val() == '') {
            Swal(
                'Ups!',
                'Debe ingresar RUC.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Update_Especialidad(){
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
        var dataString = new FormData(document.getElementById('formulario_centroe'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Especialidad";
        if (Valida_Especialidad()) {
            Swal({
                title: 'Actualizar Especialidades',
                text: "¿Realmente desea actualizar especialidades?",
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
                                'Actualización Exitosa!',
                                'Haga clic en el botón!',
                                'success'
                                ).then(function() {
                                    var url2="<?php echo site_url(); ?>AppIFV/List_Guardado_Especialidad";
                                    var dataString2 = new FormData(document.getElementById('formulario_centroe'));
                                    
                                    $.ajax({
                                        type:"POST",
                                        url: url2,
                                        data:dataString2,
                                        processData: false,
                                        contentType: false,
                                        success:function (data) {
                                        $('#div_especialidade').html(data);
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
        
        if($('#direccion_bd').val()>0 ) {
            if ($('#asf').is(":checked")){

            }else{
                if($('#fecha_firmae').val() === '') {
                    Swal(
                        'Ups!',
                        'Debe ingresar fecha firma.',
                        'warning'
                    ).then(function() { });
                    return false;
                }
            }
            
            if($('#val_dee').val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar Valida de.',
                    'warning'
                ).then(function() { });
                return false;
            }
            if($('#val_ae').val() === '') {
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

    function Cancelar_Update_Especialidad(){
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
        var url2="<?php echo site_url(); ?>AppIFV/List_Guardado_Especialidad";
        var dataString2 = new FormData(document.getElementById('formulario_centroe'));
        
        $.ajax({
            type:"POST",
            url: url2,
            data:dataString2,
            processData: false,
            contentType: false,
            success:function (data) {
            $('#div_especialidade').html(data);
            //$("#ModalUpdate .close").click()
        }
        });
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>
