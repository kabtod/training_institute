<?php
require_once 'Database.php';
require_once 'Trainee.php';
require_once 'header.html';

// إنشاء اتصال بقاعدة البيانات
$db = new Database();

$trainee = new Trainee($db);

// الحصول على المتدربين المعتمدين مصنفين حسب الشركة
$currentTrainees = $trainee->getCurrentTraineesGroupedByCompany();

// الحصول على المتدربين المستبعدين مصنفين حسب الشركة
$excludedTrainees = $trainee->getExcludedTraineesGroupedByCompany();

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المتدربين</title>
    <style>



        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        h3 {
            color: #007bff;
            margin-top: 20px;
        }

       .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>المتدربون المعتمدون</h2>
    <?php foreach ($currentTrainees as $company => $trainees): ?>
        <h3><?php //echo ($company); ?></h3>
        <ul>
            <?php foreach ($trainees as $trainee_name): ?>
                <li><?php echo $trainee_name['name'].$trainee_name['stdid'].'======'.$company; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

    <h2>المتدربون المستبعدين</h2>
    <?php foreach ($excludedTrainees as $company => $trainees): ?>
        <h3><?php echo ($company); ?></h3>
        <ul>
            <?php foreach ($trainees as $trainee_info): ?>
                <li>
                    <?php echo ($trainee_info['name']); ?> - سبب الاستبعاد: <?php echo ($trainee_info['reason']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</div>

</body>
</html>

<?php
// إنهاء الاتصال بقاعدة البيانات
$conn = null;
?>
