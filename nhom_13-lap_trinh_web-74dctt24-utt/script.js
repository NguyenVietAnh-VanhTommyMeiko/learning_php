/**
 * HỆ THỐNG QUẢN LÝ SINH VIÊN - JAVASCRIPT CHÍNH
 */

document.addEventListener("DOMContentLoaded", () => {
    // 1. KHỞI TẠO CÁC CHỨC NĂNG
    initNavigation();
    initDropdowns();
    initNotifications();
});

/**
 * CHỨC NĂNG 1: CHUYỂN TAB (NAVIGATION)
 * Xử lý khi click vào các mục menu để hiển thị nội dung tương ứng
 */
function initNavigation() {
    const navItems = document.querySelectorAll(".nav-item[data-target]");
    const tabPanes = document.querySelectorAll(".tab-pane");

    navItems.forEach(item => {
        item.addEventListener("click", () => {
            const targetId = item.getAttribute("data-target");

            // Xóa class active ở tất cả menu items
            navItems.forEach(nav => nav.classList.remove("active"));
            // Thêm class active cho item hiện tại
            item.classList.add("active");

            // Ẩn tất cả các tab nội dung
            tabPanes.forEach(pane => pane.classList.remove("active"));
            // Hiển thị tab mục tiêu
            const targetPane = document.getElementById(targetId);
            if (targetPane) {
                targetPane.classList.add("active");
            }
        });
    });
}

/**
 * CHỨC NĂNG 2: MENU DROPDOWN (SIDEBAR)
 * Xử lý đóng/mở các nhóm menu như "Học tập", "Tài khoản"
 */
function initDropdowns() {
    const navGroups = document.querySelectorAll(".nav-group");

    navGroups.forEach(group => {
        const label = group.querySelector(".nav-label");
        
        label.addEventListener("click", (e) => {
            // Đóng các group khác nếu muốn (Optional - Accordion effect)
            // navGroups.forEach(otherGroup => {
            //     if (otherGroup !== group) otherGroup.classList.remove("open");
            // });

            // Toggle group hiện tại
            group.classList.toggle("open");
        });
    });
}

/**
 * CHỨC NĂNG 3: HIỆN/ẨN MẬT KHẨU
 * Chuyển đổi type của input giữa 'password' và 'text'
 */
function togglePasswordVisibility(inputId, iconEl) {
    const passwordInput = document.getElementById(inputId);
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        // Thay đổi icon sang mắt gạch chéo
        iconEl.classList.remove("fa-eye");
        iconEl.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        // Thay đổi icon về mắt bình thường
        iconEl.classList.remove("fa-eye-slash");
        iconEl.classList.add("fa-eye");
    }
}

/**
 * CHỨC NĂNG 4: XỬ LÝ CẬP NHẬT MẬT KHẨU
 */
function handleUpdatePass() {
    const oldPass = document.getElementById('old-pass').value;
    const newPass = document.getElementById('new-pass').value;

    if (!oldPass || !newPass) {
        alert("Vui lòng nhập đầy đủ mật khẩu cũ và mới!");
        return;
    }

    if (newPass.length < 6) {
        alert("Mật khẩu mới phải có ít nhất 6 ký tự!");
        return;
    }

    // Giả lập gửi dữ liệu
    console.log("Đang cập nhật mật khẩu...");
    alert("Cập nhật mật khẩu thành công!");
    
    // Reset form
    document.getElementById('old-pass').value = "";
    document.getElementById('new-pass').value = "";
}

/**
 * CHỨC NĂNG 5: XỬ LÝ THÔNG BÁO (NOTICES)
 */
function initNotifications() {
    const noticeItems = document.querySelectorAll(".notice-item");
    
    noticeItems.forEach(item => {
        item.addEventListener("click", () => {
            // Khi click vào thông báo, xóa trạng thái "chưa đọc"
            if (item.classList.contains("unread")) {
                item.classList.remove("unread");
                console.log("Đã đánh dấu là đã đọc thông báo.");
            }
        });
    });
}

/**
 * CHỨC NĂNG 6: ĐĂNG XUẤT
 */
function confirmLogout() {
    if (confirm("Bạn có chắc chắn muốn đăng xuất khỏi hệ thống?")) {
        window.location.reload(); // Hoặc chuyển hướng đến trang login
    }
}

/* =========================================
   BỔ SUNG: LOGIC HỆ THỐNG AUTHENTICATION
   ========================================= */

// Override lại hàm logout cũ để chuyển hướng đúng
function confirmLogout() {
    if (confirm("Bạn có chắc chắn muốn đăng xuất khỏi hệ thống?")) {
        // Xóa session giả lập (nếu dùng localStorage) hoặc gọi file logout
        window.location.href = "login.php?action=logout";
    }
}

// Hàm validate form đăng ký
function validateRegister(event) {
    const pass = document.getElementById('reg_password').value;
    const confirm = document.getElementById('reg_confirm').value;
    
    if (pass !== confirm) {
        event.preventDefault(); // Chặn gửi form
        alert("Mật khẩu xác nhận không khớp! Vui lòng kiểm tra lại.");
        return false;
    }
    return true;
}

// Tự động ẩn thông báo lỗi sau 3s
document.addEventListener("DOMContentLoaded", () => {
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(el => {
                el.style.opacity = '0';
                el.style.transition = 'opacity 0.5s ease';
                setTimeout(() => el.remove(), 500);
            });
        }, 3000);
    }
});