<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $get_id[0]['nro_documento']; ?></title>
    <style type="text/css" media="all">
        body {
            position: relative;
            margin: 0 auto; 
            color: #001028;
            font-size: 14px; 
        }

        #contenido{
            position: absolute;
            top: 0;
            left: 0;
            width: 18cm;
            /*height: 29.7cm;*/
            height: 29.7cm;
        }

        #contenido_recibo{
            width: 480px;
            height: <?php echo $altura; ?>px;
            margin: 10px;
            border: 2px solid #000;
        }

        #cabecera_tabla{
            width: 440px;
            margin: 30px 0 0 20px;
            border-collapse: collapse;
        }

        #imagen_superior{
            width: 120px;
            height: 80px;
        }

        .letra_titulo{
            text-align: center;
        }

        .letra_titulo_2{
            text-align: left;
            margin: 30px 20px 0px 20px;
        }

        #nom_empresa{
            font-size: 22px;
            border-bottom: 1px solid #000;
            letter-spacing: 3px;
        }

        .ruc_empresa{
            font-size: 14px;
        }


        .negrita{
            font-weight: bold;
        }

        .sin_negrita{
            font-weight: normal;
        }

        .derecha{
            text-align: right;
        }

        .centro{
            text-align: center;
        }

        #primera_tabla{
            width: 440px;
            margin: 40px 0 0 20px;
            border-collapse: collapse;
        }

        #recibo_nro{
            width: 58%;
        }

        #fecha{
            width: 42%;
        }

        #usuario{
            width: 58%;
        }

        #hora{
            width: 42%;
        }

        #primera_linea{
            width: 440px;
            height: 15px;
            margin: 0 0 0 20px;
            border-bottom: 1px solid #000;
        }

        #segunda_tabla{
            width: 440px;
            margin: 15px 0 0 20px;
            border-collapse: collapse;
        }

        #tercera_tabla{
            width: 440px;
            margin: 30px 0 0 20px;
            border-collapse: collapse;
        }

        .th_tercera_tabla{
            height: 25px;
            border-bottom: 1px solid #000;
            border-top: 1px solid #000;
        }

        .borde_derecha{
            border-right: 1px solid #000;
        }

        .td_tercera_tabla{
            height: 30px;
            border-bottom: 1px solid #000;
        }

        .td_final_tercera_tabla{
            height: 30px;
        }

        #recibi_conforme{
            margin: 40px 0 0 20px;
        }

        #recibi_conforme2{
            margin: 40px 0px 0px 20px !important;
        }

        #espacio_final{
            margin: 20px 0px 0px 0px;
        }

        #segunda_linea{
            width: 310px;
            height: 15px;
            margin: 120px auto 0px;
            border-top: 1px solid #000;
            text-align: center;
        }

        #encomienda{
            margin-left: 30px;
        } 

        .tamanio_negrita{
            font-size: 19px;
            color:#000;
            font-family: Arial;
        }

        .tamanio_sin_negrita{
            font-size: 18px;
            color:#000;
            font-family: Arial;
        }

        .tamanio_sin_negrita2{
            font-size: 20px;
            color:#000;
            font-family: Arial;
        }

        .tamanio_sin_negrita3{
            font-size: 16px;
            color:#000;
            font-family: Arial;
        }

        .tamanio_sin_negrita_fut{
            font-size: 35px;
            color:#000;
            font-family: Arial;
        }

        .tamanio_sin_negrita_fut_negrita{
            font-size: 35px;
            color:#000;
            font-family: Arial;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="contenido">
        <div id="contenido_recibo">
            <table id="cabecera_tabla">
                <tr>
                    <td>
                        <!--<img id="imagen_superior" src="<?= base_url() ?>template/img/recibo_la_<?php echo $get_id[0]['color_logo']; ?>.png">-->
                    </td>
                    <td class="letra_titulo">
                        <div id="nom_empresa" class="negrita">IGB CHINCHA SAC</div>
                        <div class="ruc_empresa">RUC: 20602829939</div>
                    </td>
                </tr>
            </table>

            <table id="primera_tabla">
                <tr>
                    <td id="recibo_nro" class="negrita tamanio_negrita"><?php echo $get_id[0]['nro_documento']; ?> Nro: <span class="sin_negrita tamanio_sin_negrita"><?php echo $get_id[0]['cod_venta']; ?></span></td>
                    <td id="fecha" class="negrita tamanio_negrita">Fecha: <span class="sin_negrita tamanio_sin_negrita"><?php echo $get_id[0]['fecha']; ?></span></td>
                </tr>
                <tr>
                    <td id="usuario" class="negrita tamanio_negrita">Usuario: <span class="sin_negrita"><?php echo $get_id[0]['usuario_codigo']; ?></span></td>
                    <td id="hora" class="negrita tamanio_negrita">Hora: <span class="sin_negrita tamanio_sin_negrita"><?php echo $get_id[0]['hora']." ".date('a',strtotime($get_id[0]['hora'])); ?></td>
                </tr>
            </table>

            <div id="primera_linea"></div> 

            <table id="segunda_tabla">
                <tr>
                    <td class="negrita tamanio_negrita">Código: <span class="sin_negrita tamanio_sin_negrita2"><?php echo $get_id[0]['cod_alumno']; ?></span></td>
                </tr>
                <tr>
                    <td class="negrita tamanio_negrita">Alumno (a): <span class="sin_negrita tamanio_sin_negrita"><?php echo $get_id[0]['nom_alumno']; ?></span></td>
                </tr>
                <tr>
                    <td class="negrita tamanio_negrita">Programa de Estudio: <span class="sin_negrita tamanio_sin_negrita"><?php echo $get_id[0]['Especialidad']; ?></span></td>
                </tr>
            </table>

            <table id="tercera_tabla">
                <thead>
                    <tr>
                        <th class="th_tercera_tabla borde_derecha sin_negrita tamanio_sin_negrita" width="50%">Descripción</th>
                        <!--<th class="th_tercera_tabla borde_derecha sin_negrita tamanio_sin_negrita" width="12%">Talla</th>-->
                        <th class="th_tercera_tabla borde_derecha sin_negrita tamanio_sin_negrita" width="22%">Código</th>
                        <th class="th_tercera_tabla sin_negrita tamanio_sin_negrita" width="20%">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; foreach($list_detalle as $list){ ?>
                        <tr>
                            <td class="td_tercera_tabla tamanio_sin_negrita"><?php echo $list['nom_sistema']; ?></td>
                            <!--<td class="centro td_tercera_tabla tamanio_sin_negrita"><?php echo ""; ?></td>-->
                            <td class="centro td_tercera_tabla tamanio_sin_negrita"><?php echo $list['cod_producto']; ?></td>
                            <td class="derecha td_tercera_tabla tamanio_sin_negrita">S/ <?php echo number_format((($list['precio']-$list['descuento'])*$list['cantidad']),2); ?></td>
                        </tr>
                    <?php $total = $total+(($list['precio']-$list['descuento'])*$list['cantidad']); } ?>
                    <tr>
                        <td class="td_final_tercera_tabla tamanio_sin_negrita"></td>
                        <td class="centro negrita td_final_tercera_tabla tamanio_sin_negrita">Total</td>
                        <td class="derecha td_final_tercera_tabla tamanio_sin_negrita">S/ <?php echo number_format($total,2); ?></td>
                    </tr>
                </tbody>
            </table>
            
            <?php if ($validacion>0){?>
                <div id="recibi_conforme2" class="tamanio_sin_negrita_fut letra_titulo">< CODIGO FUT ></div>
                <div id="" class="tamanio_sin_negrita_fut_negrita letra_titulo"><?php echo $get_id[0]['codigo']; ?></div>
                <div class="letra_titulo_2">
                    <div class="tamanio_sin_negrita3">Activa tu FUT virtual (código válido sólo en el plazo máximo de 2 días hábiles) ingresando a <a  href="http://localhost/igbonline/"  target="_blank">www.igbonline.edu.pe</a></div>
                </div>
                
            <?php }else{?>

                <div id="recibi_conforme">Recibí conforme:</div>  
                <div id="segunda_linea">
                </div>
                <div class="letra_titulo">
                    <div id="web" class="negrita tamanio_negrita">www.igb.edu.pe</div>
                    <div class="ruc_empresa tamanio_sin_negrita">Visita nuestro Facebook</div>
                </div>


            <?php } ?>
            <div id="espacio_final"></div> 
                
            </div>     
            
        </div>
    </div>
</body>
</html>