<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    .margintop{
        margin-top:5px ;
    }

    .clase_boton{
        height: 32px;
        width: 150px;
        padding: 5px;
    }

    .color_casilla{
        border-color: #C8C8C8;
        color: #000;
        background-color: #C8C8C8 !important;
    }

    .img_class{
        position: absolute;
        width: 80px;
        height: 90px;
        top: 5%;
        left: 1%;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 4%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Retiro de Alumno</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">

                        <a type="button" href="<?= site_url('AppIFV/Matriculados_C') ?>">
                        <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <?php
        $fec_de = new DateTime($get_id[0]['Fecha_Cumpleanos']);
        $fec_hasta = new DateTime(date('Y-m-d'));
        $diff = $fec_de->diff($fec_hasta); 
    ?>

    <div class="container-fluid">
        <form id="formulario_retiro" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="row">
                <div class="col-md-12 row">
                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Código&nbsp;Arpay:</label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Codigo']; ?>">
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Especialidad: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Especialidad']; ?>">
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Grupo: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Grupo']; ?>">
                    </div>
                </div> 

                <div class="col-md-12 row">
                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">A.&nbsp;Paterno: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Paterno']; ?>">
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">A.&nbsp;Materno: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Apellido_Materno']; ?>">
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Nombres: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control " disabled value="<?php echo $get_id[0]['Nombre']; ?>">
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Turno: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Turno']; ?>">
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Módulo: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Modulo']; ?>">
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Celular: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['Celular']; ?>">
                    </div>
                </div>

                <div class="col-md-12 row" style="background-color:#c1c1c1;margin-left: auto;">
                    <div class="form-group col-md-12">
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group col-md-2 text-right">
                            <label class="control-label text-bold margintop">¿Desde cuando no asiste? </label>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="date" class="form-control" id="fecha_nasiste" name="fecha_nasiste" value="<?php if(count($get_id)>0){echo $get_id[0]['Fecha_Fin_Arpay'];} ?>">
                        </div>

                        <div class="form-group col-md-2 text-right">
                            <label class="control-label text-bold margintop">Motivo Arpay: </label>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" disabled value="<?php if(count($get_id)>0){ echo $get_id[0]['Motivo_Arpay']; } ?>">
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div style="display:<?php if(count($get_id)>0){ if($get_id[0]['Motivo_Arpay']=='Otro (mencionar en observaciones)'){ echo "block"; }else{ echo "none"; } } ?>">
                            <div class="form-group col-md-2 text-right">
                                <label class=" control-label text-bold margintop">Observaciones Arpay:</label>
                            </div>
                            <div class="form-group col-md-10">
                                <input type="text" class="form-control" placeholder="Observaciones Arpay" disabled 
                                value="<?php if(count($get_id)>0){ echo $get_id[0]['Observaciones_Arpay']; } ?>">
                            </div>              
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group col-md-2 text-right">
                            <label class="control-label text-bold margintop">Motivo Snappy: </label>
                        </div>
                        <div class="form-group col-md-2">
                            <select class="form-control" name="id_motivo" id="id_motivo" onchange="Motivo_Snappy();">
                                <option value="0">Seleccione</option>
                                <?php foreach($list_motivo as $list){ ?> 
                                    <option value="<?php echo $list['id_motivo'] ?>" 
                                        <?php if(count($get_retirado)>0){ if($get_retirado[0]['id_motivo']==$list['id_motivo']){ echo "selected"; }}?>>
                                        <?php echo $list['nom_motivo'] ?>
                                    </option>  
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div id="div_otro" style="display:<?php if(count($get_retirado)>0){ if($get_retirado[0]['id_motivo']==1){ echo "block"; }else{ echo "none";} }else{ echo "none"; } ?>">
                            <div class="form-group col-md-2 text-right">
                                <label class=" control-label text-bold margintop">¿Cual sería? </label>
                            </div>
                            <div class="form-group col-md-10">
                                <input type="text" class="form-control" id="otro_motivo" name="otro_motivo" placeholder="¿Cual sería?" 
                                value="<?php if(count($get_retirado)>0){ echo $get_retirado[0]['otro_motivo']; } ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group col-md-2 text-right">
                            <label class=" control-label text-bold margintop">¿FUT de retiro? </label>
                        </div>
                        <div class="form-group col-md-2">
                            <select class="form-control" name="fut" id="fut">
                                <option value="0">Seleccione</option>
                                <option value="1" <?php if(count($get_retirado)>0){ if($get_retirado[0]['fut']==1){ echo "selected";} } ?>>SI</option>
                                <option value="2" <?php if(count($get_retirado)>0){ if($get_retirado[0]['fut']==2){ echo "selected";} } ?>>NO</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2 text-right">
                            <label class=" control-label text-bold margintop">Recibo:</label>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="form-control" id="tkt_boleta" name="tkt_boleta" placeholder="Recibo" 
                            value="<?php if(count($get_retirado)>0){ echo $get_retirado[0]['tkt_boleta']; } ?>">
                        </div>

                        <div class="form-group col-md-2 text-right">
                            <label class=" control-label text-bold margintop">Fecha:</label>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="date" class="form-control" id="fecha_fut" name="fecha_fut" value="<?php if(count($get_retirado)>0){ echo $get_retirado[0]['fecha_fut']; } ?>">
                        </div>
                    </div>

                    <div class="col-md-12 row">
                        <div class="form-group col-md-2 text-right">
                            <label class=" control-label text-bold margintop">¿Pagos pendientes? </label>
                        </div>            
                        <div class="form-group col-md-2">
                            <select class="form-control" name="pago_pendiente" id="pago_pendiente">
                                <option value="0">Seleccione</option>
                                <option value="1" <?php if(count($get_retirado)>0){ if($get_retirado[0]['pago_pendiente']==1){ echo "selected"; } }?>>SI</option>
                                <option value="2" <?php if(count($get_retirado)>0){ if($get_retirado[0]['pago_pendiente']==2){ echo "selected"; } }?>>NO</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2 text-right">
                            <label class=" control-label text-bold margintop">Valor:</label>
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" class="margintop form-control" id="monto" name="monto" placeholder="Valor" onkeypress="return soloNumeros(event)" 
                            value="<?php if(count($get_retirado)>0){ echo $get_retirado[0]['monto']; } ?>">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-12">
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class=" control-label text-bold margintop">¿Alumno contactado telefonicamente? </label>
                    </div>
                    <div class="form-group col-md-2">
                        <select class="form-control" name="contacto" id="contacto">
                            <option value="0">Seleccione</option>
                            <option value="1" <?php if(count($get_retirado)>0){ if($get_retirado[0]['contacto']==1){ echo "selected";} } ?>>Si</option>
                            <option value="2" <?php if(count($get_retirado)>0){ if($get_retirado[0]['contacto']==2){ echo "selected";} } ?>>No</option>
                            <option value="3" <?php if(count($get_retirado)>0){ if($get_retirado[0]['contacto']==3){ echo "selected";} } ?>>Incomunicado</option>
                        </select>
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Fecha: </label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="date" class="form-control" id="fecha_contacto" name="fecha_contacto" 
                        value="<?php if(count($get_retirado)>0){ echo $get_retirado[0]['fecha_contacto']; } ?>"> 
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class=" control-label text-bold margintop">Hora:</label>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="time" class="form-control" id="hora_contacto" name="hora_contacto" 
                        value="<?php if(count($get_retirado)>0){ echo $get_retirado[0]['hora_contacto']; } ?>">
                    </div>

                    <div class="form-group col-md-12">
                        <label class=" control-label text-bold margintop">Resuma de una forma clara contenido de ese contacto:</label>
                        <textarea class="form-control" name="resumen" id="resumen" rows="4" placeholder="Resuma de una forma clara contenido de ese contacto"><?php if(count($get_retirado)>0){ echo $get_retirado[0]['resumen']; } ?></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <label class=" control-label text-bold margintop">Observación de Retiro:</label>
                        <textarea class="form-control" name="obs_retiro" id="obs_retiro" rows="4" placeholder="Observación de Retiro"><?php if(count($get_retirado)>0){ echo $get_retirado[0]['obs_retiro']; }else{ echo $get_id[0]['Observacion']; } ?></textarea>
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">¿Posibilidad&nbsp;de&nbsp;reincorporacion?</label>
                    </div>
                    <div class="form-group col-md-2"> 
                        <select class="form-control" name="p_reincorporacion" id="p_reincorporacion">
                            <option value="0">Seleccione</option>
                            <option value="1" <?php if(count($get_retirado)>0){ if($get_retirado[0]['p_reincorporacion']==1){ echo "selected"; }} ?>>Si</option>
                            <option value="2" <?php if(count($get_retirado)>0){ if($get_retirado[0]['p_reincorporacion']==2){ echo "selected"; }} ?>>No</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 row">
                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Actualizado por: 
                        </label>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label text-bold margintop">
                            <?php if(count($get_retirado)>0){ echo $get_retirado[0]['usuario_codigo']." ".$get_retirado[0]['fecha_actualizacion']; } ?>
                        </label>
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Administración:</label>
                    </div>
                    <div class="form-group col-md-2">
                    </div>

                    <div class="form-group col-md-2 text-right">
                        <label class="control-label text-bold margintop">Sec. Académica:</label>
                    </div>    
                    <div class="form-group col-md-2">
                    </div>                
                </div>

                <div class="modal-footer">
                    <input type="hidden" id="id_alumno" name="id_alumno" value="<?php echo $get_id[0]['Id']; ?>">
                    <button type="button" class="btn btn-primary" onclick="Update_Retiro();"><i class="glyphicon glyphicon-ok-sign"></i>Actualizar</button>
                    <a href="<?= site_url('AppIFV/Matriculados_C') ?>" class="btn btn-default" type="button"><i class="glyphicon glyphicon-remove-sign"></i>Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
        $(document).ready(function() {
        $("#calendarizaciones").addClass('active');
        $("#hcalendarizaciones").attr('aria-expanded', 'true');
        $("#matriculados_c").addClass('active');
		document.getElementById("rcalendarizaciones").style.display = "block";
    });

    function Motivo_Snappy(){
        var div = document.getElementById("div_otro");

        $('#otro_motivo').val('');

        if($('#id_motivo').val()==1){
            div.style.display = "block";
        }else{
            div.style.display = "none";
        }
    }

    function Update_Retiro(){
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

        var dataString = new FormData(document.getElementById('formulario_retiro'));
        var url="<?php echo site_url(); ?>AppIFV/Update_Retiro_Alumno";
        
        if (Valida_Update_Retiro()) {
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    window.location.reload();
                }
            });      
        }
    }

    function Valida_Update_Retiro() {
        if($('#fecha_nasiste').val()=="") {
            Swal(
                'Ups!',
                'Debe ingresar fecha Desde cuando no asiste.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_motivo').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar motivo de retiro.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_motivo').val() === '1') {
            if($('#otro_motivo').val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar otro motivo.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#fut').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar ¿Presento FUT de retiro?',
                'warning'
            ).then(function() { });
            return false;
            
        }
        if($('#pago_pendiente').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar ¿Pagos pendientes?',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>