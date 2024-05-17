<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$foto = $_SESSION['foto'];
$id_sede= '27';
?>
 
<body class="sidebar-xs"> 
	<div class="navbar navbar-inverse" style="background-color:#ac9f79">
		<div class="navbar-header">
		<a class="navbar-brand" href="<?= site_url('CursosCortos') ?>"><img src="<?= base_url() ?>template/img/logo2.png" alt=""></a>
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
							<img src="<?= base_url() ?>template/img/intranetlogoca-gris.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>

					<?php $busq_menu = in_array('15', array_column($menu, 'id_modulo_mae'));
					if ($busq_menu != false) { ?>
						<a class="dropdown" href="<?= site_url('CursosCortos') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogocc.png" class="img-circle" alt="Imagen de Usuario" />
						</a>
					<?php } ?>
				</ul>

				<ul class="nav navbar-nav" style="margin-top: 5px;">
					<select class="form-control" id="nav_cod_sede" name="nav_cod_sede"> 
						<?php foreach($list_nav_sede as $list_nav){ ?>
							<option value="<?php echo $list_nav['cod_sede']; ?>" <?php if($list_nav['cod_sede']=="BL1"){ echo "selected"; } ?>>
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
									<a href="<?= site_url('CursosCortos/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
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
				<div class="sidebar-content" style="background-color:#ac9f79">
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion" >
								<?php 
								$busq_menu = in_array('alumnos_cc', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('alumnos_cc',array_column($menu,'nom_grupomenu'));

								if ($busq_menu != false) { ?>
									<li id="alumnos">
										<a href="#ralumnos" id="halumnos"><i class="icon-collaboration" style="font-size: 18px;"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="ralumnos">
											<?php
											$busq_modulo = in_array('alum_cc_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('alum_cc_lista', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="matriculados"><a href="<?= site_url('CursosCortos/Alumno') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('alum_cc_matricula', array_column($modulo, 'nom_menu'));
											$posicion = array_search('alum_cc_matricula', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?> 
												<!--<li id="matriculas"><a href="<?= site_url('CursosCortos/Matricula') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>-->
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('cliente_cc', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('cliente_cc',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){ ?> 
									<li id="clientes">
										<a href="#rclientes" id="hclientes"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M0 219.2v212.5c0 14.25 11.62 26.25 26.5 27C75.32 461.2 180.2 471.3 240 511.9V245.2C181.4 205.5 79.99 194.8 29.84 192C13.59 191.1 0 203.6 0 219.2zM482.2 192c-50.09 2.848-151.3 13.47-209.1 53.09C272.1 245.2 272 245.3 272 245.5v266.5c60.04-40.39 164.7-50.76 213.5-53.28C500.4 457.9 512 445.9 512 431.7V219.2C512 203.6 498.4 191.1 482.2 192zM352 96c0-53-43-96-96-96S160 43 160 96s43 96 96 96S352 149 352 96z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rclientes">
											<?php 
											$busq_modulo = in_array('cli_cc_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cli_cc_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="listas_clientes"><a href="<?= site_url('CursosCortos/Cliente')?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?> 
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('contabilidad_cc', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('contabilidad_cc', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="contabilidad">
										<a href="#rcontabilidad" id="hcontabilidad"><i class="icon-stats-dots"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcontabilidad"> 
											<?php
											$busq_modulo = in_array('cont_cc_cierres_caja', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cont_cc_cierres_caja', array_column($modulo, 'nom_menu'));
								
											if ($busq_modulo != false) { ?>
												<li id="c_cierres_cajas"><a href="<?= site_url('CursosCortos/Cierre_Caja') ?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M480 80C480 53.49 458.5 32 432 32h-288C117.5 32 96 53.49 96 80V384h384V80zM378.9 166.8l-88 112c-4.031 5.156-10 8.438-16.53 9.062C273.6 287.1 272.7 287.1 271.1 287.1c-5.719 0-11.21-2.019-15.58-5.769l-56-48C190.3 225.6 189.2 210.4 197.8 200.4c8.656-10.06 23.81-11.19 33.84-2.594l36.97 31.69l72.53-92.28c8.188-10.41 23.31-12.22 33.69-4.062C385.3 141.3 387.1 156.4 378.9 166.8zM528 288H512v112c0 8.836-7.164 16-16 16h-416C71.16 416 64 408.8 64 400V288H48C21.49 288 0 309.5 0 336v96C0 458.5 21.49 480 48 480h480c26.51 0 48-21.49 48-48v-96C576 309.5 554.5 288 528 288z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('cont_sunat_cc', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('cont_sunat_cc',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){ ?> 
									<li id="contabilidad_sunat">
										<a href="#rcontabilidad_sunat" id="hcontabilidad_sunat"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M256 96C256 113.7 270.3 128 288 128C305.7 128 320 113.7 320 96V32H394.8C421.9 32 446 49.08 455.1 74.63L572.9 407.2C574.9 413 576 419.2 576 425.4C576 455.5 551.5 480 521.4 480H320V416C320 398.3 305.7 384 288 384C270.3 384 256 398.3 256 416V480H54.61C24.45 480 0 455.5 0 425.4C0 419.2 1.06 413 3.133 407.2L120.9 74.63C129.1 49.08 154.1 32 181.2 32H255.1L256 96zM320 224C320 206.3 305.7 192 288 192C270.3 192 256 206.3 256 224V288C256 305.7 270.3 320 288 320C305.7 320 320 305.7 320 288V224z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcontabilidad_sunat">
											<?php 
											$busq_modulo = in_array('cont_exportacion', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cont_exportacion',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="exportaciones"><a href="<?= site_url('CursosCortos/Exportacion_Bbva')?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="17" height="17" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM140.4 320.2H93.8c-5.5 0-8.7-5.3-6-10.3l49.3-86.7c.1 0 .1-.1 0-.2l-31.4-54c-3-5.6.2-10.1 6-10.1h46.6c5.2 0 9.5 2.9 12.9 8.7l31.9 55.3c-1.3 2.3-18 31.7-50.1 88.2-3.5 6.2-7.7 9.1-12.6 9.1zm219.7-214.1L257.3 286.8v.2l65.5 119c2.8 5.1.1 10.1-6 10.1h-46.6c-5.5 0-9.7-2.9-12.9-8.7l-66-120.3c2.3-4.1 36.8-64.9 103.4-182.3 3.3-5.8 7.4-8.7 12.5-8.7h46.9c5.7-.1 8.8 4.7 6 10z"></path></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('cont_importacion', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cont_importacion',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="importaciones"><a href="#"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="17" height="17" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M248 8C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm171.33 158.6c-15.18 34.51-30.37 69.02-45.63 103.5-2.44 5.51-6.89 8.24-12.97 8.24-23.02-.01-46.03.06-69.05-.05-5.12-.03-8.25 1.89-10.34 6.72-10.19 23.56-20.63 47-30.95 70.5-1.54 3.51-4.06 5.29-7.92 5.29-45.94-.01-91.87-.02-137.81 0-3.13 0-5.63-1.15-7.72-3.45-11.21-12.33-22.46-24.63-33.68-36.94-2.69-2.95-2.79-6.18-1.21-9.73 8.66-19.54 17.27-39.1 25.89-58.66 12.93-29.35 25.89-58.69 38.75-88.08 1.7-3.88 4.28-5.68 8.54-5.65 14.24.1 28.48.02 42.72.05 6.24.01 9.2 4.84 6.66 10.59-13.6 30.77-27.17 61.55-40.74 92.33-5.72 12.99-11.42 25.99-17.09 39-3.91 8.95 7.08 11.97 10.95 5.6.23-.37-1.42 4.18 30.01-67.69 1.36-3.1 3.41-4.4 6.77-4.39 15.21.08 30.43.02 45.64.04 5.56.01 7.91 3.64 5.66 8.75-8.33 18.96-16.71 37.9-24.98 56.89-4.98 11.43 8.08 12.49 11.28 5.33.04-.08 27.89-63.33 32.19-73.16 2.02-4.61 5.44-6.51 10.35-6.5 26.43.05 52.86 0 79.29.05 12.44.02 13.93-13.65 3.9-13.64-25.26.03-50.52.02-75.78.02-6.27 0-7.84-2.47-5.27-8.27 5.78-13.06 11.59-26.11 17.3-39.21 1.73-3.96 4.52-5.79 8.84-5.78 23.09.06 25.98.02 130.78.03 6.08-.01 8.03 2.79 5.62 8.27z"></path></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?> 
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('profesor_cc', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('profesor_cc',array_column($menu,'nom_grupomenu')); ?>

								<?php if($busq_menu != false){  ?> 
									<li id="profesor" class="menu">
										<a href="#rprofesor" id="hprofesor"><i class="icon-user-plus"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rprofesor">
											<?php 
											$busq_modulo = in_array('pro_cc_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('pro_cc_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="listas_profesor"><a href="<?= site_url('CursosCortos/Profesor') ?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php } 

								$busq_menu = in_array('informe_cc', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('informe_cc', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="informes">  
										<a href="#rinformes" id="hinformes"><i class="icon-bars-alt" style="font-size: 18px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rinformes">
											<?php
											$busq_modulo = in_array('inf_cc_doc_alum', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_cc_doc_alum', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="doc_alumnos"><a href="<?= site_url('CursosCortos/Doc_Alumno') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('inf_cc_retirados', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_cc_retirados',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){ ?> 
												<li id="retirados"><a href="<?= site_url('CursosCortos/Retirados')?>"><i class="icon-users4"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 
											$busq_modulo = in_array('inf_cc_alum_obs', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_cc_alum_obs',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<li id="alumnos_obs"><a href="<?= site_url('CursosCortos/Alumno_Obs') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="25" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('colaboradores_cc', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('colaboradores_cc',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="colaboradores">
										<a href="#rcolaboradores" id="hcolaboradores"><i class="icon-user-plus" style="font-size: 19px;"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcolaboradores">
											<?php
											$busq_modulo = in_array('col_cc_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('col_cc_lista',array_column($modulo,'nom_menu'));
											if($busq_modulo != false){?>
												<!--<li id="colaboradores_lista"><a href="<?= site_url('CursosCortos/Colaborador')?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>-->
												<li id="colaboradores_lista"><a href="<?= site_url('Colaborador/Colaborador')?>/27"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>

											<?php }  

											$busq_modulo = in_array('conf_cc_cargo_fotocheck', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_cc_cargo_fotocheck',array_column($modulo,'nom_menu')); 
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
											?>
										</ul>
									</li>

								<?php } 
								
								$busq_menu = in_array('configuracion_cc', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('configuracion_cc',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="configuracion" class="menu">
										<a href="#rconfiguracion" id="hconfiguracion" ><i class="icon-cog6"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rconfiguracion">
											<?php 
											$busq_modulo = in_array('conf_cc_grado', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_cc_grado', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="grados"><a href="<?= site_url('CursosCortos/Grado') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="17" height="17" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M208 352c-2.39 0-4.78.35-7.06 1.09C187.98 357.3 174.35 360 160 360c-14.35 0-27.98-2.7-40.95-6.91-2.28-.74-4.66-1.09-7.05-1.09C49.94 352-.33 402.48 0 464.62.14 490.88 21.73 512 48 512h224c26.27 0 47.86-21.12 48-47.38.33-62.14-49.94-112.62-112-112.62zm-48-32c53.02 0 96-42.98 96-96s-42.98-96-96-96-96 42.98-96 96 42.98 96 96 96zM592 0H208c-26.47 0-48 22.25-48 49.59V96c23.42 0 45.1 6.78 64 17.8V64h352v288h-64v-64H384v64h-76.24c19.1 16.69 33.12 38.73 39.69 64H592c26.47 0 48-22.25 48-49.59V49.59C640 22.25 618.47 0 592 0z"></path></svg></i><?php if($menu[$posicion]['nom_modulo_grupo'] = 'Grado') echo 'Cursos'; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_cc_seccion', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_cc_seccion', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="secciones"><a href="<?= site_url('CursosCortos/Seccion') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="17" height="17" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M560 448H480V50.75C480 22.75 458.5 0 432 0h-288C117.5 0 96 22.75 96 50.75V448H16C7.125 448 0 455.1 0 464v32C0 504.9 7.125 512 16 512h544c8.875 0 16-7.125 16-16v-32C576 455.1 568.9 448 560 448zM384 288c-17.62 0-32-14.38-32-32s14.38-32 32-32s32 14.38 32 32S401.6 288 384 288z"></path></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_art', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_art',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="articulos"><a href="<?= site_url('CursosCortos/Articulo') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M159.7 237.4C108.4 308.3 43.1 348.2 14 326.6-15.2 304.9 2.8 230 54.2 159.1c51.3-70.9 116.6-110.8 145.7-89.2 29.1 21.6 11.1 96.6-40.2 167.5zm351.2-57.3C437.1 303.5 319 367.8 246.4 323.7c-25-15.2-41.3-41.2-49-73.8-33.6 64.8-92.8 113.8-164.1 133.2 49.8 59.3 124.1 96.9 207 96.9 150 0 271.6-123.1 271.6-274.9.1-8.5-.3-16.8-1-25z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_pro', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_pro',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="productos"><a href="<?= site_url('CursosCortos/Producto') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="19" height="24" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M322.1 252v-1l-51.2-65.8s-12 1.6-25 15.1c-9 9.3-242.1 239.1-243.4 240.9-7 10 1.6 6.8 15.7 1.7.8 0 114.5-36.6 114.5-36.6.5-.6-.1-.1.6-.6-.4-5.1-.8-26.2-1-27.7-.6-5.2 2.2-6.9 7-8.9l92.6-33.8c.6-.8 88.5-81.7 90.2-83.3zm160.1 120.1c13.3 16.1 20.7 13.3 30.8 9.3 3.2-1.2 115.4-47.6 117.8-48.9 8-4.3-1.7-16.7-7.2-23.4-2.1-2.5-205.1-245.6-207.2-248.3-9.7-12.2-14.3-12.9-38.4-12.8-10.2 0-106.8.5-116.5.6-19.2.1-32.9-.3-19.2 16.9C250 75 476.5 365.2 482.2 372.1zm152.7 1.6c-2.3-.3-24.6-4.7-38-7.2 0 0-115 50.4-117.5 51.6-16 7.3-26.9-3.2-36.7-14.6l-57.1-74c-5.4-.9-60.4-9.6-65.3-9.3-3.1.2-9.6.8-14.4 2.9-4.9 2.1-145.2 52.8-150.2 54.7-5.1 2-11.4 3.6-11.1 7.6.2 2.5 2 2.6 4.6 3.5 2.7.8 300.9 67.6 308 69.1 15.6 3.3 38.5 10.5 53.6 1.7 2.1-1.2 123.8-76.4 125.8-77.8 5.4-4 4.3-6.8-1.7-8.2z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_cc_documento', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_cc_documento',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="documentos"><a href="<?= site_url('CursosCortos/Documento') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }									

											$busq_modulo = in_array('conf_cc_mailing', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_cc_mailing',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="mailing"><a href="<?= site_url('CursosCortos/Mailing') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="23" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor"d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>

										</ul>
									</li>
								<?php } 

								$busq_menu = in_array('soporte_cc_docs', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('soporte_cc_docs',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){  ?> 
									<li id="soporte_docs"> 
										<a href="#rsoporte_docs" id="hsoporte_docs"><i><svg xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;" aria-hidden="true" width="20" height="25" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M192 0H48C21.5 0 0 21.5 0 48V368c0 26.5 21.5 48 48 48H162.7c6.6-18.6 24.4-32 45.3-32V272c0-44.2 35.8-80 80-80h32V128H224c-17.7 0-32-14.3-32-32V0zm96 224c-26.5 0-48 21.5-48 48v16 96 32H208c-8.8 0-16 7.2-16 16v16c0 35.3 28.7 64 64 64H576c35.3 0 64-28.7 64-64V432c0-8.8-7.2-16-16-16H592V288c0-35.3-28.7-64-64-64H320 304 288zm32 64H528V416H304V288h16zM224 0V96h96L224 0z"/></svg></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rsoporte_docs">
											<?php 
											$busq_modulo = in_array('sop_cc_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('sop_cc_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="soporte_docs_listas"><a href="<?= site_url('CursosCortos/Soporte_Doc') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('comercial_cc', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('comercial_cc', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="comercial">
										<a href="#rcomercial" id="hcomercial"><i class="icon-cart"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcomercial">
											<?php
											$busq_modulo = in_array('registro_cc', array_column($modulo, 'nom_menu'));
											$posicion = array_search('registro_cc', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="registro"><a href="<?= site_url('CursosCortos/Registro') ?>">
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

											$busq_modulo = in_array('conf_cc', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_cc', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="sconfig_comercial">
													<a href="#rconfig_comercial" id="hconfig_comercial"><i class="icon-cog6"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a>
													<ul id="rconfig_comercial">
														<?php
															$busq_submodulo = in_array('prod_interese', array_column($submodulo, 'nom_submenu'));
															$posicion = array_search('prod_interese', array_column($submodulo, 'nom_submenu'));
															if ($busq_submodulo != false) { ?>
																<li id="producto_interese"><a href="<?= site_url('CursosCortos/Producto_Interes') ?>"><i class="icon-bag"></i><?php echo $submodulo[$posicion]['nom_sub_subgrupo']; ?></a></li>
															<?php }
														?>
													</ul>
												</li>
											<?php } ?>
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