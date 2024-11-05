<?php
require_once 'Database.php';
require_once 'Company.php';
require_once 'header.html';

$db = new Database();
$company = new Company($db);

// إضافة شركة جديدة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_company'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $company->addCompany($name, $location);
    header("Location: company_management.php");
    exit();
}

// تعديل شركة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_company'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $company->updateCompany($id, $name, $location);
    header("Location: company_management.php");
    exit();
}

// حذف شركة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_company'])) {
    $id = $_POST['id'];
    $company->deleteCompany($id);
    header("Location: company_management.php");
    exit();
}

// الحصول على قائمة الشركات
$companies = $company->getAllCompanies();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الشركات</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>إدارة الشركات</h2>
    
    <!-- عرض الشركات في جدول -->
    <table class="table">
        <thead>
            <tr>
                <th>اسم الشركة</th>
                <th>الموقع</th>
                <th>تعديل / حذف</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($companies as $company): ?>
                <tr>
                    <td><?= htmlspecialchars($company['name']) ?></td>
                    <td><?= htmlspecialchars($company['location']) ?></td>
                    <td>
                        <form action="company_management.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?= $company['id'] ?>">
                            <button type="button" onclick="fillEditForm(<?= $company['id'] ?>, '<?= $company['name'] ?>', '<?= $company['location'] ?>')" class="btn btn-warning">تعديل</button>
                        </form>
                        <form action="company_management.php" method="POST" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?= $company['id'] ?>">
                            <button type="submit" name="delete_company" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- نموذج إضافة شركة جديدة -->
    <h3>إضافة شركة جديدة</h3>
    <form action="company_management.php" method="POST">
        <div class="form-group">
            <label for="name">اسم الشركة</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="location">الموقع</label>
            <input type="text" id="location" name="location" required>
        </div>
        <button type="submit" name="add_company" class="btn btn-primary">إضافة</button>
    </form>

    <!-- نموذج تعديل شركة -->
    <div id="editCompanyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>تعديل شركة</h3>
            <form action="company_management.php" method="POST">
                <input type="hidden" id="edit_id" name="id">
                <div class="form-group">
                    <label for="edit_name">اسم الشركة</label>
                    <input type="text" id="edit_name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="edit_location">الموقع</label>
                    <input type="text" id="edit_location" name="location" required>
                </div>
                <button type="submit" name="edit_company" class="btn btn-success">حفظ التعديلات</button>
            </form>
        </div>
    </div>
</div>

<script>
    function fillEditForm(id, name, location) {
        document.getElementById("edit_id").value = id;
        document.getElementById("edit_name").value = name;
        document.getElementById("edit_location").value = location;
        document.getElementById("editCompanyModal").style.display = "block";
    }

    function closeEditModal() {
        document.getElementById("editCompanyModal").style.display = "none";
    }
</script>
</body>
</html>
