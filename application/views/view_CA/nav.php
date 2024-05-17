<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
?>
 
<style>
	.new-icon {
		width: 17px!important;
		height: 18px!important;
		margin-left: -2px;
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
	<div class="navbar navbar-inverse" style="background-color:#000"> 
		<div class="navbar-header">
		<a class="navbar-brand" href="<?= site_url('Ca') ?>"><img src="<?= base_url() ?>template/img/logo2.png" alt=""></a>
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
							<img src="<?= base_url() ?>template/img/intranetlogoca.png" class="img-circle" alt="Imagen de Usuario" />
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
									<a href="<?= site_url('Ca/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
								</div>
							<?php } ?>
						</div>
					</li>

					<li class="dropdown dropdown-user">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?php if(isset($_SESSION['foto'])) {echo base_url().$_SESSION['foto']; }else{echo  base_url()."template/assets/images/placeholder.jpg"; } ?>"  alt="">
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
				<div class="sidebar-content" style="background-color:#000">
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion" >
							<?php 
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
												<li id="listas">
													<a href="<?= site_url('Ca/Cargo') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
												</li>
											<?php } ?>
										</ul>
									</li>
								<?php }
								 
								$busq_menu = in_array('contabilidad_ca', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('contabilidad_ca',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="contabilidad" class="menu">
										<a href="#rcontabilidad" id="hcontabilidad"><i class="icon-stats-dots"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcontabilidad">
											<?php 
											$busq_modulo = in_array('despesas_ca', array_column($modulo, 'nom_menu'));
											$posicion = array_search('despesas_ca', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<!--<li id="despesas">
													<a href="#rdespesas" id="hdespesas"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-invoice-dollar" class="icon- new-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-153 31V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zM64 72c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8V72zm0 80v-16c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16c0 4.42-3.58 8-8 8H72c-4.42 0-8-3.58-8-8zm144 263.88V440c0 4.42-3.58 8-8 8h-16c-4.42 0-8-3.58-8-8v-24.29c-11.29-.58-22.27-4.52-31.37-11.35-3.9-2.93-4.1-8.77-.57-12.14l11.75-11.21c2.77-2.64 6.89-2.76 10.13-.73 3.87 2.42 8.26 3.72 12.82 3.72h28.11c6.5 0 11.8-5.92 11.8-13.19 0-5.95-3.61-11.19-8.77-12.73l-45-13.5c-18.59-5.58-31.58-23.42-31.58-43.39 0-24.52 19.05-44.44 42.67-45.07V232c0-4.42 3.58-8 8-8h16c4.42 0 8 3.58 8 8v24.29c11.29.58 22.27 4.51 31.37 11.35 3.9 2.93 4.1 8.77.57 12.14l-11.75 11.21c-2.77 2.64-6.89 2.76-10.13.73-3.87-2.43-8.26-3.72-12.82-3.72h-28.11c-6.5 0-11.8 5.92-11.8 13.19 0 5.95 3.61 11.19 8.77 12.73l45 13.5c18.59 5.58 31.58 23.42 31.58 43.39 0 24.53-19.05 44.44-42.67 45.07z"></path></svg>
													<span style="margin-left: -4px;"><?php echo $modulo[$posicion]['nom_subgrupo']; ?></span></a>
													<ul id="rdespesas">
														<?php
														/*$busq_submodulo = in_array('gast_gastos_ca', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('gast_gastos_ca', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="despesas_index"><a href="<?= site_url('Ca/Despesa') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="hand-holding-usd" class="icon- new-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M271.06,144.3l54.27,14.3a8.59,8.59,0,0,1,6.63,8.1c0,4.6-4.09,8.4-9.12,8.4h-35.6a30,30,0,0,1-11.19-2.2c-5.24-2.2-11.28-1.7-15.3,2l-19,17.5a11.68,11.68,0,0,0-2.25,2.66,11.42,11.42,0,0,0,3.88,15.74,83.77,83.77,0,0,0,34.51,11.5V240c0,8.8,7.83,16,17.37,16h17.37c9.55,0,17.38-7.2,17.38-16V222.4c32.93-3.6,57.84-31,53.5-63-3.15-23-22.46-41.3-46.56-47.7L282.68,97.4a8.59,8.59,0,0,1-6.63-8.1c0-4.6,4.09-8.4,9.12-8.4h35.6A30,30,0,0,1,332,83.1c5.23,2.2,11.28,1.7,15.3-2l19-17.5A11.31,11.31,0,0,0,368.47,61a11.43,11.43,0,0,0-3.84-15.78,83.82,83.82,0,0,0-34.52-11.5V16c0-8.8-7.82-16-17.37-16H295.37C285.82,0,278,7.2,278,16V33.6c-32.89,3.6-57.85,31-53.51,63C227.63,119.6,247,137.9,271.06,144.3ZM565.27,328.1c-11.8-10.7-30.2-10-42.6,0L430.27,402a63.64,63.64,0,0,1-40,14H272a16,16,0,0,1,0-32h78.29c15.9,0,30.71-10.9,33.25-26.6a31.2,31.2,0,0,0,.46-5.46A32,32,0,0,0,352,320H192a117.66,117.66,0,0,0-74.1,26.29L71.4,384H16A16,16,0,0,0,0,400v96a16,16,0,0,0,16,16H372.77a64,64,0,0,0,40-14L564,377a32,32,0,0,0,1.28-48.9Z"></path></svg><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php }

														$busq_submodulo = in_array('gast_informe_ca', array_column($submodulo, 'nom_submenu'));
														$posicion = array_search('gast_informe_ca', array_column($submodulo, 'nom_submenu'));
														if ($busq_submodulo != false) { ?>
															<li id="informe_despesas"><a href="<?= site_url('Ca/Informe_Despesa') ?>"><i class="icon-bars-alt"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
														<?php } */?>
													</ul>
												</li>-->
											<?php }  ?>

											<?php
											$busq_submodulo = in_array('gast_gastos_ca', array_column($submodulo, 'nom_submenu'));
											$posicion = array_search('gast_gastos_ca', array_column($submodulo, 'nom_submenu'));
											if($busq_submodulo != false) { ?>
												<li id="despesas_index"><a href="<?= site_url('Ca/Despesa') ?>"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="hand-holding-usd" class="icon- new-icon" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M271.06,144.3l54.27,14.3a8.59,8.59,0,0,1,6.63,8.1c0,4.6-4.09,8.4-9.12,8.4h-35.6a30,30,0,0,1-11.19-2.2c-5.24-2.2-11.28-1.7-15.3,2l-19,17.5a11.68,11.68,0,0,0-2.25,2.66,11.42,11.42,0,0,0,3.88,15.74,83.77,83.77,0,0,0,34.51,11.5V240c0,8.8,7.83,16,17.37,16h17.37c9.55,0,17.38-7.2,17.38-16V222.4c32.93-3.6,57.84-31,53.5-63-3.15-23-22.46-41.3-46.56-47.7L282.68,97.4a8.59,8.59,0,0,1-6.63-8.1c0-4.6,4.09-8.4,9.12-8.4h35.6A30,30,0,0,1,332,83.1c5.23,2.2,11.28,1.7,15.3-2l19-17.5A11.31,11.31,0,0,0,368.47,61a11.43,11.43,0,0,0-3.84-15.78,83.82,83.82,0,0,0-34.52-11.5V16c0-8.8-7.82-16-17.37-16H295.37C285.82,0,278,7.2,278,16V33.6c-32.89,3.6-57.85,31-53.51,63C227.63,119.6,247,137.9,271.06,144.3ZM565.27,328.1c-11.8-10.7-30.2-10-42.6,0L430.27,402a63.64,63.64,0,0,1-40,14H272a16,16,0,0,1,0-32h78.29c15.9,0,30.71-10.9,33.25-26.6a31.2,31.2,0,0,0,.46-5.46A32,32,0,0,0,352,320H192a117.66,117.66,0,0,0-74.1,26.29L71.4,384H16A16,16,0,0,0,0,400v96a16,16,0,0,0,16,16H372.77a64,64,0,0,0,40-14L564,377a32,32,0,0,0,1.28-48.9Z"></path></svg><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
											<?php }

											$busq_submodulo = in_array('gast_informe_ca', array_column($submodulo, 'nom_submenu'));
											$posicion = array_search('gast_informe_ca', array_column($submodulo, 'nom_submenu'));
											if($busq_submodulo != false) { ?>
												<li id="informe_despesas"><a href="<?= site_url('Ca/Informe_Despesa') ?>"><i class="icon-bars-alt"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('saldo_banco_ca', array_column($modulo, 'nom_menu'));
											$posicion = array_search('saldo_banco_ca',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="saldo_bancos"><a href="<?= site_url('Ca/Saldo_Banco') ?>">
												<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="money-check-alt" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M608 32H32C14.33 32 0 46.33 0 64v384c0 17.67 14.33 32 32 32h576c17.67 0 32-14.33 32-32V64c0-17.67-14.33-32-32-32zM176 327.88V344c0 4.42-3.58 8-8 8h-16c-4.42 0-8-3.58-8-8v-16.29c-11.29-.58-22.27-4.52-31.37-11.35-3.9-2.93-4.1-8.77-.57-12.14l11.75-11.21c2.77-2.64 6.89-2.76 10.13-.73 3.87 2.42 8.26 3.72 12.82 3.72h28.11c6.5 0 11.8-5.92 11.8-13.19 0-5.95-3.61-11.19-8.77-12.73l-45-13.5c-18.59-5.58-31.58-23.42-31.58-43.39 0-24.52 19.05-44.44 42.67-45.07V152c0-4.42 3.58-8 8-8h16c4.42 0 8 3.58 8 8v16.29c11.29.58 22.27 4.51 31.37 11.35 3.9 2.93 4.1 8.77.57 12.14l-11.75 11.21c-2.77 2.64-6.89 2.76-10.13.73-3.87-2.43-8.26-3.72-12.82-3.72h-28.11c-6.5 0-11.8 5.92-11.8 13.19 0 5.95 3.61 11.19 8.77 12.73l45 13.5c18.59 5.58 31.58 23.42 31.58 43.39 0 24.53-19.05 44.44-42.67 45.07zM416 312c0 4.42-3.58 8-8 8H296c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h112c4.42 0 8 3.58 8 8v16zm160 0c0 4.42-3.58 8-8 8h-80c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h80c4.42 0 8 3.58 8 8v16zm0-96c0 4.42-3.58 8-8 8H296c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h272c4.42 0 8 3.58 8 8v16z"></path></svg>
												<?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>											
										</ul>
									</li>
								<?php } 
								
								$busq_menu = in_array('documentos_ca', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('documentos_ca',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="documento" class="menu">
										<a href="#rdocumento" id="hdocumento"><i class="icon-file-pdf"></i></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rdocumento">
											<?php 
											$busq_modulo = in_array('doc_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('doc_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="listas"><a href="<?= site_url('Ca/Documento') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php } 

								$busq_menu = in_array('config_ca', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('config_ca',array_column($menu, 'nom_grupomenu')); 

								if($busq_menu != false){?>
									<li id="configcont" class="menu">
										<a href="#rconfigcont" id="hconfigcont"><i class="icon-cog6"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rconfigcont">
											<?php
											$busq_modulo = in_array('conf_rubros_ca', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_rubros_ca',array_column($modulo, 'nom_menu'));
											if($busq_modulo != false){?>
												<li id="rubros">
													<a href="<?= site_url('Ca/Rubro')?>">
														<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="border-none" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M240 224h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-288 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zM240 320h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-96 288h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96-384h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM48 224H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-192H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zm96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
													</a>
												</li>
											<?php }

											$busq_modulo = in_array('conf_sub_rubros_ca', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_sub_rubros_ca',array_column($modulo, 'nom_menu'));
											if($busq_modulo != false){?> 
												<li id="subrubros">
													<a href="<?= site_url('Ca/Subrubro') ?>">
														<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="border-style" class="new-icon icon-" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M240 416h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm192 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-288h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H32A32 32 0 0 0 0 64v400a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V96h368a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
													</a>
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