<!DOCTYPE html>
<html>
    <?php 
        $var_esapacio='espacio_colaborador';
        $var_esapacio2='espacio2_colaborador';
        $var_color_letras_nombre_cargo='color_colaborador';
        $var_top_apellido='top_apellido';
        $var_apellido='apellido_colaborador';
        $var_nombre='nombre_colaborador';
        $var_cargo='cargo_colaborador';
        $var_margin_apellido_nombre='margin_apellido_nombre';
        $var_foto='contenedor';
        if($get_id[0]['id_empresa']=='3'){//3
            $imagen='template/img/fotocheck_colaborador/LL_FOTOCHECKS_cara-01.jpg';
            $imagen2='template/img/fotocheck_colaborador/LL_FOTOCHECKS_contracara-02.jpg';
        }else if($get_id[0]['id_empresa']=='4'){ //4
            $imagen='template/img/fotocheck_colaborador/LS_FOTOCHECKS_cara-01.jpg';
            $imagen2='template/img/fotocheck_colaborador/LS_FOTOCHECKS_contracara-02.jpg';
        }else if($get_id[0]['id_empresa']=='2'){ //2
            $imagen='template/img/fotocheck_colaborador/BL_FOTOCHECKS_cara-01.jpg';
            $imagen2='template/img/fotocheck_colaborador/BL_FOTOCHECKS_contracara-02.jpg';
        }else if($get_id[0]['id_empresa']=='6'){ //6
            $imagen='template/img/fotocheck_colaborador/FV_FOTOCHECKS_cara-01.jpg';
            $imagen2='template/img/fotocheck_colaborador/FV_FOTOCHECKS_contracara-02.jpg';
            $var_cargo='cargo_ifv';
            $var_foto='contenedor_ifv';
        }else if($get_id[0]['id_empresa']=='1'){ //1
            $imagen='template/img/fotocheck_colaborador/GL_FOTOCHECKS_cara-01.jpg';
            $imagen2='template/img/fotocheck_colaborador/GL_FOTOCHECKS_contracara-02.jpg';
            $var_esapacio='espacio_gl';
            $var_esapacio2='espacio2_gl';
            $var_color_letras_nombre_cargo='color_gl';
            $var_top_apellido='';
            $var_apellido='apellido_gl';
            $var_nombre='nombre_gl';
            $var_cargo='cargo_gl';
            $var_margin_apellido_nombre='margin_apellido_nombre_gl';
        } 
    ?>
    <head>
        <style>

            *{
                padding: 0;
                margin: 0;
            }

            .fondo_cara,.fondo_atras{
                margin: 0px 0px 0 -57px;
                width: 100%;
                height: 100%;
                background-size: cover;
                background-repeat: no-repeat;
            }

            .fondo_cara{
                background: url('<?= base_url().$imagen?>');
            }

            .fondo_atras{
                background: url('<?= base_url().$imagen2?>');
            }

            .espacio_colaborador{
                height: 60px;
            }

            .espacio_gl{
                height: 81.5px;
            }

            .espacio2_colaborador{
                height: 125px;
            }

            .espacio2_gl{
                height: 115px;
            }

            .contenedor{
                height: 123px;
                width:  123px;
                border-radius: 50% !important;
                background-image: url(<?= base_url().$get_id[0]['foto_fotocheck_2'] ?>);
                background-size: cover;
                margin: 0px auto;
            }

            .contenedor_ifv{
                height: 112.5px;
                width:  112.5px;
                border-radius: 50% !important;
                background-image: url(<?= base_url().$get_id[0]['foto_fotocheck_2'] ?>);
                background-size: cover;
                margin: 7px auto 0px;
            }


            .contenedor-nombre-cargo{
                padding: 0px 0 0 0;
                width: 209px;
                height: 100px;
                display: block;
                /*background: black;*/
                background-repeat: no-repeat;
                background-size: cover;
                
                text-align: center;
            }

            .margin_apellido_nombre{
                margin: 45px 0 0 0px;
            }

            .margin_apellido_nombre_gl{
                margin: 15px 0 0 0px;
            }

            .apellido_colaborador{
                font-family: 'gothambold';
                font-size: 10pt;
                text-transform: uppercase;
                margin-bottom: 0px;
            }

            .apellido_gl{
                font-family: 'gothambold';
                font-size: 14pt;
                text-transform: uppercase;
                margin-bottom: 0px;
            }

            .top_apellido{
                margin-top: 10px;
            }

            .nombre_colaborador{
                font-family: 'gothambook';
                font-size: 11pt;
                margin-bottom: 0px;
            }

            .nombre_gl{
                font-family: 'gothambook';
                font-size: 12pt;
                margin-bottom: 0px;
            }

            .cargo_colaborador{
                margin-top: 10pt !important;
                font-family: 'ubuntu';
                color:white;
                
            }

            .color_gl{
                color: black;
            }

            .cargo_ifv{
                color: #fff !important;
                margin-top: 6pt !important;
                font-family: 'gothamcondmedium';
                font-size: 14pt;
            }

            .cargo_gl{
                margin-top: 5pt !important;
                font-family: 'gothambook';
                font-size: 10pt;
                color: #0077be !important;
            }

            .color_colaborador{
                color: white;
            }
            

            .contenedor-codigo-baras{
                width: 207px;
                display: block;
                /*background-color: blue;*/
                margin: 0 0 0 0px;
            }

            .codigo-barras{
                margin: 3px 10px -5px;
                width:100%;
                height: 20px;
                text-align: center;
            }

            .codigo-colaborador{
                width:100%; 
                font-size:6pt;
                text-align: center;
                font-family: 'gothambold';
            } 
            .cola{
                margin-top: 1pt !important;
                margin-bottom: -5pt !important;
                font-family: 'gothamcondmedium';
                font-size: 9pt;
                color: white !important;
            }
        </style>
    </head>
    <body>
    
        <div class="fondo_cara">
            <div class="<?php echo $var_esapacio;?>"></div>
            <div class="<?php echo $var_foto?>"></div>
            <div class="contenedor-nombre-cargo <?php echo $var_margin_apellido_nombre;?>">
                <div class="nombre-cargo">
                    <?php if($get_id[0]['id_empresa']=='6'){?>
                        <div class="cola">COLABORADOR(A)</div>
                    <?php } ?>
                    <div class="<?php echo $var_apellido?> <?php echo $var_color_letras_nombre_cargo?> <?php echo $var_top_apellido?>"><?php echo $get_id[0]['apellidos'].","?></div>
                    <div class="<?php echo $var_nombre?> <?php echo $var_color_letras_nombre_cargo;?>"><?php echo $get_id[0]['Nombre_corto'] ?></div>
                    <div class="<?php echo $var_cargo?>"><?php echo $get_id[0]['nom_cf'] ?></div>
                </div>
            </div>
        </div>
        <br>
        <div class="fondo_atras">
            <div class="<?php echo $var_esapacio2;?>"></div>
            <div class="contenedor-codigo-baras">
                <img class="codigo-barras" src="<?php echo base_url() ?>application/views/view_IFV/fotocheck_alumno/barcode.php?text=<?php echo $get_id[0]['codigo_gll'].'-C' ?>"/>
                <p class="codigo-colaborador"><b>Código del Colaborador(a): <?php echo $get_id[0]['codigo_gll'].'-C' ?></b></p>
            </div>
        </div>
    </body>
</html>


