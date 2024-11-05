<?php
include_once 'Database.php';

class Company {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // دالة للحصول على جميع الشركات
    public function getAllCompanies() {
        $query = "SELECT  id,name,code,location FROM companies"; // افترض وجود حقل company_name في جدول المتدربين
       return $stmt = $this->db->query($query);
        // $stmt->execute();
        //   $stmt->getresult();
    }
    public function getTotalCompaniesCount() {
        $sql = "SELECT COUNT(*) AS total FROM companies";
        $result = $this->db->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // يمكنك إضافة دوال أخرى تخص الشركات هنا

    public function addCompany($name, $location) {
        $sql = "INSERT INTO companies (name, location) VALUES (?, ?)";
        $params = ["ss", $name, $location];
        $this->db->query($sql, $params);
    }

    public function updateCompany($id, $name, $location) {
        $sql = "UPDATE companies SET name = ?, location = ? WHERE id = ?";
        $params = ["ssi", $name, $location, $id];
        $this->db->query($sql, $params);
    }

    public function deleteCompany($id) {
        $sql = "DELETE FROM companies WHERE id = ?";
        $params = ["i", $id];
        $this->db->query($sql, $params);
    }

}
