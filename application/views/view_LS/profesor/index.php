<?php 
$sesion =  $_SESSION['usuario'][0];
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view('view_LS/header'); ?>
<?php $this->load->view('view_LS/nav'); ?>

<div class="panel panel-flat">
    <div class="panel-heading">
        <div class="row">
            <div class="x_panel">
                <div class="page-title" style="background-color: #C1C1C1;">
                    <h4 style="font-size:40px; color:white; position: absolute;top: 40%;left: 5%;margin: -25px 0 0 -25px;"><span class="text-semibold"><b>Profesor (Lista)</b></span></h4>
                </div>

                <div class="heading-elements">
                    <div class="heading-btn-group">
                        <a href="<?= site_url('LeadershipSchool/Excel_Profesor') ?>">
                            <img src="<?= base_url() ?>template/img/excel.png" alt="Exportar Excel" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="lista_profesor" class="col-lg-12">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#profesor").addClass('active');
        $("#hprofesor").attr('aria-expanded','true');
        $("#listas_profesor").addClass('active');
		document.getElementById("rprofesor").style.display = "block";

        Lista_Profesor();
    });

    function Lista_Profesor(){
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

        var url="<?php echo site_url(); ?>LeadershipSchool/Lista_Profesor";

        $.ajax({
            type:"POST",
            url:url,
            success:function (resp) {
                $('#lista_profesor').html(resp);
            }
        });
    }
</script>

<?php $this->load->view('view_LS/footer'); ?>