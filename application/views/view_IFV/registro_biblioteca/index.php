<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Registro Biblioteca (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row col-md-12">
                    <div class="form-group col-md-2">
                        <label>Código de barras</label>
                        <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" placeholder="Código de barras" autofocus onkeypress="if(event.keyCode == 13){ Busca_Libro(); }">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="div_busqueda" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#bibliotecas").addClass('active');
        $("#hbibliotecas").attr('aria-expanded', 'true');
        $("#registros_biblioteca").addClass('active');
		document.getElementById("rbibliotecas").style.display = "block";
    });

    /*$('#codigo_barras').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });*/

    function Busca_Libro(){
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
        
        var url = "<?php echo site_url(); ?>AppIFV/Buscar_Libro";
        var cod_libro = $("#codigo_barras").val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {'cod_libro':cod_libro},
            success: function(data){
                if(data=="error"){
                    swal.fire(
                        'Sin Resultados',
                        '¡No se encontró el libro, por favor verifique el código!',
                        'error'
                    ).then(function() {
                        $('#div_busqueda').html('');
                    });
                }else{
                    window.location = "<?php echo site_url(); ?>AppIFV/Descripcion_Libro/"+data;
                    //$('#div_busqueda').html(data);
                }
            }
        });

        //$('#codigo_barras').val('');
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('Admin/footer'); ?>

