<?php
include 'db_connect.php';
$msg = "";

if (isset($_POST['register'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $n = $_POST['full_name'];
    $r = $_POST['role'];

    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$u'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Tên tài khoản đã tồn tại!";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password, full_name, role) VALUES ('$u', '$p', '$n', '$r')");
        $msg = "Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a>";
    }
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"><title>Đăng ký</title></head>
<body style="background: #2c3e50; display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="container" style="width: 400px; min-height: auto;">
        <h2 style="text-align: center;">TẠO TÀI KHOẢN</h2>
        <?php if($msg) echo "<p>$msg</p>"; ?>
        <form method="POST">
            <input type="text" name="full_name" placeholder="Họ tên đầy đủ" required style="width: 95%; margin-bottom: 10px;">
            <input type="text" name="username" placeholder="Tên đăng nhập" required style="width: 95%; margin-bottom: 10px;">
            <input type="password" name="password" placeholder="Mật khẩu" required style="width: 95%; margin-bottom: 10px;">
            <select name="role" style="width: 100%; margin-bottom: 15px;">
                <option value="student">Sinh viên</option>
                <option value="admin">Admin (Giáo vụ)</option>
            </select>
            <button type="submit" name="register" class="btn btn-add" style="width: 100%;">Đăng ký</button>
            <p style="text-align: center;"><a href="login.php">Quay lại đăng nhập</a></p>
        </form>
    </div>
</body>
</html>