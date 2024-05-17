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
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Centros de EFSRT (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a title="Nuevo Centro" style="cursor:pointer; cursor: hand;margin-right:5px" href="<?= site_url('AppIFV/Modal_Centro') ?>">
                            <img src="<?= base_url() ?>template/img/nuevo.png" alt="Exportar Excel" />
                        </a>
                        <a onclick="Excel_Centro()">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row col-md-12 col-sm-12 col-xs-12">
            <a onclick="Muestra_Centro(2);" id="activos" style="color:#FFF;background-color:#00C000;height:32px;width:150px;padding:5px;" class="form-group btn"><span>Activos</span><i class="icon-arrow-down52"></i> </a>
            <a onclick="Muestra_Centro(1);" id="todos" style="color:#000;background-color:#0070c0;height:32px;width:150px;padding:5px;" class="form-group btn"><span>Todos</span><i class="icon-arrow-down52"></i> </a>    
        </div>
        <div class="row" id="list_centro">
            <input type="hidden" id="parametro" name="parametro" value="<?php echo $parametro ?>">
            <div class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#practicas").addClass('active');
        $("#hpracticas").attr('aria-expanded', 'true');
        $("#centros").addClass('active');
		document.getElementById("rpracticas").style.display = "block";

        Muestra_Centro(2);
    });
</script>

<script>
    function Muestra_Centro(id) {
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

        var id = id;
        var url="<?php echo site_url(); ?>AppIFV/Muestra_Centro";

        $.ajax({
            type:"POST",
            url:url,
            data: {'parametro':id},
            success:function (data) {
                $('#list_centro').html(data);
            }
        });

        var activos = document.getElementById('activos');
        var todos = document.getElementById('todos');

        if(id==1){
            activos.style.color = '#000';
            todos.style.color = '#FFF';
        }else if(id==2){
            todos.style.color = '#000';
            activos.style.color = '#FFF';
        }
    }

    function Excel_Centro(){
        var parametro=$('#parametro').val();
        window.location = "<?php echo site_url(); ?>AppIFV/Excel_Centro/"+parametro;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>

<div class="modal fade" id="documento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Comprobante de Pago</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      
      <div class="modal-body">
        

      <input type="hidden" name="rutafoto" id="rutafoto" value= '<?php echo base_url() ?>'>

            <div align="center" id="capital2"></div>        
      </div>

      

      <div class="modal-footer">      
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script >
    $('#documento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Botón que activó el modal
        var imagen = button.data('imagen') // Extraer la información de atributos de datos
        var imagen2 = imagen.substr(-3)
        var rutapdf= $("#rutafoto").val();
        var nombre_archivo= rutapdf+imagen

        if (imagen!=""){
            if (imagen2=="PDF" || imagen2=="pdf"){
                document.getElementById("capital2").innerHTML = "<iframe height='400px' width='400px' src='"+nombre_archivo+"'></iframe>";
            }else{
                document.getElementById("capital2").innerHTML = "<img height='400px' width='400px' src='"+nombre_archivo+"'>";
            }
        }else{
            document.getElementById("capital2").innerHTML = "No se ha registrado ningún archivo";
        }

        var modal = $(this)
        modal.find('.modal-title').text('Documento')
        $('.alert').hide();

    })
</script>