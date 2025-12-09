<?php
// Tải các Model cần thiết cho Quản trị viên
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Course.php';
// ... (các Model khác cho báo cáo)

class AdminController {
    private $db;
    private $userModel;
    private $categoryModel;
    private $courseModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new Users($this->db);
        $this->categoryModel = new Categories($this->db);
        $this->courseModel = new Courses($this->db);
        
        // KHÔNG BAO GIỜ CHO PHÉP TRUY CẬP NẾU KHÔNG PHẢI ADMIN
        $this->checkAdminAccess();
    }
    
    private function checkAdminAccess() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang quản trị.';
            header('Location: /');
            exit();
        }
    }

    // Trang tổng quan Admin
    public function dashboard() {
        // Lấy số liệu thống kê cơ bản
        $totalUsers = $this->userModel->countAll();
        $totalCourses = $this->courseModel->countAll();
        // ...

        $this->view('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'pageTitle' => 'Dashboard Admin'
        ]);
    }

    // Quản lý Người dùng
    public function manageUsers() {
        $users = $this->userModel->getAllUsers();
        $this->view('admin/users/manage', [
            'users' => $users,
            'pageTitle' => 'Quản lý Người dùng'
        ]);
    }
    
    // Thêm danh mục
    public function createCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            
            if ($this->categoryModel->create($name, $description)) {
                $_SESSION['success'] = 'Tạo danh mục thành công.';
                header('Location: /admin/categories/list');
            } else {
                $_SESSION['error'] = 'Lỗi tạo danh mục.';
            }
        }
        $this->view('admin/categories/create', ['pageTitle' => 'Tạo Danh mục']);
    }

    // Liệt kê danh mục
    public function listCategories() {
        $categories = $this->categoryModel->getAll();
        $this->view('admin/categories/list', [
            'categories' => $categories,
            'pageTitle' => 'Danh sách Danh mục'
        ]);
    }
    
    // Báo cáo thống kê
    public function statistics() {
        // ... Logic lấy dữ liệu thống kê phức tạp (Doanh thu, số lượng đăng ký theo tháng, v.v.)
        $reports = []; // Giả định

        $this->view('admin/reports/statistics', [
            'reports' => $reports,
            'pageTitle' => 'Báo cáo & Thống kê'
        ]);
    }

    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}