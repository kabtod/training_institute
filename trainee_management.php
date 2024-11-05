<?php
session_start();
require_once 'Database.php';
require_once 'Trainee.php';
require_once 'header.html';

// التحقق من دور المستخدم (يجب أن يكون مسؤول للوصول إلى هذه الصفحة)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 1) {
    header("Location: login.php");
    exit();
}

$db = new Database();
$trainee = new Trainee($db);

// الحصول على كل المتدربين
$sql = "SELECT * FROM trainees";
$trainees = $db->query($sql)->fetch_all(MYSQLI_ASSOC);

// التحقق من طلبات التعديل والحذف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        // تحديث بيانات المتدرب
        $id = $_POST['trainee_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $jobtitle = $_POST['jobtitle'];
        $branch = $_POST['branch'];
        $status = $_POST['status'];
        $updateSql = "UPDATE trainees SET name = ?, email = ?, jobtitle = ?, branch = ?, status = ? WHERE id = ?";
        $db->query($updateSql, ["sssssi", $name, $email, $jobtitle, $branch, $status, $id]);
        header("Location: trainee_management.php"); // إعادة تحميل الصفحة بعد التحديث
        exit();
    } elseif (isset($_POST['delete'])) {
        // حذف المتدرب
        $id = $_POST['trainee_id'];
        $deleteSql = "DELETE FROM trainees WHERE id = ?";
        $db->query($deleteSql, ["i", $id]);
        header("Location: trainee_management.php"); // إعادة تحميل الصفحة بعد الحذف
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المتدربين</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">إدارة المتدربين</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>المسمى الوظيفي</th>
                <th>الفرع</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trainees as $trainee): ?>
                <tr>
                    <form method="POST" action="trainee_management.php">
                        <td>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($trainee['name']) ?>">
                        </td>
                        <td>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($trainee['email']) ?>">
                        </td>
                        <td>
                            <input type="text" name="jobtitle" class="form-control" value="<?= htmlspecialchars($trainee['jobtitle']) ?>">
                        </td>
                        <td>
                            <input type="text" name="branch" class="form-control" value="<?= htmlspecialchars($trainee['branch']) ?>">
                        </td>
                        <td>
                            <select name="status" class="form-select">
                                <option value="معتمد" <?= $trainee['status'] === 'معتمد' ? 'selected' : '' ?>>معتمد</option>
                                <option value="غير معتمد" <?= $trainee['status'] === 'غير معتمد' ? 'selected' : '' ?>>غير معتمد</option>
                                <option value="مستبعد" <?= $trainee['status'] === 'مستبعد' ? 'selected' : '' ?>>مستبعد</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="trainee_id" value="<?= $trainee['id'] ?>">
                            <button type="submit" name="edit" class="btn btn-success btn-sm">تعديل</button>
                            <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا المتدرب؟')">حذف</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
