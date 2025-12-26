<?php
// --- PHP LOGIC ---
session_start();
$error = "";
$success = "";

// Xử lý đăng xuất nếu có tham số logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    $success = "Đăng xuất thành công!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = trim($_POST['maSV']);
    $password = $_POST['password'];

    // GIẢ LẬP CHECK DATABASE
    // Trong thực tế bạn sẽ query SQL ở đây
    if ($maSV === "SV2024001" && $password === "123456") {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $maSV;
        $_SESSION['user_name'] = "NGUYỄN VĂN A";
        
        header("Location: index.php"); // Chuyển sang Dashboard
        exit();
    } else {
        $error = "Mã sinh viên hoặc mật khẩu không chính xác!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Student Portal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-header">
            <div class="logo-text"><i class="fas fa-graduation-cap"></i> PORTAL</div>
            <p>Hệ thống Quản lý Sinh viên</p>
        </div>
        
        <div class="auth-form">
            <?php if($error): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
            <?php endif; ?>
            <?php if($success): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>Mã Sinh Viên</label>
                    <input type="text" name="maSV" class="form-input" placeholder="Ví dụ: SV2024001" required value="SV2024001">
                </div>
                
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="login_pass" class="form-input" placeholder="Nhập mật khẩu" required>
                        <i class="fas fa-eye toggle-password" style="right: 15px; top: 15px;" onclick="togglePasswordVisibility('login_pass', this)"></i>
                    </div>
                </div>

                <div style="text-align: right; margin-bottom: 20px;">
                    <a href="forgot_password.php" style="font-size: 0.85rem; color: #4361ee; text-decoration: none;">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="auth-btn">ĐĂNG NHẬP <i class="fas fa-arrow-right" style="margin-left: 8px;"></i></button>
            </form>

            <div class="auth-footer">
                Chưa có tài khoản? <a href="register.php">Đăng ký hồ sơ mới</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>