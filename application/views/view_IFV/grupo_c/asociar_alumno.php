<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(5),
    #example tbody tr td:nth-child(6),#example tbody tr td:nth-child(7){
        text-align: center;
    }

    .btn-flotante_1 {
        position: fixed;
        bottom: 40px;
        right: 150px;
        z-index: 99;
    }

    .btn-flotante_2 {
        position: fixed;
        bottom: 40px;
        right: 40px;
        z-index: 99;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Asociar Alumno</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a style="margin-right:5px;" type="button" href="<?= site_url('AppIFV/Detalle_Grupo_C') ?>/<?php echo $get_id[0]['id_grupo']; ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div>
                <div class="col-md-2">
                    <label for="">Inicio Clases</label>
                </div>
                <div class="col-md-4">
                    <input type="date" name="inicio_marcaciones" id="inicio_marcaciones" value="<?php echo $get_id[0]['inicio_clase']; ?>" min="<?php echo $get_id[0]['inicio_clase']; ?>" class="form-control">
                </div>
            </div>
            
            <div class="col-lg-12" id="busqueda" style="margin-top: 25px !important;">
                <input type="hidden" id="cadena" name="cadena" value="">
                <input type="hidden" id="cantidad" name="cantidad" value="0">
                <input type="hidden" id="prueba" name="prueba">
                    
                <table id="example" class="table table-hover table-bordered">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th class="text-center" width="3%"><input type="checkbox" id="total" name="total" value="1"></th>
                            <th>Id</th>
                            <th class="text-center" width="21%">Apellido Paterno</th>
                            <th class="text-center" width="21%">Apellido Materno</th>
                            <th class="text-center" width="29%">Nombre</th>
                            <th class="text-center" width="10%">Código</th>
                            <th class="text-center" width="8%">Matricula</th>
                            <th class="text-center" width="8%">Alumno</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($list_alumno as $list){ ?>
                            <tr class="even pointer">
                                <td><input type="checkbox" id="array_alumno[]" name="array_alumno[]"></td>
                                <td><?php echo $list['Id']; ?></td> 
                                <td><?php echo $list['Apellido_Paterno']; ?></td>  
                                <td><?php echo $list['Apellido_Materno']; ?></td> 
                                <td><?php echo $list['Nombre']; ?></td> 
                                <td><?php echo $list['Codigo']; ?></td> 
                                <td><?php echo $list['Matricula']; ?></td> 
                                <td><span class="badge" <?php if($list['Alumno']=="Retirado"){ echo "style='background-color:#C00000;'"; }else{ echo "style='background-color:#9cd5d1;'"; } ?>><?php echo $list['Alumno']; ?></span></td>                        
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <input type="hidden" id="id_grupo" name="id_grupo" value="<?php echo $get_id[0]['id_grupo']; ?>">
            <input type="hidden" id="cod_grupo" name="cod_grupo" value="<?php echo $get_id[0]['grupo']; ?>">
            <input type="hidden" id="cod_modulo" name="cod_modulo" value="<?php echo $get_id[0]['modulo']; ?>">
            <input type="hidden" id="cod_seccion" name="cod_seccion" value="<?php echo $get_id[0]['id_seccion']; ?>">
            <input type="hidden" id="inicio_clase" name="inicio_clase" value="<?php echo $get_id[0]['inicio_clase']; ?>">
            <input type="hidden" id="fin_clase" name="fin_clase" value="<?php echo $get_id[0]['fin_clase']; ?>">
            <input type="hidden" id="desde" name="desde" value="<?php echo $get_horario[0]['desde_horario']; ?>">
            <input type="hidden" id="hasta" name="hasta" value="<?php echo $get_horario[0]['hasta_horario']; ?>">
            <input type="hidden" id="tolerancia" name="tolerancia" value="<?php echo $get_horario[0]['tolerancia']; ?>">
            <input type="hidden" id="id_turno" name="id_turno" value="<?php echo $get_horario[0]['id_turno']; ?>">
            <input type="hidden" id="especialidad" name="especialidad" value="<?php echo $get_id[0]['nom_especialidad']; ?>">
            <button type="button" class="btn btn-primary btn-flotante_1" onclick="Asociar_Alumno();">
                <i class="glyphicon glyphicon-ok-sign"></i>Guardar
            </button>
            <a type="button" class="btn btn-default btn-flotante_2" href="<?= site_url('AppIFV/Detalle_Grupo_C') ?>/<?php echo $get_id[0]['id_grupo']; ?>">
                <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
            </a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#grupos").addClass('active');
        $("#hgrupos").attr('aria-expanded', 'true'); 
        $("#grupos_c").addClass('active');
		document.getElementById("rgrupos").style.display = "block";

        $('#example thead tr').clone(true).appendTo('#example thead');
        $('#example thead tr:eq(1) th').each(function(i) {
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

        var table = $('#example').DataTable({
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
        let $dt = $('#example');
        let $total = $('#total');
        let $cadena = $('#cadena');
        let $cantidad = $('#cantidad');
        let $span_cantidad = $('#span_cantidad');

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
                $span_cantidad.html(total);
            }else{
                if (document.getElementById('total').checked){
                    var inp=document.getElementsByTagName('input');
                    for(var i=0, l=inp.length;i<l;i++){
                        if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='array_alumno')
                            inp[i].checked=1;
                    }
                }else{
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
                    $span_cantidad.html(total);
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
            $span_cantidad.html(cantidad);
            //cadena += this.checked ? cadena2 : info[1]+", ";
        });
    });

    function Asociar_Alumno(){ 
        Cargando(); 

        var url="<?php echo site_url(); ?>AppIFV/Asociar_Alumno";
        var cadena = $("#cadena").val();
        var cantidad = $("#cantidad").val();
        var id_grupo = $("#id_grupo").val();
        var grupo = $("#cod_grupo").val();
        var modulo = $("#cod_modulo").val();
        var seccion = $("#cod_seccion").val();
        var inicio_clase = $("#inicio_clase").val();
        var fin_clase = $("#fin_clase").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        var tolerancia = $("#tolerancia").val();
        var id_turno = $("#id_turno").val();
        var especialidad = $("#especialidad").val();
        var inicio_marcaciones = $("#inicio_marcaciones").val();
        
        if (Valida_Asociar_Alumno()) {
            Swal({
                title: '¿Realmente desea asociar alumnos?',
                text: "",
                type: 'question',
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
                        data:{'cadena':cadena,'cantidad':cantidad,'id_grupo':id_grupo,'grupo':grupo,
                            'modulo':modulo,'seccion':seccion,'inicio_clase':inicio_clase,'fin_clase':fin_clase,
                            'desde':desde,'hasta':hasta,'tolerancia':tolerancia,'id_turno':id_turno,'especialidad':especialidad,
                            'inicio_marcaciones':inicio_marcaciones},
                        success:function (data) {
                            //window.location.reload();
                            List_Vista_Asociar_Alumno();
                        }
                    });
                }
            })
            
        }
    }

    function Valida_Asociar_Alumno() {
        if($('#inicio_marcaciones').val()<$('#inicio_clase').val()) {
            Swal(
                'Ups!',
                'Inicio de marcaciones no puede ser antes de '+$('#inicio_clase').val(),
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#inicio_marcaciones').val()>$('#fin_clase').val()) {
            Swal(
                'Ups!',
                'Inicio de marcaciones no puede ser después de '+$('#fin_clase').val(),
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cantidad').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar como mínimo un Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#cantidad').val().trim() >4) {
            Swal(
                'Ups!',
                'Debe seleccionar hasta 4 alumnos para continuar.',
                'warning'
            ).then(function() { });
            return false;
        }
        
        return true;
    }

    function List_Vista_Asociar_Alumno(){
        Cargando();
        var url="<?php echo site_url(); ?>AppIFV/List_Vista_Asociar_Alumno";
        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                $('#busqueda').html(data);
            }
        });
    }
</script>

<?php $this->load->view('view_IFV/footer'); ?>