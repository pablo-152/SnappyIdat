<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVALUACIÓN BÁSICA</title>
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

        #primera_tabla{
            width: 100%;
            margin: 15px 0 25px 0;
            border-collapse: collapse;
        }

        .segunda_tabla{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .primer_color_2{
            background: #808080;
            color: white;
        }

        .titulo_segunda_tabla{
            font-size: 14px;
            font-weight: bold;
            color: #868288;
        }

        .tercera_tabla{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .div_tabla{
            border: 2px solid black; 
            padding: 8px;
            margin-bottom: 25px;
        }

        .cuarta_tabla{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .letra_pregunta{
            font-size: 15px;
        }

        .espacio_nota{
            background: #D9D9D9;
        }

        .titulo_pregunta{
            font-size: 12px;
            color: #a5b5cb;
        }

        .titulo_nota{
            font-weight: bold;
            font-size: 12px;
        }

        .quinta_tabla{
            width: 100%;
            border-collapse: collapse;
        }

        .titulo_pregunta_2{
            font-size: 12px;
            color: black;
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

        .primer_color{
            background-color: #F2F2F2;
        }

        .segundo_color{
            background-color: #D9D9D9;
        }

        #primer_espacio{
            width: 17%;
        }

        #segundo_espacio{
            width: 17%;
        }

        #tercer_espacio{
            width: 33%;
        }

        #cuarto_espacio{
            width: 33%;
        }

        .padding_tabla{ 
            padding: 8px;
        }

        .linea_un_pixel{
            border-bottom: 1px solid #000;
        }

        .dos_por_ciento{
            width: 2%;
        }

        .cinco_por_ciento{
            width: 5%;
        }

        .trece_por_ciento{
            width: 13%;
        }

        .dieciocho_por_ciento{
            width: 18%;
        }
        
        .veinte_por_ciento{
            width: 20%;
        }

        .veintidos_por_ciento{
            width: 22%;
        }

        .veinticinco_por_ciento{
            width: 25%;
        }

        .treinta_por_ciento{
            width: 30%;
        }

        .treinticinco_por_ciento{
            width: 35%;
        }
        
        .cuarenta_por_ciento{
            width: 40%;
        }

        .cuarenticinco_por_ciento{
            width: 45%;
        }

        .borde_derecho{
            border-right: 1.5px solid #000;
        }

        .borde_izquierdo{
            border-left: 1.5px solid #000;
        }

        .borde_superior{
            border-top: 1.5px solid #000;
        }

        .borde_inferior{
            border-bottom: 1.5px solid #000;
        }

        .linea_dos_pixeles{
            border-bottom: 2px solid #000;
        }

        .borde_completo{
            border: 1.5px solid #000;
        }

        .alto_grande{
            height: 80px;
        }

        .alto_mediano{
            height: 55px;
        }

        .alto_pequeno{
            height: 10px;
        }

        .letra_negra{
            color: black !important; 
        }
    </style>
