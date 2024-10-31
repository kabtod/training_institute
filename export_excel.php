<?php
require 'vendor/autoload.php'; // تحميل مكتبة PHPExcel
include 'Trainee.php';

$trainee = new Trainee();
$currentTrainees = $trainee->getCurrentTraineesGroupedByCompany();
$excludedTrainees = $trainee->getExcludedTraineesGroupedByCompany();

$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$row = 1;
foreach ($currentTrainees as $company => $trainees) {
    $sheet->setCellValue("A$row", "الشركة: $company");
    $row++;

    $sheet->setCellValue("A$row", "المتدربون الحاليون");
    $row++;
    $sheet->setCellValue("A$row", "الاسم");
    $sheet->setCellValue("B$row", "البريد الإلكتروني");
    $row++;

    foreach ($trainees as $trainee) {
        $sheet->setCellValue("A$row", $trainee['name']);
        $sheet->setCellValue("B$row", $trainee['email']);
        $row++;
    }

    $sheet->setCellValue("A$row", "المتدربون المستبعدين أو المستقيلين");
    $row++;
    $sheet->setCellValue("A$row", "الاسم");
    $sheet->setCellValue("B$row", "البريد الإلكتروني");
    $sheet->setCellValue("C$row", "السبب");
    $row++;

    if (isset($excludedTrainees[$company])) {
        foreach ($excludedTrainees[$company] as $trainee) {
            $sheet->setCellValue("A$row", $trainee['name']);
            $sheet->setCellValue("B$row", $trainee['email']);
            $sheet->setCellValue("C$row", $trainee['reason_for_exclusion']);
            $row++;
        }
    } else {
        $sheet->setCellValue("A$row", "لا توجد بيانات");
        $row++;
    }
    $row++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="report.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
?>
