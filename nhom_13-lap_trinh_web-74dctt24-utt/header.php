<div class="navbar">
    <b>HỆ THỐNG QUẢN LÝ</b>
    <div>
        <a href="index.php">Bảng điểm</a>
        <a href="students.php">Sinh viên</a>
        <?php if($_SESSION['user']['role'] == 'admin'): ?>
            <a href="dept_class.php">Lớp & Khoa</a>
            <a href="subjects.php">Môn học</a>
        <?php endif; ?>
    </div>
    <div style="float: right;">
        <span>👤 <?php echo $_SESSION['user']['full_name']; ?> (<?php echo $_SESSION['user']['role']; ?>)</span>
        <a href="logout.php" style="color: #ff7675; margin-left: 20px; font-weight: bold;">Đăng xuất</a>
    </div>
</div>