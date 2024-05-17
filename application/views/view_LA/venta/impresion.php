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
            font-size: 16px; 
        }

        /*#contenido{
            position: absolute;
            top: 0;
            left: 0;
            width: 21cm;
            height: 29.7cm;
        }

        #contenido_recibo{
            width: 480px;
            height: <?php echo $altura; ?>px;
            margin: 0px;
            border: 2px solid #000;
        }*/

        #cabecera_tabla{
            width: 440px;
            margin: 30px 0 0 15px;
            border-collapse: collapse;
        }

        #imagen_superior{
            width: 120px;
            height: 80px;
        }

        #letra_titulo{
            text-align: center;
        }

        #nom_empresa{
            font-size: 26px;
            border-bottom: 1px solid #000;
            letter-spacing: 3px;
        }

       
        .negrita{
            font-size: 20px;
            font-weight: bold;
        }

        .sin_negrita{
            font-size: 20px;
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
            margin: 40px 0 0 15px;
            border-collapse: collapse;
        }

        #recibo_nro{
            width: 65%;
        }

        #fecha{
            width: 35%;
        }

        #usuario{
            width: 65%;
        }

        #hora{
            width: 35%;
        }

        #primera_linea{
            width: 440px;
            height: 15px;
            margin: 0 0 0 15px;
            border-bottom: 1px solid #000;
        }

        #segunda_tabla{
            width: 440px;
            margin: 15px 0 0 15px;
            border-collapse: collapse;
        }

        #tercera_tabla{
            width: 440px;
            margin: 30px 0 0 15px;
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
            margin: 40px 0 0 15px;
        }

        #recibi_conforme2{
            margin: 50px 0px 0px 15px;
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
            margin-left: 15px;
        }
    </style>
</head>
<body onload="window.print();">
    <div id="contenido">
        <div id="contenido_recibo">
            <table id="cabecera_tabla">
                <tr>
                    <!--<td>
                         <img id="imagen_superior" src="<?= base_url() ?>template/img/recibo_la_<?php echo $get_id[0]['color_logo']; ?>.png"> color lo obtenga de la base de datos
                        <img id="imagen_superior" src="<?= base_url() ?>template/img/recibo_la_blanco.png">
                    </td>-->
                    <td id="letra_titulo">
                        <div id="nom_empresa" class="negrita">LALELI EIRL</div>
                        <div id="ruc_empresa">RUC: 20602823891</div>
                    </td>
                </tr>
            </table>

            <table id="primera_tabla">
                <tr>
                    <td id="recibo_nro" class="negrita"><?php echo $get_id[0]['nro_documento']; ?> Nro: <span class="sin_negrita"><?php echo $get_id[0]['cod_venta']; ?></span></td>
                    <td id="fecha" class="negrita">Fecha: <span class="sin_negrita"><?php echo $get_id[0]['fecha']; ?></span></td>
                </tr>
                <tr>
                    <td id="usuario" class="negrita">Usuario: <span class="sin_negrita"><?php echo $get_id[0]['usuario_codigo']; ?></span></td>
                    <td id="hora" class="negrita">Hora: <span class="sin_negrita"><?php echo $get_id[0]['hora']." ".date('a',strtotime($get_id[0]['hora'])); ?></td>
                </tr>
            </table>

            <div id="primera_linea"></div>

            <table id="segunda_tabla">
                <tr>
                    <td class="negrita">Código: <span class="sin_negrita"><?php echo $get_id[0]['cod_alumno']; ?></span></td>
                </tr>
                <tr>
                    <td class="negrita">Alumno (a): <span class="sin_negrita"><?php echo $get_id[0]['nom_alumno']; ?></span></td>
                </tr>
                <tr>
                    <td class="negrita">Especialidad: <span class="sin_negrita"><?php echo $get_id[0]['Especialidad']; ?></span></td>
                </tr>
            </table>

            <table id="tercera_tabla">
                <thead>
                    <tr>
                        <th class="th_tercera_tabla borde_derecha sin_negrita" width="46%">Descripción</th>
                        <th class="th_tercera_tabla borde_derecha sin_negrita" width="12%">Talla</th>
                        <th class="th_tercera_tabla borde_derecha sin_negrita" width="22%">Código</th>
                        <th class="th_tercera_tabla sin_negrita" width="20%">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; foreach($list_detalle as $list){ ?>
                        <tr>
                            <td class="td_tercera_tabla"><?php echo $list['descripcion']; ?></td>
                            <td class="centro td_tercera_tabla"><?php echo $list['talla']; ?></td>
                            <td class="centro td_tercera_tabla"><?php echo $list['codigo']; ?></td>
                            <td class="derecha td_tercera_tabla">S/ <?php echo number_format(($list['precio']*$list['cantidad']),2); ?></td>
                        </tr>
                    <?php $total = $total+($list['precio']*$list['cantidad']); } ?>
                    <tr>
                        <td class="td_final_tercera_tabla"></td>
                        <td class="td_final_tercera_tabla"></td>
                        <td class="centro negrita td_final_tercera_tabla">Total</td>
                        <td class="derecha td_final_tercera_tabla">S/ <?php echo number_format($total,2); ?></td>
                    </tr>
                </tbody>
            </table>

            <div id="recibi_conforme" class="sin_negrita">Recibí conforme:</div>  

            <div id="segunda_linea"></div>

            <div id="letra_titulo">
                <div id="web" class="negrita">www.gllg.edu.pe</div>
                <div id="ruc_empresa">Visita Nuestro Facebook</div>
            </div>

            <?php if($get_id[0]['encomienda']==1){ ?> 
                <div id="encomienda">(*) Tiene productos pendientes de entregar</div> 
            <?php } ?>

            <div id="espacio_final"></div> 
        </div>
    </div>
</body>
</html>