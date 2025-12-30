<?php
require_once 'config.php';
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit(); }

$error = ''; $success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['student_code']);
    $name = trim($_POST['fullname']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $class = trim($_POST['class_name']);
    $dept = trim($_POST['department']);
    $email = trim($_POST['email']);
    $avg_grade = $_POST['average_grade']; // Lấy điểm từ form

    $check = $conn->prepare("SELECT id FROM students WHERE student_code = ?");
    $check->bind_param("s", $code);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $error = "Mã sinh viên này đã tồn tại!";
    } else {
        // Thêm average_grade vào câu lệnh INSERT
        $stmt = $conn->prepare("INSERT INTO students (student_code, fullname, dob, gender, class_name, department, email, average_grade) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssd", $code, $name, $dob, $gender, $class, $dept, $email, $avg_grade);
        if ($stmt->execute()) {
            $success = "Thêm sinh viên và điểm thành công!";
            header("refresh:1;url=dashboard.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sinh viên mới</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper wide">
            <h2 style="text-align: center; color: var(--primary);">THÊM SINH VIÊN MỚI</h2>
            <?php if($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>
            <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
            
            <form method="POST" class="grid-form">
                <div class="form-group"><label>Mã SV</label><input type="text" name="student_code" class="form-control" placeholder="VD: SV001" required></div>
                <div class="form-group"><label>Họ tên</label><input type="text" name="fullname" class="form-control" required></div>
                <div class="form-group"><label>Ngày sinh</label><input type="date" name="dob" class="form-control" required></div>
                <div class="form-group"><label>Giới tính</label>
                    <select name="gender" class="form-control">
                        <option value="Nam">Nam</option><option value="Nữ">Nữ</option>
                    </select>
                </div>
                <div class="form-group"><label>Lớp</label><input type="text" name="class_name" class="form-control" required></div>
                <div class="form-group"><label>Khoa</label><input type="text" name="department" class="form-control" required></div>
                <div class="form-group full-width"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                
                <div class="form-group full-width" name="average_grade">
                    <label>Điểm Trung Bình (TB)</label>
                    <input type="number" step="0.1" min="0" max="10" name="average_grade" class="form-control" placeholder="Nhập điểm từ 0.0 đến 10.0" required>
                </div>

                <div class="full-width" style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Lưu dữ liệu</button>
                    <a href="dashboard.php" class="btn" style="background: #666; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px;">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>