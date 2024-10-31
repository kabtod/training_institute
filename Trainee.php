<?php 
include_once 'Database.php';

class Trainee {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // دالة تسجيل متدرب
    public function registerTrainee($name, $email, $company_id) {
        $sql = "INSERT INTO trainees (name, email, company_id, status) VALUES (?, ?, ?, 'غير معتمد')";
        $params = ["ssi", $name, $email, $company_id];
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
    public function excludeTrainee($trainee_id, $reason, $status) {
        $sql = "UPDATE trainees SET status = ?, reason_for_exclusion = ? WHERE id = ?";
        $params = ["ssi", $status, $reason, $trainee_id];
        $this->db->query($sql, $params);
    }

    // دالة للحصول على المتدربين المعتمدين مصنفين حسب الشركة
    public function getCurrentTraineesGroupedByCompany() {
        $sql = "SELECT c.name AS company_name, t.name AS trainee_name 
                FROM trainees t 
                JOIN companies c ON t.company_id = c.id 
                WHERE t.status = 'معتمد'";

        $result = $this->db->query($sql);
        $groupedTrainees = [];

        foreach ($result as $row) {
            $groupedTrainees[$row['company_name']][] = $row['trainee_name'];
        }

        return $groupedTrainees;
    }

    // دالة للحصول على المتدربين المستبعدين مصنفين حسب الشركة
    public function getExcludedTraineesGroupedByCompany() {
        $sql = "SELECT c.name AS company_name, t.name AS trainee_name, t.reason_for_exclusion 
                FROM trainees t 
                JOIN companies c ON t.company_id = c.id 
                WHERE t.status = 'مستبعد'";

        $result = $this->db->query($sql);
        $groupedExcludedTrainees = [];

        foreach ($result as $row) {
            $groupedExcludedTrainees[$row['company_name']][] = [
                'name' => $row['trainee_name'],
                'reason' => $row['reason_for_exclusion'],
            ];
        }

        return $groupedExcludedTrainees;
    }

    // دالة للحصول على المتدربين المعتمدين
    public function getApprovedTrainees() {
        $sql = "SELECT * FROM trainees WHERE status = 'معتمد'";
        return $this->db->query($sql);
    }

    // دالة للتخلص من الموارد
    public function __destruct() {
        $this->db->close();
    }
}
?>
