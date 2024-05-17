<!DOCTYPE HTML5>
<html>
	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="description" content="pdf cv numero1">
    <meta name="keywords" content="datos, usuario, pdf">
    <style type="text/css"  media="all">
        *{
            box-sizing: border-box;
            padding:0;
            margin:0;
            font-family: gothic;
            /*font-size:20px;*/
        }
        .clearfix:after {
          content: "";
          display: table;
          clear: both;
        }

        a {
          color: #5D6975;
          text-decoration: underline;
        }
        header {
          padding: 2px 0;
          /*margin-bottom: 0px;*/
        }

        #logo {
          text-align: center;
          /*margin-bottom: 10px;*/
        }

        #logo img {
          width: 90px;
          height:20px;
        }

        .hi {
          width:30%;
          height: 30px;
          border-bottom: 3px dashed  #2093c6;
          border-left: 3px solid  #2093c6;
          border-right: 3px solid  #2093c6;
          border-top: 3px dashed  #2093c6;
          color: #2093c6;
          font-size: 1.3em;
          line-height: 1.7em;
          font-weight: bold;
          padding-top: 5px;
          padding-left: 10px;
          padding-right: 10px;
          padding-bottom: 5px;
          margin: 0 0 10px 0;
          /*background: url(<?php echo base_url() ?>assets/especiales/dimension.png);*/
        }
        .imgaenperfil{
          width: 200px; height:150px; padding-right:10px;border-radius:40px;object-fit: cover;
        }

        #tdprimero{
          text-align: left !important;
          /*background:blue;*/
        }
        #tdsegundo{
          text-align: right !important;
        }

        #project {
          float: left;
        }

        #project span {
          color: #5D6975;
          text-align: right;
          width: 52px;
          margin-right: 15px;
          display: inline-block;
          font-size: 0.8em;
          /*margin-bottom: 15px;*/
        }
        #company {
          float: right;
          text-align: center;
        }
        #project div,
        #company div {
          white-space: nowrap;        
        }

        /**************************** */

        table th,
        table #tdb {
          text-align: center;
        }

        #tableuno {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          /*margin-bottom: 1px;*/
        }

        
        #tableuno th {
          padding: 5px 20px;
          color: #5D6975;
          border-bottom: 1px solid #CC7924;
          border-top: 1px solid #9BB552;
          border-left:1px solid #2093C6;
          border-right:1px solid #2093C6;
          white-space: nowrap;        
          font-weight: bold;
        }

      /****************************** */

          #tabledos {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            /*margin-bottom: 0px;*/
          }

          #tabledos td {
            text-align: center;
            padding: 5px ;
            color:black;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            font-size: 11px;
          }
          #tabledos tr:nth-child(2n-1) td {
            /*background:#C6DAF7;*/
            background:white;
          }

          
          #tabledos th {
            padding: 2px 0px;
            color: white;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            white-space: nowrap;        
            font-weight: bold;
            background-color:#025790;
            font-size: 10px;
          }

          /****************************** */
          #tabledoss {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            /*margin-bottom: 0px;*/
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
          }

          #tabledoss th {
            padding: 5px 20px;
            color: #ffffff;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            white-space: nowrap;        
            font-weight: bold;
            background-color:#025790;
          }
          #tabledoss td {
            text-align: center;
            padding: 5px;
            color:#6c6c6c;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            font-size: 8px;

          }

          #tabledoss tr:nth-child(2n-1) td {
            /*background:#C6DAF7;*/
            background:white;
          }

          
          #tabledoss #aqui tr:nth-child(2n-1) td {
            /*background:#C6DAF7;*/
            background:white;
          }

      /*********************** */
          #tabledosss {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            /*margin-bottom: 0px;*/
          }

          #tabledosss th {
            padding: 5px 20px;
            color: #ffffff;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            white-space: nowrap;        
            font-weight: bold;
            background-color:#025790;
          }
          #tabledosss td {
            text-align: center;
            padding: 5px ;
            color:#6c6c6c;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            font-size: 8px;

          }
          /*tbody#aqui tr:nth-child(2n-1) td {
            background:#C6DAF7;
          }*/

      /******************************** */
        #tabletres {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          /*margin-bottom: 0px;*/
        }
            
        #tabletres td {
          text-align: center;
          padding: 5px ;
          color:black;
          font-size: 11px;
          border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
          
        }

        #tabletres th {
          padding: 5px 20px;
            color: white;
            border-bottom: 1px solid #6c6c6c;
            border-top: 1px solid #6c6c6c;
            border-left:1px solid #6c6c6c;
            border-right:1px solid #6c6c6c;
            white-space: nowrap;        
            font-weight: bold;
            background-color:#025790;
            font-size: 11px;
        }


        .fontlb{
          font-weight: 600;
          font-family: gothic;
        }

        body {
          
          background: url(<?php echo base_url() ?>template/img/fondo_pdf.jpg);
          background-size: 15rem;
          
        }

        body p{
          font-size: 13px; 
        }

        p.saltodepagina
        {
        page-break-after: always;
        }
        .copyright .container-fluid{
          
          color: #5D6975;
        }
    </style>
    <style>
        .btn,
        .navbar-link,
        .nav-tabs > li > a,
        .nav-tabs > li > a:after,
        .nav-pills > li > a,
        .nav li > a > .label,
        .nav li > a > .badge,
        .breadcrumb > li > a,
        .breadcrumb-elements > li > a,
        .tt-suggestion,
        .tokenfield .token,
        .selectboxit-btn,
        .bootstrap-select .btn-default,
        .select2-results__option,
        .select2-selection__choice__remove,
        .dropdown-menu > li > a,
        .dropdown-menu > li > label,
        .wizard .actions a,
        .checker span:after,
        .choice span:after,
        .selectboxit-option-anchor,
        .dt-autofill-list ul li,
        .dt-autofill-button .btn,
        .dataTable .select-checkbox:before,
        .dataTable .select-checkbox:after,
        .pika-button,
        .sp-input,
        .navbar-nav > li > a,
        .dropdown-content-footer a,
        .icons-list > li > a,
        .picker__nav--prev,
        .picker__nav--next,
        .multiselect.btn-default,
        .list-group-item,
        .pagination > li > a,
        .pagination > li > span,
        .pager > li > a,
        .pager > li > span,
        .datepicker-dropdown .day,
        a.label,
        a.badge,
        .ui-datepicker-buttonpane > button,
        .ui-button,
        .ui-menu-item,
        .ui-selectmenu-button,
        .ui-datepicker a,
        .media-link,
        .menu-list li > a,
        .plupload_file_action > a,
        .dataTables_paginate .paginate_button,
        .dataTables_filter input,
        .dt-button,
        .picker__list-item,
        .picker__day,
        .picker__footer,
        .sp-replacer,
        .sp-cancel,
        .sp-choose,
        .sp-palette-toggle,
        .daterangepicker td,
        .daterangepicker th,
        .noUi-handle,
        .fc-button,
        .plupload_button,
        .picker__footer button,
        .picker__list button,
        .AnyTime-btn,
        .plupload_filelist li,
        .password-indicator-group.input-group-addon,
        .password-indicator-label-absolute,
        .select2-selection--single:not([class*=bg-]),
        .select2-selection--multiple:not([class*=bg-]) .select2-selection__choice,
        .bootstrap-select.btn-group .dropdown-menu > li > a .check-mark {
        -webkit-transition: all ease-in-out 0.15s;
        -o-transition: all ease-in-out 0.15s;
        transition: all ease-in-out 0.15s;
        }
        .close,
        .tag [data-role='remove'] {
        -webkit-transition: opacity ease-in-out 0.15s;
        -o-transition: opacity ease-in-out 0.15s;
        transition: opacity ease-in-out 0.15s;
        }
        .wysiwyg-color-black {
        color: black;
        }
        .wysiwyg-color-silver {
        color: silver;
        }
        .wysiwyg-color-gray {
        color: gray;
        }
        .wysiwyg-color-white {
        color: white;
        }
        .wysiwyg-color-maroon {
        color: maroon;
        }
        .wysiwyg-color-red {
        color: red;
        }
        .wysiwyg-color-purple {
        color: purple;
        }
        .wysiwyg-color-fuchsia {
        color: fuchsia;
        }
        .wysiwyg-color-green {
        color: green;
        }
        .wysiwyg-color-lime {
        color: lime;
        }
        .wysiwyg-color-olive {
        color: olive;
        }
        .wysiwyg-color-yellow {
        color: yellow;
        }
        .wysiwyg-color-navy {
        color: navy;
        }
        .wysiwyg-color-blue {
        color: blue;
        }
        .wysiwyg-color-teal {
        color: teal;
        }
        .wysiwyg-color-aqua {
        color: aqua;
        }
        .wysiwyg-color-orange {
        color: orange;
        }
        .ace_editor {
        height: 400px;
        position: relative;
        }
        ul {
          font-size: 12px;
        }
    </style>
	</head>
	<body>
      
    
      
    
    <br>
    <p style="margin-top:0px;COLOR:#1f4e79;font-size:18px;font-family: 'Roboto'!important;" align="left"><b style="font-size: 16px;font-family: 'Roboto'!important;">Fueran realizados los siguientes cambios que necesitan de su aprobación:</b><br>
    
    <table id="tabledos"  >
        <thead >
          <tr>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Registro</b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Solicitado por </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Fecha pedido </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Empresa </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Nombre </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Código </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Especialidad </b></th>
            <!--<th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Unidad Didáctica </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Fecha inicio </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Fecha fin </b></th>-->
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Estado </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Motivo </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Fecha fin de Clases </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Faltas Injustificadas </b></th>
            <th style="background-color:#f38a0b;color:white;"><b style="font-size: 13px;font-family: 'Roboto'!important;">Observaciones </b></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="font-family: 'Roboto'!important;"><?php if($version==1){echo "Original";}else{echo "Editado";}?></td>
            <td style="font-family: 'Roboto'!important;"><?php echo $_SESSION['usuario'][0]['usuario_codigo']; ?></td>
            <td style="font-family: 'Roboto'!important;"><?php echo date('d/m/Y') ?></td>
            <td style="font-family: 'Roboto'!important;">FV</td>
            <td style="font-family: 'Roboto'!important;"><?php echo $get_alumno[0]['Nombre_Completo'] ?></td>
            <td style="font-family: 'Roboto'!important;"><?php echo $get_alumno[0]['Codigo'] ?></td>
            <td style="font-family: 'Roboto'!important;"><?php echo $get_alumno[0]['Especialidad'] ?></td>
            <!--<td style="font-family: 'Roboto'!important;"></td>
            <td style="font-family: 'Roboto'!important;"></td>
            <td style="font-family: 'Roboto'!important;"></td>-->
            <td style="font-family: 'Roboto'!important;">Retirado(a)</td>
            <td style="font-family: 'Roboto'!important;"><?php if($id_motivo==1){ echo "Otro (".$otro_motivo.")";}else{echo $get_motivo[0]['nom_motivo']; }?></td>
            <td style="font-family: 'Roboto'!important;"><?php echo date("d/m/Y", strtotime($fecha_nasiste)); ?></td>
            <td style="font-family: 'Roboto'!important;"></td>
            <td style="font-family: 'Roboto'!important;"><?php echo $resumen; ?></td>
          </tr>
        </tbody>
    </table>
<br>
<?php if($btn==1){?>
  <div class="modal-footer" align="center">
  
  <a type="button" target="_blank" href="<?= site_url('AppIFV/Aprobar_Retiro/') ?><?php echo $id_alumno; ?>/1" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off" ><button type="button" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off" style="background-color: green;color: white;border-color: green;border-radius: 8px;width: 100px;height: 40px;font-family: 'Roboto', Helvetica Neue, Helvetica, Arial, sans-serif;font-size: 16px;line-height: 1.5384616;">Aprobar </button></a>  
  <a type="button" target="_blank" href="<?= site_url('AppIFV/Aprobar_Retiro/') ?><?php echo $id_alumno; ?>/2" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off" ><button type="button" class="btn btn-primary" data-loading-text="Loading..." autocomplete="off" style="background-color: red;color: white;border-color: red;border-radius: 8px;width: 100px;height: 40px;font-family: 'Roboto', Helvetica Neue, Helvetica, Arial, sans-serif;font-size: 16px;line-height: 1.5384616;">Rechazar </button></a>  
    
    
  </div>
<?php }?>
    


	</body>
</html>