<?php
include_once 'Trainee.php';

$trainee = new Trainee();

// استلام المتغيرات من الـ AJAX
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// استخدام دالة البحث المتقدمة مع الفلاتر
$trainees = $trainee->getAllTrainees();

$filteredTrainees = [];

foreach ($trainees as $row) {
    // تحقق من النص المدخل في البحث
    if ((!empty($searchQuery) && stripos($row['name'], $searchQuery) !== false) || 
        (!empty($searchQuery) && stripos($row['email'], $searchQuery) !== false)) {

        // تحقق من حالة المتدرب
        if (empty($statusFilter) || $row['status'] == $statusFilter) {
            $filteredTrainees[] = $row;
        }
    }
}

// إذا كانت النتائج موجودة
if (count($filteredTrainees) > 0) {
    foreach ($filteredTrainees as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>";
        echo "<select class='form-control statusSelect' data-id='" . $row['stdid'] . "'>";
        echo "<option value='معتمد'" . ($row['status'] == 'معتمد' ? ' selected' : '') . ">معتمد</option>";
        echo "<option value='مستبعد'" . ($row['status'] == 'مستبعد' ? ' selected' : '') . ">مستبعد</option>";
        echo "<option value='مستقيل'" . ($row['status'] == 'مستقيل' ? ' selected' : '') . ">مستقيل</option>";
        echo "</select>";
        echo "</td>";

        // إظهار حقل السبب فقط إذا كانت الحالة مستبعد أو مستقيل
        if ($row['status'] == 'مستبعد' || $row['status'] == 'مستقيل') {
            echo "<td><input type='text' class='form-control reasonInput' data-id='" . $row['stdid'] . "' value='" . htmlspecialchars($row['reason_for_exclusion']) . "'></td>";
        } else {
            echo "<td><input type='text' class='form-control reasonInput' data-id='" . $row['stdid'] . "' value=''></td>";
        }

        echo "<td><button type='button' class='btn btn-success'>تحديث</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>لا توجد نتائج لعرضها.</td></tr>";
}
?>
