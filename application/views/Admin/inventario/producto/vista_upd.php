<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<?php $this->load->view('Admin/nav'); ?>
<script type="text/javascript" src="<?=base_url() ?>template/assets/js/plugins/loaders/pace.min.js"></script>
<!--<script type="text/javascript" src="<?=base_url() ?>template/assets/js/core/libraries/jquery.min.js"></script>-->

<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url() ?>template/assets/js/plugins/loaders/blockui.min.js"></script>

<script type="text/javascript" src="<?=base_url() ?>template/assets/js/pages/uploader_bootstrap.js"></script>

<!--<link href="<?php echo base_url(); ?>template/inputfiles/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?php echo base_url(); ?>template/inputfiles/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Actualizar Producto</b></span></h4>
                </div>
                <div class="heading-elements">
                    <div class="heading-btn-group" >
                        <a type="button" href="<?= site_url('Snappy/Producto') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="formulario_productoie" method="POST" enctype="multipart/form-data"  class="horizontal">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                <input type="hidden" readonly class="form-control"  id="hoy" name="hoy" value="<?php echo date('Y-m-d'); ?>" autofocus>
                    <div class="form-group col-md-1">
                        <label title="Referencia" style="cursor:help">Refer.:</label>
                    </div>

                    <div class="form-group col-md-2">
                        <input type="text" readonly class="form-control" id="referencia" name="referencia" value="<?php echo $get_id[0]['referencia'] ?>" autofocus>
                    </div>

                    <div class="form-group col-md-1">
                        <label>Tipo:</label>
                    </div>

                    <div class="form-group col-md-3">
                        <select required class="form-control" name="id_tipo_inventario" id="id_tipo_inventario" onchange="Busca_Subtipo()">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo as $list){ 
                            if($get_id[0]['id_tipo_inventario']==$list['id_tipo_inventario']){ ?>
                                <option selected value="<?php echo $list['id_tipo_inventario']; ?>"><?php echo $list['nom_tipo_inventario'];?></option>
                            <?php
                            }else{?>
                            <option value="<?php echo $list['id_tipo_inventario']; ?>"><?php echo $list['nom_tipo_inventario'];?></option>
                        <?php }
                             } ?>
                        </select>
                    </div>

                    <div class="form-group col-md-1">
                        <label nowrap>Sub&nbsp;Tipo:</label>
                    </div>

                    <div class="form-group col-md-3" id="div_subtipo">
                        <select required class="form-control" name="id_subtipo_inventario" id="id_subtipo_inventario">
                            <option value="0">Seleccione</option>
                            <?php foreach($list_subtipo as $list){ 
                            if($get_id[0]['id_subtipo_inventario']==$list['id_subtipo_inventario']){?>
                            <option selected value="<?php echo $list['id_subtipo_inventario']; ?>"><?php echo $list['nom_subtipo_inventario'];?></option>
                            <?php }else{?> 
                                <option value="<?php echo $list['id_subtipo_inventario']; ?>"><?php echo $list['nom_subtipo_inventario'];?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="col">
                        <!--<input type="text" readonly class="form-control"  id="estado" name="estado" autofocus>-->
                        
                            <!--<select required class="form-control" name="id_tipo_inventario" id="id_tipo_inventario" onchange="Busca_Subtipo()">-->
                            <input type="hidden" readonly class="form-control"  id="id_estado" name="id_estado" value="<?php echo $get_id[0]['estado'] ?>" autofocus>
                            <?php foreach($list_estado as $list){ 
                                if($get_id[0]['estado']==$list['id_status_general']){ ?>
                                    <input readonly class="form-control" id="estado" name="estado" type="text" value="<?php echo $list['nom_status'];?>" />
                                <?php
                                } } ?>
                            </select>
                    </div>
                </div>
                
                <div class="col-md-9">
                    
                    <div class="form-group col-md-2 ">
                        <label>Descripción:</label>
                    </div>

                    <div class="form-group col-md-10" >
                        <input type="text"   class="form-control" value="<?php echo $get_id[0]['producto_descripcion'] ?>"  id="producto_descripcion" name="producto_descripcion" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-2">
                        <label>Fecha&nbsp;Compra:</label>
                    </div>

                    <div class="form-group col-md-3 ">
                        <input type="date" class="form-control" value="<?php echo $get_id[0]['fec_compra'] ?>" id="fec_compra" name="fec_compra" onchange="Calculo_Desvalorizacion()" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-2">
                        <label>Proveedor:</label>
                    </div>

                    <div class="form-group col-md-5 ">
                        <input type="text"   class="form-control" value="<?php echo $get_id[0]['proveedor'] ?>" id="proveedor" name="proveedor" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-2 ">
                        <label>Garantía hasta:</label>
                    </div>

                    <div class="form-group col-md-3 ">
                        <input type="date" value="<?php echo $get_id[0]['garantia_h'] ?>"  class="form-control"  id="garantia_h" name="garantia_h" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-2">
                        <label title="Precio Unitario" style="cursor:help">Precio Unit.(S/):</label>
                    </div>

                    <div class="form-group col-md-2 ">
                        <input type="text" value="<?php echo $get_id[0]['precio_u'] ?>" class="form-control"  id="precio_u" name="precio_u" onchange="Calculo_Desvalorizacion()" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-1">
                        <label title="Cantidad" style="cursor:help">Cant.:</label>
                    </div>

                    <div class="form-group col-md-2 ">
                        <input type="text" class="form-control" onchange="Cargar_Codigos()" value="<?php echo $get_id[0]['cantidad'] ?>" id="cantidad" name="cantidad" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-1">
                        <label>Total&nbsp;(S/):</label>
                    </div>

                    <div class="form-group col-md-2 ">
                        <input type="text" readonly class="form-control" value="<?php echo $get_id[0]['total'] ?>" id="total" name="total" autofocus>
                    </div>

                    <div class="form-group col-md-1">
                        <label title="Desvalorización" style="cursor:help">Desval(%):</label>
                    </div>

                    <div class="form-group col-md-2">
                        <input type="text"  class="form-control" value="<?php echo $get_id[0]['desvalorizacion'] ?>" id="desvalorizacion" name="desvalorizacion" placeholder="%" onchange="Calculo_Desvalorizacion()" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-1">
                        <label>Gastos(S/.):</label>
                    </div>

                    <div class="form-group col-md-2 ">
                        <input type="text"  class="form-control" maxlength="5" value="<?php echo $get_id[0]['gastos'] ?>" id="gastos" name="gastos" placeholder="Ingresar Gastos" autofocus onkeypress="if(event.keyCode == 13){ Actualizar_ProductoI(); }">
                    </div>

                    <div class="form-group col-md-1">
                        <label title="Valor Actual" style="cursor:help">V.&nbsp;Act(S/):</label>
                    </div>

                    <div class="form-group col-md-2 ">
                        
                        <input type="text" class="form-control" readonly value="" id="valor_actual" name="valor_actual" placeholder="Valor" autofocus>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="col" style="margin-right:10px;">
                        <label class="text-bold">Imagen:
                        <div class="col">
                            <?php if(substr($get_id[0]['imagen'],-3) === "jpg" || substr($get_id[0]['imagen'],-3) === "JPG"){ ?>
                                <div id="i_<?php echo  $get_id[0]['id_inventario_producto']?>" class="form-group col-sm-10">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-27) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                                    ?>
                                </div>
                            <?php }elseif (substr($get_id[0]['imagen'],-3) === "png" || substr($get_id[0]['imagen'],-3) === "PNG"){ ?>
                                <div id="i_<?php echo  $get_id[0]['id_inventario_producto']?>" class="form-group col-sm-10">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-27) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                                    ?> 
                                </div>
                            <?php }elseif (substr($get_id[0]['imagen'],-4) === "jpeg" || substr($get_id[0]['imagen'],-4) === "JPEG"){ ?>
                                <div id="i_<?php echo  $get_id[0]['id_inventario_producto']?>" class="form-group col-sm-10">
                                    <?php 
                                    echo'<div id="lista_escogida"><img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($get_id[0]['imagen'],-28) .'" src="' . base_url() . $get_id[0]['imagen'] . '"></div>'; 
                                    ?>
                                </div>
                            <?php }else{ echo ""; } ?> 
                        </div>
                        </label>
                        <label class="text-bold">Reemplazar:</label>
                        <input type="file" id="imagene" name="imagene" data-allowed-file-extensions='["JPG|jpg|png|PNG|jpeg|JPEG"]'>
                    </div>
                    
                </div>
                <div class="col-md-12">
                    <span>&nbsp;</span>
                </div>

                <div class="col-md-12" id="tabla_codigo">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-hover" id="example" width="50%">
                                    <thead>
                                        <tr >
                                            <th width="2%"><div align="center"></div></th>
                                            <th width="20%"><div align="center">Código</div></th>
                                            <th width="20%"><div align="center">Empresa</div></th>
                                            <th width="20%"><div align="center">Sede</div></th>
                                            <th width="10%"><div align="center">Estado</div></th>
                                            <th width="10%"><div align="center">LCheck</div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ini=1; foreach($list_productos as $prod){?>
                                                    <tr>
                                                        <td align="center"><?php echo $ini; ?></td>
                                                        <td align="center"><?php echo $prod['codigo_barra']; ?></td>
                                                        <td align="center"><?php echo $prod['cod_empresa']; ?></td>
                                                        <td align="center"><?php echo $prod['cod_sede']; ?></td>
                                                        <td align="center"><?php if($prod['estado']==39){?>
                                                            <span class="badge" style="background:#00b050;color: white;"><?php echo $prod['estado_inventario'] ?></span> 
                                                                <?php }elseif($prod['estado']==40){?> 
                                                                <span class="badge" style="background:#ff0000;color: white;"><?php echo $prod['estado_inventario'] ?></span>
                                                                <?php }elseif($prod['estado']==41){?>
                                                                <span class="badge" style="background:#bf9000;color: white;"><?php echo $prod['estado_inventario'] ?></span> <?php 
                                                                }elseif($prod['estado']==42){?>
                                                                <span class="badge" style="background:#7030a0;color: white;"><?php echo $prod['estado_inventario'] ?></span> <?php 
                                                                }?>
                                                        </td>
                                                        <td align="center"><?php echo $prod['lcheck']; ?></td>
                                                    </tr>
                                                    <?php 
                                                $ini=$ini+1;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <span>&nbsp;</span>
                </div>


                <div class="col-md-12" >
                    <div class="form-group col-md-1">
                        <label>Observ.:</label>
                    </div>
                    <div class="form-group col-md-11">
                        
                        <textarea name="producto_obs" rows="4" class="form-control" id="producto_obs"><?php echo $get_id[0]['producto_obs'] ?></textarea>
                    </div>
                </div>

                <div class="col-md-12" >
                    <?php if(count($list_historial)>0){ ?>
                        <div class="form-group col-md-12">
                            <label class="col-sm-12 control-label text-bold">Archivos cargados:</label>
                        </div>
                    <?php } ?>

                    <?php foreach($list_historial as $list) {  ?>
                        <?php if(substr($list['archivo'],-3) === "jpg" || substr($list['archivo'],-3) === "JPG"){ ?>
                            <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                                ?>
                                <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                </a>
                                <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                </a>
                            </div>
                        <?php }elseif (substr($list['archivo'],-3) === "png" || substr($list['archivo'],-3) === "PNG"){ ?>
                            <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                                ?> 
                                <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                </a>
                                <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                </a>
                            </div>
                        <?php }elseif (substr($list['archivo'],-4) === "jpeg" || substr($list['archivo'],-4) === "JPEG"){ ?>
                            <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-28) .'" src="' . base_url() . $list['archivo'] . '"></div>'; 
                                ?>
                                <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                </a>
                                <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                </a>
                            </div>
                        <?php }elseif (substr($list['archivo'],-3) === "pdf"){ ?>
                            <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><embed loading="lazy" src="'. base_url() . $list['archivo'] . '" width="100%" height="150px" /></div>';
                                ?>
                                <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                </a>
                                <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                </a>
                            </div>
                        <?php }elseif (substr($list['archivo'],-4) === "xlsx"){ ?>
                            <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-28) .'" src="' . base_url() ."/template/inputfiles/excel_example.png". '"></div>'; 
                                ?>
                                <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                </a>
                                <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                </a>
                            </div>
                        <?php }elseif (substr($list['archivo'],-3) === "xls"){ ?>
                            <div id="i_<?php echo  $list['id_historial_producto']?>" class="form-group col-sm-3">
                                <?php 
                                echo'<div id="lista_escogida"><img loading="lazy" class="img_post_historial img-thumbnail img-presentation-small-actualizar_support" alt="'.substr($list['archivo'],-27) .'" src="' . base_url() ."/template/inputfiles/excel_example.png". '"></div>'; 
                                ?>
                                <a style="cursor:pointer;" class="download" type="button" id="download_file_historial" data-image_id="<?php echo $get_id[0]['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/descarga_peq.png"></img>
                                </a>
                                <a style="cursor:pointer;" class="delete" type="button" id="delete_file_historial" data-image_id="<?php echo  $list['id_historial_producto']?>">
                                    <img src="<?= base_url() ?>template/img/eliminar.png"></img>
                                </a>
                            </div>
                        <?php }else{ echo ""; } ?>  
                    <?php } ?>
                </div>
                <div class="col-md-12" >
                    <div class="form-group col-md-1">
                        <label>Archivos:</label>
                    </div>
                    <div class="form-group col-md-11">
                        
                        <input type="file" class="form-control" name="archivose[]" id="archivose" multiple autofocus/>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
        <input name="id_inventario_producto" type="hidden" class="form-control" id="id_inventario_producto" value="<?php echo $get_id[0]['id_inventario_producto']; ?>">
        <input type="hidden" readonly class="form-control" id="cod_producto" name="cod_producto" value="<?php echo $get_id[0]['cod_producto'] ?>" autofocus>
            <button type="button" class="btn btn-primary" onclick="Actualizar_ProductoI()" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Guardar
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $("#inventario").addClass('active');
        $("#hinventario").attr('aria-expanded','true');
        $("#inv_producto").addClass('active');
        document.getElementById("rinventario").style.display = "block";
    });
