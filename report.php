<?php
include 'Trainee.php';
include 'Company.php';
include 'header.html';
$trainee = new Trainee();
$company = new Company(); // إنشاء كائن من كلاس الشركات

// الحصول على قائمة الشركات
$companies = $company->getAllCompanies();

// الحصول على قائمة الشركات والمتدربين الحاليين والمستبعدين
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['company'])) {
    $selectedCompany = $_POST['company'];

    // الحصول على المتدربين المعتمدين لشركة مختارة
    $currentTrainees = $trainee->getCurrentTraineesGroupedByCompany($selectedCompany);
    // الحصول على المتدربين المستبعدين لشركة مختارة
    $excludedTrainees = $trainee->getExcludedTraineesGroupedByCompany($selectedCompany);
} else {
    $currentTrainees = $trainee->getCurrentTraineesGroupedByCompany();
    $excludedTrainees = $trainee->getExcludedTraineesGroupedByCompany();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير الشركات</title>
</head>
<body>
<div class="container ">
    <h2>اختر شركة لعرض المتدربين</h2>
    <form method="POST">
        <select name="company" class="form-control" required>
            <option value="">اختر شركة</option>
            <?php foreach ($companies as $company_name): ?>
                <option value="<?php echo htmlspecialchars($company_name['id']); ?>"><?php echo htmlspecialchars($company_name['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" class="btn btn-primary mt-2" value="عرض المتدربين">
    </form>
    <h2>تقرير الشركات</h2>

    <?php foreach ($currentTrainees as $company => $trainees): ?>
        <h3>الشركة: <?= $company ?></h3>
        <h4>المتدربون الحاليون</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>رقم الهوية</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>المسمى الوظيفي</th>
                    <th>الفرع</th>
                    <th>تاريخ التسجيل</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trainees as $trainee): ?>
                    <tr>
                        <td><?= $trainee['stdid'] ?></td>
                        <td><?= $trainee['name'] ?></td>
                        <td><?= $trainee['email'] ?></td>
                        <td><?= $trainee['jobtitle'] ?></td>
                        <td><?= $trainee['branch'] ?></td>
                        <td><?= $trainee['registration_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>المتدربون المستبعدين أو المستقيلين</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>رقم الهوية</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الحالة</th>
                    <th>السبب</th>
                    <th>تاريخ الاستبعاد</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($excludedTrainees[$company])): ?>
                    <?php foreach ($excludedTrainees[$company] as $trainee): ?>
                        <tr>
                            <td><?= $trainee['stdid'] ?></td>
                            <td><?= $trainee['name'] ?></td>
                            <td><?= $trainee['email'] ?></td>
                            <td><?= $trainee['status'] ?></td>
                            <td><?= $trainee['reason'] ?></td>
                            <td><?= $trainee['date_of_ex'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">لا توجد بيانات</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>
</body>
</html>
