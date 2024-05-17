<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHARLA DE INDUCCIÓN</title>
    <style type="text/css" media="all">
        body {
            font-size: 13px; 
        }

        #cabecera_tabla{
            width: 100%;
            border-collapse: collapse;
        }

        #letra_titulo{
            width: 65%;
            text-align: left;
            border-bottom: 2px solid #000;
            padding-left: 10px;
            font-size: 35px;
        }

        #imagen_titulo{
            text-align: right;
        }

        #imagen_superior{
            width: 65px;
            height: 65px;
        }

        #letra_subtitulo{
            font-size: 20px;
            padding-left: 10px;
            color: #808080;
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
            width: 100%;
            margin: 30px 0 30px 0;
            border-collapse: collapse;
        }

        .primer_color{
            background-color: #F2F2F2;
        }

        .segundo_color{
            background-color: #D9D9D9;
        }

        #primer_espacio{
            width: 25%;
        }

        #segundo_espacio{
            width: 25%;
        }

        #tercer_espacio{
            width: 25%;
        }

        #cuarto_espacio{
            width: 25%;
        }

        .padding_tabla{
            padding: 8px;
        }

        .linea_un_pixel{
            border-bottom: 1px solid #000;
        }

        .segunda_tabla{
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .cinco_por_ciento{
            width: 5%;
        }

        .cuarenticinco_por_ciento{
            width: 45%;
        }

        .veinte_por_ciento{
            width: 20%;
        }

        .treinta_por_ciento{
            width: 30%;
        }

        .borde_derecho{
            border-right: 1px solid #000;
        }

        .linea_dos_pixeles{
            border-bottom: 2px solid #000; 
        }
    </style>
</head>
<body>
    <table id="cabecera_tabla">
        <tr>
            <td id="letra_titulo" class="negrita">CHARLA DE INDUCCIÓN</div></td>
            <td id="imagen_titulo"><img id="imagen_superior" src="<?= base_url() ?>template/img/icono_fv.png"></td>
        </tr>
        <tr>
            <td id="letra_subtitulo">registro de asistencia</td> 
            <td></td>
        </tr>
    </table>

    <table id="primera_tabla">
        <tr class="primer_color">
            <td class="negrita padding_tabla" colspan="2">Especialidad: <span class="sin_negrita"><?php echo $get_id[0]['nom_especialidad']; ?></span></td>
            <td></td>
            <td class="derecha padding_tabla">Referencia: <span class="linea_un_pixel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
        </tr>
        <tr class="primer_color">
            <td id="primer_espacio" class="negrita padding_tabla">Grupo: <span class="sin_negrita"><?php echo $get_id[0]['grupo']; ?></span></td>
            <td id="segundo_espacio" class="negrita padding_tabla">Modulo: <span class="sin_negrita"><?php echo $get_id[0]['modulo']; ?></td>
            <td id="tercer_espacio" class="negrita padding_tabla">Inicio: <span class="sin_negrita"><?php echo $get_id[0]['inicio_efsrt']; ?></td>
            <td id="cuarto_espacio" class="negrita padding_tabla">Termino: <span class="sin_negrita"><?php echo $get_id[0]['termino_efsrt']; ?></td> 
        </tr>
        <tr class="segundo_color">
            <td class="negrita padding_tabla">Fecha: <span class="linea_un_pixel sin_negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;202&nbsp;&nbsp;&nbsp;</span></td>
            <td class="negrita padding_tabla">Hora: <span class="linea_un_pixel sin_negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
            <!--<td class="negrita padding_tabla">Participantes: <span class="linea_un_pixel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>-->
            <td class="negrita padding_tabla">Ponente: <span class="linea_un_pixel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
            <td class="derecha"><span class="linea_un_pixel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td> 
        </tr>
    </table>

    <?php $i = 1; foreach($list_matriculado as $list){ ?>
        <table class="segunda_tabla">
            <tr>
                <td class="cinco_por_ciento centro padding_tabla borde_derecho" rowspan="2"><?php echo $i; ?></td>
                <td class="cuarenticinco_por_ciento negrita padding_tabla">Apellidos(s): <span class="sin_negrita"><?php echo $list['apellidos']; ?></span></td>
                <td class="veinte_por_ciento negrita padding_tabla">Código: <span class="sin_negrita"><?php echo $list['Codigo']; ?></span></td>
                <td class="treinta_por_ciento padding_tabla"></td>
            </tr>
            <tr>
                <td class="negrita padding_tabla">Nombre(s): <span class="sin_negrita"><?php echo $list['Nombre']; ?></span></td>
                <td class="negrita padding_tabla">DNI: <span class="sin_negrita"><?php echo $list['Dni']; ?></span></td>
                <td class="centro"><span class="linea_dos_pixeles">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
            </tr>
        </table>
    <?php $i++; } ?>
</body>
</html>