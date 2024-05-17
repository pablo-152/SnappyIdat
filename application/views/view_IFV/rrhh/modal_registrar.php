<style>
    .grande_check{
        width: 20px;
        height: 20px;
    }
</style>

<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title"><b>Editar RRHH</b></h5>
    </div>

    <div class="modal-body" style="max-height:520px; overflow:auto;">
        <div class="col-md-12 row">
            <?php foreach($list_especialidad as $list){ ?>
                <div class="form-group col-md-2">
                    <input type="checkbox" class="grande_check" id="<?php echo $list['abreviatura']."_i"; ?>" name="<?php echo $list['abreviatura']."_i"; ?>" value="1">
                    <label class="form-group text-bold"><?php echo $list['abreviatura']; ?></label><span>&nbsp;</span>
                </div>
            <?php } ?>
        </div>  
    </div>
    
    <div class="modal-footer">
        <input type="hidden" id="EmployeeId_i" name="EmployeeId_i" value="<?php echo $EmployeeId; ?>">
        <button type="button" class="btn btn-primary" onclick="Insert_Rrhh()">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    function Insert_Rrhh(){
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

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url="<?php echo site_url(); ?>AppIFV/Insert_Rrhh";

        if (Valida_Insert_Rrhh()) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Actualización Exitosa',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        window.location = "<?php echo site_url(); ?>AppIFV/Rrhh";
                    });
                }
            });
        }
    }

    function Valida_Insert_Rrhh() {
        return true;
    }
</script>
