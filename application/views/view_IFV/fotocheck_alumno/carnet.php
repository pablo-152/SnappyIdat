<!DOCTYPE html>
<html>
<?php 
$color="";
$futer="";
$stylefecha="";
$styleespecialidad="";
if($get_id[0]['Especialidad']=='Desarrollo de Sistemas de Información'){
    $color="#a18a49";
    $futer="FRANJA-SISTEMAS.png";
    $stylefecha="padding: 10px 3px 0px 3px;height:30px;font-size:7px;max-height:30px;min-height:30px;margin-bottom:-25px;";
    $styleespecialidad="padding: 3px 1px 4px 1px;line-height: 1.1;max-height:30px;min-height:30px; margin-bottom:-25px;";
}if($get_id[0]['Especialidad']=='Administración Empresas'){
    $color="#927eb0";
    $futer="footer.png";
    $stylefecha="padding: 10px 3px 0px 3px;height:30px;font-size:7px;max-height:30px;min-height:30px;margin-bottom:-25px;";
    $styleespecialidad="padding: 5px 1px 6px 1px;line-height: 1.1;font-size:13px;max-height:30px;min-height:30px; margin-bottom:-25px;";
}if($get_id[0]['Especialidad']=='Enfermería Técnica'){
    $color="#007561";
    $futer="FRANJA-ENFERMERIA.png";
    $stylefecha="padding: 10px 3px 0px 3px;height:30px;font-size:7px;max-height:30px;min-height:30px;margin-bottom:-25px;";
    $styleespecialidad="padding: 3px 1px 2px 1px;line-height: 1.1;font-size:16px;max-height:30px;min-height:30px; margin-bottom:-25px;";
}if($get_id[0]['Especialidad']=='Farmacia Técnica'){
    $color="#598ca7";
    $futer="FRANJA-FARMACIA.png";
    $stylefecha="padding: 10px 3px 0px 3px;height:30px;font-size:7px;max-height:30px;min-height:30px;margin-bottom:-25px;";
    $styleespecialidad="padding: 3px 1px 2px 1px;line-height: 1.1;font-size:16px;max-height:30px;min-height:30px; margin-bottom:-25px;";
}if($get_id[0]['Especialidad']=='Contabilidad con Mención en Finanzas'){
    $color="#c0222c";
    $futer="FRANJA-CONTABILIDAD.png";
    $stylefecha="padding: 10px 3px 0px 3px;height:30px;font-size:7px;max-height:30px;min-height:30px;margin-bottom:-25px;";
    $styleespecialidad="padding: 9px 1px 9px 1px;line-height: 1.1;font-size:10px;max-height:30px;min-height:30px; margin-bottom:-25px;";
} ?>
<head>
    <style>
        #contenedor {
            background-image: url('<?= base_url().$get_id[0]['foto_fotocheck_2'] ?>');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: left top;
            height: 140px;
            width: 110px;
            border-radius: 3%;
            border-color: <?php echo $color ?>;
            border-width: 2px;
            border-style: solid;
		margin-left:-10px;
		margin-right:50px;
		margin-top:5px;
        }

    </style>
</head>

