<?php 
include 'Trainee.php';
include_once 'Database.php';
include_once 'header.html';

$trainee = new Trainee();
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    // استلام البيانات المدخلة من المستخدم
    $name = $_POST['name'];
    $email = $_POST['email'];
    $company_id = $_POST['company_id'];
    $stdid = $_POST['stdid'];
    $phone = $_POST['phone'];
    $phone2 = $_POST['phone2'];
    $jobtitle = $_POST['jobtitle'];
    $jobid = $_POST['jobid'];
    $qualif = $_POST['qualif'];
    $branch = $_POST['branch'];
    $status = $_POST['status'];
    $totaltime = $_POST['totaltime'];
    $registration_date = date('Y-m-d');
    $note = $_POST['note'];

    // تسجيل المتدرب
    $trainee->registerTrainee($name, $email, $company_id, $stdid, $phone, $phone2, $jobtitle, $jobid, $qualif, $branch, $status, $totaltime, $registration_date, $note);
    echo "تم تسجيل المتدرب بنجاح";
}

// استعلام لجلب الشركات
$companies = $db->query("SELECT id, name FROM companies");

// معالجة رفع ملف Excel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file'];
    if ($file['error'] === UPLOAD_ERR_OK && $file['type'] === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        $filePath = $file['tmp_name'];
        // استدعاء دالة استيراد بيانات Excel هنا
        $trainee->importFromExcel($filePath);
        echo '<div class="alert alert-success">تم استيراد البيانات بنجاح!</div>';
    } else {
        echo '<div class="alert alert-danger">الرجاء رفع ملف Excel صالح.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل المتدربين</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <style>
        .form-section { margin-bottom: 1.5em; }
        .form-group label { font-weight: bold; }
        h2, h3 { margin-bottom: 1.5em; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">تسجيل المتدربين</h2>

    <!-- نموذج تسجيل متدرب جديد -->
    <form action="register.php" method="POST">
        <div class="form-row form-section">
            <div class="form-group col-md-6">
                <label for="stdid">رقم الهوية</label>
                <input type="text" class="form-control" id="stdid" name="stdid" required>
            </div>
            <div class="form-group col-md-6">
                <label for="name">الاسم</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>

        <div class="form-row form-section">
            <div class="form-group col-md-6">
                <label for="phone">رقم الجوال</label>
                <input type="text" class="form-control" id="phone" name="phone" maxlength="10" required>
            </div>
            <div class="form-group col-md-6">
                <label for="phone2">رقم الجوال 2</label>
                <input type="text" class="form-control" id="phone2" name="phone2" maxlength="10">
            </div>
        </div>

        <div class="form-row form-section">
            <div class="form-group col-md-6">
                <label for="jobtitle">المسمى الوظيفي</label>
                <input type="text" class="form-control" id="jobtitle" name="jobtitle">
            </div>
            <div class="form-group col-md-6">
                <label for="jobid">الرقم الوظيفي</label>
                <input type="text" class="form-control" id="jobid" name="jobid">
            </div>
        </div>

        <div class="form-row form-section">
            <div class="form-group col-md-6">
                <label for="qualif">المؤهل</label>
                <select class="form-control" id="qualif" name="qualif">
                    <option value="ثانوي">ثانوي</option>
                    <option value="جامعي">جامعي</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="branch">الفرع</label>
                <select class="form-control" id="branch" name="branch">
                    <option value="خريص">خريص</option>
                    <option value="الشفا">الشفا</option>
                </select>
            </div>
        </div>

        <div class="form-row form-section">
            <div class="form-group col-md-6">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group col-md-6">
                <label for="company_id">الشركة</label>
                <select class="form-control" id="company_id" name="company_id" required>
                    <?php while ($company = $companies->fetch_assoc()): ?>
                        <option value="<?= $company['id'] ?>"><?= $company['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="form-row form-section">
            <div class="form-group col-md-6">
                <label for="status">الحالة</label>
                <select class="form-control" id="status" name="status">
                    <option value="غير معتمد">غير معتمد</option>
                    <option value="معتمد">معتمد</option>
                    <option value="مستبعد">مستبعد</option>
                    <option value="مستقيل">مستقيل</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="totaltime">مدة العقد</label>
                <select class="form-control" id="totaltime" name="totaltime">
                    <option value="6 اشهر">6 أشهر</option>
                    <option value="12 شهر">12 شهر</option>
                    <option value="24 شهر">24 شهر</option>
                </select>
            </div>
        </div>

        <div class="form-row form-section">
            <div class="form-group col-md-6">
                <label for="registration_date">تاريخ التسجيل</label>
                <input type="date" class="form-control" id="registration_date" name="registration_date" required>
            </div>
            <div class="form-group col-md-6">
                <label for="note">ملاحظات</label>
                <input type="text" class="form-control" id="note" name="note">
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">تسجيل المتدرب</button>
    </form>

    <!-- رفع ملف Excel -->
    <h3 class="text-center mt-4">استيراد متدربين من ملف Excel</h3>
    <form method="POST" action="register.php" enctype="multipart/form-data">
        <div class="form-group">
            <input type="file" class="form-control-file" name="excel_file" accept=".xlsx" required>
        </div>
        <button type="submit" class="btn btn-success btn-block">رفع الملف</button>
    </form>
</div>

</body>
</html>
