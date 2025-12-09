<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Enrollment.php';

class CourseController {
    private $db;
    private $courseModel;
    private $lessonModel;
    private $enrollmentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->courseModel = new Courses($this->db);
        $this->lessonModel = new Lessons($this->db);
        $this->enrollmentModel = new Enrollments($this->db);
    }

    // Trang liệt kê tất cả khóa học
    public function index() {
        $courses = $this->courseModel->getAllCourses();
        
        $this->view('courses/index', [
            'courses' => $courses,
            'pageTitle' => 'Tất cả Khóa học'
        ]);
    }

    // Trang chi tiết khóa học
    public function detail($id) {
        $course = $this->courseModel->getId($id);
        if (!$course) {
            $this->view('errors/404', ['pageTitle' => 'Không tìm thấy']);
            return;
        }
        
        $lessons = $this->lessonModel->getAllByCourseId($id);
        $is_enrolled = isset($_SESSION['user_id']) ? $this->enrollmentModel->isEnrolled($id, $_SESSION['user_id']) : false;

        $this->view('courses/detail', [
            'course' => $course,
            'lessons' => $lessons,
            'is_enrolled' => $is_enrolled,
            'pageTitle' => $course['title']
        ]);
    }

    // Trang tìm kiếm khóa học
    public function search() {
        $keyword = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
        $courses = [];
        if (!empty($keyword)) {
            $courses = $this->courseModel->searchCourses($keyword);
        }
        
        $this->view('courses/search', [
            'keyword' => $keyword,
            'courses' => $courses,
            'pageTitle' => 'Kết quả tìm kiếm'
        ]);
    }
    
    // Giảng viên tạo/chỉnh sửa khóa học: Các hàm này nên nằm trong InstructorController hoặc AdminController 
    // Nhưng vì cấu trúc của bạn có file này, ta sẽ giả định các action này dành cho người dùng public.
    // Nếu bạn muốn chia rõ Instructor/Admin, nên chuyển các chức năng CRUD khóa học sang InstructorController.
    
    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}