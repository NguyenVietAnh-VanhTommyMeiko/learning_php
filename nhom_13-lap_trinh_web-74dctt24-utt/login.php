<?php
session_start();
include 'db_connect.php';

// 1. Nếu đã đăng nhập rồi thì tự động chuyển vào trang chủ (Tránh lỗi chuyển hướng vòng lặp)
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = "";

// 2. Xử lý khi người dùng nhấn nút Đăng nhập
if (isset($_POST['login'])) {
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = mysqli_real_escape_string($conn, $_POST['password']);

    // Truy vấn kiểm tra tài khoản
    $sql = "SELECT * FROM users WHERE username = '$u' AND password = '$p'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Lưu thông tin vào Session
        $_SESSION['user'] = $user;
        
        // Chuyển hướng thành công
        header("Location: index.php");
        exit();
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS riêng để căn giữa form đăng nhập */
        body {
            background: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 350px;
        }
        .login-box h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .error-msg {
            color: #e74c3c;
            background: #fdeaea;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>ĐĂNG NHẬP</h2>

        <?php if ($error): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" placeholder="Nhập username" required style="width: 100%;">
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <label>Mật khẩu</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu" required style="width: 100%;">
            </div>
            <button type="submit" name="login" class="btn btn-add" style="width: 100%; margin-top: 20px; padding: 12px;">
                Đăng nhập
            </button>
        </form>

        <p style="text-align: center; margin-top: 20px; font-size: 14px;">
            Chưa có tài khoản? <a href="register.php" style="color: #3498db; text-decoration: none;">Đăng ký ngay</a>
        </p>
    </div>

</body>
</html>