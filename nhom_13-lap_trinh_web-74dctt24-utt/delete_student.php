<?php
// delete_student.php
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Dùng prepared statement để xóa
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Có lỗi xảy ra khi xóa.";
    }
    $stmt->close();
} else {
    header("Location: dashboard.php");
}
?>