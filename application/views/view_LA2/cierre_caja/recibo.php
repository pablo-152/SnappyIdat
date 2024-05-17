<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Cierre Caja</title>
    <style type="text/css" media="all">
        body {
            position: relative;
            margin: 0 auto; 
            color: #001028;
            font-size: 14px; 
        }

        #ruc_empresa{
            
        }

        #contenido{
            position: absolute;
            top: 0;
            left: 0;
            width: 21cm;
            height: 29.7cm;
        }

        #contenido_recibo{
            width: 500px;
            height: 750px;
            margin: 20px;
            border: 2px solid #000;
        }

        #cabecera_tabla{
            width: 440px;
            margin: 30px 0 0 30px;
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
            font-size: 25px;
        }

        .negrita{
            font-weight: bold;
            font-family: Arial;
            font-size: 19px;
        }

        .sin_negrita{
            font-weight: normal;
            font-family: Arial;
            font-size: 17px;
        }

        .derecha{
            text-align: right;
        }

        .centro{
            text-align: center;
        }

        #primera_tabla{
            width: 440px;
            margin: 40px 0 0 30px;
            border-collapse: collapse;
        }

        #recibo_nro{
            width: 60%;
        }

        #fecha{
            width: 40%;
        }

        #usuario{
            width: 60%;
        }

        #hora{
            width: 40%;
        }

        #primera_linea{
            width: 440px;
            height: 15px;
            margin: 0 0 0 30px;
            border-bottom: 1px solid #000;
        }

        #segunda_tabla{
            width: 440px;
            margin: 30px 0 0 30px;
            border-collapse: collapse;
        }

        .th_segunda_tabla{
            height: 25px;
            border-bottom: 1px solid #000;
            border-top: 1px solid #000;
        }

        .borde_derecha{
            border-right: 1px solid #000;
        }

        .altura_tabla{
            height: 30px;
        }

        .borde_superior{
            border-top: 1px solid #000;
        }

        .borde_inferior{
            border-bottom: 1px solid #000;
        }

        .mas_ancho{
            height: 60px; 
        }

        .color_blanco{
            color: white;
        }

        #tercera_tabla{
            width: 440px;
            margin: 40px 0 0 30px;
            border-collapse: collapse;
        }

        #espacio_final{
            margin: 20px 0px 0px 0px;
        }
    </style>
