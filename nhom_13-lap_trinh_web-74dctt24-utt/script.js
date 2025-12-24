document.addEventListener("DOMContentLoaded", () => {
    const menuItems = document.querySelectorAll(".menu li");

    // Xử lý chuyển đổi menu active và cuộn trang
    menuItems.forEach(item => {
        item.addEventListener("click", () => {
            // Xóa active cũ
            menuItems.forEach(i => i.classList.remove("active"));
            // Thêm active mới
            item.classList.add("active");

            // Cuộn đến phần tương ứng
            const targetId = item.getAttribute("data-target");
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: "smooth" });
            }
        });
    });

    // Xử lý nút đăng ký học phần
    const regBtns = document.querySelectorAll(".btn-green");
    regBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            if (confirm("Xác nhận đăng ký học phần này?")) {
                btn.textContent = "Thành công";
                btn.disabled = true;
                btn.style.background = "#94a3b8";
            }
        });
    });

    // Thông báo
    const noticeBtns = document.querySelectorAll(".btn-blue");
    noticeBtns.forEach(btn => {
        btn.addEventListener("click", () => alert("Nội dung thông báo đang tải..."));
    });
});