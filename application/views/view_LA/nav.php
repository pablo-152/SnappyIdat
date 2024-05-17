<?php $sesion =  $_SESSION['usuario'][0];
$id_nivel = $sesion['id_nivel'];
$foto = $_SESSION['foto'];
?>
 
<body class="sidebar-xs">
	<div class="navbar navbar-inverse" style="background-color:#65C0E3"> 
		<div class="navbar-header">
		<a class="navbar-brand" href="<?= site_url('Laleli') ?>"><img src="<?= base_url() ?>template/img/logo2.png" alt=""></a>
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
							<option value="<?php echo $list_nav['cod_sede']; ?>" <?php if($list_nav['cod_sede']=="LA0"){ echo "selected"; } ?>>
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
									<a href="<?= site_url('Laleli/Detalle_Aviso') ?>" data-popup="tooltip" title="Todos las notificaciones"><i class="icon-menu display-block"></i></a>
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
								$busq_menu = in_array('ventas_la', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('ventas_la',array_column($menu,'nom_grupomenu')); 

								if ($busq_menu != false) { ?> 
									<li id="venta">
										<a href="#rventa" id="hventa"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M384 288l64-192h-109.4C308.4 96 281.6 76.66 272 48C262.4 19.33 235.6 0 205.4 0H64l64 288H384zM0 480c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-64H0V480zM480 224h-40.94l-21.33 64H432C440.8 288 448 295.2 448 304S440.8 320 432 320h-352C71.16 320 64 312.8 64 304S71.16 288 80 288h15.22l-14.22-64H32C14.33 224 0 238.3 0 256v128h512V256C512 238.3 497.7 224 480 224z"/></svg></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rventa"> 
											<?php
											$busq_modulo = in_array('ven_la_entregas', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ven_la_entregas', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?><!--<?= site_url('Laleli/Entrega_Venta') ?>-->
												<li id="v_entregas"><a href="#"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M256 0C273.7 0 288 14.33 288 32V296.6C307.1 307.6 320 328.3 320 352C320 387.3 291.3 416 256 416C220.7 416 192 387.3 192 352C192 328.3 204.9 307.6 224 296.6V32C224 14.33 238.3 0 256 0zM160 128V352C160 405 202.1 448 256 448C309 448 352 405 352 352V128H464C490.5 128 512 149.5 512 176V464C512 490.5 490.5 512 464 512H48C21.49 512 0 490.5 0 464V176C0 149.5 21.49 128 48 128H160z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('ven_la_encomiendas', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ven_la_encomiendas', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="v_encomiendas"><a href="<?= site_url('Laleli/Encomienda') ?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M256 0C273.7 0 288 14.33 288 32V296.6C307.1 307.6 320 328.3 320 352C320 387.3 291.3 416 256 416C220.7 416 192 387.3 192 352C192 328.3 204.9 307.6 224 296.6V32C224 14.33 238.3 0 256 0zM160 128V352C160 405 202.1 448 256 448C309 448 352 405 352 352V128H464C490.5 128 512 149.5 512 176V464C512 490.5 490.5 512 464 512H48C21.49 512 0 490.5 0 464V176C0 149.5 21.49 128 48 128H160z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?><span style="background-color:red;margin-left:20px;padding:3px;font-size:14px;"><?php echo $encomiendas_pendientes; ?></span></a></li>
											<?php }

											$busq_modulo = in_array('ven_la_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ven_la_lista', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="v_listas_ventas"><a href="<?= site_url('Laleli/Venta') ?>"><i class="glyphicon glyphicon-list"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('ven_la_devoluciones', array_column($modulo, 'nom_menu'));
											$posicion = array_search('ven_la_devoluciones', array_column($modulo, 'nom_menu'));
											if ($busq_modulo != false) { ?>
												<li id="v_devoluciones"><a href="<?= site_url('Laleli/Devolucion') ?>"><i class="icon-coin-dollar x1"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('almacen_la', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('almacen_la',array_column($menu,'nom_grupomenu'));?>
								<?php if($busq_menu != false){ ?> 
									<li id="almacen">
										<a href="#ralmacen" id="halmacen"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M256 48C256 21.49 277.5 0 304 0H592C618.5 0 640 21.49 640 48V464C640 490.5 618.5 512 592 512H381.3C383 506.1 384 501.6 384 496V253.3C402.6 246.7 416 228.9 416 208V176C416 149.5 394.5 128 368 128H256V48zM571.3 347.3C577.6 341.1 577.6 330.9 571.3 324.7L507.3 260.7C501.1 254.4 490.9 254.4 484.7 260.7L420.7 324.7C414.4 330.9 414.4 341.1 420.7 347.3C426.9 353.6 437.1 353.6 443.3 347.3L480 310.6V432C480 440.8 487.2 448 496 448C504.8 448 512 440.8 512 432V310.6L548.7 347.3C554.9 353.6 565.1 353.6 571.3 347.3H571.3zM0 176C0 167.2 7.164 160 16 160H368C376.8 160 384 167.2 384 176V208C384 216.8 376.8 224 368 224H16C7.164 224 0 216.8 0 208V176zM352 480C352 497.7 337.7 512 320 512H64C46.33 512 32 497.7 32 480V256H352V480zM144 320C135.2 320 128 327.2 128 336C128 344.8 135.2 352 144 352H240C248.8 352 256 344.8 256 336C256 327.2 248.8 320 240 320H144z"/></svg></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="ralmacen">
											<?php 
											$busq_modulo = in_array('alm_la_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('alm_la_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="a_listas_almacenes"><a href="<?= site_url('Laleli/Almacen') ?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?> 
										</ul>
									</li>
								<?php }
									
								$busq_menu = in_array('stock_la', array_column($menu, 'nom_grupomenu')); 
								$posicion=array_search('stock_la',array_column($menu,'nom_grupomenu')); ?> 
								<?php if($busq_menu != false){ ?> 
									<li id="stocks">
										<a href="#rstocks" id="hstocks"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M451.46,244.71H576V172H451.46Zm0-173.89v72.67H576V70.82Zm0,275.06H576V273.2H451.46ZM0,447.09H124.54V374.42H0Zm150.47,0H275V374.42H150.47Zm150.52,0H425.53V374.42H301Zm150.47,0H576V374.42H451.46ZM301,345.88H425.53V273.2H301Zm-150.52,0H275V273.2H150.47Zm0-101.17H275V172H150.47Z"/></svg></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rstocks">
											<?php 
											$busq_modulo = in_array('sto_la_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('sto_la_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="s_listas_stocks"><a href="<?= site_url('Laleli/Stock') ?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?> 
										</ul> 
									</li>
								<?php }

								$busq_menu = in_array('compras_la', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('compras_la',array_column($menu,'nom_grupomenu')); ?>

								<?php if($busq_menu != false){  ?> 
									<li id="compra" class="menu">
										<a href="#rcompra" id="hcompra"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M288 0C305.7 0 320 14.33 320 32V96C320 113.7 305.7 128 288 128H208V160H424.1C456.6 160 483.5 183.1 488.2 214.4L510.9 364.1C511.6 368.8 512 373.6 512 378.4V448C512 483.3 483.3 512 448 512H64C28.65 512 0 483.3 0 448V378.4C0 373.6 .3622 368.8 1.083 364.1L23.76 214.4C28.5 183.1 55.39 160 87.03 160H143.1V128H63.1C46.33 128 31.1 113.7 31.1 96V32C31.1 14.33 46.33 0 63.1 0L288 0zM96 48C87.16 48 80 55.16 80 64C80 72.84 87.16 80 96 80H256C264.8 80 272 72.84 272 64C272 55.16 264.8 48 256 48H96zM80 448H432C440.8 448 448 440.8 448 432C448 423.2 440.8 416 432 416H80C71.16 416 64 423.2 64 432C64 440.8 71.16 448 80 448zM112 216C98.75 216 88 226.7 88 240C88 253.3 98.75 264 112 264C125.3 264 136 253.3 136 240C136 226.7 125.3 216 112 216zM208 264C221.3 264 232 253.3 232 240C232 226.7 221.3 216 208 216C194.7 216 184 226.7 184 240C184 253.3 194.7 264 208 264zM160 296C146.7 296 136 306.7 136 320C136 333.3 146.7 344 160 344C173.3 344 184 333.3 184 320C184 306.7 173.3 296 160 296zM304 264C317.3 264 328 253.3 328 240C328 226.7 317.3 216 304 216C290.7 216 280 226.7 280 240C280 253.3 290.7 264 304 264zM256 296C242.7 296 232 306.7 232 320C232 333.3 242.7 344 256 344C269.3 344 280 333.3 280 320C280 306.7 269.3 296 256 296zM400 264C413.3 264 424 253.3 424 240C424 226.7 413.3 216 400 216C386.7 216 376 226.7 376 240C376 253.3 386.7 264 400 264zM352 296C338.7 296 328 306.7 328 320C328 333.3 338.7 344 352 344C365.3 344 376 333.3 376 320C376 306.7 365.3 296 352 296z"/></svg></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcompra">
											<?php 
											$busq_modulo = in_array('com_la_lista', array_column($modulo, 'nom_menu'));
											$posicion = array_search('com_la_lista',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="c_listas_compras"><a href="<?= site_url('Laleli/Compra') ?>"><i class="glyphicon glyphicon-list" style="font-size: 15px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php } 

								$busq_menu = in_array('contabilidad_la', array_column($menu, 'nom_grupomenu'));
								$posicion = array_search('contabilidad_la', array_column($menu, 'nom_grupomenu')); ?> 
								<?php if ($busq_menu != false) {  ?>
									<li id="contabilidad">
										<a href="#rcontabilidad" id="hcontabilidad"><i class="icon-stats-dots"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rcontabilidad">
											<?php
											$busq_modulo = in_array('cont_la_cierres_caja', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cont_la_cierres_caja', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?> 
												<li id="c_cierres_cajas">
													<a href="<?= site_url('Laleli/Cierre_Caja') ?>">
														<i>
															<svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512">
																<path fill="currentColor" d="M480 80C480 53.49 458.5 32 432 32h-288C117.5 32 96 53.49 96 80V384h384V80zM378.9 166.8l-88 112c-4.031 5.156-10 8.438-16.53 9.062C273.6 287.1 272.7 287.1 271.1 287.1c-5.719 0-11.21-2.019-15.58-5.769l-56-48C190.3 225.6 189.2 210.4 197.8 200.4c8.656-10.06 23.81-11.19 33.84-2.594l36.97 31.69l72.53-92.28c8.188-10.41 23.31-12.22 33.69-4.062C385.3 141.3 387.1 156.4 378.9 166.8zM528 288H512v112c0 8.836-7.164 16-16 16h-416C71.16 416 64 408.8 64 400V288H48C21.49 288 0 309.5 0 336v96C0 458.5 21.49 480 48 480h480c26.51 0 48-21.49 48-48v-96C576 309.5 554.5 288 528 288z"/>
															</svg>
														</i>
														<?php echo $modulo[$posicion]['nom_subgrupo']; ?>
														<span style="background-color:red;margin-left:5px;padding:3px;font-size:14px;"><?php echo $cierres_caja_pendientes; ?></span>
														<span style="background-color:orange;margin-left:1px;padding:3px;font-size:14px;"><?php echo $cierres_caja_sin_cofre; ?></span>
													</a>
												</li>
											<?php }

											$busq_modulo = in_array('cont_la_documentos', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cont_la_documentos', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="c_documentos"><a href="#"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272 416h-160C103.2 416 96 408.8 96 400C96 391.2 103.2 384 112 384h160c8.836 0 16 7.162 16 16C288 408.8 280.8 416 272 416zM272 352h-160C103.2 352 96 344.8 96 336C96 327.2 103.2 320 112 320h160c8.836 0 16 7.162 16 16C288 344.8 280.8 352 272 352zM288 272C288 280.8 280.8 288 272 288h-160C103.2 288 96 280.8 96 272C96 263.2 103.2 256 112 256h160C280.8 256 288 263.2 288 272z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('cont_la_lost', array_column($modulo, 'nom_menu'));
											$posicion = array_search('cont_la_lost', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="c_losts"><a href="#"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M377.74 32H70.26C31.41 32 0 63.41 0 102.26v307.48C0 448.59 31.41 480 70.26 480h307.48c38.52 0 69.76-31.08 70.26-69.6-45.96-25.62-110.59-60.34-171.6-88.44-32.07 43.97-84.14 81-148.62 81-70.59 0-93.73-45.3-97.04-76.37-3.97-39.01 14.88-81.5 99.52-81.5 35.38 0 79.35 10.25 127.13 24.96 16.53-30.09 26.45-60.34 26.45-60.34h-178.2v-16.7h92.08v-31.24H88.28v-19.01h109.44V92.34h50.92v50.42h109.44v19.01H248.63v31.24h88.77s-15.21 46.62-38.35 90.92c48.93 16.7 100.01 36.04 148.62 52.74V102.26C447.83 63.57 416.43 32 377.74 32zM47.28 322.95c.99 20.17 10.25 53.73 69.93 53.73 52.07 0 92.58-39.68 117.87-72.9-44.63-18.68-84.48-31.41-109.44-31.41-67.45 0-79.35 33.06-78.36 50.58z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php }

								$busq_menu = in_array('informes_la', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('informes_la',array_column($menu,'nom_grupomenu')); ?>

								<?php if($busq_menu != false){ ?>  
									<li id="informes" class="menu">
										<a href="#rinformes" id="hinformes"><i class="icon-bars-alt"></i><span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rinformes"> 
											<?php 
											$busq_modulo = in_array('inf_la_transferencia', array_column($modulo, 'nom_menu'));
											$posicion = array_search('inf_la_transferencia',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="i_transferencias"><a href="<?= site_url('Laleli/Informe_Transferencia') ?>"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="19" height="23" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M384 288l64-192h-109.4C308.4 96 281.6 76.66 272 48C262.4 19.33 235.6 0 205.4 0H64l64 288H384zM0 480c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-64H0V480zM480 224h-40.94l-21.33 64H432C440.8 288 448 295.2 448 304S440.8 320 432 320h-352C71.16 320 64 312.8 64 304S71.16 288 80 288h15.22l-14.22-64H32C14.33 224 0 238.3 0 256v128h512V256C512 238.3 497.7 224 480 224z"/></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											?>
										</ul>
									</li>
								<?php } 
								
								$busq_menu = in_array('configuracion_la', array_column($menu, 'nom_grupomenu'));
								$posicion=array_search('configuracion_la',array_column($menu,'nom_grupomenu')); ?>
								<?php if($busq_menu != false){  ?> 
									<li id="configuracion" class="menu">
										<a href="#rconfiguracion" id="hconfiguracion" ><i class="icon-cog6"></i> <span><?php echo $menu[$posicion]['nom_modulo_grupo']; ?></span></a>
										<ul id="rconfiguracion">
											<?php 
											/*$busq_modulo = in_array('conf_la_punto_venta', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_la_punto_venta',array_column($modulo,'nom_menu')); 
 
											if($busq_modulo != false){ */?>
												<!--<li id="c_puntos_ventas"><a href="#"><i><svg xmlns="http://www.w3.org/2000/svg"  style="margin: 0 auto;" aria-hidden="true" width="20" height="20" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M0 32l34.9 395.8L192 480l157.1-52.2L384 32H0zm313.1 80l-4.8 47.3L193 208.6l-.3.1h111.5l-12.8 146.6-98.2 28.7-98.8-29.2-6.4-73.9h48.9l3.2 38.3 52.6 13.3 54.7-15.4 3.7-61.6-166.3-.5v-.1l-.2.1-3.6-46.3L193.1 162l6.5-2.7H76.7L70.9 112h242.2z"/></svg></i><?php //echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>-->
											<?php //} 

											$busq_modulo = in_array('conf_la_tipo', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_la_tipo', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="c_tipos"><a href="<?= site_url('Laleli/Tipo') ?>"><i class="icon-circle-small" style="font-size: 20px; left: -5px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_la_subtipo', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_la_subtipo', array_column($modulo, 'nom_menu'));

											if ($busq_modulo != false) { ?>
												<li id="c_subtipos"><a href="<?= site_url('Laleli/Subtipo') ?>"><i class="icon-menu" style="font-size: 20px; left: -5px;"></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_la_tipo_producto', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_la_tipo_producto',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="c_tipos_productos"><a href="<?= site_url('Laleli/Tipo_Producto') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="20" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M240 416h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm-96 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm192 0h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm96-192h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0 96h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-288h-32a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-96H32A32 32 0 0 0 0 64v400a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V96h368a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }

											$busq_modulo = in_array('conf_la_talla', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_la_talla',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="c_tallas"><a href="<?= site_url('Laleli/Talla') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="20" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M.0022 64C.0022 46.33 14.33 32 32 32H288C305.7 32 320 46.33 320 64C320 81.67 305.7 96 288 96H231.8C241.4 110.4 248.5 126.6 252.4 144H288C305.7 144 320 158.3 320 176C320 193.7 305.7 208 288 208H252.4C239.2 266.3 190.5 311.2 130.3 318.9L274.6 421.1C288.1 432.2 292.3 452.2 282 466.6C271.8 480.1 251.8 484.3 237.4 474L13.4 314C2.083 305.1-2.716 291.5 1.529 278.2C5.774 264.1 18.09 256 32 256H112C144.8 256 173 236.3 185.3 208H32C14.33 208 .0022 193.7 .0022 176C.0022 158.3 14.33 144 32 144H185.3C173 115.7 144.8 96 112 96H32C14.33 96 .0022 81.67 .0022 64V64z"></path></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
											<?php }
											
											$busq_modulo = in_array('conf_la_producto', array_column($modulo, 'nom_menu'));
											$posicion = array_search('conf_la_producto',array_column($modulo,'nom_menu')); 

											if($busq_modulo != false){?>
												<li id="c_productos"><a href="<?= site_url('Laleli/Producto') ?>"><i><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="20" height="20" focusable="false" data-prefix="fas" data-icon="chalkboard-teacher" class="svg-inline--fa fa-chalkboard-teacher fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M322.1 252v-1l-51.2-65.8s-12 1.6-25 15.1c-9 9.3-242.1 239.1-243.4 240.9-7 10 1.6 6.8 15.7 1.7.8 0 114.5-36.6 114.5-36.6.5-.6-.1-.1.6-.6-.4-5.1-.8-26.2-1-27.7-.6-5.2 2.2-6.9 7-8.9l92.6-33.8c.6-.8 88.5-81.7 90.2-83.3zm160.1 120.1c13.3 16.1 20.7 13.3 30.8 9.3 3.2-1.2 115.4-47.6 117.8-48.9 8-4.3-1.7-16.7-7.2-23.4-2.1-2.5-205.1-245.6-207.2-248.3-9.7-12.2-14.3-12.9-38.4-12.8-10.2 0-106.8.5-116.5.6-19.2.1-32.9-.3-19.2 16.9C250 75 476.5 365.2 482.2 372.1zm152.7 1.6c-2.3-.3-24.6-4.7-38-7.2 0 0-115 50.4-117.5 51.6-16 7.3-26.9-3.2-36.7-14.6l-57.1-74c-5.4-.9-60.4-9.6-65.3-9.3-3.1.2-9.6.8-14.4 2.9-4.9 2.1-145.2 52.8-150.2 54.7-5.1 2-11.4 3.6-11.1 7.6.2 2.5 2 2.6 4.6 3.5 2.7.8 300.9 67.6 308 69.1 15.6 3.3 38.5 10.5 53.6 1.7 2.1-1.2 123.8-76.4 125.8-77.8 5.4-4 4.3-6.8-1.7-8.2z"></path></svg></i><?php echo $modulo[$posicion]['nom_subgrupo']; ?></a></li>
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