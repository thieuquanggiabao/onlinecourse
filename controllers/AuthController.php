<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new Users($this->db);
    }

    // Hiển thị form Đăng nhập
    public function login() {
        $this->view('auth/login', ['pageTitle' => 'Đăng nhập']);
    }

    // Xử lý POST Đăng nhập
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            return;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Lấy người dùng theo email
        $user = $this->userModel->getUserByEmail($email);

        // Kiểm tra người dùng và mật khẩu
        if ($user && password_verify($password, $user['password'])) {
            // Đăng nhập thành công: Lưu thông tin vào session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['fullname'] = $user['fullname'];

            // Chuyển hướng theo vai trò
            if ($user['role'] == 2) { // Admin
                header('Location: /admin/dashboard');
            } elseif ($user['role'] == 1) { // Giảng viên
                header('Location: /instructor/dashboard');
            } else { // Học viên (hoặc mặc định)
                header('Location: /student/dashboard');
            }
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu không chính xác.';
            header('Location: /login');
        }
    }

    // Hiển thị form Đăng ký
    public function register() {
        $this->view('auth/register', ['pageTitle' => 'Đăng ký']);
    }
    
    // Xử lý POST Đăng ký
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            return;
        }
        
        // Lấy dữ liệu và Validation cơ bản
        $data = [
            'username' => trim($_POST['username']),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'password' => $_POST['password'],
            'fullname' => trim($_POST['fullname']),
            'role' => (isset($_POST['is_instructor']) ? 1 : 0) // Giả định có checkbox 'Đăng ký làm Giảng viên'
        ];

        // Mã hóa mật khẩu trước khi lưu
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($this->userModel->create($data)) {
            $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
            header('Location: /login');
        } else {
            $_SESSION['error'] = 'Đăng ký thất bại. Tên người dùng hoặc Email có thể đã tồn tại.';
            header('Location: /register');
        }
    }

    // Đăng xuất
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /');
    }

    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}