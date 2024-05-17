<form id="formulario_anular" method="POST" enctype="multipart/form-data"   class="formulario">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" id="exampleModalLabel" ><b>Anular Envío :  <span><?php echo $get_id[0]['Nombre']; ?></span></b></h5>
    </div>

    <div class="modal-body" >
        <div class="col-md-12 row">       
            <div class="form-group col-md-4">
                <label class="text-bold">Observaciones: </label>
                <div class="col">
                    <div class="col">
                        <textarea id="obs_anulado" name="obs_anulado" cols="100" rows="10" class="form-control" style="width: 836px;"></textarea>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
 
    <div class="modal-footer">
        <input type="hidden"id="id_fotocheck" name="id_fotocheck" value="<?php echo $get_id[0]['id_fotocheck']; ?>">
        <button type="button" class="btn btn-primary" onclick="Anular_Envio();"> 
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar 
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal"> 
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Anular_Envio(){
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

        var tipo_excel = $('#tipo_excel').val();
        var dataString = new FormData(document.getElementById('formulario_anular'));  
        var url="<?php echo site_url(); ?>AppIFV/Anular_Envio";

        Swal({
            title: '¿Realmente desea anular el registro',
            text: "El registro será anulado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"POST",
                    url:url,
                    data: dataString,
                    processData: false,
                    contentType: false,
                    success:function () {
                        Lista_Fotocheck_Alumnos(tipo_excel); 
                        $("#LargeLabelModal .close").click()
                    }
                });
            }
        })    
    }
</script>