<?php

defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
   <link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/docs/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>template/font-awesome-4.7.0/css/font-awesome.min.css">
     <script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>
   <script type="text/javascript">
      $(document).ready(function() {
        document.getElementById("resultado").style.display = 'none';
        $('#frm_login').submit(function(event) {
            event.preventDefault();
            var Usuario = document.getElementById("Usuario").value;
            var Password = document.getElementById("Password").value;
            
            //var tipoacc = document.getElementById("tipoacc").value;

            var url = "<?php echo site_url(); ?>" + "/login/ingresar";
            var urladministrador = "<?php echo site_url(); ?>" + "/Snappy";
            var urlteamleader= "<?php echo site_url(); ?>" + "/Snappy";
            var urldiseniador= "<?php echo site_url(); ?>" + "/Snappy";
            var urlredes= "<?php echo site_url(); ?>" + "/Snappy";
            var urlsolicitador= "<?php echo site_url(); ?>" + "/Snappy";
            var urlsadministrador= "<?php echo site_url(); ?>" + "/Snappy";
            var urladministradorseo= "<?php echo site_url(); ?>" + "/Ceba";
            var urlsupervisoracademico= "<?php echo site_url(); ?>" + "/Ceba";
            var urlsoporteti= "<?php echo site_url(); ?>" + "/General/Ticket";
            $.ajax({
              url: url,
              data: {
                Usuario:Usuario,
                Password:Password
              },
              type: 'POST',
              success: function(resp){
                //console.log(resp);
                //$('#resultado').html(resp);
                if(resp==="error"){
                  $('#resultado').html("Verifique datos de usuario y/o contraseña");
                  document.getElementById("resultado").style.display = 'block';
                }
                else{ 
                  if(resp == "1"){
                  document.getElementById("resultado").style.display = 'none';
                  location.href = urladministrador;
                  }
                  if(resp == "2")
                  {
                    document.getElementById("resultado").style.display = 'none';
                    location.href = urlteamleader;
                  }
                  if(resp == "3")
                  {
                    document.getElementById("resultado").style.display = 'none';
                    location.href = urldiseniador;
                  }
                  if(resp == "4")
                  {
                    document.getElementById("resultado").style.display = 'none';
                    location.href = urlredes;
                  }
                  if(resp == "5")
                  {
                    document.getElementById("resultado").style.display = 'none';
                    location.href = urlsolicitador;
                  }
                  if(resp == "6")
                  {
                    document.getElementById("resultado").style.display = 'none';
                    location.href = urlsadministrador;
                  }
                  if(resp == "7")
                  {
                    document.getElementById("resultado").style.display = 'none';
                    location.href = urladministradorseo;
                  }
                  if(resp == "8")
                  {
                    document.getElementById("resultado").style.display = 'none';
                    location.href = urlsupervisoracademico;
                  }
                  if(resp == "9")
                  {
                    document.getElementById("resultado").style.display = 'none';
                    location.href = urlsoporteti;
                  }
                }
              }
            });
          });
      });
    </script>
    <title>.:: SNAPPY ::.</title>
  </head>
  <body>
    <!--<section class="material-half-bg">
      <div class="cover"></div>
    </section>-->
    <section class="login-content">
      <div class="logo">
        <img id="profile-img" class="profile-img-card" src="template/img/logo_snapy.png" />
      </div>
      <div class="login-box">
        <form class="login-form"  id="frm_login" name="frm_login" action="<?= site_url('login/Ingresar') ?>" method="post">
          <!--<h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>INICIAR SESIÓN</h3>-->
          <span class="titulo">Bienvenido.</span> <span class="titulo2">Haz que tus proyectos crezcan...</span>
          <p id="profile-name" class="profile-name-card"></p>
          <div class="form-group">
            <input class="textlogin" type="text" id="Usuario" name="Usuario" placeholder="Usuario" required="required" autofocus>
          </div>

          <div class="form-group">
            <input class="textlogin" type="password" id="Password" name="Password" required="required" placeholder="Contraseña">
          </div>
          <div class="form-group btn-container">
            <!--<button class="btn btn-primary btn-block" type="submit" value="Login" id="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>INGRESAR</button>-->
            <button type="submit" class="btn btn-block btn-signin" value="Login" name="login" id="submit">Ingresa</button>
          </div>

          <div class="form-group">
            <div class="utility">
            <!--
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Se te olvidó tu contraseña ?</a></p>-->
            </div>
          </div>
          <center><span role="alert" id="resultado" style="color:red;"></span></center>
          <BR><BR><BR>
       </form>
      </div>

    </section>

     <script type="text/javascript">                
        var user;                                                          
        $("#Password").focus();
        /*$("#Password").keyup(function(e){                  
              user = $("#Usuario").val();
              console.log(user);
               var per_url ="<?php echo site_url(); ?>" + "/login/tippoacceso/"+user;
                    var items = "";
                    $.getJSON(per_url, function(data) {
                       // items="<option value=''>Seleccione</option>";
                        $.each(data, function(key, val) {
                            items = items+"<option value='" + val.Tipo_acceso + "'>" + val.DescAcceso + "</option>"; 
                        });
                         console.log(items);
                         $('#tipoacc').children('option').remove();
                         $('#tipoacc').append(items);
                       

                    });                                                          
        });*/
                     
    </script>
    <!--  javascripts for application -->
   <!-- <script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>-->
    <script src="<?= base_url() ?>template/docs/js/popper.min.js"></script>
    <script src="<?= base_url() ?>template/docs/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>template/docs/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= base_url() ?>/template/docs/js/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
      });
    </script>
  </body>
</html>