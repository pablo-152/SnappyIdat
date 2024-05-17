<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Examenes de Admisión (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo" style="cursor:pointer;margin-right:5px;" data-toggle="modal" data-target="#acceso_modal"  app_crear_per="<?= site_url('AppIFV/Modal_Examen_Ifv') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a style="cursor:pointer;margin-right:5px;" id="btn_invitar">
                            <img  src="<?= base_url() ?>template/img/copy.png" alt="Duplicar Examen"  style="cursor:pointer; cursor: hand;" />
                            <!--<img src="" alt=""><svg   width="50" height="50" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="copy" class="svg-inline--fa fa-copy fa-w-14" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M320 448v40c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V120c0-13.255 10.745-24 24-24h72v296c0 30.879 25.121 56 56 56h168zm0-344V0H152c-13.255 0-24 10.745-24 24v368c0 13.255 10.745 24 24 24h272c13.255 0 24-10.745 24-24V128H344c-13.2 0-24-10.8-24-24zm120.971-31.029L375.029 7.029A24 24 0 0 0 358.059 0H352v96h96v-6.059a24 24 0 0 0-7.029-16.97z"/></svg>-->
                        </a>
                        <a href="<?= site_url('AppIFV/Excel_Examen') ?>">
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
                <form method="post" id="formulario_examen" enctype="multipart/form-data"  class="formulario">
                    <table class="table table-hover table-bordered table-striped" id="example" width="100%">
                        <thead >
                            <tr style="background-color: #E5E5E5; font-size:13px">
                                <!--<th width="15%"><div align="center">&nbsp;<input type="checkbox" style="width: 20px" id="total" name="total" onclick="seleccionart();" value="1"></div></th>-->
                                <th><div align="center"></div></th>
                                <th><div align="center">Descripción</div></th>
                                <th width="12%"><div align="center">Fecha Examen</div></th>
                                <th width="12%"><div align="center">Fecha Publica.</div></th>
                                <th width="7%"><div align="center">Contenido</div></th>
                                <th width="5%"><div align="center">Enviados</div></th>
                                <th width="5%"><div align="center">Sin Iniciar</div></th>
                                <th width="5%"><div align="center">Sin Concluir</div></th>
                                <th width="5%"><div align="center">Concluidos</div></th>
                                <th width="5%"><div align="center">Tiempo</div></th>
                                <th width="5%"><div align="center">Evaluación</div></th>
                                <th width="10%"><div align="center">Estado</div></th>
                                <th><div ></div></th>
                            </tr>
                        </thead>

                        <tbody >
                            <?php foreach($list_examen2 as $list) {  ?>                                           
                                <tr class="even pointer" style=" font-size:13px">    
                                    <td><input required type="checkbox" id="id_examen[]" name="id_examen[]" value="<?php echo $list['id_examen']; ?>"></td>                                
                                    <td nowrap ><?php echo substr($list['nom_examen'],0,30 ); ?></td>
                                    <td align="center" nowrap><?php echo $list['fecha_limite']; ?></td>
                                    <td align="center"><?php echo $list['fecha_resultados']; ?></td>
                                    <td align="center" nowrap ><?php
                                        foreach($list_examen as $cant){
                                            if($cant['id_examen']==$list['id_examen']){
                                                if($cant['cantidad']>=(count($limite)*20)){echo "<span class='badge' style='background-color: #92D050;border-color: #92D050;'>Completo</span>"; 
                                                }else{echo "<span class='badge badge-info'>Incompleto</span>"; 
                                                }
                                            } } ?>
                                    </td>
                                    <td align="center"><?php echo $list['Enviados']; ?></td>
                                    <td align="center"><?php echo $list['Sin Iniciar']; ?></td>
                                    <td align="center"><?php echo $list['Sin Concluir'] ?></td>
                                    <td align="center"><?php echo $list['Concluido']; ?></td>
                                    <td align="center" nowrap ><?php
                                        foreach($list_examen3 as $list1){
                                            if($list1['id_examen']==$list['id_examen']){
                                                echo substr($list1['Tiempo'],0,8); 
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td align="center" nowrap ><?php
                                        foreach($list_examen3 as $list1){
                                            if($list1['id_examen']==$list['id_examen']){
                                                echo substr($list1['Evaluacion'],0,2); 
                                            }
                                        } ?>
                                    </td>
                                    <td nowrap><?php echo $list['nom_status']; if($list['Concluido']>0){echo " - Terminado";} ?></td>
                                    <td align="center" nowrap>
                                        <img title="Editar Datos Empresa" data-toggle="modal" 
                                        data-target="#acceso_modal_mod" 
                                        app_crear_mod="<?= site_url('AppIFV/Modal_Update_Examen_ifv') ?>/<?php echo $list["id_examen"]; ?>" 
                                        src="<?= base_url() ?>template/img/editar.png" style="cursor:pointer; cursor: hand;" 
                                        width="22" height="22" />
                                        <a title="Más Información" href="<?= site_url('AppIFV/Detalle_Examen') ?>/<?php echo $list["id_examen"]; ?>">
                                            <img title="Más Información" src="<?= base_url() ?>template/img/ver.png"  style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

        <div id="clockdate" >
          <div class="clockdate-wrapper">
              <div id="clock"></div>
              <div id="date"></div>
          </div>
      </div>   
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#examenadmision").addClass('active');
        $("#hexamenadmision").attr('aria-expanded', 'true');
        $("#examenf").addClass('active');
		document.getElementById("rexamenadmision").style.display = "block";
    });
</script>

<script>
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
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
        ordering:false,
        "order": [[ 0, "Código" ]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50
    } );

   
} );
</script>

