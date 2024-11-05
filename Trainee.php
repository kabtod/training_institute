<?php 
include_once 'Database.php';
class Trainee {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function getAllTrainees() {
        $sql = "
            SELECT t.stdid, t.name, c.name AS company, t.status, t.email, t.phone 
            FROM trainees t
            LEFT JOIN companies c ON t.company_id = c.id
        ";
        $result = $this->db->query($sql);

        $trainees = [];
        while ($row = $result->fetch_assoc()) {
            $trainees[] = $row;
        }
        
        return $trainees;
    }

    // دالة تسجيل متدرب
    public function registerTrainee($name, $email, $company_id, $stdid, $jobtitle, $branch) {
        // الحصول على تاريخ التسجيل الحالي
        $registration_date = date('Y-m-d');
    
        // إعداد استعلام SQL لإدخال بيانات المتدرب مع الحقول الجديدة
        $sql = "INSERT INTO trainees (name, email, company_id, stdid, jobtitle, branch, status, registration_date) 
                VALUES (?, ?, ?, ?, ?, ?, 'غير معتمد', ?)";
        $params = ["ssssssi", $name, $email, $company_id, $stdid, $jobtitle, $branch, $registration_date];
        $this->db->query($sql, $params);
    }
    

    // دالة الحصول على المتدربين غير المعتمدين
    public function getPendingTrainees() {
        $sql = "SELECT * FROM trainees WHERE status = 'غير معتمد'";
        return $this->db->query($sql);
    }

    // دالة اعتماد متدرب
    public function approveTrainee($trainee_id) {
        $sql = "UPDATE trainees SET status = 'معتمد' WHERE id = ?";
        $params = ["i", $trainee_id];
        $this->db->query($sql, $params);
    }

    // دالة استبعاد متدرب
    public function excludeTrainee($trainee_id, $reason, $status,$date_of_ex) {
        $sql = "UPDATE trainees SET status = ?, reason_for_exclusion = ?,date_of_ex =? WHERE id = ?";
        $params = ["sssi", $status, $reason, $date_of_ex,$trainee_id];
        $this->db->query($sql, $params);
    }

    // دالة للحصول على المتدربين المعتمدين مصنفين حسب الشركة
    public function getCurrentTraineesGroupedByCompany($companyId = null) {
        // إعداد استعلام SQL لاسترجاع المتدربين مع المعلومات الجديدة
        $sql = "SELECT c.name AS company_name,
                       t.name AS trainee_name,
                       t.email,
                       t.stdid,
                       t.jobtitle,
                       t.branch,
                       t.registration_date
                FROM trainees t 
                JOIN companies c ON t.company_id = c.id 
                WHERE t.status = 'معتمد'";
        
        // إذا تم تمرير companyId، نضيف شرط للبحث في شركة معينة
        if ($companyId) {
            $sql .= " AND t.company_id = $companyId";
        }
    
        // تنفيذ الاستعلام
        $result = $this->db->query($sql);
        $groupedCurrentTrainees = [];
    
        // تنظيم البيانات حسب الشركة
        foreach ($result as $row) {
            $groupedCurrentTrainees[$row['company_name']][] = [
                'name' => $row['trainee_name'],
                'email' => $row['email'],
                'stdid' => $row['stdid'],           // إضافة رقم الهوية
                'jobtitle' => $row['jobtitle'],     // إضافة المسمى الوظيفي
                'branch' => $row['branch'],         // إضافة الفرع
                'registration_date' => $row['registration_date'] // إضافة تاريخ التسجيل
            ];
        }
    
        return $groupedCurrentTrainees;
    }
    
    // دالة للحصول على المتدربين المستبعدين مصنفين حسب الشركة
    public function getExcludedTraineesGroupedByCompany($company = null) {
        // جملة SQL الأساسية للحصول على المتدربين المستبعدين أو المستقيلين
        $sql = "SELECT c.name AS company_name,
                    t.stdid,
                       t.name AS trainee_name,
                       t.reason_for_exclusion AS reason,
                       t.email AS email,
                       t.status AS status,
                       t.date_of_ex
                FROM trainees t
                JOIN companies c ON t.company_id = c.id
                WHERE t.status IN ('مستبعد', 'مستقيل')";
    
        // إضافة شرط تصفية حسب معرف الشركة إذا كان موجودًا
        $params = [];
        if ($company !== null) {
            $sql .= " AND t.company_id = ?";
            $params = ["i", $company];
        }
    
        // تنفيذ الاستعلام
        $result = $this->db->query($sql, $params);
        $groupedExcludedTrainees = [];
    
        // تجميع النتائج حسب الشركة
        foreach ($result as $row) {
            $groupedExcludedTrainees[$row['company_name']][] = [
                'stdid' => $row['stdid'],
                'name' => $row['trainee_name'],
                'reason' => $row['reason'],
                'status' => $row['status'],
                'email' => $row['email'],
                'date_of_ex' => $row['date_of_ex'],
            ];
        }
    
        return $groupedExcludedTrainees;
    }
    

    // دالة للحصول على المتدربين المعتمدين
    public function getApprovedTrainees() {
        $sql = "SELECT * FROM trainees WHERE status = 'معتمد'";
        return $this->db->query($sql);
    }


    public function getTotalTraineesCount() {
        $sql = "SELECT COUNT(*) AS total FROM trainees";
        $result = $this->db->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // عدد المتدربين المعتمدين
    public function getApprovedTraineesCount() {
        $sql = "SELECT COUNT(*) AS total FROM trainees WHERE status = 'معتمد'";
        $result = $this->db->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // عدد المتدربين غير المعتمدين
    public function getUnapprovedTraineesCount() {
        $sql = "SELECT COUNT(*) AS total FROM trainees WHERE status = 'غير معتمد'";
        $result = $this->db->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // عدد المتدربين المستبعدين
    public function getExcludedTraineesCount() {
        $sql = "SELECT COUNT(*) AS total FROM trainees WHERE status = 'مستبعد'";
        $result = $this->db->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // دالة للتخلص من الموارد
    public function __destruct() {
        $this->db->close();
    }
}
?>
