<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Material.php';

class LessonController {
    private $db;
    private $lessonModel;
    private $enrollmentModel;
    private $materialModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->lessonModel = new Lessons($this->db);
        $this->enrollmentModel = new Enrollments($this->db);
        $this->materialModel = new Materials($this->db);
    }

    /**
     * Hiển thị chi tiết bài học cho học viên
     * URL ví dụ: /lessons/{lesson_id}
     * @param int $lesson_id ID của bài học
     */
    public function show($lesson_id) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem nội dung bài học.';
            header('Location: /login');
            return;
        }
        
        $lesson = $this->lessonModel->getId($lesson_id);

        if (!$lesson) {
            return $this->view('errors/404', ['pageTitle' => 'Bài học không tồn tại']);
        }
        
        $course_id = $lesson['course_id'];
        $student_id = $_SESSION['user_id'];
        
        // 1. Kiểm tra quyền: Đã đăng ký khóa học chưa
        if (!$this->enrollmentModel->isEnrolled($course_id, $student_id)) {
            $_SESSION['error'] = 'Bạn chưa đăng ký khóa học này.';
            header('Location: /course/' . $course_id);
            return;
        }
        
        // 2. Lấy danh sách tài liệu
        $materials = $this->materialModel->getAllByLessonId($lesson_id);
        
        // 3. (Tùy chọn) Cập nhật tiến trình học tập
        // $this->enrollmentModel->updateProgress($course_id, $student_id, $lesson_id);

        $this->view('student/lesson_view', [ // Giả định có view này cho học viên
            'lesson' => $lesson,
            'materials' => $materials,
            'pageTitle' => $lesson['title']
        ]);
    }
    
    // Chức năng CRUD Giảng viên/Admin: đã được đề cập trong câu trả lời trước và nên đặt trong một Controller chuyên biệt.

    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}