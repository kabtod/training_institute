<?php
include 'header.html';
include_once 'Database.php';
$db = new Database();

$user_id = $_GET['id']; // ID المستخدم المطلوب تعديله
$user = $db->query("SELECT * FROM users WHERE id = ?", ["i", $user_id])->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    $sql = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $role, $user_id);
    $stmt->execute();
    echo "تم تعديل بيانات المستخدم بنجاح";
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل بيانات المستخدم</title>
</head>
<body>
<div class="container">
    <h2>تعديل بيانات المستخدم</h2>
    <form method="POST" action="edit_user.php?id=<?= $user_id ?>">
        <label>الاسم:</label>
        <input type="text" name="name" value="<?= $user['name'] ?>" required><br>
        <label>البريد الإلكتروني:</label>
        <input type="email" name="email" value="<?= $user['email'] ?>" required><br>
        <label>الدور:</label>
        <select name="role">
            <option value="admin" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>مدير</option>
            <option value="trainer" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>مدرب</option>
            <option value="user" <?= $user['role_id'] == 3 ? 'selected' : '' ?>>مستخدم</option>
        </select><br>
        <button type="submit">حفظ التعديلات</button>
    </form>
</div>
</body>
</html>
