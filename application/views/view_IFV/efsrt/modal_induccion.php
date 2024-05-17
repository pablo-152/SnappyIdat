<style>
    #example_in tbody tr td:nth-child(1),#example_in tbody tr td:nth-child(5),
    #example_in tbody tr td:nth-child(6),#example_in tbody tr td:nth-child(7){ 
        text-align: center;
    }

    .grande_check{
        width: 20px;
        height: 20px;
    }
</style>

<form method="post" id="formulario_induccion" enctype="multipart/form-data" class="formulario">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de Charla de Inducción de EFSRT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>

    <div class="modal-body" style="max-height:650px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2 text-right"> 
                <label class="control-label text-bold">Fecha: </label>
            </div>
            <div class="form-group col-lg-4"> 
                <input type="date" class="form-control" id="fecha_charla_in" name="fecha_charla_in" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group col-lg-2 text-right">  
                <label class="control-label text-bold">Hora: </label>
            </div>
            <div class="form-group col-lg-2"> 
                <input type="text" class="form-control" id="hora_in" name="hora_in" value="<?php echo date('H'); ?>" maxlength="2" onkeypress="Permitir_Hora();">
            </div>
            <div class="form-group col-lg-2"> 
                <input type="text" class="form-control" id="minuto_in" name="minuto_in" value="<?php echo date('i'); ?>" maxlength="2" onkeypress="Permitir_Minuto();">
            </div>
        </div>

        <div class="row">
            <input type="hidden" id="cadena_in" name="cadena_in" value="">
            <input type="hidden" id="cantidad_in" name="cantidad_in" value="0">

            <table id="example_in" class="table table-hover table-bordered">
                <thead>
                    <tr style="background-color: #E5E5E5;">
                        <th class="text-center"><input type="checkbox" class="grande_check" id="total_in" name="total_in" value="1"></th>
                        <th>Id</th>
                        <th class="text-center" width="20%">Apellido Paterno</th>
                        <th class="text-center" width="20%">Apellido Materno</th>
                        <th class="text-center" width="24%">Nombre</th>
                        <th class="text-center" width="10%">Código</th>
                        <th class="text-center" width="10%">Turno</th>
                        <th class="text-center" width="10%">Sección</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($list_alumno as $list){ ?>
                        <tr class="even pointer text-center">
                            <td><input type="checkbox" class="grande_check"></td>
                            <td><?php echo $list['Id']; ?></td>
                            <td class="text-left"><?php echo $list['Apellido_Paterno']; ?></td>  
                            <td class="text-left"><?php echo $list['Apellido_Materno']; ?></td> 
                            <td class="text-left"><?php echo $list['Nombre']; ?></td> 
                            <td><?php echo $list['Codigo']; ?></td> 
                            <td><?php echo $list['Turno']; ?></td> 
                            <td><?php echo $list['Seccion']; ?></td> 
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 text-right"> 
                <label class="control-label text-bold">Documento: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="file" id="documento_in" name="documento_in" onchange="Validar_Extension_Ie();">
            </div> 
        </div>

        <div class="row">
            <div class="form-group col-lg-2 text-right"> 
                <label class="control-label text-bold">Ponente: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="id_ponente_in" name="id_ponente_in">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_ponente as $list){ ?>
                        <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_codigo']; ?></option>
                    <?php } ?>
                </select>
            </div> 
        </div>
    </div> 

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Insert_Induccion_Efsrt();">
            <i class="glyphicon glyphicon-ok-sign"></i> Guardar
        </button> 
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
        </button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#example_in thead tr').clone(true).appendTo('#example_in thead');
        $('#example_in thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();

            if(title==""){
                $(this).html('');
            }else{
                $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
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

        var table = $('#example_in').DataTable({
            order: [[2,"asc"],[3,"asc"],[4,"asc"]],
            orderCellsTop: true,
            fixedHeader: true,
            pageLength: 50,
            "aoColumnDefs" : [ 
                {
                    'bSortable' : false,
                    'aTargets' : [ 0 ]
                },
                {
                    'targets' : [ 1 ],
                    'visible' : false
                } 
            ]
        });

        // Seleccionar todo en la tabla
        let $dt = $('#example_in');
        let $total = $('#total_in');
        let $cadena = $('#cadena_in');
        let $cantidad = $('#cantidad_in');

        // Cuando hacen click en el checkbox del thead
        $dt.on('change', 'thead input', function (evt) {
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
        });

        // Cuando hacen click en los checkbox del tbody
        $dt.on('change', 'tbody input', function() {
            let q= $('#cadena_in').val();
            let cantidad= $('#cantidad_in').val();
            let info = table.row($(this).closest('tr')).data();
            let total = parseFloat($total.val());
            let cadena = $cadena.val();
            let price = parseFloat(info[1]);
            let cadena2 = info[1]+",";
            
            if(this.checked==false){
                q = q.replace(cadena2, "");
                cantidad = parseFloat(cantidad)-1;
            }else{
                q += this.checked ? cadena2 : cadena2+",";
                cantidad = parseFloat(cantidad)+1;
            }
            $cadena.val(q);
            $cantidad.val(cantidad);
        });
    });

    function Permitir_Hora(){
        const hourInput = document.getElementById("hora_in");

        hourInput.addEventListener("input", function() {
            const inputValue = parseInt(hourInput.value);
            
            if (isNaN(inputValue) || inputValue < 0 || inputValue > 23) {
                hourInput.value = ''; // Limpia el valor si no es válido
            }
        });
    }

    function Permitir_Minuto(){
        const minuteInput = document.getElementById("minuto_in");

        minuteInput.addEventListener("input", function() {
            const inputValue = parseInt(minuteInput.value);
            
            if (isNaN(inputValue) || inputValue < 0 || inputValue > 59) {
                minuteInput.value = ''; // Limpia el valor si no es válido
            }
        });
    }

    function Validar_Extension_Ie(){
        var archivoInput = document.getElementById('documento_in');
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

    function Insert_Induccion_Efsrt(){
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
        
        var cantidad = $('#cantidad_in').val();
        var dataString = new FormData(document.getElementById('formulario_induccion')); 
        var url="<?php echo site_url(); ?>AppIFV/Insert_Induccion_Efsrt"; 

        var grupo = $('#grupo').val();
        var id_especialidad = $('#id_especialidad').val();
        var id_modulo = $('#id_modulo').val();
        var id_turno = $('#id_turno').val();
        
        dataString.append('grupo', grupo);
        dataString.append('id_especialidad', id_especialidad); 
        dataString.append('id_modulo', id_modulo);
        dataString.append('id_turno', id_turno);

        if (Valida_Insert_Induccion_Efsrt()) {
            Swal({
                title: '¿Está seguro que desea registrar '+cantidad+' alumno(s) como asistiendo a la charla?',
                text: "Por favor confirma en tu hoja de asistencia se coinciden.",
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
                        success: function(data) {
                            swal.fire(
                                'Registro grabado con la referencia '+data,
                                'Por favor apunta en la hoja original y archiva correctamente.',
                                'success'
                            ).then(function() {
                                Lista_Induccion();
                                $("#acceso_modal .close").click()
                            });
                        }
                    });
                }
            })    
        }  
    }

    function Valida_Insert_Induccion_Efsrt() {
        if($('#cantidad_in').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar al menos un Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#hora_in').val().length<2) {
            Swal(
                'Ups!',
                'Debe ingresar Hora.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#minuto_in').val().length<2) {
            Swal(
                'Ups!',
                'Debe ingresar Minuto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#documento_in').val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Documento.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_ponente_in').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Ponente.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>