<?php
include 'header.html';
include_once 'Database.php';
$db = new Database();

$users = $db->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة المستخدمين</title>
</head>
<body>
<div class="container">
    <h2>قائمة المستخدمين</h2>
    <table border="1">
        <tr>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الدور</th>
            <th>إجراءات</th>
        </tr>
        <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role_id'] ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $user['id'] ?>">تعديل</a>
                    <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
