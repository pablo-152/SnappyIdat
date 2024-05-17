<?php 
$sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
?>

<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?> 

<style>
    .tabset > input[type="radio"] {
        position: absolute;
        left: -200vw;
    }

    .tabset .tab-panel {
        display: none;
    }

    .tabset > input:first-child:checked ~ .tab-panels > .tab-panel:first-child,
    .tabset > input:nth-child(3):checked ~ .tab-panels > .tab-panel:nth-child(2),
    .tabset > input:nth-child(5):checked ~ .tab-panels > .tab-panel:nth-child(3),
    .tabset > input:nth-child(7):checked ~ .tab-panels > .tab-panel:nth-child(4),
    .tabset > input:nth-child(9):checked ~ .tab-panels > .tab-panel:nth-child(5),
    .tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6),
    .tabset > input:nth-child(13):checked ~ .tab-panels > .tab-panel:nth-child(7),
    .tabset > input:nth-child(15):checked ~ .tab-panels > .tab-panel:nth-child(8),
    .tabset > input:nth-child(17):checked ~ .tab-panels > .tab-panel:nth-child(9),
    .tabset > input:nth-child(19):checked ~ .tab-panels > .tab-panel:nth-child(10){
        display: block;
    }

    .tabset > label {
        position: relative;
        display: inline-block;
        padding: 15px 15px 25px;
        border: 1px solid transparent;
        border-bottom: 0;
        cursor: pointer;
        font-weight: 600;
        background: #799dfd5c;
        width: 110px;
        text-align: center;
    }

    .tabset > label::after {
        content: "";
        position: absolute; 
        left: 15px;
        bottom: 10px;
        width: 22px;
        height: 4px;
        background: #8d8d8d;
    }

    .tabset > label:hover,
    .tabset > input:focus + label {
        color: #06c;
    }

    .tabset > label:hover::after,
    .tabset > input:focus + label::after,
    .tabset > input:checked + label::after {
        background: black;
    }

    .tabset > input:checked + label {
        border-color: black;
        border-width: 2px;
        border-bottom: 1px solid #fff;
        margin-bottom: -1px;
    }

    .tab-panel {
        padding: 30px 0;
        border-top: 1px solid #ccc;
    }

    *,
    *:before,
    *:after {
        box-sizing: border-box;
    }

    .tabset {
        margin: 8px 15px;
    }

    .contenedor1 {
        position: relative;
        height: 80px;
        width: 80px;
        float: left;
    }

    .contenedor1 img {
        position: absolute;
        left: 0;
        transition: opacity 0.3s ease-in-out;
        height: 80px;
        width: 80px;
    }

    .contenedor1 img.top:hover {
        opacity: 0;
        height: 80px;
        width: 80px;
    }

    table th {
        text-align: center;
    }

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

    .boton_exportable{
        margin: 0 0 10px 0;
    }

    .cabecera_pagos{
        margin: 5px 0 0 5px;
    }

    .tab_gris{
        background-color: #C9C9C9 !important;
    }

    .tab_naranja{
        background-color: #f08903 !important; 
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;"> 
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo "(".$get_id[0]['codigo'].") ".$get_id[0]['abreviatura']." - ".$get_id[0]['grupo']; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">    
                        <?php if($get_id[0]['modulo']=="M1"){ ?> 
                            <a data-toggle="modal" data-target="#acceso_modal" 
                            app_crear_per="<?= site_url('AppIFV/Modal_Induccion_Efsrt') ?>/<?php echo str_replace('/','_',$get_id[0]['grupo']); ?>/<?php echo $get_id[0]['id_especialidad']; ?>/<?php echo $get_id[0]['id_modulo']; ?>/<?php echo $get_id[0]['id_turno']; ?>" style="margin-right: 5px;">
                                <img src="<?= base_url() ?>template/img/induccion_efsrt.png">
                            </a>
                        <?php } ?>

                        <a data-toggle="modal" data-target="#acceso_modal" 
                        app_crear_per="<?= site_url('AppIFV/Modal_Firma_Contrato_Efsrt') ?>/<?php echo str_replace('/','_',$get_id[0]['grupo']); ?>/<?php echo $get_id[0]['id_especialidad']; ?>/<?php echo $get_id[0]['id_modulo']; ?>/<?php echo $get_id[0]['id_turno']; ?>" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/subir_contrato.png">
                        </a>

                        <a href="<?= site_url('AppIFV/Efsrt') ?>">
                            <img src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Código:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['codigo']; ?>" style="background-color: #E9EEF3;border-color: #E9EEF3;">
                </div>

                <div class="form-group col-md-1">
                </div>
                
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Grupo:</label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['grupo']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="control-label text-bold margintop">Especialidad:</label>
                </div>
                <div class="form-group col-md-3"> 
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_especialidad']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1"> 
                    <label class="col-sm-3 control-label text-bold margintop">Modulo: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['modulo']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1"> 
                    <label class="col-sm-3 control-label text-bold margintop">Turno: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['nom_turno']; ?>">
                </div> 

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1"> 
                    <label class="col-sm-3 control-label text-bold margintop">Sección: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['seccion']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Inicio: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['inicio_efsrt']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Termino: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['termino_efsrt']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Estado: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['estado']; ?>">
                </div>
            </div>
        </div>

        <div class="row"> 
            <div class="tabset">
            <input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked onclick="Lista_Alumno();">
            <label class="tab_gris" for="tab1">Alumnos</label>

            <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2" onclick="Lista_Retirado();">
            <label class="tab_gris" for="tab2">Retirados</label>

            <?php if($get_id[0]['modulo']=="M1"){ ?>
                <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" onclick="Lista_Induccion();">
                <label for="tab3">Inducción de EFRST</label> 

                <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4" onclick="Lista_Entrega_Formato();">
                <label for="tab4">Entrega Formatos</label>
            <?php }else{ ?>
                <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" disabled>
                <label for="tab3">Inducción de EFRST</label> 

                <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4" disabled>
                <label for="tab4">Entrega Formatos</label>
            <?php } ?>

            <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier5" onclick="Lista_Firma_Contrato();">
            <label for="tab5">Firma Contrato</label>

            <?php if($get_id[0]['modulo']=="M1"){ ?>
                <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6" onclick="Lista_Entrega_Temario();">
                <label for="tab6">Entrega Temario</label>

                <input type="radio" name="tabset" id="tab7" aria-controls="rauchbier7" onclick="Lista_Examen_Basico();">
                <label for="tab7">Examen Básico</label>

                <input type="radio" name="tabset" id="tab8" aria-controls="rauchbier8" onclick="Lista_Evaluacion_Basica();"> 
                <label for="tab8">Evaluación Básica</label>
            <?php }else{ ?>
                <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6" disabled>
                <label for="tab6">Entrega Temario</label>

                <input type="radio" name="tabset" id="tab7" aria-controls="rauchbier7" disabled>
                <label for="tab7">Examen Básico</label>

                <input type="radio" name="tabset" id="tab8" aria-controls="rauchbier8" disabled>
                <label for="tab8">Evaluación Básica</label>
            <?php } ?>

            <input type="radio" name="tabset" id="tab9" aria-controls="rauchbier9" onclick="Lista_Rezagado();">
            <label for="tab9">Rezagados</label>

            <input type="radio" name="tabset" id="tab10" aria-controls="rauchbier10" onclick="Lista_Centro();">
            <label class="tab_naranja" for="tab10">Centros EFSRT</label>

            <input type="hidden" id="grupo" name="grupo" value="<?php echo $get_id[0]['grupo']; ?>">   
            <input type="hidden" id="id_especialidad" name="id_especialidad" value="<?php echo $get_id[0]['id_especialidad']; ?>">   
            <input type="hidden" id="id_modulo" name="id_modulo" value="<?php echo $get_id[0]['id_modulo']; ?>"> 
            <input type="hidden" id="id_turno" name="id_turno" value="<?php echo $get_id[0]['id_turno']; ?>">     
            <input type="hidden" id="seccion" name="seccion" value="<?php echo $get_id[0]['seccion']; ?>">     
            <input type="hidden" name="especialidad" id="especialidad" value="<?php echo $get_id[0]['nom_especialidad']; ?>">
            <input type="hidden" name="modulo" id="modulo" value="<?php echo $get_id[0]['modulo']; ?>">
            <input type="hidden" name="turno" id="turno" value="<?php echo $get_id[0]['cod_turno']; ?>">
            
            <div class="tab-panels">
                <!-- ALUMNOS -->
                <section id="rauchbier1" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Alumno();">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_alumno">
                        </div>
                    </div>
                </section>

                <!-- RETIRADOS -->
                <section id="rauchbier2" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Retirado();">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_retirado">
                        </div>
                    </div>
                </section>      
                
                <!-- INDUCCIÓN EFRST -->
                <section id="rauchbier3" class="tab-panel">
                    <div id="botones_induccion" class="boton_exportable">
                    </div>

                    <div class="modal-content">
                        <div id="lista_induccion">
                        </div>
                    </div>
                </section>  

                <!-- ENTREGA FORMATOS -->
                <section id="rauchbier4" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Entrega_Formato();" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_entrega_formato">
                        </div>
                    </div>
                </section> 

                <!-- FIRMA CONTRATO -->
                <section id="rauchbier5" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Firma_Contrato();" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_firma_contrato">
                        </div>
                    </div>
                </section>     

                <!-- ENTREGA TEMARIO -->
                <section id="rauchbier6" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Entrega_Temario();" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_entrega_temario">
                        </div>
                    </div>
                </section>     
                
                <!-- EXAMEN BASICO -->
                <section id="rauchbier7" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Examen_Basico();" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_examen_basico">
                        </div>
                    </div>
                </section>     

                <!-- EVALUACIÓN BASICA -->
                <section id="rauchbier8" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Evaluacion_Basica();" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>

                        <a title="PDF" onclick="Pdf_Evaluacion_Basica();">
                            <img src="<?= base_url() ?>template/img/boton_pdf_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_evaluacion_basica">
                        </div>
                    </div>
                </section>   
                
                <!-- REZAGADOS -->
                <section id="rauchbier9" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Rezagado();" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_rezagado">
                        </div>
                    </div>
                </section>  

                <!-- CENTROS EFSRT -->
                <section id="rauchbier10" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Centro();" style="margin-right: 5px;">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_centro">
                        </div>
                    </div>
                </section>                  
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#practicas").addClass('active');
        $("#hpracticas").attr('aria-expanded', 'true'); 
        $("#listas_efsrt").addClass('active');
		document.getElementById("rpracticas").style.display = "block";

        Lista_Alumno();  
    });

    function Lista_Alumno(){ 
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Alumno_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#lista_alumno').html(data); 
            }
        });
    }

    function Excel_Alumno(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Alumno_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }

    function Lista_Retirado(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Retirado_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#lista_retirado').html(data);
            }
        });
    }

    function Excel_Retirado(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Retirado_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }

    function Botones_Induccion(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Botones_Induccion_Efsrt";

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#botones_induccion').html(data);
            }
        });
    }

    function Lista_Induccion(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Induccion_Efsrt";

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                Botones_Induccion();
                $('#lista_induccion').html(data);
            }
        });
    }

    function Delete_Induccion(id) { 
        Cargando();

        var url = "<?php echo site_url(); ?>AppIFV/Delete_Induccion_Efsrt";

        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'id_detalle':id},
                    success: function() {
                        Lista_Induccion();
                    }
                });
            }
        })
    }

    function Excel_Induccion(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Induccion_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }

    function Pdf_Induccion(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.open('<?php echo site_url(); ?>AppIFV/Pdf_Induccion_Efsrt/'+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno, '_blank');
    }

    function Lista_Entrega_Formato(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Entrega_Formato_Efsrt";

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#lista_entrega_formato').html(data);
            }
        });
    }

    function Reenviar_Entrega_Formato(id,id_especialidad){   
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Reenviar_Entrega_Formato_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_entrega':id,'id_especialidad':id_especialidad},
            success:function (data) {
                Lista_Entrega_Formato();
            } 
        });
    }

    function Delete_Entrega_Formato(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>AppIFV/Delete_Entrega_Formato_Efsrt";

        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'id_entrega':id},
                    success: function() {
                        Lista_Entrega_Formato();
                    }
                });
            }
        })
    }

    function Excel_Entrega_Formato(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Entrega_Formato_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }

    function Lista_Firma_Contrato(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Firma_Contrato_Efsrt";

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#lista_firma_contrato').html(data);
            }
        });
    }

    function Reenviar_Firma_Contrato(id){    
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Reenviar_Firma_Contrato_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_firma':id},
            success:function (data) {
                Lista_Firma_Contrato();
            } 
        });
    }

    function Descargar_Firma_Contrato(id){
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Firma_Contrato_Efsrt/"+id);
    }

    function Delete_Firma_Contrato(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>AppIFV/Delete_Firma_Contrato_Efsrt";

        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'id_firma':id},
                    success: function() {
                        Lista_Firma_Contrato();
                    }
                });
            }
        })
    }

    function Excel_Firma_Contrato(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Firma_Contrato_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }

    function Lista_Entrega_Temario(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Entrega_Temario_Efsrt";

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#lista_entrega_temario').html(data); 
            }
        });
    }

    function Reenviar_Entrega_Temario(id,id_especialidad){   
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Reenviar_Entrega_Temario_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_entrega':id,'id_especialidad':id_especialidad},
            success:function (data) {
                Lista_Entrega_Temario();
            } 
        });
    }

    function Delete_Entrega_Temario(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>AppIFV/Delete_Entrega_Temario_Efsrt";

        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'id_entrega':id},
                    success: function() {
                        Lista_Entrega_Temario();
                    }
                });
            }
        })
    }

    function Excel_Entrega_Temario(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Entrega_Temario_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }

    function Lista_Examen_Basico(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var seccion = $("#seccion").val();
        var especialidad = $("#especialidad").val();
        var modulo = $("#modulo").val();
        var turno = $("#turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Examen_Basico_Efsrt";

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno,
            'seccion':seccion,'especialidad':especialidad,'modulo':modulo,'turno':turno},
            success:function (data) {
                $('#lista_examen_basico').html(data); 
            }
        });
    }

    function Reenviar_Examen_Basico(id){   
        Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Reenviar_Examen_Basico_Efsrt";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_examen':id},
            success:function (data) {
                Lista_Examen_Basico();
            } 
        });
    }

    function Delete_Examen_Basico(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>AppIFV/Delete_Examen_Basico_Efsrt";

        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'id_examen':id},
                    success: function() {
                        Lista_Examen_Basico();
                    }
                });
            }
        })
    }

    function Excel_Examen_Basico(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Examen_Basico_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }
    
    function Lista_Evaluacion_Basica(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Evaluacion_Basica_Efsrt"; 

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#lista_evaluacion_basica').html(data); 
            }
        });
    }

    function Delete_Evaluacion_Basica(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>AppIFV/Delete_Evaluacion_Basica_Efsrt";

        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {'id_evaluacion':id},
                    success: function() {
                        Lista_Evaluacion_Basica();
                    }
                });
            }
        })
    }

    function Excel_Evaluacion_Basica(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Evaluacion_Basica_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }

    function Pdf_Evaluacion_Basica(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.open('<?php echo site_url(); ?>AppIFV/Pdf_Evaluacion_Basica_Efsrt/'+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno, '_blank');
    }

    function Lista_Rezagado(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Rezagado_Efsrt";

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#lista_rezagado').html(data); 
            }
        });
    }

    function Excel_Rezagado(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Rezagado_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }

    function Lista_Centro(){
        Cargando();

        var grupo = $("#grupo").val();
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Centro_Efsrt";

        $.ajax({
            type:"POST",
            url:url, 
            data: {'grupo':grupo,'id_especialidad':id_especialidad,'id_modulo':id_modulo,'id_turno':id_turno},
            success:function (data) {
                $('#lista_centro').html(data); 
            }
        });
    }

    function Excel_Centro(){
        var grupo = $("#grupo").val().replace('/','_');
        var id_especialidad = $("#id_especialidad").val();
        var id_modulo = $("#id_modulo").val();
        var id_turno = $("#id_turno").val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Centro_Efsrt/"+grupo+"/"+id_especialidad+"/"+id_modulo+"/"+id_turno;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>