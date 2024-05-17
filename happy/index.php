<?php
	require_once ("config/db.php");
  require_once ("config/conexion.php")
?>

<?php
    $query_p=mysqli_query($con, "SELECT * FROM contacto");
    $row_p=mysqli_fetch_array($query_p);
    $totalRows_p = mysqli_num_rows($query_p);

    $query_d=mysqli_query($con, "SELECT * FROM departamento");
    $row_d=mysqli_fetch_array($query_d);
    $totalRows_d = mysqli_num_rows($query_d);

    $query_r=mysqli_query($con, "SELECT * FROM provincia");
    $row_r=mysqli_fetch_array($query_r);
    $totalRows_r = mysqli_num_rows($query_r);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link href="css/css-plugin-collections.css"/>
  <script src="js/jquery-plugin-collection.js"></script>
  <!-- Stylesheets -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/revolution-slider.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <!--Favicon-->
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <!-- Responsive -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link href="css/responsive.css" rel="stylesheet">
  <title>Happynessweek</title>
  <link href="css/animate.css" rel="stylesheet" type="text/css">
  <link href="css/style_Brii.css" rel="stylesheet" type="text/css">
  <link href="https://fontlibrary.org/face/bebas" type="text/css">
  <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.min.css">
</head>

<body>

<div id="page-top"> 
<div class="page-wrapper">
        <!--<header class="main-header">
          <div class="header-top">
          <div class="row">
          <div class="col-md-12">
               <figure class="author-image" ><img class="img-circle" src="images/gallery/img01.png"  alt=""></figure> 
            </div>
            <div class="col-md-4" align="left">
               <figure class="author-image" ><img class="img-circle1" src="images/gallery/img2.png"  alt=""></figure> 
            </div>
          <div class="col-md-4" align="left">
               <figure class="author-image" ><img class="img-circle2" src="images/gallery/img0.png"  alt=""></figure> 
            </div> 
          </div>
        </div>sm-text-cente
    </header>-->
       <div class="col-md-12">
            <div class="widget no-border m-0">
              <ul class="list-inline">
                <li>
                 <figure class="author-image" ><img class="img-circle" src="images/gallery/img01.png"  alt=""></figure>
                </li>
               
                <li>
                 <figure class="author-image" ><img class="img-circle1" src="images/gallery/img2.png"  alt=""></figure>
                </li>
               
                <li>
                  <figure class="author-image" ><img class="img-circle2 " src="images/gallery/img0.png"></figure> 
                </li>
              </ul>
            </div>
        </div>
    </div>
    </div>

    
  <section class="testimonial-section">
    <div class="container ">
        <div class="row">
           <!--<div class="col-sm-12 " >
            <div class="sec-title ">
         <div class="col-md-12" >-->
              <div class="col-md-6 ">
                <br>
               <span class="txtferia" style="color: #fff"><b>31 DE MAYO AL 5 DE JUNIO DEL 2021  </b> </font></span>
              </div>
            <div class="col-md-4">
                <img class="img-avion"src="images/gallery/happy.png" >
            </div>
       </div>
     </div>

     <div class="col-md-12">
              <div class="col-md-3">
                 <img class="img-avion" src="images/gallery/img11.png" >
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6"></div>

      </div>

        <div class="col-md-12" >
              <div class="col-sm-5">
                <div class="sec-title text-center">
                </div>
                   <p align="justify"> Desde   <font style="color:#CDDB00">Leaders Mind</font> vimos la necesidad de ofrecer un espacio a la comunidad para reflexionar sobre nuestra percepción de felicidad o bienestar, en estos tiempos en que se ven expuestas nuestras capacidades al maximo, y nos hicimos una pregunta:</p>
                 <p align="justify"><font style="color:#CDDB00">¿Qué es felicidad? </font>Encontrando que no habia una definición que pueda englobarla, sentirla y compartirla, es ahi que surge <font style="color:#CDDB00">Happniss Week</font>, como una alternativa para comprender que la felicidad parte de nuestro interior y que se expresa en nuestras acciones, pensamientos y vículos, por ello durante esta semana les ofrecemos la posibilidad de interactuar con experimentadas profesionales en el campo que ofrecerán sus experiencias y sobre todo nos ayudarán a descubrir el camino que lleva una vida plena.</p>

            </div>
             <div class="col-md-1">
            </div>
            <div class="col-md-6">
              <div class="box box4">
                <div class="subdiv1">
                    <label class="Inscribete">&nbsp;&nbsp;&nbsp;&nbsp;Inscribete</label>
                </div>
                <form name="theform" class="form" id="formulario" method="POST" enctype="multipart/form-data">
                    <div class="linea1" >
                        <div class="formulario" > 
                            <input type="text" id="nombre" name="nombre" class="inputformulario" placeholder="Nombre">
                            
                            <input type="text" id="correo" name="correo" class="inputformulario" placeholder="Correo">
                            
                            <input type="text" id="celular" name="celular" class="inputformulario" placeholder="Celular" minlength="9" maxlength="9">
                            
                            <input type="text" id="dni" name="dni" class="inputformulario" placeholder="DNI" minlength="8" maxlength="8">
                            
                            <select id="id_contacto" class="selectformulario" name="id_contacto">
                                <option value="0">¿Cómo te enteraste?</option>
                                <?php
                                if ($totalRows_p > 0){
                                    do {  
                                    ?>
                                    <option value="<?php echo $row_p['id_contacto']?>"><?php echo utf8_encode($row_p['nom_contacto'])?></option>
                                <?php
                                    } while ($row_p = mysqli_fetch_array($query_p));
                                }

                                ?>
                            </select>

                            <select id="id_departamento" class="selectformulario" name="id_departamento" onchange="Departamento();">
                                <option value="0">Seleccione departamento</option>
                                <?php
                                if ($totalRows_d > 0){
                                    do {  
                                    ?>
                                    <option value="<?php echo $row_d['id_departamento']?>"><?php echo utf8_encode($row_d['nombre_departamento'])?></option>
                                <?php
                                    } while ($row_d = mysqli_fetch_array($query_d));
                                }

                                ?>
                            </select>

                            <div id="div_provincia">
                              <select id="id_provincia" class="selectformulario" name="id_provincia">
                                  <option value="0">Seleccione provincia</option>
                              </select>
                            </div>
                             
                            <div class="labelformulario">
                                <div class="subdiv" align="center">
                                  <input type="checkbox" id="terminos" name="terminos">
                                        <span class="check"></span>
                                    <label class="checkbox"><a class="deco" href="" style="font-size: 15px;">Acepto las politicas de privacidad</a> </label>
                                </div>
                             </div>
                               <div class="col-sm-12">
                                  <div class="form-group">
                                   <div class="col-md-4"></div>
                                      <div class="col-md-3 text-center">
                                        <button type="button" onclick="Insert_Happy();" class="button-success1" style="font-size:15px; padding:8px; background:#E81F76; color: #fff;">&nbsp;&nbsp;ENVIAR&nbsp;&nbsp;</button>
                                      </div>
                                  </div>

                                </div>

                        </div>

                    </div>
                     <div class="col-md-7"></div>
                    <div class="col-md-5">
                     <img class="img8" src="images/gallery/img6.png" alt="">
                    </div> 
                </form>
           </div>
         </div>
      </div>
     <!-- <div class="col-md-12">
              <div class="col-md-3">
                   <img class="img-avion"  src="images/gallery/img02.png" >
            </div>
            <div class="col-md-6"></div>

            <div class="col-md-3">
                 <img class="img8" src="images/gallery/img6.png" alt="">
            </div>
      </div> -->  