</script>

<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>
<script>
    $('#precio_u').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#cantidad').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $('#desvalorizacion').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#gastos').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    $('#valor_actual').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });
    
    $(document).ready(function() {
        var msgDate = '';
        var inputFocus = '';
    });

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
            
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 21
           
        } );

        if($('#fec_compra').val().trim() !="" && $('#precio_u').val().trim() !="" && $('#cantidad').val().trim() !="" && $('#desvalorizacion').val().trim() !=""){
        
            f1 = $('#fec_compra').val();
            f2 = $('#hoy').val();
            total=$('#precio_u').val()*$('#cantidad').val();
            aF1 = f1.split("-");
            aF2 = f2.split("-");
            
            numMeses = aF2[0]*12 + aF2[1] - (aF1[0]*12 + aF1[1]);
            if (aF2[2]<aF1[2]){
                numMeses = numMeses - 1;
            }

            if(numMeses>0){
                valor_actual=total-((($('#desvalorizacion').val()/100)*numMeses)*total);
                $('#valor_actual').val(valor_actual.toFixed(2));
            }else{
                $('#valor_actual').val(total.toFixed(2));
            }
        }

    } );

    $(function(){
        $('#precio_u').on('change', calcularTotal);
        $('#cantidad').on('change', calcularTotal);
    });
    
    function calcularTotal() {
        if($('#precio_u').val().trim() !="" && $('#cantidad').val().trim() !=""){
            var pu=$('#precio_u').val();
            var cantidad=$('#cantidad').val();
            var total=pu*cantidad;
            $('#total').val(total.toFixed(2));
            $('#valor_actual').val(total.toFixed(2));
            Calculo_Desvalorizacion();
        }
        
    }

    function Cargar_Codigos(){
        $(document)
        .ajaxStart(function () {
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

        var dataString = new FormData(document.getElementById('formulario_productoie'));
        var url="<?php echo site_url(); ?>Snappy/Cargar_Codigos";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#tabla_codigo').html(data);
                
            }
        });

        Calculo_Desvalorizacion();
    }

    function Calculo_Desvalorizacion(){
        if($('#fec_compra').val().trim() !="" && $('#precio_u').val().trim() !="" && $('#cantidad').val().trim() !="" && $('#desvalorizacion').val().trim() !=""){
            
            f1 = $('#fec_compra').val();
            f2 = $('#hoy').val();
            total=$('#precio_u').val()*$('#cantidad').val();
            aF1 = f1.split("-");
            aF2 = f2.split("-");
            
            numMeses = aF2[0]*12 + aF2[1] - (aF1[0]*12 + aF1[1]);
            if (aF2[2]<aF1[2]){
                numMeses = numMeses - 1;
            }
            if(numMeses>0){
                valor_actual=total-((($('#desvalorizacion').val()/100)*numMeses)*total);
                $('#valor_actual').val(valor_actual.toFixed(2));
            }else{
                $('#valor_actual').val(total.toFixed(2));
            }



        }
    }

    function Cancelar() {
        window.location = "<?php echo site_url(); ?>Snappy/Producto";
        
    }
    

    $('#archivose').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['png','jpeg','jpg','xls','xlsx','pdf'],
    });

    function Busca_Subtipo(){
        var dataString = new FormData(document.getElementById('formulario_productoie'));
        var url="<?php echo site_url(); ?>Snappy/Buscar_Subtipo_Inventario";
        $.ajax({
            type:"POST",
            url: url,
            data:dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                $('#div_subtipo').html(data);
            }
        });
    }


    function Actualizar_ProductoI(){
        var dataString = new FormData(document.getElementById('formulario_productoie'));
        var url="<?php echo site_url(); ?>Snappy/Update_Producto";

        if (valida_prodie()) {
            bootbox.confirm({
                title: "Editar Datos de Producto",
                message: "¿Desea actualizar datos del Producto?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $.ajax({
                            type:"POST",
                            url: url,
                            data:dataString,
                            processData: false,
                            contentType: false,
                            success:function (data) {
                                if(data=="error"){
                                    swal.fire(
                                    'Actualización Denegada!',
                                    'Existe un registro con mismos datos',
                                    'error'
                                ).then(function() {
                                    
                                    
                                });
                                }else{
                                    swal.fire(
                                    'Actualización Exitosa!',
                                    '',
                                    'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>Snappy/Producto";
                                    
                                });
                                }
                                
                            }
                        });
                    }
                } 
            });        
        }
    }
    

    function valida_prodie() {
        if($('#id_tipo_inventario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar tipo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#id_subtipo_inventario').val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar subtipo.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#fec_compra').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar fecha de compra.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#precio_u').val().trim() == '') {
            Swal(
                'Ups!',
                'Debe ingresar precio unitario.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#cantidad').val().trim() == '' || $('#cantidad').val().trim() == '0') {
            Swal(
                'Ups!',
                'Debe ingresar cantidad.',
                'warning'
            ).then(function() { });
            return false;
        }

        if($('#desvalorizacion').val().trim() == '' ) {
            Swal(
                'Ups!',
                'Debe ingresar porcentaje de desvalorizacion    .',
                'warning'
            ).then(function() { });
            return false;
        }

        return true;
    }

</script>

<script>
    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Snappy/Descargar_Imagen_ProductoI/" + image_id);
    });

    $(document).on('click', '#delete_file', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Snappy/Delete_Imagen_ProductoI',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });

    $(".img_post_historial").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    $(document).on('click', '#download_file_historial', function () {
        image_id = $(this).data('image_id');
        window.location.replace("<?php echo site_url(); ?>Snappy/Descargar_Imagen_ProductoI_Historial/" + image_id);
    });

    $(document).on('click', '#delete_file_historial', function () {
        var image_id = $(this).data('image_id');
        var file_col = $('#i_' + image_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(); ?>Snappy/Delete_Imagen_ProductoI_Historial',
            data: {'image_id': image_id},
            success: function (data) {
                file_col.remove();            
            }
        });
    });
</script>

<?php $this->load->view('Admin/footer'); ?>