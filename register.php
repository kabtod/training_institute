<?php 
include 'Trainee.php';
include_once 'Database.php';
include_once 'header.html';

$trainee = new Trainee();
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // استلام البيانات المدخلة من المستخدم
    $name = $_POST['name'];
    $email = $_POST['email'];
    $company_id = $_POST['company_id'];
    $stdid = $_POST['stdid']; // حقل رقم الهوية
    $jobtitle = $_POST['jobtitle']; // حقل المسمى الوظيفي
    $branch = $_POST['branch']; // حقل الفرع

    // إضافة تاريخ التسجيل بشكل تلقائي
    $registration_date = date('Y-m-d');

    // تسجيل المتدرب
    $trainee->registerTrainee($name, $email, $company_id, $stdid, $jobtitle, $BRANCH, $registration_date);
    echo "تم تسجيل المتدرب بنجاح";
}

// استعلام لجلب الشركات
$companies = $db->query("SELECT id, name FROM companies");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل المتدربين</title>
</head>
<body>
<div class="container">
    <h2>تسجيل المتدربين</h2>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="stdid">رقم الهوية</label>
            <input type="text" class="form-control" id="stdid" name="stdid" required>
        </div>
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="jobtitle">المسمى الوظيفي</label>
            <input type="text" class="form-control" id="jobtitle" name="jobtitle" required>
        </div>
        <div class="form-group">
            <label for="branch">الفرع</label>
            <select class="form-control" id="branch" name="branch" required>
            <option value="الشقا">الشفا</option>
            <option value="خريص">خريص</option>

            </select>
        </div>
        <div class="form-group">
            <label for="company">الشركة</label>
            <select class="form-control" id="company" name="company_id" required>
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
