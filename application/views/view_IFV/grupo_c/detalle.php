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

            <input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" onclick="Lista_Documento();">
            <label for="tab3">Calendarización</label>

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
</script>
<?php $this->load->view('view_IFV/footer'); ?>