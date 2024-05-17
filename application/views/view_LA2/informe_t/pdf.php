<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferencias</title>
    <style type="text/css" media="all">
        body {
            position: relative;
            margin: 0 auto; 
            color: #001028;
            font-size: 14px; 
        }

        #cabecera_tabla{
            width: 100%;
            border-collapse: collapse;
            /*border: 1px solid #000;*/
        }

        #letra_titulo{
            text-align: center;
        }

        #nom_empresa{
            font-size: 22px;
            border-bottom: 1px solid #000; 
            letter-spacing: 3px;
        }

        #ruc_empresa{
            font-size: 14px;
        }

        .negrita{
            font-weight: bold;
        }

        .sin_negrita{
            font-weight: normal;
        }

        .izquierda{
            text-align: left;
        }

        .centro{
            text-align: center;
        }

        #tercera_tabla{
            width: 100%;
            margin: 20px 0 0 0;
            border-collapse: collapse;
            font-size: 12px; 
        }

        .th_tercera_tabla{
            height: 25px;
            border: 1px solid #000;
        }

        .td_tercera_tabla{
            height: 30px;
            border: 1px solid #000;
        }

        .td_final_tercera_tabla{
            height: 30px;
        }
    </style>
</head>
<body>
    <div id="contenido">
        <div id="contenido_recibo">
            <table id="cabecera_tabla">
                <tr>
                    <td id="letra_titulo">
                        <div id="nom_empresa" class="negrita">LALELI EIRL</div>
                        <div id="ruc_empresa">RUC: 20602823891</div>
                    </td>
                </tr>
            </table>

            <table id="tercera_tabla">
                <thead>
                    <tr>
                        <th class="th_tercera_tabla negrita" width="29%">De</th>
                        <th class="th_tercera_tabla negrita" width="29%">Para</th>
                        <th class="th_tercera_tabla negrita" width="12%">Producto</th>
                        <th class="th_tercera_tabla negrita" width="10%">Cantidad</th>
                        <th class="th_tercera_tabla negrita" width="10%">Fecha</th>
                        <th class="th_tercera_tabla negrita" width="10%">Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($list_informe_transferencia as $list){ ?>
                        <tr>
                            <td class="izquierda td_tercera_tabla"><?php echo $list['de']; ?></td>
                            <td class="izquierda td_tercera_tabla"><?php echo $list['para']; ?></td>
                            <td class="izquierda td_tercera_tabla"><?php echo $list['cod_producto']; ?></td>
                            <td class="centro td_tercera_tabla"><?php echo $list['cantidad']; ?></td>
                            <td class="centro td_tercera_tabla"><?php echo $list['fecha']; ?></td>
                            <td class="izquierda td_tercera_tabla"><?php echo $list['usuario']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>