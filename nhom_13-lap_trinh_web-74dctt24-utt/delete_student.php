<?php
session_start();
// 1. Đồng bộ file kết nối (Sử dụng db.php theo các file trước đó)
require_once 'db.php';

// 2. Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    die("Bạn không có quyền thực hiện hành động này.");
}

// 3. Kiểm tra và thực hiện xóa
if (isset($_GET['id'])) {
    // Sử dụng mysqli_real_escape_string để bảo mật SQL Injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // SỬA LỖI: Đổi tên cột từ 'id' thành 'student_id' cho khớp với Database
    $sql = "DELETE FROM students WHERE student_id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        // Chuyển hướng về trang students.php thay vì dashboard.php
        header("Location: students.php?msg=deleted");
        exit();
    } else {
        echo "Lỗi khi xóa sinh viên: " . mysqli_error($conn);
    }
} else {
    header("Location: students.php");
    exit();
}
?>