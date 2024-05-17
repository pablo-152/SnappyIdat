<form method="post" id="formulario_pdf" enctype="multipart/form-data" class="formulario">
    <input type="hidden" name="accion" id="accion" value="<?php if($get_id==0){echo "I";}else{ echo "A";} ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Web IFV <?php if($get_id==0){echo "Registro";}else{ echo "Editar";} ?>  </b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Tipo: </label>
                <div class="col">
                    <select class="form-control" id="flag_referencia" name="flag_referencia" onchange="Flag_Referencia();">
                        <option value="">Seleccione</option>
                        <option value="0" <?php if($get_id==0){echo "";}else{ if($get_id[0]['flag_referencia']==0){echo "selected";} }   ?>>Resultados IFV</option>
                        <option value="1" <?php if($get_id==0){echo "";}else{ if($get_id[0]['flag_referencia']==1){echo "selected";} }   ?>>Triptico</option>
                        <option value="3" <?php if($get_id==0){echo "";}else{ if($get_id[0]['flag_referencia']==3){echo "selected";} }   ?>>Reglamento Interno</option>
                        <option value="2" <?php if($get_id==0){echo "";}else{ if($get_id[0]['flag_referencia']==2){echo "selected";} }   ?>>Imagen</option>

                    </select>
                </div>
            </div>

            <div class="form-group col-md-6">
                <br>
                <br>
                <br>
                
            </div>

            <div id="div_triptico" class="form-group col-md-6" style="visibility:<?php  if($get_id==0){echo "hidden";}else{ if($get_id[0]['flag_referencia']==1 ){echo "visible";}else{echo "hidden";}  }   ?>">
                <label class="control-label text-bold">Carrera: </label>
                <div class="col">
                    <select class="form-control" id="id_carrera" name="id_carrera">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_carrera as $list){?> 
                            <option value="<?php echo $list['id_carrera'] ?>"   <?php  if($get_id==0){ }else{  if($get_id[0]['cod_referencia']==$list['id_carrera']){echo "selected";}  }  ?>  ><?php echo $list['nombre'] ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>

            <div id="div_otro" class="form-group col-md-6" style="visibility:<?php  if($get_id==0){echo "hidden";}else{  if($get_id[0]['flag_referencia']==0 or $get_id[0]['flag_referencia']==3 or $get_id[0]['flag_referencia']==2){echo "visible";}else{echo "hidden";}  }   ?>">
                <label class="control-label text-bold">Referencia: </label>
                <div class="col">
                    <input maxlength="25" type="text" class="form-control" id="refe_comuimg" name="refe_comuimg"  value="<?php  if($get_id==0){  echo ""; }else{ echo $get_id[0]['refe_comuimg'];}   ?>"   placeholder="Ingresar Referencia">
                </div>
            </div>
        </div>
        

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Activo de&nbsp;: </label>
                <div class="col">
                    <input type="date" class="form-control" id="inicio_comuimg" name="inicio_comuimg"  value="<?php  if($get_id==0){ echo ""; }else{ echo $get_id[0]['inicio_comuimg'];}   ?>" >
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Hasta&nbsp;: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fin_comuimg" name="fin_comuimg"  value="<?php  if($get_id==0){  echo ""; }else{ echo $get_id[0]['fin_comuimg'];}   ?>" >
                </div>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>
                <input id="img_comuimg" name="img_comuimg" type="file" size="100" onchange="return fileValidation()" required >
                <span style="color:#867A82;">Maximo 2Mb ó 2048kl</span>
            </div>


            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo:</label>

                <?php if ($get_id == 0) {   echo "No ha adjuntado ningún archivo"; } else {?>

                    <?php if ($get_id[0]['img_comuimg'] != "") { ?>
                            <div id="i_<?php echo  $get_id[0]['id_comuimg'] ?>" >
                                <a style="cursor:pointer;" class="download" type="button" id="download_file" data-image_id="<?php echo $get_id[0]['id_comuimg'] ?>">
                                    <img src="<?= base_url() ?>template/img/descarga_peq.png" style="cursor:pointer; cursor: hand;"/>
                                </a>
                                <a style="cursor:pointer;" class="delete" type="button" id="delete_file" data-image_id="<?php echo  $get_id[0]['id_comuimg'] ?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png" style="cursor:pointer; cursor: hand;"/>
                                </a>
                            </div>
                        <?php } else {
                            echo "No ha adjuntado ningún archivo";
                        } ?>

                <?php } ?>

            </div>

            
        </div>



        <div class="col-md-12 row" id='estado_div'>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Estado&nbsp;: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado" id="estado">
                    <option value="0">Seleccionar</option>
                    <?php foreach ($list_statusva as $list) {

                        if ($get_id[0]['estado'] == $list['id_statusav']) { ?>
                            <option selected value="<?php echo $list['id_statusav']; ?>"><?php echo $list['nom_status']; ?></option>

                        <?php } else { ?>
                            <option value="<?php echo $list['id_statusav']; ?>"><?php echo $list['nom_status']; ?></option>

                    <?php }
                    } ?>
                </select>
            </div>
        </div>
        


    </div>

    <div class="modal-footer">
        <input type="hidden" class="form-control" id="id_comuimg" name="id_comuimg" value="<?php  if($get_id==0){  echo ""; }else{ echo $get_id[0]['id_comuimg'];}   ?>">
        <button type="button" class="btn btn-primary"  onclick="Insert_Update_web_ifv();" >
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>


        $( document ).ready(function() {

                    $('#flag_referencia').trigger('change');

                    var id_carrera= '<?php  if($get_id==0){ echo ''; }else{  echo $get_id[0]['cod_referencia'];  }   ?>';

                    var refe_comuimg='<?php  if($get_id==0){  echo ""; }else{ echo $get_id[0]['refe_comuimg'];} ?>';

               


                    setTimeout(function() { 
                        $('#refe_comuimg').val(refe_comuimg);
                        $('#id_carrera').val(id_carrera);

                    }, 1000);


        });





    function Insert_Update_web_ifv() {
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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

        var dataString = new FormData(document.getElementById('formulario_pdf'));
        
        // var url = "<?php echo site_url(); ?>AppIFV/Insert_web_img";

        var accion ='<?php if($get_id==0){echo "I";}else{ echo "A";} ?>'; 
        var tipo_select=$('#flag_referencia').val();

        if(accion=='I'){


                    if(tipo_select==0 || tipo_select==1){
                        
                        var url = "<?php echo site_url(); ?>AppIFV/Insert_ComuImg";
                        var url2 = "<?php echo site_url(); ?>AppIFV/InsertarPDFIFV";

                        if (Valida_Insert_web_ifv()) {
                            $.ajax({
                                url: url,
                                data: dataString,
                                type: "POST",
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if(data=="error"){
                                        Swal({
                                            title: 'Registro Denegado',
                                            text: 'Existe un registro que coincide con las fechas de publicación ingresada, por favor verificar!',
                                            type: 'error',
                                            showCancelButton: false,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                        });
                                    }else{
                                        $.ajax({  
                                            url: url2,
                                            data: dataString,
                                            type: "POST",
                                            processData: false,
                                            contentType: false,
                                            success: function(data) {
                                                swal.fire(
                                                    'Registro Exitoso',
                                                    'Haga clic en el botón!',
                                                    'success'
                                                ).then(function() {
                                                    window.location = "<?php echo site_url(); ?>AppIFV/Web_IFV";
                                                });
                                            }
                                        });
                                    }
                                }
                            });
                        }


                    }else if(tipo_select== 3){

                        
                        var url = "<?php echo site_url(); ?>AppIFV/Insertar_Reglamento";
                        var url2 = "<?php echo site_url(); ?>AppIFV/InsertarPDF_Reglamento";

                        if (Valida_Insert_web_ifv()) {
                            $.ajax({
                                url: url,
                                data: dataString,
                                type: "POST",
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    $.ajax({
                                        url: url2,
                                        data: dataString,
                                        type: "POST",
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        success: function(data) {
                                            swal.fire(
                                                'Su PDF Reglamento Interno se ha guardado correctamente',
                                                '',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>AppIFV/Web_IFV";
                                            });
                                        }
                                    });
                                }
                            });
                        }



                    }else if(tipo_select== 2){

                        

                        var url = "<?php echo site_url(); ?>AppIFV/Insertar_WebImg";
                        var url2 = "<?php echo site_url(); ?>AppIFV/Insertar_Web_Img_IFV";


                        if (Valida_Insert_web_ifv()) {
                            $.ajax({
                                url: url,
                                data: dataString,
                                type: "POST",
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    $.ajax({
                                        url: url2,
                                        data: dataString,
                                        type: "POST",
                                        processData: false,
                                        contentType: false,
                                        success: function(data) {
                                            swal.fire(
                                                'Su Imagen de Portada IFV se ha guardado correctamente',
                                                'ok',
                                                'success'
                                            ).then(function() {
                                                window.location = "<?php echo site_url(); ?>AppIFV/Web_IFV";
                                            });
                                        }
                                    });
                                }
                            });

                        }

                    }

        }else{



                    if(tipo_select==0 || tipo_select==1){

                        var url = "<?php echo site_url(); ?>AppIFV/Update_ComuImg";
        
                        if (Valida_Insert_web_ifv()) {
                            $.ajax({
                                url: url,
                                data: dataString,
                                type: "POST",
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if(data=="error"){
                                        swal.fire(
                                            'Actualización Denegada',
                                            'Existe un registro que coincide con las fechas de publicación ingresada, por favor verificar!',
                                            'error'
                                        ).then(function() {
                                            
                                        });
                                    }else{
                                        swal.fire(
                                            'Actualización Exitosa',
                                            'Haga clic en el botón!',
                                            'success'
                                        ).then(function() {
                                            window.location = "<?php echo site_url(); ?>AppIFV/Web_IFV";
                                        });  
                                    }
                                }
                            });
                        }
                                        
                       

                    }else if(tipo_select== 3){


                        var url = "<?php echo site_url(); ?>AppIFV/Update_Reglamento";
                        if (Valida_Insert_web_ifv()) {
                            $.ajax({
                                url: url,
                                data: dataString,
                                type: "POST",
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    swal.fire(
                                        'Su PDF Reglamento Interno se ha actualizado correctamente',
                                        '',
                                        'success'
                                    ).then(function() {
                                        window.location = "<?php echo site_url(); ?>AppIFV/Web_IFV";
                                    });
                                }
                            });

                        }

                                        
                        

                    }else if(tipo_select== 2){

                        

                            var url = "<?php echo site_url(); ?>AppIFV/Update_WebImg";
                            if (Valida_Insert_web_ifv()) {
                                $.ajax({
                                    url: url,
                                    data: dataString,
                                    type: "POST",
                                    processData: false,
                                    contentType: false,
                                    success: function(data) {
                                        swal.fire(
                                            'Su Imagen de Portada IFV se ha actualizado correctamente',
                                            'ok',
                                            'success'
                                        ).then(function() {
                                            window.location = "<?php echo site_url(); ?>AppIFV/Web_IFV";


                                        });
                                    }
                                });

                            }

                    }

        }


    }

    function Valida_Insert_web_ifv() {
        if ($('#flag_referencia').val() === '') {
            Swal(
                'Ups!',
                'Debe Seleccionar Tipo.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#flag_referencia').val() === '1' ) {
            if ($('#id_carrera').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe Seleccionar Carrera.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#flag_referencia').val() === '0'  || $('#flag_referencia').val() === '2' || $('#flag_referencia').val() === '3') {
            if ($('#refe_comuimg').val() === '') {
                Swal(
                    'Ups!',
                    'Debe Ingresar Referencia.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#inicio_comuimg').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Inicio.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#fin_comuimg').val() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Fecha Fin.',
                'warning'
            ).then(function() {});
            return false;
        }

        var accion ='<?php if($get_id==0){echo "I";}else{ echo "A";} ?>'; 


        if(accion=='I'){

                if ($('#img_comuimg').val() === '') {
                    Swal(
                        'Ups!',
                        'Debe ingresar Archivo.',
                        'warning'
                    ).then(function() {});
                    return false;
                }
        }else{

            if ($('#img_comuimg').val() === '') {
                    Swal(
                        'Ups!',
                        'Debe ingresar Archivo.',
                        'warning'
                    ).then(function() {});
                    return false;
                }

        }

        var flag_referencia_val = $('#flag_referencia').val() 

        if(flag_referencia_val==3){

            


        }else{

            if ($('#estado').val() === '0') {
                Swal(
                    'Ups!',
                    'Debe seleccionar Estado.',
                    'warning'
                ).then(function() {});
                return false;
            }

        }
       


        return true;
    }

    function fileValidation(){
            var fileInput = document.getElementById('img_comuimg');
            var filePath = fileInput.value;

            var tipo =$('#flag_referencia').val();


            if(tipo !=""){

                    if( tipo == 0 || tipo == 1 ||  tipo == 3 ){
                        var allowedExtensions = /(.pdf)$/i;
                        var texto = '.pdf '
                        var msg = 'un pdf '

                    }else if (tipo == 2 ){
                        var allowedExtensions = /(.jpg)$/i;
                        var texto = '.jpeg/.jpg/.png/.gif '
                        var msg = 'una imagen '

                    }





                    if(!allowedExtensions.exec(filePath)){
                       
                        swal(
                                    'Alerta',
                                    'Cargue un archivo que termine en '+ texto,
                                    'error'
                                )


                        fileInput.value = '';
                        return false;
                    }else{





                        let img = new Image()
                        img.src = window.URL.createObjectURL(event.target.files[0])
                        img.onload = () => {
                            if (img.width === 1920 && img.height === 1291) {
                                //alert(`Agradable, la imagen tiene el tamaño correcto. Se puede subir.`)
                                swal(
                                    'Tipo de archivo',
                                    'el archivo es '+msg,
                                    'success'
                                )

                            } else {
                                alert(`Lo sentimos, esta imagen de ${img.width} x ${img.height} de tamaño no se parece a lo que se pide. Se requiere que el tamaño sea 1920 x 1291.`);
                            }
                        }

                    
                    }

            }else{

                Swal(
                    'Ups!',
                    'Debe escoger el tipo primero .',
                    'warning'
                )

            }


           


        }

    
    function Flag_Referencia(){
        var div1 = document.getElementById("div_triptico");
        var div2 = document.getElementById("div_otro");

        var estado_div = document.getElementById("estado_div");

        var accion ='<?php if($get_id==0){echo "I";}else{ echo "A";} ?>'; 


        $('#id_carrera').val('0');
        $('#refe_comuimg').val('');

        if($('#flag_referencia').val()!=""){
            if($('#flag_referencia').val()=="1"){
                div1.style.visibility='visible';
                div2.style.visibility = "hidden";

                estado_div.style.display = "block";

            }
            if($('#flag_referencia').val()=="0"){
                div1.style.visibility = "hidden";
                div2.style.visibility = "visible";

                estado_div.style.display = "block";

            }
            if($('#flag_referencia').val()=="3"){
                div1.style.visibility = "hidden";
                div2.style.visibility = "visible";




                if(accion=='I'){

                            estado_div.style.display = "none";

                }else{

                    estado_div.style.display = "none";


                }





            }
            if($('#flag_referencia').val()=="2"){
                div1.style.visibility = "hidden";
                div2.style.visibility = "visible";

                estado_div.style.display = "block";

            }
        }else{
            div1.style.visibility = "hidden";
            div2.style.visibility = "hidden";

            estado_div.style.display = "block";

        }
    }


    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>AppIFV/Descargar_Archivo/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>AppIFV/Delete_Archivo',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>