</div>
</div>
</div>
 </section>

<div class="page-wrapper">
      <header class="main-header">
          <div class="row">

          <div class="col-md-6">
               <figure class="author-image" ><img class="image-slider" src="images/gallery/week_Mesa.png"  alt=""></figure> 
          </div>
            <!--<div class="col-md-5">
               <span class="txtferia" style="color:#CDDB00">¡Atrévete a ser parte de este cambio! </font></span>
              </div>
             <div class="col-md-3" align="left">
               <figure class="author-image" ><img class="" src="images/gallery/img8.png"  alt=""></figure> 
            </div>-->
          </div>
    </header>
</div>
 <footer class="main-footer" >
        <div class="footer-bottom">
          
        </div>
    </footer>

<!--<div class="scroll-to-top scroll-to-target" data-target=".main-header"><span class="icon fa fa-long-arrow-up"></span>
</div>-->
<style type="text/css">
  .deco{
    text-decoration: none;
    color: cornsilk;
    font-size: 12px;
  }
  .box4 .Inscribete{
    color:#CDDB00;
    font-weight: 700;
    font-size: 50px;
    align-self: center;
    font-family: 'Gotham-Bold';
  }
  .form .linea1{
      width: 100% !important;
      height: 100% !important;
      background: #333399;
      display: grid;
      align-items: flex-start;
      justify-content: center;
      justify-items: center;
      padding: 4%;
      border-radius: 1rem;
  }
  .inputformulario{
      width: 100%;
      background-color: white;
      color: rgb(99, 96, 96);
      font-size: 15px;
      padding: 1px 0px 2px 12px;
      margin: 4px 0;
      border: none;
      border-radius: 0px;
      cursor: pointer;
      outline: none;
  }
  .selectformulario{
      width: 100%;
      height: 30px;
      background-color: white;
      color: rgb(99, 96, 96);
      font-size:15px;
      padding: 1px 0px 2px 12px;
      margin: 4px 0;
      border: none;
      border-radius: 0px;
      cursor: pointer;
      outline: none;
  }
  .labelformulario{
      width: 100%;
      color: rgb(99, 96, 96);
      font-size: 15px;
      border: none;
      border-radius: 0px;
      cursor: pointer;
      outline: none;
      display: flex;

  }
</style>

