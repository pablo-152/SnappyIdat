<?php $sesion =  $_SESSION['usuario'][0];?>

<form method="post" id="from_img" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Actualizar Foto de Perfil </h5>
      </div>
<div class="modal-body" >
    <div class="col-md-12 row">
          <!--<?php if(isset($camb_clave)){ ?>
               <input  type="hidden" name="id_usuario" id="id_usuario"  value="<?php echo $camb_clave[0]['id_usuario'] ?>">
          <?php } ?> -->

         <div class="form-group col-md-12">
             <label class="control-label text-bold">Perfil: </label>
                <?php if ($row_p[0]['foto']!=""){ ?>
                                

                <img src="<?= base_url().$row_p[0]['foto']; ?>" class="img-circle" alt="Imagen de Usuario"/>
                <?php } else {?>
                <img src="../img/avatar3.png" class="img-circle" alt="Imagen de Usuario"/>
                <?php } ?>
                    <br>
                <?php if($_SESSION['usuario'][0]['foto']!=$row_p[0]['foto']){ ?>
                <span style="color:red;">Debe cerrar sesión para visualizar su nueva foto de perfil</span>
                <?php } ?>
        </div>

        <div class="form-group col-md-12">
             <label class="control-label text-bold">Cambiar Foto: </label>
             <input name="foto" type="file" id="foto">
        </div>
        <input name="id_usuario" type="hidden" class="form-control" id="id_usuario" value="<?php echo $row_p[0]['id_usuario']; ?>">

        

    </div>
</div>

    <div class="modal-footer">
        <button type="button" id="btn_img" name="btn_img" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
    </div>

</form>

<script >

    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

    $("#btn_img").on('click', function(e){
        var dataString = new FormData(document.getElementById('from_img'));
        var url="<?php echo site_url(); ?>Snappy/actualizar_img";
        if (img()) {
            bootbox.confirm({
                title: "Actualización de Foto",
                message: "¿Desea cambiar actualizar foto de perfil?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    /*if (result) {
                        $('#from_cmbclave').submit();
                    }*/
                    
                    
                    $.ajax({
                        type:"POST",
                        url: url,
                        data:dataString,
                        processData: false,
                        contentType: false,
                        success:function (resp) {
                            //$('#mdistrito').html(resp);
                            
                            swal.fire(
                                'Actualización Exitosa!',
                                'Tiene que cerrar sesión para completar los cambios!',
                                'success'
                                ).then(function() {
                                    //window.location.reload(true);
                                    location.reload(true);
                                });
                        }
                    });
                }
            });
        } else {
            bootbox.alert(msgDate);
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    });
  
    function img() {
        if ($('#foto').val() === '') {
            msgDate = 'Adjuntar Imagen.';
            inputFocus = '#foto';
            return false;
            }
            return true;

    }
</script>