<?php
session_start();
// Kiểm tra nếu chưa đăng nhập thì đẩy về trang login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

/**
 * PHẦN 1: KHAI BÁO DỮ LIỆU (PHP)
 */

// 1. Thông tin cá nhân
$sinhVien = [
    "hoTen"    => "NGUYỄN VĂN A",
    "maSV"     => "SV2024001",
    "ngaySinh" => "01/01/2002",
    "gioiTinh" => "Nam",
    "lop"      => "65DCHT21",
    "nganh"    => "Kỹ thuật phần mềm",
    "khoa"     => "Công nghệ thông tin",
    "gpa"      => 3.65,
    "tinChi"   => 115,
    "hocPhiNo" => 4500000, // Số tiền nợ
    "hocPhiTong" => 18000000, // Tổng học phí kỳ này để tính %
    "email"    => "vana.nguyen@student.edu.vn",
    "sdt"      => "0987.654.321",
    "matKhau"  => "123456" // Mật khẩu hiện tại
];

// 2. Dữ liệu bảng điểm
$bangDiem = [
    ["mon" => "Lập trình PHP", "tinChi" => 3, "diem" => 8.5, "chu" => "A"],
    ["mon" => "Cơ sở dữ liệu", "tinChi" => 4, "diem" => 7.0, "chu" => "B"],
    ["mon" => "Phân tích hệ thống", "tinChi" => 3, "diem" => 9.0, "chu" => "A"],
    ["mon" => "Tiếng Anh chuyên ngành", "tinChi" => 2, "diem" => 4.5, "chu" => "D"]
];

// 3. Danh sách thông báo
$thongBao = [
    [
        "ngay" => "20/12/2024", 
        "tieuDe" => "Lịch nghỉ Tết Nguyên Đán 2025", 
        "noiDung" => "Sinh viên được nghỉ từ ngày 25/01/2025 đến hết ngày 09/02/2025.",
        "chuaDoc" => true
    ],
    [
        "ngay" => "15/12/2024", 
        "tieuDe" => "Đăng ký học kỳ phụ mùa hè", 
        "noiDung" => "Thông báo về việc mở cổng đăng ký các lớp học cải thiện cho sinh viên khóa K21.",
        "chuaDoc" => false
    ]
];

