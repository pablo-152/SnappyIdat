<?php $sesion = $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$foto = $sesion['foto'];
$id_sede= '2';
?>

<body class="sidebar-xs">
<div class="navbar navbar-inverse" style="background-color:#2DB443">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?= site_url('LittleLeaders') ?>"><img
                    src="<?= base_url() ?>template/img/logo2.png" alt=""></a>
        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
            </li>
        </ul>
        <p class="navbar-text"><span class="label bg-success">Online</span></p>

        <ul class="nav navbar-nav navbar-right">
            <ul class="nav navbar-nav">
                <?php $busq_menu = in_array('1', array_column($menu, 'id_modulo_mae'));
                if ($busq_menu != false) { ?>
                    <a class="dropdown" href="<?= site_url('General') ?>">
                        <img src="<?= base_url() ?>template/img/estrella_gris.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>

                <?php $busq_empresa = in_array('1', array_column($list_empresa, 'id_empresa'));
                if ($busq_empresa != false) { ?>
                    <a class="dropdown" href="<?= site_url('Snappy') ?>">
                        <img src="<?= base_url() ?>template/img/intranetlogogllg-b.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>

                <?php $busq_empresa = in_array('3', array_column($list_empresa, 'id_empresa'));
                if ($busq_empresa != false) { ?>
                    <a class="dropdown" href="<?= site_url('BabyLeaders') ?>">
                        <img src="<?= base_url() ?>template/img/intranetlogobl-gris.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>

                <?php $busq_empresa = in_array('2', array_column($list_empresa, 'id_empresa'));
                if ($busq_empresa != false) { ?>
                    <a class="dropdown" href="<?= site_url('LittleLeaders') ?>">
                        <img src="<?= base_url() ?>template/img/intranetlogoll.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>

                <?php $busq_empresa = in_array('4', array_column($list_empresa, 'id_empresa'));
                if ($busq_empresa != false) { ?>
                    <a class="dropdown" href="<?= site_url('LeadershipSchool') ?>">
                        <img src="<?= base_url() ?>template/img/intranetlogols-gris.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>

                <?php $busq_empresa = in_array('5', array_column($list_empresa, 'id_empresa'));
                if ($busq_empresa != false) { ?>
                    <a class="dropdown" href="<?= site_url('Ceba2') ?>">
                        <img src="<?= base_url() ?>template/img/intranetlogo05-b.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>

                <?php $busq_empresa = in_array('6', array_column($list_empresa, 'id_empresa'));
                if ($busq_empresa != false) { ?>
                    <a class="dropdown" href="<?= site_url('AppIFV') ?>">
                        <img src="<?= base_url() ?>template/img/intranetlogoifv-gris.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>

                <?php $busq_empresa = in_array('7', array_column($list_empresa, 'id_empresa'));
                if ($busq_empresa != false) { ?>
                    <?php if ($_SESSION['usuario'][0]['cod_sede_la'] == "No") { ?>
                        <a class="dropdown" onclick="Error_Laleli();">
                            <img src="<?= base_url() ?>template/img/intranetlogola-gris.png" class="img-circle"
                                 alt="Imagen de Usuario"/>
                        </a>
                    <?php } else { ?>
                        <?php if ($_SESSION['usuario'][0]['cod_sede_la'] > 0) { ?>
                            <a class="dropdown"
                               href="<?= site_url('Laleli' . $_SESSION['usuario'][0]['cod_sede_la']) ?>">
                                <img src="<?= base_url() ?>template/img/intranetlogola-gris.png" class="img-circle"
                                     alt="Imagen de Usuario"/>
                            </a>
                        <?php } else { ?>
                            <a class="dropdown" href="<?= site_url('Laleli') ?>">
                                <img src="<?= base_url() ?>template/img/intranetlogola-gris.png" class="img-circle"
                                     alt="Imagen de Usuario"/>
                            </a>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>

                <?php $busq_menu = in_array('6', array_column($menu, 'id_modulo_mae'));
                if ($busq_menu != false) { ?>
                    <a class="dropdown" href="<?= site_url('Ca') ?>">
                        <img src="<?= base_url() ?>template/img/intranetlogoca-gris.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>

                <?php $busq_menu = in_array('15', array_column($menu, 'id_modulo_mae'));
                if ($busq_menu != false) { ?>
                    <a class="dropdown" href="<?= site_url('CursosCortos') ?>">
                        <img src="<?= base_url() ?>template/img/intranetlogocc-gris.png" class="img-circle"
                             alt="Imagen de Usuario"/>
                    </a>
                <?php } ?>
            </ul>

            <ul class="nav navbar-nav" style="margin-top: 5px;">
                <select class="form-control" id="nav_cod_sede" name="nav_cod_sede">
                    <?php foreach ($list_nav_sede as $list_nav) { ?>
                        <option value="<?php echo $list_nav['cod_sede']; ?>" <?php if ($list_nav['cod_sede'] == "LL1") {
                            echo "selected";
                        } ?>>
                            <?php echo $list_nav['cod_sede']; ?>
                        </option>
                    <?php } ?>
                </select>
            </ul>

            <ul class="nav navbar-nav">
                <li id="cargar_nav" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-bubble-notification"></i>
                        <span class="visible-xs-inline-block position-right">Notificaciones</span>
                        <span class="badge bg-warning-400"><?php echo count($list_aviso); ?></span>
                    </a>

                    <div class="dropdown-menu dropdown-content width-350">
                        <div class="dropdown-content-heading">
                            Notificaciones
                        </div>

                        <ul class="media-list dropdown-content-body">
                            <?php foreach ($list_aviso as $list) { ?>
                                <li class="media">
                                    <div class="media-body">
                                        <a href="<?php if ($list['link'] != "") {
                                            echo $list['link'];
                                        } else {
                                            echo "#";
                                        } ?>">
                                            <span
                                                    style="color:black;font-weight:bold;"><?php echo $list['nom_accion']; ?></span>
                                            <span style="color:black;"><?php echo " - " . $list['mensaje']; ?></span>
                                        </a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                        <?php if (count($list_aviso) > 5) { ?>
                            <div class="dropdown-content-footer">
                                <a href="<?= site_url('LittleLeaders/Detalle_Aviso') ?>" data-popup="tooltip"
                                   title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                </li>

                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php if (isset($foto)) {
                            echo base_url() . $foto;
                        } else {
                            echo base_url() . "template/assets/images/placeholder.jpg";
                        } ?>" alt="">
                        <span><?php echo $sesion['usuario_nombres'] . " " . $sesion['usuario_apater'] ?></span>
                        <i class="caret"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a data-toggle="modal" data-target="#acceso_modal"
                               app_crear_per="<?= site_url('Snappy/Cambiar_clave') ?>"><i class="icon-key"></i>
                                Cambiar Clave</a></li>
                        <li><a data-toggle="modal" data-target="#acceso_modal"
                               app_crear_per="<?= site_url('Snappy/imagen') ?>"><i class="icon-image2"></i> Cambiar
                                Foto Perfil</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= site_url('login/logout') ?>"><i class="icon-switch2"></i> Salir</a></li>
                    </ul>
                </li>
            </ul>
        </ul>
    </div>
</div>

<div class="page-container">
    <div class="page-content">
        <div class="sidebar sidebar-main sidebar-fixed">
            <div class="sidebar-content" style="background-color:#2DB443">
                <div class="sidebar-category sidebar-category-visible">
                    <div class="category-content no-padding">
                        <ul class="navigation navigation-main navigation-accordion">
                            <?php
                            $busq_menu = in_array('alumnos_ll', array_column($menu, 'nom_grupomenu'));
                            $posicion = array_search('alumnos_ll', array_column($menu, 'nom_grupomenu'));

                            if ($busq_menu != false) { ?>
                                <li id="alumnos">
                                    <a href="#ralumnos" id="halumnos"><i class="icon-collaboration"
                                                                         style="font-size: 18px;"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
                                    <ul id="ralumnos">
                                        <?php
                                        $busq_modulo = in_array('alum_ll_lista', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('alum_ll_lista', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="matriculados"><a
                                                        href="<?= site_url('LittleLeaders/Matriculados') ?>"><i
                                                            class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?>
                                                </a>
                                            </li>
                                        <?php }

                                        $busq_modulo = in_array('alum_ll_mat_pend', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('alum_ll_mat_pend', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="matriculas_pendientes"><a
                                                        href="<?= site_url('LittleLeaders/Matricula_Pendiente') ?>"><i
                                                            class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?>
                                                </a>
                                            </li>
                                        <?php }
                                        ?>
                                    </ul>
                                </li>
                            <?php }

                            $busq_menu = in_array('informe_ll', array_column($menu, 'nom_grupomenu'));
                            $posicion = array_search('informe_ll', array_column($menu, 'nom_grupomenu')); ?>
                            <?php if ($busq_menu != false) { ?>
                                <li id="informe" class="menu">
                                    <a href="#rinforme" id="hinforme"><i
                                                class="icon-bars-alt"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
                                    <ul id="rinforme">
                                        <?php
                                        $busq_modulo = in_array('inf_ll_doc_alum', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('inf_ll_doc_alum', array_column($modulo, 'nom_menu'));

                                        if ($busq_modulo != false) { ?>
                                            <li id="doc_alumnos"><a
                                                        href="<?= site_url('LittleLeaders/Doc_Alumno') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="25"
                                                                height="25" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512">
                                                            <path fill="currentColor"
                                                                  d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }

                                        $busq_modulo = in_array('inf_ll_alum_obs', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('inf_ll_alum_obs', array_column($modulo, 'nom_menu'));

                                        if ($busq_modulo != false) { ?>
                                            <li id="alumnos_obs"><a
                                                        href="<?= site_url('LittleLeaders/Alumno_Obs') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="25"
                                                                height="25" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512">
                                                            <path fill="currentColor"
                                                                  d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }

                                        $busq_modulo = in_array('inf_lista_ll', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('inf_lista_ll', array_column($modulo, 'nom_menu'));

                                        if ($busq_modulo != false) { ?>
                                            <li id="listas"><a href="<?= site_url('LittleLeaders/Informe_Lista') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="25"
                                                                height="25" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512">
                                                            <path fill="currentColor"
                                                                  d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7c-12.23-91.55-87.28-166-178.9-177.6c-136.2-17.24-250.7 97.28-233.4 233.4c11.6 91.64 86.07 166.7 177.6 178.9c53.81 7.191 104.3-6.235 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 .0004C515.9 484.7 515.9 459.3 500.3 443.7zM273.7 253.8C269.8 276.4 252.6 291.3 228 296.1V304c0 11.03-8.953 20-20 20S188 315 188 304V295.2C178.2 293.2 168.4 289.9 159.6 286.8L154.8 285.1C144.4 281.4 138.9 269.9 142.6 259.5C146.2 249.1 157.6 243.7 168.1 247.3l5.062 1.812c8.562 3.094 18.25 6.562 25.91 7.719c16.23 2.5 33.47-.0313 35.17-9.812c1.219-7.094 .4062-10.62-31.8-19.84L196.2 225.4C177.8 219.1 134.5 207.3 142.3 162.2C146.2 139.6 163.5 124.8 188 120V112c0-11.03 8.953-20 20-20S228 100.1 228 112v8.695c6.252 1.273 13.06 3.07 21.47 5.992c10.42 3.625 15.95 15.03 12.33 25.47C258.2 162.6 246.8 168.1 236.3 164.5C228.2 161.7 221.8 159.9 216.8 159.2c-16.11-2.594-33.38 .0313-35.08 9.812c-1 5.812-1.719 10 25.7 18.03l6 1.719C238.9 196 281.5 208.2 273.7 253.8z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }

                                        $busq_modulo = in_array('inf_ll_retirados', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('inf_ll_retirados', array_column($modulo, 'nom_menu'));

                                        if ($busq_modulo != false) { ?>
                                            <li id="retirados"><a href="<?= site_url('LittleLeaders/Retirados') ?>"><i
                                                            class="icon-users4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?>
                                                </a>
                                            </li>
                                        <?php }
                                        ?>
                                    </ul>
                                </li>
                            <?php }

                            /*$busq_menu = in_array('profesor_ll', array_column($menu, 'nom_grupomenu'));
                            $posicion=array_search('profesor_ll',array_column($menu,'nom_grupomenu')); ?>

                            <?php if($busq_menu != false){  ?>
                            <li id="profesor" class="menu">
                                <a href="#rprofesor" id="hprofesor"><i
                                        class="icon-user-plus"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
                                <ul id="rprofesor">
                                    <?php
                                        $busq_modulo = in_array('pro_ll_lista', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('pro_ll_lista',array_column($modulo,'nom_menu'));

                                        if($busq_modulo != false){?>
                                    <li id="listas_profesor"><a href="<?= site_url('LittleLeaders/Profesor') ?>"><i
                                                class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
                                    </li>
                                    <?php }
                                        ?>
                                </ul>
                            </li>
                            <?php } */

                            $busq_menu = in_array('colaboradores_ll', array_column($menu, 'nom_grupomenu'));
                            $posicion = array_search('colaboradores_ll', array_column($menu, 'nom_grupomenu')); ?>
                            <?php if ($busq_menu != false) { ?>
                                <li id="colaboradores">
                                    <a href="#rcolaboradores" id="hcolaboradores"><i class="icon-user-plus"
                                                                                     style="font-size: 19px;"></i>
                                        <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
                                    <ul id="rcolaboradores">
                                        <?php
                                        $busq_modulo = in_array('col_ll_lista', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('col_ll_lista', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <!--<li id="colaboradores_lista"><a href="<?= site_url('LittleLeaders/Colaborador') ?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>-->
                                            <li id="colaboradores_lista"><a
                                                        href="<?= site_url('Colaborador/Colaborador') ?>/<?php echo $id_sede; ?>"><i
                                                            class="glyphicon glyphicon-list"
                                                            style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?>
                                                </a>
                                            </li>
                                        <?php }
                                        $busq_modulo = in_array('asistencia_colaboradores', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('asistencia_colaboradores', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="asistencias_colaboradores"><a
                                                        href="<?= site_url('LittleLeaders/Asistencia_Colaborador')?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                style="margin: 0 auto;"
                                                                aria-hidden="true" width="20" height="25"
                                                                focusable="false"
                                                                data-prefix="fas" data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20" role="img"
                                                                viewBox="0 0 640 512">
                                                            <path fill="currentColor"
                                                                  d="M128 96h384v256h64v-272c0-26.38-21.62-48-48-48h-416c-26.38 0-48 21.62-48 48V352h64V96zM624 383.1h-608c-8.75 0-16 7.25-16 16v16c0 35.25 28.75 64 64 64h512c35.25 0 64-28.75 64-64v-16C640 391.2 632.8 383.1 624 383.1z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }
                                        /*$busq_modulo = in_array('conf_ll_documento_colab', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('conf_ll_documento_colab',array_column($modulo,'nom_menu'));
                                        if($busq_modulo != false){?>
                                        <li id="documentos_colaborador"><a href="<?= site_url('Colaborador/Documento_Colaborador')?>/<?php echo $id_sede; ?>"><i><svg
                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23"
                                                    height="25" focusable="false" data-prefix="fas"
                                                    data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20"
                                                    role="img" viewBox="0 0 640 512">
                                                    <path fill="currentColor"
                                                        d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z" />
                                                </svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }*/
                                        $busq_modulo = in_array('conf_ll_cargo_fotocheck', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('conf_ll_cargo_fotocheck',array_column($modulo,'nom_menu')); 
                                        if($busq_modulo != false){ ?> 
                                            <li id="cargos_fotocheck">
                                                <a href="<?= site_url('Colaborador/Cargo_Fotocheck')?>/<?php echo $id_sede; ?>">
                                                <?php echo $modulo[$posicion]['nom_subgrupo'];?>
                                                <i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" 
                                                    data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512">
                                                    <path fill="currentColor" d="M128 96h384v256h64v-272c0-26.38-21.62-48-48-48h-416c-26.38 0-48 21.62-48 48V352h64V96zM624 383.1h-608c-8.75 0-16 7.25-16
                                                    16v16c0 35.25 28.75 64 64 64h512c35.25 0 64-28.75 64-64v-16C640 391.2 632.8 383.1 624 383.1z"/></svg></i>
                                                </a>
                                            </li>
                                        <?php }

                                        $busq_modulo = in_array('col_ll_fotocheck', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('col_ll_fotocheck', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) {
                                            ?>
                                            <li id="fotocheck_colaboradores"><a
                                                        href="<?= site_url('Colaborador/Fotocheck_Colaborador') ?>/<?php echo $id_sede; ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="23"
                                                                height="23" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512"
                                                                style="margin:0px auto;">
                                                            <path fill="currentColor"
                                                                  d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z">
                                                            </path>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }
                                        $busq_modulo = in_array('informe_colabor_ll', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('informe_colabor_ll', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="informe_colaborador">
                                                <a href="#rinforme_colaborador" id="hinforme_colaborador"><i
                                                            class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?>
                                                </a>
                                                <ul id="rinforme_colaborador">
                                                    <?php
                                                    $busq_submodulo = in_array('lista_obs_colaborado', array_column($submodulo, 'nom_submenu'));
                                                    $posicion = array_search('lista_obs_colaborado', array_column($submodulo, 'nom_submenu'));
                                                    if ($busq_submodulo != false) { ?>
                                                        <li id="c_lista_obs"><a
                                                                    href="<?= site_url('LittleLeaders/Colaborador_Obs') ?>"><i>
                                                                    <svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            aria-hidden="true"
                                                                            width="25" height="25" focusable="false"
                                                                            data-prefix="fas" data-icon="sitemap"
                                                                            class="svg-inline--fa fa-sitemap fa-w-20"
                                                                            role="img"
                                                                            viewBox="0 0 640 512">
                                                                        <path fill="currentColor"
                                                                              d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/>
                                                                    </svg>
                                                                </i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?>
                                                            </a>
                                                        </li>
                                                    <?php }
                                                    ?>
                                                </ul>
                                            </li>
                                        <?php }
                                        ?>
                                    </ul>
                                </li>
                            <?php }


                            $busq_menu = in_array('soporte_ll_docs', array_column($menu, 'nom_grupomenu'));
                            $posicion = array_search('soporte_ll_docs', array_column($menu, 'nom_grupomenu')); ?>
                            <?php if ($busq_menu != false) { ?>
                                <li id="soporte_docs">
                                    <a href="#rsoporte_docs" id="hsoporte_docs"><i>
                                            <svg
                                                    xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;"
                                                    aria-hidden="true" width="20" height="25" focusable="false"
                                                    data-prefix="fas" data-icon="sitemap"
                                                    class="svg-inline--fa fa-sitemap fa-w-20" role="img"
                                                    viewBox="0 0 640 512">
                                                <path fill="currentColor"
                                                      d="M192 0H48C21.5 0 0 21.5 0 48V368c0 26.5 21.5 48 48 48H162.7c6.6-18.6 24.4-32 45.3-32V272c0-44.2 35.8-80 80-80h32V128H224c-17.7 0-32-14.3-32-32V0zm96 224c-26.5 0-48 21.5-48 48v16 96 32H208c-8.8 0-16 7.2-16 16v16c0 35.3 28.7 64 64 64H576c35.3 0 64-28.7 64-64V432c0-8.8-7.2-16-16-16H592V288c0-35.3-28.7-64-64-64H320 304 288zm32 64H528V416H304V288h16zM224 0V96h96L224 0z"/>
                                            </svg>
                                        </i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
                                    <ul id="rsoporte_docs">
                                        <?php
                                        $busq_modulo = in_array('sop_ll_lista', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('sop_ll_lista', array_column($modulo, 'nom_menu'));

                                        if ($busq_modulo != false) { ?>
                                            <li id="soporte_docs_listas"><a
                                                        href="<?= site_url('LittleLeaders/Soporte_Doc') ?>"><i
                                                            class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?>
                                                </a>
                                            </li>
                                        <?php }
                                        ?>
                                    </ul>
                                </li>
                            <?php }

                            $busq_menu = in_array('tramites_ll', array_column($menu, 'nom_grupomenu'));
                            $posicion = array_search('tramites_ll', array_column($menu, 'nom_grupomenu')); ?>
                            <?php if ($busq_menu != false) { ?>
                                <li id="tramites">
                                    <a href="#rtramites" id="htramites"><i>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 aria-hidden="true" width="23" height="23" focusable="false"
                                                 data-prefix="fas" data-icon="sitemap"
                                                 class="svg-inline--fa fa-sitemap fa-w-20" role="img"
                                                 viewBox="0 0 640 512" style="margin:0px auto;">
                                                <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path fill="currentColor"
                                                      d="M121 32C91.6 32 66 52 58.9 80.5L1.9 308.4C.6 313.5 0 318.7 0 323.9V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V323.9c0-5.2-.6-10.4-1.9-15.5l-57-227.9C446 52 420.4 32 391 32H121zm0 64H391l48 192H387.8c-12.1 0-23.2 6.8-28.6 17.7l-14.3 28.6c-5.4 10.8-16.5 17.7-28.6 17.7H195.8c-12.1 0-23.2-6.8-28.6-17.7l-14.3-28.6c-5.4-10.8-16.5-17.7-28.6-17.7H73L121 96z"/>
                                            </svg>
                                        </i>
                                        <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
                                    <ul id="rtramites">
                                        <?php
                                        $busq_modulo = in_array('tra_ll_contratos', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('tra_ll_contratos', array_column($modulo, 'nom_menu'));

                                        if ($busq_modulo != false) { ?>
                                            <li id="contratos"><a href="<?= site_url('LittleLeaders/Contrato') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="23"
                                                                height="23" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512"
                                                                style="margin:0px auto;">
                                                            <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path fill="currentColor"
                                                                  d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }
                                        ?>
                                    </ul>
                                </li>
                            <?php }


                            $busq_menu = in_array('configuracion_ll', array_column($menu, 'nom_grupomenu'));
                            $posicion = array_search('configuracion_ll', array_column($menu, 'nom_grupomenu')); ?>

                            <?php if ($busq_menu != false) { ?>
                                <li id="configuracion" class="menu">
                                    <a href="#rconfiguracion" id="hconfiguracion"><i
                                                class="icon-cog6"></i></i>
                                        <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
                                    <ul id="rconfiguracion">
                                        <?php
                                        $busq_modulo = in_array('conf_ll_documento', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('conf_ll_documento', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="documentos"><a href="<?= site_url('LittleLeaders/Documento') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="22"
                                                                height="25" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512">
                                                            <path fill="currentColor"
                                                                  d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }

                                        $busq_modulo = in_array('conf_ll_contratos', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('conf_ll_contratos', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="c_contratos"><a
                                                        href="<?= site_url('LittleLeaders/C_Contrato') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="23"
                                                                height="23" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512"
                                                                style="margin:0px auto;">
                                                            <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path fill="currentColor"
                                                                  d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }

                                        $busq_modulo = in_array('conf_ll_bimestres', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('conf_ll_bimestres', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="c_bimestres"><a
                                                        href="<?= site_url('LittleLeaders/C_Bimestres') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="23"
                                                                height="23" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512"
                                                                style="margin:0px auto;">
                                                            <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                            <path fill="currentColor"
                                                                  d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }

                                        $busq_modulo = in_array('conf_ll_mailing', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('conf_ll_mailing', array_column($modulo, 'nom_menu'));

                                        if ($busq_modulo != false) { ?>
                                            <li id="mailings"><a href="<?= site_url('LittleLeaders/Mailing') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="23"
                                                                height="25" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512">
                                                            <path fill="currentColor"
                                                                  d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }

                                        $busq_modulo = in_array('conf_bl_salon', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('conf_bl_salon', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="salones"><a href="<?= site_url('LittleLeaders/Salon') ?>"><i>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                                                width="25"
                                                                height="25" focusable="false" data-prefix="fas"
                                                                data-icon="sitemap"
                                                                class="svg-inline--fa fa-sitemap fa-w-20"
                                                                role="img" viewBox="0 0 640 512">
                                                            <path fill="currentColor"
                                                                  d="M88 104C88 95.16 95.16 88 104 88H152C160.8 88 168 95.16 168 104V152C168 160.8 160.8 168 152 168H104C95.16 168 88 160.8 88 152V104zM280 88C288.8 88 296 95.16 296 104V152C296 160.8 288.8 168 280 168H232C223.2 168 216 160.8 216 152V104C216 95.16 223.2 88 232 88H280zM88 232C88 223.2 95.16 216 104 216H152C160.8 216 168 223.2 168 232V280C168 288.8 160.8 296 152 296H104C95.16 296 88 288.8 88 280V232zM280 216C288.8 216 296 223.2 296 232V280C296 288.8 288.8 296 280 296H232C223.2 296 216 288.8 216 280V232C216 223.2 223.2 216 232 216H280zM0 64C0 28.65 28.65 0 64 0H320C355.3 0 384 28.65 384 64V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V64zM48 64V448C48 456.8 55.16 464 64 464H144V400C144 373.5 165.5 352 192 352C218.5 352 240 373.5 240 400V464H320C328.8 464 336 456.8 336 448V64C336 55.16 328.8 48 320 48H64C55.16 48 48 55.16 48 64z"/>
                                                        </svg>
                                                    </i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                        <?php }

                                        $busq_modulo = in_array('conf_ll_calendario', array_column($modulo, 'nom_menu'));
                                        $posicion = array_search('conf_ll_calendario', array_column($modulo, 'nom_menu'));
                                        if ($busq_modulo != false) { ?>
                                            <li id="c_calendarios"><a
                                                        href="<?= site_url('LittleLeaders/Calendario') ?>"><i
                                                            class="icon-calendar2"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?>
                                                    <!--<label id="contadornulosst" for=""> <?php //echo count($cantidadnulos)
                                                    ?> </label>--></span>
                                                </a></li>
                                        <?php }
                                        ?>
                                    </ul>
                                </li>
                            <?php }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-15">