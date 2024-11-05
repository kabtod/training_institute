<?php 
require 'vendor/autoload.php';
require_once 'Database.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$db = new Database();
$conn = $db;

// استعلام لاسترجاع بيانات المتدربين لكل شركة، مرتبًا حسب الشركة والحالة
$sql = "SELECT c.name AS company_name, 
               t.name AS trainee_name, 
               t.email, 
               t.status, 
               t.reason_for_exclusion, 
               t.date_of_ex, 
               t.STDID, 
               t.JOBTITLE, 
               t.BRANCH 
        FROM trainees t 
        JOIN companies c ON t.company_id = c.id 
        ORDER BY c.name, FIELD(t.status, 'معتمد', 'مستبعد', 'مستقيل')";

$result = $conn->query($sql);

// إعداد مصفوفة لتخزين بيانات المتدربين حسب الشركة وحالتهم
$companyData = [];
foreach ($result as $row) {
    $companyData[$row['company_name']][$row['status']][] = [
        'name' => $row['trainee_name'],
        'email' => $row['email'],
        'status' => $row['status'],
        'date_of_ex' => $row['date_of_ex'],
        'reason' => $row['reason_for_exclusion'] ?? '',
        'id' => $row['STDID'],
        'jobtitle' => $row['JOBTITLE'],
        'branch' => $row['BRANCH'],
    ];
}

// إنشاء كائن Spreadsheet
$spreadsheet = new Spreadsheet();

$sheetIndex = 0;
foreach ($companyData as $companyName => $statuses) {
    if ($sheetIndex > 0) {
        $spreadsheet->createSheet();
    }
    $spreadsheet->setActiveSheetIndex($sheetIndex);
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle($companyName);

    // ضبط الاتجاه من اليمين إلى اليسار
    $sheet->setRightToLeft(true);

    // إعداد عناوين الأعمدة مع تنسيق وتلوين
    $headerStyle = [
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => 'FFB6D4E8'],
        ],
        'font' => [
            'bold' => true,
            'color' => ['argb' => Color::COLOR_BLACK],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
        ],
    ];

    // إعداد رؤوس الأعمدة
    $sheet->setCellValue('A1', 'رقم الهوية');
    $sheet->setCellValue('B1', 'اسم المتدرب');
    $sheet->setCellValue('C1', 'البريد الإلكتروني');
    $sheet->setCellValue('D1', 'المسمى الوظيفي');
    $sheet->setCellValue('E1', 'الفرع');
    $sheet->setCellValue('F1', 'الحالة');
    $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

    // جعل عرض الحقول احتوائيًا
    foreach (range('A', 'F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // تخصيص عرض العمود "اسم المتدرب" ليكون أكبر قليلاً
    $sheet->getColumnDimension('B')->setWidth(25);

    // إدخال بيانات المتدربين المعتمدين
    $row = 2;
    if (isset($statuses['معتمد'])) {
        foreach ($statuses['معتمد'] as $trainee) {
            $sheet->setCellValue("A$row", $trainee['id']);
            $sheet->setCellValue("B$row", $trainee['name']);
            $sheet->setCellValue("C$row", $trainee['email']);
            $sheet->setCellValue("D$row", $trainee['jobtitle']);
            $sheet->setCellValue("E$row", $trainee['branch']);
            $sheet->setCellValue("F$row", $trainee['status']);
            $row++;
        }
    }

    // دمج وتنسيق خلية العنوان للمتدربين المستبعدين أو المستقيلين
    $row += 2;
    $sheet->mergeCells("A$row:F$row");
    $sheet->setCellValue("A$row", "المتدربون المستبعدين أو المستقيلين");
    $sheet->getStyle("A$row:F$row")->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => 'FFF4CCCC'],
        ],
    ]);
    $row++;

    // إعداد رؤوس الأعمدة للمستبعدين والمستقيلين
    $sheet->setCellValue("A$row", "رقم الهوية");
    $sheet->setCellValue("B$row", "الاسم");
    $sheet->setCellValue("C$row", "البريد الإلكتروني");
    $sheet->setCellValue("D$row", "الحالة");
    $sheet->setCellValue("E$row", "السبب");
    $sheet->setCellValue("F$row", "تاريخ الاستبعاد");
    $sheet->getStyle("A$row:F$row")->applyFromArray($headerStyle);
    $row++;

    // إدخال بيانات المتدربين المستبعدين والمستقيلين
    foreach (['مستبعد', 'مستقيل'] as $status) {
        if (isset($statuses[$status])) {
            foreach ($statuses[$status] as $trainee) {
                $sheet->setCellValue("A$row", $trainee['id']);
                $sheet->setCellValue("B$row", $trainee['name']);
                $sheet->setCellValue("C$row", $trainee['email']);
                $sheet->setCellValue("D$row", $trainee['status']);
                $sheet->setCellValue("E$row", $trainee['reason']);
                $sheet->setCellValue("F$row", $trainee['date_of_ex']);
                $row++;
            }
        }
    }

    $sheetIndex++;
}

// تصدير الملف إلى Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="trainees_report.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
