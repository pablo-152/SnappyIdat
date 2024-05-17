<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>
<?php $this->load->view('Admin/header'); ?>

<?php $this->load->view('Admin/nav'); ?>

<style>
    table tbody tr td:nth-child(1),table tbody tr td:nth-child(2),table tbody tr td:nth-child(3),table tbody tr td:nth-child(4),table tbody tr td:nth-child(5),table tbody tr td:nth-child(8),table tbody tr td:nth-child(9),table tbody tr td:nth-child(11),table tbody tr td:nth-child(13){
        text-align: center;
    }

    <?php $i=1; foreach($list_proyecto as $list) { ?>
        table tbody tr:nth-child(<?php echo $i; ?>) td:nth-child(3){
            background-color: <?php echo $list['color']; ?>;
        }
    <?php $i++; } ?>
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                    
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Estado Snappy (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <?php if ($id_nivel==1 || $id_nivel==6) { ?>
                            <!--<a id="btn_archivar" style="margin-right: 5px;">
                                <img src="<?= base_url() ?>template/img/archivar.png" alt="Archivar" />
                            </a>-->
                            <a onclick="Archivar()" style="margin-right: 5px;">
                                <img src="<?= base_url() ?>template/img/archivar.png" alt="Prueba" />
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
            <form method="post" id="frm_snappy" enctype="multipart/form-data" action="<?= site_url('Snappy/archivar')?>" class="formulario">
                <input type="hidden" id="cadena" name="cadena" class="form-control"  value="">
                <input type="hidden" id="cantidad" name="cantidad" class="form-control"  value="0">
                <input type="hidden" id="prueba" name="prueba" class="form-control" >

                <div class="col-lg-12" id="divtabla">
                    <table id="example" class="table table-hover table-striped table-bordered" width="100%">
                        <thead>
                            <tr style="background-color: #E5E5E5;">
                                <?php if ($id_nivel==1 || $id_nivel==6) { ?>
                                    <th class="text-center" width="3%"><input type="checkbox" style="width: 20px" id="total" name="total" value="1"></th>
                                <?php } ?>
                                <th class="text-center" width="5%" title="Código">Cod</th>
                                <th class="text-center" width="7%">Status</th>
                                <th class="text-center" width="5%" title="Empresa">Emp</th>
                                <th class="text-center" width="7%">Tipo</th>
                                <th class="text-center" width="8%">SubTipo</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center" width="5%">Snappy's</th>
                                <th class="text-center" width="6%">Agenda</th>
                                <th class="text-center" width="6%">Usuario</th>
                                <th class="text-center" width="6%">Fecha</th>
                                <th class="text-center" width="6%">Usuario</th>
                                <th class="text-center" width="6%">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_proyecto as $list) {  ?> 
                                <tr class="even pointer">                                          
                                    <?php if ($id_nivel==1 || $id_nivel==6) { ?>        
                                        <td><input type="checkbox" id="proyecto[]" name="proyecto[]" value="<?php echo $list['id_proyecto']; ?>"></td>
                                    <?php } ?>
                                    <td><?php echo utf8_encode($list['cod_proyecto']); ?></td>
                                    <td><?php echo $list['nom_statusp']; ?></td>
                                    <!--<td nowrap>
                                        <?php 
                                            $empresa="";
                                            foreach($list_empresam as $emp){
                                                if($emp['id_proyecto']==$list['id_proyecto']){
                                                    $empresa=$empresa.$emp['cod_empresa'].",";
                                                }
                                            }
                                            echo substr($empresa,0,-1);
                                        ?>                                        
                                    </td>-->
                                    <td><?php echo $list['cod_empresa']; ?></td>
                                    <td><?php echo $list['nom_tipo']; ?></td>
                                    <td><?php echo $list['nom_subtipo']; ?></td>
                                    <td nowrap ><?php echo $list['descripcion']; ?></td>
                                    <td><?php echo $list['s_artes']+$list['s_redes']; ?></td>
                                    <td><?php if ($list['fec_agenda']!='0000-00-00') echo date('d/m/Y', strtotime($list['fec_agenda'])); ?></td>
                                    <td><?php echo $list['ucodigo_solicitado']; ?></td>
                                    <td><?php if ($list['fec_solicitante']!='0000-00-00') echo date('d/m/Y', strtotime($list['fec_solicitante'])); ?></td>
                                    <td><?php echo $list['ucodigo_asignado']; ?></td>
                                    <td><?php if ($list['fec_termino']!='0000-00-00 00:00:00') echo date('d/m/Y', strtotime($list['fec_termino'])); ?></td>
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
                        $('#prueba').val(this.value);
                        //$("input:checkbox").prop('checked', $(this).prop("checked"));
                        if (document.getElementById('total').checked){
                            $("#total").prop('checked', false); 
                            let checked = this.checked;
                            let total = 0;
                            let data = [];
                            let cadena='';
                            
                            table.data().each(function (info) {
                            var txt = info[0];
                                if (checked) {
                                    total += 1;
                                    txt = txt.substr(0, txt.length - 1) + ' checked>';
                                    cadena += info[1]+",";
                                }/* else {
                                    txt = txt.replace(' checked', '');
                                }*/
                                info[0] = txt;
                                data.push(info);
                            });
                            
                            table.clear().rows.add(data).draw();
                            $cantidad.val(total);
                            $cadena.val(cadena);

                        }else{
                            /*document.querySelector("#total").click();*/
                        }
                }
            });
        });

        var table = $('#example').DataTable({
            ordering: false,
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

        // Seleccionar todo en la tabla
        let $dt = $('#example');
        let $total = $('#total');
        let $cadena = $('#cadena');
        let $cantidad = $('#cantidad');
  
        // Cuando hacen click en el checkbox del thead
        $dt.on('change', 'thead input', function (evt) {
            var tipo=$('#prueba').val();
            if(tipo==""){
                let checked = this.checked;
                let total = 0;
                let data = [];
                let cadena='';
                
                table.data().each(function (info) {
                var txt = info[0];
                    if (checked) {
                        total += 1;
                        txt = txt.substr(0, txt.length - 1) + ' checked>';
                        cadena += info[1]+",";
                    } else {
                        txt = txt.replace(' checked', '');
                    }
                    info[0] = txt;
                    data.push(info);
                });
                
                table.clear().rows.add(data).draw();
                $cantidad.val(total);
                $cadena.val(cadena);
            }else{
                if (document.getElementById('total').checked)
                {
                    var inp=document.getElementsByTagName('input');
                    for(var i=0, l=inp.length;i<l;i++){
                        if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='proyecto')
                            inp[i].checked=1;
                    }
                }

                else
                {
                    let checked = this.checked;
                    let total = 0;
                    let data = [];
                    let cadena='';
                    
                    table.data().each(function (info) {
                    var txt = info[0];
                        if (checked) {
                            total += 1;
                            txt = txt.substr(0, txt.length - 1) + ' checked>';
                            cadena += info[1]+",";
                        } else {
                            txt = txt.replace(' checked', '');
                        }
                        info[0] = txt;
                        data.push(info);
                    });
                    
                    table.clear().rows.add(data).draw();
                    $cantidad.val(total);
                    $cadena.val(cadena);
                } 
            }
        });
  
        // Cuando hacen click en los checkbox del tbody
        $dt.on('change', 'tbody input', function() {
            let q= $('#cadena').val();
            let cantidad= $('#cantidad').val();
            let info = table.row($(this).closest('tr')).data();
            let total = parseFloat($total.val());
            let cadena = $cadena.val();
            let price = parseFloat(info[1]);
            let cadena2 = info[1]+",";
            //total += this.checked ? price : price * -1;
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
            //cadena += this.checked ? cadena2 : info[1]+", ";
            
        });


        
    });
    function Archivar(){
        var p = $('#prueba').val();
        if(p!=""){
            var contador=0;
            var contadorf=0;
            var url = "<?php echo site_url(); ?>Metalikas/Valida_Asignacion_Pintor";
            var id_ot=$('#id_ot').val();

            $("input[type=checkbox]").each(function(){
                if($(this).is(":checked"))
                    contador++;
            });

            if(contador>0 && document.getElementById('total').checked)
            {
                contadorf=contador-1;
            }
            else{
                contadorf=contador;
            }
            if(contadorf>0)
            {
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

                /*$.ajax({
                        url: url, 
                        data: $("#frm_snappy").serialize(),
                        type: 'POST',        
                        success: function(data){
                            if (data=='error') {
                                msgDate = 'Registro ya encontrado.';
                                bootbox.alert(msgDate);
                            }else{
                                bootbox.confirm({
                                title: "Asignar Pintor",
                                message: "¿Desea asignar "+contadorf+ " pintor(es) o granallador(es)?",
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
                                        swal.fire(
                                        'Asignación Exitosa!',
                                        'Haga clic en el botón!',
                                        'success'
                                            ).then(function() {
                                                $('#frm_inspector').submit();
                                            });
                                    }
                                } 
                            });
                        }             
                    }
                });*/
            }
            
            else{
                Swal(
                    'Ups!',
                    'Debe seleccionar al menos 1 registro.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }else{
            var contadorf=$('#cantidad').val();
        
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
        }
    }

    function seleccionart(){
        if (document.getElementById('total').checked)
        {
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='proyecto')
                    inp[i].checked=1;
            }
        }

        else
        {
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='proyecto')
                    inp[i].checked=0;
            }
        }
    }
</script>
<?php $this->load->view('Admin/footer'); ?>

<script>
    $("#btn_archivar").on('click', function(e){
        var contadorf=$('#cantidad').val();
        
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