<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$username = $sesion['usuario_codigo'];
$foto = $_SESSION['foto'];
?>
 
<body class="sidebar-xs">

	<div class="navbar navbar-inverse" style="background-color:#6c757d">
		<div class="navbar-header">
		<a class="navbar-brand" href="<?= site_url('General') ?>"><img src="<?= base_url() ?>template/img/logo2.png" alt=""></a> 

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
					if($busq_menu != false) { ?>
						<a class="dropdown" href="<?= site_url('General') ?>">
							<img src="<?= base_url() ?>template/img/estrella.png" class="img-circle" alt="Imagen de Usuario" />
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
							<img src="<?= base_url() ?>template/img/intranetlogoifv-gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_empresa = in_array('7', array_column($list_empresa, 'id_empresa'));
					if($busq_empresa != false){ ?>

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
									<a href="<?= site_url('General/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
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
				<div class="sidebar-content" style="background-color:#5d656b">


					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion" >
								
							<?php
								$busq_menu = in_array('soporte_ti', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('soporte_ti',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="soporteti">
										<a href="#rsoporteti" id="hsoporteti"><i class="icon-lifebuoy"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rsoporteti">
											<?php 
											$busq_modulo = in_array('ticket', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ticket',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="tickets"><a href="<?= site_url('General/Ticket') ?>"><i class="icon-ticket"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('informe_ticket', array_column($modulo, 'nom_menu'));
											$posicion = array_search('informe_ticket',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="informeti">
													<a href="#rinformeti" id="hinformeti"><i class="icon-bars-alt"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rinformeti">
														<?php
														$busq_submodulo = in_array('lista_general', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('lista_general',array_column($submodulo,'nom_submenu'));
														if($busq_submodulo != false){?>
															<li id="hlist_informe"><a href="<?= site_url('General/Informe') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														
														$busq_submodulo = in_array('busqueda_general', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('busqueda_general',array_column($submodulo,'nom_submenu'));
														if($busq_submodulo != false){?>
															<li id="hbusqueda_informe"><a href="<?= site_url('General/Busqueda') ?>"><i class="icon-search4"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														?>	
													</ul>
												</li>
											<?php }

											$busq_modulo = in_array('config_ti', array_column($modulo, 'nom_menu'));
											$posicion = array_search('config_ti',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="configsoporteti">
													<a href="#rconfigsoporteti" id="hconfigsoporteti"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconfigsoporteti">
														<?php
														$busq_submodulo = in_array('proyectos_ti', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('proyectos_ti',array_column($submodulo,'nom_submenu'));
														if($busq_submodulo != false){?>
															<li id="proyectos"><a href="<?= site_url('General/Soporte_Proyecto') ?>"><i class="icon-cube4"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }
														
														$busq_submodulo = in_array('sub_proyecto_ti', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('sub_proyecto_ti',array_column($submodulo,'nom_submenu'));
														if($busq_submodulo != false){?>
															<li id="subproyectos"><a href="<?= site_url('General/Soporte_Subproyecto') ?>"><i class="icon-cube3"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														?>
														
														
													</ul>
												</li>
											<?php }?>

											<!--<li><a href="datatable_extension_colvis.html">Columns visibility</a></li>-->
										</ul>
									</li>
								<?php }	

								$busq_menu = in_array('soporte_docs', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('soporte_docs',array_column($menu,'nom_grupomenu'));?> 
								<?php if($busq_menu != false){  ?> 
									<li id="soporte_docs">
										<a href="#rsoporte_docs" id="hsoporte_docs"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M192 0H48C21.5 0 0 21.5 0 48V368c0 26.5 21.5 48 48 48H162.7c6.6-18.6 24.4-32 45.3-32V272c0-44.2 35.8-80 80-80h32V128H224c-17.7 0-32-14.3-32-32V0zm96 224c-26.5 0-48 21.5-48 48v16 96 32H208c-8.8 0-16 7.2-16 16v16c0 35.3 28.7 64 64 64H576c35.3 0 64-28.7 64-64V432c0-8.8-7.2-16-16-16H592V288c0-35.3-28.7-64-64-64H320 304 288zm32 64H528V416H304V288h16zM224 0V96h96L224 0z"/></svg></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rsoporte_docs">
											<?php 
											$busq_modulo = in_array('sop_gen_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('sop_gen_lista',array_column($modulo,'nom_menu')); 
								
											if($busq_modulo != false){?>
												<li id="soporte_docs_listas"><a href="<?= site_url('General/Soporte_Doc') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }	
								
								$busq_menu = in_array('configuracion', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('configuracion',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false && ($username == "VHilario" || $username == "PVieira" || $username == "CMedina" || $username == "LQuinones" || $username == "PRuiz" || $username == "Secretario" || $_SESSION['usuario'][0]['id_usuario']==5) ){  ?> 
									<li id="configuracion"  class="menu">
										<a href="#rconfiguracion" id="hconfiguracion" ><i class="icon-cog6"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										
										<ul id="rconfiguracion">
											<?php 
											$busq_modulo = in_array('festivo_fecha', array_column($modulo, 'nom_menu'));
											$posicion = array_search('festivo_fecha',array_column($modulo,'nom_menu')); 							
											if($busq_modulo != false){?>
												<li id="festivo"><a href="<?= site_url('General/Festivo') ?>"><i class="icon-calendar2"></i><?php echo substr($modulo[$posicion]['nom_subgrupo'],0,25); ?></a></li>
											<?php }
																						
											$busq_modulo = in_array('fondo_extranet', array_column($modulo, 'nom_menu'));
											$posicion = array_search('fondo_extranet',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="fondos_extranet"><a href="<?= site_url('General/Fondo_Extranet') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="22" height="20" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M528 32H144c-26.51 0-48 21.49-48 48v256c0 26.51 21.49 48 48 48H528c26.51 0 48-21.49 48-48v-256C576 53.49 554.5 32 528 32zM223.1 96c17.68 0 32 14.33 32 32S241.7 160 223.1 160c-17.67 0-32-14.33-32-32S206.3 96 223.1 96zM494.1 311.6C491.3 316.8 485.9 320 480 320H192c-6.023 0-11.53-3.379-14.26-8.75c-2.73-5.367-2.215-11.81 1.332-16.68l70-96C252.1 194.4 256.9 192 262 192c5.111 0 9.916 2.441 12.93 6.574l22.35 30.66l62.74-94.11C362.1 130.7 367.1 128 373.3 128c5.348 0 10.34 2.672 13.31 7.125l106.7 160C496.6 300 496.9 306.3 494.1 311.6zM456 432H120c-39.7 0-72-32.3-72-72v-240C48 106.8 37.25 96 24 96S0 106.8 0 120v240C0 426.2 53.83 480 120 480h336c13.25 0 24-10.75 24-24S469.3 432 456 432z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											
											$busq_modulo = in_array('fondo_snappy', array_column($modulo, 'nom_menu'));
											$posicion = array_search('fondo_snappy',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="fondo_s"><a href="<?= site_url('General/Fondo_snappy') ?>"><i class="icon-image2"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('empresa', array_column($modulo, 'nom_menu'));
											$posicion = array_search('empresa',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="empresa"><a href="<?= site_url('General/Empresas') ?>"><i class="icon-quotes-left2"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											
											$busq_modulo = in_array('notificaciones', array_column($modulo, 'nom_menu'));
											$posicion = array_search('notificaciones',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="aviso"><a href="<?= site_url('General/Aviso') ?>"><i class="icon-bell3"></i>
												<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('prod_interese', array_column($modulo, 'nom_menu'));
											$posicion = array_search('prod_interese', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="productos_intereses"><a href="<?= site_url('General/Producto_Interes') ?>"><i class="icon-bag"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('rrhh', array_column($modulo, 'nom_menu'));
											$posicion = array_search('rrhh',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="rrhh" ><a href="<?= site_url('General/RRHH') ?>" style="flex items-center"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M79 96h130c5.967 0 11.37-3.402 13.75-8.662c2.385-5.262 1.299-11.39-2.754-15.59l-65-67.34c-5.684-5.881-16.31-5.881-21.99 0l-65 67.34C63.95 75.95 62.87 82.08 65.25 87.34C67.63 92.6 73.03 96 79 96zM357 91.59c5.686 5.881 16.31 5.881 21.99 0l65-67.34c4.053-4.199 5.137-10.32 2.754-15.59C444.4 3.402 438.1 0 433 0h-130c-5.967 0-11.37 3.402-13.75 8.662c-2.385 5.262-1.301 11.39 2.752 15.59L357 91.59zM448 128H64c-35.35 0-64 28.65-64 63.1v255.1C0 483.3 28.65 512 64 512h384c35.35 0 64-28.65 64-63.1V192C512 156.7 483.3 128 448 128zM352 224C378.5 224.1 400 245.5 400 272c0 26.46-21.47 47.9-48 48C325.5 319.9 304 298.5 304 272C304 245.5 325.5 224.1 352 224zM160 224C186.5 224.1 208 245.5 208 272c0 26.46-21.47 47.9-48 48C133.5 319.9 112 298.5 112 272C112 245.5 133.5 224.1 160 224zM240 448h-160v-48C80 373.5 101.5 352 128 352h64c26.51 0 48 21.49 48 48V448zM432 448h-160v-48c0-26.51 21.49-48 48-48h64c26.51 0 48 21.49 48 48V448z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('sedes', array_column($modulo, 'nom_menu'));
											$posicion = array_search('sedes',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="sedes"><a href="<?= site_url('General/Sedes') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="19" height="19" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M128 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32zm-24-80h192v48h48v-48h192v48h48v-57.59c0-21.17-17.23-38.41-38.41-38.41H344v-64h40c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32H256c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h40v64H94.41C73.23 224 56 241.23 56 262.41V320h48v-48zm264 80h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32zm240 0h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('semanas', array_column($modulo, 'nom_menu'));
											$posicion = array_search('semanas',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="semanas"><a href="<?= site_url('General/Semanas') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="19" height="19" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M128 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32zm-24-80h192v48h48v-48h192v48h48v-57.59c0-21.17-17.23-38.41-38.41-38.41H344v-64h40c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32H256c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h40v64H94.41C73.23 224 56 241.23 56 262.41V320h48v-48zm264 80h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32zm240 0h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('sms_automatizado', array_column($modulo, 'nom_menu'));
											$posicion = array_search('sms_automatizado',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="sms_automatizados"><a href="<?= site_url('General/Sms_Automatizado') ?>"><i class="icon-comments"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('tipo_comercial', array_column($modulo, 'nom_menu'));
											$posicion = array_search('tipo_comercial', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="tipos_comercial"><a href="<?= site_url('General/Tipo_Comercial') ?>"><i class="icon-circle-small"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('usuario', array_column($modulo, 'nom_menu'));
											$posicion = array_search('usuario',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="usuario" ><a href="<?= site_url('General/Usuario') ?>"><i class="icon-user-plus" style="font-size: 18px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('usuario_acceso', array_column($modulo, 'nom_menu'));
											$posicion = array_search('usuario_acceso',array_column($modulo,'nom_menu')); 
											if($busq_modulo != false){?>
												<li id="usuario_acceso"><a href="<?= site_url('General/Usuario_Configuracion') ?>"><i class="icon-user-lock" style="font-size: 18px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li> 
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