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
					
					
					<?php $busq_empresa = in_array('6', array_column($list_empresa, 'id_empresa'));
					if($busq_empresa != false){  ?>
						<a class="dropdown" href="<?= site_url('AppIFV') ?>">
							<img src="<?= base_url() ?>template/img/intranetlogoifv-gris.png" class="img-circle" alt="Imagen de Usuario" />
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
								$busq_menu = in_array('configuracion', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('configuracion',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false && ($username == "VHilario" || $username == "PVieira" || $username == "CMedina" || $username == "LQuinones" || $username == "PRuiz" || $username == "Secretario" || $_SESSION['usuario'][0]['id_usuario']==5) ){  ?> 
									<li id="configuracion"  class="menu">
										<a href="#rconfiguracion" id="hconfiguracion" ><i class="icon-cog6"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										
										<ul id="rconfiguracion">
											<?php 
											
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