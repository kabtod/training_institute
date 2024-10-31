<?php
include 'Trainee.php';
include_once 'Database.php';

$trainee = new Trainee();
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $company_id = $_POST['company_id'];
    $trainee->registerTrainee($name, $email, $company_id);
    echo "تم تسجيل المتدرب بنجاح";
}

$companies = $db->query("SELECT id, name FROM companies");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل المتدربين</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>تسجيل المتدربين</h2>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="company">الشركة</label>
            <select class="form-control" id="company" name="company_id">
                <?php while ($company = $companies->fetch_assoc()): ?>
                    <option value="<?= $company['id'] ?>"><?= $company['name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">تسجيل</button>
    </form>
</div>
</body>
</html>
