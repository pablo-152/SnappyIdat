<form id="formulario_detalle" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Entregar Encomienda</b></h5>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;text-align:justify;">
        <p>
            No registre entrega mientras no tengas confirmacion absoluta que entregas al cliente el dia de hoy. Esta accion no se
            puede desacer y registra usuario, fecha y hora.
        </p>
        <p>Es necesario imprimir de nuevo recibo para que firme en recibido.</p>
        <p style="margin-left: 30px;"><b>Fecha entrega:</b> <span><?php echo date('d/m/Y'); ?></span></p>
        <p style="margin-left: 30px;"><b>Usuario:</b> <span><?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?></span></p>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background-color: #0070C0;" onclick="Entrega_Encomienda('<?php echo $id_encomienda; ?>');"> 
            Entregar
        </button>     
    </div>
</form>

<script>
    function Entrega_Encomienda(id){ 
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

        var url="<?php echo site_url(); ?>Laleli2/Entrega_Encomienda";

        $.ajax({
            type:"POST",
            url:url,
            data:{'id_encomienda':id},
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No hay stock disponible!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    Lista_Encomienda(1);
                    $("#acceso_modal_pequeno .close").click()
                }
            }
        });
    } 
</script>
