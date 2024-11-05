<?php 
include_once 'Trainee.php';
include_once 'header.html';

$trainee = new Trainee();

// الحصول على المتدربين المعتمدين
$approvedTrainees = $trainee->getApprovedTrainees();
$approvedCount = $approvedTrainees ? mysqli_num_rows($approvedTrainees) : 0;

// الحصول على عدد المتدربين غير المعتمدين
$pendingTrainees = $trainee->getPendingTrainees();
$pendingCount = $pendingTrainees ? mysqli_num_rows($pendingTrainees) : 0;

// الحصول على عدد المتدربين المستبعدين
$excludedTrainees = $trainee->getExcludedTraineesGroupedByCompany();
$excludedCount = 0;
foreach ($excludedTrainees as $company) {
    $excludedCount += count($company);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إحصائيات المتدربين</title>
    <style>


        .container {
            width: 70%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        .statistics {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .stat-card {
            background-color: #28a745; /* لون أخضر */
            color: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 28%; /* حجم مناسب */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            cursor: pointer; /* يظهر أن العنصر قابل للنقر */
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background-color: #218838; /* لون أخضر أغمق عند التحويم */
        }

        .stat-card h2 {
            font-size: 1.25em; /* حجم مناسب */
            margin: 0;
        }

        .count {
            font-size: 2em; /* حجم مناسب */
            margin: 10px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>إحصائيات المتدربين</h1>
        <div class="statistics">
            <div class="stat-card">
                <h2>عدد المتدربين المعتمدين</h2>
                <p class="count"><?php echo $approvedCount; ?></p>
            </div>
            <div class="stat-card">
                <h2>عدد المتدربين غير المعتمدين</h2>
                <p class="count"><?php echo $pendingCount; ?></p>
            </div>
            <div class="stat-card">
                <h2>عدد المتدربين المستبعدين</h2>
                <p class="count"><?php echo $excludedCount; ?></p>
            </div>
            <br>
            <div class="statistics stat-card">
                <a style="text-decoration: none; color:white; text-align:center;" href="dashboard.php"><h2>المزيد  </h2></a>
                
            </div>
        </div>
    </div>
</body>
</html>
