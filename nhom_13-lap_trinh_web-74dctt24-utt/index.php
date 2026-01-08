<?php
session_start();
require_once 'db.php'; 

// 1. SỬA LỖI: Class SimpleXLSX not found
// Kiểm tra sự tồn tại của file thư viện trước khi load
if (file_exists("SimpleXLSX.php")) {
    require_once "SimpleXLSX.php";
} else {
    die("<b style='color:red'>Lỗi:</b> Không tìm thấy file <b>SimpleXLSX.php</b>. Hãy tải thư viện này và bỏ vào thư mục dự án.");
}

// Xác định quyền hạn (Admin: full, Student: xem)
$role = $_SESSION['user']['role'] ?? 'student'; 
$msg = "";

/************* 2. XỬ LÝ IMPORT (Chỉ dành cho Admin) *************/
if (isset($_POST["btn_import"]) && $role === "admin") {
    if (isset($_FILES["excel_file"]) && $_FILES["excel_file"]["error"] == 0) {
        
        // Kiểm tra class có thuộc Namespace Shuchkin hay không
        if (class_exists('Shuchkin\SimpleXLSX')) {
            $xlsx = Shuchkin\SimpleXLSX::parse($_FILES["excel_file"]["tmp_name"]);
        } else if (class_exists('SimpleXLSX')) {
            $xlsx = SimpleXLSX::parse($_FILES["excel_file"]["tmp_name"]);
        } else {
            $xlsx = false;
        }

        if ($xlsx) {
            foreach ($xlsx->rows() as $index => $row) {
                if ($index == 0) continue; // Bỏ qua dòng tiêu đề Excel
                
                $s_name = mysqli_real_escape_string($conn, $row[0]);
                $s_id   = mysqli_real_escape_string($conn, $row[1]);
                $sub_id = mysqli_real_escape_string($conn, $row[2]);
                $score  = (float)$row[3];

                // Cập nhật bảng sinh viên
                mysqli_query($conn, "INSERT INTO students (student_id, student_name) 
                                     VALUES ('$s_id', '$s_name') 
                                     ON DUPLICATE KEY UPDATE student_name='$s_name'");
                
                // Cập nhật bảng điểm (Bỏ cột gpa để tránh lỗi Unknown column)
                mysqli_query($conn, "INSERT INTO scores (student_id, subject_id, score) 
                                     VALUES ('$s_id', '$sub_id', $score) 
                                     ON DUPLICATE KEY UPDATE score=$score");
            }
            $msg = "✅ Đã cập nhật dữ liệu thành công!";
        } else {
            $msg = "❌ Không thể đọc file Excel. Vui lòng kiểm tra lại định dạng .xlsx";
        }
    }
}

/************* 3. TRUY VẤN DỮ LIỆU (Đã sửa lỗi Unknown Column) *************/
// Loại bỏ sc.gpa vì DB của bạn không có cột này
$query = "SELECT s.student_id, s.student_name, sc.subject_id, sc.score 
          FROM students s 
          LEFT JOIN scores sc ON s.student_id = sc.student_id 
          ORDER BY s.student_id DESC";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Quản lý Điểm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main-container" style="padding: 20px; max-width: 1000px; margin: auto;">
        <h2 style="text-align: center;">BẢNG ĐIỂM SINH VIÊN</h2>

        <?php if ($role === "admin"): ?>
        <div style="background: #f0f0f0; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px dashed #666;">
            <strong>Nhập dữ liệu từ Excel (Admin):</strong>
            <form method="POST" enctype="multipart/form-data" style="margin-top: 10px;">
                <input type="file" name="excel_file" accept=".xlsx" required>
                <button type="submit" name="btn_import" style="padding: 5px 15px; background: #27ae60; color: white; border: none; cursor: pointer;">Tải lên</button>
            </form>
            <p style="color: blue; margin-top: 5px;"><?= $msg ?></p>
        </div>
        <?php endif; ?>

        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead style="background: #2c3e50; color: white;">
                <tr>
                    <th style="padding: 10px;">Mã SV</th>
                    <th style="padding: 10px;">Họ tên</th>
                    <th style="padding: 10px;">Môn học</th>
                    <th style="padding: 10px;">Điểm số</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data && mysqli_num_rows($data) > 0): ?>
                    <?php while($r = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td style="padding: 10px; font-weight: bold;"><?= htmlspecialchars($r['student_id']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($r['student_name']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($r['subject_id'] ?? 'N/A') ?></td>
                        <td style="padding: 10px; color: red; font-weight: bold;"><?= $r['score'] ?? '0' ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align: center; padding: 20px;">Dữ liệu hiện đang trống.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>