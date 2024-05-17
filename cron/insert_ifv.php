<?php
    include 'conexion.php';
    include 'conexion_vps.php';
    $query_t = sqlsrv_query($conexion_vps, "TRUNCATE TABLE detalle_matricula_alumno");

    $query_c = mysqli_query($conexion,"select * from detalle_matricula_alumno"); 

    while( $fila = mysqli_fetch_array($query_c)) {
        $query_a = sqlsrv_query($conexion_vps, "INSERT INTO detalle_matricula_alumno (id_matricula, id_unidad,
                    estado, fec_reg, user_reg, fec_act, user_act, fec_eli, user_eli) 
                    VALUES ('".$fila['id_matricula']."', '".$fila['id_unidad']."', '".$fila['estado']."',
                    '".$fila['fec_reg']."', '".$fila['user_reg']."', '".$fila['fec_act']."',
                    '".$fila['user_act']."', '".$fila['fec_eli']."', '".$fila['user_eli']."')");
    }

    $query_t1 = sqlsrv_query($conexion_vps, "TRUNCATE TABLE documento_alumno");

    $query_c1 = mysqli_query($conexion,"select * from documento_alumno"); 

    while( $fila = mysqli_fetch_array($query_c1)) {
        $query_a1 = sqlsrv_query($conexion_vps, "INSERT INTO documento_alumno (id_grado, id_requisito,
                    id_alumno, archivo, fec_subido, user_subido,
                    estado, fec_reg, user_reg, fec_act, user_act, fec_eli, user_eli) 
                    VALUES ('".$fila['id_grado']."', '".$fila['id_requisito']."', '".$fila['id_alumno']."',
                    '".$fila['archivo']."', '".$fila['fec_subido']."', '".$fila['user_subido']."',
                    '".$fila['estado']."', '".$fila['fec_reg']."', '".$fila['user_reg']."', '".$fila['fec_act']."',
                    '".$fila['user_act']."', '".$fila['fec_eli']."', '".$fila['user_eli']."')");
    }
    
    $query_t2 = sqlsrv_query($conexion_vps, "TRUNCATE TABLE documento_alumno_empresa");

    $query_c2 = mysqli_query($conexion,"select * from documento_alumno_empresa"); 

    while( $fila = mysqli_fetch_array($query_c2)) {
        $query_a2 = sqlsrv_query($conexion_vps, "INSERT INTO documento_alumno_empresa (id_empresa, id_sede,
                    cod_documento, nom_grado, obligatorio, digital, aplicar_todos, nom_documento,
                    descripcion_documento, departamento, aparece_doc,
                    estado, fec_reg, user_reg, fec_act, user_act, fec_eli, user_eli) 
                    VALUES ('".$fila['id_empresa']."', '".$fila['id_sede']."', '".$fila['cod_documento']."',
                    '".$fila['nom_grado']."', '".$fila['obligatorio']."', '".$fila['digital']."',
                    '".$fila['aplicar_todos']."', '".$fila['nom_documento']."', '".$fila['descripcion_documento']."',
                    '".$fila['departamento']."', '".$fila['aparece_doc']."',
                    '".$fila['estado']."', '".$fila['fec_reg']."', '".$fila['user_reg']."', '".$fila['fec_act']."',
                    '".$fila['user_act']."', '".$fila['fec_eli']."', '".$fila['user_eli']."')");
    }

    $query_t3 = sqlsrv_query($conexion_vps, "TRUNCATE TABLE especialidad");

    $query_c3 = mysqli_query($conexion,"select * from especialidad"); 

    while( $fila = mysqli_fetch_array($query_c3)) {
        $query_a3 = sqlsrv_query($conexion_vps, "INSERT INTO especialidad (licenciamiento, cod_especialidad,
                    id_tipo_especialidad , nom_especialidad, abreviatura, nmodulo, desc_especialidad, color,
                    estado, fec_reg, user_reg, fec_act, user_act, fec_eli, user_eli) 
                    VALUES ('".$fila['licenciamiento']."', '".$fila['cod_especialidad']."', 
                    '".$fila['id_tipo_especialidad ']."',
                    '".$fila['nom_especialidad']."', '".$fila['abreviatura']."', '".$fila['nmodulo']."',
                    '".$fila['desc_especialidad']."', '".$fila['color']."', 
                    '".$fila['estado']."', '".$fila['fec_reg']."', '".$fila['user_reg']."', '".$fila['fec_act']."',
                    '".$fila['user_act']."', '".$fila['fec_eli']."', '".$fila['user_eli']."')");
    }

    $query_t4 = sqlsrv_query($conexion_vps, "TRUNCATE TABLE foto_docentes");

    $query_c4 = mysqli_query($conexion,"select * from foto_docentes"); 

    while( $fila = mysqli_fetch_array($query_c4)) {
        $query_a4 = sqlsrv_query($conexion_vps, "INSERT INTO foto_docentes (id_empresa, id_sede,
                    id_docente , foto,
                    estado, fec_reg, user_reg, fec_act, user_act, fec_eli, user_eli) 
                    VALUES ('".$fila['id_empresa']."', '".$fila['id_sede']."', 
                    '".$fila['id_docente ']."',
                    '".$fila['foto']."',
                    '".$fila['estado']."', '".$fila['fec_reg']."', '".$fila['user_reg']."', '".$fila['fec_act']."',
                    '".$fila['user_act']."', '".$fila['fec_eli']."', '".$fila['user_eli']."')");
    }

    $query_t5 = sqlsrv_query($conexion_vps, "TRUNCATE TABLE nivel");

    $query_c5 = mysqli_query($conexion,"select * from nivel"); 

    while( $fila = mysqli_fetch_array($query_c5)) {
        $query_a5 = sqlsrv_query($conexion_vps, "INSERT INTO nivel (nom_nivel, orden,
                    estado, fec_reg, user_reg, fec_act, user_act, fec_eli, user_eli)
                    VALUES ('".$fila['nom_nivel']."', '".$fila['orden']."', 
                    '".$fila['estado']."', '".$fila['fec_reg']."', '".$fila['user_reg']."', '".$fila['fec_act']."',
                    '".$fila['user_act']."', '".$fila['fec_eli']."', '".$fila['user_eli']."')");
    }
?>