<script>


    $("#btn_invitar").on('click', function(e)
    {
        var contador=0;
        var contadorf=0;
        var dataString = $("#formulario_examen").serialize();
        var url = "<?php echo site_url(); ?>AppIFV/Duplicar_Examen";

        $("input[type=checkbox]").each(function(){
            if($(this).is(":checked"))
                contador++;
        });


        if(contador==1)
        {
            bootbox.confirm({
                title: "Duplicar Examen",
                message: "¿Esta seguro de duplicar este examen?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    if (result==false) {
                    
                    }else{
                       $.ajax({
                        type:"POST",
                        url:url,
                        data:dataString,
                        success:function (data) {
                            swal.fire(
                            'Duplicado Exitoso!',
                            '',
                            'success'
                                ).then(function() {
                                    window.location = "<?php echo site_url(); ?>AppIFV/Examen";
                                });
                            }
                    }); 
                    }
                    

                } 
            });
        }else if(contador>1){
            Swal(
                'Ups!',
                'Debe seleccionar solo un Examen.',
                'warning'
            ).then(function() { });
            return false;
        }else{
            Swal(
                'Ups!',
                'Debe seleccionar Examen.',
                'warning'
            ).then(function() { });
            return false;
        }
    });

    function Carga_Mensaje()
    {
        swal.fire(
                'Invitación Exitosa!',
                'Haga clic en el botón!',
                'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                    });
    }

</script>

<script>
$(document).ready(function() {
    /**/var msgDate = '';
    var inputFocus = '';
});
var base_url = "<?php echo site_url(); ?>";

function Insert_Requerimiento() {
    
    var dataString = new FormData(document.getElementById('formulario_excel'));
    var url="<?php echo site_url(); ?>AppIFV/Insert_Listas";
    if (Valida_Import_Excel()) 
    {
        $.ajax({
            url: url,
            data:dataString,
            type:"POST",
            processData: false,
            contentType: false,
            
            success:function (data) {
                var mensaje = data;
                /*validacion=cadena.substr(0,1);
                mensaje=cadena.substr(1);*/
                if(mensaje!=""){
                    swal.fire(
                        'Carga con Errores!',
                        mensaje,
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                    });
                }else{
                    swal.fire(
                        'Carga Exitosa!',
                        /*mensaje,*/
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Postulantes";
                    });
                }
            }
        });
    }
    else
    {
        bootbox.alert(msgDate)
        var input = $(inputFocus).parent();
        $(input).addClass("has-error");
        $(input).on("change", function () {
            if ($(input).hasClass("has-error")) {
                $(input).removeClass("has-error");
            }
        });
    }
    
}

function Valida_Import_Excel() {
    

    if($('#archivo_excel').val() === '') {
        msgDate = 'Debe seleccionar un archivo excel';
        inputFocus = '#archivo_excel';
        return false;
    }

    //if ($('#semana').val() <)

    return true;
}

$("#btn_asignar").on('click', function(e)
{

    /*if($('#sector').val().trim() === '0') {
            msgDate = 'Debe seleccionar un sector';
            inputFocus = '#sector';
            bootbox.alert(msgDate);
            return false;
    }if($('#id_lista').val().trim() === '0') {
        msgDate = 'Debe seleccionar una lista';
        inputFocus = '#id_lista';
        bootbox.alert(msgDate);
        return false;
    }
    if($('#archivo_excel').val().trim() === '') {
        msgDate = 'Debe seleccionar un archivo excel';
        inputFocus = '#archivo_excel';
        bootbox.alert(msgDate);
        return false;
    }*/
    
    var url = "<?php echo site_url(); ?>AppIFV/Valida_RLista";
    $.ajax({
        url: url, 
        data: $("#frm_soldador").serialize(),
        type: 'POST',        
        success: function(resp){
            //alert(resp);
            if (resp=='error') {
                msgDate = 'Registro ya encontrado.';
                bootbox.alert(msgDate);
            }
            else
            {
                $('#frm_soldador').submit();
                msgDate = 'Lista insertada correctamente.';
                bootbox.alert(msgDate);
            }
            //$('#listaequipos').html(data);               
        }
    });    
});


</script>


<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>
