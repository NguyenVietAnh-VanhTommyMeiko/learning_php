<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "student_management";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Thiết lập font chữ tiếng Việt
mysqli_set_charset($conn, "utf8mb4");
?>