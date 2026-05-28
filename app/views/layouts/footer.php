    </div><!-- end page-content -->
</div><!-- end main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Format số tiền VND
function formatVND(n) {
    return new Intl.NumberFormat('vi-VN').format(n) + ' đ';
}
// Confirm xóa
function confirmDelete(url, name) {
    if(confirm('Xác nhận xóa: ' + name + '?')) window.location = url;
}
</script>
<?php if(isset($extra_js)) echo $extra_js; ?>
</body>
</html>
