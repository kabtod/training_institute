<?php
include 'Trainee.php';
$trainee = new Trainee();

// الحصول على قائمة الشركات والمتدربين الحاليين والمستبعدين
$currentTrainees = $trainee->getCurrentTraineesGroupedByCompany();
$excludedTrainees = $trainee->getExcludedTraineesGroupedByCompany();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تقرير الشركات</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>تقرير الشركات</h2>

    <?php foreach ($currentTrainees as $company => $trainees): ?>
        <h3>الشركة: <?= $company ?></h3>
        <h4>المتدربون الحاليون</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trainees as $trainee): ?>
                    <tr>
                        <td><?= $trainee['name'] ?></td>
                        <td><?= $trainee['email'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>المتدربون المستبعدين أو المستقيلين</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>السبب</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($excludedTrainees[$company])): ?>
                    <?php foreach ($excludedTrainees[$company] as $trainee): ?>
                        <tr>
                            <td><?= $trainee['name'] ?></td>
                            <td><?= $trainee['email'] ?></td>
                            <td><?= $trainee['reason_for_exclusion'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">لا توجد بيانات</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>
</body>
</html>
