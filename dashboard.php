<?php
session_start();
require_once 'Database.php';
require_once 'Trainee.php';
require_once 'Company.php';
require_once 'header.html';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// إنشاء كائنات الاتصال بقاعدة البيانات
$db = new Database();
$trainee = new Trainee($db);
$company = new Company($db);

// استرجاع الإحصائيات المطلوبة
$totalTrainees = $trainee->getTotalTraineesCount();
$approvedTrainees = $trainee->getApprovedTraineesCount();
$unapprovedTrainees = $trainee->getUnapprovedTraineesCount();
$excludedTrainees = $trainee->getExcludedTraineesCount();
$excludedTrainees2 = $trainee->getExcludedTraineesCount2();
$totalCompanies = $company->getTotalCompaniesCount();

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4"> إحصائيات</h2>

    <!-- إحصائيات المتدربين -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white p-3">
                <h5 class="card-title">إجمالي المتدربين</h5>
                <p class="card-text fs-4"><?= $totalTrainees ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white p-3">
                <h5 class="card-title">المتدربون المعتمدون</h5>
                <p class="card-text fs-4"><?= $approvedTrainees ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white p-3">
                <h5 class="card-title">المتدربون غير المعتمدين</h5>
                <p class="card-text fs-4"><?= $unapprovedTrainees ?></p>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-danger text-white p-3">
                <h5 class="card-title">المتدربون المستبعدين</h5>
                <p class="card-text fs-4"><?= $excludedTrainees ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white p-3">
                <h5 class="card-title">المتدربون المستقيلين</h5>
                <p class="card-text fs-4"><?= $excludedTrainees2 ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white p-3">
                <h5 class="card-title">إجمالي الشركات</h5>
                <p class="card-text fs-4"><?= $totalCompanies ?></p>
            </div>
        </div>
    </div>

    <!-- أزرار الوصول السريع -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <a href="trainee_management.php" class="btn btn-outline-primary w-100">إدارة المتدربين</a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="company_management.php" class="btn btn-outline-secondary w-100">إدارة الشركات</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
