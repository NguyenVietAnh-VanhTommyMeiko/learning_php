<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "nhom_13-ltw-utt-quanlythongtinsinhvien";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>