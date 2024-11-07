<?php
include_once 'Trainee.php';
include_once 'header.html';

$trainee = new Trainee();

// التحقق من حالة الـ POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // استلام القيم من النموذج (التحديث)
    if (isset($_POST['trainee_id'])) {
        $trainee_id = $_POST['trainee_id'];
        $reason = $_POST['reason'];
        $status = $_POST['status'];
        $date_of_ex = $_POST['date_of_ex'];

        // استبعاد أو تغيير حالة المتدرب
        $trainee->excludeTrainee($trainee_id, $reason, $status, $date_of_ex);
        echo "<p>تم تحديث حالة المتدرب بنجاح!</p>";
    } elseif (isset($_POST['search_query'])) {
        // عملية البحث إذا تم إرسال استعلام بحث
        $search_query = $_POST['search_query'];
        $approvedTrainees = $trainee->searchAndFilterTrainees($search_query);
    }
}

// عرض جميع المتدربين المعتمدين بشكل افتراضي أو نتائج البحث إذا كانت موجودة
if (!isset($approvedTrainees)) {
    $approvedTrainees = $trainee->getApprovedTrainees();
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الاستبعاد والاستقالة</title>
</head>
<body>
<div class="container mt-5">
    <h2>إدارة الاستبعاد والاستقالة</h2>

    <!-- نموذج البحث -->
    <form action="exclude.php" method="POST" class="mb-3">
        <input type="text" name="search_query" class="form-control" placeholder="ابحث عن المتدربين بالاسم..." required>
        <button type="submit" class="btn btn-primary mt-2">بحث</button>
    </form>

    <!-- جدول المتدربين المعتمدين -->
    <table class="table">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الحالة</th>
                <th>السبب</th>
                <th>تحديث</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $approvedTrainees->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <form action="exclude.php" method="POST">
                        <!-- تضمين ID المتدرب كـ hidden field -->
                        <input type="hidden" name="trainee_id" value="<?= $row['id'] ?>">

                        <!-- قائمة منسدلة لاختيار الحالة (مستبعد أو مستقيل) -->
                        <select name="status" class="form-control">
                            <option value="مستبعد" <?= $row['status'] == 'مستبعد' ? 'selected' : '' ?>>استبعاد</option>
                            <option value="مستقيل" <?= $row['status'] == 'مستقيل' ? 'selected' : '' ?>>استقالة</option>
                        </select>
                </td>

                <!-- حقل لإدخال السبب -->
                <td><input type="text" name="reason" class="form-control" required value="<?= $row['reason_for_exclusion'] ?>"></td>

                <!-- حقل يحتوي على التاريخ والوقت الحالي للاستبعاد أو الاستقالة -->
                <td><input type="hidden" name="date_of_ex" class="form-control" value="<?= date('Y-m-d H:i:s') ?>"></td>

                <!-- زر التحديث -->
                <td><button type="submit" class="btn btn-danger">تحديث</button></form></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
