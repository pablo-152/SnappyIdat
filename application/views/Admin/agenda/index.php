<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
//$rol = $_SESSION['usuario'][0]['ROLASISTENCIA'];
?>
<?php $this->load->view('Admin/header'); ?>
<link href="<?= base_url() ?>template/docs/css/fullcalendar.css" rel="stylesheet" />
<?php $this->load->view('Admin/nav'); ?>
<style>
    h2 p {
    text-transform: lowercase;
    }

    h2 p:first-letter {
        text-transform: uppercase;
    }
</style>
<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Agenda</b></span></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="calendar" class="col-centered">
                </div>
            </div>

            <!-- Modal Nuevo-->
            <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-horizontal" method="POST" action="addEvent.php">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Agregar Evento</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Titulo</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="color" class="col-sm-2 control-label">Color</label>
                                    <div class="col-sm-10">
                                        <select name="color" class="form-control" id="color">
                                            <option value="">Seleccionar</option>
                                            <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
                                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                            <option style="color:#008000;" value="#008000">&#9724; Verde</option>
                                            <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
                                            <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
                                            <option style="color:#000;" value="#000">&#9724; Negro</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="start" class="col-sm-2 control-label">Fecha Inicial</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="start" class="form-control" id="start" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="end" class="col-sm-2 control-label">Fecha Final</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="end" class="form-control" id="end" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edición-->
            <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-horizontal" method="POST" action="editEventTitle.php">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Modificar Evento</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Titulo</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title" placeholder="Titulo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="color" class="col-sm-2 control-label">Color</label>
                                    <div class="col-sm-10">
                                        <select name="color" class="form-control" id="color">
                                            <option value="">Seleccionar</option>
                                            <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro</option>
                                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                            <option style="color:#008000;" value="#008000">&#9724; Verde</option>
                                            <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
                                            <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
                                            <option style="color:#000;" value="#000">&#9724; Negro</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label class="text-danger"><input type="checkbox" name="delete"> Eliminar Evento</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" class="form-control" id="id">


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comunicacion").addClass('active');
        $("#hcomunicacion").attr('aria-expanded', 'true');
        $("#agenda_a").addClass('active');
        document.getElementById("rcomunicacion").style.display = "block";
    });
</script>

<?php $this->load->view('Admin/footer'); ?>

<script src="<?= base_url() ?>template/docs/js/moment.min.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/fullcalendar.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/locale/es.js"></script>

<script>
    $(document).ready(function() {
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
        var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

        $('#calendar').fullCalendar({
            header: {
                language: 'es',
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay',

            },
            defaultDate: yyyy + "-" + mm + "-" + dd,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: false,
            selectHelper: true,
            select: function(start, end) {

                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                $('#ModalAdd').modal('show');
            },
            eventRender: function(event, element) {
                element.bind('dblclick', function() {
                    $('#ModalEdit #id').val(event.id);
                    $('#ModalEdit #title').val(event.title);
                    $('#ModalEdit #color').val(event.color);
                    $('#ModalEdit').modal('show');
                });
            },
            eventDrop: function(event, delta, revertFunc) { // si changement de position

                edit(event);

            },
            eventResize: function(event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                edit(event);

            },
            events: [
                <?php foreach ($list_agenda as $list) {

                    $empresas = "";
                    foreach ($list_empresa_proyecto as $empresa) {
                        if ($empresa['id_proyecto'] == $list['id_proyecto']) {
                            $empresas = $empresas . $empresa['cod_empresa'] . ",";
                        }
                    }

                    if ($empresas == "") {
                        $empresa_codigos = "";
                    } else {
                        $empresa_codigos = substr($empresas, 0, -1);
                    }

                    $start = explode(" ", $list['inicio']);
                    $end = explode(" ", $list['fin']);
                    if ($start[1] == '00:00:00') {
                        $start = $start[0];
                    } else {
                        $start = $list['inicio'];
                    }

                    if ($end[1] == '00:00:00') {
                        $end = $end[0];
                    } else {
                        $end = $list['fin'];
                    }
                ?> {
                        id: '<?php echo $list['id_calendar_agenda']; ?>',
                        title: '<?php if ($list['cod_proyecto'] != "") {
                                    echo $empresa_codigos . $list['cod_proyecto'] . ' - ' . $list['descripcion'];
                                } else {
                                    echo $empresa_codigos . $list['descripcion'];
                                } ?>',
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        color: '<?php echo $list['color']; ?>',
                    },
                <?php } ?>
            ]
        });

        function edit(event) {
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if (event.end) {
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            } else {
                end = start;
            }

            id = event.id;

            Event = [];
            Event[0] = id;
            Event[1] = start;
            Event[2] = end;

            $.ajax({
                url: 'editEventDate.php',
                type: "POST",
                data: {
                    Event: Event
                },
                success: function(rep) {
                    /*if(rep == 'OK'){*/
                    alert('Evento se ha guardado correctamente');
                    /*}else{
                        alert('No se pudo guardar. Inténtalo de nuevo.'); 
                    }*/
                }
            });
        }

    });
</script>