<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "training_institute";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
