<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$foto = $_SESSION['foto'];
$id_sede= '9';
?>
<body class="sidebar-xs">

	<!-- Main navbar -->
	<div class="navbar navbar-inverse" style="background-color:#f38a0b;"> 
		<div class="navbar-header">
			<a class="navbar-brand" href="<?= site_url('AppIFV') ?>"><img src="<?= base_url() ?>template/img/logo2.png" alt=""></a>

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
					if($busq_menu != false) { ?>
						<a class="dropdown" href="<?= site_url('General') ?>">
							<img src="<?= base_url() ?>template/img/estrella_gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_empresa = in_array('1', array_column($list_empresa, 'id_empresa')); 
					if($busq_empresa != false){  ?>
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
					if($busq_empresa != false){  ?>
						<a class="dropdown" href="<?= site_url('Ceba2') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogo05-b.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php }?>
					
					<?php $busq_empresa = in_array('6', array_column($list_empresa, 'id_empresa'));
					if($busq_empresa != false){  ?>
						<a class="dropdown" href="<?= site_url('AppIFV') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogoifv.png" class="img-circle" alt="Imagen de Usuario" />
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
							<option value="<?php echo $list_nav['cod_sede']; ?>" <?php if($list_nav['cod_sede']=="FV1"){ echo "selected"; } ?>>
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
									<a href="<?= site_url('AppIFV/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
								</div>
							<?php } ?>
						</div>
					</li>

					<li class="dropdown dropdown-user">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?php if(isset($foto)) {echo base_url().$foto; }else{echo  base_url()."template/assets/images/placeholder.jpg"; } ?>"  alt="">
							<span><?php echo $sesion['usuario_nombres']." ".$sesion['usuario_apater'] ?></span>
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
			</div>
		</div>
	</div>

    	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main sidebar-fixed">
				<div class="sidebar-content" style="background-color:#c37413;">

					<!-- User menu -->
					<!--<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><img src="<?=base_url() ?>template/assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
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
							<?php 
								$busq_menu = in_array('calendarizacion', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('calendarizacion',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="calendarizaciones">
										<a href="#rcalendarizaciones" id="hcalendarizaciones"><i class="icon-collaboration" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcalendarizaciones">
											<?php
											$busq_modulo = in_array('lista_alumno_fv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('lista_alumno_fv',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="matriculados_c"><a href="<?= site_url('AppIFV/Matriculados_C')?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?> <!--<label id="contadornulosst" for=""> <?php //echo count($cantidadnulos)?> </label>--></span></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('admision_ifv', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('admision_ifv',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="admision_formulario">
										<a href="#radmision_formulario" id="hadmision_formulario"><i class="icon-collaboration" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="radmision_formulario">
											<?php

											$busq_modulo = in_array('admision_ifv_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('admision_ifv_lista',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="lista"><a href="<?= site_url('AppIFV/Postulantes_Formulario')?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?> <!--<label id="contadornulosst" for=""> <?php //echo count($cantidadnulos)?> </label>--></span></a></li>
											<?php }

											$busq_modulo = in_array('alum_fv_admision', array_column($modulo, 'nom_menu'));
											$posicion = array_search('alum_fv_admision',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="admisiones"><a href="<?= site_url('AppIFV/Admision')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="22" height="22" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M32 32C32 14.33 46.33 0 64 0H256C273.7 0 288 14.33 288 32C288 49.67 273.7 64 256 64H64C46.33 64 32 49.67 32 32zM0 160C0 124.7 28.65 96 64 96H256C291.3 96 320 124.7 320 160V448C320 483.3 291.3 512 256 512H64C28.65 512 0 483.3 0 448V160zM256 224H64V384H256V224z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('asistencia_fv', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('asistencia_fv',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="asistencias">
										<a href="#rasistencias" id="hasistencias"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M128 96h384v256h64v-272c0-26.38-21.62-48-48-48h-416c-26.38 0-48 21.62-48 48V352h64V96zM624 383.1h-608c-8.75 0-16 7.25-16 16v16c0 35.25 28.75 64 64 64h512c35.25 0 64-28.75 64-64v-16C640 391.2 632.8 383.1 624 383.1z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rasistencias">
											<?php 
											$busq_modulo = in_array('asis_fv_registro', array_column($modulo, 'nom_menu'));
											$posicion = array_search('asis_fv_registro',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="registros_asistencias"><a href="<?= site_url('AppIFV/Asistencia')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><path fill="currentColor" d="M13.97 2.196C22.49-1.72 32.5-.3214 39.62 5.778L80 40.39L120.4 5.778C129.4-1.926 142.6-1.926 151.6 5.778L192 40.39L232.4 5.778C241.4-1.926 254.6-1.926 263.6 5.778L304 40.39L344.4 5.778C351.5-.3214 361.5-1.72 370 2.196C378.5 6.113 384 14.63 384 24V488C384 497.4 378.5 505.9 370 509.8C361.5 513.7 351.5 512.3 344.4 506.2L304 471.6L263.6 506.2C254.6 513.9 241.4 513.9 232.4 506.2L192 471.6L151.6 506.2C142.6 513.9 129.4 513.9 120.4 506.2L80 471.6L39.62 506.2C32.5 512.3 22.49 513.7 13.97 509.8C5.456 505.9 0 497.4 0 488V24C0 14.63 5.456 6.112 13.97 2.196V2.196zM96 144C87.16 144 80 151.2 80 160C80 168.8 87.16 176 96 176H288C296.8 176 304 168.8 304 160C304 151.2 296.8 144 288 144H96zM96 368H288C296.8 368 304 360.8 304 352C304 343.2 296.8 336 288 336H96C87.16 336 80 343.2 80 352C80 360.8 87.16 368 96 368zM96 240C87.16 240 80 247.2 80 256C80 264.8 87.16 272 96 272H288C296.8 272 304 264.8 304 256C304 247.2 296.8 240 288 240H96z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											$busq_modulo = in_array('asis_fv_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('asis_fv_lista',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="listas_asistencias"><a href="<?= site_url('AppIFV/Registro_Ingreso')?>"><i class="glyphicon glyphicon-list" style="padding-right: 7px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											$busq_modulo = in_array('asis_fv_invitados', array_column($modulo, 'nom_menu'));
											$posicion = array_search('asis_fv_invitados',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="invitados_asistencias"><a href="<?= site_url('AppIFV/Invitado')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><path fill="currentColor" d="M256 64C256 99.35 227.3 128 192 128C156.7 128 128 99.35 128 64C128 28.65 156.7 0 192 0C227.3 0 256 28.65 256 64zM155.7 170.2C167.3 173.1 179.6 176 192.2 176C232.1 176 269.3 155.8 291 122.4L309.2 94.54C318.8 79.73 338.6 75.54 353.5 85.18C368.3 94.82 372.5 114.6 362.8 129.5L344.7 157.3C326.4 185.4 301.2 207.3 272 221.6V480C272 497.7 257.7 512 240 512C222.3 512 208 497.7 208 480V384H176V480C176 497.7 161.7 512 144 512C126.3 512 112 497.7 112 480V221.4C83.63 207.4 58.94 186.1 40.87 158.1L21.37 129.8C11.57 115 15.54 95.18 30.25 85.37C44.95 75.57 64.82 79.54 74.62 94.25L94.12 123.5C108.5 145 129.2 160.9 152.9 169.3C153.9 169.5 154.8 169.8 155.7 170.2V170.2z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } ?> 
										</ul>
									</li>
								<?php } 

								$busq_menu = in_array('grupo_fv', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('grupo_fv',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="grupos">
										<a href="#rgrupos" id="hgrupos"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M360 72C360 94.09 342.1 112 320 112C297.9 112 280 94.09 280 72C280 49.91 297.9 32 320 32C342.1 32 360 49.91 360 72zM104 168C104 145.9 121.9 128 144 128C166.1 128 184 145.9 184 168C184 190.1 166.1 208 144 208C121.9 208 104 190.1 104 168zM608 416C625.7 416 640 430.3 640 448C640 465.7 625.7 480 608 480H32C14.33 480 0 465.7 0 448C0 430.3 14.33 416 32 416H608zM456 168C456 145.9 473.9 128 496 128C518.1 128 536 145.9 536 168C536 190.1 518.1 208 496 208C473.9 208 456 190.1 456 168zM200 352C200 369.7 185.7 384 168 384H120C102.3 384 88 369.7 88 352V313.5L61.13 363.4C54.85 375 40.29 379.4 28.62 373.1C16.95 366.8 12.58 352.3 18.87 340.6L56.75 270.3C72.09 241.8 101.9 224 134.2 224H153.8C170.1 224 185.7 228.5 199.2 236.6L232.7 174.3C248.1 145.8 277.9 128 310.2 128H329.8C362.1 128 391.9 145.8 407.3 174.3L440.8 236.6C454.3 228.5 469.9 224 486.2 224H505.8C538.1 224 567.9 241.8 583.3 270.3L621.1 340.6C627.4 352.3 623 366.8 611.4 373.1C599.7 379.4 585.2 375 578.9 363.4L552 313.5V352C552 369.7 537.7 384 520 384H472C454.3 384 440 369.7 440 352V313.5L413.1 363.4C406.8 375 392.3 379.4 380.6 373.1C368.1 366.8 364.6 352.3 370.9 340.6L407.2 273.1C405.5 271.5 404 269.6 402.9 267.4L376 217.5V272C376 289.7 361.7 304 344 304H295.1C278.3 304 263.1 289.7 263.1 272V217.5L237.1 267.4C235.1 269.6 234.5 271.5 232.8 273.1L269.1 340.6C275.4 352.3 271 366.8 259.4 373.1C247.7 379.4 233.2 375 226.9 363.4L199.1 313.5L200 352z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rgrupos">
											<?php
											$busq_modulo = in_array('grupo_calen', array_column($modulo, 'nom_menu'));
											$posicion = array_search('grupo_calen',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="grupos_c"><a href="<?= site_url('AppIFV/Grupo_C')?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('informe_calen', array_column($modulo, 'nom_menu'));
											$posicion = array_search('informe_calen',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){ ?>
												<li id="informes_c"><a href="<?= site_url('AppIFV/Informe_C')?>"><i class="icon-bars-alt" style="font-size: 18px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('grupo_calendario', array_column($modulo, 'nom_menu'));
											$posicion = array_search('grupo_calendario',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="calendarios_c"><a href="<?= site_url('AppIFV/Calendario')?>"><i class="icon-calendar2"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?> <!--<label id="contadornulosst" for=""> <?php //echo count($cantidadnulos)?> </label>--></span></a></li>
											<?php } ?>
										</ul>
									</li>
								<?php }
															
								$busq_menu = in_array('examen_adm', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('examen_adm',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="examenadmision">
										<a href="#rexamenadmision" id="hexamenadmision"><i class="icon-task" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rexamenadmision">
											<?php 
											$busq_modulo = in_array('postulante', array_column($modulo, 'nom_menu'));
											$posicion = array_search('postulante',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="postulantes"><a href="<?= site_url('AppIFV/Postulantes') ?>"><i class="icon-users4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('examenf', array_column($modulo, 'nom_menu'));
											$posicion = array_search('examenf',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="examenf"><a href="<?= site_url('AppIFV/Examen') ?>"><i class="icon-stack-text"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('biblioteca_ifv', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('biblioteca_ifv',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="bibliotecas">
										<a href="#rbibliotecas" id="hbibliotecas"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><path fill="currentColor" d="M448 336v-288C448 21.49 426.5 0 400 0H352v191.1c0 13.41-15.52 20.88-25.1 12.49L272 160L217.1 204.5C207.5 212.8 192 205.4 192 191.1V0H96C42.98 0 0 42.98 0 96v320c0 53.02 42.98 96 96 96h320c17.67 0 32-14.33 32-32c0-11.72-6.607-21.52-16-27.1v-81.36C441.8 362.8 448 350.2 448 336zM384 448H96c-17.67 0-32-14.33-32-32c0-17.67 14.33-32 32-32h288V448z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rbibliotecas">
											<?php 
											$busq_modulo = in_array('bibl_registro', array_column($modulo, 'nom_menu'));
											$posicion = array_search('bibl_registro',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="registros_biblioteca"><a href="<?= site_url('AppIFV/Registro_Biblioteca')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><path fill="currentColor" d="M13.97 2.196C22.49-1.72 32.5-.3214 39.62 5.778L80 40.39L120.4 5.778C129.4-1.926 142.6-1.926 151.6 5.778L192 40.39L232.4 5.778C241.4-1.926 254.6-1.926 263.6 5.778L304 40.39L344.4 5.778C351.5-.3214 361.5-1.72 370 2.196C378.5 6.113 384 14.63 384 24V488C384 497.4 378.5 505.9 370 509.8C361.5 513.7 351.5 512.3 344.4 506.2L304 471.6L263.6 506.2C254.6 513.9 241.4 513.9 232.4 506.2L192 471.6L151.6 506.2C142.6 513.9 129.4 513.9 120.4 506.2L80 471.6L39.62 506.2C32.5 512.3 22.49 513.7 13.97 509.8C5.456 505.9 0 497.4 0 488V24C0 14.63 5.456 6.112 13.97 2.196V2.196zM96 144C87.16 144 80 151.2 80 160C80 168.8 87.16 176 96 176H288C296.8 176 304 168.8 304 160C304 151.2 296.8 144 288 144H96zM96 368H288C296.8 368 304 360.8 304 352C304 343.2 296.8 336 288 336H96C87.16 336 80 343.2 80 352C80 360.8 87.16 368 96 368zM96 240C87.16 240 80 247.2 80 256C80 264.8 87.16 272 96 272H288C296.8 272 304 264.8 304 256C304 247.2 296.8 240 288 240H96z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('bibl_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('bibl_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="listas_biblioteca"><a href="<?= site_url('AppIFV/Lis_Biblioteca')?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('bibl_historia', array_column($modulo, 'nom_menu'));
											$posicion = array_search('bibl_historia',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="historias_biblioteca"><a href="<?= site_url('AppIFV/Historico_Biblioteca')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><path fill="currentColor" d="M0 32C0 14.33 14.33 0 32 0H160C177.7 0 192 14.33 192 32V416C192 469 149 512 96 512C42.98 512 0 469 0 416V32zM128 64H64V128H128V64zM64 256H128V192H64V256zM96 440C109.3 440 120 429.3 120 416C120 402.7 109.3 392 96 392C82.75 392 72 402.7 72 416C72 429.3 82.75 440 96 440zM224 416V154L299.4 78.63C311.9 66.13 332.2 66.13 344.7 78.63L435.2 169.1C447.7 181.6 447.7 201.9 435.2 214.4L223.6 425.9C223.9 422.7 224 419.3 224 416V416zM374.8 320H480C497.7 320 512 334.3 512 352V480C512 497.7 497.7 512 480 512H182.8L374.8 320z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('registro_pract', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('registro_pract',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?>  
									<li id="practicas">
										<a href="#rpracticas" id="hpracticas"><i class="icon-office" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rpracticas">
											<?php 	
											$busq_modulo = in_array('efsrt_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('efsrt_lista',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="listas_efsrt"><a href="<?= site_url('AppIFV/Efsrt')?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('centro', array_column($modulo, 'nom_menu'));
											$posicion = array_search('centro',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){ ?>
												<li id="centros"><a href="<?= site_url('AppIFV/Centro')?>"><i class="icon-location4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?><label id="contadorreno" for=""> <?php echo count($contador_renovar) ?> </label><label id="contadorcadu" for=""> <?php echo count($contador_caducado) ?> </label></a></li>
											<?php }

											$busq_modulo = in_array('efsrt_fv_contratos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('efsrt_fv_contratos',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="contratos_efsrt"><a href="<?= site_url('AppIFV/Contrato_Efsrt')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;" ><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('efsrt_informes', array_column($modulo, 'nom_menu'));
											$posicion = array_search('efsrt_informes', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="informes_efsrt"> 
													<a href="#rinformes_efsrt" id="hinformes_efsrt"><i class="icon-bars-alt" style="font-size: 19px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rinformes_efsrt">
														<?php
														$busq_submodulo = in_array('efsrt_inf_examen_bas', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('efsrt_inf_examen_bas', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="postulantes_efsrt"><a href="<?= site_url('AppIFV/Postulantes_Efsrt') ?>"><i class="icon-mail5" style="font-size: 18px;"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>
												</li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('titulacion_ifv', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('titulacion_ifv',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="titulacion">
										<a href="#rtitulacion" id="htitulacion"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><path fill="currentColor" d="M623.1 136.9l-282.7-101.2c-13.73-4.91-28.7-4.91-42.43 0L16.05 136.9C6.438 140.4 0 149.6 0 160s6.438 19.65 16.05 23.09L76.07 204.6c-11.89 15.8-20.26 34.16-24.55 53.95C40.05 263.4 32 274.8 32 288c0 9.953 4.814 18.49 11.94 24.36l-24.83 149C17.48 471.1 25 480 34.89 480H93.11c9.887 0 17.41-8.879 15.78-18.63l-24.83-149C91.19 306.5 96 297.1 96 288c0-10.29-5.174-19.03-12.72-24.89c4.252-17.76 12.88-33.82 24.94-47.03l190.6 68.23c13.73 4.91 28.7 4.91 42.43 0l282.7-101.2C633.6 179.6 640 170.4 640 160S633.6 140.4 623.1 136.9zM351.1 314.4C341.7 318.1 330.9 320 320 320c-10.92 0-21.69-1.867-32-5.555L142.8 262.5L128 405.3C128 446.6 213.1 480 320 480c105.1 0 192-33.4 192-74.67l-14.78-142.9L351.1 314.4z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rtitulacion">
											<?php 
											$busq_modulo = in_array('solicitud_ifv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('solicitud_ifv',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="solicitudes"><a href="<?= site_url('AppIFV/Solicitud')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><path fill="currentColor" d="M502.6 198.6l-61.25-61.25C435.4 131.4 427.3 128 418.8 128H256C220.7 128 191.1 156.7 192 192l.0065 255.1C192 483.3 220.7 512 256 512h192c35.2 0 64-28.8 64-64l.0098-226.7C512 212.8 508.6 204.6 502.6 198.6zM464 448c0 8.836-7.164 16-16 16h-192c-8.838 0-16-7.164-16-16L240 192.1c0-8.836 7.164-16 16-16h128L384 224c0 17.67 14.33 32 32 32h48.01V448zM317.7 96C310.6 68.45 285.8 48 256 48H215.2C211.3 20.93 188.1 0 160 0C131.9 0 108.7 20.93 104.8 48H64c-35.35 0-64 28.65-64 64V384c0 35.34 28.65 64 64 64h96v-48H64c-8.836 0-16-7.164-16-16V112C48 103.2 55.18 96 64 96h16v16c0 17.67 14.33 32 32 32h61.35C190 115.4 220.6 96 256 96H317.7zM160 72c-8.822 0-16-7.176-16-16s7.178-16 16-16s16 7.176 16 16S168.8 72 160 72z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('lista_tit_ifv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('lista_tit_ifv',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="listas_titulacion"><a href="#"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('titu_fv_publico', array_column($modulo, 'nom_menu'));
											$posicion = array_search('titu_fv_publico',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="titu_publicos">
													<a href="<?= site_url('AppIFV/Publico')?>">
														<i>
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" width="19" height="19" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
																<g>
																	<path xmlns="http://www.w3.org/2000/svg" d="m12.25 2h-1.1c-.33-1.15-1.39-2-2.65-2s-2.32.85-2.65 2h-1.1c-.41 0-.75.34-.75.75v1.5c0 .96.79 1.75 1.75 1.75h5.5c.96 0 1.75-.79 1.75-1.75v-1.5c0-.41-.34-.75-.75-.75z" fill="#ffffff" data-original="#000000"/>
																	<path xmlns="http://www.w3.org/2000/svg" d="m14.25 3h-.25v1.25c0 1.52-1.23 2.75-2.75 2.75h-5.5c-1.52 0-2.75-1.23-2.75-2.75v-1.25h-.25c-1.52 0-2.75 1.23-2.75 2.75v12.5c0 1.52 1.23 2.75 2.75 2.75h7.38l.22-1.23c.1-.56.36-1.06.76-1.47l.8-.8h-8.16c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h9.5c.05 0 .09 0 .14.02h.01l3.6-3.6v-6.67c0-1.52-1.23-2.75-2.75-2.75zm-1 11.25h-9.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h9.5c.41 0 .75.34.75.75s-.34.75-.75.75zm0-3.25h-9.5c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h9.5c.41 0 .75.34.75.75s-.34.75-.75.75z" fill="#ffffff" data-original="#000000"/>
																	<path xmlns="http://www.w3.org/2000/svg" d="m12.527 24c-.197 0-.389-.078-.53-.22-.173-.173-.251-.419-.208-.661l.53-3.005c.026-.151.1-.291.208-.4l7.425-7.424c.912-.914 1.808-.667 2.298-.177l1.237 1.237c.683.682.683 1.792 0 2.475l-7.425 7.425c-.108.109-.248.182-.4.208l-3.005.53c-.043.008-.087.012-.13.012zm3.005-1.28h.01z" fill="#ffffff" data-original="#000000"/>
																</g>
															</svg>
														</i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
													</a>
												</li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('registro_ifv', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('registro_ifv',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="registros">
										<a href="#rregistros" id="hregistros"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><path fill="currentColor" d="M50.73 58.53C58.86 42.27 75.48 32 93.67 32H208V160H0L50.73 58.53zM240 160V32H354.3C372.5 32 389.1 42.27 397.3 58.53L448 160H240zM448 416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V192H448V416z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rregistros">
											<?php 
											$busq_modulo = in_array('oficial_ifv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('oficial_ifv',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="oficiales_registros"><a href="<?= site_url('AppIFV/Registro')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M96 96h384v288h64V72C544 50 525.1 32 504 32H72C49.1 32 32 50 32 72V384h64V96zM560 416H416v-48c0-8.838-7.164-16-16-16h-160C231.2 352 224 359.2 224 368V416H16C7.164 416 0 423.2 0 432v32C0 472.8 7.164 480 16 480h544c8.836 0 16-7.164 16-16v-32C576 423.2 568.8 416 560 416z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('horario_ifv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('horario_ifv',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="horarios_registros"><a href="<?= site_url('AppIFV/Horario')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M310.3 97.25c-8-3.5-17.5 .25-21 8.5L255.8 184C233.8 184.3 216 202 216 224c0 22.12 17.88 40 40 40S296 246.1 296 224c0-10.5-4.25-20-11-27.12l33.75-78.63C322.3 110.1 318.4 100.8 310.3 97.25zM448 64h-56.23C359.5 24.91 310.7 0 256 0S152.5 24.91 120.2 64H64C28.75 64 0 92.75 0 128v320c0 35.25 28.75 64 64 64h384c35.25 0 64-28.75 64-64V128C512 92.75 483.3 64 448 64zM256 304c-70.58 0-128-57.42-128-128s57.42-128 128-128c70.58 0 128 57.42 128 128S326.6 304 256 304z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								/*if ($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==5 || $_SESSION['usuario'][0]['id_usuario']==7 || 
								$_SESSION['usuario'][0]['id_usuario']==10 || $_SESSION['usuario'][0]['id_usuario']==30 || $_SESSION['usuario'][0]['id_usuario']==34 || 
								$_SESSION['usuario'][0]['id_usuario']==35 || $_SESSION['usuario'][0]['id_usuario']==60 || $_SESSION['usuario'][0]['id_usuario']==64 || 
								$_SESSION['usuario'][0]['id_usuario']==69 || $_SESSION['usuario'][0]['id_usuario']==70 || $_SESSION['usuario'][0]['id_usuario']==71 || 
								$_SESSION['usuario'][0]['id_usuario']==72 || $_SESSION['usuario'][0]['id_usuario']==79) {*/ 
								$busq_menu = in_array('tramites_fv', array_column($menu, 'nom_grupomenu'));  
								$posicion=array_search('tramites_fv',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="tramites">
										<a href="#rtramites" id="htramites"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M121 32C91.6 32 66 52 58.9 80.5L1.9 308.4C.6 313.5 0 318.7 0 323.9V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V323.9c0-5.2-.6-10.4-1.9-15.5l-57-227.9C446 52 420.4 32 391 32H121zm0 64H391l48 192H387.8c-12.1 0-23.2 6.8-28.6 17.7l-14.3 28.6c-5.4 10.8-16.5 17.7-28.6 17.7H195.8c-12.1 0-23.2-6.8-28.6-17.7l-14.3-28.6c-5.4-10.8-16.5-17.7-28.6-17.7H73L121 96z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rtramites">
											<?php 
											$busq_modulo = in_array('inf_doc_recibidos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_doc_recibidos',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="documentos_recibidos">
													<a href="<?= site_url('AppIFV/Documento_Recibido')?>">
														<i class="icon-file-pdf" style="font-size: 18px;"></i>
														<?php if(isset($cantidad_documentos_recibidos)){ ?>
															<?php echo $modulo[$posicion]['nom_subgrupo']; ?><label style="background-color:red;margin-left:10px;padding:2px;"><?php echo $cantidad_documentos_recibidos; ?></label>
														<?php }else{ ?>
															<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
														<?php } ?>
													</a>
												</li>
											<?php }

											$busq_modulo = in_array('trami_fv_gut', array_column($modulo, 'nom_menu'));
											$posicion = array_search('trami_fv_gut',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="trami_fv_gut">
													<a href="<?= site_url('AppIFV/Fut_Recibido')?>">
														<i class="icon-file-pdf" style="font-size: 18px;"></i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
														<!--<?php if(isset($cantidad_documentos_recibidos)){ ?>
															<?php echo $modulo[$posicion]['nom_subgrupo']; ?><label style="background-color:red;margin-left:10px;padding:2px;"><?php echo $cantidad_documentos_recibidos; ?></label>
														<?php }else{ ?>
															<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
														<?php } ?>-->
													</a>
												</li>
											<?php }
											
											$busq_modulo = in_array('trami_fv_fotocheck', array_column($modulo, 'nom_menu'));
											$posicion = array_search('trami_fv_fotocheck',array_column($modulo,'nom_menu')); 
											
											if($busq_modulo != false){?>
												<li id="fotocheck_tramites">
													<a href="<?= site_url('AppIFV/Fotocheck_Alumnos')?>">
														<i>
															<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;">
																<path fill="currentColor" d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/>
															</svg>
														</i>
														<?php if(isset($cantidad_fotochecks)){ ?>
															<?php echo $modulo[$posicion]['nom_subgrupo']; ?><label style="background-color:red;margin-left:35px;padding:2px;"><?php echo $cantidad_fotochecks; ?></label>
														<?php }else{ ?>
															<?php echo $modulo[$posicion]['nom_subgrupo']; ?> 
														<?php } ?>
													</a>
												</li>
											<?php } 

											$busq_modulo = in_array('tra_fv_contratos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('tra_fv_contratos',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="contratos"><a href="<?= site_url('AppIFV/Contrato')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;" ><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?> 
										</ul>
									</li>
								<?php } //}

								$busq_menu = in_array('comunicacion_ifv', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('comunicacion_ifv',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?>  
									<li id="comunicaciones">
										<a href="#rcomunicaciones" id="hcomunicaciones"><i class="icon-megaphone" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcomunicaciones">
											<?php 
											/*if($_SESSION['usuario'][0]['id_usuario']==1 || $_SESSION['usuario'][0]['id_usuario']==7 || $_SESSION['usuario'][0]['id_usuario']==35 || $_SESSION['usuario'][0]['id_usuario']==71 || $_SESSION['usuario'][0]['id_nivel']==6){
												$busq_modulo = in_array('pdf_adm', array_column($modulo, 'nom_menu'));
												$posicion = array_search('pdf_adm',array_column($modulo,'nom_menu')); 

												if($busq_modulo != false){?>
													<li id="resultados"><a href="<?= site_url('AppIFV/PDF_Admision')?>"><i class="icon-file-pdf"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
												<?php } 
											}

											$busq_modulo = in_array('pdf_reglamento', array_column($modulo, 'nom_menu'));
											$posicion = array_search('pdf_reglamento',array_column($modulo,'nom_menu')); 
											
											if($busq_modulo != false){?>
												<li id="pdf_reglamento"><a href="<?= site_url('AppIFV/PDF_Reglamento')?>"><i class="icon-file-pdf"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

                                            $busq_modulo = in_array('img_web', array_column($modulo, 'nom_menu'));
                                            $posicion = array_search('img_web',array_column($modulo,'nom_menu')); 

                                            if($busq_modulo != false){?>
                                                <li id="imagenwebs"><a href="<?= site_url('AppIFV/Imagen_Web')?>"><i class="icon-image3"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                            <?php }*/

                                            $busq_modulo = in_array('web_ifv', array_column($modulo, 'nom_menu'));
                                            $posicion = array_search('web_ifv',array_column($modulo,'nom_menu')); 

                                            if($busq_modulo != false){?>
                                                <li id="web_ifv">
													<a href="<?= site_url('AppIFV/Web_IFV')?>">
														<i class="icon-file-pdf" style="font-size: 18px;"></i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
														<label style="background-color:red;margin-left:3rem;padding:0 0.5rem;">
														<?php if(isset($cantidad_caducados)){echo $cantidad_caducados;}?>
														</label>
													</a>
												</li>
                                            <?php } ?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('informe_fv', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('informe_fv',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="informes">
										<a href="#rinformes" id="hinformes"><i class="icon-bars-alt" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rinformes">
											<?php 

											$busq_modulo = in_array('inf_contac', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_contac',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="contactenos"><a href="<?= site_url('AppIFV/Contactenos')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="22" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M48 32C21.5 32 0 53.5 0 80v64C0 152.9 7.125 160 16 160H96V80C96 53.5 74.5 32 48 32zM256 380.6V320h224V128c0-53-43-96-96-96H111.6C121.8 45.38 128 61.88 128 80V384c0 38.88 34.62 69.63 74.75 63.13C234.3 442 256 412.5 256 380.6zM288 352v32c0 52.88-43 96-96 96h272c61.88 0 112-50.13 112-112c0-8.875-7.125-16-16-16H288z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?> <label id="contadorcadu" for=""> <?php echo count($contador_contactenos) ?> </label></a></li>
											<?php } 

											$busq_modulo = in_array('conf_fv_doc_alum', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_doc_alum',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<!--<?= site_url('AppIFV/Lista_Admision') ?>-->
												<li id="doc_alumnos"><a href="<?= site_url('AppIFV/Doc_Alumno') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_fv_datos_alum', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_datos_alum',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="datos_alumnos"><a href="<?= site_url('AppIFV/Datos_Alumno') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('inf_fv_alum_obs', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_fv_alum_obs',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="alumnos_obs"><a href="<?= site_url('AppIFV/Alumno_Obs') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('inf_historico', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_historico',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="historicos_extranet"><a href="<?= site_url('AppIFV/Historico_Extranet')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="22" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M48 32C21.5 32 0 53.5 0 80v64C0 152.9 7.125 160 16 160H96V80C96 53.5 74.5 32 48 32zM256 380.6V320h224V128c0-53-43-96-96-96H111.6C121.8 45.38 128 61.88 128 80V384c0 38.88 34.62 69.63 74.75 63.13C234.3 442 256 412.5 256 380.6zM288 352v32c0 52.88-43 96-96 96h272c61.88 0 112-50.13 112-112c0-8.875-7.125-16-16-16H288z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('inf_pagamentos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_pagamentos',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="pagos"><a href="<?= site_url('AppIFV/Pagos')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7c-12.23-91.55-87.28-166-178.9-177.6c-136.2-17.24-250.7 97.28-233.4 233.4c11.6 91.64 86.07 166.7 177.6 178.9c53.81 7.191 104.3-6.235 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 .0004C515.9 484.7 515.9 459.3 500.3 443.7zM273.7 253.8C269.8 276.4 252.6 291.3 228 296.1V304c0 11.03-8.953 20-20 20S188 315 188 304V295.2C178.2 293.2 168.4 289.9 159.6 286.8L154.8 285.1C144.4 281.4 138.9 269.9 142.6 259.5C146.2 249.1 157.6 243.7 168.1 247.3l5.062 1.812c8.562 3.094 18.25 6.562 25.91 7.719c16.23 2.5 33.47-.0313 35.17-9.812c1.219-7.094 .4062-10.62-31.8-19.84L196.2 225.4C177.8 219.1 134.5 207.3 142.3 162.2C146.2 139.6 163.5 124.8 188 120V112c0-11.03 8.953-20 20-20S228 100.1 228 112v8.695c6.252 1.273 13.06 3.07 21.47 5.992c10.42 3.625 15.95 15.03 12.33 25.47C258.2 162.6 246.8 168.1 236.3 164.5C228.2 161.7 221.8 159.9 216.8 159.2c-16.11-2.594-33.38 .0313-35.08 9.812c-1 5.812-1.719 10 25.7 18.03l6 1.719C238.9 196 281.5 208.2 273.7 253.8z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('inf_fv_retirados', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_fv_retirados',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){ ?>
												<li id="retirados"><a href="<?= site_url('AppIFV/Retirados')?>"><i class="icon-users4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('uniforme_fv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('uniforme_fv',array_column($modulo,'nom_menu')); 
											
											if($busq_modulo != false){?>
												<li id="uniforme"><a href="<?= site_url('AppIFV/Uniformes')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7c-12.23-91.55-87.28-166-178.9-177.6c-136.2-17.24-250.7 97.28-233.4 233.4c11.6 91.64 86.07 166.7 177.6 178.9c53.81 7.191 104.3-6.235 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 .0004C515.9 484.7 515.9 459.3 500.3 443.7zM273.7 253.8C269.8 276.4 252.6 291.3 228 296.1V304c0 11.03-8.953 20-20 20S188 315 188 304V295.2C178.2 293.2 168.4 289.9 159.6 286.8L154.8 285.1C144.4 281.4 138.9 269.9 142.6 259.5C146.2 249.1 157.6 243.7 168.1 247.3l5.062 1.812c8.562 3.094 18.25 6.562 25.91 7.719c16.23 2.5 33.47-.0313 35.17-9.812c1.219-7.094 .4062-10.62-31.8-19.84L196.2 225.4C177.8 219.1 134.5 207.3 142.3 162.2C146.2 139.6 163.5 124.8 188 120V112c0-11.03 8.953-20 20-20S228 100.1 228 112v8.695c6.252 1.273 13.06 3.07 21.47 5.992c10.42 3.625 15.95 15.03 12.33 25.47C258.2 162.6 246.8 168.1 236.3 164.5C228.2 161.7 221.8 159.9 216.8 159.2c-16.11-2.594-33.38 .0313-35.08 9.812c-1 5.812-1.719 10 25.7 18.03l6 1.719C238.9 196 281.5 208.2 273.7 253.8z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php } 
							
								$busq_menu = in_array('soporte_fv_docs', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('soporte_fv_docs',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="soporte_docs">
										<a href="#rsoporte_docs" id="hsoporte_docs"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M192 0H48C21.5 0 0 21.5 0 48V368c0 26.5 21.5 48 48 48H162.7c6.6-18.6 24.4-32 45.3-32V272c0-44.2 35.8-80 80-80h32V128H224c-17.7 0-32-14.3-32-32V0zm96 224c-26.5 0-48 21.5-48 48v16 96 32H208c-8.8 0-16 7.2-16 16v16c0 35.3 28.7 64 64 64H576c35.3 0 64-28.7 64-64V432c0-8.8-7.2-16-16-16H592V288c0-35.3-28.7-64-64-64H320 304 288zm32 64H528V416H304V288h16zM224 0V96h96L224 0z"/></svg></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rsoporte_docs">
											<?php 
											$busq_modulo = in_array('sop_fv_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('sop_fv_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="soporte_docs_listas"><a href="<?= site_url('AppIFV/Soporte_Doc') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('colaboradores_ifv', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('colaboradores_ifv',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="colaboradores">
										<a href="#rcolaboradores" id="hcolaboradores"><i class="icon-user-plus" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcolaboradores"> 
											<?php
											$busq_modulo = in_array('lista_profe_ifv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('lista_profe_ifv',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<!--<li id="colaboradores_lista"><a href="<?= site_url('AppIFV/Colaborador')?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>-->
												<li id="colaboradores_lista"><a href="<?= site_url('Colaborador/Colaborador')?>/<?php echo $id_sede; ?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }  

											$busq_modulo = in_array('col_asistencia_fv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('col_asistencia_fv',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="asistencias_colaboradores"><a href="<?= site_url('AppIFV/Asistencia_Colaborador')?>"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M128 96h384v256h64v-272c0-26.38-21.62-48-48-48h-416c-26.38 0-48 21.62-48 48V352h64V96zM624 383.1h-608c-8.75 0-16 7.25-16 16v16c0 35.25 28.75 64 64 64h512c35.25 0 64-28.75 64-64v-16C640 391.2 632.8 383.1 624 383.1z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											
											$busq_modulo = in_array('conf_fv_perfil', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_perfil',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){ ?> 
												<li id="perfiles">
													<a href="<?= site_url('AppIFV/Perfil')?>">
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
														<i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" 
														data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512">
														<path fill="currentColor" d="M128 96h384v256h64v-272c0-26.38-21.62-48-48-48h-416c-26.38 0-48 21.62-48 48V352h64V96zM624 383.1h-608c-8.75 0-16 7.25-16
														16v16c0 35.25 28.75 64 64 64h512c35.25 0 64-28.75 64-64v-16C640 391.2 632.8 383.1 624 383.1z"/></svg></i>
													</a>
												</li>

											<?php }

											$busq_modulo = in_array('conf_fv_cargo_fotocheck', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_cargo_fotocheck',array_column($modulo,'nom_menu')); 
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

											
                                            $busq_modulo = in_array('col_ifv_fotocheck', array_column($modulo, 'nom_menu'));
                                            $posicion = array_search('col_ifv_fotocheck',array_column($modulo,'nom_menu'));
                                            if($busq_modulo != false){?>
                                                <li id="fotocheck_colaboradores"><a href="<?= site_url('Colaborador/Fotocheck_Colaborador')?>/<?php echo $id_sede; ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;">
                                                                <path fill="currentColor" d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"></path>
                                                            </svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
                                            <?php }

											$busq_modulo = in_array('informe_colabor_ifv', array_column($modulo, 'nom_menu'));
											$posicion = array_search('informe_colabor_ifv', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="informe_colaborador"> 
													<a href="#rinforme_colaborador" id="hinforme_colaborador"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rinforme_colaborador">
														<?php
														$busq_submodulo = in_array('lista_obs_colaborado', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('lista_obs_colaborado', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="c_lista_obs"><a href="<?= site_url('AppIFV/Colaborador_Obs') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>
												</li>
											<?php }
											?>
										</ul>
									</li>
								<?php } 

								$busq_menu = in_array('ventas_fv', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('ventas_fv',array_column($menu,'nom_grupomenu')); ?> 
								<?php if($busq_menu != false){  ?>  
									<li id="ventas">
										<a href="#rventas" id="hventas"><i>
											<svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" 
												focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512">
												<path fill="currentColor" d="M384 288l64-192h-109.4C308.4 96 281.6 76.66 272 48C262.4 19.33 235.6 0 205.4 0H64l64 288H384zM0 480c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-64H0V480zM480 224h-40.94l-21.33 64H432C440.8 288 448 295.2 448 304S440.8 320 432 320h-352C71.16 320 64 312.8 64 304S71.16 288 80 288h15.22l-14.22-64H32C14.33 224 0 238.3 0 256v128h512V256C512 238.3 497.7 224 480 224z"/>
											</svg></i>
											<span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?>
												<span style="background-color:red;margin-left:5px;padding:3px;font-size:14px;"><?php echo $cierres_caja_pendientes; ?></span>
												<span style="background-color:orange;margin-left:1px;padding:3px;font-size:14px;"><?php echo $cierres_caja_sin_cofre; ?></span>
											</span></a>
										<ul id="rventas">
											<?php
											$busq_modulo = in_array('ve_fv_nueva', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ve_fv_nueva',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="v_nuevas_ventas"><a href="<?= site_url('AppIFV/Nueva_Venta')?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M35.19 171.1C-11.72 217.1-11.72 294 35.19 340.9L171.1 476.8C217.1 523.7 294 523.7 340.9 476.8L476.8 340.9C523.7 294 523.7 217.1 476.8 171.1L340.9 35.19C294-11.72 217.1-11.72 171.1 35.19L35.19 171.1zM315.5 315.5C282.6 348.3 229.4 348.3 196.6 315.5C163.7 282.6 163.7 229.4 196.6 196.6C229.4 163.7 282.6 163.7 315.5 196.6C348.3 229.4 348.3 282.6 315.5 315.5z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('ve_fv_lista_venta', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ve_fv_lista_venta',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="ve_fv_lista_venta"><a href="<?= site_url('AppIFV/Lista_Venta')?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('ve_fv_cierres_caja', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ve_fv_cierres_caja',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){ ?>
												<li id="v_cierres_caja"><a href="<?= site_url('AppIFV/Cierre_Caja')?>"><i>
													<svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" 
														data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" 
														d="M480 80C480 53.49 458.5 32 432 32h-288C117.5 32 96 53.49 96 80V384h384V80zM378.9 166.8l-88 112c-4.031 5.156-10 8.438-16.53 9.062C273.6 287.1 272.7 287.1 271.1 287.1c-5.719 0-11.21-2.019-15.58-5.769l-56-48C190.3 225.6 189.2 210.4 197.8 200.4c8.656-10.06 23.81-11.19 33.84-2.594l36.97 31.69l72.53-92.28c8.188-10.41 23.31-12.22 33.69-4.062C385.3 141.3 387.1 156.4 378.9 166.8zM528 288H512v112c0 8.836-7.164 16-16 16h-416C71.16 416 64 408.8 64 400V288H48C21.49 288 0 309.5 0 336v96C0 458.5 21.49 480 48 480h480c26.51 0 48-21.49 48-48v-96C576 309.5 554.5 288 528 288z"/>
													</svg>
													</i><?php echo $modulo[$posicion]['nom_subgrupo']; ?><span style="background-color:red;margin-left:5px;padding:3px;font-size:14px;"><?php echo $cierres_caja_pendientes; ?></span>
														<span style="background-color:orange;margin-left:1px;padding:3px;font-size:14px;"><?php echo $cierres_caja_sin_cofre; ?></span></a></li>
											<?php } 
											?>
										</ul>
									</li>
								<?php } 

								$busq_menu = in_array('configuracion_fv', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('configuracion_fv',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="configuraciones">
										<a href="#rconfiguraciones" id="hconfiguraciones"><i class="icon-cog6" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rconfiguraciones">
											<?php
											$busq_modulo = in_array('conf_fv_admision', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_admision',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="c_admisiones"><a href="<?= site_url('AppIFV/C_Admision')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="22" height="22" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M32 32C32 14.33 46.33 0 64 0H256C273.7 0 288 14.33 288 32C288 49.67 273.7 64 256 64H64C46.33 64 32 49.67 32 32zM0 160C0 124.7 28.65 96 64 96H256C291.3 96 320 124.7 320 160V448C320 483.3 291.3 512 256 512H64C28.65 512 0 483.3 0 448V160zM256 224H64V384H256V224z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('colegio_prov', array_column($modulo, 'nom_menu'));
											$posicion = array_search('colegio_prov',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="colegio_prov"><a href="<?= site_url('AppIFV/Colegio_Prov')?>"><i><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><style>svg{fill:rgba(255, 255, 255, 0.75)}</style><path d="M337.8 5.4C327-1.8 313-1.8 302.2 5.4L166.3 96H48C21.5 96 0 117.5 0 144V464c0 26.5 21.5 48 48 48H592c26.5 0 48-21.5 48-48V144c0-26.5-21.5-48-48-48H473.7L337.8 5.4zM256 416c0-35.3 28.7-64 64-64s64 28.7 64 64v96H256V416zM96 192h32c8.8 0 16 7.2 16 16v64c0 8.8-7.2 16-16 16H96c-8.8 0-16-7.2-16-16V208c0-8.8 7.2-16 16-16zm400 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v64c0 8.8-7.2 16-16 16H512c-8.8 0-16-7.2-16-16V208zM96 320h32c8.8 0 16 7.2 16 16v64c0 8.8-7.2 16-16 16H96c-8.8 0-16-7.2-16-16V336c0-8.8 7.2-16 16-16zm400 16c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16v64c0 8.8-7.2 16-16 16H512c-8.8 0-16-7.2-16-16V336zM232 176a88 88 0 1 1 176 0 88 88 0 1 1 -176 0zm88-48c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16s-7.2-16-16-16H336V144c0-8.8-7.2-16-16-16z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_fv_contratos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_contratos',array_column($modulo,'nom_menu')); 
											
											if($busq_modulo != false){?>
												<li id="c_contratos"><a href="<?= site_url('AppIFV/C_Contrato')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;" ><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											
											$busq_modulo = in_array('conf_fv_documentos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_documentos',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="documentos"><a href="<?= site_url('AppIFV/Documento') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }											
											
											$busq_modulo = in_array('conf_fv_documentos_postulantes', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_documentos_postulantes',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="documentos_postulantes"><a href="<?= site_url('AppIFV/Documento_Postulantes') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }	

											$busq_modulo = in_array('conf_fv_efsrt', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_efsrt', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="configuraciones_efsrt"> 
													<a href="#rconfiguraciones_efsrt" id="hconfiguraciones_efsrt"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconfiguraciones_efsrt">
														<?php
														$busq_submodulo = in_array('conf_efsrt_correo', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_efsrt_correo', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="c_efsrt_correos"><a href="<?= site_url('AppIFV/Correo_Efsrt') ?>"><i class="icon-mail5" style="font-size: 18px;"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>
												</li>
											<?php }
											
											$busq_modulo = in_array('especialidades', array_column($modulo, 'nom_menu'));
											$posicion = array_search('especialidades',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="especialidades"><a href="<?= site_url('AppIFV/Especialidad')?>"><i class="glyphicon glyphicon-check"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 
											
											$busq_modulo = in_array('conf_fv_hora_acad', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_hora_acad',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="conf_fv_hora_acad"><a href="<?= site_url('AppIFV/Horario_Academico') ?>"><i class="glyphicon glyphicon-time"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
			
											$busq_modulo = in_array('conf_fv_hora', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_hora',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="c_hora"><a href="<?= site_url('AppIFV/C_Hora')?>"><i class="glyphicon glyphicon-time"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											
											$busq_modulo = in_array('conf_fv_ifvonline', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_ifvonline', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="configuraciones_ifvonline">
													<a href="#rconfiguraciones_ifvonline" id="hconfiguraciones_ifvonline"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconfiguraciones_ifvonline">
														<?php
														$busq_submodulo = in_array('conf_ifvonline_conta', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_ifvonline_conta', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="conf_ifvonline_conta"><a href="<?= site_url('AppIFV/C_Motivo_Contactenos') ?>"><i class="fa fa-location-arrow"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
											
														$busq_submodulo = in_array('conf_ifvonline_doc', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_ifvonline_doc', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="conf_ifvonline_doc"><a href="<?= site_url('AppIFV/Documento_Configuracion_Ifv') ?>"><i class="fa fa-location-arrow"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('conf_ifv_examen', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_ifv_examen', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="conf_ifv_examen"><a href="<?= site_url('AppIFV/Examen_Efsrt') ?>"><i class="fa fa-location-arrow"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														
														$busq_submodulo = in_array('conf_ifv_ingrcyp', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_ifv_ingrcyp', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="conf_ifv_ingrcyp"><a href="<?= site_url('AppIFV/Ingreso_CalendayPagos') ?>"><i class="fa fa-location-arrow"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('conf_ifv_text', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_ifv_text', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="conf_ifv_text"><a href="<?= site_url('AppIFV/Documento_Configuracion_Texto') ?>"><i class="fa fa-location-arrow"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														?>
													</ul>
												</li>
											<?php }
																						
											$busq_modulo = in_array('conf_fv_mailing', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_mailing',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){ ?> 
												<li id="mailings">
													<a href="<?= site_url('AppIFV/Mailing')?>">
														<i>
															<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512" style="margin:0px auto;" ><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M24 32C10.7 32 0 42.7 0 56V456c0 13.3 10.7 24 24 24H40c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H24zm88 0c-8.8 0-16 7.2-16 16V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H184zm96 0c-13.3 0-24 10.7-24 24V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H280zM448 56V456c0 13.3 10.7 24 24 24h16c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24H472c-13.3 0-24 10.7-24 24zm-64-8V464c0 8.8 7.2 16 16 16s16-7.2 16-16V48c0-8.8-7.2-16-16-16s-16 7.2-16 16z"/></svg>
														</i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
													</a>
												</li>
											<?php } 

											$busq_modulo = in_array('conf_fv_producto', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_producto',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="productos"><a href="<?= site_url('AppIFV/Producto') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M377.74 32H70.26C31.41 32 0 63.41 0 102.26v307.48C0 448.59 31.41 480 70.26 480h307.48c38.52 0 69.76-31.08 70.26-69.6-45.96-25.62-110.59-60.34-171.6-88.44-32.07 43.97-84.14 81-148.62 81-70.59 0-93.73-45.3-97.04-76.37-3.97-39.01 14.88-81.5 99.52-81.5 35.38 0 79.35 10.25 127.13 24.96 16.53-30.09 26.45-60.34 26.45-60.34h-178.2v-16.7h92.08v-31.24H88.28v-19.01h109.44V92.34h50.92v50.42h109.44v19.01H248.63v31.24h88.77s-15.21 46.62-38.35 90.92c48.93 16.7 100.01 36.04 148.62 52.74V102.26C447.83 63.57 416.43 32 377.74 32zM47.28 322.95c.99 20.17 10.25 53.73 69.93 53.73 52.07 0 92.58-39.68 117.87-72.9-44.63-18.68-84.48-31.41-109.44-31.41-67.45 0-79.35 33.06-78.36 50.58z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											/*$busq_modulo = in_array('conf_fv_rrhh', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_rrhh',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="rrhhs"><a href="<?= site_url('AppIFV/Rrhh') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M79 96h130c5.967 0 11.37-3.402 13.75-8.662c2.385-5.262 1.299-11.39-2.754-15.59l-65-67.34c-5.684-5.881-16.31-5.881-21.99 0l-65 67.34C63.95 75.95 62.87 82.08 65.25 87.34C67.63 92.6 73.03 96 79 96zM357 91.59c5.686 5.881 16.31 5.881 21.99 0l65-67.34c4.053-4.199 5.137-10.32 2.754-15.59C444.4 3.402 438.1 0 433 0h-130c-5.967 0-11.37 3.402-13.75 8.662c-2.385 5.262-1.301 11.39 2.752 15.59L357 91.59zM448 128H64c-35.35 0-64 28.65-64 63.1v255.1C0 483.3 28.65 512 64 512h384c35.35 0 64-28.65 64-63.1V192C512 156.7 483.3 128 448 128zM352 224C378.5 224.1 400 245.5 400 272c0 26.46-21.47 47.9-48 48C325.5 319.9 304 298.5 304 272C304 245.5 325.5 224.1 352 224zM160 224C186.5 224.1 208 245.5 208 272c0 26.46-21.47 47.9-48 48C133.5 319.9 112 298.5 112 272C112 245.5 133.5 224.1 160 224zM240 448h-160v-48C80 373.5 101.5 352 128 352h64c26.51 0 48 21.49 48 48V448zM432 448h-160v-48c0-26.51 21.49-48 48-48h64c26.51 0 48 21.49 48 48V448z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } */
											
											$busq_modulo = in_array('conf_fv_salon', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_salon',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="salones"><a href="<?= site_url('AppIFV/Salon') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M88 104C88 95.16 95.16 88 104 88H152C160.8 88 168 95.16 168 104V152C168 160.8 160.8 168 152 168H104C95.16 168 88 160.8 88 152V104zM280 88C288.8 88 296 95.16 296 104V152C296 160.8 288.8 168 280 168H232C223.2 168 216 160.8 216 152V104C216 95.16 223.2 88 232 88H280zM88 232C88 223.2 95.16 216 104 216H152C160.8 216 168 223.2 168 232V280C168 288.8 160.8 296 152 296H104C95.16 296 88 288.8 88 280V232zM280 216C288.8 216 296 223.2 296 232V280C296 288.8 288.8 296 280 296H232C223.2 296 216 288.8 216 280V232C216 223.2 223.2 216 232 216H280zM0 64C0 28.65 28.65 0 64 0H320C355.3 0 384 28.65 384 64V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V64zM48 64V448C48 456.8 55.16 464 64 464H144V400C144 373.5 165.5 352 192 352C218.5 352 240 373.5 240 400V464H320C328.8 464 336 456.8 336 448V64C336 55.16 328.8 48 320 48H64C55.16 48 48 55.16 48 64z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											
											$busq_modulo = in_array('conf_fv_tipo_contrato', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_tipo_contrato',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="tipos_c_contratos"><a href="<?= site_url('AppIFV/Tipo_C_Contrato')?>"><i class="icon-circle-small"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_fv_tipo_documento', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_fv_tipo_documento',array_column($modulo,'nom_menu')); 
												if($busq_modulo != false){?>
												<li id="tipos_c_documento"><a href="<?= site_url('AppIFV/Tipo_Documento')?>"><i class="icon-circle-small"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_fv_ventas', array_column($modulo, 'nom_menu'));
											$posicion=array_search('conf_fv_ventas',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){  ?>  
												<li id="conf_ventas">
													<a href="#rconf_ventas" id="hconf_ventas"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M384 288l64-192h-109.4C308.4 96 281.6 76.66 272 48C262.4 19.33 235.6 0 205.4 0H64l64 288H384zM0 480c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-64H0V480zM480 224h-40.94l-21.33 64H432C440.8 288 448 295.2 448 304S440.8 320 432 320h-352C71.16 320 64 312.8 64 304S71.16 288 80 288h15.22l-14.22-64H32C14.33 224 0 238.3 0 256v128h512V256C512 238.3 497.7 224 480 224z"/></svg></i><span><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span></a>
													<ul id="rconf_ventas">
														<?php
														$busq_submodulo = in_array('conf_ifv_ventas_prod', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_ifv_ventas_prod',array_column($submodulo,'nom_submenu'));
														if($busq_submodulo != false){?>
															<li id="v_productos"><a href="<?= site_url('AppIFV/Producto_Venta')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="20" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M322.1 252v-1l-51.2-65.8s-12 1.6-25 15.1c-9 9.3-242.1 239.1-243.4 240.9-7 10 1.6 6.8 15.7 1.7.8 0 114.5-36.6 114.5-36.6.5-.6-.1-.1.6-.6-.4-5.1-.8-26.2-1-27.7-.6-5.2 2.2-6.9 7-8.9l92.6-33.8c.6-.8 88.5-81.7 90.2-83.3zm160.1 120.1c13.3 16.1 20.7 13.3 30.8 9.3 3.2-1.2 115.4-47.6 117.8-48.9 8-4.3-1.7-16.7-7.2-23.4-2.1-2.5-205.1-245.6-207.2-248.3-9.7-12.2-14.3-12.9-38.4-12.8-10.2 0-106.8.5-116.5.6-19.2.1-32.9-.3-19.2 16.9C250 75 476.5 365.2 482.2 372.1zm152.7 1.6c-2.3-.3-24.6-4.7-38-7.2 0 0-115 50.4-117.5 51.6-16 7.3-26.9-3.2-36.7-14.6l-57.1-74c-5.4-.9-60.4-9.6-65.3-9.3-3.1.2-9.6.8-14.4 2.9-4.9 2.1-145.2 52.8-150.2 54.7-5.1 2-11.4 3.6-11.1 7.6.2 2.5 2 2.6 4.6 3.5 2.7.8 300.9 67.6 308 69.1 15.6 3.3 38.5 10.5 53.6 1.7 2.1-1.2 123.8-76.4 125.8-77.8 5.4-4 4.3-6.8-1.7-8.2z"></path></svg></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php } 

														$busq_submodulo = in_array('conf_ifv_ventas_tipo', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('conf_ifv_ventas_tipo',array_column($submodulo,'nom_submenu'));
														if($busq_submodulo != false){?>
															<li id="v_tipos"><a href="<?= site_url('AppIFV/Tipo_Venta')?>"><i class="icon-circle-small" style="font-size: 20px; left: -5px;"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php } 
														?>
													</ul>
												</li>
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