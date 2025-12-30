<?php
require_once 'config.php';
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit(); }

// Xử lý tìm kiếm và lọc
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filter_dept = isset($_GET['dept']) ? trim($_GET['dept']) : '';

$sql = "SELECT * FROM students WHERE 1=1";
$params = [];
$types = "";

if ($search !== '') {
    $sql .= " AND (fullname LIKE ? OR student_code LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param; $params[] = $search_param;
    $types .= "ss";
}

if ($filter_dept !== '') {
    $sql .= " AND department = ?";
    $params[] = $filter_dept;
    $types .= "s";
}

$sql .= " ORDER BY id DESC";
$stmt = $conn->prepare($sql);
if (!empty($params)) { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$result = $stmt->get_result();

// Lấy danh sách khoa cho bộ lọc
$dept_list = $conn->query("SELECT DISTINCT department FROM students");

// Hàm xếp loại theo thang điểm yêu cầu
function getClassification($score) {
    if ($score >= 8.5) return ["A", "#10b981"];    // Xanh lá
    if ($score >= 8.0) return ["B+", "#059669"];
    if ($score >= 7.0) return ["B", "#2563eb"];    // Xanh dương
    if ($score >= 6.0) return ["C+", "#3b82f6"];
    if ($score >= 5.5) return ["C", "#8b5cf6"];    // Tím
    if ($score >= 5.0) return ["D+", "#f59e0b"];   // Cam
    if ($score >= 4.0) return ["D", "#d97706"];
    return ["F", "#ef4444"];                       // Đỏ
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ thống Quản lý Sinh viên</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .active-link { background: #eff6ff; color: var(--primary) !important; border: 1px solid #bfdbfe; }
        .grade-badge { padding: 3px 8px; border-radius: 4px; color: white; font-weight: bold; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
    <h1>Hệ Thống Quản Lý</h1>
    <div class="nav-links" style="display: flex; align-items: center; gap: 15px;">
        <a href="dashboard.php" class="active-link" style="padding: 8px 15px; border-radius: 8px; text-decoration: none;">Sinh viên & Điểm</a>
        <a href="classes.php" style="padding: 8px 15px; text-decoration: none; color: #666;">Lớp & Khoa</a>
        
        <span style="border-left: 1px solid #ddd; padding-left: 15px; color: #475569;">
            <small style="background: #e2e8f0; padding: 2px 8px; border-radius: 4px; font-weight: bold; color: #1e293b; margin-right: 5px;">
                <?php echo htmlspecialchars($_SESSION['role']); ?>
            </small>
            Chào <b><?php echo htmlspecialchars($_SESSION['fullname']); ?></b>
        </span>
        
        <a href="logout.php" class="btn btn-danger btn-logout">Thoát</a>
    </div>
</header>

        <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <form action="dashboard.php" method="GET" style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="Tên hoặc Mã SV..." value="<?php echo htmlspecialchars($search); ?>" class="form-control" style="flex: 2;">
                <select name="dept" class="form-control" style="flex: 1;">
                    <option value="">Tất cả Khoa</option>
                    <?php while($d = $dept_list->fetch_assoc()): ?>
                        <option value="<?php echo $d['department']; ?>" <?php echo ($filter_dept == $d['department']) ? 'selected' : ''; ?>><?php echo $d['department']; ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" class="btn btn-primary">Tìm & Lọc</button>
                <a href="dashboard.php" class="btn" style="background: #eee; color: #333; text-decoration: none; line-height: 2.5; padding: 0 15px; border-radius: 6px;">Reset</a>
            </form>
        </div>

        <div class="action-bar">
            <h2>Danh sách sinh viên</h2>
            <a href="add_student.php" class="btn btn-success">+ Thêm sinh viên & Điểm</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Mã SV</th>
                        <th>Họ Tên</th>
                        <th>Lớp - Khoa</th>
                        <th>Điểm TB</th>
                        <th>Xếp loại</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): 
                        $classInfo = getClassification($row['average_grade']);
                    ?>
                    <tr>
                        <td><b><?php echo $row['student_code']; ?></b></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['class_name']; ?> - <small><?php echo $row['department']; ?></small></td>
                        <td><b style="color: var(--primary);"><?php echo number_format($row['average_grade'], 1); ?></b></td>
                        <td>
                            <span class="grade-badge" style="background: <?php echo $classInfo[1]; ?>;">
                                <?php echo $classInfo[0]; ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn-edit">Sửa</a>
                            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn-delete delete-btn">Xóa</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>