<?php
// 1. Khởi động Session
session_start();

// 2. Gán cứng thông tin Giảng viên vào Session
// (Giả vờ như người dùng ID=1 đã đăng nhập thành công)
$_SESSION['user_id'] = 1;        // ID của user trong database (đảm bảo ID này tồn tại và là Giảng viên)
$_SESSION['role'] = 1;           // 1 = Giảng viên
$_SESSION['fullname'] = 'Giảng viên Test';
$_SESSION['email'] = 'giabao@gmail.com';

// 3. Chuyển hướng ngay lập tức vào trang Quản lý Khóa học
header('Location: index.php?controller=instructor&action=manageCourse');
exit();
?>