<body >
    <img style="margin-left:-50px;margin-top:5px;margin-right:50px;width:100%;height:60px;" src="<?= base_url() ?>template/img/header.png"> 
    
    <div id="contenedor"></div>
    <div style="margin-left:-50px;padding: 8px 1px 8px 1px;line-height: 1.1;width:100%;color:<?php echo $color ?>;font-size:17px;font-family:Gotham" align="center"><span ><b><?php echo $get_id[0]['apellidos'].","?></b><br><?php echo $get_id[0]['Nombre_corto'] ?><br></span> </div>  
    
        <div>
            <div style="<?php echo $stylefecha ?> text-align:center;width:35%;float:left;margin-left:-57px;background-color:<?php echo $color ?>;border-top-right-radius: 5px;border-bottom-right-radius: 5px;vertical-align: middle;color:white;">
                <b>&nbsp;Fecha&nbsp;de&nbsp;emisión:<br>&nbsp;<?php if($get_id[0]['mes_fotocheck']==1){echo "Enero";}
                if($get_id[0]['mes_fotocheck']==2){echo "Febrero";}if($get_id[0]['mes_fotocheck']==3){echo "Marzo";}if($get_id[0]['mes_fotocheck']==4){echo "Abril";}
                if($get_id[0]['mes_fotocheck']==5){echo "Mayo";}if($get_id[0]['mes_fotocheck']==6){echo "Junio";}if($get_id[0]['mes_fotocheck']==7){echo "Julio";}
                if($get_id[0]['mes_fotocheck']==8){echo "Agosto";}if($get_id[0]['mes_fotocheck']==9){echo "Setiembre";}if($get_id[0]['mes_fotocheck']==10){echo "Octubre";}
                if($get_id[0]['mes_fotocheck']==11){echo "Noviembre";}if($get_id[0]['mes_fotocheck']==12){echo "Diciembre";} ?>&nbsp;<?php echo $get_id[0]['anio_fotocheck'] ?></b>
            </div>
            <?php if($get_id[0]['Especialidad']=='Desarrollo de Sistemas de Información'){ ?>
            <div style="<?php echo $styleespecialidad ?> vertical-align: middle;display:inline-block;width:62.5%;float:right;margin-right:50px;text-align:center;background-color:<?php echo $color ?>;border-top-left-radius: 5px;border-bottom-left-radius: 5px;color:white;font-family:font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif !important;" align="center">
                <b style="font-size:10px;" id="especialidad"><?php echo substr(mb_strtoupper($get_id[0]['Especialidad']),0,-16)?></b> <br>
                <b style="font-size:10px;" id="especialidad"><?php echo substr(mb_strtoupper($get_id[0]['Especialidad']),-15)?></b> 
            </div>   
            <?php } elseif($get_id[0]['Especialidad']=='Administración Empresas'){ ?>
                <div style="<?php echo $styleespecialidad ?> vertical-align: middle;display:inline-block;width:62.5%;float:right;margin-right:50px;text-align:center;background-color:<?php echo $color ?>;border-top-left-radius: 5px;border-bottom-left-radius: 5px;color:white;font-family:font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif !important;" align="center">
                <b id="especialidad"><?php echo substr(mb_strtoupper($get_id[0]['Especialidad']),0,15)?></b> <br>
                <b id="especialidad"><?php echo "DE ".substr(mb_strtoupper($get_id[0]['Especialidad']),-9)?></b> 
                
                <?php } else{ ?>
                <div style="<?php echo $styleespecialidad ?> vertical-align: middle;display:inline-block;width:62.5%;float:right;margin-right:50px;text-align:center;background-color:<?php echo $color ?>;border-top-left-radius: 5px;border-bottom-left-radius: 5px;color:white;font-family:font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif !important;" align="center">
                    <b id="especialidad"><?php echo mb_strtoupper($get_id[0]['Especialidad'])?></b> 
                </div>   
            <?php } ?>
        </div><br>
        <img style="width:75%;margin-left:-30px;margin-right:53px;margin-top:10px;margin-bottom:0px;" src="<?= base_url() ?>template/img/<?php echo $futer ?>">  
  
	<div style="width:206.2px; height:40px !important;margin-left:-56px;">
        	<img style="width:110%;" src="<?= base_url() ?>template/img/header2.png">    
        </div>

        <img style="padding-top: 25px;margin-left:-40px;margin-right:30px;width:85%;height:50px" src="<?php echo base_url() ?>application/views/view_IFV/fotocheck_alumno/barcode.php?text=<?php echo $get_id[0]['Codigo'] ?>"/>
        
        <p style="width:100%; margin: 5px 0px 0px -25px;font-size:10px;"><b>Código del alumno(a): <?php echo $get_id[0]['Codigo'] ?></b><br><br></p>

        <p style="margin-left:-40px;margin-top:-5px;font-size:8px;width:85%;text-align:justify">El presente documento hace constar al portador como un alumno de nuestra institución. Espersonal e instransferible.<br>
            Para confirmar la vigencia del portador, puede confirmar contactando a nuestra institución.<br>
            Si encuentra este carné de estudiante extraviado, le agradeceremos comunicarse al teléfono <b>997 321 000</b> o llevarlo directamente a informes de su sede.</p>
        <img style="width:206.2px; height:35px;margin-left:-56px;margin-right:53px;margin-top:7px" src="<?= base_url() ?>template/img/footer2.png"> 
</body>


</html>