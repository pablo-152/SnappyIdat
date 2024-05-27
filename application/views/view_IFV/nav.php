<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];

$id_sede= '9';
?>
<body class="sidebar-xs">


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
					
					
					
						<a class="dropdown" href="<?= site_url('AppIFV') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogoifv.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
			

				</ul>



				<ul class="nav navbar-nav">
					<li id="cargar_nav" class="dropdown">
						
						
						<div class="dropdown-menu dropdown-content width-350">
							<div class="dropdown-content-heading">
								Notificaciones
							</div>

							

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

							<li class="divider"></li>
							<li><a href="<?= site_url('login/logout') ?>"><i class="icon-switch2"></i> Salir</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="page-container">
		<div class="page-content">
			<div class="sidebar sidebar-main sidebar-fixed">
				<div class="sidebar-content" style="background-color:#c37413;">
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
											<?php }?>
										</ul>
									</li>
								<?php }
															
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
											
											?> 
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
												<li id="doc_alumnos"><a href="<?= site_url('AppIFV/Doc_Alumno') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } ?>
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
											<span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
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
											<?php } ?>
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
				</div>
			</div>
			
			<div class="content-wrapper">
				<div class="content">
					<div class="row">
						<div class="col-lg-15">