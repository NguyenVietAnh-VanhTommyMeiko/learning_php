document.addEventListener('DOMContentLoaded', function() {
    // 1. Xác nhận khi xóa
    const deleteBtns = document.querySelectorAll('.btn-delete');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Bạn có chắc chắn muốn xóa mục này?')) {
                e.preventDefault();
            }
        });
    });

    // 2. Tự động ẩn thông báo sau 3 giây
    const alertMsg = document.querySelector('.alert');
    if (alertMsg) {
        setTimeout(() => {
            alertMsg.style.display = 'none';
        }, 3000);
    }

    // 3. Kiểm tra file trước khi upload
    const fileInput = document.querySelector('input[name="excel_file"]');
    const importForm = document.querySelector('form[enctype="multipart/form-data"]');
    if (importForm && fileInput) {
        importForm.addEventListener('submit', function(e) {
            if (fileInput.files.length === 0) {
                alert('Vui lòng chọn file Excel (.xlsx) trước!');
                e.preventDefault();
            }
        });
    }
});