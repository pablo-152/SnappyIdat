<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$foto = $_SESSION['foto'];
?>

<body class="sidebar-xs">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse" style="background-color:#04044c;"> 
		<div class="navbar-header">
			<a class="navbar-brand" href="<?= site_url('Ceba') ?>"><img src="<?= base_url() ?>template/img/logo2.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

			</ul>
			<p class="navbar-text"><span class="label bg-success">Online</span></p>

			<ul class="nav navbar-nav navbar-right">
				<ul class="nav navbar-nav">
					<?php $busq_menu = in_array('1', array_column($menu, 'id_modulo_mae')); 
					if ($busq_menu != false) { ?>
						<a class="dropdown" href="<?= site_url('General') ?>">
							<img src="<?= base_url() ?>template/img/estrella_gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_empresa = in_array('1', array_column($list_empresa, 'id_empresa'));
					if ($busq_empresa != false) {  ?>
						<a class="dropdown" href="<?= site_url('Snappy') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogogllg-b.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_empresa = in_array('3', array_column($list_empresa, 'id_empresa'));
					if($busq_empresa != false){ ?>
						<a class="dropdown" href="<?= site_url('BabyLeaders') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogobl-gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_empresa = in_array('2', array_column($list_empresa, 'id_empresa'));
					if($busq_empresa != false){ ?>
						<a class="dropdown" href="<?= site_url('LittleLeaders') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogoll-gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_empresa = in_array('4', array_column($list_empresa, 'id_empresa'));
					if($busq_empresa != false){ ?>
						<a class="dropdown" href="<?= site_url('LeadershipSchool') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogols-gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_empresa = in_array('5', array_column($list_empresa, 'id_empresa'));
					if ($busq_empresa != false) {  ?>
						<a class="dropdown" href="<?= site_url('Ceba2') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogo05.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_empresa = in_array('6', array_column($list_empresa, 'id_empresa'));
					if ($busq_empresa != false) {  ?>
						<a class="dropdown" href="<?= site_url('AppIFV') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogoifv-gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>
					
					<?php $busq_empresa = in_array('7', array_column($list_empresa, 'id_empresa'));
					if($busq_empresa != false){ ?>
						<?php if($_SESSION['usuario'][0]['cod_sede_la']=="No"){ ?>
							<a class="dropdown" onclick="Error_Laleli();">
								<img src="<?= base_url() ?>template/img/intranetlogola-gris.png" class="img-circle" alt="Imagen de Usuario" />
							</a>
						<?php }else{ ?>
							<?php if($_SESSION['usuario'][0]['cod_sede_la']>0){ ?>
								<a class="dropdown" href="<?= site_url('Laleli'.$_SESSION['usuario'][0]['cod_sede_la']) ?>">
									<img src="<?= base_url() ?>template/img/intranetlogola-gris.png" class="img-circle" alt="Imagen de Usuario" />
								</a>
							<?php }else{ ?>
								<a class="dropdown" href="<?= site_url('Laleli') ?>">
									<img src="<?= base_url() ?>template/img/intranetlogola-gris.png" class="img-circle" alt="Imagen de Usuario" />
								</a>
							<?php } ?>
						<?php } ?>
					<?php } ?>

					<?php $busq_menu = in_array('6', array_column($menu, 'id_modulo_mae'));  
					if ($busq_menu != false) { ?>
						<a class="dropdown" href="<?= site_url('Ca') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogoca-gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>
					
					<?php $busq_menu = in_array('15', array_column($menu, 'id_modulo_mae'));
					if ($busq_menu != false) { ?>
						<a class="dropdown" href="<?= site_url('CursosCortos') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogocc-gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>
				</ul>

				<ul class="nav navbar-nav" style="margin-top: 5px;">
					<select class="form-control" id="nav_cod_sede" name="nav_cod_sede" onchange="Cambiar_Nav_Sede();"> 
						<?php foreach($list_nav_sede as $list_nav){ ?>
							<option value="<?php echo $list_nav['cod_sede']; ?>" <?php if($list_nav['cod_sede']=="EP2"){ echo "selected"; } ?>>
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
								<?php foreach($list_aviso as $list){ ?>
									<li class="media">
										<div class="media-body">
											<a href="<?php if($list['link']!=""){ echo $list['link']; }else{ echo "#"; } ?>">
												<span style="color:black;font-weight:bold;"><?php echo $list['nom_accion']; ?></span>
												<span style="color:black;"><?php echo " - ".$list['mensaje']; ?></span>
											</a>
										</div>
									</li>
								<?php } ?>
							</ul>

							<?php if(count($list_aviso)>5){ ?>
								<div class="dropdown-content-footer">
									<a href="<?= site_url('Ceba/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
								</div>
							<?php } ?>
						</div>
					</li>

					<li class="dropdown dropdown-user">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?php if(isset($foto)) {echo base_url().$foto; }else{echo  base_url()."template/assets/images/placeholder.jpg"; } ?>"  alt="">
							<span><?php echo $sesion['usuario_nombres'] . " " . $sesion['usuario_apater'] ?></span>
							<i class="caret"></i>
						</a>

						<ul class="dropdown-menu dropdown-menu-right">
							<li><a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Snappy/Cambiar_clave') ?>"><i class="icon-key"></i> Cambiar Clave</a></li>
							<li><a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('Snappy/imagen') ?>"><i class="icon-image2"></i> Cambiar Foto Perfil</a></li>

							<!--<li><a href="#"><i class="icon-coins"></i> My balance</a></li>-->
							<!--<li><a href="#"><span class="badge bg-blue pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>-->
							<li class="divider"></li>
							<!--<li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>-->
							<li><a href="<?= site_url('login/logout') ?>"><i class="icon-switch2"></i> Salir</a></li>
						</ul>
					</li>
				</ul>
			</ul>
		</div>
	</div>

	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main sidebar-fixed">
				<div class="sidebar-content" style="background-color:#04042c;">

					<!-- User menu -->
					<!--<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><img src="<?= base_url() ?>template/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
								<div class="media-body">
									<span class="media-heading text-semibold">Victoria Baker</span>
									<div class="text-size-mini text-muted">
										<i class="icon-pin text-size-small"></i> &nbsp;Santa Ana, CA
									</div>
								</div>

								<div class="media-right media-middle">
									<ul class="icons-list">
										<li>
											<a href="#"><i class="icon-cog3"></i></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>-->
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">


								<?php $busq_menu = in_array('alumnos', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('alumnos', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="alumno">
										<a href="#ralumno" id="halumno">

											<i class="icon-collaboration">
												<!--<svg aria-hidden="true" focusable="false" width="17" height="17" data-prefix="fas" data-icon="users-class" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-users-class fa-w-20 fa-7x"><path fill="currentColor" d="M256 288c0 35.35 28.66 64 64 64 35.35 0 64-28.65 64-64s-28.65-64-64-64c-35.34 0-64 28.65-64 64zm224 0c0 35.35 28.66 64 64 64 35.35 0 64-28.65 64-64s-28.65-64-64-64c-35.34 0-64 28.65-64 64zM96 352c35.35 0 64-28.65 64-64s-28.65-64-64-64c-35.34 0-64 28.65-64 64s28.66 64 64 64zm480 32h-64c-35.34 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h128c17.67 0 32-14.33 32-32v-32c0-35.35-28.66-64-64-64zm-224 0h-64c-35.34 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h128c17.67 0 32-14.33 32-32v-32c0-35.35-28.66-64-64-64zm-224 0H64c-35.34 0-64 28.65-64 64v32c0 17.67 14.33 32 32 32h128c17.67 0 32-14.33 32-32v-32c0-35.35-28.66-64-64-64zM96 64h448v128c24.68 0 46.98 9.62 64 24.97V49.59C608 22.25 586.47 0 560 0H80C53.53 0 32 22.25 32 49.59v167.38C49.02 201.62 71.33 192 96 192V64z" class=""></path></svg>-->
											</i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="ralumno">
											<?php
											$busq_modulo = in_array('lista_alumnos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('lista_alumnos', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="lalumno"><a href="<?= site_url('Ceba/Alumno') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('cliente_ep2', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('cliente_ep2',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="clientes">
										<a href="#rclientes" id="hclientes"><i class="glyphicon glyphicon-list"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rclientes">
											<?php 
											$busq_modulo = in_array('cli_ep2_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cli_ep2_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="listas_clientes"><a href="<?= site_url('Ceba/Cliente')?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('academico', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('academico', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="academico">
										<a href="#rcurso" id="hcurso"><i class="icon-graduation"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcurso">
											<?php
											$busq_modulo = in_array('curso', array_column($modulo, 'nom_menu'));
											$posicion = array_search('curso', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="curso"><a href="<?= site_url('Ceba/Curso') ?>"><i class="icon-book2"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('temas', array_column($modulo, 'nom_menu'));
											$posicion = array_search('temas', array_column($modulo, 'nom_menu'));

											if($busq_modulo != false){?>
												<li id="tema"><a href="<?= site_url('Ceba/Temas') ?>"><i class="icon-portfolio"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											?>
											<!--<li><a href="datatable_extension_colvis.html">Columns visibility</a></li>-->
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('informe_ep2', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('informe_ep2', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="informes"> 
										<a href="#rinformes" id="hinformes"><i class="icon-bars-alt" style="font-size: 18px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rinformes">
											<?php
											$busq_modulo = in_array('inf_ep2_doc_alum', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_ep2_doc_alum', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="doc_alumnos"><a href="<?= site_url('Ceba/Doc_Alumno') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											$busq_modulo = in_array('inf_ep2_alum_obs', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_ep2_alum_obs',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="alumnos_obs"><a href="<?= site_url('Ceba/Alumno_Obs') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('configuracion_ceba', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('configuracion_ceba', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="configuracion">
										<a href="#rconfiguracion" id="hconfiguracion"><i class="icon-cog6"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rconfiguracion">
											<?php
											$busq_modulo = in_array('grado', array_column($modulo, 'nom_menu'));
											$posicion = array_search('grado', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="grados"><a href="<?= site_url('Ceba/Grado') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="17" height="17" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512">
																<path fill="currentColor" d="M208 352c-2.39 0-4.78.35-7.06 1.09C187.98 357.3 174.35 360 160 360c-14.35 0-27.98-2.7-40.95-6.91-2.28-.74-4.66-1.09-7.05-1.09C49.94 352-.33 402.48 0 464.62.14 490.88 21.73 512 48 512h224c26.27 0 47.86-21.12 48-47.38.33-62.14-49.94-112.62-112-112.62zm-48-32c53.02 0 96-42.98 96-96s-42.98-96-96-96-96 42.98-96 96 42.98 96 96 96zM592 0H208c-26.47 0-48 22.25-48 49.59V96c23.42 0 45.1 6.78 64 17.8V64h352v288h-64v-64H384v64h-76.24c19.1 16.69 33.12 38.73 39.69 64H592c26.47 0 48-22.25 48-49.59V49.59C640 22.25 618.47 0 592 0z"></path>
															</svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('area', array_column($modulo, 'nom_menu'));
											$posicion = array_search('area', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="areas"><a href="<?= site_url('Ceba/Area') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="17" height="17" focusable="false" data-prefix="fas" data-icon="layer-group" class="svg-inline--fa fa-layer-group fa-w-16" role="img" viewBox="0 0 512 512">
																<path fill="currentColor" d="M12.41 148.02l232.94 105.67c6.8 3.09 14.49 3.09 21.29 0l232.94-105.67c16.55-7.51 16.55-32.52 0-40.03L266.65 2.31a25.607 25.607 0 0 0-21.29 0L12.41 107.98c-16.55 7.51-16.55 32.53 0 40.04zm487.18 88.28l-58.09-26.33-161.64 73.27c-7.56 3.43-15.59 5.17-23.86 5.17s-16.29-1.74-23.86-5.17L70.51 209.97l-58.1 26.33c-16.55 7.5-16.55 32.5 0 40l232.94 105.59c6.8 3.08 14.49 3.08 21.29 0L499.59 276.3c16.55-7.5 16.55-32.5 0-40zm0 127.8l-57.87-26.23-161.86 73.37c-7.56 3.43-15.59 5.17-23.86 5.17s-16.29-1.74-23.86-5.17L70.29 337.87 12.41 364.1c-16.55 7.5-16.55 32.5 0 40l232.94 105.59c6.8 3.08 14.49 3.08 21.29 0L499.59 404.1c16.55-7.5 16.55-32.5 0-40z"></path>
															</svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('asignatura', array_column($modulo, 'nom_menu'));
											$posicion = array_search('asignatura', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="asignaturas"><a href="<?= site_url('Ceba/Asignatura') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="17" height="17" focusable="false" data-prefix="fas" data-icon="file-signature" class="svg-inline--fa fa-file-signature fa-w-18" role="img" viewBox="0 0 576 512">
																<path fill="currentColor" d="M218.17 424.14c-2.95-5.92-8.09-6.52-10.17-6.52s-7.22.59-10.02 6.19l-7.67 15.34c-6.37 12.78-25.03 11.37-29.48-2.09L144 386.59l-10.61 31.88c-5.89 17.66-22.38 29.53-41 29.53H80c-8.84 0-16-7.16-16-16s7.16-16 16-16h12.39c4.83 0 9.11-3.08 10.64-7.66l18.19-54.64c3.3-9.81 12.44-16.41 22.78-16.41s19.48 6.59 22.77 16.41l13.88 41.64c19.75-16.19 54.06-9.7 66 14.16 1.89 3.78 5.49 5.95 9.36 6.26v-82.12l128-127.09V160H248c-13.2 0-24-10.8-24-24V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24v-40l-128-.11c-16.12-.31-30.58-9.28-37.83-23.75zM384 121.9c0-6.3-2.5-12.4-7-16.9L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1zm-96 225.06V416h68.99l161.68-162.78-67.88-67.88L288 346.96zm280.54-179.63l-31.87-31.87c-9.94-9.94-26.07-9.94-36.01 0l-27.25 27.25 67.88 67.88 27.25-27.25c9.95-9.94 9.95-26.07 0-36.01z"></path>
															</svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('instrucciones', array_column($modulo, 'nom_menu'));
											$posicion = array_search('instrucciones', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="instrucciones"><a href="<?= site_url('Ceba/Instruccion') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="17" height="17" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
																<g>
																	<path xmlns="http://www.w3.org/2000/svg" d="m316 300v-30h90v-120h-90v-30h80l80-60-80-60h-290v120h120v30h-110l-80 60 80 60h110v30h-120v120h120v92h90v-92h80l80-60-80-60zm-180-270h250l40 30-40 30h-250zm120 90h30v30h-30zm-170 90 40-30h250v60h-250zm170 60h30v30h-30zm30 212h-30v-62h30zm100-92h-250v-60h250l40 30z" fill="#ffffff" data-original="#000000"></path>
																</g>
															</svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
															
											$busq_modulo = in_array('conf_ep2_documento', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_ep2_documento',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="documentos"><a href="<?= site_url('Ceba/Documento') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('registro_ep2', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('registro_ep2',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="registros">
										<a href="#rregistros" id="hregistros"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="22" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M50.73 58.53C58.86 42.27 75.48 32 93.67 32H208V160H0L50.73 58.53zM240 160V32H354.3C372.5 32 389.1 42.27 397.3 58.53L448 160H240zM448 416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V192H448V416z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rregistros">
											<?php 
											$busq_modulo = in_array('reg_list_ep2', array_column($modulo, 'nom_menu'));
											$posicion = array_search('reg_list_ep2',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="listas_registros"><a href="<?= site_url('Ceba/Registro')?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('soporte_ep2_docs', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('soporte_ep2_docs',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="soporte_docs">
										<a href="#rsoporte_docs" id="hsoporte_docs"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M192 0H48C21.5 0 0 21.5 0 48V368c0 26.5 21.5 48 48 48H162.7c6.6-18.6 24.4-32 45.3-32V272c0-44.2 35.8-80 80-80h32V128H224c-17.7 0-32-14.3-32-32V0zm96 224c-26.5 0-48 21.5-48 48v16 96 32H208c-8.8 0-16 7.2-16 16v16c0 35.3 28.7 64 64 64H576c35.3 0 64-28.7 64-64V432c0-8.8-7.2-16-16-16H592V288c0-35.3-28.7-64-64-64H320 304 288zm32 64H528V416H304V288h16zM224 0V96h96L224 0z"/></svg></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rsoporte_docs">
											<?php 
											$busq_modulo = in_array('sop_ep2_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('sop_ep2_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="soporte_docs_listas"><a href="<?= site_url('Ceba/Soporte_Doc') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }
								?>
							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>

			<div class="content-wrapper">



				<div class="content">

					<div class="row">
						<div class="col-lg-15">