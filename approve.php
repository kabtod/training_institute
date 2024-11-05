<?php
include_once 'header.html';
include_once 'Trainee.php';

$trainee = new Trainee();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trainee_id = $_POST['trainee_id'];
    $trainee->approveTrainee($trainee_id);
    echo "تم اعتماد المتدرب بنجاح";
}

$pendingTrainees = $trainee->getPendingTrainees();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>اعتماد المتدربين</title>
</head>
<body>
<div class="container mt-5">
    <h2>اعتماد المتدربين</h2>
    <table class="table">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>اعتماد</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $pendingTrainees->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <form action="approve.php" method="POST">
                        <input type="hidden" name="trainee_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn btn-success">اعتماد</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
