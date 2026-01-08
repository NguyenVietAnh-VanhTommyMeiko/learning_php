<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php"); exit();
}

if (isset($_POST['add_subject'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $credit = $_POST['credit'];
    mysqli_query($conn, "INSERT INTO subjects (name, credit) VALUES ('$name', '$credit')");
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM subjects WHERE id=$id");
}

$subjects = mysqli_query($conn, "SELECT * FROM subjects");
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Quản lý môn học</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Quản lý môn học</h2>
        <form method="POST" class="search-bar">
            <input type="text" name="name" placeholder="Tên môn học" required>
            <input type="number" name="credit" placeholder="Số tín chỉ" required>
            <button name="add_subject" class="btn btn-add">Thêm môn</button>
        </form>
        <table>
            <tr><th>ID</th><th>Tên môn</th><th>Tín chỉ</th><th>Thao tác</th></tr>
            <?php while($s = mysqli_fetch_assoc($subjects)): ?>
            <tr>
                <td><?php echo $s['id']; ?></td>
                <td><?php echo $s['name']; ?></td>
                <td><?php echo $s['credit']; ?></td>
                <td><a href="?del=<?php echo $s['id']; ?>" class="btn btn-delete">Xóa</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>