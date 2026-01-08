<?php
session_start();
require_once 'db.php'; 

// 1. Kiểm tra quyền admin (Tùy chọn)
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    // header("Location: index.php"); 
    // exit();
}

// 2. Lấy ID sinh viên từ URL
if (!isset($_GET['student_id'])) {
    header("Location: students.php");
    exit();
}

$student_id = mysqli_real_escape_string($conn, $_GET['student_id']);

// 3. XỬ LÝ CẬP NHẬT
if (isset($_POST['update'])) {
    // Chỉ lấy trường 'name' vì form chỉ có ô này để sửa
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // SỬA LỖI: Xóa dấu phẩy thừa, sử dụng đúng biến $name và $student_id
    $sql_update = "UPDATE students SET 
                    student_name = '$name' 
                   WHERE student_id = '$student_id'";

    if (mysqli_query($conn, $sql_update)) {
        // Chuyển hướng về danh sách với thông báo thành công
        header("Location: students.php?msg=updated");
        exit();
    } else {
        $error = "Lỗi cập nhật: " . mysqli_error($conn);
    }
}

// 4. LẤY DỮ LIỆU ĐỂ HIỂN THỊ TRÊN FORM
// Truy vấn này giúp lấy thông tin hiện tại của sinh viên để đổ vào ô Input
$res = mysqli_query($conn, "SELECT * FROM students WHERE student_id = '$student_id'");
$s = mysqli_fetch_assoc($res);

if (!$s) {
    die("Lỗi: Không tìm thấy sinh viên có mã $student_id trong hệ thống.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Sửa thông tin sinh viên</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="main-content">
        <div class="container" style="max-width: 500px; margin: 40px auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; color: #333;">CHỈNH SỬA SINH VIÊN</h2>
            
            <?php if(isset($error)): ?>
                <div style="color: red; background: #fee; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mã sinh viên:</label>
                    <input type="text" value="<?= htmlspecialchars($s['student_id']) ?>" disabled style="background: #f4f4f4; width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; cursor: not-allowed;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Họ và tên:</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($s['student_name'] ?? '') ?>" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="text-align: center; margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
                    <button type="submit" name="update" style="padding: 10px 25px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold;">Cập nhật</button>
                    <a href="students.php" style="padding: 10px 25px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>