</head>
<body>
    <div id="contenido">
        <div id="contenido_recibo">
            <table id="cabecera_tabla">
                <tr>
                    <td>
                        <img id="imagen_superior" src="<?= base_url() ?>template/img/recibo_la_blanco.png">
                    </td>
                    <td id="letra_titulo">
                        <div id="nom_empresa" class="negrita">CIERRE CAJA</div>
                        <div id="ruc_empresa" class="sin_negrita"><?php echo $get_id[0]['cod_sede']; ?><?php echo substr($get_id[0]['nom_sede'],0,4); ?></div>
                    </td>
                </tr>
            </table>

            <table id="primera_tabla">
                <tr>
                    <td id="recibo_nro" class="negrita">Cierre caja de: <span class="sin_negrita"><?php echo $get_id[0]['cod_vendedor']; ?></span></td>
                    <td id="fecha" class="negrita">Fecha: <span class="sin_negrita"><?php echo $get_id[0]['caja']; ?></span></td>
                </tr>
                <tr>
                    <td id="usuario" class="negrita">Usuario: <span class="sin_negrita"><?php echo $get_id[0]['cod_entrega']; ?></span></td>
                    <td id="hora" class="negrita">Hora: <span class="sin_negrita"><?php echo $get_id[0]['hora']." ".date('a',strtotime($get_id[0]['hora'])); ?></td>
                </tr>
            </table>

            <div id="primera_linea"></div>

            <table id="segunda_tabla">
                <thead>
                    <tr>
                        <th class="altura_tabla borde_superior borde_inferior borde_derecha sin_negrita" width="40%">Descripción</th>
                        <th class="altura_tabla borde_superior borde_inferior borde_derecha sin_negrita" width="30%">Ct.</th>
                        <th class="altura_tabla borde_superior borde_inferior sin_negrita" width="30%">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="altura_tabla borde_inferior negrita">Ventas</td>
                        <td class="altura_tabla borde_inferior"></td>
                        <td class="altura_tabla borde_inferior"></td>
                    </tr>
                    <tr>
                        <td class="altura_tabla borde_inferior sin_negrita"><span class="color_blanco">11</span>Recibos:</td>
                        <td class="altura_tabla borde_inferior centro sin_negrita"><?php echo $get_id[0]['recibos']; ?></td>
                        <td class="altura_tabla borde_inferior derecha sin_negrita">S/ <?php echo $get_id[0]['total_recibos']; ?></td>
                    </tr>
                    <tr>
                        <td class="altura_tabla borde_inferior sin_negrita"><span class="color_blanco">11</span>Boletas:</td>
                        <td class="altura_tabla borde_inferior centro sin_negrita"><?php echo $get_id[0]['boletas']; ?></td>
                        <td class="altura_tabla borde_inferior derecha sin_negrita">S/ <?php echo $get_id[0]['boletas']; ?></td>
                    </tr>
                    <tr>
                        <td class="altura_tabla borde_inferior sin_negrita "><span class="color_blanco">11</span>Facturas:</td>
                        <td class="altura_tabla borde_inferior centro sin_negrita"><?php echo $get_id[0]['facturas']; ?></td>
                        <td class="altura_tabla borde_inferior derecha sin_negrita">S/ <?php echo $get_id[0]['facturas']; ?></td>
                    </tr>
                    <tr>
                        <td class="altura_tabla borde_inferior negrita">Creditos</td>
                        <td class="altura_tabla borde_inferior"></td>
                        <td class="altura_tabla borde_inferior"></td>
                    </tr>
                    <tr>
                        <td class="altura_tabla borde_inferior sin_negrita"><span class="color_blanco">11</span>Devoluciones:</td>
                        <td class="altura_tabla borde_inferior centro sin_negrita" ><?php echo $get_id[0]['devoluciones']; ?></td>
                        <td class="altura_tabla borde_inferior derecha sin_negrita">-S/ <?php echo $get_id[0]['total_devoluciones']; ?></td>
                    </tr>
                    <tr>
                        <td class="altura_tabla borde_inferior sin_negrita"><span class="color_blanco">11</span>Notas Credito:</td>
                        <td class="altura_tabla borde_inferior centro sin_negrita">0</td>
                        <td class="altura_tabla borde_inferior derecha sin_negrita">S/ 0.00</td>
                    </tr>
                    <tr>
                        <td class="altura_tabla"></td>
                        <td class="altura_tabla negrita">Saldo Automatico:</td>
                        <td class="altura_tabla derecha sin_negrita">S/ <?php echo $get_id[0]['saldo_automatico']; ?></td>
                    </tr>
                    <tr>
                        <td class="altura_tabla"></td>
                        <td class="altura_tabla negrita">Saldo Manual:</td>
                        <td class="altura_tabla derecha sin_negrita">S/ <?php echo $get_id[0]['monto_entregado']; ?></td>
                    </tr>
                    <tr>
                        <td class="altura_tabla"></td>
                        <td class="altura_tabla negrita">Diferencia:</td>
                        <td class="altura_tabla derecha sin_negrita">S/ <?php echo $get_id[0]['diferencia']; ?></td>
                    </tr>
                </tbody>
            </table>

            <table id="tercera_tabla">
                <tr>
                    <td class="altura_tabla centro negrita" width="40%">Entregado Por:</td>
                    <td class="altura_tabla" width="20%"></td>
                    <td class="altura_tabla centro negrita" width="40%">Recibido Por:</td>   
                </tr>
                <tr>
                    <td class="altura_tabla borde_inferior mas_ancho"></td>
                    <td class="altura_tabla"></td>
                    <td class="altura_tabla borde_inferior mas_ancho"></td>
                </tr>
            </table>

            <div id="espacio_final"></div> 
                
            </div> 
        </div>
    </div>
</body>
</html>