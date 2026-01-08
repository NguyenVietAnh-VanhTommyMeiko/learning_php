<?php
include "config.php";
if(!isset($_SESSION['user'])) header("Location:index.php");
$u=$_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Xin chào <?= $u['username'] ?> (<?= $u['full_name'] ?>)</h2>

<div class="menu">
<?php if($u['role']=='admin'): ?>
<a href="add_student.php">Thêm sinh viên</a>
<a href="classes.php">Lớp / Khoa</a>
<a href="subjects.php">Môn học</a>
<a href="manage_scores.php">Quản lý điểm</a>
<a href="import_excel.php">Import Excel</a>
<?php endif; ?>

<?php if($u['role']=='student'): ?>
<a href="manage_scores.php">Xem bảng điểm</a>
<?php endif; ?>

<a href="logout.php">Đăng xuất</a>
</div>
</div>
</body>
</html>
