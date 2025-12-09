<?php
class Database {
    // Thông số cấu hình Database (Mặc định của XAMPP)
    private $host = 'localhost';
    private $db_name = 'onlinecourse'; // Tên cơ sở dữ liệu bạn đã tạo
    private $username = 'root';        // User mặc định của XAMPP
    private $password = '';            // Mật khẩu mặc định của XAMPP (thường để trống)
    public $conn;

    /**
     * Phương thức kết nối đến cơ sở dữ liệu
     * @return PDO|null Trả về đối tượng kết nối PDO hoặc null nếu thất bại
     */
    public function connect() {
        $this->conn = null;

        try {
            // Chuỗi kết nối DSN (Data Source Name)
            // charset=utf8mb4 rất quan trọng để hiển thị đúng tiếng Việt
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";

            // Tạo đối tượng PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Thiết lập chế độ báo lỗi: Ném ra ngoại lệ (Exception) khi có lỗi SQL
            // Điều này giúp bắt lỗi dễ dàng hơn trong quá trình code (try-catch)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Thiết lập chế độ lấy dữ liệu mặc định là mảng kết hợp (Associative Array)
            // Ví dụ: $row['username'] thay vì $row[0]
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            // Nếu kết nối thất bại, hiển thị thông báo lỗi
            echo "Lỗi kết nối CSDL: " . $e->getMessage();
            die(); // Dừng chương trình
        }

        return $this->conn;
    }
}
?>