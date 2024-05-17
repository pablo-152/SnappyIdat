<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_BL/header'); ?>
<?php $this->load->view('view_BL/nav'); ?>

<style>
    #example tbody tr td:nth-child(1),#example tbody tr td:nth-child(5){
        text-align: center;
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Asignar Sección</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a style="margin-right:5px;" type="button" href="<?= site_url('BabyLeaders/Detalle_Curso') ?>/<?php echo $get_id[0]['id_curso']; ?>">
                            <img class="top" src="<?= base_url() ?>template/img/icono-regresar.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form id="formulario_insert" method="POST" enctype="multipart/form-data" class="formulario">
            <div class="col-md-12 row" style="margin-bottom:15px;">
                <div class="form-group col-md-2">
                    <label class=" control-label text-bold margintop">Sección: </label>
                    <select class="form-control" id="id_seccion" name="id_seccion">
                        <option  value="0">Seleccione</option>
                        <?php foreach($list_seccion as $list){ ?>
                            <option value="<?php echo $list['id_seccion']; ?>"><?php echo $list['nom_seccion']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" id="cadena" name="cadena" value="">
                <input type="hidden" id="cantidad" name="cantidad" value="0">
                <input type="hidden" id="prueba" name="prueba">

                <table id="example" class="table table-hover table-bordered">
                    <thead>
                        <tr style="background-color: #E5E5E5;">
                            <th class="text-center" width="3%"><input type="checkbox" id="total" name="total" value="1"></th>
                            <th>Id</th>
                            <th class="text-center" width="29%">Apellido Paterno</th>
                            <th class="text-center" width="29%">Apellido Materno</th>
                            <th class="text-center" width="29%">Nombre</th>
                            <th class="text-center" width="10%">Código</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($list_alumno as $list){ ?>
                            <tr class="even pointer">
                                <td><input type="checkbox" id="array_matricula[]" name="array_matricula[]" value="<?php echo $list['id_matricula']; ?>"></td>
                                <td><?php echo $list['id_matricula']; ?></td>
                                <td><?php echo $list['alum_apater']; ?></td>  
                                <td><?php echo $list['alum_amater']; ?></td> 
                                <td><?php echo $list['alum_nom']; ?></td> 
                                <td><?php echo $list['cod_alum']; ?></td> 
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <input type="hidden" id="id_curso" name="id_curso" value="<?php echo $get_id[0]['id_curso']; ?>">
            <button type="button" class="btn btn-primary" onclick="Asignar_Seccion();">
                <i class="glyphicon glyphicon-ok-sign"></i>Guardar
            </button>
            <a type="button" class="btn btn-default" href="<?= site_url('BabyLeaders/Detalle_Curso') ?>/<?php echo $get_id[0]['id_curso']; ?>">
                <i class="glyphicon glyphicon-remove-sign"></i>Cancelar
            </a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#academicos").addClass('active');
        $("#hacademicos").attr('aria-expanded', 'true');
        $("#cursos").addClass('active');
        document.getElementById("racademicos").style.display = "block";

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
                        if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='array_matricula')
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

    function Asignar_Seccion(){ 
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

        var url="<?php echo site_url(); ?>BabyLeaders/Asignar_Seccion";
        var cadena = $("#cadena").val();
        var cantidad = $("#cantidad").val();
        var id_seccion = $("#id_seccion").val();
        var id_curso = $("#id_curso").val();

        if (Valida_Asignar_Seccion()) {
            $.ajax({
                type:"POST",
                url:url,
                data:{'cadena':cadena,'cantidad':cantidad,'id_seccion':id_seccion,'id_curso':id_curso},
                success:function (data) {
                    window.location = "<?php echo site_url(); ?>BabyLeaders/Detalle_Curso/"+id_curso;
                }
            });
        }
    }

    function Valida_Asignar_Seccion() {
        if($('#cantidad').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar como mínimo un Alumno.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#id_seccion').val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Sección.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>

<?php $this->load->view('view_BL/footer'); ?>