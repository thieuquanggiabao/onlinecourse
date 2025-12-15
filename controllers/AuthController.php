<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        
        // SỬA 1: Đảm bảo tên class là 'User' (khớp với file models/User.php)
        $this->userModel = new Users($this->db);
    }

    // Hiển thị form Đăng nhập
    public function login() {
        // Kiểm tra nếu đã đăng nhập thì đá về trang chủ/dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectUser($_SESSION['role']);
        }
        $this->view('auth/login', ['pageTitle' => 'Đăng nhập']);
    }

    // Xử lý POST Đăng nhập
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // SỬA 2: Chuyển hướng về đúng router
            header('Location: index.php?controller=auth&action=login');
            return;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Lấy người dùng theo email
        $user = $this->userModel->getUserByEmail($email);

        // Kiểm tra người dùng và mật khẩu
        if ($user && $password == $user['password']) {
            // Đăng nhập thành công: Lưu thông tin vào session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];

            // SỬA 3: Gọi hàm chuyển hướng chuẩn
            $this->redirectUser($user['role']);
            
        } else {
            // Đăng nhập thất bại
            // SỬA 4: Truyền tham số error để View hiển thị thông báo
            header('Location: index.php?controller=auth&action=login&error=failed');
        }
    }

    // Hiển thị form Đăng ký
    public function register() {
        $this->view('auth/register', ['pageTitle' => 'Đăng ký']);
    }
    
    // Xử lý POST Đăng ký
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=auth&action=register');
            return;
        }
        
        // Lấy dữ liệu
        $data = [
            'username' => trim($_POST['username']),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'password' => $_POST['password'],
            'fullname' => trim($_POST['fullname']),
            'role' => 0 // Mặc định là Học viên. Nếu muốn test Giảng viên thì sửa thành 1
        ];

        
        

        if ($this->userModel->create($data)) {
            // SỬA 5: Chuyển hướng kèm thông báo success
            header('Location: index.php?controller=auth&action=login&status=success');
        } else {
            // SỬA 6: Chuyển hướng kèm thông báo lỗi
            header('Location: index.php?controller=auth&action=register&error=exists');
        }
    }

    // Đăng xuất
    public function logout() {
        session_unset();
        session_destroy();
        // SỬA 7: Về trang chủ đúng cách
        header('Location: index.php');
    }

    // Hàm phụ: Chuyển hướng người dùng dựa theo Role
    private function redirectUser($role) {
        if ($role == 2) { // Admin
            header('Location: index.php?controller=admin&action=dashboard');
        } elseif ($role == 1) { // Giảng viên
            header('Location: index.php?controller=instructor&action=dashboard');
        } else { // Học viên
            header('Location: index.php'); // Hoặc index.php?controller=student&action=dashboard
        }
        exit();
    }

    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}