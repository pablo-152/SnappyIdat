<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$foto = $_SESSION['foto'];
?>
 
<body class="sidebar-xs">
	<div class="navbar navbar-inverse" style="background-color:#65C0E3"> 
		<div class="navbar-header">
		<a class="navbar-brand" href="<?= site_url('Laleli1') ?>"><img src="<?= base_url() ?>template/img/logo2.png" alt=""></a>
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
								<img src="<?= base_url() ?>template/img/intranetlogola.png" class="img-circle" alt="Imagen de Usuario" />
							</a>
						<?php }else{ ?>
							<?php if($_SESSION['usuario'][0]['cod_sede_la']>0){ ?>
								<a class="dropdown" href="<?= site_url('Laleli'.$_SESSION['usuario'][0]['cod_sede_la']) ?>">
									<img src="<?= base_url() ?>template/img/intranetlogola.png" class="img-circle" alt="Imagen de Usuario" />
								</a>
							<?php }else{ ?>
								<a class="dropdown" href="<?= site_url('Laleli') ?>">
									<img src="<?= base_url() ?>template/img/intranetlogola.png" class="img-circle" alt="Imagen de Usuario" />
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
				</ul>

				<ul class="nav navbar-nav" style="margin-top: 5px;"> 
					<select class="form-control" id="nav_cod_sede" name="nav_cod_sede" onchange="Cambiar_Nav_Sede();">
						<?php foreach($list_nav_sede as $list_nav){ ?>
							<option value="<?php echo $list_nav['cod_sede']; ?>" <?php if($list_nav['cod_sede']=="LA1"){ echo "selected"; } ?>>
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
									<a href="<?= site_url('Laleli1/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
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
				<div class="sidebar-content" style="background-color:#65C0E3">
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion" >
								<?php 
								$busq_menu = in_array('ventas_la1', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('ventas_la1',array_column($menu,'nom_grupomenu'));

								if ($busq_menu != false) { ?> 
									<li id="venta">
										<a href="#rventa" id="hventa"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M384 288l64-192h-109.4C308.4 96 281.6 76.66 272 48C262.4 19.33 235.6 0 205.4 0H64l64 288H384zM0 480c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-64H0V480zM480 224h-40.94l-21.33 64H432C440.8 288 448 295.2 448 304S440.8 320 432 320h-352C71.16 320 64 312.8 64 304S71.16 288 80 288h15.22l-14.22-64H32C14.33 224 0 238.3 0 256v128h512V256C512 238.3 497.7 224 480 224z"/></svg></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rventa">
											<?php
											$busq_modulo = in_array('ven_la1_nueva', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ven_la1_nueva', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<?php if(count($valida_punto_venta)>0){ ?>
													<li id="v_nueva"><a href="<?= site_url('Laleli1/Nueva_Venta') ?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M35.19 171.1C-11.72 217.1-11.72 294 35.19 340.9L171.1 476.8C217.1 523.7 294 523.7 340.9 476.8L476.8 340.9C523.7 294 523.7 217.1 476.8 171.1L340.9 35.19C294-11.72 217.1-11.72 171.1 35.19L35.19 171.1zM315.5 315.5C282.6 348.3 229.4 348.3 196.6 315.5C163.7 282.6 163.7 229.4 196.6 196.6C229.4 163.7 282.6 163.7 315.5 196.6C348.3 229.4 348.3 282.6 315.5 315.5z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
												<?php }else{ ?>
													<li id="v_nueva"><a onclick="Mensaje_Error_Punto_Venta();"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M35.19 171.1C-11.72 217.1-11.72 294 35.19 340.9L171.1 476.8C217.1 523.7 294 523.7 340.9 476.8L476.8 340.9C523.7 294 523.7 217.1 476.8 171.1L340.9 35.19C294-11.72 217.1-11.72 171.1 35.19L35.19 171.1zM315.5 315.5C282.6 348.3 229.4 348.3 196.6 315.5C163.7 282.6 163.7 229.4 196.6 196.6C229.4 163.7 282.6 163.7 315.5 196.6C348.3 229.4 348.3 282.6 315.5 315.5z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
												<?php } ?>
											<?php } 

											$busq_modulo = in_array('ven_la1_entregas', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ven_la1_entregas', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?><!--<?= site_url('Laleli1/Entrega_Venta') ?>-->
												<li id="v_entregas"><a href="#"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M256 0C273.7 0 288 14.33 288 32V296.6C307.1 307.6 320 328.3 320 352C320 387.3 291.3 416 256 416C220.7 416 192 387.3 192 352C192 328.3 204.9 307.6 224 296.6V32C224 14.33 238.3 0 256 0zM160 128V352C160 405 202.1 448 256 448C309 448 352 405 352 352V128H464C490.5 128 512 149.5 512 176V464C512 490.5 490.5 512 464 512H48C21.49 512 0 490.5 0 464V176C0 149.5 21.49 128 48 128H160z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('ven_la1_encomiendas', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ven_la1_encomiendas', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="v_encomiendas"><a href="<?= site_url('Laleli1/Encomienda') ?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M256 0C273.7 0 288 14.33 288 32V296.6C307.1 307.6 320 328.3 320 352C320 387.3 291.3 416 256 416C220.7 416 192 387.3 192 352C192 328.3 204.9 307.6 224 296.6V32C224 14.33 238.3 0 256 0zM160 128V352C160 405 202.1 448 256 448C309 448 352 405 352 352V128H464C490.5 128 512 149.5 512 176V464C512 490.5 490.5 512 464 512H48C21.49 512 0 490.5 0 464V176C0 149.5 21.49 128 48 128H160z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php } 

											$busq_modulo = in_array('ven_la1_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ven_la1_lista', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<?php if(count($valida_punto_venta)>0){ ?>
													<li id="v_listas_ventas"><a href="<?= site_url('Laleli1/Venta') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
												<?php }else{ ?>
													<li id="v_listas_ventas"><a onclick="Mensaje_Error_Punto_Venta();"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
												<?php } ?>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('almacen_la1', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('almacen_la1',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){ ?> 
									<li id="almacen">
										<a href="#ralmacen" id="halmacen"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M256 48C256 21.49 277.5 0 304 0H592C618.5 0 640 21.49 640 48V464C640 490.5 618.5 512 592 512H381.3C383 506.1 384 501.6 384 496V253.3C402.6 246.7 416 228.9 416 208V176C416 149.5 394.5 128 368 128H256V48zM571.3 347.3C577.6 341.1 577.6 330.9 571.3 324.7L507.3 260.7C501.1 254.4 490.9 254.4 484.7 260.7L420.7 324.7C414.4 330.9 414.4 341.1 420.7 347.3C426.9 353.6 437.1 353.6 443.3 347.3L480 310.6V432C480 440.8 487.2 448 496 448C504.8 448 512 440.8 512 432V310.6L548.7 347.3C554.9 353.6 565.1 353.6 571.3 347.3H571.3zM0 176C0 167.2 7.164 160 16 160H368C376.8 160 384 167.2 384 176V208C384 216.8 376.8 224 368 224H16C7.164 224 0 216.8 0 208V176zM352 480C352 497.7 337.7 512 320 512H64C46.33 512 32 497.7 32 480V256H352V480zM144 320C135.2 320 128 327.2 128 336C128 344.8 135.2 352 144 352H240C248.8 352 256 344.8 256 336C256 327.2 248.8 320 240 320H144z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="ralmacen">
											<?php 
											$busq_modulo = in_array('alm_la1_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('alm_la1_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="a_listas_almacenes"><a href="<?= site_url('Laleli1/Almacen') ?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?> 
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('contabilidad_la1', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('contabilidad_la1', array_column($menu, 'nom_grupomenu')); ?>
								<?php if ($busq_menu != false) {  ?>
									<li id="contabilidad">
										<a href="#rcontabilidad" id="hcontabilidad"><i class="icon-stats-dots"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcontabilidad"> 
											<?php
											$busq_modulo = in_array('cont_la1_cierres_caja', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cont_la1_cierres_caja', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="c_cierres_cajas"><a href="<?= site_url('Laleli1/Cierre_Caja') ?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M480 80C480 53.49 458.5 32 432 32h-288C117.5 32 96 53.49 96 80V384h384V80zM378.9 166.8l-88 112c-4.031 5.156-10 8.438-16.53 9.062C273.6 287.1 272.7 287.1 271.1 287.1c-5.719 0-11.21-2.019-15.58-5.769l-56-48C190.3 225.6 189.2 210.4 197.8 200.4c8.656-10.06 23.81-11.19 33.84-2.594l36.97 31.69l72.53-92.28c8.188-10.41 23.31-12.22 33.69-4.062C385.3 141.3 387.1 156.4 378.9 166.8zM528 288H512v112c0 8.836-7.164 16-16 16h-416C71.16 416 64 408.8 64 400V288H48C21.49 288 0 309.5 0 336v96C0 458.5 21.49 480 48 480h480c26.51 0 48-21.49 48-48v-96C576 309.5 554.5 288 528 288z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('informes_la1', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('informes_la1',array_column($menu,'nom_grupomenu')); ?>

								<?php if($busq_menu != false){ ?> 
									<li id="informes" class="menu">
										<a href="#rinformes" id="hinformes"><i class="icon-bars-alt"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rinformes"> 
											<?php 
											$busq_modulo = in_array('inf_la1_transferencia', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_la1_transferencia',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="i_transferencias"><a href="<?= site_url('Laleli1/Informe_Transferencia') ?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M384 288l64-192h-109.4C308.4 96 281.6 76.66 272 48C262.4 19.33 235.6 0 205.4 0H64l64 288H384zM0 480c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-64H0V480zM480 224h-40.94l-21.33 64H432C440.8 288 448 295.2 448 304S440.8 320 432 320h-352C71.16 320 64 312.8 64 304S71.16 288 80 288h15.22l-14.22-64H32C14.33 224 0 238.3 0 256v128h512V256C512 238.3 497.7 224 480 224z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
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

			<script>
				function Mensaje_Error_Punto_Venta(){
					Swal({
						title: 'Acceso Denegado',
						text: "¡No se ha creado Punto de Venta para esta sede!",
						type: 'error',
						showCancelButton: false,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'OK',
					});
				}
			</script>

			<div class="content-wrapper">
				<div class="content">
					<div class="row">
						<div class="col-lg-15">