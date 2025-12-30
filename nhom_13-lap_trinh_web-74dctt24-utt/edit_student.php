<?php
require_once 'config.php';
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit(); }

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: dashboard.php"); exit(); }

$error = ''; $success = '';

// Lấy thông tin hiện tại
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['fullname']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $class = trim($_POST['class_name']);
    $dept = trim($_POST['department']);
    $email = trim($_POST['email']);
    $avg_grade = $_POST['average_grade'];

    $update = $conn->prepare("UPDATE students SET fullname=?, dob=?, gender=?, class_name=?, department=?, email=?, average_grade=? WHERE id=?");
    $update->bind_param("ssssssdi", $name, $dob, $gender, $class, $dept, $email, $avg_grade, $id);
    
    if ($update->execute()) {
        $success = "Cập nhật thành công!";
        header("refresh:1;url=dashboard.php");
    } else {
        $error = "Có lỗi xảy ra khi cập nhật.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin sinh viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper wide">
            <h2 style="text-align: center; color: var(--primary);">SỬA THÔNG TIN & ĐIỂM</h2>
            <?php if($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>
            <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>

            <form method="POST" class="grid-form">
                <div class="form-group"><label>Mã SV (Không thể sửa)</label>
                    <input type="text" class="form-control" value="<?php echo $student['student_code']; ?>" disabled>
                </div>
                <div class="form-group"><label>Họ tên</label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($student['fullname']); ?>" required>
                </div>
                <div class="form-group"><label>Ngày sinh</label>
                    <input type="date" name="dob" class="form-control" value="<?php echo $student['dob']; ?>" required>
                </div>
                <div class="form-group"><label>Giới tính</label>
                    <select name="gender" class="form-control">
                        <option value="Nam" <?php echo ($student['gender'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                        <option value="Nữ" <?php echo ($student['gender'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                    </select>
                </div>
                <div class="form-group"><label>Lớp</label>
                    <input type="text" name="class_name" class="form-control" value="<?php echo htmlspecialchars($student['class_name']); ?>" required>
                </div>
                <div class="form-group"><label>Khoa</label>
                    <input type="text" name="department" class="form-control" value="<?php echo htmlspecialchars($student['department']); ?>" required>
                </div>
                <div class="form-group full-width"><label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>

                <div class="form-group full-width" name="average_grade">
                    <label>Điểm Trung Bình (TB)</label>
                    <input type="number" step="0.1" min="0" max="10" name="average_grade" class="form-control" value="<?php echo $student['average_grade']; ?>" required>
                </div>

                <div class="full-width" style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Cập nhật</button>
                    <a href="dashboard.php" class="btn" style="background: #666; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px;">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>