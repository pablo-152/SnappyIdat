<?php
    include 'conexion_arpay.php';

    
    $query_ep2 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 23");
    $query_fv1 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 10");
    $query_fv2 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 15");
    $query_fv5 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 27");
    $query_la1 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 9");
    $query_la2 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 16");
    $query_la4 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 20");
    $query_ld1 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 22");
    include 'conexion.php'; 
    
    while( $fila_p = sqlsrv_fetch_array( $query_ep2, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (5,8,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_fv1, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (6,9,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_fv2, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (6,18,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_fv5, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (6,19,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_la1, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (7,12,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_la2, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (7,20,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_la4, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (7,21,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_ld1, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (9,11,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>