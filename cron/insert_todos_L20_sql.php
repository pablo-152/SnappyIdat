<?php
    include 'conexion_vps.php';

    sqlsrv_query($conexion_vps, "TRUNCATE TABLE todos_l20"); 

    sqlsrv_query($conexion_vps, "INSERT INTO todos_l20 (Tipo,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
    Codigo,Grupo,Especialidad,Turno,Modulo,Seccion,Matricula,Alumno,Fecha_Cumpleanos,Celular,Pago_Pendiente,
    Documento_Pendiente,Observacion,Motivo_Arpay,Observaciones_Arpay,Fecha_Fin_Arpay,Fotocheck,Estado_Matricula,
    Estado_Cuota_1) 
    SELECT 1,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
    Codigo,Grupo,Especialidad,Turno,Modulo,Seccion,Matricula,Alumno,Fecha_Cumpleanos,Celular,Pago_Pendiente,
    Documento_Pendiente,Observacion,Motivo_Arpay,Observaciones_Arpay,Fecha_Fin_Arpay,Fotocheck,Estado_Matricula,
    Estado_Cuota_1
    FROM todos_l20_temporal"); 

    $query_p = sqlsrv_query($conexion_vps,"SELECT em.id_colaborador,em.dni, em.correo_personal,
                em.apellido_paterno, em.apellido_materno, em.nombres, em.codigo_gll,
                em.fec_nacimiento, em.celular, ep.nom_perfil AS Cargo, 
                em.correo_corporativo AS Email_Corporativo
                FROM colaborador em
                LEFT JOIN perfil ep ON ep.id_perfil =em.id_perfil
                WHERE em.id_empresa IN (6) AND em.estado=2 AND 
                (em.fin_funciones IS NULL or em.fin_funciones='0000-00-00')
                ORDER BY em.apellido_paterno ASC,em.apellido_materno ASC,em.nombres ASC");

    while( $fila_p = sqlsrv_fetch_array( $query_p, SQLSRV_FETCH_ASSOC) ) {
        $codigoa = $fila_p['codigo_gll']."''C";
        
        sqlsrv_query($conexion_vps, "INSERT INTO todos_l20 (Tipo,Id,Dni,Email,Apellido_Paterno,Apellido_Materno,Nombre,
        Codigo,Fecha_Cumpleanos,Celular,Cargo,Email_Corporativo)
        VALUES (2,'".$fila_p['id_colaborador']."','".$fila_p['dni']."','".$fila_p['correo_personal']."',
        '".$fila_p['apellido_paterno']."',
        '".$fila_p['apellido_materno']."','".$fila_p['nombres']."','".$codigoa."',
        '".$fila_p['fec_nacimiento']."',
        '".$fila_p['celular']."','".$fila_p['Cargo']."','".$fila_p['Email_Corporativo']."')");
    }
?>