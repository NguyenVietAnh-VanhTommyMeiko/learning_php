<?php
require_once 'config.php';
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit(); }

// Lấy danh sách lớp và số lượng SV
$class_sql = "SELECT class_name, department, COUNT(*) as total FROM students GROUP BY class_name, department";
$class_result = $conn->query($class_sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Lớp và Khoa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
    <h1>Hệ Thống Quản Lý</h1>
    <div class="nav-links" style="display: flex; align-items: center; gap: 15px;">
        <a href="dashboard.php" style="padding: 8px 15px; text-decoration: none; color: #666;">Sinh viên & Điểm</a>
        <a href="classes.php" style="padding: 8px 15px; border-radius: 8px; text-decoration: none; color: var(--primary); font-weight: bold; background: #eff6ff;">Lớp & Khoa</a>
        
        <span style="border-left: 1px solid #ddd; padding-left: 15px; color: #475569;">
            <small style="background: #e2e8f0; padding: 2px 8px; border-radius: 4px; font-weight: bold; color: #1e293b; margin-right: 5px;">
                <?php echo htmlspecialchars($_SESSION['role']); ?>
            </small>
            Chào <b><?php echo htmlspecialchars($_SESSION['fullname']); ?></b>
        </span>
        
        <a href="logout.php" class="btn btn-danger btn-logout">Thoát</a>
    </div>
</header>

        <div class="action-bar">
            <h2>Thống kê Lớp - Khoa</h2>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tên Lớp</th>
                        <th>Thuộc Khoa</th>
                        <th>Số lượng sinh viên</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $class_result->fetch_assoc()): ?>
                    <tr>
                        <td><b><?php echo $row['class_name']; ?></b></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><span class="badge"><?php echo $row['total']; ?> Sinh viên</span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>