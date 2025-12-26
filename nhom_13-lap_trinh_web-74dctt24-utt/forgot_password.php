<?php
// --- PHP LOGIC ---
session_start();
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    // Logic gửi mail reset password sẽ nằm ở đây
    $msg = "<div class='alert alert-success'>Nếu email tồn tại trong hệ thống, chúng tôi đã gửi hướng dẫn đặt lại mật khẩu vào hộp thư của bạn.</div>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu - Student Portal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-header">
            <h2>KHÔI PHỤC TÀI KHOẢN</h2>
            <p>Đừng lo lắng, chúng tôi sẽ giúp bạn</p>
        </div>
        
        <div class="auth-form">
            <?php echo $msg; ?>

            <form action="forgot_password.php" method="POST">
                <div class="form-group">
                    <label>Email đăng ký</label>
                    <input type="email" name="email" class="form-input" required placeholder="vana.nguyen@student.edu.vn">
                </div>

                <button type="submit" class="auth-btn">GỬI YÊU CẦU</button>
            </form>

            <div class="auth-footer">
                <a href="login.php"><i class="fas fa-arrow-left"></i> Quay lại Đăng nhập</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>