// Tính toán phần trăm học phí đã đóng
$phanTramDaDong = round((($sinhVien['hocPhiTong'] - $sinhVien['hocPhiNo']) / $sinhVien['hocPhiTong']) * 100);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Lý Sinh viên</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="logo-area">
                <div class="icon-logo">SV</div>
                <h2>PORTAL</h2>
            </div>
            <nav class="nav-menu">
                <div class="nav-item active" data-target="dashboard">Trang chủ</div>
                
                <div class="nav-group">
                    <div class="nav-label">Học tập <span class="arrow">▼</span></div>
                    <div class="dropdown-content">
                        <div class="nav-item" data-target="academic-grades">Tra cứu điểm</div>
                        <div class="nav-item" data-target="tuition">Học phí</div>
                    </div>
                </div>

                <div class="nav-item" data-target="notices">Thông báo</div>

                <div class="nav-group">
                    <div class="nav-label">Tài khoản <span class="arrow">▼</span></div>
                    <div class="dropdown-content">
                        <div class="nav-item" data-target="profile">Hồ sơ cá nhân</div>
                        <div class="nav-item" data-target="settings">Cài đặt</div>
                    </div>
                </div>
                
                <div class="nav-item" onclick="confirmLogout()" style="color: #ff4d4d; margin-top: 20px;">Đăng xuất</div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="header-title">Hệ Thống Thông Tin Sinh Viên</div>
                <div class="user-pill">
                    <span class="dot"></span>
                    <?php echo $sinhVien['hoTen']; ?>
                </div>
            </header>

            <div class="content-body">
                
                <section id="dashboard" class="tab-pane active">
                    <div class="welcome-box">
                        <h1>Xin chào, <?php echo $sinhVien['hoTen']; ?>!</h1>
                        <p>Mã số sinh viên: <?php echo $sinhVien['maSV']; ?> | Ngành: <?php echo $sinhVien['nganh']; ?></p>
                    </div>
                    <div class="stats-row">
                        <div class="stat-card">
                            <h3>GPA Tích lũy</h3>
                            <p class="val"><?php echo $sinhVien['gpa']; ?></p>
                        </div>
                        <div class="stat-card" style="border-left-color: #10b981;">
                            <h3>Số tín chỉ đạt</h3>
                            <p class="val"><?php echo $sinhVien['tinChi']; ?></p>
                        </div>
                        <div class="stat-card" style="border-left-color: #ef4444;">
                            <h3>Học phí còn nợ</h3>
                            <p class="val"><?php echo number_format($sinhVien['hocPhiNo']); ?>đ</p>
                        </div>
                    </div>
                </section>

                <section id="profile" class="tab-pane">
                    <div class="main-card">
                        <div class="card-header-gradient">
                            <h2>HỒ SƠ CÁ NHÂN</h2>
                            <p>Thông tin cơ bản và liên hệ</p>
                        </div>
                        <div class="card-body">
                            <div class="profile-grid">
                                <div class="info-group"><label>Họ và tên: </label><strong><?php echo $sinhVien['hoTen']; ?></strong></div>
                                <div class="info-group"><label>Mã sinh viên: </label><strong><?php echo $sinhVien['maSV']; ?></strong></div>
                                <div class="info-group"><label>Ngày sinh: </label><strong><?php echo $sinhVien['ngaySinh']; ?></strong></div>
                                <div class="info-group"><label>Giới tính: </label><strong><?php echo $sinhVien['gioiTinh']; ?></strong></div>
                                <div class="info-group"><label>Lớp: </label><strong><?php echo $sinhVien['lop']; ?></strong></div>
                                <div class="info-group"><label>Khoa: </label><strong><?php echo $sinhVien['khoa']; ?></strong></div>
                                <div class="info-group"><label>Email: </label><strong><?php echo $sinhVien['email']; ?></strong></div>
                                <div class="info-group"><label>Số điện thoại: </label><strong><?php echo $sinhVien['sdt']; ?></strong></div>
                                <div class="info-group"><label>Mật khẩu: </label><strong><?php echo $sinhVien['matKhau']; ?></strong></div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="academic-grades" class="tab-pane">
                    <h2 class="sec-title">KẾT QUẢ HỌC TẬP</h2>
                    <div class="summary-grid">
                        <div class="summary-item">Xếp loại: <strong>Giỏi</strong></div>
                        <div class="summary-item">Hệ đào tạo: <strong>Chính quy</strong></div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr><th>Tên môn học</th><th>Tín chỉ</th><th>Điểm</th><th>Thang điểm chữ</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach($bangDiem as $item): ?>
                            <tr>
                                <td><?php echo $item['mon']; ?></td>
                                <td><?php echo $item['tinChi']; ?></td>
                                <td><?php echo $item['diem']; ?></td>
                                <td>
                                    <?php 
                                        $class = ($item['chu'] == 'A') ? 'grade-a' : (($item['chu'] == 'F') ? 'grade-f' : 'grade-b');
                                        echo "<span class='grade-badge $class'>{$item['chu']}</span>";
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>

                <section id="tuition" class="tab-pane">
                    <h2 class="sec-title">THÔNG TIN HỌC PHÍ</h2>
                    <div class="tuition-card">
                        <div class="tuition-status">
                            <div class="status-label">
                                <strong>Số dư nợ hiện tại:</strong>
                                <p>Học kỳ 1 - Năm học 2024-2025</p>
                            </div>
                            <div class="amount"><?php echo number_format($sinhVien['hocPhiNo']); ?> VND</div>
                        </div>
                        <div class="progress-container">
                            <div style="display:flex; justify-content:space-between; font-size:0.9rem; margin-bottom:5px;">
                                <span>Tiến độ thanh toán:</span>
                                <strong><?php echo $phanTramDaDong; ?>%</strong>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: <?php echo $phanTramDaDong; ?>%;"></div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="notices" class="tab-pane">
                    <h2 class="sec-title">THÔNG BÁO MỚI NHẤT</h2>
                    <div class="notice-list">
                        <?php foreach($thongBao as $nb): ?>
                        <div class="notice-item <?php echo $nb['chuaDoc'] ? 'unread' : ''; ?>">
                            <span class="notice-date"><?php echo $nb['ngay']; ?></span>
                            <div class="notice-title"><?php echo $nb['tieuDe']; ?></div>
                            <p class="notice-desc"><?php echo $nb['noiDung']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section id="settings" class="tab-pane">
                    <div class="main-card">
                        <div class="card-header-gradient"><h3>CÀI ĐẶT HỆ THỐNG</h3></div>
                        <div class="card-body">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
    <div class="input-field">
        <label>Mật khẩu cũ</label>
        <div class="password-wrapper">
            <input type="password" id="old-pass" placeholder="Nhập mật khẩu cũ">
            <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('old-pass', this)"></i>
        </div>
    </div>
    <div class="input-field">
        <label>Mật khẩu mới</label>
        <div class="password-wrapper">
            <input type="password" id="new-pass" placeholder="Nhập mật khẩu mới">
            <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('new-pass', this)"></i>
        </div>
    </div>
</div>
<button class="btn-success" onclick="handleUpdatePass()">Cập nhật mật khẩu</button>
                            </div>
                    </div>
                </section>

            </div> </main>
    </div>
    <script src="script.js"></script>
</body>
</html>