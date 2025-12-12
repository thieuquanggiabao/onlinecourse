<?php
// 1. KHỞI ĐỘNG SESSION
// Bắt buộc phải có dòng này ở dòng đầu tiên để chức năng Đăng nhập/Đăng ký hoạt động
session_start();

// 2. THIẾT LẬP MÚI GIỜ
// Đặt múi giờ Việt Nam để thời gian (created_at) hiển thị đúng
date_default_timezone_set('Asia/Ho_Chi_Minh');

// 3. XỬ LÝ ĐỊNH TUYẾN (ROUTING)
// Lấy tên controller và action từ URL. Ví dụ: index.php?controller=course&action=detail
// Nếu không có, mặc định sẽ vào Home và trang Index.
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action     = isset($_GET['action']) ? $_GET['action'] : 'index';

// 4. CHUẨN HÓA TÊN CONTROLLER
// Ví dụ: nếu url là controller=course -> Tên file sẽ là CourseController.php
$controllerName = ucfirst($controller) . 'Controller'; // Viết hoa chữ cái đầu
$controllerFile = "./controllers/$controllerName.php"; // Đường dẫn file

// 5. KIỂM TRA VÀ GỌI FILE CONTROLLER
if (file_exists($controllerFile)) {
    // Nạp file controller
    require_once $controllerFile;

    // Kiểm tra xem class có tồn tại trong file đó không
    if (class_exists($controllerName)) {
        // Khởi tạo đối tượng Controller
        $object = new $controllerName();

        // Kiểm tra xem action (hàm) có tồn tại trong class đó không
        if (method_exists($object, $action)) {
            // Lấy tham số ID nếu có (Dùng cho các trang chi tiết, sửa, xóa. VD: &id=5)
            $id = isset($_GET['id']) ? $_GET['id'] : null;

            // Thực thi hành động
            if ($id !== null) {
                $object->$action($id); // Gọi hàm có tham số (VD: detail($id))
            } else {
                $object->$action();    // Gọi hàm không tham số (VD: index())
            }
        } else {
            // Nếu hàm không tồn tại
            die("Lỗi: Action '$action' không tồn tại trong Controller '$controllerName'.");
        }
    } else {
        // Nếu class không tồn tại
        die("Lỗi: Class '$controllerName' không được tìm thấy.");
    }
} else {
    // Nếu file controller không tồn tại -> Báo lỗi 404 hoặc chuyển về trang chủ
    // Bạn có thể tạo file views/errors/404.php để require vào đây cho đẹp
    echo "<h1>Lỗi 404: Trang bạn tìm kiếm không tồn tại!</h1>";
    echo "<p>File Controller '$controllerFile' không tìm thấy.</p>";
    echo "<a href='index.php'>Quay về trang chủ</a>";
}
?>