// Format so tien VND
function formatVND(n) {
    return new Intl.NumberFormat('vi-VN').format(n) + ' đ';
}

// Confirm xoa
function confirmDelete(url, name) {
    if (confirm('Bạn có chắc muốn xóa: ' + name + '?')) {
        window.location.href = url;
    }
}

// Auto hide alert sau 4s
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.querySelectorAll('.alert.alert-success').forEach(function(el) {
            var bsAlert = new bootstrap.Alert(el);
            bsAlert.close();
        });
    }, 4000);
});
