<?php
include_once 'Trainee.php';

$trainee = new Trainee();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trainee_id = $_POST['trainee_id'];
    $reason = $_POST['reason'];
    $status = $_POST['status'];
    $trainee->excludeTrainee($trainee_id, $reason, $status);
    echo "تم تحديث حالة المتدرب بنجاح";
}

$approvedTrainees = $trainee->getApprovedTrainees();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الاستبعاد والاستقالة</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>إدارة الاستبعاد والاستقالة</h2>
    <table class="table">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الحالة</th>
                <th>السبب</th>
                <th>تحديث</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $approvedTrainees->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <form action="exclude.php" method="POST">
                        <input type="hidden" name="trainee_id" value="<?= $row['id'] ?>">
                        <select name="status" class="form-control">
                            <option value="مستبعد">استبعاد</option>
                            <option value="مستقيل">استقالة</option>
                        </select>
                </td>
                <td><input type="text" name="reason" class="form-control" required></td>
                <td><button type="submit" class="btn btn-danger">تحديث</button></form></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
