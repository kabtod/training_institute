<?php
// الاتصال بقاعدة البيانات
include 'db_connect.php';

$company_id = $_GET['company_id'];

// جلب المتدربين الحاليين
$stmt = $conn->prepare("SELECT name, email FROM trainees WHERE company_id = ? AND status = 'معتمد'");
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>المتدربون الحاليون</h2>";
echo "<table border='1'>
<tr><th>الاسم</th><th>البريد الإلكتروني</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td></tr>";
}
echo "</table>";

// جلب المتدربين المستبعدين أو المستقيلين
$stmt = $conn->prepare("SELECT name, email, reason_for_exclusion, status FROM trainees WHERE company_id = ? AND (status = 'مستبعد' OR status = 'مستقيل')");
$stmt->bind_param("i", $company_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>المتدربون المستبعدون أو المستقيلون</h2>";
echo "<table border='1'>
<tr><th>الاسم</th><th>البريد الإلكتروني</th><th>الحالة</th><th>السبب</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['status']}</td><td>{$row['reason_for_exclusion']}</td></tr>";
}
echo "</table>";

$stmt->close();
?>
