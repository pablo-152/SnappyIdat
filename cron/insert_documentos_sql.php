<?php
    include 'conexion.php'; 
    include 'conexion_vps.php'; 

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));  
    }

    sqlsrv_query($conexion_vps, "TRUNCATE TABLE documento_alumno_empresa"); 
    sqlsrv_query($conexion_vps, "TRUNCATE TABLE detalle_alumno_empresa"); 

    $query_a = mysqli_query($conexion, "SELECT * FROM documento_alumno_empresa");
    $query_b = mysqli_query($conexion, "SELECT id_alumno,id_documento,archivo
                FROM detalle_alumno_empresa
                WHERE id_alumno IN (SELECT Id FROM matriculados_l20 
                WHERE Tipo=1) AND id_documento IN (SELECT id_documento FROM documento_alumno_empresa
                WHERE id_empresa=6 AND estado=2 AND obligatorio>0) AND id_empresa=6 AND estado=2");

    while($fila = mysqli_fetch_assoc($query_a)) {
        sqlsrv_query($conexion_vps, "INSERT INTO documento_alumno_empresa (id_empresa,id_sede,cod_documento,nom_grado,
        obligatorio,digital,aplicar_todos,nom_documento,descripcion_documento,departamento,
        aparece_doc,estado,fec_reg,user_reg,fec_act,user_act,fec_eli,user_eli) 
        VALUES ('".$fila['id_empresa']."','".$fila['id_sede']."','".$fila['cod_documento']."',
        '".$fila['nom_grado']."','".$fila['obligatorio']."','".$fila['digital ']."',
        '".$fila['aplicar_todos']."','".$fila['nom_documento']."',
        '".$fila['descripcion_documento']."','".$fila['departamento']."',
        '".$fila['aparece_doc']."','".$fila['estado']."','".$fila['fec_reg']."',
        '".$fila['user_reg']."','".$fila['fec_act']."','".$fila['user_act']."',
        '".$fila['fec_eli']."','".$fila['user_eli']."')"); 
    }

    while($fila = mysqli_fetch_assoc($query_b)) {
        sqlsrv_query($conexion_vps, "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,archivo) 
        VALUES ('".$fila['id_alumno']."','".$fila['id_documento']."','".$fila['archivo']."')");
        /*sqlsrv_query($conexion_vps, "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,id_sede,
        anio,cod_documento,nom_grado,obligatorio,digital,nom_documento,
        descripcion_documento,aplicar_todos,archivo,user_subido,fec_subido,estado,fec_reg,
        user_reg,fec_act,user_act,fec_eli,user_eli) 
        VALUES ('".$fila['id_alumno']."','".$fila['id_documento']."','".$fila['id_empresa']."',
        '".$fila['id_sede']."','".$fila['anio']."','".$fila['cod_documento ']."',
        '".$fila['nom_grado']."','".$fila['obligatorio']."',
        '".$fila['digital']."','".$fila['nom_documento']."',
        '".$fila['descripcion_documento']."','".$fila['aplicar_todos']."','".$fila['archivo']."',
        '".$fila['user_subido']."','".$fila['fec_subido']."','".$fila['estado']."',
        '".$fila['fec_reg']."','".$fila['user_reg']."','".$fila['fec_act']."','".$fila['user_act']."',
        '".$fila['fec_eli']."','".$fila['user_eli']."')");*/
    }
?>