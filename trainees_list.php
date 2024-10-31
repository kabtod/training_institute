<?php
require_once 'Database.php';
require_once 'Trainee.php';
require_once 'Company.php'; // استيراد كلاس الشركات

// إنشاء اتصال بقاعدة البيانات
$db = new Database();
$trainee = new Trainee($db);
$company = new Company($db); // إنشاء كائن من كلاس الشركات

// الحصول على قائمة الشركات
$companies = $company->getAllCompanies();

$currentTrainees = [];
$excludedTrainees = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['company'])) {
    $selectedCompany = $_POST['company'];

    // الحصول على المتدربين المعتمدين لشركة مختارة
    $currentTrainees = $trainee->getCurrentTraineesByCompany($selectedCompany);
    
    // الحصول على المتدربين المستبعدين لشركة مختارة
    $excludedTrainees = $trainee->getExcludedTraineesByCompany($selectedCompany);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المتدربين</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        h3 {
            color: #007bff;
            margin-top: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
    <h2>اختر شركة لعرض المتدربين</h2>
    <form method="POST">
        <select name="company">
            <option value="">اختر شركة</option>
            <?php foreach ($companies as $company_name): ?>
                <option value="<?php echo htmlspecialchars($company_name); ?>"><?php echo htmlspecialchars($company_name); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="عرض المتدربين">
    </form>

    <?php if (!empty($currentTrainees) || !empty($excludedTrainees)): ?>
        <h2>المتدربون المعتمدون</h2>
        <?php if (!empty($currentTrainees)): ?>
            <h3><?php echo htmlspecialchars($selectedCompany); ?></h3>
            <ul>
                <?php foreach ($currentTrainees as $trainee_name): ?>
                    <li><?php echo htmlspecialchars($trainee_name); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>لا توجد متدربين معتمدين لهذه الشركة.</p>
        <?php endif; ?>

        <h2>المتدربون المستبعدين</h2>
        <?php if (!empty($excludedTrainees)): ?>
            <h3><?php echo htmlspecialchars($selectedCompany); ?></h3>
            <ul>
                <?php foreach ($excludedTrainees as $trainee_info): ?>
                    <li>
                        <?php echo htmlspecialchars($trainee_info['name']); ?> - سبب الاستبعاد: <?php echo htmlspecialchars($trainee_info['reason']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>لا توجد متدربين مستبعدين لهذه الشركة.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// إنهاء الاتصال بقاعدة البيانات
$conn = null;
?>
