<?php
// --- PHP LOGIC ---
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = htmlspecialchars($_POST['fullname']);
    $maSV = htmlspecialchars($_POST['maSV']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Validate Server-side
    if ($password !== $confirm) {
        $message = "<div class='alert alert-danger'>Mật khẩu xác nhận không khớp!</div>";
    } elseif (strlen($password) < 6) {
        $message = "<div class='alert alert-danger'>Mật khẩu phải từ 6 ký tự trở lên!</div>";
    } else {
        // TẠI ĐÂY: Insert vào Database
        // Giả lập thành công:
        $message = "<div class='alert alert-success'>Đăng ký thành công! <br>Vui lòng <a href='login.php' style='font-weight:bold;'>Đăng nhập</a></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - Student Portal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-header" style="padding: 30px;">
            <h2>TẠO HỒ SƠ MỚI</h2>
            <p>Nhập thông tin sinh viên để đăng ký</p>
        </div>
        
        <div class="auth-form">
            <?php echo $message; ?>

            <form action="register.php" method="POST" onsubmit="return validateRegister(event)">
                <div class="form-group">
                    <label>Họ và Tên</label>
                    <input type="text" name="fullname" class="form-input" required placeholder="Nguyễn Văn A">
                </div>

                <div class="form-group">
                    <label>Mã Sinh Viên</label>
                    <input type="text" name="maSV" class="form-input" required placeholder="SV2024..." >
                </div>
                
                <div class="form-group">
            <label>Mật khẩu</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="reg_password" class="form-input" required placeholder="Tối thiểu 6 ký tự">
                <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('reg_password', this)"></i>
            </div>
        </div>

        <div class="form-group">
            <label>Nhập lại mật khẩu</label>
            <div class="password-wrapper">
                <input type="password" name="confirm_password" id="reg_confirm" class="form-input" required placeholder="Xác nhận mật khẩu">
                <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('reg_confirm', this)"></i>
            </div>
        </div>

                <button type="submit" class="auth-btn">HOÀN TẤT ĐĂNG KÝ</button>
            </form>

            <div class="auth-footer">
                Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>