<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Sub-Rubros (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="<?= site_url('Administrador/Excel_Subrubro') ?>">
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
                    <thead>
                        <tr>
                            <th class="text-center" width="15%">Rubro</th>
                            <th class="text-center" width="15%">Sub-Rubro</th>
                            <th class="text-center" width="24%">Empresa(s)</th>
                            <th class="text-center" width="24%">Tipo&nbsp;Documento(s)</th>
                            <th class="text-center" width="8%">Obliga&nbsp;Doc.</th>
                            <th class="text-center" width="6%">Informe</th>
                            <th class="text-center" width="5%">Status</th>  
                            <th width="3%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list_subrubro as $list) { 
                                $empresa="";
                                $obliga_documento="";
                                $informe="";
                                $nom_tipo_documento="";
                                $busqueda_subrubro=in_array($list['Id'],array_column($subrubro,'id_subrubro'));
                                if($busqueda_subrubro!=false){
                                    $posicion=array_search($list['Id'],array_column($subrubro,'id_subrubro'));

                                    if($subrubro[$posicion]['id_empresa']!=99){
                                        $cantidad_empresa=explode(",",$subrubro[$posicion]['id_empresa']);
                                        $i=0;
                                        $parte_empresa="";
                                        while($i<count($cantidad_empresa)){
                                            $posicion_empresa=array_search($cantidad_empresa[$i],array_column($combo_empresa,'id_empresa'));
                                            $parte_empresa=$parte_empresa.$combo_empresa[$posicion_empresa]['cd_empresa'].",";
                                            $i++;
                                        }
                                        $empresa=substr($parte_empresa,0,-1);
                                    }

                                    if($subrubro[$posicion]['obliga_documento']==1){
                                        $obliga_documento="SI";
                                    }else{
                                        $obliga_documento="NO";
                                    }

                                    if($subrubro[$posicion]['informe']==1){
                                        $informe="SI";
                                    }else{
                                        $informe="NO";
                                    }

                                    if($subrubro[$posicion]['id_tipo_documento']!=99){
                                        $cantidad_tipo_documento=explode(",",$subrubro[$posicion]['id_tipo_documento']);
                                        $i=0;
                                        $parte_tipo_documento="";
                                        while($i<count($cantidad_tipo_documento)){
                                            $posicion_tipo_documento=array_search($cantidad_tipo_documento[$i],array_column($tipo_documento,'ReceiptTypeId'));
                                            $parte_tipo_documento=$parte_tipo_documento.$tipo_documento[$posicion_tipo_documento]['Description'].",";
                                            $i++;
                                        }
                                        $nom_tipo_documento=substr($parte_tipo_documento,0,-1);

                                    }
                                }?>
                            <tr>
                                <td><?php echo $list['Rubro']; ?></td>
                                <td><?php echo $list['Name']; ?></td>
                                <td><?php echo $empresa; ?></td>
                                <td><?php echo $nom_tipo_documento; ?></td>
                                <td class="text-center"><?php echo $obliga_documento; ?></td>
                                <td class="text-center"><?php echo $informe; ?></td>
                                <td class="text-center"><?php echo $list['Description']; ?></td>
                                <td class="text-center" nowrap>
                                    <img title="Editar" data-toggle="modal" data-target="#acceso_modal_mod" app_crear_mod="<?= site_url('Administrador/Modal_Update_Subrubro') ?>/<?php echo $list['Id']; ?>" src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" width="22" height="22" />
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
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#configcontabilidad").addClass('active');
        $("#hconfigcontabilidad").attr('aria-expanded', 'true');
        $("#subrubros").addClass('active');
		document.getElementById("rcontabilidad").style.display = "block";
        document.getElementById("rconfigcontabilidad").style.display = "block";
    });
</script>

<script>
    $(document).ready(function() {
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar '+title+'" />');
            }
    
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
            order: [[0,"asc"],[1,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 7 ]
                }
            ]
        } );
    } );
</script>

<?php $this->load->view('Admin/footer'); ?>