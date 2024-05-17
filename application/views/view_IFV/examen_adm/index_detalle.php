<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('view_IFV/header'); ?>
<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<?php $this->load->view('view_IFV/nav'); ?>


<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold">
                        <b><?php echo $get_id[0]['nom_examen'] ?></b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a type="button" href="<?= site_url('AppIFV/Examen') ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table id="example" class="table table-striped table-bordered" >
                    <thead >
                        <tr style="background-color: #E5E5E5;">
                            <th width="20%"><div >Carrera</div></th>
                            <th width="15%"><div >Área</div></th>
                            <th width="10%"><div >Orden</div></th>
                            <th width="10%"><div >N° Preguntas</div></th>
                            <th width="1%"><div ></div></th>
                        </tr>
                    </thead>

                    <tbody >
                        <?php foreach($list_area as $list) {  ?>                                           
                            <tr class="even pointer">                                    
                                <td ><?php echo $list['carrera']; ?></td>
                                <td ><?php echo $list['nombre']; ?></td>
                                <td ><?php echo $list['orden']; ?></td>
                                <td ><?php if(count($list_pregunta)>0){
                                        foreach($list_pregunta as $pregunta){
                                            if($list['id_area']==$pregunta['id_area']){ 
                                                echo $pregunta['cantidad'];
                                            }
                                        }
                                }else{
                                    echo "0";
                                }  ?></td>
                                <td>
                                    <a title="Más Información" href="<?= site_url('AppIFV/Preguntas') ?>/<?php echo $list["id_area"]; ?>/<?php echo $get_id[0]['id_examen'] ?>">
                                        <img title="Lista de Preguntas" src="<?= base_url() ?>template/img/ver.png"  style="cursor:pointer; cursor: hand;" width="22" height="22" />
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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

    var table=$('#example').DataTable( {
        "order": [[ 0, "Código" ]],
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50
    } );


    $(document).ready(function() {
        $("#examenadmision").addClass('active');
        $("#hexamenadmision").attr('aria-expanded', 'true');
        $("#examenf").addClass('active');
		document.getElementById("rexamenadmision").style.display = "block";
    });

   
} );
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


$("#btn_invitar_prueba").on('click', function(e)
{
    var contador=0;
    var contadorf=0;
  // Recorremos todos los checkbox para contar los que estan seleccionados
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
            title: "Invitar alumnos",
            message: "¿Desea invitar?",
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
    }
    else{
        msgDate = 'Debe seleccionar al menos 1 alumno.';
        bootbox.alert(msgDate)
        return false;
    }
});


 $('#btn_mail').on('click', function(e)
{

    if ($('#email').val().trim() ==="") {
        $("#email").focus();
    } else{

        bootbox.confirm("¿Está seguro enviar correo al Usuario", function(result) {
            if (result) {
                
                    var email = $("#email").val();
                    
                    $.ajax({
                        url : base_url + "index.php/AppIFV/Enviar_Correo",
                        // var url = "<?php echo site_url(); ?>AppIFV/Enviar_Correo";
                        data: {'email':email},
                        type: 'POST',
                        success: function (data) {
                        bootbox.alert("Realizado Correctamente!", function(){ 
                        location.reload();
                        });
                        },
                        error: function() {
                                
                        }
                    });
                }
                
            });
            return false;
        }               
});

</script>


<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>

<script>
    $("#btn_invitar").on('click', function(e)
    {
        var contador=0;
        var contadorf=0;
        var dataString = $("#frm_snappy").serialize();
        var url = "<?php echo site_url(); ?>AppIFV/Invitar";

        $("input[type=checkbox]").each(function(){
            if($(this).is(":checked"))
                contador++;
        });

        /*if(contador>0 && document.getElementById('total').checked)
        {
            contadorf=contador-1;
        }*/
        //else{
            contadorf=contador;
        //}
        
        if(contadorf>0)
        {
            bootbox.confirm({
                title: "Enviar Invitación",
                message: "¿Desea invitar a  "+contadorf+ " postulantes?",
                buttons: {
                    cancel: {
                        label: 'Cancelar'
                    },
                    confirm: {
                        label: 'Confirmar'
                    }
                },
                callback: function (result) {
                    $.ajax({
                        type:"POST",
                        url:url,
                        data:dataString,
                        success:function () {
                            Carga_Mensaje();
                            }
                    });

                } 
            });
        }else{
            msgDate = 'Debe seleccionar al menos 1 postulante.';
            bootbox.alert(msgDate)
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

    /*function seleccionart(){
        if (document.getElementById('total').checked)
        {
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_postulante')
                    inp[i].checked=1;
            }
        }

        else
        {
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='id_postulante')
                    inp[i].checked=0;
            }
        }
    }*/
</script>