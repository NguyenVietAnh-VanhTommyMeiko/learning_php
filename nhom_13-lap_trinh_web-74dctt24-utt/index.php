<?php
require_once 'config.php';
if (isset($_SESSION['user'])) { header("Location: dashboard.php"); exit(); }
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); 
    $password = $_POST['password']; // Lấy mật khẩu thường từ form

    $stmt = $conn->prepare("SELECT username, password, fullname, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // SO SÁNH TRỰC TIẾP MẬT KHẨU (Dạng thường)
        if ($password === $row['password']) {
            $_SESSION['user'] = $row['username'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role'] = $row['role'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Mật khẩu không chính xác!";
        }
    } else {
        $error = "Tài khoản không tồn tại!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Hệ thống</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display: flex; align-items: center; min-height: 100vh; background: #f1f5f9;">
    <div class="form-wrapper">
        <h2 style="text-align: center; color: var(--primary);">ĐĂNG NHẬP</h2>
        <?php if($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Tên đăng nhập (Username)</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="login-pass" class="form-control" required>
                    <span class="toggle-password" onclick="togglePass('login-pass')">Hiện</span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Đăng nhập</button>
        </form>
        <p style="text-align: center; margin-top: 15px;"><a href="register.php">Đăng ký tài khoản mới</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>