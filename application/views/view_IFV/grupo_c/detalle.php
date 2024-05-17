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
    .tabset > input:nth-child(19):checked ~ .tab-panels > .tab-panel:nth-child(10),
    .tabset > input:nth-child(21):checked ~ .tab-panels > .tab-panel:nth-child(11){
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
        background: #06c;
    }

    .tabset > input:checked + label {
        border-color: #ccc;
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
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b> <?php echo $get_id[0]['grupo']; ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">   
                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==81 || 
                        $_SESSION['usuario'][0]['id_usuario']==82 || $_SESSION['usuario'][0]['id_usuario']==85 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                            <a title="Asociar Alumno" onclick="Valida_Asociar_Alumno();" style="cursor:pointer;margin-right:5px;"> 
                                <img src="<?= base_url() ?>template/img/asociar_alumno.png">
                            </a>

                            <a title="Nuevo Documento" data-toggle="modal" data-target="#acceso_modal" 
                            app_crear_per="<?= site_url('AppIFV/Modal_Documento_Grupo_C') ?>" style="margin-right: 5px;">
                                <img src="<?= base_url() ?>template/img/documentos_btn.png">
                            </a>

                            <!-- ESTE ONCLICK SOLO ES PARA NOSOTROS -->
                            <?php if($_SESSION['usuario'][0]['id_usuario']==5){ ?>
                                <a onclick="Insert_Grupo_Horario('<?= $get_id[0]['id_grupo']; ?>');" style="cursor:pointer;margin-right:5px;"> 
                                    <img src="<?= base_url() ?>template/img/horario_btn.png">
                                </a>
                            <?php }else{ ?>
                                <a title="Editar" style="cursor:pointer;margin-right:5px;" href="#"> 
                                    <img src="<?= base_url() ?>template/img/horario_btn.png">
                                </a>
                            <?php } ?>

                            <a title="Editar" style="cursor:pointer;margin-right:5px;" href="#"> 
                                <img src="<?= base_url() ?>template/img/comercial_btn.png">
                            </a>
                        <?php } ?>

                        <?php if($_SESSION['usuario'][0]['id_usuario']==1 || 
                        $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                            <a title="Editar" style="cursor:pointer;margin-right:5px;" href="<?= site_url('AppIFV/Editar_Grupo_C') ?>/<?php echo $get_id[0]['id_grupo']; ?>"> 
                                <img src="<?= base_url() ?>template/img/editar_grande.png">
                            </a>
                        <?php } ?>

                        <a type="button" href="<?= site_url('AppIFV/Grupo_C') ?>">
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
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['cod_grupo']; ?>">
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
                <div class="form-group col-md-2"> 
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
                    <label class="col-sm-3 control-label text-bold margintop">Ciclo: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['ciclo']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-2">
                    <label class="control-label text-bold margintop" title="Salir en matriculados">S. matriculados: </label>
                </div>
                <div class="form-group col-md-1">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['s_matriculados']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Inicio: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['inicio']; ?>">
                </div>

                <div class="form-group col-md-1">
                </div>

                <div class="form-group col-md-1">
                    <label class="col-sm-3 control-label text-bold margintop">Termino: </label>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['termino']; ?>">
                </div>
            </div>

            <div class="col-md-12 row">
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
                    <input type="text" class="form-control" disabled value="<?php echo $get_id[0]['id_seccion']; ?>">
                </div>
            </div> 
        </div>

        <div class="row">
            <div class="tabset">
            <input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked onclick="Lista_Alumno();">
            <label for="tab1">Alumnos</label>

            <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2">
            <label for="tab2">Traslados</label>

            <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" onclick="Lista_Documento();">
            <label for="tab3">Calendarización</label>

            <input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4" onclick="Lista_Horario();">
            <label for="tab4">Horario</label>

            <input type="radio" name="tabset" id="tab5" aria-controls="rauchbier5" onclick="Lista_Asistencia();">
            <label for="tab5">Asistencia</label>

            <input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6" onclick="Lista_Retirado();">
            <label for="tab6">Retirados</label>

            <input type="radio" name="tabset" id="tab7" aria-controls="rauchbier7" onclick="Lista_Unidad_Didactica();">
            <label for="tab7">Unid. Did.</label>

            <input type="radio" name="tabset" id="tab8" aria-controls="rauchbier8">
            <label for="tab8">Evaluaciones</label>

            <input type="radio" name="tabset" id="tab9" aria-controls="rauchbier9">
            <label for="tab9">EFSRT</label>

            <input type="radio" name="tabset" id="tab10" aria-controls="rauchbier10">
            <label for="tab10">Comercial</label>

            <input type="radio" name="tabset" id="tab11" aria-controls="rauchbier11" onclick="Lista_Observacion();">
            <label for="tab11">Observaciones</label> 

            <input type="hidden" id="id_grupo" name="id_grupo" value="<?php echo $get_id[0]['id_grupo']; ?>">   
            
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

                <!-- TRASLADOS -->
                <section id="rauchbier2" class="tab-panel">
                    <div class="modal-content">
                    </div>
                </section>

                <!-- DOCUMENTOS -->
                <section id="rauchbier3" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Documento();">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_documento">
                        </div>
                    </div>
                </section>

                <!-- HORARIO -->
                <section id="rauchbier4" class="tab-panel">
                    <div id="datos_horario" class="col-md-12 row">
                    </div>

                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Horario();">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_horario">
                        </div>
                    </div>
                </section>

                <!-- ASISTENCIA -->
                <section id="rauchbier5" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Asistencia();">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_asistencia">
                        </div>
                    </div>
                </section>

                <!-- RETIRADOS -->
                <section id="rauchbier6" class="tab-panel">
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

                <!-- UNIDADES DIDACTICAS -->
                <section id="rauchbier7" class="tab-panel">
                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Unidad_Didactica();">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div class="modal-content">
                        <div id="lista_unidad_didactica">
                        </div>
                    </div>
                </section>

                <!-- EVALUACIONES -->
                <section id="rauchbier8" class="tab-panel">
                    <div class="modal-content">
                    </div>
                </section>

                <!-- EFSRT --> 
                <section id="rauchbier9" class="tab-panel">
                    <div class="modal-content">
                    </div>
                </section>

                <!-- COMERCIAL -->
                <section id="rauchbier10" class="tab-panel">
                    <div class="modal-content">
                    </div>
                </section>                

                <!-- OBSERVACIONES -->
                <section id="rauchbier11" class="tab-panel">
                    <form id="formulario_obs" method="POST" enctype="multipart/form-data" class="formulario">
                        <div class="col-md-12 row">
                            <div class="form-group col-md-2">
                                <label class="control-label text-bold">Tipo:</label>
                                <select class="form-control" name="id_tipo" id="id_tipo">
                                    <option value="0">Seleccione</option>
                                    <option value="1">Alumnos</option>
                                    <option value="5">Asistencia</option>
                                    <option value="10">Comercial</option>
                                    <option value="3">Documentos</option>
                                    <option value="9">EFSRT</option>
                                    <option value="8">Evaluaciones</option>
                                    <option value="11">Generales</option>
                                    <option value="4">Horario</option>
                                    <option value="6">Retirados</option>
                                    <option value="2">Traslados</option>
                                    <option value="7">Unidades Didácticas</option>
                                </select> 
                            </div>

                            <div class="form-group col-md-1">
                                <label class="control-label text-bold">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d') ?>"> 
                            </div>

                            <div class="form-group col-md-1">
                                <label class="control-label text-bold">Usuario:</label>
                                <?php if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==6){ ?>
                                    <select class="form-control" id="usuario" name="usuario">
                                        <option value="0">Seleccione</option>
                                        <?php foreach($list_usuario as $list){?> 
                                            <option value="<?php echo $list['id_usuario'] ?>" <?php if($_SESSION['usuario'][0]['id_usuario']==$list['id_usuario']){ echo "selected"; }?>>
                                                <?php echo $list['usuario_codigo'] ?>
                                            </option>    
                                        <?php }?>
                                    </select>
                                <?php }else{?>
                                    <p><?php echo $_SESSION['usuario'][0]['usuario_codigo'] ?></p>
                                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario'][0]['id_usuario']; ?>">
                                <?php } ?>
                            </div>

                            <div class="form-group col-md-8">
                                <label class="control-label text-bold">Comentario:</label>
                                <input type="text" class="form-control" id="observacion" name="observacion" placeholder="Comentario" maxlength="150">
                            </div>
                            
                            <div class="form-group col-md-12 text-right">
                                <input type="hidden" id="id_grupo" name="id_grupo" value="<?php echo $get_id[0]['id_grupo']; ?>">   
                                <button type="button" onclick="Limpiar_Observacion();" class="btn btn-default">
                                    <i class="glyphicon glyphicon-remove-sign"></i> Limpiar
                                </button>
                                <button type="button" onclick="Insert_Observacion();" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-ok-sign"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="boton_exportable">
                        <a title="Excel" onclick="Excel_Observacion();">
                            <img src="<?= base_url() ?>template/img/boton_excel_tabla.png"> 
                        </a>
                    </div>

                    <div id="lista_observacion">
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() { 
        $("#grupos").addClass('active');
        $("#hgrupos").attr('aria-expanded', 'true'); 
        $("#grupos_c").addClass('active');
		    document.getElementById("rgrupos").style.display = "block";

        Lista_Alumno();  
    });

    function Valida_Asociar_Alumno(){ 
        Cargando();

        var id_grupo = $("#id_grupo").val();
        var url="<?php echo site_url(); ?>AppIFV/Valida_Asociar_Alumno";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_grupo':id_grupo},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Acceso Denegado',
                        text: "¡No tiene horario este grupo!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    window.location = "<?php echo site_url(); ?>AppIFV/Vista_Asociar_Alumno/"+id_grupo;
                }
            }
        });
    }

    function Lista_Alumno(){ 
      Cargando();
      var id_grupo = $("#id_grupo").val();
      var url="<?php echo site_url(); ?>AppIFV/Lista_Alumno_Grupo_C";

      $.ajax({
          type:"POST",
          url:url,
          data: {'id_grupo':id_grupo},
          success:function (data) {
              $('#lista_alumno').html(data);
          }
      });
    }

    function Delete_Asociar_Grupo(id){
      Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Asociar_Grupo";

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
                    type:"POST",
                    url:url,
                    data: {'id':id},
                    success:function () {
                        Lista_Alumno();  
                    }
                });
            }
        })
    }

    function Excel_Alumno(){
      Cargando();
        
        var id_grupo = $('#id_grupo').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Alumno_Grupo_C/"+id_grupo;
    }

    function Lista_Documento(){ 
      Cargando();

        var id_grupo = $("#id_grupo").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Documento_Grupo_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_grupo':id_grupo},
            success:function (data) {
                $('#lista_documento').html(data);
            }
        });
    } 

    function Delete_Documento(id_documento){
      Cargando();
        var url="<?php echo site_url(); ?>AppIFV/Delete_Documento_Grupo_C";

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
                    type:"POST",
                    url:url,
                    data: {'id_documento':id_documento},
                    success:function (data) {
                        Lista_Documento();
                    }
                });
            }
        })
    } 

    function Excel_Documento(){
      Cargando();
        var id_grupo = $('#id_grupo').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Documento_Grupo_C/"+id_grupo;
    }

    function Datos_Horario(){ 
      Cargando();

        var id_grupo = $("#id_grupo").val();
        var url="<?php echo site_url(); ?>AppIFV/Datos_Horario_Grupo_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_grupo':id_grupo},
            success:function (data) {
                $('#datos_horario').html(data);
            }
        });
    }

    function Lista_Horario(){ 
      Cargando();

        var id_grupo = $("#id_grupo").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Horario_Grupo_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_grupo':id_grupo},
            success:function (data) {
                Datos_Horario();
                $('#lista_horario').html(data);
            }
        });
    }

    function Excel_Horario(){
      Cargando();

        var id_grupo = $('#id_grupo').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Horario_Grupo_C/"+id_grupo;
    }

    function Lista_Asistencia(){
      Cargando();

        var id_grupo = $("#id_grupo").val(); 
        var url="<?php echo site_url(); ?>AppIFV/Lista_Asistencia_Grupo_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_grupo':id_grupo},
            success:function (data) {
                $('#lista_asistencia').html(data);
            }
        });
    }

    function Excel_Asistencia(){
      Cargando();

        var id_grupo = $('#id_grupo').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Asistencia_Grupo_C/"+id_grupo;
    }

    function Lista_Retirado(){
      Cargando();

        var id_grupo = $("#id_grupo").val(); 
        var url="<?php echo site_url(); ?>AppIFV/Lista_Retirado_Grupo_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_grupo':id_grupo},
            success:function (data) {
                $('#lista_retirado').html(data);
            }
        });
    }

    function Excel_Retirado(){
      Cargando();

        var id_grupo = $('#id_grupo').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Retirado_Grupo_C/"+id_grupo;
    }

    function Lista_Unidad_Didactica(){
      Cargando();

        var id_grupo = $("#id_grupo").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Unidad_Didactica_Grupo_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_grupo':id_grupo},
            success:function (data) {
                $('#lista_unidad_didactica').html(data);
            }
        });
    }

    function Excel_Unidad_Didactica(){
      Cargando();

        var id_grupo = $('#id_grupo').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Unidad_Didactica_Grupo_C/"+id_grupo;
    }

    function Lista_Observacion(){ 
      Cargando();

        var id_grupo = $("#id_grupo").val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Observacion_Grupo_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'id_grupo':id_grupo},
            success:function (data) {
                $('#lista_observacion').html(data);
            }
        });
    }

    function Limpiar_Observacion(){
        $('#id_tipo').val('0');
        $('#observacion').val('');
        $('#usuario').val('0');
    }

    function Insert_Observacion(){
      Cargando();

        var dataString = new FormData(document.getElementById('formulario_obs'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Observacion_Grupo_C";
        
        if(Valida_Insert_Observacion()){
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Limpiar_Observacion();
                    Lista_Observacion();
                }
            });
        }
    }

    function Valida_Insert_Observacion(){
        if($('#id_tipo').val()==0){
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#fecha').val()==""){
            Swal(
                'Ups!',
                'Debe ingresar Fecha.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#usuario').val()==0){
            Swal(
                'Ups!',
                'Debe seleccionar Usuario.',
                'warning'
            ).then(function() { });
            return false;
        }if($('#observacion').val()==""){
            Swal(
                'Ups!',
                'Debe ingresar Comentario.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Delete_Observacion(id_observacion){
      Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Delete_Observacion_Grupo_C";

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El regitro será eliminado permanentemente",
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
                    url:url,
                    data: {'id_observacion':id_observacion}, 
                    success:function (data) {
                        Lista_Observacion();
                    }
                });
            }
        })
    }

    function Excel_Observacion(){
      Cargando();
        
        var id_grupo = $('#id_grupo').val();
        window.location ="<?php echo site_url(); ?>AppIFV/Excel_Observacion_Grupo_C/"+id_grupo;
    }

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Adjunto_Horario/" + image_id);
    });
    
    function Insert_Grupo_Horario(id_grupo){
      Cargando();

        var url="<?php echo site_url(); ?>AppIFV/Insert_Horario_Grupo_C";
        
        $.ajax({
            type:"POST",
            url:url,
            data:{'id_grupo':id_grupo},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡Ya existe horario para este grupo!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    window.location.reload();
                }
            }
        });
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>