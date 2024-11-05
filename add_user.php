<?php
include 'header.html';
include_once 'Database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // تشفير كلمة المرور
    $role = $_POST['role'];

    $sql = "INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)";
    
        $stmt = $db->query($sql,["ssss", $name, $email, $password, $role]);
 
    echo "تم إضافة المستخدم بنجاح";
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة مستخدم جديد</title>
</head>
<body>
<div class="container">
    <h2>إضافة مستخدم جديد</h2>
    <form method="POST" action="add_user.php">
        <label>الاسم:</label>
        <input type="text" name="name" required><br>
        <label>البريد الإلكتروني:</label>
        <input type="email" name="email" required><br>
        <label>كلمة المرور:</label>
        <input type="password" name="password" required><br>
        <label>الدور:</label>
        <select name="role">
            <option value="1">مدير</option>
            <option value="2">مدرب</option>
            <option value="3">مستخدم</option>
        </select><br>
        <button type="submit">إضافة</button>
    </form>
</div>
</body>
</html>
