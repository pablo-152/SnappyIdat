

<!DOCTYPE html>

<html lang="en">

  <head>



    <meta name="author" content="leamug">

    <title>.:: SNAPPY ::.</title>

     

    <link href="<?php echo base_url(); ?>template/logincss/css/style.css" rel="stylesheet" type="text/css" id="style">   

    <meta charset="utf-8">

   

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">

    <link href="https://file.myfontastic.com/JwhwQnQW7uohHW8bsm2kd3/icons.css" rel="stylesheet">

    <script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>

  </head>

    <script type="text/javascript">

      $(document).ready(function() {

       

        $('#frm_login').submit(function(event) {

            event.preventDefault();

            var Usuario = document.getElementById("Usuario").value;

            var Password = document.getElementById("Password").value;

            

            //var tipoacc = document.getElementById("tipoacc").value;



            var url = "<?php echo site_url(); ?>" + "/login/ingresar";

            var urlasistencia = "<?php echo site_url(); ?>" + "/Asistencia";

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
                  document.getElementById("resultado").style.display = 'block';
                }

                else{ 
                  location.href = urlasistencia;
                }

              }

            });

          });

      });

    </script>

    <body class="contenedor-sub"> 

      <div class="contenedor-mayorista">

            <!--<form class="formulario" method="post" action="">-->

        <div class="contenedor-minorista2">

          <img src="<?php echo base_url(); ?>template/img/Logo_Snappy.png" class="logo_sn" id="logo_sn" alt="">

          <img src="<?php echo base_url(); ?>template/img/Login_Icon.png" class="icon1" id="icon1" alt="">

          <img src="<?php echo base_url(); ?>template/img/Login_Icon-06.png" id="icon2" alt="">

          <form class="formulario"  id="frm_login" name="frm_login" action="<?= site_url('login/Ingresar') ?>" method="post">

            <p class="subtitulo-logo">

                  <b>Bienvenido,</b><br>

                  haz que los sueños crezcan...

            </p>

            <p>

              <input type="text"  class="form__field" id="Usuario" name="Usuario"  placeholder="Usuario"/>

            </p>

            <p>

              <input type="password" class="form__field" id="Password" name="Password"  placeholder="Contraseña"/>

            </p> 

            <p class="contenedor-check">

              <input type="checkbox" class="checkbox" name="checkbox" id="checkbox1"></input>

              <label for="checkbox1">Recúerdame</label>

            </p>

            <p class="contenedor-buton">

              <button type="submit" >Iniciar</button>
		
              <span role="alert" id="resultado" style="display: block; color:red; text-align:center;">&nbsp;</span>
		
            </p>

          </form>

        </div>

        <div class="contenedor-minorista">

          <img src="<?php echo base_url(); ?>template/img/Logo_Snappy.png" alt="" >

          <div class="subtitulo-minorista">

            <p class="sub-minorista" >

                  <b>Bienvenido,</b><br>

                  haz que los sueños crezcan...

            </p>

          </div>

        </div> 

        

      </div>

         

      <div class="contenedor-footer-img">

        <p class="subtitulo" >

          <img src="<?php echo base_url(); ?>template/img/Logo_GLLG.png" id="icon3" alt="">

        </p>

      </div>

      <div class="contenedor-footer">

        <p class="subtitulo-footer" >

          2021 Global Leadership Group. Todos los derechos reservados.

        </p>

      </div>

    </body>

</html>

