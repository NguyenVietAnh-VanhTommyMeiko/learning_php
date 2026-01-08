<?php
session_start();
require_once 'db.php'; 

$role = $_SESSION['user']['role'] ?? 'student'; 
$search = $_GET['search'] ?? '';
$search_param = "%$search%";

// Lấy danh sách từ bảng students
$sql = "SELECT student_id, student_name FROM students WHERE student_name LIKE ? OR student_id LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();

include 'header.php'; 
?>
<link rel="stylesheet" href="style.css">

<div class="main-content" style="padding: 20px;">
    <h2>DANH SÁCH SINH VIÊN</h2>

    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
        <form method="GET">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Tìm mã hoặc tên...">
            <button type="submit">Tìm kiếm</button>
        </form>

        <?php if ($role === 'admin'): ?>
            <a href="student_add.php" style="background: green; color: white; padding: 8px 15px; text-decoration: none;">+ Thêm sinh viên</a>
        <?php endif; ?>
    </div>

    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #eee;">
                <th>Mã sinh viên</th>
                <th>Họ và tên</th>
                <?php if ($role === 'admin'): ?><th>Thao tác</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['student_id']) ?></td>
                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                    <?php if ($role === 'admin'): ?>
                    <td>
                        <a href="student_edit.php?student_id=<?= urlencode($row['student_id']) ?>">Sửa</a> | 
                        <a href="delete_student.php?id=<?= urlencode($row['student_id']) ?>" onclick="return confirm('Xóa sinh viên này?')">Xóa</a>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>