<?php
include_once 'Database.php';
$db = new Database();

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $db;
    $stmt->query($sql,["i",$user_id]);
    
    header("Location: list_users.php");
    exit();
} else {
    echo "لا يوجد مستخدم لحذفه";
}
?>
