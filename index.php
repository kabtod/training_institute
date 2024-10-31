<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم معهد التدريب</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .dashboard-header { background-color: #343a40; color: #fff; padding: 10px; text-align: center; }
        .card { margin-bottom: 20px; }
        .container { padding-top: 30px; }
    </style>
</head>
<body>
    <header class="dashboard-header">
        <h1>لوحة تحكم معهد التدريب</h1>
        <p>مرحبًا بك في نظام إدارة التدريب الخاص بمعهدنا</p>
    </header>

    <div class="container">
        <div class="row">
            <!-- تسجيل متدربين -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-user-plus fa-3x text-primary"></i>
                        <h5 class="card-title mt-3">تسجيل متدرب</h5>
                        <p class="card-text">إضافة متدربين جدد من الشركات المتعاقدة</p>
                        <a href="register.php" class="btn btn-primary btn-block">ابدأ</a>
                    </div>
                </div>
            </div>
            
            <!-- اعتماد متدربين -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-success"></i>
                        <h5 class="card-title mt-3">اعتماد المتدربين</h5>
                        <p class="card-text">مراجعة واعتماد المتدربين الجدد</p>
                        <a href="approve.php" class="btn btn-success btn-block">ابدأ</a>
                    </div>
                </div>
            </div>

            <!-- إدارة الاستبعاد والاستقالة -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-user-slash fa-3x text-danger"></i>
                        <h5 class="card-title mt-3">استبعاد/استقالة</h5>
                        <p class="card-text">إدارة الاستبعادات والاستقالات للمتدربين</p>
                        <a href="exclude.php" class="btn btn-danger btn-block">ابدأ</a>
                    </div>
                </div>
            </div>

            <!-- توليد التقارير -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-3x text-info"></i>
                        <h5 class="card-title mt-3">توليد التقارير</h5>
                        <p class="card-text">توليد تقارير الحضور والاستبعاد لكل شركة</p>
                        <a href="report.php" class="btn btn-info btn-block">ابدأ</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- تصدير التقارير -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-file-export fa-3x text-warning"></i>
                        <h5 class="card-title mt-3">تصدير التقارير</h5>
                        <p class="card-text">تصدير التقارير بتنسيق Excel لسهولة المشاركة</p>
                        <a href="export.php" class="btn btn-warning btn-block">ابدأ</a>
                    </div>
                </div>
            </div>

            <!-- إحصائيات سريعة -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x text-secondary"></i>
                        <h5 class="card-title mt-3">إحصائيات سريعة</h5>
                        <p class="card-text">عرض الإحصائيات العامة للنظام</p>
                        <a href="statistics.php" class="btn btn-secondary btn-block">ابدأ</a>
                    </div>
                </div>
            </div>
            
            <!-- قائمة المتدربين -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-dark"></i>
                        <h5 class="card-title mt-3">قائمة المتدربين</h5>
                        <p class="card-text">عرض وتحديث بيانات المتدربين</p>
                        <a href="trainees_list.php" class="btn btn-dark btn-block">ابدأ</a>
                    </div>
                </div>
            </div>
            
            <!-- إدارة المستخدمين -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-user-cog fa-3x text-primary"></i>
                        <h5 class="card-title mt-3">إدارة المستخدمين</h5>
                        <p class="card-text">إضافة وتعديل صلاحيات المستخدمين</p>
                        <a href="user_management.php" class="btn btn-primary btn-block">ابدأ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
