<style>
    .grande_check{
        width: 20px;
        height: 20px;
        margin: 0 10px 0 0 !important;
    }

    .label_check{
        position: relative;
        top: -4px;
    }
</style>

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Nuevo Mail</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">




                <div class="col-md-12 row">

               


                    <div class="form-group col-md-1">
                        <label class="control-label text-bold" for="grado_col">Curso</label>
                    </div>
                    <div class="form-group col-md-5">
                   

                        <select class="form-control" name="grado_col" id="grado_col" onchange="Grado(this)">
                            <option value="0" selected>Seleccionar</option>
                            <option value="todos">Todos</option>
                            <?php foreach ($get_list_grado_ll as $list) { ?>
                                    <option  value="<?php echo $list['id_grado']; ?>"><?php echo $list['nom_grado']; ?></option>
                            <?php 
                            } ?>
                        </select>

                    </div>


                    <div class="form-group col-md-1">
                        <label class="control-label text-bold" for="seccion_col">Sección</label>
                    </div>
                    <div class="form-group col-md-5">
                    

                        <select class="form-control" name="seccion_col" id="seccion_col">
                         <option value="0" selected>Seleccionar</option>
                            <!-- <?php foreach ($get_list_seccion_ll as $list) { ?>
                                    <option  value="<?php echo $list['id_seccion']; ?>"><?php echo $list['nom_seccion']; ?></option>
                            <?php 
                            } ?> -->
                        </select>

                    </div>



                    <div class="form-group col-md-1">
                        <label class="control-label text-bold" for="alumno_col">Alumno</label>
                    </div>
                    <div class="form-group col-md-9">
            
                        
                        <select class="form-control" name="alumno_col[]" id="alumno_col" multiple>
                            <!-- <option value="todos">Todos</option>  -->
                            <?php foreach ($list_alumnos as $list) { ?>
                                    <option  value="<?php echo $list['id_alumno']; ?>"><?php echo $list['alum_nom'].' '.$list['alum_apater'].' '.$list['alum_amater']; ?></option>
                            <?php 
                            } ?>
                        </select>

                    </div>

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold" ><input id="chkall" type="checkbox" >Seleccionar todos los alumnos</label>
                    </div>


                </div>


                <div class="col-md-12 row" >

                
                    <div class="form-group col-md-1">
                        <label class="control-label text-bold" for="envio_por">Envío por</label>
                    </div>
                    <div class="form-group col-md-6">
                        <!-- <input type="text" class="form-control" id="envio_por" name="envio_por" placeholder="Envío por" required> -->

                        <select class="form-control" id="envio_por" onchange="Envio_por(this)"  name="envio_por"  >
                            <option value="0"  selected>Seleccione</option>
                            <option value="1">Matricula</option>
                            <option value="2">Fecha</option>
                        </select>

                    </div>

                    <div class="form-group col-md-5" id="matri">
                        
                        <input type="text" readonly class="form-control" id="anio" name="anio" placeholder="Año">

                        <label  class="control-label text-bold" for="">
                            Si es x/ Matricula es siempre que se cancele
                            Cuota Ingreso envía automáticamente el correo.
                        </label>
                    </div>

                    <div class="form-group col-md-5" id="dat">
                        
                        <input type="date" class="form-control" id="fecha" name="fecha" min="<?php echo date('Y-m-d'); ?>" placeholder="Fecha" >

                        <label  class="control-label text-bold" for="">
                            Se envíará a las 6am de la fecha que especifique.
                        </label>

                    </div>
                
                </div>

                <div  class="col-md-12 row" >

                    <div class="form-group col-md-2">
                        <label class="control-label text-bold" for="titulo_mailing">Titulo mailing</label>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" id="titulo_mailing" name="titulo_mailing" placeholder="Envío por" required>
                    </div>





                    <div class="form-group col-md-2">
                        <label class="control-label text-bold" for="text_mailing">Texto mailing</label>
                    </div>

                    <div class="form-group col-md-12">
                        <textarea class="form-control" id="text_mailing" name="text_mailing"cols="30" rows="10"></textarea>
                    </div>




                    <div class="form-group col-md-1">
                        <label class="control-label text-bold" for="archivos">Archivos</label>
                    </div>

                    <div class="form-group col-md-11">
                        <input type="file" class="form-control"  name="archivos[]" id="archivos" multiple>

                    </div>

                
                </div>
            
                <div  class="col-md-12 row" >

                    <div class="form-group col-md-1">
                        <label class="control-label text-bold" for="estado">Estado</label>
                    </div>

                    <div class="form-group col-md-11">
                   
                        <select class="form-control" name="estado" id="estado">
                            <option value="0">Seleccionar</option>
                            <?php foreach ($list_status as $list) { ?>
                                <?php if (2 == $list['id_status']) { ?>
                                    <option selected value="<?php echo $list['id_status']; ?>"><?php echo $list['nom_status']; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $list['id_status']; ?>"><?php echo $list['nom_status']; ?></option>
                            <?php }
                            } ?>
                        </select>

                    </div>

                </div>


    </div> 
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Guardarmail()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>


    function Grado(val) {
        var grado=val.value;
        var url="<?php echo site_url(); ?>CursosCortos/List_seccion";

        $("#seccion_col").html('');
                     $.ajax({
                        url: url, 
                        type: 'post',
                        data: { "grado" : grado },
                        dataType: 'json',
                        success: function (response) {

                            $("#seccion_col").html(
                                `
                                    <option value="0" selected>Seleccionar</option>
                                    <option value="todos">Todos</option>
                                `
                            );

                            
                            $.each(response, function( index, value ) {
                                // alert( index + ": " + value );
                                $( "#seccion_col" ).append( "<option value='"+value[0]+"'>"+value[1]+"</option>" );

                            });

                        }
                    });
    }


    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#c_mailing").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

        $('#anio').val('');

        $('#fecha').val('');



        $("#matri").hide();
        $("#dat").hide();

        $('#alumno_col').select2({
            dropdownParent: $('#acceso_modal')

        });

        $('#grado_col').select2({
            dropdownParent: $('#acceso_modal')

        });

        
        $('#seccion_col').select2({
            dropdownParent: $('#acceso_modal')

        });


        $("#chkall").click(function(){
            if($("#chkall").is(':checked')){
                $("#alumno_col > option").prop("selected", "selected");
                $("#alumno_col").trigger("change");
            } else {
                $("#alumno_col > option").removeAttr("selected");
                $("#alumno_col").trigger("change");
            }
        });

    });

    function Envio_por(val) {
        var empresa=val.value;

        let date = new Date()

        let year = date.getFullYear()

            if(empresa==2){
                $("#matri").hide();
                $("#dat").show();

                
            }else{
                $("#matri").show();
                $("#dat").hide();
                $('#anio').val(year);

            }
    }

    function Valida_Update_Documento() {
             
        if( $('#grado_col').val().trim() != '0' &&  $('#seccion_col').val().trim() != '0' && $('#alumno_col').val() != null) {

                        Swal(
                            'Ups!',
                            'No puede seleccionar (Curso y Sección) con (Alumno) a la vez  .',
                            'warning'
                        ).then(function() { });

                        return false;

        }

               
                if( $('#grado_col').val().trim() === '0' &&  $('#seccion_col').val().trim() === '0') {

                    if($('#alumno_col').val() == null) {
                        Swal(
                            'Ups!',
                            'Debe seleccionar Alumno.',
                            'warning'
                        ).then(function() { });
                        return false;
                    }
                    
                
                }else{

                    if($('#grado_col').val().trim() === '0') {
                            Swal(
                                'Ups!',
                                'Debe seleccionar Grado.',
                                'warning'
                            ).then(function() { });
                            return false;
                        }
                        if($('#seccion_col').val().trim() === '0') {
                            Swal(
                                'Ups!',
                                'Debe seleccionar Sección.',
                                'warning'
                            ).then(function() { });
                            return false;
                        }
                    
                }



          
           

                if($('#envio_por').val().trim() === '0') {
                    Swal(
                        'Ups!',
                        'Debe ingresar Envio por.',
                        'warning'
                    ).then(function() { });
                    return false;
                }

                if($('#titulo_mailing').val().trim() === '') {
                    Swal(
                        'Ups!',
                        'Debe ingresar Titulo.',
                        'warning'
                    ).then(function() { });
                    return false;
                }


                if($('#text_mailing').val().trim() === '') {
                    Swal(
                        'Ups!',
                        'Debe ingresar Texto.',
                        'warning'
                    ).then(function() { });
                    return false;
                }

                if($('#archivos').val().trim() === '') {
                    Swal(
                        'Ups!',
                        'Debe ingresar Archivo.',
                        'warning'
                    ).then(function() { });
                    return false;
                }

                if($('#estado').val().trim() === '0') {
                    Swal(
                        'Ups!',
                        'Debe ingresar Estado.',
                        'warning'
                    ).then(function() { });
                    return false;
                }



        return true;
    }

    function Guardarmail(){		   

            var dataString = new FormData(document.getElementById('formulario_insert'));
            var url="<?php echo site_url(); ?>CursosCortos/Insert_Mailing";


            console.log("🚀 ACA");

            if (Valida_Update_Documento()) {

                    $.ajax({
                        url: url, 
                        type: 'post',
                        data: dataString,
                        contentType: false,
                        processData: false,                        
                        success:function (data) {
                            console.log("🚀 ~ file: index.php:314 ~ response", data);


                                if(data=="exito"){

                                    swal.fire(
                                        'Registro Exitoso',
                                        'Haga clic en el botón!',
                                        'success'
                                    ).then(function() {
                                       
                                        console.log("🚀 ~ file: index.php:314 ~ response", data);
                                    window.location = "<?php echo site_url(); ?>CursosCortos/Mailing";

                                    });
                                
                                }else{

                                    Swal({
                                        title: 'Registro Denegado',
                                        text: "¡El registro ya existe!",
                                        type: 'error',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                    });
                                    
                                }
                            }
                        
                    });
            }
    }



</script>