</head>
<body>
    <table id="cabecera_tabla">
        <tr>
            <td id="letra_titulo" class="negrita">EVALUACIÓN BÁSICA</div></td>
            <td id="imagen_titulo"><img id="imagen_superior" src="<?= base_url() ?>template/img/icono_fv.png"></td>
        </tr>
        <tr>
            <td id="letra_subtitulo">Registro individual del alumno(a)</td> 
            <td></td>
        </tr>
    </table>

    <table id="primera_tabla">
        <tr class="primer_color">
            <td class="negrita padding_tabla" colspan="3">Programa de Estudios: <span class="sin_negrita"><?php echo $get_id[0]['nom_especialidad']; ?></span></td>
            <td class="derecha padding_tabla">Codigo: <span class="linea_un_pixel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
        </tr>
        <tr class="primer_color">
            <td id="primer_espacio" class="negrita padding_tabla">Grupo: <span class="sin_negrita"><?php echo $get_id[0]['grupo']; ?></span></td>
            <td id="segundo_espacio" class="negrita padding_tabla">Modulo: <span class="sin_negrita"><?php echo $get_id[0]['modulo']; ?></td>
            <td id="tercer_espacio" class="negrita padding_tabla">Inicio: <span class="sin_negrita"><?php echo $get_id[0]['inicio_efsrt']; ?></td>
            <td id="cuarto_espacio" class="negrita padding_tabla">Termino: <span class="sin_negrita"><?php echo $get_id[0]['termino_efsrt']; ?></td> 
        </tr>
        <tr class="primer_color">
            <td id="primer_espacio" class="negrita padding_tabla" colspan="2">Apellido Pat.: <span class="sin_negrita"></span></td>
            <td id="tercer_espacio" class="negrita padding_tabla">Apellido Mat.: <span class="sin_negrita"></td>
            <td id="cuarto_espacio" class="negrita padding_tabla">Nombre(s): <span class="sin_negrita"></td> 
        </tr>
        <tr class="segundo_color">
            <td class="negrita padding_tabla" colspan="2">Fecha Evaluación: <span class="linea_un_pixel sin_negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;202&nbsp;&nbsp;&nbsp;</span></td>
            <td class="negrita padding_tabla">Evaluador: <span class="linea_un_pixel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
            <td class="derecha"><span class="linea_un_pixel">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td> 
        </tr>
    </table>

    <table class="segunda_tabla">
        <tr>
            <td class="dos_por_ciento"></td>
            <td class="centro padding_tabla cinco_por_ciento primer_color_2">1</td>
            <td class="padding_tabla titulo_segunda_tabla">CONOCIMIENTOS BASICOS TEORICOS</td>
        </tr>
    </table>

    <table class="tercera_tabla">
        <tr class="borde_completo">
            <td class="negrita padding_tabla">Fecha examen:</td>
            <td class="negrita padding_tabla veinticinco_por_ciento">Estado:</td>
            <td class="negrita padding_tabla veinticinco_por_ciento">Evaluación:</td>
            <td class="negrita padding_tabla veinte_por_ciento">Nota:</td>
        </tr>
    </table>

    <table class="segunda_tabla">
        <tr>
            <td class="dos_por_ciento"></td> 
            <td class="centro padding_tabla cinco_por_ciento primer_color_2">2</td>
            <td class="padding_tabla titulo_segunda_tabla">CONOCIMIENTOS BASICOS PRACTICAS</td>
        </tr>
    </table>

    <div class="div_tabla">
        <table class="cuarta_tabla">
            <tr>
                <td class="negrita padding_tabla letra_pregunta" colspan="3">Pregunta 1 <span class="sin_negrita">(Explicar o describir un procedimiento)</span></td>
            </tr>
            <tr>
                <td class="padding_tabla treinticinco_por_ciento borde_izquierdo borde_derecho borde_superior titulo_pregunta">Pregunta:</td>
                <td class="padding_tabla borde_derecho borde_superior titulo_pregunta">Observaciones:</td>
                <td class="centro padding_tabla trece_por_ciento titulo_nota">NOTA</td>
            </tr>
            <tr>
                <td class="padding_tabla alto_grande borde_izquierdo borde_derecho"></td>
                <td class="padding_tabla alto_grande borde_derecho"></td>
                <td class="padding_tabla alto_grande borde_superior borde_inferior borde_derecho espacio_nota"></td>
            </tr>
            <tr>
                <td class="padding_tabla alto_pequeno borde_izquierdo borde_derecho borde_inferior"></td>
                <td class="padding_tabla alto_pequeno borde_derecho borde_inferior"></td>
                <td class="centro padding_tabla alto_pequeno titulo_pregunta">10 Valores</td>
            </tr>
        </table>

        <table class="quinta_tabla">
            <tr>
                <td class="negrita padding_tabla letra_pregunta" colspan="3">Pregunta 2 <span class="sin_negrita">(Identificación de materiles de acuerdo al procedimiento indicado)</span></td>
            </tr>
            <tr>
                <td class="padding_tabla treinticinco_por_ciento borde_izquierdo borde_derecho borde_superior titulo_pregunta">Pregunta:</td>
                <td class="padding_tabla borde_derecho borde_superior titulo_pregunta">Observaciones:</td>
                <td class="centro padding_tabla trece_por_ciento titulo_nota">NOTA</td>
            </tr>
            <tr>
                <td class="padding_tabla alto_grande borde_izquierdo borde_derecho"></td>
                <td class="padding_tabla alto_grande borde_derecho"></td>
                <td class="padding_tabla alto_grande borde_superior borde_inferior borde_derecho espacio_nota"></td>
            </tr>
            <tr>
                <td class="padding_tabla alto_pequeno borde_izquierdo borde_derecho borde_inferior"></td>
                <td class="padding_tabla alto_pequeno borde_derecho borde_inferior"></td>
                <td class="centro padding_tabla alto_pequeno titulo_pregunta">10 Valores</td>
            </tr>
        </table>
    </div>

    <table class="segunda_tabla">
        <tr>
            <td class="dos_por_ciento"></td> 
            <td class="centro padding_tabla cinco_por_ciento primer_color_2">3</td>
            <td class="padding_tabla titulo_segunda_tabla">PRESENTACIÓN PERSONAL</td>
        </tr>
    </table>

    <div class="div_tabla">
        <table class="quinta_tabla">
            <tr>
                <td class="centro padding_tabla veinte_por_ciento borde_izquierdo borde_derecho borde_superior titulo_pregunta_2">Uniforme completo</td>
                <td class="centro padding_tabla veinte_por_ciento borde_derecho borde_superior titulo_pregunta_2">Puntualidad</td>
                <td class="centro padding_tabla veintidos_por_ciento borde_derecho borde_superior titulo_pregunta_2">Presentación Personal</td>
                <td class="centro padding_tabla borde_derecho borde_superior titulo_pregunta_2">Expresión Corporal/Verbal</td>
                <td class="centro padding_tabla trece_por_ciento titulo_nota">NOTA</td>
            </tr>
            <tr>
                <td class="padding_tabla alto_mediano borde_izquierdo borde_derecho borde_superior"></td>
                <td class="padding_tabla alto_mediano borde_derecho borde_superior"></td>
                <td class="padding_tabla alto_mediano borde_derecho borde_superior"></td>
                <td class="padding_tabla alto_mediano borde_derecho borde_superior"></td>
                <td class="padding_tabla alto_mediano borde_superior borde_inferior borde_derecho espacio_nota"></td>
            </tr>
            <tr>
                <td class="centro padding_tabla borde_izquierdo borde_derecho borde_inferior borde_superior titulo_pregunta">10 Valores</td>
                <td class="centro padding_tabla borde_derecho borde_inferior borde_superior titulo_pregunta">2.5 Valores</td>
                <td class="centro padding_tabla borde_derecho borde_inferior borde_superior titulo_pregunta">2.5 Valores</td>
                <td class="centro padding_tabla borde_derecho borde_inferior borde_superior titulo_pregunta">5 Valores</td>
                <td class="centro padding_tabla titulo_pregunta">(sumatorio)</td>
            </tr>
        </table>
    </div>
</body>
</html>