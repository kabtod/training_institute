<?php
session_start();
include_once 'Database.php';
include_once 'header.html';

// التحقق من دور المستخدم (يجب أن يكون مسؤول للوصول إلى هذه الصفحة)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 1) {

    header("Location: login.php");
    exit();
}

$db = new Database();

// استعلام لجلب المستخدمين
$sql = "SELECT id, name, email, role_id FROM users";
$users = $db->query($sql)->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // تحديث دور المستخدم إذا تم إرسال طلب تعديل
    if (isset($_POST['user_id']) && isset($_POST['role_id'])) {
        $userId = $_POST['user_id'];
        $role_id = $_POST['role_id'];
        $updateSql = "UPDATE users SET role_id = ? WHERE id = ?";
        $db->query($updateSql, ["si", $role_id, $userId]);
        header("Location: user_management.php"); // إعادة تحميل الصفحة بعد التحديث
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4 text-center">إدارة المستخدمين</h2>

    <!-- جدول عرض المستخدمين -->
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الدور</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): echo $user['role_id'];?>
                
                <tr>
                    <td><?= htmlspecialchars($user['name']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['role_id']); ?></td>
                    <td>
                        <form method="POST" action="user_management.php" class="d-inline">
                            <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                            <select name="role_id" class="form-select d-inline w-60" onchange="this.form.submit()">
                                <option value="1" <?= $user['role_id'] === 1 ? 'selected' : ''; ?>>مسؤول</option>
                                <option value="2" <?= $user['role_id'] === 2 ? 'selected' : ''; ?>>مدرب</option>
                                <option value="3" <?= $user['role_id'] === 3 ? 'selected' : ''; ?>>متدرب</option>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- تضمين Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
