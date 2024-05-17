<?php $sesion =  $_SESSION['usuario'][0];?>

<form method="post" id="from_cmbclave" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Datos de Usuario - <?php echo $camb_clave[0]['usuario_nombres']." ".$camb_clave[0]['usuario_apater']." ".$camb_clave[0]['usuario_amater']?></h5>
      </div>
<div class="modal-body" >
    <div class="col-md-12 row">
          <?php if(isset($camb_clave)){ ?>
               <input  type="hidden" name="id_usuario" id="id_usuario"  value="<?php echo $camb_clave[0]['id_usuario'] ?>">
          <?php } ?> 

         <div class="form-group col-md-12">
             <label class="control-label text-bold">Perfil: </label>
              <?php echo $camb_clave[0]['nom_nivel']?>
        </div>

        <div class="form-group col-md-6">
             <label class="control-label text-bold">Apellido Paterno: </label>
             <?php echo $camb_clave[0]['usuario_apater']?>
        </div>

        <div class="form-group col-md-6">
              <label class="control-label text-bold" >Apellido Materno: </label>
             <?php echo $camb_clave[0]['usuario_amater']?>
         </div>

         <div class="form-group col-md-6">
              <label class="control-label text-bold">Nombres: </label>
              <?php echo $camb_clave[0]['usuario_nombres']?>
         </div>

          <div class="form-group col-md-6">
              <label class="control-label text-bold">Correo: </label>
            <?php echo $camb_clave[0]['emailp']?>
         </div>

         <div class="form-group col-md-6">
              <label class="control-label text-bold">Celular: </label>
              <?php echo $camb_clave[0]['num_celp']?>
         </div>

          <div class="form-group col-md-6">
              <label class="control-label text-bold">Codigo GL: </label>
              <?php echo $camb_clave[0]['codigo_gllg']?>
         </div>
         <div class="form-group col-md-6">
              <label class="control-label text-bold">Week Snappy: </label>
              <?php echo ($camb_clave[0]['redes']+ $camb_clave[0]['artes']);?>
         </div>

          <div class="form-group col-md-6">
              <label class="control-label text-bold">Usuario: </label>
              <?php echo $camb_clave[0]['usuario_codigo']?>
         </div>

          <div class="form-group col-md-6">
              <label class="control-label text-bold">Nueva Clave: </label>
               <input name="usuario_password" type="password" class="form-control" id="usuario_password" placeholder="Ingresar Clave de Intranet">
         </div>
         <div class="form-group col-md-6">
              <label class="control-label text-bold">Confirmar Clave: </label>
              <input name="usuario_passwordn" type="password" class="form-control" id="usuario_passwordn" placeholder="Ingresar Nueva Clave de Intranet">
         </div>

    </div>
</div>

    <div class="modal-footer">
        <button type="button" id="btn_cambiarclave" name="btn_cambiarclave" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
    </div>

</form>

<script >

    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

    $("#btn_cambiarclave").on('click', function(e){
        var dataString = new FormData(document.getElementById('from_cmbclave'));
        var url="<?php echo site_url(); ?>Snappy/Update_clave";
        if (validar()) {
            bootbox.confirm({
                title: "Cambio de Clave",
                message: "¿Desea cambiar su clave?",
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
                                '',
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
  
    function validar()
    {
        if ($('#usuario_password').val().trim() === '')
        {
            msgDate = 'Debe ingresar una nueva clave';
            bootbox.alert(msgDate);
            inputFocus = '#usuario_password';
            return false;
        }

        if ($('#usuario_password').val()!=$('#usuario_passwordn').val())
        {
            msgDate = 'Las claves no coinciden';
            bootbox.alert(msgDate);
            inputFocus = '#usuario_password';
            return false;
        }
        return true;
    }
</script>