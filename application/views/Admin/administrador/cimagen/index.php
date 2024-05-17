<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('Admin/nav'); ?>
<main class="app-content">
    <link href="<?=base_url() ?>template/css/AdminLTE.css" rel="stylesheet" type="text/css">
<section class="content" id="nuevo">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header"> 
                    <h3 class="box-title"><?php echo $_SESSION['usuario'][0]['usuario_nombres'].' '.$_SESSION['usuario'][0]['usuario_apater'].' '.$_SESSION['usuario'][0]['usuario_amater']; ?></h3>
                </div><!-- /.box-header -->
               
                <form  method="post" id="frm_imagen" enctype="multipart/form-data" action="<?= site_url('Snappy/actualizar_img')?>" class="formulario">

                <div class="box-body">

                     <div class="row form-group">
                        <div class="col-xs-8">
                            <label class="col-xs" for="exampleInputNombnres">Imágen de Perfil:</label>
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
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-3">
                            <label for="exampleInputPassword1">Cambiar Imágen:</label>
                            <input name="foto" type="file" id="foto">
                        </div>
                    </div>
                    <input name="id_usuario" type="hidden" class="form-control" id="id_usuario" value="<?php echo $row_p[0]['id_usuario']; ?>">
				</div>
                
                <div class="box-footer">
                   <!-- <button type="button" onClick="Guardar()" class="btn btn-success">Guardar</button>&nbsp;&nbsp;-->

                    <button class="btn btn-primary" id="btn_img" name="btn_img" type="button">Guardar</button>

                    <button onClick="Cancelar()" type="button" class="btn btn-danger">Cancelar</button>
                </div>
            </form>

                    </div><!-- /.box -->

                </div>

            </div>
        </section><!-- /.content -->

    </main>
    <?php $this->load->view('Admin/footer'); ?>

<script type="text/javascript">

    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
        //foto=document.getElementById("foto").value;
        
    });


    $("#btn_img").on('click', function(e){
        if (img()) {
            bootbox.confirm({
                 title: "Estado Snappy",
                 message: "¿Desea actualizar datos?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $('#frm_imagen').submit();
                    }
                } 
            });
         
        } else {
            bootbox.alert(msgDate)
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



    function Cancelar(){
     var url = "<?php echo site_url(); ?>Snappy/index/";
      frm = { };
      $.ajax({
         url: url, 
          type: 'POST',
          data: frm,
      }).done(function(contextResponse, statusResponse, response) {
        // $("#nuevo_proyect").html(contextResponse);
          window.location.href=url;
      })
    }

</script>