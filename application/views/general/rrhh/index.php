<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('general/header'); ?>

<?php $this->load->view('general/nav'); ?>

<style>
	.tabset>input[type="radio"] {
		position: absolute;
		left: -200vw;
	}

	.tabset .tab-panel {
		display: none;
	}

	.tabset>input:first-child:checked~.tab-panels>.tab-panel:first-child,
	.tabset>input:nth-child(3):checked~.tab-panels>.tab-panel:nth-child(2),
	.tabset>input:nth-child(5):checked~.tab-panels>.tab-panel:nth-child(3),
	.tabset>input:nth-child(7):checked~.tab-panels>.tab-panel:nth-child(4),
	.tabset>input:nth-child(9):checked~.tab-panels>.tab-panel:nth-child(5),
	.tabset>input:nth-child(11):checked~.tab-panels>.tab-panel:nth-child(6),
	.tabset>input:nth-child(13):checked~.tab-panels>.tab-panel:nth-child(7),
	#tab8:checked~.tab-panels>#rauchbier8 {
		display: block;
	}


	.tabset>label {
		position: relative;
		display: inline-block;
		padding: 15px 15px 25px;
		border: 1px solid transparent;
		border-bottom: 0;
		cursor: pointer;
		font-weight: 600;
		background: #A9D7D6;
	}

	.tabset>label::after {
		content: "";
		position: absolute;
		left: 15px;
		bottom: 10px;
		width: 22px;
		height: 4px;
		background: #D1EDE8;
	}

	.tabset>label:hover,
	.tabset>input:focus+label {
		color:#219186;
	}

	.tabset>label:hover::after,
	.tabset>input:focus+label::after,
	.tabset>input:checked+label::after {
		background: #26A69A;
	}

	.tabset>input:checked+label {
		margin-bottom: -1px;
	}

	.tab-panel {
		padding: 30px 0;
		border-top: 1px solid #ccc;
	}

	*,
	*:before,
	*:after {
		box-sizing: border-box;
	}

	.tabset {
		margin: 8px 15px;
	}

	.contenedor1 {
		position: relative;
		height: 80px;
		width: 80px;
		float: left;
	}

	.contenedor1 img {
		position: absolute;
		left: 0;
		transition: opacity 0.3s ease-in-out;
		height: 80px;
		width: 80px;
	}

	.contenedor1 img.top:hover {
		opacity: 0;
		height: 80px;
		width: 80px;
	}

	table th {
		text-align: center;
	}

	.tabset>input:checked+label {
    	color: #26A69A; 
	}

</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>RRHH - Configuración</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" style="display:flex;gap:3rem;">
                        <div>
                            <a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('General/Modal_Insertar_Tipo_Contrato_RRHH')?>" title="Nuevo Contrato" style="margin-right:5px;">
								<img src="<?= base_url() ?>template/img/tipos-contrato.png" alt="Nuevo Contrato">
					    	</a>

					    	<a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('General/Modal_Insertar_Contribucion_RRHH')?>" title="Nueva Contribucion" style="margin-right:5px;">
								<img src="<?= base_url() ?>template/img/contribuciones.png" alt="Nueva Contribucion">
					    	</a>

					    	<a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('General/Modal_Insertar_Impuesto_RRHH')?>" title="Nuevo Impuesto" style="margin-right:5px;">
								<img src="<?= base_url() ?>template/img/impuestos.png" alt="Nuevo Impuesto">
					    	</a>

					    	<a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('General/Modal_Insertar_AsFamiliar_RRHH')?>" title="Nueva Asignacion Familiar" data-toggle="modal" style="margin-right:5px;">
								<img src="<?= base_url() ?>template/img/asignacion-familiar.png" alt="Nueva Asignacion Familiar">
					    	</a>

					    	<a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('General/Modal_Insertar_Bono_RRHH')?>" title="Nuevo Bono" style="margin-right:5px;">
								<img src="<?= base_url() ?>template/img/bonos.png" alt="Nuevo Bono">
					    	</a>

					    	<a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('General/Modal_Insertar_Tardanza_RRHH')?>" title="Nueva Tardanza" style="margin-right:5px;">
								<img src="<?= base_url() ?>template/img/tardanzas.png" alt="Nueva Tardanza">
					    	</a>

							<a data-toggle="modal" data-target="#acceso_modal" app_crear_per="<?= site_url('General/Modal_Insertar_Falta_RRHH')?>" title="Nueva Falta" style="margin-right:5px;">
								<img src="<?= base_url() ?>template/img/faltas.png" alt="Nueva Falta">
					    	</a>
                        </div>
                        
                        <div>
                            <a id="exportarExcel">
                                <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
		<div class="row">
			<div class="tabset">
				<input type="radio" name="tabset" id="tab1" aria-controls="rauchbier1" checked onclick="List_Tipo_Contrato();">
				<label for="tab1">Tipo Contrato</label>

				<input type="radio" name="tabset" id="tab2" aria-controls="rauchbier2" onclick="List_Contribucion();">
				<label for="tab2">Contribuciones</label>

				<input type="radio" name="tabset" id="tab3" aria-controls="rauchbier3" onclick="List_Impuesto();">
				<label for="tab3">Impuestos</label>

				<input type="radio" name="tabset" id="tab4" aria-controls="rauchbier4" onclick="List_AsFamiliar();">
				<label for="tab4">As. Familiar</label>

				<input type="radio" name="tabset" id="tab5" aria-controls="rauchbier5" onclick="List_Bonos();">
				<label for="tab5">Bonos</label>

				<input type="radio" name="tabset" id="tab6" aria-controls="rauchbier6" onclick="List_Tardanzas();">
				<label for="tab6">Tardanzas</label>

				<input type="radio" name="tabset" id="tab7" aria-controls="rauchbier7" onclick="List_Faltas();">
				<label for="tab7">Faltas</label>

				<div class="tab-panels">
					<!-- Contratos -->
					<section id="rauchbier1" class="tab-panel">
						<div class="modal-content">
							<div id="list_tipo_contrato">
							</div>
						</div>
					</section>

					<!-- Contribuciones -->
					<section id="rauchbier2" class="tab-panel">
						<div class="modal-content">
							<div id="list_contribuciones">
							</div>
						</div>
					</section>

					<!-- Impuestos -->
					<section id="rauchbier3" class="tab-panel">
						<div class="modal-content">
							<div id="list_impuestos">
							</div>
						</div>
					</section>

					<!-- AsFamiliar -->
					<section id="rauchbier4" class="tab-panel">
						<div class="modal-content">
							<div id="list_asFamiliar">
							</div>
						</div>
					</section>

					<!-- Bonos -->
					<section id="rauchbier5" class="tab-panel">
						<div class="modal-content">
							<div id="list_bonos">
							</div>
						</div>
					</section>

					<!-- Tardanzas -->
					<section id="rauchbier6" class="tab-panel">
						<div class="modal-content">
							<div id="list_tardanzas">
							</div>
						</div>
					</section>

					<!-- Faltas -->
					<section id="rauchbier7" class="tab-panel">
						<div class="modal-content">
							<div id="list_faltas">
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>

						
<script>
    $(document).ready(function() {
        $("#configuracion").addClass('active');
        $("#hconfiguracion").attr('aria-expanded','true');
        $("#rrhh").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";

        List_Tipo_Contrato();
    });
