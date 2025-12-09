<?php
// Tải các Model cần thiết
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Course.php';

class HomeController {
    private $db;
    private $courseModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->courseModel = new Courses($this->db);
    }

    // Hiển thị Trang chủ
    public function index() {
        // Lấy một số khóa học nổi bật hoặc mới nhất để hiển thị trên trang chủ
        $courses = $this->courseModel->getFeaturedCourses(8); 

        // Nạp View Trang chủ
        $this->view('home/index', [
            'courses' => $courses,
            'pageTitle' => 'Trang chủ Khóa học Online'
        ]);
    }

    /**
     * Hàm trợ giúp nạp View và Layout
     */
    private function view($view, $data = []) {
        extract($data);
        
        // Giả định $data có chứa $pageTitle
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}