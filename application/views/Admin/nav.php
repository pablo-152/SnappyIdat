<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$id_usuario = $sesion['id_usuario'];
$foto = $_SESSION['foto'];
$id_sede= '1';
?>
<style>
	.new-icon {
		width: 17px!important;
		height: 18px!important;
		margin-left: -7px;
		margin-right: 16px;
	}

	.new-icon2 {
		height: 18px!important;
		margin-left: 0px;
		margin-right: 0px;
	}

	.new-icon3 {
		width: 8px!important;
		height: 15px!important;
		margin-left: -8px;
		margin-right: 16px;
	}

	.x1 {
		font-size: 17px;
		margin-left: -7px;
	}

</style>
<body class="sidebar-xs">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse" style="background-color:#6b586e">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?= site_url('Snappy') ?>"><img src="<?= base_url() ?>template/img/logo2.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

			</ul>

			<p class="navbar-text">
				<span class="label bg-success">Online</span>
			</p>

			<div class="navbar-right">

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
							<img src="<?= base_url() ?>template/img/intranetlogogllg.png" class="img-circle" alt="Imagen de Usuario" />
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
							<img src="<?= base_url() ?>template/img/intranetlogo05-b.png" class="img-circle" alt="Imagen de Usuario" />
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
					<select class="form-control" id="nav_cod_sede" name="nav_cod_sede">
						<?php foreach($list_nav_sede as $list_nav){ ?>
							<option value="<?php echo $list_nav['cod_sede']; ?>" <?php if($list_nav['cod_sede']=="GL0"){ echo "selected"; } ?>>
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
									<a href="<?= site_url('Snappy/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
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
							<!--<li><a href="<?= site_url('Snappy/imagen') ?>"><i class="icon-user-plus"></i> Cambiar Imagen</a></li>-->
							
            </li>
							<!--<li><a href="#"><i class="icon-coins"></i> My balance</a></li>-->
							<!--<li><a href="#"><span class="badge bg-blue pull-right">58</span> <i class="icon-comment-discussion"></i> Messages</a></li>-->
							<li class="divider"></li>
							<!--<li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>-->
							<li><a href="<?= site_url('login/logout') ?>"><i class="icon-switch2"></i> Salir</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main sidebar-fixed" style="background-color:#5a495b">
				<div class="sidebar-content" style="background-color:#5a495b">

					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">
							<?php 
								$busq_menu = in_array('base_datos', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('base_datos', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="base_dato">
										<a href="#rbase_dato" id="hbase_dato"><i class="icon-database"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rbase_dato">
											<?php
											$busq_modulo = in_array('base_datos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('base_datos', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<!--<li id="basedatos"><a href="<?= site_url('Administrador/Base_Datos') ?>"><i class="icon-database"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>-->
											<?php }
											
											$busq_modulo = in_array('base_datos_alumnos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('base_datos_alumnos', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="base_datos_alumnos"><a href="<?= site_url('Administrador/BD_Alumnos') ?>"><i class="icon-collaboration" style="font-size:18px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('informe_bd', array_column($modulo, 'nom_menu'));
											$posicion = array_search('informe_bd', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="informe_bd"><a href="<?= site_url('Administrador/Informe') ?>"><i class="icon-bars-alt"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('cargo', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('cargo', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="cargo">
										<a href="#rcargo" id="hcargo"><i class="glyphicon glyphicon-briefcase"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcargo">
											<?php
											$busq_modulo = in_array('lista_cargo', array_column($modulo, 'nom_menu'));
											$posicion = array_search('lista_cargo', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="slista">
													<a href="<?= site_url('Snappy/Cargo') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>

													<!--<a href="#rlista" id="hlista"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rlista">
														<?php
														$busq_submodulo = in_array('nuevo_cargo', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('nuevo_cargo', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="nuevocargo"><a href="<?= site_url('Snappy/Cargo') ?>"><i class="glyphicon glyphicon-plus"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>-->
												</li>
											<?php } ?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('comercial', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('comercial', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="comercial">
										<a href="#rcomercial" id="hcomercial"><i class="icon-cart"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcomercial">
											<?php
											$busq_modulo = in_array('registro_comercial', array_column($modulo, 'nom_menu'));
											$posicion = array_search('registro_comercial', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="registro"><a href="<?= site_url('Administrador/Registro') ?>">
													<i><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="19" height="19" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
															<g>
																<path xmlns="http://www.w3.org/2000/svg" d="m12.25 2h-1.1c-.33-1.15-1.39-2-2.65-2s-2.32.85-2.65 2h-1.1c-.41 0-.75.34-.75.75v1.5c0 .96.79 1.75 1.75 1.75h5.5c.96 0 1.75-.79 1.75-1.75v-1.5c0-.41-.34-.75-.75-.75z" fill="#ffffff" data-original="#000000"/>
																<path xmlns="http://www.w3.org/2000/svg" d="m14.25 3h-.25v1.25c0 1.52-1.23 2.75-2.75 2.75h-5.5c-1.52 0-2.75-1.23-2.75-2.75v-1.25h-.25c-1.52 0-2.75 1.23-2.75 2.75v12.5c0 1.52 1.23 2.75 2.75 2.75h7.38l.22-1.23c.1-.56.36-1.06.76-1.47l.8-.8h-8.16c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h9.5c.05 0 .09 0 .14.02h.01l3.6-3.6v-6.67c0-1.52-1.23-2.75-2.75-2.75zm-1 11.25h-9.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h9.5c.41 0 .75.34.75.75s-.34.75-.75.75zm0-3.25h-9.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h9.5c.41 0 .75.34.75.75s-.34.75-.75.75z" fill="#ffffff" data-original="#000000"/>
																<path xmlns="http://www.w3.org/2000/svg" d="m12.527 24c-.197 0-.389-.078-.53-.22-.173-.173-.251-.419-.208-.661l.53-3.005c.026-.151.1-.291.208-.4l7.425-7.424c.912-.914 1.808-.667 2.298-.177l1.237 1.237c.683.682.683 1.792 0 2.475l-7.425 7.425c-.108.109-.248.182-.4.208l-3.005.53c-.043.008-.087.012-.13.012zm3.005-1.28h.01z" fill="#ffffff" data-original="#000000"/>
															</g>
														</svg></i>
													<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
												</li>
											<?php }

											$busq_modulo = in_array('informe_comercial', array_column($modulo, 'nom_menu'));
											$posicion = array_search('informe_comercial', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="mailings"><a href="<?= site_url('Administrador/Mailing') ?>">
													<i class="icon-mail5" style="font-size: 18px;"></i>
													<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
												</li>
											<?php }

											$busq_modulo = in_array('nuevo_sms', array_column($modulo, 'nom_menu'));
											$posicion = array_search('nuevo_sms', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="smensaje_sms">
													<a href="#rmensaje_sms" id="hmensaje_sms"><i class="icon-comments"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rmensaje_sms">
														<?php
														$busq_submodulo = in_array('lista_sms', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('lista_sms', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="lista_mensajes"><a href="<?= site_url('Administrador/Mensaje') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														
														$busq_submodulo = in_array('bd_sms', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('bd_sms', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="bd_mensajes"><a href="<?= site_url('Administrador/Base_Datos') ?>"><i class="icon-database"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('compras_sms', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('compras_sms', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="compra_mensajes"><a href="<?= site_url('Administrador/Compra_Mensaje') ?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php } 
														?>
													</ul>
												</li>
											<?php }

											$busq_modulo = in_array('dcom_recomendados', array_column($modulo, 'nom_menu'));
											$posicion = array_search('dcom_recomendados', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="recomendados"><a href="<?= site_url('Administrador/Recomendados') ?>">
												<i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="22" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M187.7 153.7c-34 0-61.7 25.7-61.7 57.7 0 31.7 27.7 57.7 61.7 57.7s61.7-26 61.7-57.7c0-32-27.7-57.7-61.7-57.7zm143.4 0c-34 0-61.7 25.7-61.7 57.7 0 31.7 27.7 57.7 61.7 57.7 34.3 0 61.7-26 61.7-57.7.1-32-27.4-57.7-61.7-57.7zm156.6 90l-6 4.3V49.7c0-27.4-20.6-49.7-46-49.7H76.6c-25.4 0-46 22.3-46 49.7V248c-2-1.4-4.3-2.9-6.3-4.3-15.1-10.6-25.1 4-16 17.7 18.3 22.6 53.1 50.3 106.3 72C58.3 525.1 252 555.7 248.9 457.5c0-.7.3-56.6.3-96.6 5.1 1.1 9.4 2.3 13.7 3.1 0 39.7.3 92.8.3 93.5-3.1 98.3 190.6 67.7 134.3-124 53.1-21.7 88-49.4 106.3-72 9.1-13.8-.9-28.3-16.1-17.8zm-30.5 19.2c-68.9 37.4-128.3 31.1-160.6 29.7-23.7-.9-32.6 9.1-33.7 24.9-10.3-7.7-18.6-15.5-20.3-17.1-5.1-5.4-13.7-8-27.1-7.7-31.7 1.1-89.7 7.4-157.4-28V72.3c0-34.9 8.9-45.7 40.6-45.7h317.7c30.3 0 40.9 12.9 40.9 45.7v190.6z"/></svg></i>
													<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
												</li>
											<?php } ?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('comunicacion', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('comunicacion', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="comunicacion">
										<a href="#rcomunicacion" id="hcomunicacion"><i class="icon-megaphone"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcomunicacion">
											<?php
											$busq_modulo = in_array('agenda', array_column($modulo, 'nom_menu'));
											$posicion = array_search('agenda', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="agenda_a"><a href="<?= site_url('Snappy/Agenda') ?>"><i class="icon-calendar3"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('proyectos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('proyectos', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { 
												if($id_nivel==3	){?>
													<li id="proyectos"><a href="<?= site_url('Diseniador/proyectos') ?>"><i class="icon-cube4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
												<?php }elseif($id_nivel==2){?>
													<li id="proyectos"><a href="<?= site_url('Teamleader/proyectos') ?>"><i class="icon-cube4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
												<?php }else{?>
													<li id="proyectos"><a href="<?= site_url('Administrador/proyectos') ?>"><i class="icon-cube4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
												<?php } ?>
											<?php }

											$busq_modulo = in_array('redes', array_column($modulo, 'nom_menu'));
											$posicion = array_search('redes', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="sredes">
													<a href="#rredes" id="hredes"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="hive" class="icon- new-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M260.353,254.878,131.538,33.1a2.208,2.208,0,0,0-3.829.009L.3,254.887A2.234,2.234,0,0,0,.3,257.122L129.116,478.9a2.208,2.208,0,0,0,3.83-.009L260.358,257.113A2.239,2.239,0,0,0,260.353,254.878Zm39.078-25.713a2.19,2.19,0,0,0,1.9,1.111h66.509a2.226,2.226,0,0,0,1.9-3.341L259.115,33.111a2.187,2.187,0,0,0-1.9-1.111H190.707a2.226,2.226,0,0,0-1.9,3.341ZM511.7,254.886,384.9,33.112A2.2,2.2,0,0,0,382.99,32h-66.6a2.226,2.226,0,0,0-1.906,3.34L440.652,256,314.481,476.66a2.226,2.226,0,0,0,1.906,3.34h66.6a2.2,2.2,0,0,0,1.906-1.112L511.7,257.114A2.243,2.243,0,0,0,511.7,254.886ZM366.016,284.917H299.508a2.187,2.187,0,0,0-1.9,1.111l-108.8,190.631a2.226,2.226,0,0,0,1.9,3.341h66.509a2.187,2.187,0,0,0,1.9-1.111l108.8-190.631A2.226,2.226,0,0,0,366.016,284.917Z"></path></svg><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rredes">
														<?php
														$busq_submodulo = in_array('agenda_redes', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('agenda_redes', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="agenda_redes"><a href="<?= site_url('Snappy/Redes') ?>"><i class="icon-calendar3"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('informe_redes', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('informe_redes', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="informe_redes"><a href="<?= site_url('Snappy/Redes_Mensual') ?>"><i class="icon-bars-alt"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('informe_it', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('informe_it', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="informe_it"><a href="<?= site_url('Snappy/Redes_Mensual_Instagram') ?>"><i class="icon-bars-alt"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>


													</ul>
												</li>
											<?php }

											$busq_modulo = in_array('informe_redes', array_column($modulo, 'nom_menu'));
											$posicion = array_search('informe_redes', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="siredes">
												<!--	
												<a href="#riredes" id="hiredes"><img src="<?=base_url() ?>application/views/Admin/Iconos/Redes.svg" class="img-circle img-sm" style="fill:white"></img><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
											-->
													<a href="#riredes" id="hiredes"><i class="icon-bars-alt"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="riredes">
														<?php
														$busq_submodulo = in_array('busqueda', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('busqueda', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="busqueda_redes"><a href="<?= site_url('Snappy/Busqueda') ?>"><i class="icon-search4"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('estado_snappy', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('estado_snappy', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="estado_snappy"><a href="<?= site_url('Snappy/Estado_Snappy') ?>"><i class="icon-battery-6"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('inf_publicidad', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('inf_publicidad', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="publicidades"><a href="<?= site_url('Administrador/Publicidad') ?>"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('inf_por_tipo', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('inf_por_tipo', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="por_tipos"><a href="<?= site_url('Administrador/Por_Tipo') ?>"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>
												</li>
											<?php }

											$busq_modulo = in_array('config_comuicacion', array_column($modulo, 'nom_menu'));
											$posicion = array_search('config_comuicacion', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="configcomunicacion">
													<a href="#rconfigcomunicacion" id="hconfigcomunicacion"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconfigcomunicacion">
														<?php
														$busq_submodulo = in_array('tipo_comu', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('tipo_comu', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="tipos"><a href="<?= site_url('Snappy/Tipo') ?>"><i class="icon-circle-small"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('sub_tipo_comu', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('sub_tipo_comu', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="subtipos"><a href="<?= site_url('Snappy/Subtipo') ?>"><i class="icon-menu"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }


														$busq_submodulo = in_array('lista_carpeta', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('lista_carpeta', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="carpeta"><a href="<?= site_url('Snappy/Carpeta') ?>"><i class="icon-menu"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														?>


													</ul>
												</li>
											<?php }
											$busq_modulo = in_array('comercial_doc_pdf', array_column($modulo, 'nom_menu'));
											$posicion = array_search('comercial_doc_pdf', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="documentos_pdf"><a href="<?= site_url('Administrador/Documentos_PDF') ?>">
													<i class="icon-file-pdf"></i>
													<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
												</li>
											<?php } 
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('contabilidad', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('contabilidad', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) { ?>
									<li id="contabilidad">
										<a href="#rcontabilidad" id="hcontabilidad"><i class="icon-stats-dots"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcontabilidad">
											<?php
											$busq_modulo = in_array('estado_bancario', array_column($modulo, 'nom_menu'));
											$posicion = array_search('estado_bancario', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="ebancario"><a href="<?= site_url('Administrador/Estado_Bancario') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="money-check-alt" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M608 32H32C14.33 32 0 46.33 0 64v384c0 17.67 14.33 32 32 32h576c17.67 0 32-14.33 32-32V64c0-17.67-14.33-32-32-32zM176 327.88V344c0 4.42-3.58 8-8 8h-16c-4.42 0-8-3.58-8-8v-16.29c-11.29-.58-22.27-4.52-31.37-11.35-3.9-2.93-4.1-8.77-.57-12.14l11.75-11.21c2.77-2.64 6.89-2.76 10.13-.73 3.87 2.42 8.26 3.72 12.82 3.72h28.11c6.5 0 11.8-5.92 11.8-13.19 0-5.95-3.61-11.19-8.77-12.73l-45-13.5c-18.59-5.58-31.58-23.42-31.58-43.39 0-24.52 19.05-44.44 42.67-45.07V152c0-4.42 3.58-8 8-8h16c4.42 0 8 3.58 8 8v16.29c11.29.58 22.27 4.51 31.37 11.35 3.9 2.93 4.1 8.77.57 12.14l-11.75 11.21c-2.77 2.64-6.89 2.76-10.13.73-3.87-2.43-8.26-3.72-12.82-3.72h-28.11c-6.5 0-11.8 5.92-11.8 13.19 0 5.95 3.61 11.19 8.77 12.73l45 13.5c18.59 5.58 31.58 23.42 31.58 43.39 0 24.53-19.05 44.44-42.67 45.07zM416 312c0 4.42-3.58 8-8 8H296c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h112c4.42 0 8 3.58 8 8v16zm160 0c0 4.42-3.58 8-8 8h-80c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16zm0-96c0 4.42-3.58 8-8 8H296c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h272c4.42 0 8 3.58 8 8v16z"></path></svg><span style="margin-left: 0px;"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span></a></li>
											<?php } 

											$busq_modulo = in_array('dcont_cierres_caja', array_column($modulo, 'nom_menu'));
											$posicion = array_search('dcont_cierres_caja', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="c_cierres_cajas">
													<a href="<?= site_url('Administrador/Cierre_Caja') ?>"> 
														<i>
															<svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512">
																<path fill="currentColor" d="M480 80C480 53.49 458.5 32 432 32h-288C117.5 32 96 53.49 96 80V384h384V80zM378.9 166.8l-88 112c-4.031 5.156-10 8.438-16.53 9.062C273.6 287.1 272.7 287.1 271.1 287.1c-5.719 0-11.21-2.019-15.58-5.769l-56-48C190.3 225.6 189.2 210.4 197.8 200.4c8.656-10.06 23.81-11.19 33.84-2.594l36.97 31.69l72.53-92.28c8.188-10.41 23.31-12.22 33.69-4.062C385.3 141.3 387.1 156.4 378.9 166.8zM528 288H512v112c0 8.836-7.164 16-16 16h-416C71.16 416 64 408.8 64 400V288H48C21.49 288 0 309.5 0 336v96C0 458.5 21.49 480 48 480h480c26.51 0 48-21.49 48-48v-96C576 309.5 554.5 288 528 288z"/>
															</svg>
														</i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
													</a>
												</li>
											<?php } 

											$busq_modulo = in_array('gastos_sunat', array_column($modulo, 'nom_menu')); 
											$posicion = array_search('gastos_sunat', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?> 
												<li id="gastossunat">
													<a href="#rgastossunat" id="hgastossunat"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-invoice-dollar" class="icon- new-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-153 31V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zM64 72c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8V72zm0 80v-16c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8zm144 263.88V440c0 4.42-3.58 8-8 8h-16c-4.42 0-8-3.58-8-8v-24.29c-11.29-.58-22.27-4.52-31.37-11.35-3.9-2.93-4.1-8.77-.57-12.14l11.75-11.21c2.77-2.64 6.89-2.76 10.13-.73 3.87 2.42 8.26 3.72 12.82 3.72h28.11c6.5 0 11.8-5.92 11.8-13.19 0-5.95-3.61-11.19-8.77-12.73l-45-13.5c-18.59-5.58-31.58-23.42-31.58-43.39 0-24.52 19.05-44.44 42.67-45.07V232c0-4.42 3.58-8 8-8h16c4.42 0 8 3.58 8 8v24.29c11.29.58 22.27 4.51 31.37 11.35 3.9 2.93 4.1 8.77.57 12.14l-11.75 11.21c-2.77 2.64-6.89 2.76-10.13.73-3.87-2.43-8.26-3.72-12.82-3.72h-28.11c-6.5 0-11.8 5.92-11.8 13.19 0 5.95 3.61 11.19 8.77 12.73l45 13.5c18.59 5.58 31.58 23.42 31.58 43.39 0 24.53-19.05 44.44-42.67 45.07z"></path></svg>
													<span style="margin-left: -4px;"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span><!--<span style="background-color:red;margin-left:5px;font-size:14px;"><?php //echo $gastos_sunat_pendientes[0]['cantidad']; ?></span>--></a>
													<ul id="rgastossunat">
														<?php
														$busq_submodulo = in_array('gastos_sunat_gastos', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('gastos_sunat_gastos', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="gastos_sunat"><a href="<?= site_url('Administrador/Gastos_Sunat') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="hand-holding-usd" class="icon- new-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M271.06,144.3l54.27,14.3a8.59,8.59,0,0,1,6.63,8.1c0,4.6-4.09,8.4-9.12,8.4h-35.6a30,30,0,0,1-11.19-2.2c-5.24-2.2-11.28-1.7-15.3,2l-19,17.5a11.68,11.68,0,0,0-2.25,2.66,11.42,11.42,0,0,0,3.88,15.74,83.77,83.77,0,0,0,34.51,11.5V240c0,8.8,7.83,16,17.37,16h17.37c9.55,0,17.38-7.2,17.38-16V222.4c32.93-3.6,57.84-31,53.5-63-3.15-23-22.46-41.3-46.56-47.7L282.68,97.4a8.59,8.59,0,0,1-6.63-8.1c0-4.6,4.09-8.4,9.12-8.4h35.6A30,30,0,0,1,332,83.1c5.23,2.2,11.28,1.7,15.3-2l19-17.5A11.31,11.31,0,0,0,368.47,61a11.43,11.43,0,0,0-3.84-15.78,83.82,83.82,0,0,0-34.52-11.5V16c0-8.8-7.82-16-17.37-16H295.37C285.82,0,278,7.2,278,16V33.6c-32.89,3.6-57.85,31-53.51,63C227.63,119.6,247,137.9,271.06,144.3ZM565.27,328.1c-11.8-10.7-30.2-10-42.6,0L430.27,402a63.64,63.64,0,0,1-40,14H272a16,16,0,0,1,0-32h78.29c15.9,0,30.71-10.9,33.25-26.6a31.2,31.2,0,0,0,.46-5.46A32,32,0,0,0,352,320H192a117.66,117.66,0,0,0-74.1,26.29L71.4,384H16A16,16,0,0,0,0,400v96a16,16,0,0,0,16,16H372.77a64,64,0,0,0,40-14L564,377a32,32,0,0,0,1.28-48.9Z"></path></svg><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('gastos_sunat_informe', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('gastos_sunat_informe', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?> 
															<li id="informe_sunat"><a href="<?= site_url('Administrador/Informe_Sunat') ?>"><i class="icon-bars-alt"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php } ?>
													</ul>
												</li>
											<?php } 

											$busq_modulo = in_array('arpay_online', array_column($modulo, 'nom_menu'));
											$posicion = array_search('arpay_online', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="arpays"><a href="<?= site_url('Administrador/Arpay_Online') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="money-check" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M0 448c0 17.67 14.33 32 32 32h576c17.67 0 32-14.33 32-32V128H0v320zm448-208c0-8.84 7.16-16 16-16h96c8.84 0 16 7.16 16 16v32c0 8.84-7.16 16-16 16h-96c-8.84 0-16-7.16-16-16v-32zm0 120c0-4.42 3.58-8 8-8h112c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H456c-4.42 0-8-3.58-8-8v-16zM64 264c0-4.42 3.58-8 8-8h304c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8v-16zm0 96c0-4.42 3.58-8 8-8h176c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8v-16zM624 32H16C7.16 32 0 39.16 0 48v48h640V48c0-8.84-7.16-16-16-16z"></path></svg><span style="margin-left: 4px;"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span></a></li>
											<?php } 

											$busq_modulo = in_array('balance_real', array_column($modulo, 'nom_menu'));
											$posicion = array_search('balance_real', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="balances_reales"><a href="<?= site_url('Administrador/Balance_Real') ?>"><i class="icon-coin-dollar x1"></i><span style="margin-left: 2px;"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span></a></li>
											<?php }

											$busq_modulo = in_array('balance_oficial', array_column($modulo, 'nom_menu'));
											$posicion = array_search('balance_oficial', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="balances_oficiales"><a href="<?= site_url('Administrador/Balance_Oficial') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dollar-sign" class="icon- new-icon3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512"><path fill="currentColor" d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z"></path></svg><span style="margin-left: 3px;"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span></a></li>
											<?php } 

											$busq_modulo = in_array('config_contabilidad', array_column($modulo, 'nom_menu'));
											$posicion = array_search('config_contabilidad', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="configcontabilidad">
													<a href="#rconfigcontabilidad" id="hconfigcontabilidad"><i class="icon-cog6" style="margin-left: -7px; margin-right:18px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconfigcontabilidad">
														<?php
														$busq_submodulo = in_array('config_rubros', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('config_rubros', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="rubros"><a href="<?= site_url('Administrador/Rubro') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="border-none" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M240 224h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-288 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM240 320h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-96 288h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96-384h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM48 224H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('config_sub-rubros', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('config_sub-rubros', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="subrubros"><a href="<?= site_url('Administrador/Subrubro') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="border-style" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M240 416h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm192 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-288h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H32A32 32 0 0 0 0 64v400a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V96h368a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }  ?>
														
													</ul>
												</li>
											<?php } ?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('contabilidade', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('contabilidade', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) { ?>
									<li id="contabilidade">
										<a href="#rcontabilidade" id="hcontabilidade"><i class="icon-stats-dots"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcontabilidade">
											<?php
											$busq_modulo = in_array('despesas', array_column($modulo, 'nom_menu'));
											$posicion = array_search('despesas', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="edespensas"><a href="<?= site_url('Administrador/Despesas') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dollar-sign" class="icon- new-icon3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512"><path fill="currentColor" d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z"></path></svg><span style="margin-left: 3px;"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span></a></li>
											<?php } ?>

											
											<?php
											$busq_modulo = in_array('informe_contabilidad', array_column($modulo, 'nom_menu'));
											$posicion = array_search('informe_contabilidad', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="informecontabilidade">
													<a href="#rinformecontabilidade" id="hinformecontabilidade"><i class="icon-cog6" style="margin-left: -7px; margin-right:18px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rinformecontabilidade">
														<?php
														$busq_submodulo = in_array('despesas_todos', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('despesas_todos', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="rubros"><a href="#"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="border-none" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M240 224h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-288 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM240 320h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-96 288h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96-384h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM48 224H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php } ?>
														
													</ul>
												</li>
											<?php } ?>

											<?php
											$busq_modulo = in_array('config_contabilidad', array_column($modulo, 'nom_menu'));
											$posicion = array_search('config_contabilidad', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="configcontabilidade">
													<a href="#rconfigcontabilidade" id="hconfigcontabilidade"><i class="icon-cog6" style="margin-left: -7px; margin-right:18px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconfigcontabilidade">
														<?php
														$busq_submodulo = in_array('config_rubros', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('config_rubros', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="rubrose"><a href="<?= site_url('Administrador/Rubro_Contabilidade') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="border-none" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M240 224h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-288 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM240 320h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-96 288h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96-384h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM48 224H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('centro_custo', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('centro_custo', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="centro_custoe"><a href="<?= site_url('Administrador/Centro_Custo') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="border-style" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M240 416h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm192 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-288h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H32A32 32 0 0 0 0 64v400a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V96h368a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php } ?>
														
													</ul>
												</li>
											<?php } ?>

											<?php /*}*/ ?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('eventos', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('eventos', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="eventos">
										<a href="#reventos" id="heventos" ><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="calendar-day" class="new-icon2 icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm64-192c0-8.8 7.2-16 16-16h96c8.8 0 16 7.2 16 16v96c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16v-96zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"></path></svg><span style="margin-left: 13px;"><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="reventos">
											<?php
											$busq_modulo = in_array('lista_eventos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('lista_eventos', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="lista_eventos"><a href="<?= site_url('Administrador/Eventos') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="calendar-day" class="new-icon2 icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm64-192c0-8.8 7.2-16 16-16h96c8.8 0 16 7.2 16 16v96c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16v-96zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"></path></svg><span style="margin-left: 15px;"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span></a></li>
											<?php }

											$busq_modulo = in_array('inscripcion_eventos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inscripcion_eventos', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="inscripcion"><a href="<?= site_url('Administrador/Inscripcion') ?>"><i class="icon-books"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('configuracion_eventos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('configuracion_eventos', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?> 
												<li id="conf_evento">
													<a href="#rconf_evento" id="hconf_evento"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconf_evento">
														<?php
														$busq_submodulo = in_array('conf_evento_obj', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_evento_obj', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="objetivos"><a href="<?= site_url('Administrador/Objetivo') ?>"><i class="icon-circle-small" style="font-size: 20px; left: -5px;"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>
												</li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('inventario', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('inventario', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="inventario">
										<a href="#rinventario" id="hinventario"><i class="icon-clipboard6"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rinventario">
											<?php
											$busq_modulo = in_array('inventario', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inventario', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>

												<li id="inventariog"><a href="<?= site_url('Snappy/Inventario') ?>">
														<i class="icon-clipboard6" style="left: 2px;"></i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('inventario_producto', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inventario_producto', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>

												<li id="inv_producto"><a href="<?= site_url('Snappy/Producto') ?>">
												<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shopping-basket" class="icon-" width="19px" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="margin: 0 9px 0 0;"><path fill="currentColor" d="M576 216v16c0 13.255-10.745 24-24 24h-8l-26.113 182.788C514.509 462.435 494.257 480 470.37 480H105.63c-23.887 0-44.139-17.565-47.518-41.212L32 256h-8c-13.255 0-24-10.745-24-24v-16c0-13.255 10.745-24 24-24h67.341l106.78-146.821c10.395-14.292 30.407-17.453 44.701-7.058 14.293 10.395 17.453 30.408 7.058 44.701L170.477 192h235.046L326.12 82.821c-10.395-14.292-7.234-34.306 7.059-44.701 14.291-10.395 34.306-7.235 44.701 7.058L484.659 192H552c13.255 0 24 10.745 24 24zM312 392V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24zm112 0V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24zm-224 0V280c0-13.255-10.745-24-24-24s-24 10.745-24 24v112c0 13.255 10.745 24 24 24s24-10.745 24-24z"></path></svg>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('inventario_sede', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inventario_sede', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>

												<li id="inv_sede"><a href="<?= site_url('Snappy/Sede') ?>">
														<i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="19" height="17" focusable="false" width="20px" data-prefix="fas" data-icon="sitemap" class="icon-" role="img" viewBox="0 0 640 512" ><path fill="currentColor" d="M128 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32zm-24-80h192v48h48v-48h192v48h48v-57.59c0-21.17-17.23-38.41-38.41-38.41H344v-64h40c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32H256c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h40v64H94.41C73.23 224 56 241.23 56 262.41V320h48v-48zm264 80h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32zm240 0h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32z"/></svg></i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('inventario_codigo', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inventario_codigo', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>

												<li id="inv_codigo"><a href="<?= site_url('Snappy/Codigo') ?>">
														<i class="glyphicon glyphicon-barcode"></i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('inventario_configura', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inventario_configura', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="sconfig_inventario">
													<a href="#rconfig_inventario" id="hconfig_inventario"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconfig_inventario">
														<?php
														$busq_submodulo = in_array('locales', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('locales', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="local"><a href="<?= site_url('Snappy/Local') ?>"><i class="fa fa-location-arrow"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('inventario_tipo', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('inventario_tipo', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="tipoi"><a href="<?= site_url('Snappy/Tipo_Inventario') ?>"><i class="icon-circle-small" style="font-size: 20px; left: -5px;"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('inventario_subtipo', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('inventario_subtipo', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="subtipoi"><a href="<?= site_url('Snappy/SubTipo_Inventario') ?>"><i class="icon-menu" style="font-size: 20px; left: -5px;"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>
												</li>
											<?php }


											?>
										</ul>
									</li>
								<?php } 
								
								$busq_menu = in_array('colaboradores_gllg', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('colaboradores_gllg', array_column($menu, 'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="colaboradores">
										<a href="#rcolaboradores" id="hcolaboradores"><i class="icon-user-plus" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcolaboradores"> 
											<?php
											$busq_modulo = in_array('lista_profe_gllg', array_column($modulo, 'nom_menu'));
											$posicion = array_search('lista_profe_gllg',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<!--<li id="colaboradores_lista"><a href="<?= site_url('Administrador/Colaborador')?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>-->
												<li id="colaboradores_lista"><a href="<?= site_url('Colaborador/Colaborador')?>/<?php echo $id_sede; ?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }  

											$busq_modulo = in_array('asistencia_colaboradores', array_column($modulo, 'nom_menu'));
											$posicion = array_search('asistencia_colaboradores',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="asistencias_colaboradores"><a href="<?= site_url('Administrador/Asistencia_Colaborador')?>"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M128 96h384v256h64v-272c0-26.38-21.62-48-48-48h-416c-26.38 0-48 21.62-48 48V352h64V96zM624 383.1h-608c-8.75 0-16 7.25-16 16v16c0 35.25 28.75 64 64 64h512c35.25 0 64-28.75 64-64v-16C640 391.2 632.8 383.1 624 383.1z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											
											<?php }
											$busq_modulo = in_array('conf_gllg_documento_colab', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_gllg_documento_colab',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
											<li id="documentos_colaborador"><a href="<?= site_url('Colaborador/Documento_Colaborador')?>/<?php echo $id_sede; ?>"><i><svg
														xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23"
														height="25" focusable="false" data-prefix="fas"
														data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20"
														role="img" viewBox="0 0 640 512">
														<path fill="currentColor"
															d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z" />
													</svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											
											$busq_modulo = in_array('conf_gllg_cargo_fotocheck', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_gllg_cargo_fotocheck',array_column($modulo,'nom_menu')); 
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

                                            $busq_modulo = in_array('col_gl_fotocheck', array_column($modulo, 'nom_menu'));
                                            $posicion = array_search('col_gl_fotocheck',array_column($modulo,'nom_menu'));
                                            if($busq_modulo != false){?>
                                                <li id="fotocheck_colaboradores"><a href="<?= site_url('Colaborador/Fotocheck_Colaborador')?>/<?php echo $id_sede; ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;">
                                                                <path fill="currentColor" d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"></path>
                                                            </svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                            <?php }

											$busq_modulo = in_array('rrhh_gl_config', array_column($modulo, 'nom_menu'));
											$posicion = array_search('rrhh_gl_config',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="rrhh_configuraciones"><a href="<?= site_url('Administrador/Rrhh_Configuracion')?>"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }  

											$busq_modulo = in_array('rrhh_gl_plani', array_column($modulo, 'nom_menu'));
											$posicion = array_search('rrhh_gl_plani', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="planilla_empresa">
													<a href="#rplanilla_empresa" id="hplanilla_empresa"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rplanilla_empresa">
														<?php
														$busq_submodulo = in_array('plani_gl0', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('plani_gl0', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="planillas_gl0"><a href="<?= site_url('Administrador/Planilla') ?>/<?php echo $id_sede; ?>"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('plani_gl1', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('plani_gl1', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="planillas_gl1"><a href="<?= site_url('Administrador/Planilla') ?>/3"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('plani_gl2', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('plani_gl2', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="planillas_gl2"><a href="<?= site_url('Administrador/Planilla') ?>/4"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('plani_bl1', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('plani_bl1', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="planillas_bl1"><a href="<?= site_url('Administrador/Planilla') ?>/6"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('plani_ll1', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('plani_ll1', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="planillas_ll1"><a href="<?= site_url('Administrador/Planilla') ?>/2"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('plani_ep1', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('plani_ep1', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="planillas_ep1"><a href="<?= site_url('Administrador/Planilla') ?>/7"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('plani_ls1', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('plani_ls1', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="planillas_ls1"><a href="<?= site_url('Administrador/Planilla') ?>/5"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('plani_fv1', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('plani_fv1', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="planillas_fv1"><a href="<?= site_url('Administrador/Planilla') ?>/9"><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>
												</li>
											<?php }

											$busq_modulo = in_array('rrhh_gl_boleta', array_column($modulo, 'nom_menu'));
											$posicion = array_search('rrhh_gl_boleta',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="rrhh_boletas"><a href="<?= site_url('Administrador/Rrhh_Boleta')?>"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php } 

								$busq_menu = in_array('archivo_gl', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('archivo_gl', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="archivos">
										<a href="#rarchivos" id="harchivos"><i class="icon-book3"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rarchivos">
											<?php
											$busq_modulo = in_array('archivo_gl_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('archivo_gl_lista', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="archivos_lista">
													<a href="<?= site_url('Administrador/Archivo') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
												</li>
											<?php }
											
											$busq_modulo = in_array('archivo_gl_busqueda', array_column($modulo, 'nom_menu'));
											$posicion = array_search('archivo_gl_busqueda', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="archivos_busqueda">
													<a href="<?= site_url('Administrador/Archivo_Busqueda') ?>"><i class="icon-search4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
												</li>
											<?php } ?>
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