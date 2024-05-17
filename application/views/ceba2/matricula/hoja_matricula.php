<!DOCTYPE HTML5>
<html>
	<head>
		<title>Hoja de Matrícula</title>
		<meta charset="utf-8">
		<meta name="description" content="pdf cv numero1">
    <meta name="keywords" content="datos, usuario, pdf">
    <style type="text/css"  media="all">
        *{
            box-sizing: border-box;
            padding:0;
            margin:0;
            font-family: gothic;
        }

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
          width: 21cm;
          height: 29.7cm;
          background-image: url('template/img/Fondo_EP.png');
          background-size: contain;
        }

        .posicion_codigo{
          margin-top: 25px;
          margin-right: 35px;
        }

        .derecha{
          text-align: right;
        }

        .centro {
          text-align: center;
        }
        
        .span_principal{
          font-weight: bold;
        }

        .span_secundario{
          font-size: 13px;
        }

        table th{
          color: #FFF;
        }

        .primera_tabla{
          margin-top: 120px;
        }

        .posicion_datos_alumno{
          margin-top: 35px;
        }

        .segunda_tabla{
          margin-top: 20px;
          border-spacing: 8px;
        }

        .posicion_datos_familiar{
          margin-top: 35px;
        }

        .tercera_tabla{
          margin-top: 20px;
          border-spacing: 8px;
        }
    </style>
	</head>
	<body>
    <div id="contenido">
      <h3 class="derecha posicion_codigo">CODIGO DE ALUMNO: </h3>

      <table class="primera_tabla" width="100%">
        <thead class="ocultar">
          <tr>
            <th width="24%"></th>
            <th width="21%"></th>
            <th width="8%"></th>
            <th width="20%"></th>
            <th width="10%"></th>
            <th width="17%"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="derecha"><span class="span_principal">Año a que se Inscribe:</span></td>
            <td><span class="span_secundario"><?php echo $get_matricula[0]['descripcion_grado']; ?></span></td>
            <td class="derecha"><span class="span_principal">Fecha:</span></td>
            <td><span class="span_secundario"><?php echo date('d-m-Y H:i'); ?></span></td>
            <td class="derecha"><span class="span_principal">Sede:</span></td>
            <td><span class="span_secundario">EP1</span></td>
          </tr>
        </tbody>
      </table>

      <h2 class="centro posicion_datos_alumno">DATOS DEL ALUMNO(A)</h2>

      <table class="segunda_tabla" width="100%">
        <thead>
          <tr>
            <th width="24%"></th>
            <th width="12%"></th>
            <th width="8%"></th>
            <th width="4%"></th>
            <th width="22%"></th>
            <th width="11%"></th>
            <th width="7%"></th>
            <th width="12%"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="derecha"><span class="span_principal">Nombre del Alumno:</span></td>
            <td colspan="7"><span class="span_secundario"><?php echo $get_id[0]['nombres_alum']; ?></span></td>
          </tr>
          <tr>
            <td  class="derecha" class="derecha"><span class="span_principal">Apellido Paterno:</span></td>
            <td colspan="3"><span class="span_secundario"><?php echo $get_id[0]['apater_alum']; ?></span></td>
            <td class="derecha"><span class="span_principal">Apellido Materno:</span></td>
            <td colspan="3"><span class="span_secundario"><?php echo $get_id[0]['amater_alum']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Fecha de Nacimiento:</span></td>
            <td><span class="span_secundario"><?php echo $get_id[0]['fecha_nacimiento']; ?></span></td>
            <td class="derecha"><span class="span_principal">Edad:</span></td>
            <td><span class="span_secundario"><?php echo $get_id[0]['edad_alum']; ?></span></td>
            <td class="derecha"><span class="span_principal">Sexo:</span></td>
            <td><span class="span_secundario"><?php echo $get_id[0]['nom_sexo']; ?></span></td>
            <td class="derecha"><span class="span_principal">DNI:</span></td>
            <td><span class="span_secundario"><?php echo $get_id[0]['n_doc_alum']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Distrito:</span></td>
            <td colspan="3"><span class="span_secundario"><?php echo $get_id[0]['dis_alum']; ?></span></td>
            <td class="derecha"><span class="span_principal">Telf. Casa:</span></td>
            <td colspan="3"><span class="span_secundario"><?php echo $get_id[0]['telf_casa_alum']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Correo Electronico:</span></td>
            <td colspan="7"><span class="span_secundario"><?php echo $get_id[0]['correo_personal_alum']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Colegio de Procedencia:</span></td>
            <td colspan="7"><span class="span_secundario"><?php echo $get_id[0]['inst_procedencia']; ?></span></td>
          </tr>
        <tbody>
      </table>

      <h2 class="centro posicion_datos_familiar">DATOS FAMILIARES</h2>

      <table class="tercera_tabla" width="100%">
        <thead>
          <tr>
            <th width="24%"></th>
            <th width="20%"></th>
            <th width="11%"></th>
            <th width="15%"></th>
            <th width="18%"></th>
            <th width="12%"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="derecha"><span class="span_principal">Parentesto:</span></td>
            <td colspan="5"><span class="span_secundario"><?php echo $get_id[0]['nom_parentesco']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Nombre:</span></td>
            <td colspan="5"><span class="span_secundario"><?php echo $get_id[0]['nom_principal']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Direccion:</span></td>
            <td colspan="5"><span class="span_secundario"><?php echo $get_id[0]['direccion_prin']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Distrito:</span></td>
            <td><span class="span_secundario"><?php echo $get_id[0]['dis_prin']; ?></span></td>
            <td class="derecha"><span class="span_principal">Telf. Casa:</span></td>
            <td><span class="span_secundario"><?php echo $get_id[0]['telf_casa_prin']; ?></span></td>
            <td class="derecha"><span class="span_principal">Celular:</span></td>
            <td><span class="span_secundario"><?php echo $get_id[0]['celular_prin']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Centro de Trabajo:</span></td>
            <td colspan="2"><span class="span_secundario"><?php echo $get_id[0]['centro_empleo_prin']; ?></span></td>
            <td class="derecha"><span class="span_principal">Ocupacion:</span></td>
            <td colspan="2"><span class="span_secundario"><?php echo $get_id[0]['ocupacion_prin']; ?></span></td>
          </tr>
          <tr>
            <td class="derecha"><span class="span_principal">Correo Electronico:</span></td>
            <td colspan="5"><span class="span_secundario"><?php echo $get_id[0]['correo_personal_prin']; ?></span></td>
          </tr>
        </tbody>
      </table>
    </div>
	</body>
</html> 