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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Inventario por Sede (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        
                        <a onclick="Excel()">
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
                <form  method="post" id="formulario_sede" enctype="multipart/form-data"  class="formulario">
                    <div class="col-md-12 row">
                    <div class="form-group col-md-1">
                        <label>Sede:</label>
                    </div>

                    <div class="form-group col-md-3">
                        <select  class="form-control basic" id="id_sede" name="id_sede" onchange="Buscar_Inventario()">
                            <option value="">Todos</option>
                            <?php foreach($list_sede as $list){ ?>
                                <option value="<?php echo $list['id_sede']; ?>"><?php echo $list['cod_sede'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    </div>
                </form>
                <div id="tabla">
                    <form  method="post" id="formularioxls" enctype="multipart/form-data" action="<?= site_url('Snappy/Excel_Iventario_xSede')?>" class="formulario">
                        <input type="hidden" name="id_sede" id="id_sede" value=""> 
                    </form>
                    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                        <thead>
                            <tr >
                                
                                <th width="2%"><div align="center" title="Referencia" style="cursor:help">Ref.</div></th>
                                <th width="11%"><div align="center" title="Código" style="cursor:help">Cod.</div></th>
                                <th width="15%"><div align="center">Tipo</div></th>
                                <th width="15%"><div align="center">Sub-Tipo</div></th>
                                <th width="12%"><div align="center">Empresa</div></th>
                                <th width="9%"><div align="center">Sede</div></th>
                                <th width="9%"><div align="center">Local</div></th>
                                <th width="8%"><div align="center" title="Validación" style="cursor:help">Vali.</div></th>
                                <th width="13%"><div align="center" title="Usuario que realizó Validación" style="cursor:help">Usuario Vali.</div></th>
                                <th width="11%"><div align="center" title="Fecha de Validación" style="cursor:help">Fec.&nbsp;Vali.</div></th>
                                <th width="11%"><div align="center" title="Último Check" style="cursor:help">Últ.&nbsp;check</div></th>
                                <!--<th width="10%"><div align="center">Stock</div></th>-->
                                <th width="11%"><div align="center">Estado</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list_inventario_sede as $list) { ?>
                                <tr>
                                    
                                    <td align="center"><?php echo $list['numero']; ?></td>
                                    <td align="center"><?php echo $list['letra']."/".$list['codigo_barra']; ?></td>
                                    <td ><?php echo $list['nom_tipo_inventario']; ?></td>
                                    <td ><?php echo $list['nom_subtipo_inventario']; ?></td>
                                    <td align="center"><?php echo $list['cod_empresa']; ?></td>
                                    <td><?php echo $list['cod_sede']; ?></td>
                                    <td ><?php echo $list['nom_local']; ?></td>
                                    <td align="center"><?php echo $list['validacion_msg']; ?></td>
                                    <td><?php echo $list['usuario_codigo']; ?></td>
                                    <td align="center"><?php if($list['validacion']!=0){echo $list['fecha_validacion'];}  ?></td>
                                    <td align="center"><?php if($list['fecha_validacion']!="00/00/0000 00:00:00"){echo $list['lcheck']; } ?></td>
                                    <!--<td ><?php echo ""; ?></td>-->
                                    <td align="center"><?php echo $list['nom_status']; ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#inventario").addClass('active');
        $("#hinventario").attr('aria-expanded','true');
        $("#inv_sede").addClass('active');
        document.getElementById("rinventario").style.display = "block";
    });
</script>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
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
            ordering: false,
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 25,
            "aoColumnDefs" : [ {
            'bSortable' : false,
            'aTargets' : [ 0 ]
            } ]
           
        } );

    } );

    

    function Buscar_Inventario(){
        $(document)
        .ajaxStart(function () {
            //screen.fadeIn();
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        
        var dataString = new FormData(document.getElementById('formulario_sede'));
        var url = "<?php echo site_url(); ?>Snappy/Buscar_Inventario_xSede";

        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#tabla').html(data);
            }
        }); 
    }

    function Excel(){
        $('#formularioxls').submit();
    
    }
    
</script>

<?php $this->load->view('Admin/footer'); ?>