<!--<div class="scroll-to-top scroll-to-target" data-target=".main-header"><span class="icon fa fa-long-arrow-up"></span>
</div>-->

<style type="text/css">
  @font-face{
    font-family:FuturaBookfont;
    src:url(fonts/FuturaBookfont.ttf);
  }

  @font-face{
    font-family:FuturaBookItalic;
    src:url(fonts/FuturaBookItalicfont.ttf);
  }

  @font-face{
    font-family:BebasNeueBold;
    src:url(fonts/BebasNeueBold.ttf);
  }

  @font-face{
    font-family:BebasNeue;
    src:url(fonts/BebasNeue-Regular.otf);
  }

  @font-face{
    font-family:Schadow;
    src:url(fonts/Schadow-BT-Roman.ttf);
  }

  hr .div{
    height: 10px;
    margin-left: 50%;
    margin-right: 0%;
    background-color: red;
  }



     @media (min-width: 360px)  {
          .txt12{
               font-size: 12pt;
               margin-left: 46% !important;
            
            }
            .txt11{
             font-size: 12pt;
            }

        .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 16pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 23pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 8pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 12pt;
            }

          .fr{
            height: 2px !important;
             width: 100% !important;
             margin-left: 37% !important;
             margin-right: 50% !important;
          } 

        .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             left: 10% !important;
             font-size: 140pt;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 155pt;
          }

        .Slider-images2{
            width: 10% !important;
           left: -3% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 100.338px !important;
              height:18.571px !important;
          }

          .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 65.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 97.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 30.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 48.63pt;
          }
          
          .hr1{
            right: 80px !important;
            height: 5px !important;
             width: 95% !important;
          }




     
        .Slider-images1{
            width: 5% !important;
            left: 1% !important;
            top: 1px !important;
          }

        .image-slider1{
            font-size: 1rem !important;
              width: 10.437px !important;
              height:10.171px !important;
          }

         
          .Slider-text{
             right: 20px !important;
          }

              .img-circle {
              font-size: 1rem !important;
              width: 115px !important;
              height:50px !important;
             }
             .img-circle1 {
              font-size: 1rem !important;
              width: 60px !important;
              height:40px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
               margin-left: 20% !important;
              width: 120px !important;
              height:50px !important;
             }
              .sec4{font-family:Schadow  !important;
            font-size: 20px;
             }

               .img-futer {
              font-size: 1rem !important;
              width: 300px !important;;
             }
              .img-avion{
              width: 150% !important;
             }
               .image-slider {
              font-size: 1rem !important;
              width: 20px !important;
              height:10px !important;
              /*width: 61% !important;
              height:100% !important;  49*/  
            }
            .Slider-images{
            width: 10% !important;
            left: -1px !important;
            top: 1px !important;
          }

            .tp-banner-container{
             font-size: 1rem !important;
              width: 100% !important;
              height:100% !important;

            }
            .tp-caption.tp-resizeme{
                padding-left: 0px !important;
            }
             .cls-espacio{
            margin-right: 1px !important;  
            }
                .text-menu{
            font-family: Schadow  !important;
           margin-left: 15% !important;

             }
             .main-menu .navigation > li > a {
                margin-right: 0px !important;  
            }             
            }  


   @media screen and (max-width: 575px) {
            .txt12{
               font-size: 15pt;
               margin-left: 46% !important;
            
            }
            .txt11{
             font-size: 20pt;
            }
    .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 16pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 23pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 8pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 12pt;
            }

          .fr{
            height: 2px !important;
             width: 32% !important;
             margin-left: 32% !important;
             margin-right: 50% !important;
          } 


    .Slider-images2{
            width: 10% !important;
           left: -1.8% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 480.338px !important;
              height:340.571px !important;
          }

           .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 65.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 97.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 30.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 48.63pt;
          }
          
          .hr1{
            right: 80px !important;
            height: 5px !important;
             width: 95% !important;
          }

        .Slider-images1{
            width: 10% !important;
            left: 1% !important;
            top: 1px !important;
          }

        .image-slider1{
            font-size: 1rem !important;
              width: 180.437px !important;
              height:200.171px !important;
          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             left: 10% !important;
             font-size: 140pt;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 155pt;
          }
          .Slider-text{
             right: 40px !important;
          }


              .img-circle {
              font-size: 1rem !important;
              width: 115px !important;
              height:40px !important;
             }
             .img-circle1 {
              font-size: 1rem !important;
              width: 60px !important;
              height:40px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
               margin-left: 20% !important;
              width: 100px !important;
              height:50px !important;
             }

              .sec4{font-family:Schadow  !important;
            font-size: 15px;
             }
             .img_contact{
                width:100%; 
                height:100%;
             }

               .img-futer {
              font-size: 1rem !important;
              width: 350px !important;;
             }
              .img-avion{
              width: 100% !important;
             }

             .image-slider {
              font-size: 1rem !important;
              width: 350.338px !important;
              height:170.571px !important;
            }
            .Slider-images{
            width: 10% !important;
            left: -1px !important;
            top: 1px !important;
          }

         /* .Slider-images{width:750px}}@media (min-width:992px){

              }*/


            .tp-banner-container{
             font-size: 1rem !important;
              width: 100% !important;
              height:100% !important;

            }
            .tp-caption.tp-resizeme{
                padding-left: 0px !important;
            }
             .cls-espacio{
            margin-right: 1px !important;  
            }
             .text-menu{
            font-family: Schadow  !important;
            margin-right: 3px !important;

             }
             .main-menu .navigation > li > a {
                margin-right: 0px !important;  
            }             
            }  
             
              
            @media (min-width: 576px) { 

                 .text-menu{
            font-family: Schadow  !important;
           margin-left: 15% !important;

             }

                 .txt12{
               font-size: 25pt;
               margin-left: 46% !important;
            
            }
            .txt11{
             font-size: 30pt;
            }

                .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 16pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 23pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 8pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 12pt;
            }

          .fr{
            height: 2px !important;
             width: 18% !important;
             margin-left: 40% !important;
             margin-right: 50% !important;
          } 

                 .Slider-images2{
            width: 10% !important;
           left: -2.5% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 820.338px !important;
              height:480.571px !important;
          }

           .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 30.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 50.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 15.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 25.63pt;
          }
          
          .hr1{
            right: 90px !important;
            height: 2px !important;
             width: 98% !important;
          }



            .Slider-images1{
            width: 10% !important;
            left: 1% !important;
            top: 1px !important;
          }

        .image-slider1{
            font-size: 1rem !important;
              width: 258.437px !important;
              height:358.171px !important;
          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             left: 10% !important;
             font-size: 55px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 60px;
          }
          .Slider-text{
             right: 60px !important;
          }


                 .txtferia{font-family:BebasNeue !important;
                    font-size: 30px;
                }
                .sec4{font-family:Schadow  !important;
                    font-size: 15px;
                }
                .txtpatro{font-family:BebasNeue !important;
                    font-size: 40px;
                }
                .txtpatro1{font-family:BebasNeue !important;
                    font-size: 50px;
                    color:  #E81F76;
                }
                 .img-avion{
              width: 100% !important;
             }
             .img_contact{
                width:100%; 
                height:100%;
             }

                .img-futer {
              font-size: 1rem !important;
              width: 350px !important;
             }

               .img-circle {
              font-size: 1rem !important;
              width: 180px !important;
              height:60px !important;
             }
             .img-circle1 {
              font-size: 1rem !important;
              width: 90px !important;
              height:60px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
               margin-left: 20% !important;
              width: 200px !important;
              height:75px !important;
             }
            .image-slider {
              font-size: 1rem !important;
              width: 350.338px !important;
              height:170.571px !important;
            }
            .Slider-images{
            width: 10% !important;
            left: -2px !important;
            top: 1px !important;
          }

             .cls-espacio{
            margin-right: 2px !important;  
            }
           
             .main-menu .navigation > li > a {
                margin-right: 0px !important;  
            }
            .main-menu .navigation > li:before {
                content: '';
                position: absolute;
                left: 10px !important;
                bottom: 4px !important;
                width: 15px;
                height: 2px;
                background: #ffffff;
                opacity: 0;
            }           
            }  
              
            @media (min-width: 768px) {
              .text-menu{
            font-family: Schadow  !important;
           margin-left: 15% !important;

             }

                 .txt12{
               font-size: 25pt;
               margin-left: 46% !important;
            
            }
            .txt11{
             font-size: 30pt;
            }

                .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 12pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 20pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 8pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 12pt;
            }

          .fr{
            height: 2px !important;
             width: 15% !important;
             margin-left: 42% !important;
             margin-right: 50% !important;
          } 

                  .Slider-images2{
            width: 10% !important;
           left: -3% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 1000.338px !important;
              height:550.571px !important;
          }

           .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 65.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 97.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 30.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 48.63pt;
          }
          
          .hr1{
            right: 80px !important;
            height: 5px !important;
             width: 95% !important;
          }

             .Slider-images1{
            width: 10% !important;
            left: 2% !important;
            top: 1px !important;
          }

        .image-slider1{
            font-size: 1rem !important;
              width: 350.437px !important;
              height:450.171px !important;
          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 50px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 60px;
          }
          .Slider-text{
             right: 60px !important;
          }

             .img-futer {
              font-size: 1rem !important;
              width: 350px !important;;
             } 
              .sec4{font-family:Schadow  !important;
            font-size: 20px;
             }

              .img-circle {
              font-size: 1rem !important;
              margin-right: 10% !important;
              width: 250px !important;
              height:90px !important;
                          }
             .img-circle1 {
              font-size: 1rem !important;
              margin-left:40% !important;
              width: 100px !important;
              height:70px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
              margin-left:45% !important;
              width: 250px !important;
              height:90px !important;
             }

                .txtferia{font-family:BebasNeue !important;
                    font-size: 30px;
                }

                .txtpatro{font-family:BebasNeue !important;
                    font-size: 40px;
                }
                 .txtpatro1{font-family:BebasNeue !important;
                    font-size: 40px;
                    color:  #E81F76;
                }
                .img-avion{
              width: 100% !important;
             }
             .img_contact{
                width:200%; 
                height:100%;
             }
         .image-slider {
              font-size: 1rem !important;
              width: 400.338px !important;
              height:200.571px !important;
            }
            .Slider-images{
            width: 10% !important;
            left: -2px !important;
            top: 1px !important;
          }

             .cls-espacio{
            margin-right: 3px !important;  
            }
             
             .main-menu .navigation > li > a {
                margin-right: 0px !important;  
            }
            .sticky-header .main-menu .navigation > li > a {
                padding: 0px 0px !important;
            }
            .main-menu .navigation > li:before {
                content: '';
                position: absolute;
                left: 10px !important;
                bottom: 4px !important;
                width: 15px;
                height: 2px;
                background: #ffffff;
                opacity: 0;
            } 
                   
            }  
              
            @media (min-width: 992px) {
              .text-menu{
            font-family: Schadow  !important;
           margin-left: 10% !important;

             }

                .txt12{
               font-size: 30pt;
               margin-left: 40% !important;
            
            }
            .txt11{
             font-size: 35pt;
            }

                .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 22pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 33pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 11pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 18pt;
            }

          .fr{
            height: 2px !important;
             width: 50% !important;
             margin-left: 25% !important;
             margin-right: 50% !important;
          } 


             .Slider-images2{
            width: 10% !important;
           left: -2.2% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 1000.338px !important;
              height:600.571px !important;
          }

         .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 65.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 97.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 30.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 48.63pt;
          }
          
          .hr1{
            right: 80px !important;
            height: 5px !important;
             width: 95% !important;
          }

                .Slider-images1{
            width: 10% !important;
            left: 2% !important;
            top: 1px !important;
          }

        .image-slider1{
            font-size: 1rem !important;
              width: 350.437px !important;
              height:550.171px !important;

          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 45px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 55px;
          }
          .Slider-text{
             right: 60px !important;
          }


            

                 .img-futer {
              font-size: 1rem !important;
              width: 350px !important;;
             }
            .sec4{font-family:Schadow  !important;
            font-size: 20px;
             }
            .txtferia{font-family:BebasNeue !important;
             font-size: 43px;
            }
            .img-avion{
              width: 150% !important;
             }
              .img_contact{
                width:130%; 
                height:100%;
             }
 
             .img-circle {
              font-size: 1rem !important;
              margin-right: 10% !important;
              width: 300px !important;
              height:100px !important;
                          }
             .img-circle1 {
              font-size: 1rem !important;
              margin-left:50% !important;
              width: 140px !important;
              height:80px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
              margin-left:60% !important;
              width: 310px !important;
              height:100px !important;
             }

             .image-slider {
              font-size: 1rem !important;
              width: 410.338px !important;
              height:200.571px !important;
            }
            .Slider-images{
            width: 10% !important;
            left: -2px !important;
            top: 1px !important;
          }

            .cls-espacio{
            margin-right: 5px !important;  
            }
             
             .main-menu .navigation > li > a {
                margin-right: 15px !important;  
            }
                  
            }  
              
        @media (min-width: 1100px) {
          .text-menu{
            font-family: Schadow  !important;
           margin-left: 12% !important;

             }

             .txt12{
               font-size: 30pt;
               margin-left: 40% !important;
            
            }
            .txt11{
             font-size: 35pt;
            }

           .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 22pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 33pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 11pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 18pt;
            }

          .fr{
            height: 2px !important;
             width: 50% !important;
             margin-left: 25% !important;
             margin-right: 50% !important;
          } 

              .Slider-images2{
            width: 10% !important;
           left: -2.2% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 1100.338px !important;
              height:654.571px !important;
          }

          .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 65.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 97.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 30.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 48.63pt;
          }
          
          .hr1{
            right: 80px !important;
            height: 5px !important;
             width: 95% !important;
          }


         .Slider-images1{
            width: 10% !important;
            left: 2% !important;
            top: 1px !important;
          }

        .image-slider1{
            font-size: 1rem !important;
              width: 417.437px !important;
              height:632.171px !important;

          }
           .image-slider {
              font-size: 1rem !important;
              width: 410.338px !important;
              height:200.571px !important;
            }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 45px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 55px;
          }
          .Slider-text{
             right: 60px !important;
          }

               }



            @media (min-width: 1200px) {
                 .txt12{
               font-size: 35pt;
               margin-left: 32% !important;
            
            }
            .txt11{
             font-size: 40pt;
            }

            .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 22pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 33pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 11pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 18pt;
            }

          .fr{
            height: 2px !important;
             width: 40% !important;
             margin-left: 30% !important;
             margin-right: 50% !important;
          }

            .Slider-images2{
            width: 10% !important;
           left: -2.2% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 1238.338px !important;
              height:722.571px !important;
          }

          .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 87.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 128.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 41.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 64.63pt;
          }
          
          .hr1{
            right: 99px !important;
            height: 5px !important;
             width: 98% !important;
          }

            .image-slider1{
            font-size: 1rem !important;
              width: 417.437px !important;
              height:632.171px !important;

          }
          .Slider-images1{
            width: 10% !important;
            left: 2% !important;
            top: 1px !important;
          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 45px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 55px;
          }
          .Slider-text{
             right: 60px !important;
          }

             .img-futer {
              font-size: 1rem !important;
              width: 350px !important;;
             }
            .sec4{font-family:Schadow  !important;
            font-size: 20px;
             }
            .txtferia{font-family:BebasNeue !important;
             font-size: 43px;
            }
            .img-avion{
              width: 150% !important;
             }
              .img_contact{
                width:110%; 
                height:70%;
             }
   
            .img-circle {
              font-size: 1rem !important;
              margin-right: 10% !important;
              width: 300px !important;
              height:100px !important;
                          }
             .img-circle1 {
              font-size: 1rem !important;
              margin-left:50% !important;
              width: 140px !important;
              height:80px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
              margin-left:60% !important;
              width: 310px !important;
              height:100px !important;
             }
              .image-slider {
              font-size: 1rem !important;
              width: 410.338px !important;
              height:200.571px !important;
            }
            .cls-espacio{
            margin-right: 10px !important;  
            }
            .text-menu{
            font-family: Schadow  !important;
           margin-left: 12% !important;

             }
            .main-menu .navigation > li > a {
                margin-right: 25px !important;  
            } 
            /*.Slider-images{
            width: 100% !important;
            left: 0px !important;
            top: 120px !important;
          }   
          .Slider-images{
            width: 100% !important;
            left: 0px !important;
            top: 105px !important;
          }*/ 
          .image-slider {
              font-size: 1rem !important;
              width: 450.338px !important;
              height:280.571px !important;
              /*width: 61% !important;
              height:100% !important;  49*/  
            }
            .Slider-images{
            width: 10% !important;
            left: -2px !important;
            top: 1px !important;
          }

            }
             @media (min-width: 1300px) {
                .txt12{
               font-size: 35pt;
               margin-left: 32% !important;
            
            }
            .txt11{
             font-size: 40pt;
            }


          .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 25pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 38pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 13pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 20pt;
            }
          .fr{
            height: 2px !important;
             width: 45% !important;
             margin-left: 28% !important;
             margin-right: 50% !important;
          }


              .Slider-images2{
            width: 10% !important;
           left: -2.3% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 1300.338px !important;
              height:722.571px !important;
          }

          .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 87.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 128.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 41.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 64.63pt;
          }
          
          .hr1{
            right: 99px !important;
            height: 5px !important;
             width: 98% !important;
          }

                 .img-futer {
                     font-size: 1rem !important;
                     width:350px !important;;
             }
                .txtferia{font-family:BebasNeue !important;
                    font-size: 40px;
                }
                .sec4{font-family:Schadow  !important;
                font-size: 20px;
                }
            
             .img_contact{
                width:100%; 
                height:60%;
             }


             .img-circle {
              font-size: 1rem !important;
              margin-right: 10% !important;
              width: 300px !important;
              height:100px !important;
                          }
             .img-circle1 {
              font-size: 1rem !important;
              margin-left:150% !important;
              width: 140px !important;
              height:80px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
              margin-left:160% !important;
              width: 320px !important;
              height:105px !important;
             }
             .image-slider {
              font-size: 1rem !important;
              width: 550.338px !important;
              height:240.571px !important;
            }
           .img-avion{
              width: 170% !important;
               
             }
             
            .cls-espacio{
            margin-right: 10px !important;  
            }
            .text-menu{
            font-family: Schadow  !important;
            margin-left: 15% !important;

             }
            .main-menu .navigation > li > a {
                margin-right: 25px !important;  
            } 
              
            }
             @media (min-width: 1400px) {

        .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 30pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 45pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 15pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 24pt;
            }
          .fr{
            height: 2px !important;
             width: 54% !important;
             margin-left: 23% !important;
             margin-right: 50% !important;
          }

                


                .Slider-images2{
            width: 10% !important;
           left: -2.3% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 1400.338px !important;
              height:722.571px !important;
          }

           .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 87.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 128.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 41.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 64.63pt;
          }
          
          .hr1{
            right: 99px !important;
            height: 5px !important;
             width: 98% !important;
          }


              .image-slider1{
            font-size: 1rem !important;
              width: 417.437px !important;
              height:632.171px !important;

          }
          .Slider-images1{
            width: 10% !important;
            left: 10% !important;
            top: 1px !important;
          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 53px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 63px;
          }
          .Slider-text{
             right: 60px !important;
          }

                 .img-futer {
              font-size: 1rem !important;
              width: 30px !important;;
             }
              .sec4{font-family:Schadow  !important;
            font-size: 20px;
             }
            .txtferia{font-family:BebasNeue !important;
             font-size: 43px;
            }
   
            .img-circle {
              font-size: 1rem !important;
              margin-right: 10% !important;
              width: 300px !important;
              height:100px !important;
                          }
             .img-circle1 {
              font-size: 1rem !important;
              margin-left:150% !important;
              width: 140px !important;
              height:80px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
              margin-left:160% !important;
              width: 320px !important;
              height:105px !important;
             }
              .image-slider {
              font-size: 1rem !important;
              width: 550.338px !important;
              height:240.571px !important;
            }
             
             .img_contact{
                width:100%; 
                height:60%;
             }
            .cls-espacio{
            margin-right: 10px !important;  
            }
            .text-menu{
            font-family: Schadow  !important;
             margin-left: 15% !important;

             }
            .main-menu .navigation > li > a {
                margin-right: 25px !important;  
            } 
            /*.Slider-images{
            width: 100% !important;
            left: 0px !important;
            top: 100px !important;
          } */

          
            .Slider-images{
            width: 10% !important;
            left: -2px !important;
            top: 1px !important;
          }
            }
             @media (min-width: 1500px) { 
                .txt12{
               font-size: 35pt;
               margin-left: 32% !important;
            
            }
            .txt11{
             font-size: 40pt;
            }
            

        .f1{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 30pt;
            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 45pt;
            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 15pt;
            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 24pt;
            }
          .fr{
            height: 2px !important;
             width: 54% !important;
             margin-left: 23% !important;
             margin-right: 50% !important;
          }
            .Slider-images2{
            width: 10% !important;
           left: -2% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 1450.338px !important;
              height:723.571px !important;
          }

           .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 98.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 147.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 47.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 74.63pt;
          }
          
          .hr1{
            right: 97px !important;
            height: 5px !important;
             width: 97% !important;
          }

            

              .image-slider1{
            font-size: 1rem !important;
              width: 417.437px !important;
              height:632.171px !important;

          }
          .Slider-images1{
            width: 10% !important;
            left: 10% !important;
            top: 1px !important;
          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 75px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 90px;
          }
          .Slider-text{
             right: 100px !important;
          }

                 .img-futer {
              font-size: 1rem !important;
              width: 10px !important;;
             }
             .sec4{font-family:Schadow  !important;
            font-size: 20px;
             }
            .txtferia{font-family:BebasNeue !important;
             font-size: 43px;
            }
            .img-avion{
              width: 150% !important;
             }

   
             .img-circle {
              font-size: 1rem !important;
              margin-right: 10% !important;
              width: 300px !important;
              height:100px !important;
                          }
             .img-circle1 {
              font-size: 1rem !important;
              margin-left:150% !important;
              width: 140px !important;
              height:80px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
              margin-left:160% !important;
              width: 320px !important;
              height:105px !important;
             }
            .image-slider {
              font-size: 1rem !important;
              width: 550.338px !important;
              height:240.571px !important;
            }
            .Slider-images{
            width: 10% !important;
            left: -2px !important;
            top: 1px !important;
          }

            .cls-espacio{
            margin-right: 10px !important;  
            }
            .text-menu{
            font-family: Schadow  !important;
           margin-left: 15% !important;

             }
            .main-menu .navigation > li > a {
                margin-right: 25px !important;  
            } 
            .image-slider1{
            font-size: 1rem !important;
              width: 417.437px !important;
              height:632.171px !important;

          }
          .Slider-images1{
            width: 10% !important;
            left: 10% !important;
            top: 1px !important;
          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 58px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 70px;
          }
          .Slider-text{
             right: 50px !important;
          }

              
            }
         @media screen and (min-width: 1701px) {



            .img-circle {
              font-size: 1rem !important;
              margin-right: 10% !important;
              width: 300px !important;
              height:100px !important;
                          }
             .img-circle1 {
              font-size: 1rem !important;
              margin-left:150% !important;
              width: 140px !important;
              height:80px !important;
             }
             .img-circle2 {
              font-size: 1rem !important;
              margin-left:160% !important;
              width: 320px !important;
              height:105px !important;
             }
             .img-avion{
              width: 150% !important;
             }
             .img_contact{
                /*width:521.665px; 
                height:390.343px ;float:left;*/
                width:80%; 
                height:50%;

             }


             .img-futer {
              font-size: 1rem !important;
              width: 350px !important;;
             }

             .image-slider {
              font-size: 1rem !important;
              width: 410.338px !important;
              height:200.571px !important;
            }
            .Slider-images{
            width: 10% !important;
            left: -2px !important;
            top: 1px !important;
          }

          .Slider-images2{
            width: 10% !important;
           left: -2.1% !important;
            top: 1px !important;
          }

          .image-slider2{
            font-size: 1rem !important;
              width: 1905.338px !important;
              height:722.571px !important;
          }

           /*.textoa{

            font-family:BebasNeue !important;
            color: #fff;
             font-size: 99.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 147.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 47.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 74.63pt;
          }
          
          .hr1{
            right: 100px !important;
            height: 2px !important;
             width: 100% !important;
          }*/
           .textoa{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 99.68pt;
          }
        .textob{
            font-family:BebasNeue !important;
            font-size: 147.89pt;
          }
          .textoc{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 47.22pt;
          }
        .textod{
            font-family:BebasNeue !important;
            font-size: 74.63pt;
          }
          
          .hr1{
            right: 97px !important;
            height: 5px !important;
             width: 97% !important;
          }
            .image-slider {
              font-size: 1rem !important;
              width: 550.338px !important;
              height:240.571px !important;
            }



          .image-slider1{
            font-size: 1rem !important;
              width: 417.437px !important;
              height:632.171px !important;

          }
          .Slider-images1{
            width: 10% !important;
            left: 10% !important;
            top: 1px !important;
          }

          .texto4{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 75px;
          }
        .texto5{
            font-family:BebasNeue !important;
            color: #F9E100;
            font-size: 90px;
          }
          .Slider-text{
             right: 100px !important;
          }

          .text-menu{
            font-family: Schadow  !important;
            margin-left: 15% !important;

             }  
         .cls-espacio{
            margin-right: 15px !important;  
          } 
          .main-menu .navigation > li > a {
                margin-right: 35px !important;  
            }

         .sec4{font-family:Schadow  !important;
            font-size: 20px;
             }

            .txtferia{font-family:BebasNeue !important;
             font-size: 62px;
             color: #fff;

            }
            .f1{
            font-family:BebasNeue !important;
            color: #fff;
            
             font-size: 35pt;

            }
            .f2{
            font-family:BebasNeue !important;
            color: #fff;
             font-size: 52pt;


            }

            .f3{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 17pt;

            }

            .f4{
            font-family:BebasNeue !important;
            color: #fff;
            font-size: 26pt;

            }
            .fr{
           
            height: 2px !important;
             width: 40% !important;
             margin-left: 30% !important;
             margin-right: 50% !important;
          }
            .txt12{
               font-size: 35pt;
               margin-left: 23% !important;
            
            }
            .txt11{
             font-size: 40pt;
            }

            

         }  


