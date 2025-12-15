<?php
// Nạp các Model cần thiết
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
// require_once __DIR__ . '/../models/Lesson.php'; // Bỏ comment khi bạn làm phần bài học

class InstructorController {
    private $db;
    private $courseModel;
    private $categoryModel;

    public function __construct() {
        // 1. Kiểm tra đăng nhập và quyền Giảng viên (Role = 1)
        // (Lưu ý: Role 1 là giảng viên, Role 2 là Admin theo quy ước ban đầu)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            // Nếu không phải giảng viên, đẩy về trang login hoặc trang chủ
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        // 2. Kết nối Database
        $database = new Database();
        $this->db = $database->connect();
        
        // 3. Khởi tạo Models
        $this->courseModel = new Courses($this->db);
        $this->categoryModel = new Categories($this->db);
    }

    // --- MẶC ĐỊNH: VÀO TRANG QUẢN LÝ ---
    public function index() {
        $this->manageCourse();
    }

    // --- 1. HIỂN THỊ DANH SÁCH KHÓA HỌC ---
    public function manageCourse() {
        $instructorId = $_SESSION['user_id'];
        // Gọi hàm lấy khóa học theo ID giảng viên (Cần thêm vào Model)
        $courses = $this->courseModel->getCoursesByInstructorId($instructorId);

        $this->view('instructor/course/manage', [
            'courses' => $courses,
            'pageTitle' => 'Quản lý khóa học'
        ]);
    }

    // --- 2. TẠO KHÓA HỌC MỚI (FORM) ---
    public function createCourse() {
        $categories = $this->categoryModel->getAll(); // Lấy danh mục để hiển thị select box
        
        $this->view('instructor/course/create', [
            'categories' => $categories,
            'pageTitle' => 'Tạo khóa học mới'
        ]);
    }

    // --- 3. XỬ LÝ LƯU KHÓA HỌC (POST) ---
    public function storeCourse() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ Form
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'category_id' => $_POST['category_id'],
                'instructor_id' => $_SESSION['user_id'], // Lấy ID từ session người đang đăng nhập
                'level' => $_POST['level'],
                'duration_weeks' => $_POST['duration_weeks'],
                'image' => ''
            ];

            // Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/uploads/courses/";
                // Tạo tên file duy nhất để tránh trùng
                $file_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $file_name;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $data['image'] = $file_name;
                }
            }

            // Gọi Model để lưu
            if ($this->courseModel->create($data)) {
                // Chuyển hướng về trang quản lý
                header('Location: index.php?controller=instructor&action=manageCourse');
            } else {
                echo "Lỗi khi tạo khóa học.";
            }
        }
    }

    // --- 4. SỬA KHÓA HỌC (FORM) ---
    public function editCourse($id) {
        // Lấy thông tin khóa học cũ
        $course = $this->courseModel->getById($id);

        // Kiểm tra quyền: Khóa học này có phải của giảng viên này không?
        if (!$course || $course['instructor_id'] != $_SESSION['user_id']) {
            die("Bạn không có quyền chỉnh sửa khóa học này.");
        }

        $categories = $this->categoryModel->getAll();

        $this->view('instructor/course/edit', [
            'course' => $course,
            'categories' => $categories,
            'pageTitle' => 'Chỉnh sửa khóa học'
        ]);
    }

    // --- 5. XỬ LÝ CẬP NHẬT (POST) ---
    public function updateCourse($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'category_id' => $_POST['category_id'],
                'level' => $_POST['level'],
                'duration_weeks' => $_POST['duration_weeks'],
                // Giữ lại ảnh cũ nếu không upload ảnh mới
                'image' => $_POST['current_image'] 
            ];

            // Nếu có upload ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/uploads/courses/";
                $file_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $target_dir . $file_name;
                
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $data['image'] = $file_name;
                }
            }

            if ($this->courseModel->update($id, $data)) {
                header('Location: index.php?controller=instructor&action=manageCourse');
            } else {
                echo "Lỗi khi cập nhật.";
            }
        }
    }

    // --- 6. XÓA KHÓA HỌC ---
    public function deleteCourse($id) {
        // Kiểm tra quyền sở hữu trước khi xóa
        $course = $this->courseModel->getById($id);
        if ($course && $course['instructor_id'] == $_SESSION['user_id']) {
            $this->courseModel->delete($id);
        }
        header('Location: index.php?controller=instructor&action=manageCourse');
    }

    // --- HÀM VIEW (Thay thế BaseController) ---
    private function view($viewPath, $data = []) {
        extract($data);
        // Chỉnh lại đường dẫn require cho đúng với cấu trúc thư mục của bạn
        // Vì file này nằm trong /controllers/, nên view nằm ở ../views/
        if (file_exists(__DIR__ . '/../views/' . $viewPath . '.php')) {
            require_once __DIR__ . '/../views/layouts/header.php';
            // Bạn có thể require sidebar ở đây nếu muốn
            require_once __DIR__ . '/../views/' . $viewPath . '.php';
            require_once __DIR__ . '/../views/layouts/footer.php';
        } else {
            die("View '$viewPath' not found!");
        }
    }
    // --- DASHBOARD (TRANG CHỦ GIẢNG VIÊN) ---
    public function dashboard() {
        $instructorId = $_SESSION['user_id'];
        
        // 1. Lấy danh sách khóa học để thống kê
        $courses = $this->courseModel->getCoursesByInstructorId($instructorId);
        
        // 2. Tính toán số liệu (Logic đơn giản)
        $totalCourses = count($courses);
        $totalStudents = 0; // Sau này sẽ query từ bảng enrollments
        $totalRevenue = 0; 
        
        // Giả lập tính toán doanh thu từ số lượng học viên (Demo logic)
        // Thực tế bạn cần query COUNT(enrollments) WHERE course_id IN (...)
        foreach ($courses as $c) {
            $fakeEnrollment = rand(0, 50); // Giả vờ mỗi khóa có 0-50 học viên
            $totalStudents += $fakeEnrollment;
            $totalRevenue += ($c['price'] * $fakeEnrollment);
        }

        // 3. Gọi View Dashboard
        $this->view('instructor/dashboard', [
            'courses' => $courses, // Truyền danh sách để hiện ở bảng "Khóa học mới nhất"
            'totalCourses' => $totalCourses,
            'totalStudents' => $totalStudents,
            'totalRevenue' => $totalRevenue,
            'pageTitle' => 'Dashboard Tổng quan'
        ]);
    }
}
?>