</script>

<?php $this->load->view('general/footer'); ?>
<?php $this->load->view('general/rrhh/utils'); ?>

<script>
	$(document).ready(function() {

    	$("#exportarExcel").on("click", function() {
    	    var tabActiva = $("input[name='tabset']:checked").attr("id");
    	    var urlExcel;

    	    switch (tabActiva) {
    	        case "tab1":
    	            urlExcel = "<?= site_url('General/Excel_Tipo_Contrato_RRHH') ?>";
    	            break;
    	        case "tab2":
    	            urlExcel = "<?= site_url('General/Excel_Contribucion_RRHH') ?>";
    	            break;
				case "tab3":
    	            urlExcel = "<?= site_url('General/Excel_Impuesto_RRHH') ?>";
    	            break;
				case "tab4":
    	            urlExcel = "<?= site_url('General/Excel_AsFamiliar_RRHH') ?>";
    	            break;
				case "tab5":
    	            urlExcel = "<?= site_url('General/Excel_Bono_RRHH') ?>";
    	            break;
				case "tab6":
    	            urlExcel = "<?= site_url('General/Excel_Tardanza_RRHH') ?>";
    	            break;
				case "tab7":
    	            urlExcel = "<?= site_url('General/Excel_Falta_RRHH') ?>";
    	            break;
    	        default:
    	            urlExcel = "<?= site_url('General/Excel_Tipo_Contrato_RRHH') ?>";
    	            break;
    	    }

    	    // Redirige a la URL correspondiente
    	    window.location.href = urlExcel;
    	});
	});

    function List_Tipo_Contrato() {
        Cargando();
        $.ajax({
            url: "<?= site_url('General/List_Tipo_Contrato_RRHH') ?>",
            type: "POST",
            success: function(data) {
                $("#list_tipo_contrato").html(data);
            }
        });
    }

    function List_Contribucion() {
        Cargando();
        $.ajax({
            url: "<?= site_url('General/List_Contribucion_RRHH') ?>",
            type: "POST",
            success: function(data) {
                $("#list_contribuciones").html(data);
            }
        });
    }

    function List_Impuesto() {
        Cargando();
        $.ajax({
            url: "<?= site_url('General/List_Impuesto_RRHH') ?>",
            type: "POST",
            success: function(data) {
                $("#list_impuestos").html(data);
            }
        });
    }

    function List_AsFamiliar() {
        Cargando();
        $.ajax({
            url: "<?= site_url('General/List_AsFamiliar_RRHH') ?>",
            type: "POST",
            success: function(data) {
                $("#list_asFamiliar").html(data);
            }
        });
    }

    function List_Bonos() {
        Cargando();
        $.ajax({
            url: "<?= site_url('General/List_Bono_RRHH') ?>",
            type: "POST",
            success: function(data) {
                $("#list_bonos").html(data);
            }
        });
    }

    function List_Tardanzas() {
        Cargando();
        $.ajax({
            url: "<?= site_url('General/List_Tardanza_RRHH') ?>",
            type: "POST",
            success: function(data) {
                $("#list_tardanzas").html(data);
            }
        });
    }

	function List_Faltas() {
        Cargando();
        $.ajax({
            url: "<?= site_url('General/List_Falta_RRHH') ?>",
            type: "POST",
            success: function(data) {
                $("#list_faltas").html(data);
            }
        });
    }

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

        var table = $('#example').DataTable({
            order: [0,"asc"],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 7 ]
            } ]
        });

    });
</script>
