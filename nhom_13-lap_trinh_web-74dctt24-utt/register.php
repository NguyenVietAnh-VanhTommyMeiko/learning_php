<?php
require_once 'config.php';
$error = ''; $success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = $_POST['password']; // Mật khẩu thường (ví dụ: 123abc)
    $fname = trim($_POST['fullname']);
    $role = $_POST['role'];

    $check = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check->bind_param("s", $user);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $error = "Tên đăng nhập này đã tồn tại!";
    } else {
        // Lưu trực tiếp biến $pass không qua mã hóa
        $stmt = $conn->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user, $pass, $fname, $role);
        if ($stmt->execute()) {
            $success = "Đăng ký giáo viên thành công!";
            header("refresh:1;url=index.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký giáo viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display: flex; align-items: center; min-height: 100vh; background: #f1f5f9;">
    <div class="form-wrapper">
        <h2 style="text-align: center; color: var(--primary);">ĐĂNG KÝ GIÁO VIÊN</h2>
        <?php if($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>
        <?php if($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" placeholder="VD: teacher_01" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="reg-pass" class="form-control" required>
                    <span class="toggle-password" onclick="togglePass('reg-pass')">Hiện</span>
                </div>
            </div>
            <div class="form-group">
                <label>Họ và tên thật</label>
                <input type="text" name="fullname" class="form-control" placeholder="VD: Nguyễn Văn A" required>
            </div>
            <div class="form-group">
                <label>Vai trò hệ thống</label>
                <select name="role" class="form-control">
                    <option value="Giáo vụ">Giáo vụ</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Đăng ký</button>
        </form>
        <p style="text-align: center; margin-top: 15px;"><a href="index.php">Quay lại Đăng nhập</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>