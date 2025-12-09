<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Enrollment.php';

class EnrollmentController {
    private $db;
    private $enrollmentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->enrollmentModel = new Enrollments($this->db);
    }

    // Xử lý việc đăng ký khóa học
    public function enroll($course_id) {
        // Yêu cầu người dùng phải đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để đăng ký khóa học.';
            header('Location: /login');
            return;
        }

        $student_id = $_SESSION['user_id'];
        
        // Giả định logic kiểm tra giá/thanh toán đã hoàn tất
        
        if ($this->enrollmentModel->enrollStudent($course_id, $student_id)) {
            $_SESSION['success'] = 'Bạn đã đăng ký khóa học thành công!';
            header('Location: /student/my_courses');
        } else {
            $_SESSION['error'] = 'Đăng ký không thành công hoặc bạn đã đăng ký khóa học này rồi.';
            header('Location: /course/' . $course_id);
        }
    }
    
    // Hiển thị tiến trình học tập của học viên (Thường nằm trong StudentController)
    public function showProgress($enrollment_id) {
        // ... Logic để lấy thông tin chi tiết về tiến trình
    }
    
    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}