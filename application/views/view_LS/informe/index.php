<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LS/header'); ?>
<?php $this->load->view('view_LS/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Informe (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="<?= site_url('LeadershipSchool/Excel_Informe_Lista') ?>">
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
                        <tr style="background-color: #E5E5E5;">
                            <th class="text-center" width="20%">Nombre</th>
                            <th class="text-center" width="75%">Descripción</th>
                            <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>                                      
                        <tr class="even pointer text-center">  
                            <td class="text-left">Pensiones Canceladas / Por Cancelar</td>   
                            <td class="text-left">Lista de pensiones canceladas y por cancelar con estado de matricula del alumno</td>                                                   
                            <td>
                                <a href="<?= site_url('LeadershipSchool/Informe') ?>" title="Lista" role="button">
                                    <img title="Lista" src="<?= base_url() ?>template/img/ver.png" style="cursor:pointer;">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#informe").addClass('active');
        $("#hinforme").attr('aria-expanded','true');
        $("#listas").addClass('active');
		document.getElementById("rinforme").style.display = "block";

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

        var table=$('#example').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 2 ]
                }
            ]
        } );
    });
</script>

<?php $this->load->view('view_LS/footer'); ?>