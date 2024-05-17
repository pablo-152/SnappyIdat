<?php 
//$session =  $_SESSION['usuario'][0];
//defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?php $this->load->view('1headerpreguntas'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $nom_examen ?></title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="template/corck/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="template/corck/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="template/corck/assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
</head>
<body class="sidebar-noneoverflow" data-spy="scroll" data-target="#navSection" data-offset="100">
    <div class="header-container fixed-top"><br>
        <header class="header navbar navbar-expand-sm">
            <ul class="navbar-item flex-row navbar-dropdown">
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="template/img/logo.png" width="90" height="90" alt="">
                    </a>
                </li>
            </ul>
            <ul class="navbar-item flex-row">
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header">
                        <div class="page-title">
                            <h3>&nbsp;&nbsp;INSTITUTO FEDERICO VILLARREAL</h3>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
        <header class="navbar0 navbar-expand-sm" id="header0">
            <ul class="navbar-item flex-row">
                <li class="nav-item align-self-center page-heading">
                    <div class="page-header">
                        <div class="page-title">
                            <h3></h3>
                        </div>
                    </div>
                </li>
            </ul>

            <ul class="navbar-item flex-row navbar-dropdown">
                <li class="nav-item dropdown notification-dropdown">
                </li>
            </ul>
        </header>
    </div><br><br><br>

    <div class="main-container" id="container">
                <div id="content" class="main-content">
                    <div class="container">
                        <div class="container">
                        </div>
                    </div>

                    <div class="col-lg-12 layout-spacing" >
                        <div class="statbox widget box box-shadow" >
                            <div class="widget-content widget-content-area" >
                                <div id="circle-basic" align="center" class="">
                                    <section>
                                        <img src="template/img/boom.png" width="300" height="300" alt="">
                                        <p style="text-align: center; color:#8a8887; font-family: Franklin Gothic"><FONT SIZE=5>
                                        Recibimos tu examen
                                        satisfactoriamente.
                                        Atento a tu correo.
                                        Nos estaremos
                                        comunicando contigo
                                        lo antes posible.
                                        </FONT></p>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="footer-wrapper">

                        <div class="footer-section f-section-1">

                            <p class="">Copyright © <?php echo date('Y')?> <a target="_blank" href="https://designreset.com">GLLG</a>, Todos los derechos reservados.</p>

                        </div>

                    </div>

                </div>

            </div>



        </div>
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
    <script src="template/corck/assets/js/scrollspyNav.js"></script>
</body>
</html>
<script src="<?= base_url() ?>template/js/jquery-3.2.1.min.js"></script>
<script>
    var base_url = '<?php echo site_url(); ?>';
    var timeout;
    $(document).ready(function() {
        clearTimeout(timeout); 
        contadorSesion();
    } );



    function contadorSesion() {
        timeout = setTimeout(salir, 20000);//3 segundos para no demorar tanto 
    }


    function salir() {
        window.location.href = "http://www.ifv.edu.pe/"; //esta función te saca
    }
</script>

<?php $this->load->view('3footerpreg'); ?>