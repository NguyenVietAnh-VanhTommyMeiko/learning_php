<?php
session_start();
// Chú ý: Sử dụng db.php để đồng bộ với file students.php của bạn
require_once 'db.php'; 

// 1. Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    // header("Location: index.php"); exit();
}

// 2. Xử lý lưu sinh viên mới
if (isset($_POST['save_student'])) {
    // Lấy dữ liệu từ Form
    $id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $name = mysqli_real_escape_string($conn, $_POST['student_name']);

    // SQL INSERT: Chỉ chèn vào 2 cột student_id và student_name để khớp với yêu cầu tối giản
    $sql = "INSERT INTO students (student_id, student_name) VALUES ('$id', '$name')";
    
    if (mysqli_query($conn, $sql)) {
        // Chèn thành công thì quay về trang danh sách
        header("Location: students.php?msg=added");
        exit();
    } else {
        $error = "Lỗi khi thêm: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Thêm sinh viên mới</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="main-content">
        <div class="container" style="max-width: 500px; margin: 40px auto; padding: 25px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; color: #333;">THÊM SINH VIÊN MỚI</h2>
            
            <?php if(isset($error)): ?>
                <div style="color: red; background: #fee; padding: 10px; border-radius: 4px; margin-bottom: 15px;"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mã sinh viên:</label>
                    <input type="text" name="student_id" placeholder="Ví dụ: SV001" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Họ và tên:</label>
                    <input type="text" name="student_name" placeholder="Nhập đầy đủ họ tên" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="text-align: center; margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
                    <button type="submit" name="save_student" style="padding: 10px 25px; background: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold;">Lưu thông tin</button>
                    <a href="students.php" style="padding: 10px 25px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Hủy bỏ</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>