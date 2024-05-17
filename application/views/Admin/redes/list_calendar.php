<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<div class="app-sidebar__overlay" data-toggle="sidebar">
</div>
<link href="<?=base_url() ?>template/docs/css/fullcalendar.css" rel="stylesheet" />

<meta charset="UTF-8">

<title><?php echo $title;?></title>

<div id="div_calendar" class="col-centered">

</div>


<?php $this->load->view('Admin/footer'); ?>
<script src="<?= base_url() ?>template/docs/js/moment.min.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/fullcalendar.js"></script>
<script src="<?= base_url() ?>template/docs/js/fullcalendar/locale/es.js"></script>

<script>
    $(document).ready(function() {
        var id_nivel = <?php echo $id_nivel; ?>;
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
        var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
        
        
        $('#div_calendar').fullCalendar({
            header: {
                language: 'es',
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay',

            },
            defaultDate: yyyy+"-"+mm+"-"+dd,
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
                    if(event.codproyecto!="0")
                    {
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #tipo').html(event.tipo);
                        $('#ModalEdit #subtipo').html(event.subtipo);
                        $('#ModalEdit #descripcion').html(event.descripcion);
                        $('#ModalEdit #usuario_codigo').html(event.usuario_codigo);
                        $('#ModalEdit #nom_statusp').html(event.nom_statusp);
                        $('#ModalEdit #codproyecto').html(event.codproyecto);  
                        $('#ModalEdit #codproyecto1').val(event.codproyecto);
                        
                        if (id_nivel==1)
                        {
                            if (event.subido=="1")
                            {
                                $('#ModalEdit #subido').attr("checked", true);
                            }
                            else
                            {
                                $('#ModalEdit #subido').attr("checked", false);
                            }
                        }
                        else{
                            if (event.subido=="1")
                            {
                                $('#ModalEdit #subido').attr("checked", true);
                                $('#ModalEdit #subido').attr("disabled", true);
                                $('#ModalEdit #btn_redes').attr("disabled", true);
                            }
                            else
                            {
                                $('#ModalEdit #subido').attr("checked", false);
                                $('#ModalEdit #subido').attr("disabled", false);
                                $('#ModalEdit #btn_redes').attr("disabled", false);
                            }
                        }
                        //$('#ModalEdit #subido').val(event.subido); 
                        $('#ModalEdit').modal('show');
                    }
                    else{}
                });
            },
            eventDrop: function(event, delta, revertFunc) { // si changement de position

                edit(event);

            },
            eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

                edit(event);

            },
            events: [
                <?php
                if($val_empresa!=""){
                    foreach($list_redes as $list) {
                        if($list['empresa']==$val_empresa){

                            $start = explode(" ", $list['inicio']);
                            $end = explode(" ", $list['fin']);
                            if($start[1] == '00:00:00'){
                                $start = $start[0];
                            }else{
                                $start = $list['inicio'];
                            }
                            if($end[1] == '00:00:00'){
                                $end = $end[0];
                            }else{
                                $end = $list['fin'];
                            }
                            ?>
                            {
                                id: '<?php echo $list['id_calendar_redes']; ?>',
                                title: '<?php if ($list['cod_proyecto']!="0" && $list['cod_proyecto']!=""){ echo $list['empresa'].' ('.$list['cod_proyecto'].'/'.$list['subtipo'].') '.$list['descripcion'];} else {echo '- '.$list['descripcion'];} ?>',
                                start: '<?php echo $start; ?>',
                                end: '<?php echo $end; ?>',
                                descripcion: '<?php echo $list['descripcion']; ?>',
                                codproyecto: '<?php echo $list['cod_proyecto']; ?>',
                                usuario_codigo: '<?php echo $list['usuario_codigo']; ?>',
                                subido: '<?php echo $list['subido']; ?>',
                                nom_statusp: '<?php echo $list['nom_statusp']; ?>',
                                tipo: '<?php echo $list['nom_tipo']; ?>',
                                subtipo: '<?php echo $list['nom_subtipo']; ?>',
                                color: '<?php if ($list['cod_proyecto']!="0" && $list['cod_proyecto']!=""){ if($list['subido']==1){echo "#9ddafa";} elseif ($list['status']==5 || $list['status']==6 || $list['status']==7) { echo "#BDE5E7"; } else { echo "#FCE9DA";} } else{ echo $list['color']; } ?>',
                            },
                        <?php }
                    }
                }else{
                    foreach($list_redes as $list) {

                            $start = explode(" ", $list['inicio']);
                            $end = explode(" ", $list['fin']);
                            if($start[1] == '00:00:00'){
                                $start = $start[0];
                            }else{
                                $start = $list['inicio'];
                            }
                            if($end[1] == '00:00:00'){
                                $end = $end[0];
                            }else{
                                $end = $list['fin'];
                            }
                            ?>
                            {
                                id: '<?php echo $list['id_calendar_redes']; ?>',
                                title: '<?php if ($list['cod_proyecto']!="0" && $list['cod_proyecto']!=""){ echo $list['empresa'].' ('.$list['cod_proyecto'].'/'.$list['subtipo'].') '.$list['descripcion'];} else {echo '- '.$list['descripcion'];} ?>',
                                start: '<?php echo $start; ?>',
                                end: '<?php echo $end; ?>',
                                descripcion: '<?php echo $list['descripcion']; ?>',
                                codproyecto: '<?php echo $list['cod_proyecto']; ?>',
                                usuario_codigo: '<?php echo $list['usuario_codigo']; ?>',
                                subido: '<?php echo $list['subido']; ?>',
                                nom_statusp: '<?php echo $list['nom_statusp']; ?>',
                                tipo: '<?php echo $list['nom_tipo']; ?>',
                                subtipo: '<?php echo $list['nom_subtipo']; ?>',
                                color: '<?php if ($list['cod_proyecto']!="0" && $list['cod_proyecto']!=""){ if($list['subido']==1){echo "#ECF0DF";} elseif ($list['status']==5 || $list['status']==6 || $list['status']==7) { echo "#BDE5E7"; } else { echo "#FCE9DA";} } else{ echo $list['color']; } ?>',
                            },
                        <?php 
                    }
                }
                     ?>
            ]
        });
        
        function edit(event){
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if(event.end){
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            }else{
                end = start;
            }
            
            id =  event.id;
            codproyecto =  event.codproyecto;
            
            Event = [];
            Event[0] = id;
            Event[1] = start;
            Event[2] = end;
            Event[3] = codproyecto;
            var url = "<?php echo site_url(); ?>" + "/Snappy/Edit_Calendar_Redes";
            //frm = {sistema: sistema, depen:depen };
            
            $.ajax({
                url: url,
                type: "POST",
                data: {Event:Event},
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