</style>

<script src="sweetalert2/dist/sweetalert2.min.js"></script>
<script src="js/jquery.js"></script>

<script src="js/jquery.bxslider.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script src="js/revolution.min.js"></script>
<script src="js/isotope.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/jquery.fancybox-media.js"></script>

<script src="js/circle-progress.js"></script>
<script src="js/owl.js"></script>
<script type="text/javascript" src="js/jquery.mixitup.min.js"></script>
<script src="js/masterslider/masterslider.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/mixitup.js"></script>
<script src="js/validate.js"></script>
<script src="js/wow.js"></script>
<script src="js/jquery.appear.js"></script>
<script src="js/jquery.countTo.js"></script>
<script src="js/script.js"></script>
<script src="ajaxmail.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>

</body>
</html>

<script>
    function Departamento(){
      var id_departamento=$("#id_departamento").val();
      var url="provincia.php";

      $.ajax({
          type:"POST",
          url:url,
          data: {'id_departamento':id_departamento},
          success:function (data) {
            $('#div_provincia').html(data);
          }
        });
    }

    function Insert_Happy(){
      var dataString = $("#formulario").serialize();
      var url="validar.php";

      if (Valida_Inscripcion()) {
        $.ajax({
          type:"POST",
          url:url,
          data:dataString,
          success:function (data) {
            var val=data.trim();
            if(val=="error"){
              Swal({
                title: 'Registro Denegado',
                text: "¡Ya te has registrado anteriormente",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
              });
            }else{
              swal.fire(
                'Registro Exitoso!',
                'Haga clic en el botón!',
                'success'
              ).then(function() {
                location.reload();
              });
            }
          }
        });
      }
    }

  function Valida_Inscripcion() {
    emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    var celu = $('#celular').val();
    var num = celu.split('');

    if($('#nombre').val() === '') {
      alert('¡UPS! \rDebe ingresar nombre.');
      return false;
    }

    if($('#correo').val() === '') {
      alert('¡UPS! \rDebe ingresar correo.');
      return false;
    }

    if(!emailRegex.test($('#correo').val())) {
      alert('¡UPS! \rDebe ingresar correo válido.');
      return false;
    }

    if(num[0]!=9) {
      alert('¡UPS! \rDebe ingresar celular válido.');
      return false;
    }

    if($('#dni').val() === '') {
      alert('¡UPS! \rDebe ingresar DNI.');
      return false;
    }

    var condiciones = $("#terminos").is(":checked");

    if (!condiciones) {
      alert("¡UPS! \rPara registrarte tienes que aceptar los “Términos y Condiciones”.");
      return false;
    }

    return true;
  }

  $('#nombre').bind('keypress', function(event) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
      event.preventDefault();
      return false;
    }
  });
  
  $('#correo').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9a-zA-ZáéíñóúüÁÉÍÑÓÚÜ_@.-]/g, '');
  });

  $('#celular').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  $('#dni').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
  });
</script>