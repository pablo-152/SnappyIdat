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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Empresas (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a title="Nueva Empresa" style="cursor:pointer; cursor: hand;margin-right:5px" data-toggle="modal" data-target="#modal_form_vertical" modal_form_vertical="<?= site_url('General/Modal_Empresas') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a href="<?= site_url('General/Excel_Empresa') ?>">
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
                            <th width="6%" class="text-center">Orden</th>
                            <th width="9%" class="text-center" title="Código Marca">CD Mar.</th>
                            <th width="20%" class="text-center">Marca</th>
                            <th width="9%" class="text-center" title="Código Empresa">CD Emp.</th>
                            <th width="21%" class="text-center">Empresa</th>
                            <th width="9%" class="text-center">RUC</th>
                            <th width="9%" class="text-center" title="Cuenta Bancaria">Cuenta Banc.</th>
                            <th width="7%" class="text-center">Estado</th>
                            <th width="7%" class="text-center">Redes</th>
                            <td width="3%" class="no-content"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_empresai as $list) { ?>
                            <tr>
                                <td class="text-center"><?php echo $list['orden_menu']; ?></td>
                                <td class="text-center"><?php echo $list['cod_empresa']; ?></td>
                                <td><?php echo $list['empresa']; ?></td>     
                                <td class="text-center"><?php echo $list['cd_empresa']; ?></td>                                               
                                <td><?php echo $list['nom_empresa']; ?></td>
                                <td class="text-center"><?php echo $list['ruc']; ?></td>
                                <td class="text-center"><?php echo $list['cuenta_bancaria']; ?></td>
                                <td class="text-center"><?php echo $list['nom_status']; ?></td>
                                <td class="text-center"><?php echo $list['reporte']; ?></td>
                                <td class="text-center">
                                    <img title="Editar Datos Empresa" data-toggle="modal" 
                                    data-target="#acceso_modal_mod" 
                                    app_crear_mod="<?= site_url('General/Modal_Update_Empresa') ?>/<?php echo $list["id_empresa"]; ?>" 
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
        $("#empresa").addClass('active');
		document.getElementById("rconfiguracion").style.display = "block";
    });
</script>

<?php $this->load->view('general/footer'); ?>

<script>
    $(document).ready(function() {
        Cargando();
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
                'bSortable' : false,
                'aTargets' : [ 9 ]
            } ]
        } );
    });
</script>

		
