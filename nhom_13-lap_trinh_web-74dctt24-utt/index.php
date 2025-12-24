<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Lý Sinh Viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    // Giả lập dữ liệu từ Cơ sở dữ liệu
    $sinhVien = [
        "hoTen" => "NGUYỄN VĂN A",
        "ngaySinh" => "01/01/2002",
        "maSV" => "SV202401",
        "nganh" => "Kỹ thuật phần mềm",
        "gpa" => 3.25,
        "tinChiTichLuy" => 110
    ];

    $danhSachMonHoc = [
        ["ma" => "IT001", "ten" => "Lập trình Web", "tc" => 3, "gv" => "Nguyễn Văn B", "siSo" => "45/50"],
        ["ma" => "IT002", "ten" => "Cơ sở dữ liệu", "tc" => 4, "gv" => "Trần Thị C", "siSo" => "45/50"]
    ];

    $bangDiem = [
        ["ma" => "ENG01", "ten" => "Tiếng Anh 1", "tc" => 3, "gk" => 8.5, "ck" => 7.0, "diemChu" => "B+"],
        ["ma" => "IT102", "ten" => "Toán rời rạc", "tc" => 3, "gk" => 7.0, "ck" => 9.0, "diemChu" => "A"]
    ];

    $hocPhi = [
        "tong" => 15000000,
        "daDong" => 10000000
    ];
    
    $conNo = $hocPhi['tong'] - $hocPhi['daDong'];
    $tienDo = ($hocPhi['daDong'] / $hocPhi['tong']) * 100;
    ?>

    <aside>
        <div class="sidebar-logo"><h2>SV PORTAL</h2></div>
        <nav>
            <ul class="menu">
                <li class="active" data-target="home">Trang chủ</li>
                <li data-target="student-profile">Hồ sơ</li>
                <li data-target="academic-grades">Học tập</li>
                <li data-target="course-registration">Học phần</li>
                <li data-target="tuition-management">Học phí</li>
                <li data-target="announcements">Thông báo</li>
            </ul>
        </nav>
    </aside>

    <main>
        <section id="home">
            <h2>CHÀO MỪNG QUAY TRỞ LẠI!</h2>
            <p>Chào mừng <strong><?php echo $sinhVien['hoTen']; ?></strong> đến với hệ thống quản lý học tập.</p>
        </section>

        <section id="student-profile">
            <header class="card-header">
                <h2>HỒ SƠ SINH VIÊN</h2>
                <button type="button" class="btn-update">Cập nhật hồ sơ</button>
            </header>
            <div class="profile-content">
                <img src="https://via.placeholder.com/80" alt="Avatar">
                <div class="info-grid">
                    <p><strong>Mã SV:</strong> <?php echo $sinhVien['maSV']; ?></p>
                    <p><strong>Ngành:</strong> <?php echo $sinhVien['nganh']; ?></p>
                    <p><strong>Ngày sinh:</strong> <?php echo $sinhVien['ngaySinh']; ?></p>
                </div>
            </div>
        </section>

        <section id="academic-grades">
            <h2>KẾT QUẢ HỌC TẬP</h2>
            <table>
                <thead>
                    <tr>
                        <th>Mã HP</th>
                        <th>Tên Học Phần</th>
                        <th>TC</th>
                        <th>Giữa kỳ</th>
                        <th>Cuối kỳ</th>
                        <th>Điểm chữ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bangDiem as $d): ?>
                    <tr>
                        <td><?php echo $d['ma']; ?></td>
                        <td><?php echo $d['ten']; ?></td>
                        <td><?php echo $d['tc']; ?></td>
                        <td><?php echo $d['gk']; ?></td>
                        <td><?php echo $d['ck']; ?></td>
                        <td><strong><?php echo $d['diemChu']; ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section id="course-registration">
            <h2>ĐĂNG KÝ HỌC PHẦN</h2>
            <table>
                <thead>
                    <tr>
                        <th>Mã MH</th>
                        <th>Tên môn học</th>
                        <th>Sĩ số</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($danhSachMonHoc as $mon): ?>
                    <tr>
                        <td><?php echo $mon['ma']; ?></td>
                        <td><?php echo $mon['ten']; ?></td>
                        <td><?php echo $mon['siSo']; ?></td>
                        <td><button class="btn-green">Đăng ký</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section id="tuition-management">
            <h2>QUẢN LÝ HỌC PHÍ</h2>
            <div class="tuition-info">
                <p>Tiến độ: <progress value="<?php echo $tienDo; ?>" max="100"></progress> <?php echo round($tienDo); ?>%</p>
                <p>Còn nợ: <span class="text-danger"><?php echo number_format($conNo, 0, ',', '.'); ?> VND</span></p>
            </div>
        </section>

        <section id="announcements">
            <h2>THÔNG BÁO MỚI</h2>
            <article class="notice-item">
                <h3>Lịch nghỉ Tết Nguyên Đán 2025</h3>
                <p>Ngày đăng: 20/12/2024</p>
                <button class="btn-blue">Xem chi tiết</button>
            </article>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>