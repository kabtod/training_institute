<?php
include_once 'Database.php';

class Company {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // دالة للحصول على جميع الشركات
    public function getAllCompanies() {
        $query = "SELECT  id,name FROM companies"; // افترض وجود حقل company_name في جدول المتدربين
      return  $stmt = $this->db->query($query);
        // $stmt->execute();
        //  $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // يمكنك إضافة دوال أخرى تخص الشركات هنا
}
