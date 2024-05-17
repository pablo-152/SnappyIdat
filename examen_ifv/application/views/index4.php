<?php 
$session =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('1headerpreguntas'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Examen de Admisión</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="template/corck/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="template/corck/assets/css/pluginspregunta.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="template/corck/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
</head>
<body class="sidebar-noneoverflow" data-spy="scroll" data-target="#navSection" data-offset="100">
    
    <div class="header-container fixed-top">
        <header  class="header navbar navbar-expand-sm" id="headeer">
            <ul class="navbar-item flex-row" >
                <li class="nav-item align-self-center page-heading " >
                    <div class="page-header" >
                        <div class="page-title" ><br>
                            <h3 style="color:#757474"><?php echo $nom_examen ?></b></h3>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="navbar-item flex-row navbar-dropdown">
                
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="template/img/logo2.png" width="55" height="55" alt="">
                        <!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge badge-success"></span>-->
                    </a>
                </li>

            </ul>
            <input type="hidden" class="col-sm-5" id="timerr" name="timerr"  value="<?php echo $timer ?>">
            <input type="hidden" class="col-sm-5" id="timermodal" name="timermodal"  value="<?php echo $timer-600000 ?>">
            <input type="hidden" class="col-sm-5" id="timer120" name="tiempo_limite"  value="<?php echo $timer120-600000 ?>">
            <input type="hidden" class="col-sm-5" id="timer120final" name="timer120final"  value="<?php echo $timer120 ?>">
        </header>

        <header class="header navbar navbar-expand-sm" style="background-color:#1e88e5;">
            <ul class="navbar-item">
                <li class="nav-item notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="template/img/msj.png" width="50" height="50" alt="">
                    </a>
                </li>
            </ul>
            <ul class="navbar-item flex-row">
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header">
                        <div class="page-title">
                            <h3><?php echo $areas[1]['nombre_area'] ?></h3>
                            <!--<h6>RAZONAMIENTO <b>MATEMÁTICO</b></h6>-->
                        </div>
                    </div>
                </li>
            </ul>
            
        </header>
        
    </div><br><br><br><br>
    
       
    <form  method="post" id="formulario" enctype="multipart/form-data" action="<?= site_url('Examendeadmision/Pg5')?>" class="formulario">
        <div class="main-container" id="container">
                <input type="hidden" name="id_postulante" id="id_postulante" value= '<?php echo $id_postulante ?>'>
                <input type="hidden" name="id_carrera" id="id_carrera" value= '<?php echo $id_carrera ?>'>
                <input type="hidden" name="id_examen" id="id_examen" value= '<?php echo $id_examen ?>'>
            
                <div id="content" class="main-content">
                    <div class="container">
                        <div class="container">

                            <!--<div id="navSection" data-spy="affix" class="nav  sidenav">
                                <div class="sidenav-content">
                                <div style="text-align:center;padding:1em 0;"> <h3><a style="text-decoration:none;" href="https://www.zeitverschiebung.net/es/city/3936456"><span style="color:gray;">Hora actual en</span><br />Lima, Perú</a></h3> <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=medium&timezone=America%2FLima" width="100%" height="115" frameborder="0" seamless></iframe> </div>
                                    <a href="#pregunta1" class="active nav-link">Pregunta 31</a>
                                    <a href="#pregunta2" class="nav-link">Pregunta 32</a>
                                    <a href="#pregunta3" class="nav-link">Pregunta 33</a>
                                    <a href="#pregunta4" class="nav-link">Pregunta 34</a>
                                    <a href="#pregunta5" class="nav-link">Pregunta 35</a>
                                    <a href="#pregunta6" class="nav-link">Pregunta 36</a>
                                    <a href="#pregunta7" class="nav-link">Pregunta 37</a>
                                    <a href="#pregunta8" class="nav-link">Pregunta 38</a>
                                    <a href="#pregunta9" class="nav-link">Pregunta 39</a>
                                    <a href="#pregunta10" class="nav-link">Pregunta 40</a>
                                </div>
                            </div>-->
                            
                            <div class="row">
                                <div id="pregunta1" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "31. ".$lista_pregunta[0]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[0]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P1();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[0]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta31" name="id_respuesta31" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="exampleRadios1" style="color:black;word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta2" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "32. ".$lista_pregunta[1]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[1]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P2();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[1]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta32" name="id_respuesta32" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta32" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta3" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "33. ".$lista_pregunta[2]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[2]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P3();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[2]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta33" name="id_respuesta33" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta33" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta4" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "34. ".$lista_pregunta[3]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[3]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P4();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[3]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta34" name="id_respuesta34" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta34" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta5" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "35. ".$lista_pregunta[4]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[4]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P5();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[4]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta35" name="id_respuesta35" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta35" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta6" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "36. ".$lista_pregunta[5]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[5]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P6();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[5]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta36" name="id_respuesta36" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta36" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta7" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "37. ".$lista_pregunta[6]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[6]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P7();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[6]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta37" name="id_respuesta37" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta37" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta8" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "38. ".$lista_pregunta[7]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[7]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P8();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[7]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta38" name="id_respuesta38" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta38" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta9" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "39. ".$lista_pregunta[8]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[8]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P9();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[8]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta39" name="id_respuesta39" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta39" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div id="pregunta10" class="col-lg-12 layout-spacing">
                                    <div class="statbox widget box box-shadow">
                                        <div class="widget-header" style="background-color:#1e88e5">                                
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12 col-12" >
                                                    <h4 style="color:white">Responda a la siguiente pregunta:</h4>
                                                </div>                                                                        
                                            </div>
                                        </div>
                                        <div class="widget-content widget-content-area">
                                            <fieldset class="form-group mb-4">
                                                <div class="row">
                                                    <div  class="col-xl-10 col-md-10 col-sm-10" >
                                                        <div class="form-check">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-15" align="left">
                                                                        <h6 style="color:black" ><?php echo "40. ".$lista_pregunta[9]['pregunta']; ?>&nbsp;&nbsp;<?php if($lista_pregunta[9]['img']!=""){ ?> <a style="cursor:pointer;" class="" href="#" onclick="Img_P10();" title="Ver Imagen"><u> Ver Imagen</u></a> <?php }  ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-9 col-sm-10">
                                                    <?php foreach ( $lista_respuesta as $rpta ){ ?>
                                                        <?php if($lista_pregunta[9]['id_pregunta']==$rpta['id_pregunta']){ ?>
                                                            <div class="form-check">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-1" >
                                                                            <input type="radio"  style="width: 30px;" id="id_respuesta40" name="id_respuesta40" class="form-check-input" value="<?php echo $rpta['id_respuesta']."-".$rpta['correcto'] ?>" >
                                                                        </div>
                                                                        <div class="col-15" align="left">
                                                                            <label class="form-check-label" for="id_respuesta40" style="color:black; word-break: break-all;word-break: break-word;">
                                                                                <?php echo $rpta['desc_respuesta'] ?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-9" >
                        <div align="center">
                            <img src="template/img/4.png" id="por1" alt="">
                            
                            <button  type="button" id="btn_asignar" class="btn btn-primary mb-2 mr-1" title="Siguiente" >
                                SIGUIENTE
                            </button>
                        </div>
                    </div>
                    <div class="footer-wrapper">
                        <div class="footer-section f-section-1">
                            <p class="">Copyright © 2021 <a target="_blank" href="https://designreset.com">GLLG</a>, Todos los derechos reservados.</p>
                        </div>
                    <!-- <div class="footer-section f-section-2">
                            <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                        </div>-->
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-contenedor">
            <div class="popup modal-cerrar" id="quitaragregarer">
                <p class="cerrar"></p>
                    <div class="cuerpo">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[0]['img']; ?>" width="220" height="350"/>
                    </div>
            </div>
        </div>
        <div class="modal-contenedor2">
            <div class="popup2 modal-cerrar2" id="quitaragregarer2">
                <p class="cerrar2"></p>
                <div class="cuerpo2">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[1]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor3">
            <div class="popup3 modal-cerrar3" id="quitaragregarer3">
                <p class="cerrar3"></p>
                <div class="cuerpo3">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[2]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor4">
            <div class="popup4 modal-cerrar4" id="quitaragregarer4">
                <p class="cerrar4"></p>
                <div class="cuerpo4">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[3]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor5">
            <div class="popup5 modal-cerrar5" id="quitaragregarer5">
                <p class="cerrar5"></p>
                <div class="cuerpo5">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[4]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor6">
            <div class="popup6 modal-cerrar6" id="quitaragregarer6">
                <p class="cerrar6"></p>
                <div class="cuerpo6">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[5]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor7">
            <div class="popup7 modal-cerrar7" id="quitaragregarer7">
                <p class="cerrar7"></p>
                <div class="cuerpo7">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[6]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor8">
            <div class="popup8 modal-cerrar8" id="quitaragregarer8">
                <p class="cerrar8"></p>
                <div class="cuerpo8">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[7]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor9">
            <div class="popup9 modal-cerrar9" id="quitaragregarer9">
                <p class="cerrar9"></p>
                <div class="cuerpo9">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[8]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor10">
            <div class="popup10 modal-cerrar10" id="quitaragregarer10">
                <p class="cerrar10"></p>
                <div class="cuerpo10">
                    <img  src="<?php echo $get_link[0]['url_config'].$lista_pregunta[9]['img']; ?>" width="220" height="350"/>
                </div>
            </div>
        </div>
        <div class="modal-contenedor11">
            <div class="popup11 modal-cerrar11" id="quitaragregarer11">
                <p class="cerrar11"></p>
                <div class="cuerpo11">
                <p style="color:white" ><b>Todas las respuestas son obligatorias.</b><br><br>
                Tienes pendiente contestar una pregunta.
                                        </p>
                </div>
            </div>
        </div>
        <div class="modal-contenedor13">
            <div class="popup13 modal-cerrar13" id="quitaragregarer13">
                <p class="cerrar13"></p>
                <div class="cuerpo13">
                <p style="color:white" ><b>Estimado Postulante.</b><br><br>
                Te quedan 10 minutos para terminar el examen.
                                        </p>
                </div>
            </div>
        </div>
        <div class="modal-contenedor14">
            <div class="popup14 modal-cerrar14" id="quitaragregarer14">
                <p class="cerrar14"></p>
                <div class="cuerpo14">
                <p style="text-align: justify;color:white;" >Hola! 
                Excediste los 120 minutos limites para hacer tu examen.<br><br>
                Alguna duda por favor entra en contacto con nosotros.
                                        </p>
                </div>
            </div>
        </div>
    </form>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="template/corck/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="template/corck/bootstrap/js/popper.min.js"></script>
    <script src="template/corck/bootstrap/js/bootstrap.min.js"></script>
    <script src="template/corck/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="template/corck/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="template/corck/plugins/highlight/highlight.pack.js"></script>
    <script src="template/corck/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="template/corck/assets/js/scrollspyNav.js"></script>
</body>
</html>

<script type="text/javascript">
	function Img_P1(){
                    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor").show();
    $(".modal-contenedor").css("opacity", "1");
    $(".modal-contenedor").css("visibility", "visible");
    document.getElementById("quitaragregarer").classList.remove("modal-cerrar");
                           
    }
    function Img_P2(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor2").show();
    $(".modal-contenedor2").css("opacity", "1");
    $(".modal-contenedor2").css("visibility", "visible");
    document.getElementById("quitaragregarer2").classList.remove("modal-cerrar2");                   
    }
    function Img_P3(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor3").show();
    $(".modal-contenedor3").css("opacity", "1");
    $(".modal-contenedor3").css("visibility", "visible");
    document.getElementById("quitaragregarer3").classList.remove("modal-cerrar3");                   
    }
    function Img_P4(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor4").show();
    $(".modal-contenedor4").css("opacity", "1");
    $(".modal-contenedor4").css("visibility", "visible");
    document.getElementById("quitaragregarer4").classList.remove("modal-cerrar4");                   
    }
    function Img_P5(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor5").show();
    $(".modal-contenedor5").css("opacity", "1");
    $(".modal-contenedor5").css("visibility", "visible");
    document.getElementById("quitaragregarer5").classList.remove("modal-cerrar5");                   
    }
    function Img_P6(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor6").show();
    $(".modal-contenedor6").css("opacity", "1");
    $(".modal-contenedor6").css("visibility", "visible");
    document.getElementById("quitaragregarer6").classList.remove("modal-cerrar6");                   
    }
    function Img_P7(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor7").show();
    $(".modal-contenedor7").css("opacity", "1");
    $(".modal-contenedor7").css("visibility", "visible");
    document.getElementById("quitaragregarer7").classList.remove("modal-cerrar7");                   
    }
    function Img_P8(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor8").show();
    $(".modal-contenedor8").css("opacity", "1");
    $(".modal-contenedor8").css("visibility", "visible");
    document.getElementById("quitaragregarer8").classList.remove("modal-cerrar8");                   
    }
    function Img_P9(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor9").show();
    $(".modal-contenedor9").css("opacity", "1");
    $(".modal-contenedor9").css("visibility", "visible");
    document.getElementById("quitaragregarer9").classList.remove("modal-cerrar9");                   
    }
    function Img_P10(){    
    //alert("dni no esta en el sistema");
    $(".modal-contenedor10").show();
    $(".modal-contenedor10").css("opacity", "1");
    $(".modal-contenedor10").css("visibility", "visible");
    document.getElementById("quitaragregarer10").classList.remove("modal-cerrar10");                   
    }
    

    $('#btn_asignar').on('click', function(e){
        var dataString = $("#formulario").serialize();
        //var url="<?php echo site_url(); ?>Alumno/Valida_Nota";
        
        var contador=0;
        $("input[id=id_respuesta31]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta32]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta33]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta34]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta35]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta36]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta37]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta38]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta39]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });
        $("input[id=id_respuesta40]").each(function(){
        if($(this).is(":checked"))
            contador++;
        });

        if(contador==10)
        {
            $('#formulario').submit();
            /*$.ajax({
                    type:"POST",
                    url:url,
                    data:dataString,
                    success:function (data) {
                        if(data=="error")
                        {
                            alert('¡UPS! \rYa respondiste 2 veces este examen.');
                            return false;
                        }if(data=="aprobado")
                        {
                            alert('¡UPS! \rYa respondiste este examen.');
                            return false;
                        }
                        else
                        {
                            $('#formulario').submit();
                        }
                    }
                });*/
            
        }else{
            $(".modal-contenedor11").show();
            $(".modal-contenedor11").css("opacity", "1");
            $(".modal-contenedor11").css("visibility", "visible");
            document.getElementById("quitaragregarer11").classList.remove("modal-cerrar11"); 
            /*alert('¡UPS! \rDebes seleccionar una respuesta por cada pregunta.');*/
            return false;
        }
        
    });

    $('.cerrar,.modal-contenedor').click(function(){
    document.getElementById("quitaragregarer").classList.add("modal-cerrar");
            setTimeout(function(){
                $(".modal-contenedor").css("opacity", "0");
                $(".modal-contenedor").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar2,.modal-contenedor2').click(function(){
    document.getElementById("quitaragregarer2").classList.add("modal-cerrar2");
            setTimeout(function(){
                $(".modal-contenedor2").css("opacity", "0");
                $(".modal-contenedor2").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar3,.modal-contenedor3').click(function(){
    document.getElementById("quitaragregarer3").classList.add("modal-cerrar3");
            setTimeout(function(){
                $(".modal-contenedor3").css("opacity", "0");
                $(".modal-contenedor3").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar4,.modal-contenedor4').click(function(){
    document.getElementById("quitaragregarer4").classList.add("modal-cerrar4");
            setTimeout(function(){
                $(".modal-contenedor4").css("opacity", "0");
                $(".modal-contenedor4").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar5,.modal-contenedor5').click(function(){
    document.getElementById("quitaragregarer5").classList.add("modal-cerrar5");
            setTimeout(function(){
                $(".modal-contenedor5").css("opacity", "0");
                $(".modal-contenedor5").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar6,.modal-contenedor6').click(function(){
    document.getElementById("quitaragregarer6").classList.add("modal-cerrar6");
            setTimeout(function(){
                $(".modal-contenedor6").css("opacity", "0");
                $(".modal-contenedor6").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar7,.modal-contenedor7').click(function(){
    document.getElementById("quitaragregarer7").classList.add("modal-cerrar7");
            setTimeout(function(){
                $(".modal-contenedor7").css("opacity", "0");
                $(".modal-contenedor7").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar8,.modal-contenedor8').click(function(){
    document.getElementById("quitaragregarer8").classList.add("modal-cerrar8");
            setTimeout(function(){
                $(".modal-contenedor8").css("opacity", "0");
                $(".modal-contenedor8").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar9,.modal-contenedor9').click(function(){
    document.getElementById("quitaragregarer9").classList.add("modal-cerrar9");
            setTimeout(function(){
                $(".modal-contenedor9").css("opacity", "0");
                $(".modal-contenedor9").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar10,.modal-contenedor10').click(function(){
    document.getElementById("quitaragregarer10").classList.add("modal-cerrar10");
            setTimeout(function(){
                $(".modal-contenedor10").css("opacity", "0");
                $(".modal-contenedor10").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar11').click(function(){
    document.getElementById("quitaragregarer11").classList.add("modal-cerrar11");
            setTimeout(function(){
                $(".modal-contenedor11").css("opacity", "0");
                $(".modal-contenedor11").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar13').click(function(){
    document.getElementById("quitaragregarer13").classList.add("modal-cerrar13");
            setTimeout(function(){
                $(".modal-contenedor13").css("opacity", "0");
                $(".modal-contenedor13").css("visibility", "hidden");
            },850) 

    });
    $('.cerrar14').click(function(){
    document.getElementById("quitaragregarer14").classList.add("modal-cerrar14");
            setTimeout(function(){
                $(".modal-contenedor14").css("opacity", "0");
                $(".modal-contenedor14").css("visibility", "hidden");
            },850) 

    });
</script>
<script>
        var base_url = '<?php echo site_url(); ?>';
        timer=$('#timerr').val();
        timer2=$('#timermodal').val();
        timer120=$('#timer120').val();
        timer120final=$('#timer120final').val();
        $(document).ready(function() {
        clearTimeout(timeout); 
               // contadorSesion();
        } );

        setTimeout(update, timer120final);
        setTimeout(update, timer);
        setTimeout(modal_tiempo, timer2);
        setTimeout(modal_tiempo, timer120);
        
        function update() {
            var dataString = 1;
            id_postulante=$('#id_postulante').val();
            id_examen=$('#id_examen').val();
            var url="<?php echo site_url(); ?>Examendeadmision/Tiempo_limite";
            $.ajax({
                type:"POST",
                url: url,
                data: {'id_postulante':id_postulante,'id_examen':id_examen},
                
                success:function (data) {
                    $(".modal-contenedor14").show();
                    $(".modal-contenedor14").css("opacity", "1");
                    $(".modal-contenedor14").css("visibility", "visible");
                    document.getElementById("quitaragregarer14").classList.remove("modal-cerrar14");
                    SinTiempo();
                    //window.location = "<?php echo site_url(); ?>Examendeadmision/Tiempo_Agotado";
                    
                }
            });
            
        }

        function modal_tiempo() {
            if(timer120<0 || timer2<0){

            }else{
                $(".modal-contenedor13").show();
                $(".modal-contenedor13").css("opacity", "1");
                $(".modal-contenedor13").css("visibility", "visible");
                document.getElementById("quitaragregarer13").classList.remove("modal-cerrar13");  
                
            }
        }

        function SinTiempo() {
            timeout = setTimeout(salir, 5000);//3 segundos para no demorar tanto 
        }

        function salir() {
            window.location.href = "http://www.ifv.edu.pe/"; //esta función te saca
        }
        
</script>
<?php $this->load->view('3footerpreg'); ?>