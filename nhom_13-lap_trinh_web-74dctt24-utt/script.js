document.addEventListener("DOMContentLoaded", function() {
    // Xác nhận khi xóa
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Lấy tên sinh viên từ dòng tương ứng (nếu có) để thông báo chi tiết hơn
            const row = this.closest('tr');
            const studentName = row ? row.cells[1].innerText : "sinh viên này";
            
            const confirmDelete = confirm(`Bạn có chắc chắn muốn xóa sinh viên: ${studentName}?\nHành động này không thể hoàn tác!`);
            
            if (!confirmDelete) {
                e.preventDefault(); // Ngăn việc chuyển hướng đến file delete_student.php
            }
        });
    });
    // Chức năng ẩn/hiện mật khẩu
    window.togglePass = function(id) {
        const passwordInput = document.getElementById(id);
        const toggleBtn = passwordInput.nextElementSibling; // Tìm thẻ span ngay sau input

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleBtn.textContent = "Ẩn";
        } else {
            passwordInput.type = "password";
            toggleBtn.textContent = "Hiện";
        }
    };

    // 2. Xác nhận Đăng xuất (Áp dụng cho mọi trang có nút .btn-logout)
    const logoutBtns = document.querySelectorAll('.btn-logout');
    logoutBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const confirmLogout = confirm("Bạn có chắc chắn muốn đăng xuất khỏi hệ thống?");
            if (!confirmLogout) {
                e.preventDefault();
            }
        });
    });

    // Tự động ẩn thông báo sau 3 giây
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });
});