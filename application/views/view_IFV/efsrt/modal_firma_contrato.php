<form method="post" id="formulario_firma_contrato" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subir Contrato de Menores de Edad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:650px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Alumno(s): </label>
            </div>
            <div class="form-group col-md-10"> 
                <select class="form-control" id="id_alumno_fc" name="id_alumno_fc">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_alumno as $list){ ?>
                        <option value="<?php echo $list['Id']; ?>"><?php echo $list['Alumno']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2"> 
                <label class="control-label text-bold">Contrato: </label> 
            </div>
            <div class="form-group col-md-4">
                <input type="file" id="contrato_fc" name="contrato_fc" onchange="Validar_Extension_Fc();">
            </div> 
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Firma_Contrato();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Validar_Extension_Fc(){
        var archivoInput = document.getElementById('contrato_fc');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf)$/i;

        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivos con extensiones .pdf.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = ''; 
            return false;
        }else{
            return true;         
        }
    }

    function Insert_Firma_Contrato(){
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
            })
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
        
        var dataString = new FormData(document.getElementById('formulario_firma_contrato'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Firma_Contrato_Efsrt";  

        var grupo = $('#grupo').val();
        var id_especialidad = $('#id_especialidad').val();
        var id_modulo = $('#id_modulo').val();
        var id_turno = $('#id_turno').val();

        dataString.append('grupo', grupo);
        dataString.append('id_especialidad', id_especialidad);
        dataString.append('id_modulo', id_modulo);
        dataString.append('id_turno', id_turno);

        if (Valida_Insert_Firma_Contrato()) {
            $.ajax({
                type:"POST",
                url:url,
                data: dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    Lista_Firma_Contrato();
                    $("#acceso_modal .close").click()
                }
            });        
        }  
    }

    function Valida_Insert_Firma_Contrato() {
        if($('#id_alumno_fc').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#contrato_fc').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Contrato.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>