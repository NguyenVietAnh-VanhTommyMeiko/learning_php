<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php"); exit();
}

$msg = "";

// Xử lý thêm Khoa
if (isset($_POST['add_dept'])) {
    $name = mysqli_real_escape_string($conn, $_POST['dept_name']);
    mysqli_query($conn, "INSERT INTO departments (name) VALUES ('$name')");
    $msg = "Đã thêm khoa thành công!";
}

// Xử lý thêm Lớp
if (isset($_POST['add_class'])) {
    $name = mysqli_real_escape_string($conn, $_POST['class_name']);
    $dept_id = $_POST['dept_id'];
    mysqli_query($conn, "INSERT INTO classes (name, department_id) VALUES ('$name', '$dept_id')");
    $msg = "Đã thêm lớp thành công!";
}

// Xử lý xóa (Khoa/Lớp)
if (isset($_GET['del_dept'])) {
    mysqli_query($conn, "DELETE FROM departments WHERE id=" . $_GET['del_dept']);
    header("Location: dept_class.php");
}
if (isset($_GET['del_class'])) {
    mysqli_query($conn, "DELETE FROM classes WHERE id=" . $_GET['del_class']);
    header("Location: dept_class.php");
}

$depts = mysqli_query($conn, "SELECT * FROM departments");
$classes = mysqli_query($conn, "SELECT c.*, d.name as dept_name FROM classes c JOIN departments d ON c.department_id = d.id");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Quản lý Lớp - Khoa</title>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Quản lý Khoa & Lớp học</h2>
        <?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div>
                <h3>Danh sách Khoa</h3>
                <form method="POST" class="search-bar">
                    <input type="text" name="dept_name" placeholder="Tên khoa mới" required>
                    <button name="add_dept" class="btn btn-add">Thêm Khoa</button>
                </form>
                <table>
                    <tr><th>Tên Khoa</th><th>Thao tác</th></tr>
                    <?php while($d = mysqli_fetch_assoc($depts)): ?>
                    <tr>
                        <td><?php echo $d['name']; ?></td>
                        <td><a href="?del_dept=<?php echo $d['id']; ?>" class="btn btn-delete">Xóa</a></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>

            <div>
                <h3>Danh sách Lớp</h3>
                <form method="POST" class="search-bar">
                    <input type="text" name="class_name" placeholder="Tên lớp mới" required>
                    <select name="dept_id" required>
                        <option value="">-- Chọn Khoa --</option>
                        <?php 
                        mysqli_data_seek($depts, 0);
                        while($d = mysqli_fetch_assoc($depts)) echo "<option value='".$d['id']."'>".$d['name']."</option>"; 
                        ?>
                    </select>
                    <button name="add_class" class="btn btn-add">Thêm Lớp</button>
                </form>
                <table>
                    <tr><th>Tên Lớp</th><th>Thuộc Khoa</th><th>Thao tác</th></tr>
                    <?php while($c = mysqli_fetch_assoc($classes)): ?>
                    <tr>
                        <td><?php echo $c['name']; ?></td>
                        <td><?php echo $c['dept_name']; ?></td>
                        <td><a href="?del_class=<?php echo $c['id']; ?>" class="btn btn-delete">Xóa</a></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>