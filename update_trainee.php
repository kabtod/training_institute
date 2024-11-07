<?php
require_once 'Database.php';
require_once 'Trainee.php';

// تفعيل عرض الأخطاء لأغراض التصحيح
error_reporting(E_ALL);
ini_set('display_errors', 1);

// التأكد من أن البيانات تم إرسالها عبر POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // التحقق من وجود الحقول المطلوبة
    if (isset($_POST['stdid'], $_POST['name'], $_POST['company_id'], $_POST['status'], $_POST['email'], $_POST['phone'])) {
        $id = $_POST['stdid'];
        $name = $_POST['name'];
        $companyId = $_POST['company_id'];
        $status = $_POST['status'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // إنشاء اتصال بقاعدة البيانات وتحديث المتدرب
        $db = new Database();
        $trainee = new Trainee($db);

        // محاولة التحديث
        try {
            $trainee->updateTrainee($id, $name, $companyId, $status, $email, $phone);
            echo json_encode(['success' => true, 'message' => 'تم تحديث بيانات المتدرب بنجاح']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'يرجى التحقق من جميع الحقول المطلوبة']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'طلب غير صالح']);
}
?>
