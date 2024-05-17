<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('Admin/header'); ?>

<?php $this->load->view('Admin/nav'); ?>
<style>

table {
  table-layout: fixed;
  /*margin: 0rem auto;*/
  width: 100%;
  /*border-collapse: collapse;*/
}

th:last-child {width: 5%;}

table thead{
    background-color:#e5e5e5;
    font-weight: bold;
    font-size: 14px;
}

table tbody tr td{
    font-size: 12px;
}

</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Estado Snappy</b></span></h4>
                </div>

                <div class="heading-elements" style="position: absolute;top: 50%;margin: -25px 0 0 -25px;">
                    <div class="heading-btn-group" >
                        <?php if ($id_nivel==1 || $id_nivel==6) { ?>
                            <a id="btn_archivar" style="margin-right: 5px;">
                                <img src="<?= base_url() ?>template/img/archivar.png" alt="Archivar" />
                            </a>
                        <?php } ?>
                        
                        <a href="<?= site_url('Snappy/Excel_snappy') ?>">
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
                <input type="checkbox" id="mostrar_todo" name="mostrar_todo" onclick="Mostrar_Todo();" style="margin-left:10px;margin-right:10px;margin-bottom:20px;">Mostrar todo
            </div>
            <form method="post" id="frm_snappy" enctype="multipart/form-data" action="<?= site_url('Snappy/archivar')?>" class="formulario">
                <div class="col-lg-12" id="divtabla" style="font-size:12px">
                    <table id="example" class="table table-hover table-striped table-bordered" width="100%" style="font-family:'Source Sans Pro', sans-serif;">
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                                <?php if ($id_nivel==1 || $id_nivel==6) { ?>
                                    <th width="5%"><div align="center"><input type="checkbox" id="total" name="total" onclick="seleccionart();" value="1"></div></th>
                                <?php } ?>
                                <th width="7%"><div align="center">Código</div></th>
                                <th width="6%"><div align="center">Status</div></th>
                                <th width="6%"><div align="center">Emp</div></th>
                                <th width="6%"><div align="center">Tipo</div></th>
                                <th width="6%"><div align="center">SubTipo</div></th>
                                <th width="28%"><div align="center">Descripción</div></th>
                                <th width="6%"><div align="center">Snappy's</div></th>
                                <th width="6%"><div align="center">Agenda</div></th>
                                <th width="6%"><div align="center">Usuario</div></th>
                                <th width="6%"><div align="center">Fecha</div></th>
                                <th width="6%"><div align="center">Usuario</div></th>
                                <th width="6%"><div align="center">Fecha</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_proyecto as $list) {  ?> 

                            <tr  class="even pointer">                                          
                                
                                <?php if ($id_nivel==1 || $id_nivel==6) { ?>        
                                <td style="width: 1px;word-wrap: break-word" align="center" ><input type="checkbox" class="select_checkbox" id="proyecto[]" name="proyecto[]" value="<?php echo $list['id_proyecto']; ?>"></td>
                                <?php } ?>
                                <td nowrap align="center" ><?php echo utf8_encode($list['cod_proyecto']); ?></td>
                                <td style="background-color:<?php echo $list['color']; ?>"><?php echo $list['nom_statusp']; ?></td>
                                <td nowrap>
                                
                                <?php 
                                                    $empresa="";
                                                    foreach($list_empresam as $emp){
                                                    if($emp['id_proyecto']==$list['id_proyecto']){
                                                        $empresa=$empresa.$emp['cod_empresa'].",";
                                                    }
                                                    }
                                                    echo substr($empresa,0,-1);
                                                ?>                                        
                                </td>
                                <td ><?php echo $list['nom_tipo']; ?></td>
                                <td><?php echo $list['nom_subtipo']; ?></td>
                                <td style="min-width: 100px;max-width: 308px; overflow: hidden;" nowrap ><?php echo $list['descripcion']; ?></td>
                                <td align="center" ><?php echo $list['s_artes']+$list['s_redes']; ?></td>
                                <td align="center" ><?php if ($list['fec_agenda']!='0000-00-00') echo date('d/m/Y', strtotime($list['fec_agenda'])); ?></td>
                                <td><?php echo $list['ucodigo_solicitado']; ?></td>

                                <td align="center" ><?php if ($list['fec_solicitante']!='0000-00-00') echo date('d/m/Y', strtotime($list['fec_solicitante'])); ?></td>
                                <td><?php echo $list['ucodigo_asignado']; ?></td>
                                <td align="center" ><?php if ($list['fec_termino']!='0000-00-00 00:00:00') echo date('d/m/Y', strtotime($list['fec_termino'])); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
            
        // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title!=""){
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
            }else{
                $(this).html('');
            }
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
            //columnDefs:[{className: 'select-checkbox'}],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50
        });

        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded', 'true');
        $("#siredes").addClass('active');
        $("#hiredes").attr('aria-expanded', 'true');
        $("#estado_snappy").addClass('active');
        document.getElementById("riredes").style.display = "block";
        document.getElementById("rcomunicacion").style.display = "block";

        
    });
</script>
<?php $this->load->view('Admin/footer'); ?>

<script>
    $("#btn_archivar").on('click', function(e){
        var contador=0;
        var contadorf=0;
        // Recorremos todos los checkbox para contar los que estan seleccionados
        $("input[type=checkbox]").each(function(){
            if($(this).is(":checked"))
                contador++;
        });

        if(contador>0 && $('#total').is(':checked') && $('#mostrar_todo').is(':checked')){
            contadorf=contador-2;
        }else if(contador>0 && !$('#total').is(':checked') && !$('#mostrar_todo').is(':checked')){
            contadorf=contador;
        }else{
            contadorf=contador-1;
        }
        
        if(contadorf>0){
            bootbox.confirm({
                title: "Estado Snappy",
                message: "¿Desea archivar "+contadorf+ " proyectos?",
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
                        $('#frm_snappy').submit();
                    }
                } 
            });
        }else{
            Swal(
                'Ups!',
                'Debe seleccionar al menos 1 registro.',
                'warning'
            ).then(function() { });
            return false;
        }
    });

    function Mostrar_Todo(){
        if (document.getElementById('mostrar_todo').checked){
            var condicion="todo";
        }else{
            var condicion="normal";
        }

        var url="<?php echo site_url(); ?>Snappy/Mostrar_Todo_Estado_Snappy";
        $.ajax({    
            type:"POST",
            url:url,
            data:{'condicion':condicion},
            success:function (resp) {
                $('#divtabla').html(resp);
            }
        });
    }

    function seleccionart(){
        if (document.getElementById('total').checked){
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='proyecto')
                    inp[i].checked=1;
            }
        }else{
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='proyecto')
                    inp[i].checked=0;
            }
        }
    }

    function Buscar(){
        var busqueda = document.getElementById("busqueda").value;
        var url = "<?php echo site_url(); ?>Snappy/Buscar_snappy/";
        frm = { 'busqueda': busqueda};
        $.ajax({
            url: url, 
            type: 'POST',
            data: frm,
        }).done(function(contextResponse, statusResponse, response) {
            $("#divtabla").html(contextResponse);
        })
    }
</script>