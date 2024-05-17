<?php
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php $this->load->view('view_IFV/header'); ?>
<?php $this->load->view('view_IFV/nav'); ?>

<style>
    #container {
        max-width: 1200px;
        min-width: 800px;
        height: 400px;
        margin: 1em auto;
    }

    .scrolling-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .scroll{
        overflow-x: scroll; 
    }
</style>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Informe (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="#">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="col-md-12 row">
                    <div class="form-group col-md-2">
                        <label class="text-bold">Año:</label>
                        <div class="col">
                            <select name="anio" id="anio" class="form-control" onchange="Cambiar_Anio()">
                                <?php foreach($list_anio as $list){ ?>
                                    <option value="<?php echo $list['nom_anio']; ?>" <?php if($list['nom_anio']==date('Y')){ echo "selected"; } ?>>
                                        <?php echo $list['nom_anio']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row" style="margin-bottom:50px;">
            <div id="lista" class="col-lg-9 scroll">
                <!--<div class="scrolling-container">
                    <div id="container"></div>
                </div>-->
            </div>

            <div id="cuadro" class="col-lg-3">
            </div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/gantt/highcharts-gantt.js"></script>
<script src="https://code.highcharts.com/gantt/modules/exporting.js"></script>
<script src="https://code.highcharts.com/gantt/modules/accessibility.js"></script>

<script>
    $(document).ready(function() {
        $("#grupos").addClass('active');
        $("#hgrupos").attr('aria-expanded', 'true');
        $("#informes_c").addClass('active');
		document.getElementById("rgrupos").style.display = "block";

        Cambiar_Anio();

        /*var today = new Date(),
        day = 1000 * 60 * 60 * 24,
        dateFormat = Highcharts.dateFormat,
        series,
        cars;

        today.setUTCHours(0);
        today.setUTCMinutes(0);
        today.setUTCSeconds(0);
        today.setUTCMilliseconds(0);
        today = today.getTime();

        cars = [
        <?php foreach($list_informe as $list){ ?>
            {
                model: '<?php echo $list['abreviatura']; ?>',
                current: 0,
                deals: [{
                    inicio_clase: '<?php echo $list['inicio_clase']; ?>',
                    fin_clase: '<?php echo $list['fin_clase']; ?>',
                    matriculados: '<?php echo $list['matriculados']; ?>',
                    sin_matricular: '<?php echo $list['sin_matricular']; ?>',
                    retirados: '<?php echo $list['retirados']; ?>',
                    from: today - 1 * day,
                    to: today + 2 * day
                }, {
                    inicio_clase: '<?php echo $list['inicio_clase']; ?>',
                    fin_clase: '<?php echo $list['fin_clase']; ?>',
                    matriculados: '<?php echo $list['matriculados']; ?>',
                    sin_matricular: '<?php echo $list['sin_matricular']; ?>',
                    retirados: '<?php echo $list['retirados']; ?>',
                    from: today - 3 * day,
                    to: today - 2 * day
                }, {
                    inicio_clase: '<?php echo $list['inicio_clase']; ?>',
                    fin_clase: '<?php echo $list['fin_clase']; ?>',
                    matriculados: '<?php echo $list['matriculados']; ?>',
                    sin_matricular: '<?php echo $list['sin_matricular']; ?>',
                    retirados: '<?php echo $list['retirados']; ?>',
                    from: today + 5 * day,
                    to: today + 6 * day
                }]
            },
        <?php } ?>
        ];

        series = cars.map(function (car, i) {
            var data = car.deals.map(function (deal) {
                return {
                    id: 'deal-' + i,
                    inicio_clase: deal.inicio_clase,
                    fin_clase: deal.fin_clase,
                    matriculados: deal.matriculados,
                    sin_matricular: deal.sin_matricular,
                    retirados: deal.retirados,
                    start: deal.from,
                    end: deal.to,
                    y: i
                };
            });
            return {
                name: car.model,
                data: data,
                current: car.deals[car.current]
            };
        });

        Highcharts.ganttChart('container', {
            series: series,
            title: {
                text: 'Informe'
            },
            tooltip: {
                pointFormat: '<span>Inicio Clases: {point.inicio_clase}</span><br/><span>Fin Clases: {point.fin_clase}</span><br/><span>Matriculados: {point.matriculados}</span><br/><span>Sin Matricular: {point.sin_matricular}</span><br/><span>Retirados: {point.retirados}</span>'
            },
            lang: {
                accessibility: {
                    axis: {
                        xAxisDescriptionPlural: 'The chart has a two-part X axis showing time in both week numbers and days.',
                        yAxisDescriptionSingular: 'The chart has a tabular Y axis showing a data table row for each point.'
                    }
                }
            },
            accessibility: {
                keyboardNavigation: {
                    seriesNavigation: {
                        mode: 'serialize'
                    }
                },
                point: {
                    valueDescriptionFormat: 'Rented to {point.rentedTo} from {point.x:%A, %B %e} to {point.x2:%A, %B %e}.'
                },
                series: {
                    descriptionFormatter: function (series) {
                        return series.name + ', car ' + (series.index + 1) + ' of ' + series.chart.series.length + '.';
                    }
                }
            },
            xAxis: {
                currentDateIndicator: true
            },
            yAxis: {
                type: 'category',
                grid: {
                    columns: [{
                        title: {
                            text: 'Espec.'
                        },
                        categories: series.map(function (s) {
                            return s.name;
                        }),
                    }]
                }
            }
        });*/
    });

    function Cambiar_Anio(){
        Lista_Informe_C();
        Cuadro_Informe_C();
    }

    function Lista_Informe_C(){
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

        var anio=$('#anio').val();
        var url="<?php echo site_url(); ?>AppIFV/Lista_Informe_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'anio':anio},
            success:function (data) {
                $('#lista').html(data);
            }
        });
    }

    function Cuadro_Informe_C(){
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

        var anio=$('#anio').val();
        var url="<?php echo site_url(); ?>AppIFV/Cuadro_Informe_C";

        $.ajax({
            type:"POST",
            url:url,
            data: {'anio':anio},
            success:function (data) {
                $('#cuadro').html(data);
            }
        });
    }

    function Exportar_Proyectos(){
        var anio=$('#anio').val();
        window.location ="<?php echo site_url(); ?>Snappy/Excel_Lista_Proyecto/"+anio;
    }
</script>

<?php $this->load->view('ceba/validaciones'); ?>
<?php $this->load->view('view_IFV/footer'); ?>