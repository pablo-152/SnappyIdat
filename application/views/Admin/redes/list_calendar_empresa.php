<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
?>

<div id="div_calendar" class="col-centered">
</div>

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
                        $('#ModalEdit #cod_proyecto').val(event.codproyecto);  
                        $('#ModalEdit #imagen').html(event.imagen);
                        $('#ModalEdit #inicio').val(event.inicio);
                        $('#ModalEdit #snappy_redes').val(event.snappy_redes);
                        $('#ModalEdit #id_proyecto').val(event.id_proyecto);
                        $('#ModalEdit #copy').html(event.copy);
                        //$('#ModalEdit #subido1').val(event.subido);
                        
                        if (id_nivel==1)
                        {
                            if (event.subido=="1")
                            {
                                //$('#ModalEdit #subido').attr("checked", true);
                                $("#subido").prop("checked", true);
                            }
                            else
                            {
                                //$('#ModalEdit #subido').attr("checked", false);
                                $("#subido").prop("checked", false);
                            }
                        }
                        else{
                            if (event.subido=="1")
                            {
                                //$('#ModalEdit #subido').attr("checked", true);
                                $("#subido").prop("checked", true);
                                //$('#ModalEdit #subido').attr("disabled", true);
                                $("#subido").prop("disabled", false);
                                $('#ModalEdit #btn_redes').attr("disabled", true);
                            }
                            else
                            {
                                //$('#ModalEdit #subido').attr("checked", false);
                                //$('#ModalEdit #subido').attr("disabled", false);
                                $("#subido").prop("checked", false);
                                $("#subido").prop("disabled", false);
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
                <?php foreach($list_redes as $list) {

                    $base_url=base_url();

                    $empresas="";
                    $cont="";
                    /*foreach($list_empresa as $empresa){
                        if($empresa['id_proyecto']==$list['id_proyecto']){
                            $empresas=$empresas.$empresa['cod_empresa'].",";

                            foreach($list_duplicado as $dup){
                                if($dup['cod_proyecto']==$list['cod_proyecto']){
                                    $cont=$cont."*";
                                }
                            }
                        }
                    }*/
                    if($list['duplicado']=="1"){
                        $cont=$cont."*";
                    }

                    if($list['cod_empresa']==""){
                        $empresa_codigos="";
                    }else{
                        $empresa_codigos=" ".$list['cod_empresa']." ";
                    }
                    
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

                    
                    $descargar=site_url('Snappy/Descargar_Imagen');

                ?>
                    {
                        id: '<?php echo $list['id_calendar_redes']; ?>',
                        title: '<?php if ($list['cod_proyecto']!=""){ echo $empresa_codigos.$list['cod_proyecto'].$cont.' - '.$list['descripcion']; }else{ echo $empresa_codigos.$list['descripcion']; } ?>',
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        descripcion: '<?php echo $list['descripcion']; ?>',
                        codproyecto: '<?php echo $list['cod_proyecto']; ?>',
                        usuario_codigo: '<?php echo $list['usuario_codigo']; ?>',
                        subido: '<?php echo $list['subido']; ?>',
                        nom_statusp: '<?php echo $list['nom_statusp']; ?>',
                        tipo: '<?php echo $list['nom_tipo']; ?>',
                        subtipo: '<?php echo $list['nom_subtipo']; ?>',
                        //color: '<?php if ($list['cod_proyecto']!=""){ if($list['subido']==1){echo "#9ddafa";} elseif ($list['status']==5 || $list['status']==6 || $list['status']==7) { echo "#BDE5E7"; } else { echo "#FCE9DA";} } else{ echo $list['color']; } ?>',
                        
                        color: '<?php 
                        if ($list['cod_proyecto']!="" || ($list['id_secundario']!=0 && $list['tipo_calendar']=="Proyecto")){ 
                            if($list['subido']==1 ){ 
                                echo "#b7afb8"; 
                            }
                            elseif($list['status']==6 || $list['status']==7 || $list['status']==5) { 
                                echo "#BDE5E7"; 
                            }
                                else{ 
                                    echo "#FCE9DA";
                                } 
                        } else{
                             echo $list['color']; 
                        } 
                        ?>',
                        
                        
                        imagen: '<?php if($list['imagen']!=""){ echo '<a title="Descargar Imagen" href="'.$descargar.'/'.$list['id_proyecto'].'"><img src="'.$base_url.''.$list['imagen'].'" height=380px width=450px></a>'; }else{ echo ''; } ?>',
                        inicio: '<?php echo $list['inicio']; ?>',
                        snappy_redes: '<?php echo $list['snappy_redes']; ?>',
                        id_proyecto: '<?php echo $list['id_proyecto']; ?>',
                        copy: '<?php echo $list['copy']; ?>',
                    },
                <?php } ?>
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