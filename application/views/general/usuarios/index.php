<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('general/header'); ?>
<?php $this->load->view('general/nav'); ?>
			
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Usuarios (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a title="Nuevo Usuario" style="cursor:pointer; cursor: hand;margin-right:5px;" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('General/Modal_Usuario') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('General/Excel_Usuario') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                    <thead >
                        <tr>
							<th class="text-center" width="6%" title="Usuario">Usu.</th>
							<th class="text-center" width="4%" title="Código">Cod.</th>
							<th class="text-center" width="18%">Apellidos y Nombres</th>
							<th class="text-center" width="10%">Perfil</th>
							<th class="text-center" width="11%">Empresa</th>
							<th class="text-center" width="7%" title="Código GL">Cod&nbsp;GL</th>
							<th class="text-center" width="7%" title="Inicio de Funciones">Ini.&nbsp;Fun.</th>
							<th class="text-center" width="7%" title="Termino de Funciones">Ter.&nbsp;Fun.</th>
							<th class="text-center" width="8%" title="Último Ingreso">Últ.&nbsp;Ing.</th>
							<th class="text-center" width="6%">Status</th> 
							<td class="text-center" width="3%"></td>
                        </tr>
                    </thead>
                    <tbody >
						<?php foreach($list_usuario as $list){?> 
							<tr>
								<td><?php echo $list['usuario_codigo']; ?></td>
								<td class="text-center"><?php echo $list['codigo']; ?></td>
								<td><?php echo $list['usuario_apater']." ".$list['usuario_amater'].", ".$list['usuario_nombres']; ?></td>
								<td><?php echo $list['nom_nivel']; ?></td>
								<td>
									<?php 
										$cadena="";
										foreach($list_empresam as $empresa){
											if($empresa['id_usuario']==$list['id_usuario']){
												$cadena=$cadena.$empresa['cod_empresa'].",";
											}
										}
										echo substr($cadena,0,-1);
									?>
								</td>
								<td class="text-center"><?php echo $list['codigo_gllg']; ?></td>
								<td class="text-center"><?php echo $list['inicio_funcion']; ?></td>
								<td class="text-center"><?php echo $list['fin_funcion']; ?></td>
								<td class="text-center"><?php echo  $list['ultimo_ingreso']; ?></td>
								<td class="text-center" <?php if($list['estado']==3) { echo "style='background-color: #ffabab;'";} ?>><?php echo $list['nom_status']; ?></td>
								<td class="text-center">                   
									<img title="Editar Datos del Usuario" data-toggle="modal" 
									data-target="#acceso_modal_mod" 
									app_crear_mod="<?= site_url('General/Modal_Update_Usuario') ?>/<?php echo $list["id_usuario"]; ?>" 
									src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" 
									width="22" height="22" />
								</td>
							</tr>
						<?php }?>

						<?php foreach($list_usuario_inactivos as $list) {  ?>                                           
							<tr class="even pointer">
								<td><?php echo $list['usuario_codigo']; ?></td>
								<td class="text-center"><?php echo $list['codigo']; ?></td>
								<td><?php echo $list['usuario_apater']." ".$list['usuario_amater'].", ".$list['usuario_nombres']; ?></td>
								<td><?php echo $list['nom_nivel']; ?></td>
								<td>
									<?php 
										$cadena="";
										foreach($list_empresam as $empresa){
											if($empresa['id_usuario']==$list['id_usuario']){
												$cadena=$cadena.$empresa['cod_empresa'].",";
											}
										}
										echo substr($cadena,0,-1);
									?>
								</td>
								<td class="text-center"><?php echo $list['codigo_gllg']; ?></td>
								<td class="text-center"><?php if ($list['ini_funciones']!='0000-00-00') echo date('d/m/Y', strtotime($list['ini_funciones'])); ?></td>
								<td class="text-center"><?php if ($list['fin_funciones']!='0000-00-00') echo date('d/m/Y', strtotime($list['fin_funciones'])); ?></td>
								<td class="text-center"><?php echo  $list['ultimo_ingreso']; ?></td>
								<td class="text-center" <?php if($list['estado']==3) { echo "style='background-color: #ffabab;'";} ?>><?php echo $list['nom_status']; ?></td>
								<td class="text-center">                   
									<img title="Editar Datos del Usuario" data-toggle="modal" 
									data-target="#acceso_modal_mod" 
									app_crear_mod="<?= site_url('General/Modal_Update_Usuario') ?>/<?php echo $list["id_usuario"]; ?>" 
									src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" 
									width="22" height="22" />
								</td>
							</tr>
						<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

						
<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#usuario").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";
    });
</script>

<?php $this->load->view('general/footer'); ?>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        /*var table = $('#example').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21
        });*/

		var table = $('#example').DataTable( {
            
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
			"order": [[ 10, "Status" ]],
			"aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 10 ]
        } ]
        } );
    });
</script>
