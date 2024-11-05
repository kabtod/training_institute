<?php 
require_once 'Database.php';
require_once 'Trainee.php';
require_once 'header.html';

// إنشاء اتصال بقاعدة البيانات
$db = new Database();
$trainee = new Trainee($db);

// الحصول على جميع المتدربين، سواء المعتمدين أو المستبعدين
$trainees = $trainee->getAllTrainees();

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المتدربين</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table-container { max-width: 1000px; margin: auto; padding-top: 20px; }
        .search-box { margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container table-container">
    <h2 class="text-center">قائمة المتدربين</h2>
    
    <!-- مربع البحث السريع -->
    <div class="search-box">
        <input type="text" id="searchInput" class="form-control" placeholder="ابحث عن متدرب...">
    </div>
    
    <!-- جدول المتدربين -->
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>رقم الطالب</th>
                <th>الاسم</th>
                <th>الشركة</th>
                <th>الحالة</th>
                <th>البريد الإلكتروني</th>
                <th>رقم الهاتف</th>
                <th>خيارات</th>
            </tr>
        </thead>
        <tbody id="traineeTable">
            <?php foreach ($trainees as $trainee): ?>
            <tr>
                <td><?php echo htmlspecialchars($trainee['stdid']); ?></td>
                <td><?php echo htmlspecialchars($trainee['name']); ?></td>
                <td><?php echo htmlspecialchars($trainee['company']); ?></td>
                <td><?php echo $trainee['status'] ; ?></td>
                <td><?php echo htmlspecialchars($trainee['email']); ?></td>
                <td><?php echo htmlspecialchars($trainee['phone']); ?></td>
                <td>
                    <a href="edit_trainee.php?id=<?php echo $trainee['stdid']; ?>" class="btn btn-warning btn-sm">تعديل</a>
                    <a href="delete_trainee.php?id=<?php echo $trainee['stdid']; ?>" class="btn btn-danger btn-sm">حذف</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// وظيفة البحث السريع
$(document).ready(function(){
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#traineeTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

</body>
</html>
