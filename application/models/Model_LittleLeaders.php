<?php
class Model_LittleLeaders extends CI_Model { 
    public function __construct() {
        parent::__construct(); 
        $this->db2 = $this->load->database('db2', true);
        $this->db5 = $this->load->database('db5', true);
        $this->load->database();
        date_default_timezone_set("America/Lima");  
    }

    public function raw($raw_query, $as_array = false) {    
        $query = $this->db->query($raw_query);
        if (is_bool($query)) {
            return true;
        } else {
            if ($as_array) {
                return $query->result_array(); 
            }
            return $query->result();
        }
    }

    function fondo_index(){
        $sql = "SELECT * FROM fintranet WHERE estado=1 AND id_empresa=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_nav_sede(){
        $sql = "SELECT * FROM sede WHERE id_empresa=2 AND estado=2 AND aparece_menu=1 ORDER BY orden_menu ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_anio(){
        $sql = "SELECT * FROM anio WHERE estado=1 ORDER BY nom_anio DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_mes(){
        $sql = "SELECT * FROM mes WHERE estado=1 ORDER BY cod_mes ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_departamento(){
        $sql = "SELECT * FROM departamento 
                ORDER BY nombre_departamento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_provincia($id_departamento){ 
        $sql = "SELECT * FROM provincia 
                WHERE id_departamento=$id_departamento 
                ORDER BY nombre_provincia ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_distrito($id_provincia){
        $sql = "SELECT * FROM distrito 
                WHERE id_provincia=$id_provincia 
                ORDER BY nombre_distrito ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_status(){
        $sql = "SELECT * FROM status 
                WHERE estado=1 ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //-----------------------------------------------INFORME------------------------------------------
    function get_list_informe(){
        $sql = "SELECT t1.CourseName,t1.CourseId AS 'CourseId',MAX(t1.CourseStatus) AS 'CourseStatus',t1.CourseGradeId,  
                MAX(t1.CourseGradeLevelId) AS CourseGradeLevelId,MAX(t1.Description) AS CourseGradeLevelDescription,   
                SUM(t1.TotalPending) AS 'TotalPending',SUM(t1.TotalPendingMatriculated) AS 'TotalPendingMatriculated',   
                SUM(t1.TotalPendingOthers) AS 'TotalPendingOthers',SUM(t1.TotalAmountPending) AS 'TotalAmountPending',  
                SUM(t1.TotalPaid) AS 'TotalPaid',SUM(t1.TotalPaidMatriculated) AS 'TotalPaidMatriculated',  
                SUM(t1.TotalPaidOthers) AS 'TotalPaidOthers',SUM(t1.TotalAmountPaid) AS 'TotalAmountPaid',  
                SUM(t1.TotalPending + t1.TotalPaid) AS 'TotalStudents',SUM(t1.TotalRefund) AS 'TotalRefund',  
                SUM(t1.TotalAmountPending + t1.TotalAmountPaid - t1.TotalRefund) AS 'TotalAmount'  
                FROM (--TOTAL PENDING   
                SELECT c.Name AS CourseName,c.Id AS 'CourseId',MAX(st.Description) AS 'CourseStatus',  
                cgt.CourseGradeId,cgt.[Description],MAX(cgl.Id) AS 'CourseGradeLevelId',MAX(cgl.Description) AS 'LevelDescription',  
                COUNT(cppr.Id) as 'TotalPending',SUM(CASE WHEN mat.StatusId IN (0, 1, 4, 5) THEN 1 ELSE 0 END) AS 'TotalPendingMatriculated',  
                SUM(CASE WHEN mat.StatusId NOT IN (0, 1, 4, 5) THEN 1 ELSE 0 END) AS 'TotalPendingOthers',  
                SUM(cppr.Cost - ISNULL(cppr.TotalDiscount, 0) + ISNULL((dbo.business_days_between(cppr.PaymentDueDate, GETDATE()) - dbo.holidays_between(cppr.PaymentDueDate, GETDATE())), 0)) AS 'TotalAmountPending',  
                0 as 'TotalPaid',0 AS 'TotalPaidMatriculated',0 AS 'TotalPaidOthers',0 AS 'TotalAmountPaid',0 AS 'TotalRefund'  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                JOIN ProductItem prodItem ON prodItem.Id = cppr.ProductItemId  
                JOIN Course c ON c.Id = prodItem.CourseId  
                LEFT JOIN StatusTranslation st ON st.StatusId = c.StatusId AND st.Language = 'es-PE'  
                JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.[Language] = 'es-PE'  
                LEFT JOIN CourseGradeLevel cgl ON c.CourseGradeLevelId = cgl.Id   
                JOIN Client cli ON cli.Id = cppr.ClientId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cppr.ClientId AND mat.ProductId = cppr.ProductId AND mat.ProductItemId = cppr.ProductItemId  
                WHERE cppr.PaymentStatusId = 2 AND prod.EnterpriseHeadquarterId = 7 AND cppr.ProductItemId = prodItem.Id AND  
                prodItem.CourseId IS NOT NULL AND prodItem.ProductItemTypeId IN (1, 26) AND (cppr.Description like '%cuota%' OR cppr.Description like '%pension%') AND  
                mat.StatusId IN (SELECT Id FROM MatriculationStatus)  
                GROUP BY c.Id, c.Name, cgt.CourseGradeId, cgt.[Description]  
                UNION ALL  
                --TOTAL PAID   
                SELECT c.Name AS CourseName,c.Id AS CourseId,MAX(st.Description) AS 'CourseStatus',cgt.CourseGradeId,   
                cgt.[Description],MAX(cgl.Id) AS 'CourseGradeLevelId',MAX(cgl.Description) AS 'LevelDescription',  
                0 as 'TotalPending',0 AS 'TotalPendingMatriculated',0 AS 'TotalPendingOthers',0 AS 'TotalAmountPending',  
                COUNT(cppr.Id) as 'TotalPaid',  
                SUM(CASE WHEN mat.StatusId IN (0, 1, 4, 5)/*cli.StudentStatusId IN (2,5)*/ THEN 1 ELSE 0 END) AS 'TotalPaidMatriculated',  
                SUM(CASE WHEN mat.StatusId NOT IN (0, 1, 4, 5) THEN 1 ELSE 0 END) AS 'TotalPaidOthers',  
                SUM(cppr.Cost - ISNULL(cppr.TotalDiscount, 0) + ISNULL(cppr.PenaltyAmountPaid, 0)) AS 'TotalAmountPaid',0 AS 'TotalRefund'  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                JOIN ProductItem prodItem ON prodItem.Id = cppr.ProductItemId  
                JOIN Course c ON c.Id = prodItem.CourseId  
                LEFT JOIN StatusTranslation st ON st.StatusId = c.StatusId AND st.Language = 'es-PE'  
                JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.[Language] = 'es-PE'  
                LEFT JOIN CourseGradeLevel cgl ON c.CourseGradeLevelId = cgl.Id  
                JOIN Client cli ON cli.Id = cppr.ClientId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cppr.ClientId AND mat.ProductId = cppr.ProductId AND mat.ProductItemId = cppr.ProductItemId  
                WHERE cppr.PaymentStatusId = 1 AND prod.EnterpriseHeadquarterId = 7 AND cppr.ProductItemId = prodItem.Id AND  
                prodItem.CourseId IS NOT NULL AND prodItem.ProductItemTypeId IN (1, 26) AND (cppr.Description like '%cuota%' OR cppr.Description like '%pension%') AND  
                mat.StatusId IN (SELECT Id FROM MatriculationStatus)   
                GROUP BY c.Id, c.Name, cgt.CourseGradeId, cgt.[Description]  
                UNION ALL   
                -- TOTAL REFUND  
                SELECT c.Name AS CourseName,c.Id AS CourseId,MAX(st.Description) AS 'CourseStatus',cgt.CourseGradeId,   
                cgt.[Description],MAX(cgl.Id) AS 'CourseGradeLevelId',MAX(cgl.Description) AS 'LevelDescription',  
                0 as 'TotalPending',0 AS 'TotalPendingMatriculated',0 AS 'TotalPendingOthers',0 AS 'TotalAmountPending',  
                0 as 'TotalPaid',0 AS 'TotalPaidMatriculated',0 AS 'TotalPaidOthers',0 AS 'TotalAmountPaid',  
                SUM(cppr.Cost) AS 'TotalRefund'  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                JOIN ProductItem prodItem ON prodItem.Id = cppr.ProductItemId  
                JOIN Course c ON c.Id = prodItem.CourseId  
                LEFT JOIN StatusTranslation st ON st.StatusId = c.StatusId AND st.Language = 'es-PE'  
                JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.[Language] = 'es-PE'  
                LEFT JOIN CourseGradeLevel cgl ON c.CourseGradeLevelId = cgl.Id  
                JOIN Client cli ON cli.Id = cppr.ClientId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cppr.ClientId AND mat.ProductId = cppr.ProductId AND mat.ProductItemId = cppr.ProductItemId  
                WHERE cppr.PaymentStatusId = 4 AND prod.EnterpriseHeadquarterId = 7 AND cppr.ProductItemId = prodItem.Id AND prodItem.CourseId IS NOT NULL AND  
                prodItem.ProductItemTypeId IN (1, 26) AND (cppr.Description like '%cuota%' OR cppr.Description like '%pension%') AND  
                mat.StatusId IN (SELECT Id FROM MatriculationStatus)  
                GROUP BY c.Id, c.Name, cgt.CourseGradeId, cgt.[Description]) as t1  
                GROUP BY t1.CourseId, t1.CourseName, t1.CourseGradeId, t1.[Description]
                ORDER BY MAX(t1.CourseStatus) ASC,t1.CourseName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }

    function get_list_detalle_informe($CourseId){
        $sql = "SELECT MAX(t1.CourseName) AS 'CourseName',MAX(t1.CourseId) AS 'CourseId',
                (SELECT MAX(dCppr.Description) FROM ClientProductPurchaseRegistry dCppr  
                JOIN ProductItem dPi ON dPi.Id = dCppr.ProductItemId  
                WHERE dPi.CourseId=$CourseId AND dCppr.PaymentDueDate=t1.PaymentDueDate AND dCppr.PaymentStatusId IN (1,2,5)) AS 'ItemDescription',  
                MAX(t1.CourseStatus) AS 'CourseStatus',t1.PaymentDueDate AS 'PaymentDueDate',MAX(t1.CourseGradeLevelId) AS CourseGradeLevelId,  
                SUM(t1.TotalPending) AS 'TotalPending',SUM(t1.TotalPendingMatriculated) AS 'TotalPendingMatriculated',   
                SUM(t1.TotalPendingOthers) AS 'TotalPendingOthers',SUM(t1.TotalAmountPending) AS 'TotalAmountPending',  
                SUM(t1.TotalPaid) AS 'TotalPaid',SUM(t1.TotalPaidMatriculated) AS 'TotalPaidMatriculated',
                SUM(t1.TotalPaidOthers) AS 'TotalPaidOthers',SUM(t1.TotalAmountPaid) AS 'TotalAmountPaid',  
                SUM(t1.TotalPending + t1.TotalPaid) AS 'TotalStudents',SUM(t1.TotalRefund) AS 'TotalRefund',  
                SUM(t1.TotalAmountPending + t1.TotalAmountPaid - t1.TotalRefund) AS 'TotalAmount'  
                FROM (--TOTAL PENDING   
                SELECT MAX(c.Name) AS 'CourseName',MAX(c.Id) AS 'CourseId',cppr.PaymentDueDate AS 'PaymentDueDate',  
                MAX(c.StatusId) AS 'CourseStatus',MAX(cgt.CourseGradeId) AS 'CourseGradeId',MAX(cgt.[Description]) AS 'CourseGradeDescription',  
                MAX(cgl.Id) AS 'CourseGradeLevelId',MAX(cgl.Description) AS 'LevelDescription',COUNT(cppr.Id) as 'TotalPending',   
                SUM(CASE WHEN mat.StatusId IN (0, 1, 4, 5) THEN 1 ELSE 0 END) AS 'TotalPendingMatriculated',  
                SUM(CASE WHEN mat.StatusId NOT IN (0, 1, 4, 5) THEN 1 ELSE 0 END) AS 'TotalPendingOthers',  
                SUM(cppr.Cost - ISNULL(cppr.TotalDiscount, 0) + ISNULL((dbo.business_days_between(cppr.PaymentDueDate, GETDATE()) - dbo.holidays_between(cppr.PaymentDueDate, GETDATE())), 0)) AS 'TotalAmountPending',  
                0 as 'TotalPaid',0 AS 'TotalPaidMatriculated',0 AS 'TotalPaidOthers',0 AS 'TotalAmountPaid',0 AS 'TotalRefund'  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                JOIN ProductItem prodItem ON prodItem.Id = cppr.ProductItemId  
                JOIN Course c ON c.Id = prodItem.CourseId  
                LEFT JOIN StatusTranslation st ON st.StatusId = c.StatusId AND st.Language = 'es-PE'  
                JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.[Language] = 'es-PE'  
                LEFT JOIN CourseGradeLevel cgl ON c.CourseGradeLevelId = cgl.Id   
                JOIN Client cli ON cli.Id = cppr.ClientId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cppr.ClientId AND mat.ProductId = cppr.ProductId AND mat.ProductItemId = cppr.ProductItemId  
                WHERE cppr.PaymentStatusId=2 AND cli.EnterpriseHeadquarterId=7 AND prodItem.CourseId = $CourseId AND  
                (cppr.Description LIKE '%cuota%' OR cppr.Description LIKE '%pension%') AND mat.StatusId IN (SELECT Id FROM MatriculationStatus)   
                GROUP BY cppr.PaymentDueDate  
                UNION ALL  
                --TOTAL PAID   
                SELECT MAX(c.Name) AS 'CourseName',MAX(c.Id) AS 'CourseId',cppr.PaymentDueDate AS 'PaymentDueDate',
                MAX(c.StatusId) AS 'CourseStatus',MAX(cgt.CourseGradeId) AS 'CourseGradeId',MAX(cgt.[Description]) AS 'CourseGradeDescription',
                MAX(cgl.Id) AS 'CourseGradeLevelId',MAX(cgl.Description) AS 'LevelDescription',  
                0 as 'TotalPending',0 AS 'TotalPendingMatriculated',0 AS 'TotalPendingOthers',0 AS 'TotalAmountPending',  
                COUNT(cppr.Id) as 'TotalPaid',SUM(CASE WHEN mat.StatusId IN (0, 1, 4, 5) THEN 1 ELSE 0 END) AS 'TotalPaidMatriculated',  
                SUM(CASE WHEN mat.StatusId NOT IN (0, 1, 4, 5) THEN 1 ELSE 0 END) AS 'TotalPaidOthers',  
                SUM(cppr.Cost - ISNULL(cppr.TotalDiscount, 0) + ISNULL(cppr.PenaltyAmountPaid, 0)) AS 'TotalAmountPaid',  
                0 AS 'TotalRefund'  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                JOIN ProductItem prodItem ON prodItem.Id = cppr.ProductItemId  
                JOIN Course c ON c.Id = prodItem.CourseId  
                LEFT JOIN StatusTranslation st ON st.StatusId = c.StatusId AND st.Language = 'es-PE'  
                JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.[Language] = 'es-PE'  
                LEFT JOIN CourseGradeLevel cgl ON c.CourseGradeLevelId = cgl.Id  
                JOIN Client cli ON cli.Id = cppr.ClientId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cppr.ClientId AND mat.ProductId = cppr.ProductId AND mat.ProductItemId = cppr.ProductItemId  
                WHERE cppr.PaymentStatusId=1 AND prod.EnterpriseHeadquarterId=7 AND prodItem.CourseId=$CourseId AND  
                (cppr.Description LIKE '%cuota%' OR cppr.Description LIKE '%pension%') AND mat.StatusId IN (SELECT Id FROM MatriculationStatus)  
                GROUP BY cppr.PaymentDueDate  
                UNION ALL   
                -- TOTAL REFUND  
                --TOTAL PENDING   
                SELECT MAX(c.Name) AS 'CourseName',MAX(c.Id) AS 'CourseId',cppr.PaymentDueDate AS 'PaymentDueDate',  
                MAX(c.StatusId) AS 'CourseStatus',MAX(cgt.CourseGradeId) AS 'CourseGradeId',MAX(cgt.[Description]) AS 'CourseGradeDescription',  
                MAX(cgl.Id) AS 'CourseGradeLevelId',MAX(cgl.Description) AS 'LevelDescription',0 as 'TotalPending',
                0 AS 'TotalPendingMatriculated',0 AS 'TotalPendingOthers',0 AS 'TotalAmountPending',0 as 'TotalPaid',  
                0 AS 'TotalPaidMatriculated',0 AS 'TotalPaidOthers',0 AS 'TotalAmountPaid',SUM(cppr.Cost) AS 'TotalRefund'  
                FROM ClientProductPurchaseRegistry cppr  
                JOIN Product prod ON prod.Id = cppr.ProductId  
                JOIN ProductItem prodItem ON prodItem.Id = cppr.ProductItemId  
                JOIN Course c ON c.Id = prodItem.CourseId  
                LEFT JOIN StatusTranslation st ON st.StatusId = c.StatusId AND st.Language = 'es-PE'  
                JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.[Language] = 'es-PE'  
                LEFT JOIN CourseGradeLevel cgl ON c.CourseGradeLevelId = cgl.Id  
                JOIN Client cli ON cli.Id = cppr.ClientId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cppr.ClientId AND mat.ProductId = cppr.ProductId AND mat.ProductItemId = cppr.ProductItemId  
                WHERE cppr.PaymentStatusId=4 AND prod.EnterpriseHeadquarterId=7 AND prodItem.CourseId=$CourseId AND  
                (cppr.Description LIKE '%cuota%' OR cppr.Description LIKE '%pension%') AND mat.StatusId IN (SELECT Id FROM MatriculationStatus)  
                GROUP BY cppr.PaymentDueDate) as t1  
                GROUP BY t1.PaymentDueDate  
                ORDER BY t1.PaymentDueDate";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }

    function get_list_alumno_informe($CourseId,$PaymentDueDate){
        $sql = "SELECT *,results.Cost + ISNULL(results.PenaltyAmountToBePaid,0) - ISNULL(TotalDiscount, 0) AS 'SubTotal'  
                FROM (SELECT cppr.Id AS 'Id',pst.Description AS 'PaymentStatus',FORMAT(cppr.PaymentDueDate,'dd-MM-yyyy') AS 'PaymentDueDate',
                FORMAT(cppr.PaymentDate,'dd-MM-yyyy') AS 'PaymentDate',cgt.Description AS 'CourseGrade',st.Description AS 'CourseStatus',
                cppr.Description AS 'Description',cli.InternalStudentId,p.IdentityCardNumber,p.FirstName,p.MotherSurname,p.FatherSurname,  
                cppr.Cost,cppr.TotalDiscount,CASE WHEN cppr.PaymentStatusId IN (1,4) THEN cppr.PenaltyAmountPaid  
                WHEN cppr.PaymentDueDate IS NOT NULL AND cppr.DailyPenaltyForPaymentDelay IS NOT NULL 
                THEN (dbo.business_days_between(cppr.PaymentDueDate, GETDATE()) - dbo.holidays_between(cppr.PaymentDueDate, GETDATE()))* cppr.DailyPenaltyForPaymentDelay  
                ELSE 0 END  AS 'PenaltyAmountToBePaid',matst.Description AS 'MatriculationStatus',
                CASE WHEN cppr.ElectronicReceiptNumber IS NOT NULL THEN cppr.ElectronicReceiptNumber  
                WHEN cppr.ManualReceiptId IS NOT NULL THEN CONCAT(LEFT(mrs.CBT,2), '/', RIGHT(mrs.CBT, 2), ' ', mrs.Letter, ' ', mr.ReceiptNumber)  
                ELSE NULL END AS 'ReceiptNumber',c.Name AS CourseName  
                FROM ClientProductPurchaseRegistry cppr   
                JOIN ProductItem pi ON pi.Id = cppr.ProductItemId  
                LEFT JOIN Course c ON c.Id = pi.CourseId  
                LEFT JOIN StatusTranslation st ON c.StatusId = st.StatusId AND st.Language = 'es-PE'  
                LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.[Language] = 'es-PE'  
                JOIN Client cli ON cli.Id = cppr.ClientId  
                JOIN Person p ON p.Id = cli.PersonId  
                LEFT JOIN PaymentStatusTranslation pst ON pst.PaymentStatusId = cppr.PaymentStatusId AND pst.[Language] = 'es-PE'  
                LEFT JOIN Matriculation mat ON mat.ClientId = cppr.ClientId AND mat.ProductId = cppr.ProductId AND mat.ProductItemId = cppr.ProductItemId  
                LEFT JOIN MatriculationStatusTranslation matst ON matst.MatriculationStatusId = mat.StatusId AND matst.[Language] = 'es-PE'  
                LEFT JOIN ManualReceipt mr ON mr.Id = cppr.ManualReceiptId  
                LEFT JOIN ManualRegistryReceiptSerie mrs ON mrs.Id = cppr.ManualReceiptSerieId  
                WHERE c.Id = $CourseId AND cppr.PaymentStatusId IN (SELECT Id FROM PaymentStatus WHERE Id=2) AND  
                cli.EnterpriseHeadquarterId = 7 AND cppr.PaymentDueDate = '$PaymentDueDate' AND  
                (cppr.Description LIKE '%cuota%' OR cppr.Description LIKE '%pension%') AND  
                mat.StatusId IN (SELECT Id FROM MatriculationStatus)) results";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------PROFESOR------------------------------------------
    function get_list_profesor(){
        $sql = "SELECT pe.FatherSurname,pe.MotherSurname,pe.FirstName,ep.InternalEmployeeId,pe.IdentityCardNumber,
                rh.Description,FORMAT(em.StartDate,'dd-MM-yyyy') AS StartDate,em.EndDate,'Activo' AS Estado
                FROM EmployeeEnterpriseActivity em
                LEFT JOIN Employee ep ON ep.Id=em.EmployeeId
                LEFT JOIN Person pe ON pe.Id=ep.PersonId
                LEFT JOIN RHContractTypeTranslation rh ON rh.RHContractTypeId=em.RHContractTypeId
                WHERE em.EmployeeRoleId=6 AND em.EnterpriseHeadquarterId=7 AND em.EndDate IS NULL
                ORDER BY pe.FatherSurname ASC,pe.MotherSurname ASC,pe.FirstName ASC";
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------DOCUMENTO------------------------------------------
    function get_list_documento($id_documento=null){
        if(isset($id_documento) && $id_documento>0){
            $sql = "SELECT * FROM documento_alumno_empresa 
                    WHERE id_documento=$id_documento";
        }else{
            $sql = "SELECT do.*,CASE WHEN do.obligatorio=0 THEN 'No' 
                    WHEN do.obligatorio=1 THEN 'Si'
                    WHEN do.obligatorio=2 THEN 'Mayores de 4 (>4)' 
                    WHEN do.obligatorio=3 THEN 'Menores de 18 (<18)' 
                    END AS obligatorio,st.nom_status,
                    CASE WHEN do.validacion=1 THEN 'Si' ELSE 'No' END AS validacion
                    FROM documento_alumno_empresa do
                    LEFT JOIN status st ON st.id_status=do.estado
                    WHERE do.id_empresa=2 AND do.estado!=4
                    ORDER BY do.obligatorio DESC,do.nom_documento ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_documento($dato){
        $sql = "SELECT * FROM documento_alumno_empresa 
                WHERE id_empresa=2 AND cod_documento='".$dato['cod_documento']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_todo_documento(){
        $sql = "SELECT id_documento FROM documento_alumno_empresa  
                WHERE id_empresa=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_alumno_empresa (id_empresa,cod_documento,nom_grado,nom_documento,
                descripcion_documento,obligatorio,digital,aplicar_todos,validacion,estado,fec_reg,user_reg) 
                VALUES (2,'".$dato['cod_documento']."','".$dato['nom_grado']."','".$dato['nom_documento']."',
                '".$dato['descripcion_documento']."','".$dato['obligatorio']."','".$dato['digital']."',
                '".$dato['aplicar_todos']."','".$dato['validacion']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_documento_todos($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM detalle_alumno_empresa WHERE id_documento='".$dato['id_documento']."' AND id_alumno='".$dato['id_alumno']."' AND estado=2" ;
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function ultimo_id_documento(){
        $sql = "SELECT id_documento FROM documento_alumno_empresa 
                ORDER BY id_documento DESC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_alumno_documento_todos($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT Id FROM todos_ll
                WHERE Alumno='Matriculado'
                ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC,Codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_documento_todos($dato){
        $sql = "SELECT * FROM detalle_alumno_empresa 
                WHERE id_alumno='".$dato['id_alumno']."' AND
                id_documento='".$dato['id_documento']."' AND id_empresa=2 AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_todos($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,anio,
                estado,fec_reg,user_reg)
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."',2,
                '".$dato['anio']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function valida_update_documento($dato){
        $sql = "SELECT * FROM documento_alumno_empresa 
                WHERE id_empresa=2 AND cod_documento='".$dato['cod_documento']."' AND estado=2 AND id_documento!='".$dato['id_documento']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_alumno_empresa SET cod_documento='".$dato['cod_documento']."',
                nom_grado='".$dato['nom_grado']."',nom_documento='".$dato['nom_documento']."',
                descripcion_documento='".$dato['descripcion_documento']."',
                obligatorio='".$dato['obligatorio']."',digital='".$dato['digital']."',
                aplicar_todos='".$dato['aplicar_todos']."',validacion='".$dato['validacion']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }

    function delete_documento($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_alumno_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_documento='".$dato['id_documento']."'";
        $this->db->query($sql);
    }
    //------------------------------------------------------MATRICULADOS------------------------------------------
    function get_informe_matriculados(){
        $anio = date('Y');
        $sql = "SELECT (SELECT COUNT(*) FROM todos_ll
                WHERE Alumno='Matriculado' AND Anio=$anio AND Pago_Pendiente=0) AS total_al_dia,
                (SELECT COUNT(*) FROM todos_ll
                WHERE Alumno='Matriculado' AND Anio=$anio AND Pago_Pendiente=1) AS total_p1,
                (SELECT COUNT(*) FROM todos_ll
                WHERE Alumno='Matriculado' AND Anio=$anio AND Pago_Pendiente=2) AS total_p2,
                (SELECT COUNT(*) FROM todos_ll
                WHERE Alumno='Matriculado' AND Anio=$anio AND Pago_Pendiente>=3) AS total_p3";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_matriculados($tipo){
        $anio = date('Y');
        $prox_anio = $anio+1;
        if($tipo==1){
            $parte = "WHERE td.Alumno='Matriculado' AND td.Fecha_Pago_Matricula<>'' AND 
                        td.Fecha_Pago_Cuota_Ingreso<>'' AND td.Anio=$anio";
        }elseif($tipo==2){
            $parte = "WHERE td.Alumno='Matriculado' AND td.Anio=$prox_anio";
        }elseif($tipo==4){
            $parte = "WHERE td.Alumno='Matriculado' AND (td.Fecha_Pago_Matricula='' OR 
                    td.Fecha_Pago_Cuota_Ingreso='') AND td.Anio=$anio";
        }elseif($tipo==5){
            $parte = "WHERE td.Alumno='Retirado'";
        }else{
            $parte = "";
        }

        $sql = "SELECT td.Id,td.Apellido_Paterno,td.Apellido_Materno,td.Nombre,td.Codigo,
                td.Grado,td.Seccion,td.Matricula,
                DATE_FORMAT(td.Fecha_Matricula,'%d/%m/%Y') AS Fec_Matricula,td.Usuario,
                DATE_FORMAT(td.Fecha_Pago_Cuota_Ingreso,'%d/%m/%Y') AS Fec_Pago_Cuota_Ingreso,
                td.Monto_Cuota_Ingreso,DATE_FORMAT(td.Fecha_Pago_Matricula,'%d/%m/%Y') AS Fec_Pago_Matricula,
                td.Alumno,td.Anio,
                CASE WHEN td.Pago_Pendiente=0 THEN 'Al Día' WHEN td.Pago_Pendiente=1 THEN 'Pendiente 1' 
                WHEN td.Pago_Pendiente=2 THEN 'Pendiente 2' ELSE 'Pendiente 3+'
                END AS nom_pago_pendiente,CASE WHEN td.Pago_Pendiente=0 THEN '#92D050' WHEN td.Pago_Pendiente=1 THEN '#7F7F7F' 
                WHEN td.Pago_Pendiente=2 THEN '#F8CBAD' ELSE '#C00000' END AS color_pago_pendiente,
                (SELECT ar.id_alumno_retirado FROM alumno_retirado ar 
                WHERE ar.Id=td.Id AND ar.id_empresa=2 AND ar.estado=2) AS id_alumno_retirado,
                td.Dni,td.Fecha_Cumpleanos,DATE_FORMAT(td.Fecha_Cumpleanos,'%d/%m/%Y') AS Cumpleanos,
                td.Monto_Matricula,IFNULL((SELECT DATE_FORMAT(df.fecha_firma,'%d/%m/%Y') FROM documento_firma df
                WHERE df.id_alumno=td.Id AND df.id_empresa=2 AND df.fecha_firma IS NOT NULL AND df.estado=2
                ORDER BY df.id_documento_firma DESC
                LIMIT 1),'') AS v_contrato,documentos_obligatorios_ll(td.Grado) AS documentos_obligatorios,
                documentos_subidos_ll(td.Grado,td.Id) AS documentos_subidos, comentariog
                FROM todos_ll td
                $parte
                ORDER BY td.Apellido_Paterno ASC,td.Apellido_Materno ASC,td.Nombre ASC,td.Codigo ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function truncate_todos_ll_temporal(){
        $sql = "TRUNCATE TABLE todos_ll_temporal";
        $this->db->query($sql);
    }

    function get_list_matriculados_arpay(){ 
        $sql = "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,
                per.FirstName AS Nombre,per.IdentityCardNumber AS Dni,
                CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) 
                END AS Codigo,Grado=ISNULL(cgt.Description, 'N/D'),CASE WHEN mat.Id IS NULL 
                THEN ISNULL((SELECT TOP 1 oldCourse.Name FROM Matriculation oldMat   
                JOIN ProductItem oldPI ON oldPI.Id = oldMat.ProductItemId  
                JOIN Course oldCourse ON oldCourse.Id = oldPI.CourseId  
                WHERE ClientId = cli.Id ORDER BY oldMat.Id DESC), 'N/D') ELSE c.Name END AS 'Course',
                sst.Description AS Alumno,ISNULL(cc.Name, 'N/D') AS 'Class',
                Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D'),
                (SELECT TOP 1 FORMAT(PurchaseDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry 
                WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND 
                ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                ClientProductPurchaseRegistry.Description='Matricula') AS Fecha_Matricula,
                (SELECT TOP 1 ap.Name FROM ClientProductPurchaseRegistry
                INNER JOIN AspNetUsers ap ON ap.Id=ClientProductPurchaseRegistry.PurchaseEmployeeId
                WHERE ClientProductPurchaseRegistry.ClientId=cli.Id AND 
                ClientProductPurchaseRegistry.ProductId=mat.ProductId AND 
                ClientProductPurchaseRegistry.Description='Matricula') AS Usuario,
                FORMAT(per.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,
                CASE WHEN cc.Name IS NULL THEN 'N/D' WHEN mat.StatusId IN (2,3,4,6,7) THEN 'N/D' 
                ELSE cc.Name END AS Seccion,mst.Description AS MatriculationStatusName,
                (SELECT COUNT(*) FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.PaymentStatusId=2 AND 
                cp.PaymentDueDate<=GETDATE()) AS Pago_Pendiente,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Matricula' AND cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC) AS Fecha_Pago_Matricula,
                ISNULL((SELECT TOP 1 (ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0)) 
                FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Matricula' AND cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC),0) AS Monto_Matricula,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Cuota de Ingreso' AND 
                cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC) AS Fecha_Pago_Cuota_Ingreso,
                ISNULL((SELECT TOP 1 (ISNULL(cp.Cost,0)+ISNULL(cp.PenaltyAmountPaid,0)-ISNULL(cp.TotalDiscount,0)) 
                FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Cuota de Ingreso' AND 
                cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC),0) AS Monto_Cuota_Ingreso,per.Email,per.MobilePhone
                FROM Client cli
                JOIN Person per ON per.Id = cli.PersonId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
                WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
                LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                LEFT JOIN Course c ON c.Id = pi.CourseId  
                LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
                LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
                ORDER BY ccs2.Id DESC)  
                LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                WHERE cli.EnterpriseHeadquarterId = 7 AND cli.InternalStudentId IS NOT NULL
                ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId";
        $query = $this->db2->query($sql)->result_Array();
        return $query;
    }

    function insert_todos_ll_temporal($dato){
        $sql = "INSERT INTO todos_ll_temporal (Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Dni,Email,
                Celular,Fecha_Cumpleanos,Grado,Seccion,Curso,Clase,Anio,Fecha_Matricula,Usuario,Matricula,
                Alumno,Pago_Pendiente,Fecha_Pago_Matricula,Monto_Matricula,Fecha_Pago_Cuota_Ingreso,
                Monto_Cuota_Ingreso) 
                VALUES ('".$dato['Id']."','".$dato['Apellido_Paterno']."','".$dato['Apellido_Materno']."',
                '".$dato['Nombre']."','".$dato['Codigo']."','".$dato['Dni']."','".$dato['Email']."',
                '".$dato['MobilePhone']."','".$dato['Fecha_Cumpleanos']."','".$dato['Grado']."',
                '".$dato['Seccion']."','".$dato['Course']."','".$dato['Class']."','".$dato['Anio']."',
                '".$dato['Fecha_Matricula']."','".$dato['Usuario']."','".$dato['MatriculationStatusName']."',
                '".$dato['Alumno']."','".$dato['Pago_Pendiente']."','".$dato['Fecha_Pago_Matricula']."',
                '".$dato['Monto_Matricula']."','".$dato['Fecha_Pago_Cuota_Ingreso']."',
                '".$dato['Monto_Cuota_Ingreso']."')";
        $this->db->query($sql);
    }

    function get_list_todos_ll(){ 
        $sql = "SELECT COUNT(1) AS cantidad FROM todos_ll";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_todos_ll_temporal(){ 
        $sql = "SELECT COUNT(1) AS cantidad FROM todos_ll_temporal";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_datos_todos_ll_temporal(){ 
        $sql = "SELECT Id,Fecha_Cumpleanos FROM todos_ll_temporal 
                WHERE Id NOT IN (SELECT Id FROM todos_ll)";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_datos_documento_alumno_empresa(){ 
        $sql = "SELECT id_documento,obligatorio FROM documento_alumno_empresa 
                WHERE id_empresa=2 AND estado=2";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function insert_datos_documento_alumno_empresa($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,id_empresa,estado,fec_reg,user_reg) 
                VALUES (".$dato['Id'].",".$dato['id_documento'].",2,2,NOW(),0)";
        $this->db->query($sql);
    }

    function truncate_todos_ll(){
        $sql = "TRUNCATE TABLE todos_ll";
        $this->db->query($sql);
    }

    function insert_todos_ll(){
        $sql = "INSERT INTO todos_ll (Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Dni,Email,Celular,
                Fecha_Cumpleanos,Grado,Seccion,Curso,Clase,Anio,Fecha_Matricula,Usuario,Matricula,Alumno,
                Pago_Pendiente,Fecha_Pago_Matricula,Monto_Matricula,Fecha_Pago_Cuota_Ingreso,
                Monto_Cuota_Ingreso) 
                SELECT Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,Dni,Email,Celular,Fecha_Cumpleanos,
                Grado,Seccion,Curso,Clase,Anio,Fecha_Matricula,Usuario,Matricula,Alumno,Pago_Pendiente,
                Fecha_Pago_Matricula,Monto_Matricula,Fecha_Pago_Cuota_Ingreso,Monto_Cuota_Ingreso
                FROM todos_ll_temporal";
        $this->db->query($sql);
    }

    function get_list_tutores_alumno($id_alumno){ 
        $sql = "SELECT celular,email FROM tutores_empresa
                WHERE id_alumno=$id_alumno AND id_empresa=2 AND estado=2";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function get_id_matriculados($id_alumno){
        $sql = "SELECT td.*,CONCAT(td.Apellido_Paterno,' ',td.Apellido_Materno,', ',td.Nombre) AS Nombre_Completo,
                DATE_FORMAT(td.Fecha_Cumpleanos,'%d-%m-%Y') AS Cumpleanos,CASE WHEN se.sexo=1 THEN 'Femenino' 
                WHEN se.sexo=2 THEN 'Masculino' ELSE '' END AS nom_sexo
                FROM todos_ll td
                LEFT JOIN sexo_empresa se ON se.id_alumno=td.Id AND se.id_empresa=2
                WHERE td.Id=$id_alumno";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function valida_sexo($id_alumno){ 
        $sql = "SELECT * FROM sexo_empresa 
                WHERE id_empresa=2 AND id_alumno=$id_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_sexo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO sexo_empresa (id_empresa,id_alumno,sexo)
                VALUES (2,'".$dato['id_alumno']."','".$dato['sexo']."')";
        $this->db->query($sql);
    }

    function update_sexo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE sexo_empresa SET sexo='".$dato['sexo']."'
                WHERE id_sexo='".$dato['id_sexo']."'";
        $this->db->query($sql);
    }

    function get_list_parentesco(){
        $sql = "SELECT * FROM parentesco 
                ORDER BY nom_parentesco ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_tutor($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO tutores_empresa (id_alumno,id_empresa,id_parentesco,apellido_paterno,
                apellido_materno,nombre,celular,email,no_mailing,estado,fec_reg,user_reg)
                VALUES ('".$dato['id_alumno']."',2,'".$dato['id_parentesco']."',
                '".$dato['apellido_paterno']."','".$dato['apellido_materno']."','".$dato['nombre']."',
                '".$dato['celular']."','".$dato['email']."','".$dato['no_mailing']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_list_tutor($id_tutor=null,$id_alumno=null){
        if(isset($id_tutor) && $id_tutor>0){
            $sql = "SELECT * FROM tutores_empresa
                    WHERE id_tutor=$id_tutor";
        }else{
            $sql = "SELECT te.id_tutor,pa.nom_parentesco,CONCAT(te.nombre,' ',te.apellido_paterno,' ',
                    te.apellido_materno) AS nom_tutor,te.celular,te.email,te.no_mailing
                    FROM tutores_empresa te
                    LEFT JOIN parentesco pa ON te.id_parentesco=pa.id_parentesco
                    WHERE te.id_alumno=$id_alumno AND te.id_empresa=2 AND te.estado=2
                    ORDER BY te.id_tutor ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_tutor($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tutores_empresa SET id_parentesco='".$dato['id_parentesco']."',
                apellido_paterno='".$dato['apellido_paterno']."',
                apellido_materno='".$dato['apellido_materno']."',nombre='".$dato['nombre']."',
                celular='".$dato['celular']."',email='".$dato['email']."',
                no_mailing='".$dato['no_mailing']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_tutor='".$dato['id_tutor']."'";
        $this->db->query($sql);     
    }

    function delete_tutor($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE tutores_empresa SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_tutor='".$dato['id_tutor']."'";
        $this->db->query($sql);     
    }

    function get_list_pago_matriculados($id_alumno){
        $sql = "SELECT prod.Name AS 'Producto',pst.Description AS 'Estado',cppr.Description AS 'Descripcion',cppr.PaymentDueDate AS 'Fecha_VP',
                cppr.Cost AS 'Monto',cppr.TotalDiscount AS 'Descuento',cppr.PenaltyAmountPaid AS 'Penalidad',(ISNULL(cppr.Cost,0)-
                ISNULL(cppr.TotalDiscount,0)+ISNULL(cppr.PenaltyAmountPaid,0)) AS 'SubTotal'
                FROM ClientProductPurchaseRegistry cppr,Client cli,Person p,EnterpriseHeadquarter eh,Headquarter he,Product prod,ProductItem prodItem,  
                PaymentStatusTranslation pst   
                WHERE cli.Id=$id_alumno AND cppr.PaymentStatusId IN (1,2,3) AND cppr.ClientId = cli.Id AND cli.PersonId = p.Id AND cli.EnterpriseHeadquarterId = eh.Id AND 
                eh.HeadquarterId = he.Id AND cppr.ProductId = prod.Id AND cppr.ProductItemId = prodItem.Id AND cppr.PaymentStatusId = pst.PaymentStatusId AND 
                pst.[Language] = 'es-PE'  
                ORDER BY prod.Name, cli.InternalStudentId";
        $query = $this->db2->query($sql)->result_Array(); 
        return $query; 
    }

    function get_list_documento_matriculados($id_alumno){  
        $sql = "SELECT dd.id_detalle,CASE WHEN da.obligatorio=0 THEN 'No' 
                WHEN da.obligatorio=1 THEN 'Si' WHEN da.obligatorio=2 
                THEN 'Mayores de 4 (>4)' WHEN da.obligatorio=3 
                THEN 'Menores de 18 (<18)' ELSE '' END AS v_obligatorio,
                dd.anio,da.cod_documento,
                CONCAT(da.nom_documento,' - ',da.descripcion_documento) AS 
                nom_documento,dd.archivo,
                CASE WHEN da.cod_documento='D54' THEN 
                (CASE WHEN (SELECT COUNT(*) FROM documento_firma df 
                WHERE df.id_alumno=dd.id_alumno AND df.id_empresa=2 AND 
                df.estado_d=3 AND df.estado=2)>0 THEN 'Firmado' ELSE 'Pendiente' END)
                ELSE SUBSTRING_INDEX(dd.archivo,'/',-1) END AS nom_archivo,
                us.usuario_codigo AS usuario_subido,
                DATE_FORMAT(dd.fec_subido,'%d-%m-%Y') AS fec_subido
                FROM detalle_alumno_empresa dd
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=dd.id_documento
                LEFT JOIN users us ON us.id_usuario=dd.user_subido
                WHERE dd.id_alumno=$id_alumno AND dd.id_empresa=2 AND dd.estado=2
                ORDER BY dd.anio DESC,da.obligatorio DESC,da.cod_documento ASC,
                da.nom_documento ASC,da.descripcion_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_documento_matriculados($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_alumno_empresa (id_alumno,id_documento,archivo,user_subido,fec_subido,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['id_documento']."','".$dato['archivo']."',$id_usuario,NOW(),2,
                NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_detalle_alumno_empresa($id_detalle){
        $sql = "SELECT * FROM detalle_alumno_empresa WHERE id_detalle=$id_detalle";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_documento_matriculados($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_alumno_empresa SET archivo='".$dato['archivo']."',user_subido=$id_usuario,
                fec_subido=NOW(),fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql);
    }

    function get_documento_alumno($dato){
        $sql="SELECT * FROM detalle_alumno_empresa WHERE id_detalle='".$dato['id_detalle']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function delete_documento_alumno($dato){
        $sql = "UPDATE detalle_alumno_empresa SET archivo='',fec_subido=NULL,user_subido=0
                WHERE id_detalle='".$dato['id_detalle']."'";
        $this->db->query($sql); 
    }

    function get_list_foto_matriculados($id_alumno){ 
        /*$sql = "SELECT fm.*,DATE_FORMAT(fm.fec_reg,'%d/%m/%Y') AS fecha,us.usuario_codigo
                FROM foto_matriculados fm
                LEFT JOIN users us ON us.id_usuario=fm.user_reg
                WHERE fm.id_empresa=2 AND fm.id_alumno=$id_alumno AND fm.estado=2 ORDER BY fm.id_foto DESC";*/
        $sql = "SELECT de.* FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=2 AND da.cod_documento='D00' AND de.id_alumno=$id_alumno AND de.estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_contrato_matriculados($id_alumno){  
        $sql = "SELECT df.id_documento_firma,SUBSTRING_INDEX(cc.mes_anio,'/',-1) AS anio,
                cc.referencia,cc.descripcion,ap.Parentesco,
                DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') AS fec_firma,
                CASE WHEN df.vencido=1 THEN 'Si' ELSE 'No' END AS vencido,
                CASE WHEN df.estado_d=1 THEN 'Anulado' 
                WHEN df.estado_d=2 THEN 'Enviado' WHEN df.estado_d=3 THEN 'Firmado' 
                WHEN df.estado_d=4 THEN 'Validado' END AS nom_status,
                CASE WHEN df.estado_d=1 THEN '#C00000' WHEN df.estado_d=2 THEN '#0070c0' 
                WHEN df.estado_d=3 THEN '#00C000' WHEN df.estado_d=4 THEN '#7F7F7F' END AS 
                color_status,df.fecha_firma,df.fecha_envio
                FROM documento_firma df
                LEFT JOIN c_contrato cc ON cc.id_c_contrato=df.id_contrato
                LEFT JOIN apoderados_ll ap ON ap.Id=df.id_apoderado
                WHERE df.id_alumno=$id_alumno AND df.id_empresa=2 AND cc.tipo=1 AND df.estado=2
                ORDER BY df.fecha_firma DESC,df.fecha_envio DESC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_contrato_matriculados($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET vencido='".$dato['vencido']."'
                WHERE id_documento_firma='".$dato['id_documento_firma']."'";
        $this->db->query($sql);
    }

    function get_list_mensaje_matriculados($id_alumno){ 
        $sql = "SELECT df.id_documento_firma,cc.referencia,cc.descripcion,ap.Parentesco,
                DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') AS fec_firma,CASE WHEN df.estado_d=1 THEN 'Anulado' 
                WHEN df.estado_d=2 THEN 'Enviado' WHEN df.estado_d=3 THEN 'Firmado' WHEN df.estado_d=4 THEN 'Validado' 
                END AS nom_status,CASE WHEN df.estado_d=1 THEN '#C00000' WHEN df.estado_d=2 THEN '#0070c0' 
                WHEN df.estado_d=3 THEN '#00C000' WHEN df.estado_d=4 THEN '#7F7F7F' END AS color_status
                FROM documento_firma df
                LEFT JOIN c_contrato cc ON cc.id_c_contrato=df.id_contrato
                LEFT JOIN apoderados_ll ap ON ap.Id=df.id_apoderado
                WHERE df.id_alumno=$id_alumno AND cc.tipo=2 AND df.estado=2"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_sms_matriculados($celular){    
        $sql = "SELECT md.fec_reg AS orden,DATE_FORMAT(md.fec_reg,'%d-%m-%Y') AS fecha,
                us.usuario_codigo AS usuario,me.mensaje
                FROM mensaje_detalle md
                LEFT JOIN users us ON us.id_usuario=md.user_reg
                LEFT JOIN mensaje me ON me.id_mensaje=md.id_mensaje 
                WHERE md.numero=$celular
                ORDER BY md.fec_reg DESC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    
    function get_list_observacion_alumno($id_alumno=null,$id_observacion=null){
        if(isset($id_observacion) && $id_observacion>0){
            $sql = "SELECT * FROM alumno_observaciones_general 
                    WHERE id_observacion=$id_observacion"; 
        }else{
            $sql = "SELECT ao.id_observacion,DATE_FORMAT(ao.fecha_obs,'%d-%m-%Y') AS fecha,ti.nom_tipo,
                    us.usuario_codigo AS usuario,ao.observacion,ao.fecha_obs AS orden, observacion_archivo
                    FROM alumno_observaciones_general ao
                    LEFT JOIN tipo_observacion ti ON ti.id_tipo=ao.id_tipo
                    LEFT JOIN users us ON us.id_usuario=ao.usuario_obs
                    WHERE ao.id_alumno=$id_alumno AND ao.id_empresa=2 AND ao.estado=2
                    ORDER BY ao.fecha_obs DESC"; 
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_tipo_obs($tipo_usuario=null){
        if(isset($tipo_usuario) && $tipo_usuario>0){
            $sql = "SELECT * FROM tipo_observacion
                    WHERE estado=2 and tipo_usuario=$tipo_usuario
                    ORDER BY nom_tipo";
        }else{
            $sql = "SELECT * FROM tipo_observacion
                    WHERE estado=2 
                    ORDER BY nom_tipo";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_observacion(){
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users
                WHERE tipo=1 AND id_nivel NOT IN (6,9) AND estado=2
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_observacion_alumno($dato){
        $sql = "SELECT id_observacion FROM alumno_observaciones_general 
                WHERE id_empresa=2 AND id_alumno='".$dato['id_alumno']."' AND 
                id_tipo='".$dato['id_tipo']."' AND observacion='".$dato['observacion']."' AND 
                fecha_obs='".$dato['fecha']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_observaciones_general (id_empresa,id_alumno,id_tipo,observacion,
                fecha_obs,usuario_obs,estado,fec_reg,user_reg, observacion_archivo) 
                VALUES (2,'".$dato['id_alumno']."','".$dato['id_tipo']."','".$dato['observacion']."',
                '".$dato['fecha']."','".$dato['usuario']."',2,NOW(),$id_usuario,
                '".$dato['observacion_archivo']."')";
        $this->db->query($sql);
    }

    function valida_update_observacion_alumno($dato){
        $sql = "SELECT id_observacion FROM alumno_observaciones_general 
                WHERE id_empresa=2 AND id_alumno='".$dato['id_alumno']."' AND 
                id_tipo='".$dato['id_tipo']."' AND observacion='".$dato['observacion']."' AND 
                fecha_obs='".$dato['fecha']."' AND estado=2 AND 
                id_observacion!='".$dato['id_observacion']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_observaciones_general SET id_tipo='".$dato['id_tipo']."',
                fecha_obs='".$dato['fecha']."',usuario_obs='".$dato['usuario']."',
                observacion='".$dato['observacion']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }

    function delete_observacion_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_observaciones_general SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }

    function get_list_motivo($id_motivo=null){ 
        if(isset($id_motivo) && $id_motivo>0){
            $sql = "SELECT * FROM motivo_retiro 
                    WHERE id_motivo=$id_motivo";
        }else{
            $sql = "SELECT * FROM motivo_retiro 
                    WHERE estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_alumno_retirado($id_alumno){ 
        $sql = "SELECT a.*,u.usuario_codigo,DATE_FORMAT(a.fec_reg,'%d/%m/%Y %H:%i %p') as fecha_actualizacion
                FROM alumno_retirado a 
                LEFT JOIN users u on a.user_reg=u.id_usuario
                WHERE a.id_empresa=2 AND a.Id='$id_alumno'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumno_retirado($id_alumno_retirado=null){  
        if(isset($id_alumno_retirado) && $id_alumno_retirado>0){
            $sql = "SELECT id_alumno_retirado,obs_retiro,Codigo
                    FROM alumno_retirado a 
                    WHERE id_alumno_retirado=$id_alumno_retirado";
        }else{
            $sql = "SELECT * FROM alumno_retirado 
                    WHERE id_empresa=2 AND estado=2";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_obs_motivo_retiro($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_retirado SET obs_retiro='".$dato['obs_retiro']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_alumno_retirado='".$dato['id_alumno_retirado']."'";
        $this->db->query($sql);
    }

    function insert_retiro_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO alumno_retirado (id_empresa,Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,
                fecha_nasiste,id_motivo,otro_motivo,fut,fecha_fut,tkt_boleta,pago_pendiente,monto,contacto,
                fecha_contacto,hora_contacto,resumen,p_reincorporacion,obs_retiro,estado,fec_reg,user_reg)
                SELECT 2,Id,Apellido_Paterno,Apellido_Materno,Nombre,Codigo,'".$dato['fecha_nasiste']."',
                '".$dato['id_motivo']."','".$dato['otro_motivo']."','".$dato['fut']."','".$dato['fecha_fut']."',
                '".$dato['tkt_boleta']."','".$dato['pago_pendiente']."','".$dato['monto']."','".$dato['contacto']."',
                '".$dato['fecha_contacto']."','".$dato['hora_contacto']."','".$dato['resumen']."',
                '".$dato['p_reincorporacion']."','".$dato['obs_retiro']."',2,NOW(),$id_usuario 
                FROM todos_ll 
                WHERE Id='".$dato['id_alumno']."' ";
        $this->db->query($sql);
    }

    function update_retiro_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE alumno_retirado SET fecha_nasiste='".$dato['fecha_nasiste']."',
                id_motivo='".$dato['id_motivo']."',otro_motivo='".$dato['otro_motivo']."',fut='".$dato['fut']."',
                fecha_fut='".$dato['fecha_fut']."',tkt_boleta='".$dato['tkt_boleta']."',
                pago_pendiente='".$dato['pago_pendiente']."',monto='".$dato['monto']."',contacto='".$dato['contacto']."',
                fecha_contacto='".$dato['fecha_contacto']."',hora_contacto='".$dato['hora_contacto']."',
                resumen='".$dato['resumen']."',p_reincorporacion='".$dato['p_reincorporacion']."',
                obs_retiro='".$dato['obs_retiro']."',aprobado=0,fec_act=NOW(),user_act=$id_usuario
                WHERE Id='".$dato['id_alumno']."' AND estado=2";
        $this->db->query($sql);
    }
    //---------------------------------------------DOC ALUMNOS-------------------------------------------
    function get_list_todos_alumno(){
        $sql = "SELECT td.Apellido_Paterno,td.Apellido_Materno,td.Nombre,td.Dni,td.Fecha_Cumpleanos,
                DATE_FORMAT(td.Fecha_Cumpleanos,'%d/%m/%Y') AS Cumpleanos,td.Codigo,td.Grado,td.Seccion,
                td.Matricula,DATE_FORMAT(td.Fecha_Matricula,'%d/%m/%Y') AS Fec_Matricula,td.Usuario,
                td.Alumno,td.Anio,td.Id,documentos_obligatorios_ll(td.Grado) AS documentos_obligatorios,
                documentos_subidos_ll(td.Grado,td.Id) AS documentos_subidos,
                CASE WHEN (foto_ll(td.Id))>0 THEN 'Si' ELSE 'No' END AS foto,
                (SELECT de.archivo FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                WHERE da.id_empresa=2 AND da.cod_documento='D00' AND de.id_alumno=td.Id AND de.archivo!='' AND 
                de.estado=2) AS link_foto
                FROM todos_ll td
                WHERE td.Alumno='Matriculado'
                ORDER BY td.Apellido_Paterno ASC,td.Apellido_Materno ASC,td.Nombre ASC,td.Codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_doc_alumnos(){
        $sql = "SELECT id_documento,cod_documento FROM documento_alumno_empresa
                WHERE id_empresa=2 AND estado!=4
                ORDER BY cod_documento ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_detalle_doc_alumnos($id_alumno,$cod_documento){
        $sql = "SELECT us.usuario_codigo,de.fec_subido 
                FROM detalle_alumno_empresa de
                LEFT JOIN documento_alumno_empresa da ON da.id_documento=de.id_documento
                LEFT JOIN users us ON us.id_usuario=de.user_subido
                WHERE da.cod_documento='$cod_documento' AND da.id_empresa=2 AND da.estado=2 AND 
                de.id_alumno=$id_alumno AND de.estado=2
                ORDER BY de.id_detalle DESC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //---------------------------------------------ALUMNO OBS-------------------------------------------
    function get_list_alumno_obs(){ 
        $sql = "SELECT tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombre,tl.Codigo,e.nom_empresa,
                DATE_FORMAT(ao.fec_reg, '%Y-%m-%d') AS fecha_registro,ao.usuario_obs,ao.observacion,
                u.usuario_codigo,ao.id_empresa,tl.Grado,tl.Seccion
                FROM alumno_observaciones_general ao
                LEFT JOIN todos_ll tl ON tl.Id=ao.id_alumno
                LEFT JOIN empresa e ON e.id_empresa=ao.id_empresa
                LEFT JOIN users u ON u.id_usuario=ao.user_reg
                WHERE ao.id_empresa = 2 AND ao.estado = 2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //-----------------------------------------------SOPORTE DOCS------------------------------------------
    function get_list_soporte_doc($id_soporte_doc=null){
        if(isset($id_soporte_doc) && $id_soporte_doc>0){
            $sql = "SELECT * FROM soporte_doc WHERE id_soporte_doc=$id_soporte_doc";
        }else{
            $sql = "SELECT so.id_soporte_doc,em.cod_empresa,so.descripcion,SUBSTRING_INDEX(so.documento,'/',-1) AS nom_documento,
                    CASE WHEN so.documento!='' THEN CONCAT('".base_url()."',SUBSTRING_INDEX(so.documento,'/',-1)) ELSE '' END AS link,
                    CASE WHEN so.documento!='' THEN CONCAT('".base_url()."',so.documento) ELSE '' END AS href,us.usuario_codigo,
                    DATE_FORMAT(so.fec_act,'%d-%m-%Y') AS fecha,CASE WHEN so.documento='' THEN 'No' ELSE 'Si' END AS v_documento,
                    CASE WHEN so.visible=1 THEN 'Si' ELSE 'No' END AS visible,st.nom_status,so.documento
                    FROM soporte_doc so
                    LEFT JOIN empresa em ON em.id_empresa=so.id_empresa 
                    LEFT JOIN users us ON us.id_usuario=so.user_act
                    LEFT JOIN status st ON st.id_status=so.estado
                    WHERE so.id_empresa=2 AND so.estado!=4
                    ORDER BY em.cod_empresa ASC,so.descripcion ASC"; 
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }
    //-----------------------------------------------C CONTRATO------------------------------------------
    function get_list_c_contrato($id_c_contrato=null){ 
        if(isset($id_c_contrato) && $id_c_contrato>0){
            $sql = "SELECT *,SUBSTRING_INDEX(documento,'/',-1) AS nom_documento 
                    FROM c_contrato 
                    WHERE id_c_contrato=$id_c_contrato";
        }else{
            $sql = "SELECT c.id_c_contrato,CASE WHEN c.tipo=1 THEN 'Contrato (Matricula)' WHEN c.tipo=2 
                    THEN 'Contrato (Pago Cuota)' WHEN c.tipo=3 THEN 'Contrato (Pago Matricula)' 
                    WHEN c.tipo=4 THEN 'Contrato (Puntual)' WHEN c.tipo=5 THEN 'Mensaje' ELSE '' END AS tipo,
                    c.referencia,CASE WHEN SUBSTRING(c.mes_anio,1,2)='01' 
                    THEN CONCAT('Ene/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='02' 
                    THEN CONCAT('Feb/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='03' 
                    THEN CONCAT('Mar/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='04' 
                    THEN CONCAT('Abr/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='05' 
                    THEN CONCAT('May/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='06' 
                    THEN CONCAT('Jun/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='07' 
                    THEN CONCAT('Jul/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='08' 
                    THEN CONCAT('Ago/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='09' 
                    THEN CONCAT('Set/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='10' 
                    THEN CONCAT('Oct/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='11' 
                    THEN CONCAT('Nov/',SUBSTRING(c.mes_anio,-4,4)) WHEN SUBSTRING(c.mes_anio,1,2)='12' THEN 
                    CONCAT('Dic/',SUBSTRING(c.mes_anio,-4,4)) ELSE '' END AS mes_anio,c.descripcion,c.asunto,
                    c.texto_correo,c.documento,st.nom_status,st.color,(SELECT COUNT(*) FROM documento_firma df
                    WHERE df.id_contrato=c.id_c_contrato AND df.estado_d=2 AND df.estado=2) AS enviados,
                    (SELECT COUNT(*) FROM documento_firma df
                    WHERE df.id_contrato=c.id_c_contrato AND df.estado_d=3 AND df.estado=2) AS firmados,
                    0 AS por_firmar
                    FROM c_contrato c
                    LEFT JOIN status st ON st.id_status=c.estado
                    WHERE c.id_empresa=2 AND c.estado IN (2,3)
                    ORDER BY c.referencia ASC";
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function ultimo_id_c_contrato(){
        $sql = "SELECT id_c_contrato FROM c_contrato";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_c_contrato($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO c_contrato (id_empresa,tipo,referencia,mes_anio,fecha_envio,descripcion,asunto,id_grado,
                id_seccion,texto_correo,sms,texto_sms,documento,estado,fec_reg,user_reg) 
                VALUES (2,'".$dato['tipo']."','".$dato['referencia']."','".$dato['mes_anio']."','".$dato['fecha_envio']."',
                '".$dato['descripcion']."','".$dato['asunto']."','".$dato['id_grado']."','".$dato['id_seccion']."',
                '".$dato['texto_correo']."','".$dato['sms']."','".$dato['texto_sms']."','".$dato['documento']."',3,NOW(),
                $id_usuario)";
        $this->db->query($sql);
    }

    function update_c_contrato($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE c_contrato SET tipo='".$dato['tipo']."',referencia='".$dato['referencia']."',mes_anio='".$dato['mes_anio']."',
                fecha_envio='".$dato['fecha_envio']."',descripcion='".$dato['descripcion']."',asunto='".$dato['asunto']."',
                id_grado='".$dato['id_grado']."',id_seccion='".$dato['id_seccion']."',texto_correo='".$dato['texto_correo']."',
                sms='".$dato['sms']."',texto_sms='".$dato['texto_sms']."',documento='".$dato['documento']."',estado='".$dato['estado']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_c_contrato='".$dato['id_c_contrato']."'";
        $this->db->query($sql);
    }

    function delete_c_contrato($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE c_contrato SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_c_contrato='".$dato['id_c_contrato']."'";
        $this->db->query($sql);
    }

    function get_list_grado_contrato(){  
        $sql = "SELECT Grado FROM nuevos_ll 
                WHERE Grado!=''
                GROUP BY Grado 
                ORDER BY Grado ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_seccion_contrato($grado){ 
        $sql = "SELECT Seccion FROM nuevos_ll 
                WHERE Grado='$grado' AND Seccion!=''
                GROUP BY Seccion 
                ORDER BY Seccion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    //-----------------------------------------------CONTRATO------------------------------------------
    function get_list_contrato($tipo){
        $parte = ""; 
        $order = "df.fecha_firma";
        if($tipo==1){
            $parte = "AND df.estado_d=2";
            $order = "df.fecha_envio";
        }
        $sql = "SELECT df.id_documento_firma,df.id_alumno,df.id_apoderado,df.cod_alumno,df.apater_alumno,
                df.amater_alumno,df.nom_alumno,
                CONCAT(df.apater_apoderado,' ',df.amater_apoderado,', ',df.nom_apoderado) AS nom_apoderado,
                df.parentesco_apoderado,df.fecha_envio,df.fecha_firma,
                DATE_FORMAT(df.fecha_envio,'%d-%m-%Y') AS fec_envio,
                DATE_FORMAT(df.fecha_envio,'%H:%i') AS hora_envio,
                DATE_FORMAT(df.fecha_firma,'%d-%m-%Y') AS fec_firma,
                DATE_FORMAT(df.fecha_firma,'%H:%i') AS hora_firma,
                CASE WHEN df.estado_d=1 THEN 'Anulado' WHEN df.estado_d=2 THEN 'Enviado' 
                WHEN df.estado_d=3 THEN 'Firmado'
                WHEN df.estado_d=4 THEN 'Validado' END AS nom_status,
                CASE WHEN df.estado_d=1 THEN '#C00000' WHEN df.estado_d=2 THEN '#0070c0' 
                WHEN df.estado_d=3 THEN '#00C000'
                WHEN df.estado_d=4 THEN '#7F7F7F' END AS color_status,co.referencia,df.email_apoderado,
                df.celular_apoderado,df.estado_d
                FROM documento_firma df
                LEFT JOIN c_contrato co ON co.id_c_contrato=df.id_contrato
                WHERE df.id_empresa=2 AND df.estado=2 $parte
                ORDER BY $order DESC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function truncate_tables_contrato(){
        $sql = "TRUNCATE TABLE nuevos_ll";
        $this->db->query($sql);
        $sql2 = "TRUNCATE TABLE apoderados_ll";
        $this->db->query($sql2);
    }

    function get_list_nuevos_ll_arpay(){ 
        $anio = date('Y');
        $anio_siguiente = date('Y')+1;

        $sql = "SELECT cli.Id,per.FatherSurname AS Apellido_Paterno,per.MotherSurname AS Apellido_Materno,per.FirstName AS Nombre,
                CASE WHEN cli.InternalStudentId IS NULL THEN NULL ELSE CONCAT('', cli.InternalStudentId) END AS Codigo,
                per.IdentityCardNumber AS Dni,FORMAT(per.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,Grado=ISNULL(cgt.Description, ''),
                CASE WHEN cc.Name IS NULL THEN '' WHEN mat.StatusId IN (2,3,4,6,7) THEN '' ELSE cc.Name END AS Seccion,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Matricula' AND cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC) AS Fecha_Pago_Matricula,
                (SELECT TOP 1 FORMAT(cp.PaymentDate,'yyyy-MM-dd') FROM ClientProductPurchaseRegistry cp
                WHERE cp.ClientId=cli.Id AND cp.Description='Cuota de Ingreso' AND cp.PaymentStatusId NOT IN (3)
                ORDER BY cp.Id DESC) AS Fecha_Pago_Cuota_Ingreso,Anio=ISNULL(CONVERT(varchar(4),YEAR(mat.StartDate)), 'N/D')
                FROM Client cli
                JOIN Person per ON per.Id = cli.PersonId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND mat.Id = (SELECT TOP 1 Id FROM Matriculation  
                WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND mst.Language = 'es-PE'  
                LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                LEFT JOIN Course c ON c.Id = pi.CourseId  
                LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND cgt.Language = 'es-PE'  
                LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
                ORDER BY ccs2.Id DESC)  
                LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                WHERE cli.EnterpriseHeadquarterId = 7 AND cli.InternalStudentId IS NOT NULL AND YEAR(mat.StartDate) IN ($anio,$anio_siguiente) AND 
                sst.Description='Matriculado'
                ORDER BY per.FatherSurname,per.MotherSurname,per.FirstName,cli.InternalStudentId";  
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }

    function insert_nuevos_ll($dato){ 
        $sql = "INSERT INTO nuevos_ll (Id,Codigo,Apellido_Paterno,Apellido_Materno,Nombre,Dni,
                Fecha_Cumpleanos,Grado,Seccion,Fecha_Matricula,Fecha_Cuota,Anio) 
                VALUES ('".$dato['Id']."','".$dato['Codigo']."','".$dato['Apellido_Paterno']."',
                '".$dato['Apellido_Materno']."','".$dato['Nombre']."','".$dato['Dni']."',
                '".$dato['Fecha_Cumpleanos']."','".$dato['Grado']."','".$dato['Seccion']."',
                '".$dato['Fecha_Matricula']."','".$dato['Fecha_Cuota']."','".$dato['Anio']."')";
        $this->db->query($sql);
    }

    function get_Ids_nuevos_ll(){
        $sql = "SELECT GROUP_CONCAT(DISTINCT Id SEPARATOR ',') AS ids FROM nuevos_ll";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_apoderados_ll_arpay($ids){
        $sql = "SELECT gu.Id,gu.StudentClientId AS Id_Alumno,pe.FatherSurname AS Apellido_Paterno,pe.MotherSurname AS Apellido_Materno,
                pe.FirstName AS Nombre,pe.IdentityCardNumber AS Dni,pe.Email,pe.MobilePhone AS Celular,FORMAT(pe.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos,
                gt.Description AS Parentesco
                FROM Guardian gu
                LEFT JOIN Person pe ON pe.Id=PersonId
                LEFT JOIN GuardianTypeTranslation gt ON gt.GuardianTypeId=gu.Kinship AND gt.Language='es-PE'
                WHERE gu.StudentClientId IN ($ids)";
        $query = $this->db2->query($sql)->result_Array(); 
        return $query; 
    }

    function insert_apoderados_ll($dato){
        $sql = "INSERT INTO apoderados_ll (Id,Id_Alumno,Apellido_Paterno,Apellido_Materno,Nombre,Dni,Email,Celular,Fecha_Cumpleanos,Parentesco) 
                VALUES ('".$dato['Id']."','".$dato['Id_Alumno']."','".$dato['Apellido_Paterno']."','".$dato['Apellido_Materno']."','".$dato['Nombre']."',
                '".$dato['Dni']."','".$dato['Email']."','".$dato['Celular']."','".$dato['Fecha_Cumpleanos']."','".$dato['Parentesco']."')";
        $this->db->query($sql);
    }

    function get_contratos_activos(){
        $sql = "SELECT id_c_contrato,asunto,texto_correo,sms,texto_sms
                FROM c_contrato 
                WHERE id_empresa=2 AND (tipo IN (1,2,3,4) OR (tipo=5 AND fecha_envio=CURDATE())) AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_datos_alumno_contrato($id_c_contrato){
        $sql = "CALL datos_alumno_contrato ($id_c_contrato,2)";
        $query = $this->db->query($sql)->result_Array();
        mysqli_next_result($this->db->conn_id);
        return $query; 
    } 

    function valida_envio_correo_contrato($Id_Alumno,$Id,$id_contrato){
        $sql = "SELECT id_documento_firma FROM documento_firma 
                WHERE id_alumno=$Id_Alumno AND id_apoderado=$Id AND id_empresa=2 AND enviado=1 AND 
                id_contrato=$id_contrato AND estado=2";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function insert_documento_firma($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO documento_firma (id_alumno,cod_alumno,apater_alumno,amater_alumno,nom_alumno,
                cumpleanos_alumno,dni_alumno,grado_alumno,seccion_alumno,id_apoderado,apater_apoderado,
                amater_apoderado,nom_apoderado,parentesco_apoderado,email_apoderado,celular_apoderado,
                cumpleanos_apoderado,dni_apoderado,id_empresa,enviado,fecha_envio,id_contrato,estado_d,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_alumno']."','".$dato['cod_alumno']."','".$dato['apater_alumno']."',
                '".$dato['amater_alumno']."','".$dato['nom_alumno']."','".$dato['cumpleanos_alumno']."',
                '".$dato['dni_alumno']."','".$dato['grado_alumno']."','".$dato['seccion_alumno']."',
                '".$dato['id_apoderado']."','".$dato['apater_apoderado']."','".$dato['amater_apoderado']."',
                '".$dato['nom_apoderado']."','".$dato['parentesco_apoderado']."',
                '".$dato['email_apoderado']."','".$dato['celular_apoderado']."',
                '".$dato['cumpleanos_apoderado']."','".$dato['dni_apoderado']."',2,1,NOW(),
                '".$dato['id_contrato']."',2,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_documento_firma(){
        $sql = "SELECT id_documento_firma FROM documento_firma
                ORDER BY id_documento_firma DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_id_contrato($id_documento_firma){
        $sql = "SELECT df.id_alumno,df.cod_alumno,df.apater_alumno,df.amater_alumno,df.nom_alumno,df.grado_alumno,df.seccion_alumno,
                df.id_apoderado,tu.Apellido_Paterno AS apater_apoderado,tu.Apellido_Materno AS amater_apoderado,
                tu.Nombre AS nom_apoderado,tu.Parentesco AS parentesco_apoderado,tu.Celular AS celular_apoderado,
                df.id_contrato,CONCAT(df.apater_alumno,' ',df.amater_alumno,', ',df.nom_alumno) AS alumno,
                df.email_apoderado,df.id_documento_firma,df.vencido
                FROM documento_firma df
                LEFT JOIN tutores_ls tu ON tu.Id_Tutor=df.id_apoderado
                WHERE df.id_documento_firma=$id_documento_firma";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_email_contrato($dato){  
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET email_apoderado='".$dato['email_apoderado']."'
                WHERE id_documento_firma='".$dato['id_documento_firma']."'";
        $this->db->query($sql);
    }

    function get_datos_alumno_arpay($id_alumno){ 
        $sql = "SELECT Grado=ISNULL(cgt.Description, ''),CASE WHEN cc.Name IS NULL THEN '' 
                WHEN mat.StatusId IN (2,3,4,6,7) THEN '' ELSE cc.Name END AS Seccion
                FROM Client cli
                JOIN Person per ON per.Id = cli.PersonId  
                LEFT JOIN Matriculation mat ON mat.ClientId = cli.Id AND 
                mat.Id = (SELECT TOP 1 Id FROM Matriculation  
                WHERE ClientId = cli.Id AND EndDate IS NULL ORDER BY Id DESC)  
                LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = mat.StatusId AND 
                mst.Language = 'es-PE'  
                LEFT JOIN ProductItem pi ON pi.Id = mat.ProductItemId   
                LEFT JOIN Course c ON c.Id = pi.CourseId  
                LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = c.CourseGradeId AND 
                cgt.Language = 'es-PE'  
                LEFT JOIN CourseClassStudent ccs ON ccs.Id = (SELECT TOP 1 ccs2.Id FROM CourseClassStudent ccs2   
                WHERE ccs2.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = c.Id) AND ccs2.StudentClientId = mat.ClientId   
                ORDER BY ccs2.Id DESC)  
                LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = cli.StudentStatusId  
                LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId  
                WHERE cli.Id = $id_alumno"; 
        $query = $this->db2->query($sql)->result_Array();
        return $query; 
    }

    function get_datos_apoderados_arpay($id_apoderado){ 
        $sql = "SELECT pe.IdentityCardNumber AS Dni,FORMAT(pe.BirthDate,'yyyy-MM-dd') AS Fecha_Cumpleanos
                FROM Guardian gu
                LEFT JOIN Person pe ON pe.Id=PersonId
                LEFT JOIN GuardianTypeTranslation gt ON gt.GuardianTypeId=gu.Kinship AND gt.Language='es-PE'
                WHERE gu.Id=$id_apoderado";
        $query = $this->db2->query($sql)->result_Array();  
        return $query; 
    }

    function update_documento_firma($dato){
        $sql = "UPDATE documento_firma SET grado_alumno='".$dato['grado_alumno']."',
                seccion_alumno='".$dato['seccion_alumno']."',
                cumpleanos_apoderado='".$dato['cumpleanos_apoderado']."',
                dni_apoderado='".$dato['dni_apoderado']."',fecha_envio=NOW()
                WHERE id_documento_firma='".$dato['id_documento_firma']."'";
        $this->db->query($sql);
    }

    function delete_documento_firma($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE documento_firma SET estado_d=1
                WHERE id_documento_firma='".$dato['id_documento_firma']."'";
        $this->db->query($sql);
    }
    //------------------------------------------------------MATRICULA PENDIENTE------------------------------------------
    function get_list_matricula_pendiente($tipo){
        $anio = date('Y');
        $ant_anio = $anio-1;
        if($tipo==1){
            $parte = "AND c.StudentStatusId=4";
        }elseif($tipo==2){
            $parte = "AND c.InternalStudentId LIKE '".substr($anio,-2)."%'";
        }else{
            $parte = "";
        }

        $sql = "SELECT c.Id, c.InternalStudentId as Codigo, c.StatusId, p.BirthDate, 
                p.FatherSurname as Apellido_Paterno, p.MotherSurname as Apellido_Materno, p.FirstName as Nombre,
                cgt.[Description] AS Grado, course.[Name] AS Curso, mst.Description AS Matricula, 
                sst.[Description] AS Alumno, cc.[Name] AS Seccion, YEAR(m.StartDate) AS Anio, 
                COUNT(sd.id) AS TotalDocuments, course.CourseGradeId
                FROM Client c
                JOIN Person p ON p.Id = c.PersonId
                LEFT JOIN Matriculation m ON m.Id = (SELECT
                CASE WHEN EXISTS (SELECT TOP 1 Id FROM Matriculation 
                WHERE ClientId = c.Id AND StatusId IN (1, 4, 5) 
                ORDER BY Id DESC) THEN (SELECT TOP 1 Id FROM Matriculation 
                WHERE ClientId = c.Id AND StatusId IN (1, 4, 5) 
                ORDER BY Id DESC) ELSE (SELECT TOP 1 Id FROM Matriculation 
                WHERE ClientId = c.Id ORDER BY Id DESC) END)
                LEFT JOIN MatriculationStatusTranslation mst ON mst.MatriculationStatusId = m.StatusId
                LEFT JOIN ProductItem pi ON pi.Id = m.ProductItemId
                LEFT JOIN Course course ON course.Id = pi.CourseId
                LEFT JOIN CourseClassStudent ccs ON ccs.StudentClientId = c.Id AND ccs.EndDate IS NULL AND ccs.CourseClassId IN (SELECT Id FROM CourseClass WHERE CourseId = course.Id)
                LEFT JOIN CourseClass cc ON cc.Id = ccs.CourseClassId
                LEFT JOIN CourseGradeTranslation cgt ON cgt.CourseGradeId = course.CourseGradeId
                LEFT JOIN StudentStatusTranslation sst ON sst.StudentStatusId = c.StudentStatusId
                LEFT JOIN Student.StudentDocument sd ON sd.ClientId = c.Id
                WHERE c.EnterpriseHeadquarterId = 7 AND course.CourseGradeId<>14 AND YEAR(m.StartDate)=$ant_anio $parte AND
                (c.StatusId IS NULL OR c.StatusId <> 2) AND
                c.InternalStudentId IS NOT NULL AND 
                (cgt.[Language] = 'es-PE' OR cgt.[Language] IS NULL) AND 
                (sst.[Language] = 'es-PE' OR sst.[Language] IS NULL) AND 
                (mst.[Language] = 'es-PE' OR sst.[Language] IS NULL) AND 
                (c.StatusId IS NULL OR c.StatusId <> 2 OR CONVERT(bit, 1) = 1) AND 
                NOT EXISTS (SELECT TOP 1 1 FROM University.UniversityMatriculation um 
                JOIN University.StudentMatriculation sm ON sm.UniversityMatriculationId = um.Id 
                JOIN University.StudentMatriculationStatus sms ON sms.Id = sm.StudentMatriculationStatusId
                WHERE um.ClientId = c.Id AND sms.ActiveMatriculation = 1)
                GROUP BY c.Id, c.InternalStudentId, c.StatusId, p.BirthDate, p.FatherSurname, p.MotherSurname,
				p.FirstName, cgt.[Description], course.[Name], mst.Description, sst.[Description], cc.[Name],
				YEAR(m.StartDate), course.CourseGradeId
                ORDER BY c.InternalStudentId";
        $query = $this->db2->query($sql)->result_Array(); 
        return $query;
    }

    function listar_mail_emprea($tipo){
        $sql = 
            "             
                SELECT C.*,
                s.nom_status,s.id_status
                
                FROM correos_empresas C
                LEFT JOIN status S ON C.estado=S.id_status
                WHERE C.estado in (1,2,3) and C.id_empresa='".$tipo."';
                    
            ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function listar_mail_alumnos($tipo){
        $sql = 
            "             
                SELECT 
            
                id_alumno ,id_grado, id_seccion

                FROM correos_empresas 
                WHERE id_correo_empre='".$tipo."';
                    
            ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario(){
        $sql = "SELECT u.id_usuario,n.nom_nivel,u.id_nivel,u.estado,s.nom_status,
        DATE_FORMAT(h.fec_ingreso,'%d/%m/%Y %H:%i') AS ultimo_ingreso,u.usuario_codigo,u.codigo,
        u.usuario_apater,u.usuario_amater,u.usuario_nombres,u.codigo_gllg,u.ini_funciones,u.fin_funciones,
        h.fec_ingreso AS ultimo_ingreso_excel,
        DATE_FORMAT(u.ini_funciones,'%d/%m/%Y') AS inicio_funcion,
        DATE_FORMAT(u.fin_funciones,'%d/%m/%Y') AS fin_funcion
        from users u 
        left join nivel n on u.id_nivel=n.id_nivel
        left join status s on u.estado=s.id_status
        left join hingreso_ultimo h on h.id_usuario=u.id_usuario
        where u.id_nivel!=6 and u.id_nivel in (12)   and u.estado=2 or u.id_usuario in (1,7)
        group by u.id_usuario  
        ORDER BY u.usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function listar_mail_alumnos_nombres($tipo){
        $anio=date('Y');        
        $sql = 
            "             
                SELECT *              
                FROM todos_ll 
                WHERE YEAR(Fecha_Pago_Matricula)='".$anio."' AND id_matriculado='".$tipo."';
                    
            ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
       
    function listado_correos_alumno($alumno_col,$anio,$grado_col,$seccion_col){
            if (is_null($alumno_col)) {

                if($grado_col==='todos' && $seccion_col!='todos'){

                    $sql = 
                    "             
                        SELECT Email FROM todos_ll
        
                        WHERE YEAR(Fecha_Pago_Matricula)='".$anio."' 
                        AND  Seccion='".$seccion_col."' 
                        
                        ;
                            
                    ";
    

                }else if($seccion_col==='todos' && $grado_col !='todos' ){

                    $sql = 
                    "             
                        SELECT Email FROM todos_ll
        
                        WHERE YEAR(Fecha_Pago_Matricula)='".$anio."' 
                        AND Grado='".$grado_col."'  
                        
                        ;
                            
                    ";

                }else if ($grado_col==='todos' && $seccion_col==='todos'){
                    $sql = 
                    "             
                        SELECT Email FROM todos_ll
        
                        WHERE YEAR(Fecha_Pago_Matricula)='".$anio."' 
                        
                        ;
                            
                    ";
                }elseif ($grado_col==='0' && $seccion_col==='0'){
                    $sql = 
                    "             
                        SELECT Email FROM todos_ll
        
                        WHERE YEAR(Fecha_Pago_Matricula)='".$anio."' 
                        
                        ;
                            
                    ";
    
                }else{
                    $sql = 
                    "             
                        SELECT Email FROM todos_ll
                            WHERE YEAR(Fecha_Pago_Matricula)='".$anio."'
                            AND  Seccion='".$seccion_col."' 
                            AND Grado='".$grado_col."'  

                            ;

                            
                    ";
    
                }



            }else{

                $sql = 
                "             
                    SELECT Email FROM todos_ll
    
                    WHERE YEAR(Fecha_Pago_Matricula)='".$anio."' 
                    and id_matriculado in ('".$alumno_col."')

                    ;
                        
                ";
           
            }

            print_r($sql);
    
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function get_list_status_combo(){
        $sql = "SELECT * FROM status 
                WHERE id_status in (1,2,3) ORDER BY nom_status ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumnos_ll(){
        $sql = "SELECT * FROM todos_ll";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_grado_ll(){
        $sql =  "
        
                    SELECT Grado FROM todos_ll GROUP BY Grado ORDER BY COUNT(id_matriculado) DESC;

                ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_seccion_ll(){
        $sql =  "
        
                    SELECT Seccion FROM todos_ll GROUP BY Seccion ORDER BY COUNT(id_matriculado) DESC;

                ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_seccion_id($data){
        if($data=='todos'){
            $sql = "
                       SELECT Seccion FROM todos_ll GROUP BY Seccion ORDER BY COUNT(id_matriculado) DESC;
                    ";
        }else{
            $sql = 
            "             
            SELECT Seccion FROM todos_ll where Grado='".$data."' GROUP BY Seccion ORDER BY COUNT(id_matriculado) DESC;

                    
            ";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_alumnos_id($seccion,$grado){
        $anio=date('Y');
                
        if($seccion=='todos'){
            $sec =  null;
        }else{
            $sec = "Seccion='".$seccion."'";
        }

        
                
        if($grado=='todos'){
            $gra =  null;
        }else{
            $gra =  "Grado='".$grado."'";
        }

        if( $sec ==null &&  $gra ==null ){

            $sql = 
            "             
                    SELECT id_matriculado,Nombre,Apellido_Paterno,Apellido_Materno
                    FROM 
                    todos_ll where YEAR(Fecha_Pago_Matricula)='".$anio."' 
                     ;
            ";

        }else if( $sec != null &&  $gra !=null){

            $sql = 
            "             
                    SELECT id_matriculado,Nombre,Apellido_Paterno,Apellido_Materno
                    FROM 
                    todos_ll 
                    where  YEAR(Fecha_Pago_Matricula)='".$anio."'  AND  ".$sec." AND ".$gra."  ;
            ";
        }else if( $sec != null &&  $gra ==null){

            $sql = 
            "             
                    SELECT id_matriculado,Nombre,Apellido_Paterno,Apellido_Materno
                    FROM 
                    todos_ll 
                    where YEAR(Fecha_Pago_Matricula)='".$anio."'  AND  ".$sec."  ;

            ";


        }else if( $sec == null &&  $gra !=null){

            $sql =      "             
                                SELECT id_matriculado,Nombre,Apellido_Paterno,Apellido_Materno
                                FROM 
                                todos_ll 
                                where  YEAR(Fecha_Pago_Matricula)='".$anio."'  AND  ".$gra."  ;

                        ";


        }

        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
        
    function delete_email_empresa($dato){

        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];

        $sql = "UPDATE correos_empresas SET estado=4, fec_eli=NOW() ,user_eli=$id_usuario
                WHERE id_correo_empre='".$dato['id_correo_empre']."'";
        $this->db->query($sql); 
    }

    function insert_correos_empresas($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql =   "
            
                    INSERT INTO correos_empresas 
                    (
                        id_empresa,
                        codigo,
                        id_alumno,
                        id_grado,
                        id_seccion,
                  
                        envio_por,
                        anio,
                        fecha_envio_por,

                        titulo_mail,
                        text_mail,
                        estado,
                        asunto,

                        fec_reg,
                        user_reg
            
                    ) 

                    VALUES 
                    
                    (
                        'll',
                        '".$dato['codigo']."',
                        '".$dato['alumno_col']."',
                        '".$dato['grado_col']."',
                        '".$dato['seccion_col']."',

                        '".$dato['envio_por']."',
                        '".$dato['anio']."',
                        '".$dato['fecha']."',

                        '".$dato['titulo_mailing']."',
                        '".$dato['text_mailing']."',
                        '".$dato['estado']."',
                        '".$dato['asunto']."',


                        NOW(),
                        $id_usuario
                    
                    );


                
                ";
        $this->db->query($sql);


                    $sqlselect = 'SELECT LAST_INSERT_ID() as id;';

        $query = $this->db->query($sqlselect)->result_Array();
        return $query;


    }

    function insert_correos_empresas_arch($nombre_arch,$id,$nombre){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql =   "
            
                    INSERT INTO archivos_correos_empresas 
                    (
                        nombre,
                        ruta,
                        id_correo_empre,
                        empresa,
                  

                        estado,

                        fec_reg,
                        user_reg
            
                    ) 

                    VALUES 
                    
                    (
                        '".$nombre."',
                        '".$nombre_arch."',
                        '".$id."',
                        'll',

                        '2',

                        NOW(),
                        $id_usuario
                    
                    )


                
                ";
        $this->db->query($sql);
    }
    //---------------------------------RETIRADOS----------------------------
    function get_list_retirados(){
        $sql = "SELECT ar.id_alumno_retirado,ar.Id,ar.Apellido_Paterno,ar.Apellido_Materno,ar.Nombre,ar.Codigo,
                DATE_FORMAT(ar.fecha_nasiste,'%d-%m-%Y') AS fecha_no_asiste,mr.nom_motivo,
                CASE WHEN ar.fut=1 THEN 'Si' WHEN ar.fut=2 THEN 'No' ELSE '' END AS fut,ar.tkt_boleta,
                DATE_FORMAT(ar.fecha_fut,'%d-%m-%Y') AS fecha_fut,CASE WHEN ar.pago_pendiente=1 THEN 'Si' 
                WHEN ar.pago_pendiente=2 THEN 'No' END AS pago_pendiente,
                CASE WHEN ar.monto!='' THEN CONCAT('s./ ',ar.monto) ELSE '' END AS monto,td.Motivo_Arpay,
                td.Observaciones_Arpay,ar.otro_motivo,CASE WHEN ar.contacto=1 THEN 'Si' 
                WHEN ar.contacto=2 THEN 'No' WHEN ar.contacto=3 THEN 'Incomunicado' ELSE '' END AS contacto,
                DATE_FORMAT(ar.fecha_contacto,'%d-%m-%Y') AS fecha_contacto,
                DATE_FORMAT(ar.hora_contacto,'%H:%i:%s') AS hora_contacto,ar.resumen,ar.obs_retiro,
                CASE WHEN ar.p_reincorporacion=1 THEN 'Si' WHEN ar.p_reincorporacion=2 THEN 'No' ELSE '' 
                END AS reincorporacion
                FROM alumno_retirado ar
                LEFT JOIN motivo_retiro mr ON mr.id_motivo=ar.id_motivo
                LEFT JOIN todos_l20 td ON td.Id=ar.Id
                WHERE ar.id_empresa=2 AND ar.estado=2
                ORDER BY ar.Apellido_Paterno ASC,ar.Apellido_Materno ASC,ar.Nombre ASC";     
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //----------------------------------------COLABORADORES------------------------------------------
    function get_list_colaborador($tipo){  
        $parte = "";
        if($tipo==1){
            $parte = "AND co.estado=2";
        }else{
            $parte = "AND co.estado NOT IN (4)";
        }

        $sql = "SELECT co.id_colaborador,CASE WHEN co.foto!='' THEN 'Si' ELSE 'No' END ft, 
                co.apellido_paterno,co.apellido_materno,co.nombres,co.nickname,co.codigo_gll,
                co.correo_personal,co.celular,CASE WHEN co.cv!='' THEN 'Si' ELSE 'No' END AS cv,
                CASE WHEN (SELECT COUNT(*) FROM contrato_colaborador cc 
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado=2)>0 THEN 'Si' ELSE 'No' END AS ct, 
                co.foto,CASE WHEN co.id_perfil=1 THEN 'Profesor' ELSE '' END AS nom_perfil,co.dni,
                co.correo_corporativo,co.direccion,de.nombre_departamento,
                pr.nombre_provincia,di.nombre_distrito,
                DATE_FORMAT(co.inicio_funciones,'%d-%m-%Y') AS inicio_funciones,
                DATE_FORMAT(co.fin_funciones,'%d-%m-%Y') AS fin_funciones,co.nickname,co.usuario,
                st.nom_status,co.observaciones,CASE WHEN co.archivo_dni!='' THEN 'Si'
                ELSE 'No' END AS doc,pe.nom_perfil AS perfil, comentariog,
                CASE WHEN SUBSTRING(co.fec_nacimiento,1,1)!='0' THEN 
                DATE_FORMAT(co.fec_nacimiento,'%d-%m-%Y') ELSE '' END AS fec_nacimiento,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc 
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2 AND 
                cc.archivo!='')>0 THEN 'Si' ELSE 'No' END AS ct_firmado
                FROM colaborador co
                LEFT JOIN departamento de ON de.id_departamento=co.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia=co.id_provincia
                LEFT JOIN distrito di ON di.id_distrito=co.id_distrito
                LEFT JOIN status st ON st.id_status=co.estado
                LEFT JOIN perfil pe ON co.id_perfil=pe.id_perfil
                WHERE co.id_empresa=2 $parte
                ORDER BY co.apellido_paterno ASC,co.apellido_materno ASC,co.nombres ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_perfil(){
        $sql = "SELECT * FROM perfil 
                WHERE id_empresa=2 AND estado=2
                ORDER BY nom_perfil ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_colaborador(){
        $sql = "SELECT id_colaborador FROM colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_usuario_colaborador($dato){
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND usuario_codigo='".$dato['usuario']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $codigo_glla=$dato['codigo_gll']."'C";

        if($dato['fec_nacimiento']=='' or $dato['fec_nacimiento']=='0000-00-00'){
            $dato['fec_nacimiento'] = 'NULL';
        }else{
            $dato['fec_nacimiento'] = "'".$dato['fec_nacimiento']."'";
        }
    
        if($dato['inicio_funciones']=='' or $dato['inicio_funciones']=='0000-00-00'){
            $dato['inicio_funciones'] = 'NULL';
        }else{
            $dato['inicio_funciones'] = "'".$dato['inicio_funciones']."'";
        }
    
        if($dato['fin_funciones']=='' or $dato['fin_funciones']=='0000-00-00'){
            $dato['fin_funciones'] = 'NULL';
        }else{
            $dato['fin_funciones'] = "'".$dato['fin_funciones']."'";
        }

        $sql = "INSERT INTO colaborador (id_empresa,id_perfil,apellido_paterno,apellido_materno,nombres,dni,
                correo_personal,correo_corporativo,celular,direccion,id_departamento,id_provincia,
                id_distrito,codigo_gll,codigo_glla, inicio_funciones,fin_funciones,nickname,usuario,password,
                password_desencriptado,foto,observaciones,fec_nacimiento, estado,fec_reg,user_reg)
                VALUES (2,'".$dato['id_perfil']."','".$dato['apellido_paterno']."',
                '".$dato['apellido_materno']."','".$dato['nombres']."','".$dato['dni']."',
                '".$dato['correo_personal']."','".$dato['correo_corporativo']."',
                '".$dato['celular']."','".$dato['direccion']."','".$dato['id_departamento']."',
                '".$dato['id_provincia']."','".$dato['id_distrito']."','".$dato['codigo_gll']."',
                '".addslashes($codigo_glla)."',
                ".$dato['inicio_funciones'].",".$dato['fin_funciones'].",'".$dato['nickname']."',
                '".$dato['usuario']."','".$dato['password']."','".$dato['password_desencriptado']."',
                '".$dato['foto']."','".$dato['observaciones']."',".$dato['fec_nacimiento'].",2,NOW(),
                $id_usuario)";
        $this->db->query($sql);

        $codigo_glla=$dato['codigo_gll']."''C";
        $sql2 = "INSERT INTO colaborador (id_empresa,id_perfil,apellido_paterno,apellido_materno,nombres,dni,
                correo_personal,correo_corporativo,celular,direccion,id_departamento,id_provincia,
                id_distrito,codigo_gll,codigo_glla, inicio_funciones,fin_funciones,nickname,usuario,password,
                password_desencriptado,foto,observaciones,fec_nacimiento, estado,fec_reg,user_reg)
                VALUES (2,'".$dato['id_perfil']."','".$dato['apellido_paterno']."',
                '".$dato['apellido_materno']."','".$dato['nombres']."','".$dato['dni']."',
                '".$dato['correo_personal']."','".$dato['correo_corporativo']."',
                '".$dato['celular']."','".$dato['direccion']."','".$dato['id_departamento']."',
                '".$dato['id_provincia']."','".$dato['id_distrito']."','".$dato['codigo_gll']."',
                '".$codigo_glla."',
                ".$dato['inicio_funciones'].",".$dato['fin_funciones'].",'".$dato['nickname']."',
                '".$dato['usuario']."','".$dato['password']."','".$dato['password_desencriptado']."',
                '".$dato['foto']."','".$dato['observaciones']."',".$dato['fec_nacimiento'].",2,getdate(),
                $id_usuario)";
        $this->db5->query($sql2);
    }

    function ultimo_id_colaborador(){
        $sql = "SELECT id_colaborador FROM colaborador
                ORDER BY id_colaborador DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function valida_insert_users_colaborador($dato){ 
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND id_externo='".$dato['id_externo']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_usuario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO users (tipo,id_externo,usuario_codigo,usuario_password,password_desencriptado,
                estado,fec_reg,user_reg)
                VALUES (2,'".$dato['id_externo']."','".$dato['usuario']."','".$dato['password']."',
                '".$dato['password_desencriptado']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_colaborador($id_colaborador){ 
        $sql = "SELECT co.*,SUBSTRING_INDEX(co.foto,'/',-1) AS nom_documento,
                CONCAT(co.apellido_paterno,' ',co.apellido_materno,', ',co.nombres) AS Nombre_Completo,
                CASE WHEN co.id_perfil=1 THEN 'Profesor' ELSE '' END AS nom_perfil,
                de.nombre_departamento,pr.nombre_provincia,di.nombre_distrito,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT DATE_FORMAT(cc.inicio_funciones,'%d/%m/%Y') 
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS i_funciones,
                CASE WHEN (SELECT COUNT(1) FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2)>0 
                THEN (SELECT CASE WHEN SUBSTRING(cc.fin_funciones,1,1)!='0' THEN 
                DATE_FORMAT(cc.fin_funciones,'%d/%m/%Y') ELSE '' END
                FROM contrato_colaborador cc
                WHERE cc.id_colaborador=co.id_colaborador AND cc.estado_contrato=2 AND cc.estado=2
                ORDER BY cc.id_contrato DESC
                LIMIT 1) ELSE '' END AS f_funciones,
                SUBSTRING_INDEX(co.cv,'/',-1) AS nom_cv,'' AS banco,'' AS cuenta
                FROM colaborador co
                LEFT JOIN departamento de ON de.id_departamento=co.id_departamento
                LEFT JOIN provincia pr ON pr.id_provincia=co.id_provincia
                LEFT JOIN distrito di ON di.id_distrito=co.id_distrito
                WHERE co.id_colaborador=$id_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_usuario_colaborador($dato){ 
        $sql = "SELECT id_usuario FROM users 
                WHERE tipo=2 AND usuario_codigo='".$dato['usuario']."' AND estado=2 AND
                id_externo!='".$dato['id_colaborador']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $codigo_glla=$dato['codigo_gll']."'C";
        $parte = "";
        if($dato['password']!=""){
            $parte = "password='".$dato['password']."',password_desencriptado='".$dato['password_desencriptado']."',";
        }

        if($dato['fec_nacimiento']=='' or $dato['fec_nacimiento']=='0000-00-00'){
            $dato['fec_nacimiento'] = 'NULL';
        }else{
            $dato['fec_nacimiento'] = "'".$dato['fec_nacimiento']."'";
        }
    
        if($dato['inicio_funciones']=='' or $dato['inicio_funciones']=='0000-00-00'){
            $dato['inicio_funciones'] = 'NULL';
        }else{
            $dato['inicio_funciones'] = "'".$dato['inicio_funciones']."'";
        }
    
        if($dato['fin_funciones']=='' or $dato['fin_funciones']=='0000-00-00'){
            $dato['fin_funciones'] = 'NULL';
        }else{
            $dato['fin_funciones'] = "'".$dato['fin_funciones']."'";
        }
        
        $sql = "UPDATE colaborador SET id_perfil='".$dato['id_perfil']."',
                apellido_paterno='".$dato['apellido_paterno']."',
                apellido_materno='".$dato['apellido_materno']."',nombres='".$dato['nombres']."',
                dni='".$dato['dni']."',correo_personal='".$dato['correo_personal']."',
                correo_corporativo='".$dato['correo_corporativo']."',celular='".$dato['celular']."',
                direccion='".$dato['direccion']."',id_departamento='".$dato['id_departamento']."',
                id_provincia='".$dato['id_provincia']."',id_distrito='".$dato['id_distrito']."',
                codigo_gll='".$dato['codigo_gll']."',inicio_funciones=".$dato['inicio_funciones'].",
                fin_funciones=".$dato['fin_funciones'].",nickname='".$dato['nickname']."',
                usuario='".$dato['usuario']."',$parte foto='".$dato['foto']."',
                observaciones='".$dato['observaciones']."',estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario, fec_nacimiento=".$dato['fec_nacimiento'].",
                codigo_glla='".addslashes($codigo_glla)."'
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db->query($sql);

        $codigo_glla=$dato['codigo_gll']."''C";

        $sql2 = "UPDATE colaborador SET id_perfil='".$dato['id_perfil']."',
                apellido_paterno='".$dato['apellido_paterno']."',
                apellido_materno='".$dato['apellido_materno']."',nombres='".$dato['nombres']."',
                dni='".$dato['dni']."',correo_personal='".$dato['correo_personal']."',
                correo_corporativo='".$dato['correo_corporativo']."',celular='".$dato['celular']."',
                direccion='".$dato['direccion']."',id_departamento='".$dato['id_departamento']."',
                id_provincia='".$dato['id_provincia']."',id_distrito='".$dato['id_distrito']."',
                codigo_gll='".$dato['codigo_gll']."',inicio_funciones=".$dato['inicio_funciones'].",
                fin_funciones=".$dato['fin_funciones'].",nickname='".$dato['nickname']."',
                usuario='".$dato['usuario']."',$parte foto='".$dato['foto']."',
                observaciones='".$dato['observaciones']."',estado='".$dato['estado']."',fec_act=getdate(),
                user_act=$id_usuario, fec_nacimiento=".$dato['fec_nacimiento'].",
                codigo_glla='".$codigo_glla."'
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db5->query($sql2);
    }

    function update_usuario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $parte = "";
        if($dato['password']!=""){
            $parte = "usuario_password='".$dato['password']."',password_desencriptado='".$dato['password_desencriptado']."',";
        }

        $sql = "UPDATE users SET usuario_codigo='".$dato['usuario']."',$parte fec_act=NOW(),
                user_act=$id_usuario
                WHERE tipo=2 AND id_externo='".$dato['id_externo']."'";
        $this->db->query($sql); 
    }

    function delete_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db->query($sql);
        $sql2 = "UPDATE colaborador SET estado=4,fec_eli=getdate(),user_eli=$id_usuario 
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db5->query($sql2);
    }

    function update_cv_colaborador($dato){
        $sql = "UPDATE colaborador SET cv='".$dato['cv']."'
                WHERE id_colaborador ='".$dato['id_colaborador']."'";
        $this->db->query($sql); 
    }

    function get_list_contrato_colaborador($id_colaborador){  
        $sql = "SELECT cc.id_contrato,cc.nom_contrato,DATE_FORMAT(cc.fecha,'%d-%m-%Y') AS fecha,
                CASE WHEN cc.archivo!='' THEN 'Si' ELSE 'No' END AS v_archivo,
                DATE_FORMAT(cc.fec_reg,'%d-%m-%Y') AS fec_registro,us.usuario_codigo AS user_registro,
                st.nom_status,st.color,cc.archivo
                FROM contrato_colaborador cc
                LEFT JOIN users us ON us.id_usuario=cc.user_reg
                LEFT JOIN status st ON st.id_status=cc.estado
                WHERE cc.id_colaborador=$id_colaborador AND cc.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_contrato_colaborador($dato){ 
        $sql = "SELECT * FROM contrato_colaborador 
                WHERE nom_contrato='".$dato['nom_contrato']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_contrato_colaborador(){
        $sql = "SELECT id_contrato FROM contrato_colaborador";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO contrato_colaborador (id_colaborador,nom_contrato,fecha,archivo,estado,
                fec_reg,user_reg) 
                VALUES ('".$dato['id_colaborador']."','".$dato['nom_contrato']."','".$dato['fecha']."',
                '".$dato['archivo']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_contrato_colaborador($id_contrato){
        $sql = "SELECT * FROM contrato_colaborador 
                WHERE id_contrato=$id_contrato";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_contrato_colaborador($dato){ 
        $sql = "SELECT * FROM contrato_colaborador 
                WHERE nom_contrato='".$dato['nom_contrato']."' AND estado=2 AND 
                id_contrato!='".$dato['id_contrato']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE contrato_colaborador SET nom_contrato='".$dato['nom_contrato']."',fecha='".$dato['fecha']."',
                archivo='".$dato['archivo']."',estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_contrato='".$dato['id_contrato']."'";
        $this->db->query($sql);
    }

    function delete_contrato_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = " UPDATE contrato_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_contrato='".$dato['id_contrato']."'";
        $this->db->query($sql);
    }

    function get_list_pago_colaborador($id_colaborador){  
        $sql = "SELECT pc.id_pago,pc.id_banco AS nom_banco,pc.cuenta_bancaria,st.nom_status,
                st.color
                FROM pago_colaborador pc
                LEFT JOIN status st ON st.id_status=pc.estado
                WHERE pc.id_colaborador=$id_colaborador AND pc.estado NOT IN (4)";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_pago_colaborador($dato){ 
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_banco='".$dato['id_banco']."' AND cuenta_bancaria='".$dato['cuenta_bancaria']."' AND 
                estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_pago_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO pago_colaborador (id_colaborador,id_banco,cuenta_bancaria,
                estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_colaborador']."','".$dato['id_banco']."',
                '".$dato['cuenta_bancaria']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_pago_colaborador($id_pago){
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_pago=$id_pago";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_update_pago_colaborador($dato){ 
        $sql = "SELECT * FROM pago_colaborador 
                WHERE id_banco='".$dato['id_banco']."' AND cuenta_bancaria='".$dato['cuenta_bancaria']."' AND 
                estado=2 AND id_pago!='".$dato['id_pago']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function update_pago_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE pago_colaborador SET id_banco='".$dato['id_banco']."',
                cuenta_bancaria='".$dato['cuenta_bancaria']."',
                estado='".$dato['estado']."',fec_act=NOW(),user_act=$id_usuario 
                WHERE id_pago='".$dato['id_pago']."'";
        $this->db->query($sql);
    }

    function delete_pago_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario']; 
        $sql = " UPDATE pago_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_pago='".$dato['id_pago']."'";
        $this->db->query($sql);
    }

    function get_list_asistencia_colaborador($id_colaborador){  
        // ri.estado=2 AND ri.id_alumno=$id_colaborador
        $sql = "SELECT ri.ingreso AS orden,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr 
                WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' 
                END AS tipo_desc,CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' 
                WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,
                us.usuario_codigo,CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,ri.codigo
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.id_registro_ingreso=0
                ORDER BY ri.ingreso ASC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_usuario_obs(){
        $sql = "SELECT id_usuario,usuario_codigo 
                FROM users
                WHERE id_nivel!=6 AND id_nivel IN (12) AND estado=2 OR id_usuario IN (1,7)
                ORDER BY usuario_codigo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_observacion_colaborador($id_colaborador){  
        $sql = "SELECT oc.id_observacion,DATE_FORMAT(oc.fecha,'%d-%m-%Y') AS fecha,ti.nom_tipo,
                us.usuario_codigo AS usuario,oc.observacion,oc.fecha AS orden, observacion_archivo
                FROM observacion_colaborador oc
                LEFT JOIN tipo_observacion ti ON ti.id_tipo=oc.id_tipo
                LEFT JOIN users us ON us.id_usuario=oc.usuario
                WHERE oc.id_colaborador=$id_colaborador AND oc.estado=2
                ORDER BY oc.fecha DESC"; 
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function valida_insert_observacion_colaborador($dato){
        $id_nivel= $_SESSION['usuario'][0]['id_nivel'];
        $sql = "SELECT * FROM observacion_colaborador 
                WHERE id_tipo='".$dato['id_tipo']."' AND fecha='".$dato['fecha']."' AND 
                observacion='".$dato['observacion']."' AND id_colaborador='".$dato['id_colaborador']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_observacion_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO observacion_colaborador (id_colaborador,id_tipo,fecha,usuario,observacion,
                estado,fec_reg,user_reg, observacion_archivo) 
                VALUES ('".$dato['id_colaborador']."','".$dato['id_tipo']."','".$dato['fecha']."',
                '".$dato['usuario']."','".$dato['observacion']."',2,NOW(),$id_usuario,
                '".$dato['observacion_archivo']."')";
        $this->db->query($sql);
    }

    function delete_observacion_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE observacion_colaborador SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_observacion='".$dato['id_observacion']."'";
        $this->db->query($sql);
    }
    //-----------------------------------CALENDARIO-------------------------------------
    function get_list_calendario($tipo){ 
        if($tipo==1){
            $parte = "AND ca.estado=2";
        }else{
            $parte = "AND ca.estado NOT IN (4)";
        }
        $sql = "SELECT ca.id_calendario,DATE_FORMAT(ca.fecha,'%d-%m-%Y') AS fecha,
                ca.descripcion,ca.dias,ca.motivo,st.nom_status,st.color,
                ca.fecha AS orden
                FROM calendario ca
                LEFT JOIN status st ON st.id_status=ca.estado
                WHERE ca.id_empresa=2 $parte
                ORDER BY st.nom_status ASC,ca.fecha ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function insert_calendario($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO calendario (id_empresa,fecha,descripcion,dias,motivo,estado,fec_reg,user_reg)
                VALUES (2,'".$dato['fecha']."','".$dato['descripcion']."','".$dato['dias']."',
                '".$dato['motivo']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function get_id_calendario($id_calendario){
        $sql = "SELECT * FROM calendario 
                WHERE id_calendario=$id_calendario";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    
    function update_calendario($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE calendario SET fecha='".$dato['fecha']."',
                descripcion='".$dato['descripcion']."',dias='".$dato['dias']."',
                motivo='".$dato['motivo']."',estado='".$dato['estado']."',fec_act=NOW(),
                user_act=$id_usuario
                WHERE id_calendario='".$dato['id_calendario']."'";
        $this->db->query($sql);
    }

    function delete_calendario($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE calendario SET estado=4,fec_eli=NOW(),user_eli=$id_usuario
                WHERE id_calendario='".$dato['id_calendario']."'";
        $this->db->query($sql);
    }

    //-------------------------------------------------ASISTENCIA COLABORADOR----------------------------------
    function get_list_registro_ingreso_c($fec_in,$fec_fi){
        $sql = "SELECT ri.id_registro_ingreso,ri.ingreso AS orden,
                FORMAT(ri.ingreso,'dd/MM/yyyy') AS fecha_ingreso,
                FORMAT(ri.ingreso,'HH:mm') AS hora_ingreso,
                ri.codigo,ri.apater,ri.amater,ri.nombres,
                (CASE WHEN hr.observacion IS NULL THEN 'No' ELSE 'Sí' END) AS obs,
                CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' 
                WHEN hr.tipo=5 THEN 'Foto' WHEN hr.tipo=6 THEN 'Uniforme' 
                WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.salida>0 THEN 'Salida' ELSE 
                (CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END) END AS nom_estado_reporte,
                us.usuario_codigo,CASE WHEN ri.estado_reporte=1 THEN 
                (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) 
                WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing,
                pe.nom_perfil AS nom_tipo_acceso,
                CASE WHEN ri.reg_automatico=1 THEN 'Automático' WHEN ri.reg_automatico=2 THEN 'Manual'
                ELSE '' END AS reg_automatico,CASE WHEN ri.user_reg=0 THEN 
                (SELECT usuario_codigo FROM users WHERE id_usuario=60) 
                ELSE ue.usuario_codigo END AS usuario_registro,
                FORMAT(ri.hora_salida,'HH:mm') AS hora_salida,hr.observacion as obs_historial
                FROM registro_ingreso_ls ri
                LEFT JOIN historial_registro_ingreso_ls hr ON ri.id_registro_ingreso=hr.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                LEFT JOIN users ue ON ue.id_usuario=ri.user_reg
                LEFT JOIN colaborador c on c.codigo_glla = ri.codigo
                LEFT JOIN perfil pe ON c.id_perfil=pe.id_perfil
                WHERE ri.estado=2 AND FORMAT(ri.ingreso,'yyyy-MM-dd') BETWEEN '$fec_in' AND '$fec_fi' AND 
                ri.codigo LIKE '%C%' and c.id_empresa=2
                ORDER BY ri.ingreso DESC";
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function delete_registro_ingreso_lista($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE registro_ingreso_ls SET estado=4,fec_eli=GETDATE(),user_eli=$id_usuario
                WHERE id_registro_ingreso='".$dato['id_registro_ingreso']."'";
        $this->db5->query($sql);
    }
    //-----------------------------------------------SALÓN------------------------------------------
    function get_list_salon($id_salon=null){
        if(isset($id_salon) && $id_salon>0){
            $sql = "SELECT * FROM salon_ll WHERE id_salon=$id_salon";
        }else{
            $sql = "SELECT sa.*,CASE WHEN sa.ae=1 THEN 'Si' ELSE 'No' END AS ae,
                    CASE WHEN sa.cf=1 THEN 'Si' ELSE 'No' END AS cf,CASE WHEN sa.ds=1 THEN 'Si' ELSE 'No' END AS ds,
                    CASE WHEN sa.et=1 THEN 'Si' ELSE 'No' END AS et,CASE WHEN sa.ft=1 THEN 'Si' ELSE 'No' END AS ft,
                    CASE WHEN sa.estado_salon=1 THEN 'Activo' WHEN sa.estado_salon=2 THEN 'Inactivo' 
                    WHEN sa.estado_salon=3 THEN 'Clausurado' ELSE '' END AS estado_salon,ts.nom_tipo_salon
                    FROM salon_ll sa
                    LEFT JOIN tipo_salon ts ON ts.id_tipo_salon=sa.id_tipo_salon
                    WHERE sa.estado=2
                    ORDER BY sa.planta ASC,sa.referencia ASC";
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }
    
    function get_list_combo_salon($id_especialidad){
        if($id_especialidad==5){
            $parte = "AND et=1";
        }elseif($id_especialidad==6){
            $parte = "AND ft=1";
        }elseif($id_especialidad==7){
            $parte = "AND ae=1";
        }elseif($id_especialidad==8){
            $parte = "AND cf=1";
        }elseif($id_especialidad==9){
            $parte = "AND ds=1";
        }
        $sql = "SELECT id_salon,descripcion AS nom_salon 
                FROM salon_ll 
                WHERE estado=2 $parte
                ORDER BY nom_salon ASC";
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }
    
    function get_list_tipo_salon(){
        $sql = "SELECT * FROM tipo_salon ORDER BY nom_tipo_salon ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    
    function valida_insert_salon($dato){
        $sql = "SELECT * FROM salon_ll WHERE referencia='".$dato['referencia']."' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    
    function insert_salon($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO salon_ll (planta,referencia,id_tipo_salon,descripcion,ae,cf,ds,et,ft,capacidad,disponible,
                pintura,chapa,pizarra,proyector,puerta,tacho,cortina,iluminacion,mueble,mesa_profesor,enchufe,
                computadora,silla_profesor,observaciones,estado_salon,estado,fec_reg,user_reg) 
                VALUES('".$dato['planta']."','".$dato['referencia']."','".$dato['id_tipo_salon']."',
                '".$dato['descripcion']."','".$dato['ae']."','".$dato['cf']."','".$dato['ds']."','".$dato['et']."',
                '".$dato['ft']."','".$dato['capacidad']."','".$dato['disponible']."','".$dato['pintura']."',
                '".$dato['chapa']."','".$dato['pizarra']."','".$dato['proyector']."','".$dato['puerta']."',
                '".$dato['tacho']."','".$dato['cortina']."','".$dato['iluminacion']."','".$dato['mueble']."',
                '".$dato['mesa_profesor']."','".$dato['enchufe']."','".$dato['computadora']."',
                '".$dato['silla_profesor']."','".$dato['observaciones']."',1,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }
    
    function valida_update_salon($dato){
        $sql = "SELECT * FROM salon_ll WHERE referencia='".$dato['referencia']."' AND 
                estado=2 AND id_salon!='".$dato['id_salon']."'";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    
    function update_salon($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE salon_ll SET planta='".$dato['planta']."',referencia='".$dato['referencia']."',
                id_tipo_salon='".$dato['id_tipo_salon']."',descripcion='".$dato['descripcion']."',
                ae='".$dato['ae']."',cf='".$dato['cf']."',ds='".$dato['ds']."',et='".$dato['et']."',ft='".$dato['ft']."',
                capacidad='".$dato['capacidad']."',disponible='".$dato['disponible']."',pintura='".$dato['pintura']."',
                chapa='".$dato['chapa']."',pizarra='".$dato['pizarra']."',proyector='".$dato['proyector']."',
                puerta='".$dato['puerta']."',tacho='".$dato['tacho']."',cortina='".$dato['cortina']."',
                iluminacion='".$dato['iluminacion']."',mueble='".$dato['mueble']."',mesa_profesor='".$dato['mesa_profesor']."',
                enchufe='".$dato['enchufe']."',computadora='".$dato['computadora']."',silla_profesor='".$dato['silla_profesor']."',
                observaciones='".$dato['observaciones']."',estado_salon='".$dato['estado_salon']."',fec_act=NOW(),user_act=$id_usuario
                WHERE id_salon='".$dato['id_salon']."'";
        $this->db->query($sql);
    } 
    
    function delete_salon($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE salon_ll SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_salon='".$dato['id_salon']."'";
        $this->db->query($sql);
    }
    
    function get_list_especialidad_combo(){
        $sql = "SELECT id_especialidad,nom_especialidad,abreviatura 
                FROM especialidad 
                WHERE estado=2 
                ORDER BY nom_especialidad ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }
    //---------------------------------------------MAILING-------------------------------------------
    function get_list_mailing($id_mailing=null){  
        if(isset($id_mailing) && $id_mailing>0){
            $sql = "SELECT * FROM mailing_alumno 
                    WHERE id_mailing=$id_mailing";
        }else{
            $sql = "SELECT ma.id_mailing,ma.codigo,
                    SUBSTRING(CONCAT((CASE WHEN FIND_IN_SET('1',ma.dia_envio) THEN 'Lunes, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('2',ma.dia_envio) THEN 'Martes, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('3',ma.dia_envio) THEN 'Miércoles, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('4',ma.dia_envio) THEN 'Jueves, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('5',ma.dia_envio) THEN 'Viernes, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('6',ma.dia_envio) THEN 'Sábado, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('7',ma.dia_envio) THEN 'Domingo, ' ELSE '' END)),1,
                    CHAR_LENGTH(CONCAT((CASE WHEN FIND_IN_SET('1',ma.dia_envio) THEN 'Lunes, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('2',ma.dia_envio) THEN 'Martes, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('3',ma.dia_envio) THEN 'Miércoles, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('4',ma.dia_envio) THEN 'Jueves, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('5',ma.dia_envio) THEN 'Viernes, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('6',ma.dia_envio) THEN 'Sábado, ' ELSE '' END),
                    (CASE WHEN FIND_IN_SET('7',ma.dia_envio) THEN 'Domingo, ' ELSE '' END)))-2) AS
                    dia_envio,ma.titulo,ma.texto,ma.documento,st.nom_status,st.color,
                    CASE WHEN SUBSTRING(ma.fecha_envio,1,1)='2' THEN
                    DATE_FORMAT(ma.fecha_envio,'%d-%m-%Y') ELSE '' END AS fecha_envio,
                    CASE WHEN ma.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
                    FROM mailing_alumno ma
                    LEFT JOIN status st ON ma.estado_m=st.id_status
                    WHERE ma.id_empresa=2 AND ma.estado IN (2,3)
                    ORDER BY ma.codigo ASC";
        }
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_alumno_mailing(){
        $anio = date('Y');
        $sql = "SELECT Id AS id_alumno,CONCAT(Apellido_Paterno,' ',Apellido_Materno,', ',
                Nombre) AS nom_alumno
                FROM todos_ll
                WHERE Alumno='Matriculado' AND Fecha_Pago_Matricula<>'' AND 
                Fecha_Pago_Cuota_Ingreso<>'' AND Anio='$anio'
                ORDER BY Apellido_Paterno ASC,Apellido_Materno ASC,Nombre ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_list_grado_mailing(){
        $sql = "SELECT Grado AS nom_grado FROM todos_ll 
                WHERE Grado NOT IN ('','N/D')
                GROUP BY Grado 
                ORDER BY Grado ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_list_seccion_mailing($nom_grado){
        $sql = "SELECT Seccion AS nom_seccion FROM todos_ll 
                WHERE Grado='$nom_grado' AND Seccion NOT IN ('','N/D')
                GROUP BY Seccion 
                ORDER BY Seccion ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_cantidad_mailing(){
        $sql = "SELECT COUNT(1) AS cantidad FROM mailing_alumno";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO mailing_alumno (id_empresa,codigo,grado,seccion,dia_envio,titulo,texto,
                documento,estado_m,estado,fec_reg,user_reg) 
                VALUES (2,'".$dato['codigo']."','".$dato['grado']."','".$dato['seccion']."',
                '".$dato['dia_envio']."','".$dato['titulo']."','".$dato['texto']."','".$dato['documento']."',
                '".$dato['estado_m']."',2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function ultimo_id_mailing(){
        $sql = "SELECT id_mailing FROM mailing_alumno
                ORDER BY id_mailing DESC
                LIMIT 1";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function insert_envio_mailing($dato){
        $sql = "INSERT INTO envio_mailing_alumno (id_mailing,id_alumno) 
                VALUES ('".$dato['id_mailing']."','".$dato['id_alumno']."')";
        $this->db->query($sql);
    }

    function get_list_envio_mailing($id_mailing){
        $sql = "SELECT id_alumno FROM envio_mailing_alumno
                WHERE id_mailing=$id_mailing";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function update_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET codigo='".$dato['codigo']."',grado='".$dato['grado']."',
                seccion='".$dato['seccion']."',dia_envio='".$dato['dia_envio']."',titulo='".$dato['titulo']."',
                texto='".$dato['texto']."',documento='".$dato['documento']."',estado_m='".$dato['estado_m']."',
                fec_act=NOW(),user_act=$id_usuario
                WHERE id_mailing='".$dato['id_mailing']."'";
        $this->db->query($sql);
    }

    function delete_envio_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "DELETE FROM envio_mailing_alumno
                WHERE id_mailing='".$dato['id_mailing']."'";
        $this->db->query($sql);
    }

    function get_mailing_activos(){
        $sql = "SELECT id_mailing,titulo,texto,documento
                FROM mailing_alumno 
                WHERE id_empresa=2 AND enviado=0 AND estado_m=2 AND 
                (tipo_envio=1 OR (tipo_envio=2 AND fecha_envio=CURDATE())) AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    function get_datos_alumno_mailing($id_mailing){
        $sql = "CALL datos_alumno_mailing ($id_mailing)";
        $query = $this->db->query($sql)->result_Array();
        mysqli_next_result($this->db->conn_id);
        return $query; 
    } 

    function insert_detalle_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO detalle_mailing_alumno (id_mailing,id_alumno,cod_alumno,apater_alumno,
                amater_alumno,nom_alumno,email_alumno,celular_alumno,grado_alumno,seccion_alumno,id_apoderado,
                apater_apoderado,amater_apoderado,nom_apoderado,parentesco_apoderado,email_apoderado,
                celular_apoderado,fecha_envio,estado,fec_reg,user_reg) 
                VALUES ('".$dato['id_mailing']."','".$dato['id_alumno']."','".$dato['cod_alumno']."',
                '".$dato['apater_alumno']."','".$dato['amater_alumno']."','".$dato['nom_alumno']."',
                '".$dato['email_alumno']."','".$dato['celular_alumno']."','".$dato['grado_alumno']."',
                '".$dato['seccion_alumno']."','".$dato['id_apoderado']."','".$dato['apater_apoderado']."',
                '".$dato['amater_apoderado']."','".$dato['nom_apoderado']."',
                '".$dato['parentesco_apoderado']."','".$dato['email_apoderado']."',
                '".$dato['celular_apoderado']."',NOW(),2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_enviado_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET enviado=1,estado_m=3
                WHERE id_mailing='".$dato['id_mailing']."'";
        $this->db->query($sql);
    }

    function delete_mailing($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE mailing_alumno SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_mailing='".$dato['id_mailing']."'";
        $this->db->query($sql);
    }

    function get_list_detalle_mailing($id_mailing,$tipo){
        $sql = "CALL usp_listado_detalle_mailing ($id_mailing,$tipo)";
        $query = $this->db->query($sql)->result_Array(); 
        mysqli_next_result($this->db->conn_id);
        return $query; 
    }

    function update_comentario_colaborador($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE colaborador SET comentariog='".$dato['comentariog']."'
                WHERE id_colaborador='".$dato['id_colaborador']."'";
        $this->db->query($sql);
    }

    function update_comentario_alumno($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE todos_ll SET comentariog='".$dato['comentariog']."'
                WHERE Id='".$dato['id_alumno']."'";
        $this->db->query($sql);
    }

    function get_id_obsaimg($id_comuimg){ 
        $sql = "SELECT *,SUBSTRING_INDEX(observacion_archivo,'/',-1) AS nom_documento  
                FROM alumno_observaciones_general 
                WHERE id_observacion =$id_comuimg";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    function get_id_obscimg($id_comuimg){ 
        $sql = "SELECT *,SUBSTRING_INDEX(observacion_archivo,'/',-1) AS nom_documento  
                FROM observacion_colaborador 
                WHERE id_observacion =$id_comuimg";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }

    // ---------------------- lISTA DE FOTOCHECKS DE LITTLELEADERS --------------------------------------
    function get_list_fotocheck($tipo){
        $parte = " f.esta_fotocheck NOT IN (99)"; //99 es el estado de prueba
        if($tipo==1){
            $parte = "f.esta_fotocheck NOT IN (2,3,99)";
        }
        $sql = "SELECT f.*,DATE_FORMAT(f.Fecha_Pago_Fotocheck, '%d/%m/%Y') as Pago_Fotocheck,tl.id_colaborador,
                tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombres,tl.codigo_gll, tl.codigo_glla,
                DATE_FORMAT(f.fecha_envio, '%d/%m/%Y') as fecha_envio,
                f.usuario_encomienda,f.cargo_envio,
                DATE_FORMAT(f.fecha_recepcion, '%d/%m/%Y') as fecha_recepcion,f.usuario_foto,
                (SELECT us.usuario_codigo FROM users us 
                WHERE f.usuario_encomienda=us.id_usuario) as usuario_codigo,
                (SELECT us.usuario_codigo FROM users us 
                WHERE f.usuario_foto=us.id_usuario) as usuario_foto,
                (SELECT car.cod_cargo FROM cargo car 
                WHERE car.id_cargo=f.cargo_envio) as cargo_envio,
                CASE WHEN f.esta_fotocheck=1 AND f.impresion=0 THEN 'Foto Rec' 
                WHEN f.esta_fotocheck=1 AND f.impresion=1 THEN 'Impreso'
                WHEN f.esta_fotocheck=2 THEN 'Enviado' 
                WHEN f.esta_fotocheck=3 THEN 'Anulado' ELSE 'Cancelado' END AS esta_fotocheck,
                CASE WHEN f.esta_fotocheck=1 AND f.impresion=0 THEN '#92D050' 
                WHEN f.esta_fotocheck=1 AND f.impresion=1 THEN '#F18A00'
                WHEN f.esta_fotocheck=2 THEN '#0070c0' 
                WHEN f.esta_fotocheck=3 THEN '#7F7F7F' ELSE '#0070c0' END AS color_esta_fotocheck,
                f.esta_fotocheck AS estado_fotocheck
                FROM fotocheck_ll f
                LEFT JOIN colaborador tl ON f.Id=tl.id_colaborador
                WHERE $parte
                ORDER BY f.Fecha_Pago_Fotocheck ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_id_fotocheck($id_fotocheck){
        $sql = "SELECT fo.*,CASE WHEN fo.esta_fotocheck=1 THEN 'Foto Rec' WHEN fo.esta_fotocheck=2 THEN 'Enviado' 
                WHEN fo.esta_fotocheck=3 THEN 'Anulado' ELSE 'Cancelado' END AS esta_fotocheck,
                CASE WHEN fo.esta_fotocheck=1 THEN '#92D050' WHEN fo.esta_fotocheck=2 THEN '#0070c0' 
                WHEN fo.esta_fotocheck=3 THEN '#7F7F7F' ELSE '#0070c0' END AS color_esta_fotocheck, 
                DATE_FORMAT(fo.fecha_recepcion, '%d/%m/%Y') AS fecha_recepcion,
                DATE_FORMAT(fo.fecha_recepcion_2, '%d/%m/%Y') AS fecha_recepcion_2,
                DATE_FORMAT(fo.fecha_recepcion_3, '%d/%m/%Y') AS fecha_recepcion_3,
                DATE_FORMAT(fo.fecha_envio, '%d/%m/%Y') AS fecha_envio,
                uf.usuario_codigo AS usuario_foto,
                DATE_FORMAT(fo.fecha_anulado, '%d/%m/%Y') AS fecha_anulado,
                ua.usuario_codigo AS usuario_anulado,ud.usuario_codigo AS usuario_foto_2,
                ut.usuario_codigo AS usuario_foto_3,ue.usuario_codigo AS usuario_encomienda,
                ca.cod_cargo AS cargo_envio,
                SUBSTRING_INDEX(foto_fotocheck,'/',-1) AS nom_foto_fotocheck,
                SUBSTRING_INDEX(foto_fotocheck_2,'/',-1) AS nom_foto_fotocheck_2,
                SUBSTRING_INDEX(foto_fotocheck_3,'/',-1) AS nom_foto_fotocheck_3
                ,tl.Apellido_Paterno,tl.Apellido_Materno,tl.Nombres,tl.codigo_gll,tl.codigo_glla,
                YEAR(fo.fecha_fotocheck) AS anio_fotocheck,MONTH(fo.fecha_fotocheck) AS mes_fotocheck,
                case when length(concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno)) > 18 then 
                concat(tl.Apellido_Paterno,' ',substring(tl.Apellido_Materno,1,1),'.')else concat(tl.Apellido_Paterno,' ',tl.Apellido_Materno) end as apellidos,
                IF(LENGTH(tl.nombres) > 20, CONCAT(SUBSTRING(tl.nombres, 1, 20),'.'),tl.nombres) AS Nombre_corto,
                (SELECT car.cod_cargo FROM cargo car WHERE car.id_cargo=fo.cargo_envio) as cargo_envio
                FROM fotocheck_ll fo
                LEFT JOIN users uf ON uf.id_usuario=fo.usuario_foto
                LEFT JOIN users ua ON ua.id_usuario=fo.usuario_anulado
                LEFT JOIN users ud ON ud.id_usuario=fo.usuario_foto_2
                LEFT JOIN users ut ON ut.id_usuario=fo.usuario_foto_3
                LEFT JOIN users ue ON ue.id_usuario=fo.usuario_encomienda
                LEFT JOIN cargo ca ON ca.id_cargo=fo.cargo_envio
                LEFT JOIN colaborador tl ON tl.id_colaborador=fo.Id
                WHERE fo.id_fotocheck=$id_fotocheck";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_cod_documento_colaborador($cod_documento){ // cambiar aal crear tabla de -> documento_colaborador_empresa
        $sql = "SELECT id_documento FROM documento_colaborador_empresa 
                WHERE id_empresa=2 AND cod_documento='$cod_documento' AND estado=2";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function update_foto_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $estado = "";
        if($dato['n_foto']==1){
            $foto_fotocheck = "foto_fotocheck";
            $usuario_foto = "usuario_foto";
            $fecha_recepcion = "fecha_recepcion";
        }else{
            if($dato['n_foto']==2){
                $estado="esta_fotocheck=1,";
            }
            $foto_fotocheck = "foto_fotocheck_".$dato['n_foto'];
            $usuario_foto = "usuario_foto_".$dato['n_foto'];
            $fecha_recepcion = "fecha_recepcion_".$dato['n_foto'];
        }
        $sql = "UPDATE fotocheck_ll SET $foto_fotocheck='".$dato[$foto_fotocheck]."',
                $usuario_foto=$id_usuario,$fecha_recepcion=NOW(),$estado
                fec_act=NOW(),user_act=$id_usuario 
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }
    function get_detalle_colaborador_empresa($id_colaborador,$id_documento){
        $sql = "SELECT id_detalle FROM detalle_colaborador_empresa 
                WHERE id_colaborador=$id_colaborador AND id_documento=$id_documento AND estado=2
                ORDER BY id_detalle DESC";
        //echo $sql;
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function update_documento_colaborador($dato){ // cambiar al crear la tabla -> detalle_colabordor_empresa
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE detalle_colaborador_empresa SET archivo='".$dato['archivo']."',user_subido=$id_usuario,
                fec_subido=NOW(),fec_act=NOW(),user_act=$id_usuario
                WHERE id_detalle='".$dato['id_detalle']."'";
        echo $sql;
        $this->db->query($sql);
    }
    function valida_fotocheck_completo($id_fotocheck){
        $sql = "SELECT id_fotocheck FROM fotocheck_ll 
                WHERE id_fotocheck=$id_fotocheck AND foto_fotocheck!='' AND 
                foto_fotocheck_2!='' AND foto_fotocheck_3!='' AND 
                (fecha_fotocheck IS NOT NULL OR fecha_fotocheck!='' OR fecha_fotocheck!='0000-00-00')";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function update_fotocheck_completo($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_ll SET fecha_fotocheck=NOW()
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }
    function impresion_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_ll SET impresion=1,fec_impresion=NOW(),user_impresion=$id_usuario
                WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }
    function anular_envio($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql="UPDATE fotocheck_ll SET esta_fotocheck=3,obs_anulado='".$dato['obs_anulado']."',usuario_anulado=$id_usuario,fecha_anulado=NOW(),user_act=$id_usuario 
        WHERE id_fotocheck='".$dato['id_fotocheck']."'";

        $this->db->query($sql);
    }
    function get_id_user(){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "SELECT * FROM users where id_usuario='$id_usuario' ";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function get_cargo_x_id($id_usuario_de){
        $sql = "SELECT * FROM (SELECT * FROM cargo where id_usuario_de=$id_usuario_de ORDER BY cod_cargo DESC LIMIT 10) AS cargo ORDER BY cod_cargo ASC";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    function update_envio_fotocheck($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE fotocheck_ll SET fecha_envio='".$dato['fecha_envio']."',
                    usuario_encomienda='".$dato['usuario_encomienda']."',
                    cargo_envio='".$dato['cargo_envio']."',esta_fotocheck=2,
                    fec_act=NOW(),user_act=$id_usuario 
                    WHERE id_fotocheck='".$dato['id_fotocheck']."'";
        $this->db->query($sql);
    }
    
    //---------------------------------------------Colabordor--Observaciones-------------------------------------------
    function get_list_colaborador_obs(){ 
        $sql = "SELECT c.apellido_Paterno,c.apellido_Materno,c.nombres,c.codigo_gll,e.nom_empresa,
                DATE_FORMAT(oc.fec_reg, '%d-%m-%Y') AS fecha_registro,oc.observacion AS Comentario,
                u.usuario_codigo,c.id_empresa
                FROM observacion_colaborador oc
                LEFT JOIN colaborador c ON c.id_colaborador=oc.id_colaborador
                LEFT JOIN empresa e ON e.id_empresa=c.id_empresa
                LEFT JOIN users u ON u.id_usuario=c.user_reg
                WHERE oc.id_empresa = 2";
        $query = $this->db->query($sql)->result_Array();
        return $query; 
    }

    //---------------------------------------------Ingresos--Alumno-------------------------------------------
    function get_ingresos_modulo($id_alumno){
        $sql = "SELECT modulo
                FROM registro_ingreso_ls ri
                LEFT JOIN historial_registro_ingreso_ls hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno=$id_alumno
                group by ri.modulo ORDER BY modulo";
                //echo ($sql);
        $query = $this->db5->query($sql)->result_Array();
        return $query;

    }

    function get_list_registro_ingreso_matriculados_modulo($dato){
        //echo ($dato['modulo']);
        /*$sql = "SELECT ri.codigo,ri.ingreso AS orden,DATE_FORMAT(ri.ingreso,'%d/%m/%Y') AS fecha_ingreso,
                DATE_FORMAT(ri.ingreso,'%H:%i') AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso hr WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
                CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing
                FROM registro_ingreso ri
                LEFT JOIN historial_registro_ingreso hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno='".$dato['id_alumno']."' and ri.modulo='".$dato['modulo']."'
                ORDER BY ri.ingreso DESC"; 
               //echo($sql);
        $query = $this->db->query($sql)->result_Array();
        return $query;*/

        $sql = "SELECT ri.codigo,ri.ingreso AS orden,CONVERT(varchar,ri.ingreso,103) AS fecha_ingreso,
                CONVERT(char(5),ri.ingreso,108) AS hora_ingreso,
                CASE WHEN (SELECT COUNT(*) FROM historial_registro_ingreso_ls hr WHERE hr.id_registro_ingreso=ri.id_registro_ingreso)>0
                THEN 'Si' ELSE 'No' END AS obs,CASE WHEN hr.tipo=1 THEN 'Asiduidad' WHEN hr.tipo=2 THEN 'Retraso' 
                WHEN hr.tipo=3 THEN 'Fotocheck' WHEN hr.tipo=4 THEN 'Documentos' WHEN hr.tipo=5 THEN 'Foto' 
                WHEN hr.tipo=6 THEN 'Uniforme' WHEN hr.tipo=7 THEN 'Presentación' WHEN hr.tipo=8 THEN 'Pagos' END AS tipo_desc,
                CASE WHEN ri.estado_reporte=1 THEN 'Ingresa' WHEN ri.estado_reporte=2 THEN 'Autorización' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS nom_estado_reporte,us.usuario_codigo,
                CASE WHEN ri.estado_reporte=1 THEN (CASE WHEN ri.estado_ingreso=1 THEN 'Puntual' 
                WHEN ri.estado_ingreso=2 THEN 'Retrasado' ELSE '' END) WHEN ri.estado_reporte=2 THEN 'A hora' 
                WHEN ri.estado_reporte=3 THEN 'NO Ingresa' ELSE '' END AS estado_ing
                FROM registro_ingreso_ls ri
                LEFT JOIN historial_registro_ingreso_ls hr ON hr.id_registro_ingreso=ri.id_registro_ingreso
                LEFT JOIN users us ON us.id_usuario=ri.user_autorizado
                WHERE ri.estado=2 AND ri.id_alumno='".$dato['id_alumno']."' and ri.modulo='".$dato['modulo']."' and RIGHT(ri.codigo,1)<>'C'
                ORDER BY ri.ingreso DESC";
                //echo ($dato['modulo']);
        $query = $this->db5->query($sql)->result_Array();
        return $query;
    }

    function get_list_historial_registro_ingreso($id_registro_ingreso){
        $sql = "SELECT *,CASE WHEN tipo=1 THEN 'Asiduidad' WHEN tipo=2 THEN 'Retraso' WHEN tipo=3 THEN 'Fotocheck' 
                WHEN tipo=4 THEN 'Documentos' WHEN tipo=5 THEN 'Foto' WHEN tipo=6 THEN 'Uniforme'
                WHEN tipo=7 THEN 'Presentación' WHEN tipo=8 THEN 'Pagos' END AS tipo_desc,
                DATE_FORMAT(fec_reg,'%d/%m/%Y') AS Fecha
                FROM historial_registro_ingreso_ls 
                WHERE estado=2 AND id_registro_ingreso=$id_registro_ingreso";
        $query = $this->db5->query($sql)->result_Array(); 
        return $query;
    }
    
    //-----------------------------------------------C BIMESTRES------------------------------------------
    function get_list_c_bimestres($id_bimestre=null){ 
        if(isset($id_bimestre) && $id_bimestre>0){
            $sql = "SELECT * FROM bimestres 
                    WHERE id_bimestre=$id_bimestre";
        }else{
            $sql = "SELECT *, e.nom_empresa, DATE_FORMAT(b.fecha_inicio, '%d/%m/%Y') as inicio,
                    DATE_FORMAT(b.fecha_fin, '%d/%m/%Y') as fin
                    FROM bimestres b
                    LEFT JOIN empresa e ON e.id_empresa=b.id_empresa
                    WHERE b.id_empresa = 2 AND b.estado = 2";
        }
        $query = $this->db->query($sql)->result_Array(); 
        return $query; 
    }

    function insert_c_bimestres($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "INSERT INTO bimestres (descripcion,fecha_inicio,fecha_fin,id_empresa,estado,fec_reg,user_reg)
                VALUES ('".$dato['descripcion']."','".$dato['fecha_inicio']."','".$dato['fecha_fin']."',2,2,NOW(),$id_usuario)";
        $this->db->query($sql);
    }

    function update_c_bimestres($dato){ 
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE bimestres SET descripcion='".$dato['descripcion']."',
                fecha_inicio='".$dato['fecha_inicio']."',fecha_fin='".$dato['fecha_fin']."',fec_act=NOW(),
                user_act=$id_usuario WHERE id_bimestre='".$dato['id_bimestre']."'";
        $this->db->query($sql);
    }

    function delete_c_bimestres($dato){
        $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
        $sql = "UPDATE bimestres SET estado=4,fec_eli=NOW(),user_eli=$id_usuario 
                WHERE id_bimestre='".$dato['id_bimestre']."'";
        $this->db->query($sql);
    }
}