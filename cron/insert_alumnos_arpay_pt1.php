<?php
    include 'conexion_arpay.php';

    $query_bl1 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 4");
    $query_ll1 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 7");
    $query_ll2 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 12");
    $query_ll5 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 25");
    $query_ls1 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 5");
    $query_ls2 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 14");
    $query_ls5 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 26");
    $query_ep1 = sqlsrv_query($conexion_arpay,"exec GetReportDatabase 11");
    
    include 'conexion.php'; 
    $query_t = mysqli_query($conexion, "TRUNCATE TABLE alumnos_arpay_temporal");
    while( $fila_p = sqlsrv_fetch_array( $query_bl1, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (3,6,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_ll1, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (2,2,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_ll2, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (2,14,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_ll5, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (2,15,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_ls1, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (4,5,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_ls2, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (4,16,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_ls5, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (4,17,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }
    while( $fila_p = sqlsrv_fetch_array( $query_ep1, SQLSRV_FETCH_ASSOC) ) {
        $query_ap = mysqli_query($conexion, "INSERT INTO alumnos_arpay_temporal (empresa,sede,FatherSurname,MotherSurname,FirstName,InternalStudentId,SchoolYear,Grade,
                    Class,StudentStatus,ClientStatus,IdentityCardNumber,NumberOfBrothers,Address,StudentAdmissionId,Department,Province,District,HomePhoneNumber,
                    MobilePhone,OtherContact,Email,Occupation,Workplace,ReasonNotWorking,Working,ContactDate,Remuneration,Foto,estado) 
                    VALUES (5,7,'".$fila_p['FatherSurname']."','".$fila_p['MotherSurname']."','".$fila_p['FirstName']."','".$fila_p['InternalStudentId']."','".$fila_p['SchoolYear']."',
                    '".$fila_p['Grade']."','".$fila_p['Class']."','".$fila_p['StudentStatus']."','".$fila_p['ClientStatus']."','".$fila_p['IdentityCardNumber']."',
                    '".$fila_p['NumberOfBrothers']."','".$fila_p['Address']."','".$fila_p['StudentAdmissionId']."','".$fila_p['Department']."','".$fila_p['Province']."','".$fila_p['District']."',
                    '".$fila_p['HomePhoneNumber']."','".$fila_p['MobilePhone']."','".$fila_p['OtherContact']."','".$fila_p['Email']."','".$fila_p['Occupation']."','".$fila_p['Workplace']."',
                    '".$fila_p['ReasonNotWorking']."','".$fila_p['Working']."','".$fila_p['ContactDate']."','".$fila_p['Remuneration']."','".$fila_p['Foto']."',2)");
    }

    if(!$conexion){
        die("Imposible Conectarse: ".mysqli_error($conexion));
    }
?>