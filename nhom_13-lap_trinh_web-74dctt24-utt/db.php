<?php
$host = "localhost";
$user = "root";
$pass = ""; // Mặc định XAMPP để trống
$dbname = "student_management"; // THAY ĐỔI THEO TÊN DB CỦA BẠN

$conn = new mysqli($host, $user, $pass, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Cấu hình tiếng Việt
$conn->set_charset("utf8mb4");
?>