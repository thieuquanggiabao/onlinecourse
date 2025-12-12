<?php
class Courses{
    private $id;
    private $title;
    private $description;
    private $instructor_id;
    private $category_id;
    private $price;
    private $duration_weeks;
    private $level;
    private $image;
    private $created_at;
    private $updated_at;
    private $conn;
    public function HamTao($id, $title, $description, $instructor_id, $category_id, $price, $duration_weeks, $level, $image, $created_at, $updated_at){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->instructor_id = $instructor_id;
        $this->category_id = $category_id;
        $this->price = $price;
        $this->duration_weeks = $duration_weeks;
        $this->level = $level;
        $this->image = $image;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function __construct($db) {
        $this->conn = $db;
    }
    // id
    public function setID($id){
        $this->id = $id;
    }
    public function getID(){
        return $this->id;
    }

    // title
    public function setTitle($title){
        $this->title = $title;
    }
    public function getTitle(){
        return $this->title;
    }

    // description
    public function setDescription($description){
        $this->description = $description;
    }
    public function getDescription(){
        return $this->description;
    }

    // instructor_id
    public function setInstructor_id($instructor_id){
        $this->instructor_id = $instructor_id;
    }
    public function getInstructor_id(){
        return $this->instructor_id;
    }

    // category_id
    public function setCategory_id($category_id){
        $this->category_id = $category_id;
    }
    public function getCategory_id(){
        return $this->category_id;
    }

    // price
    public function setPrice($price){
        $this->price = $price;
    }
    public function getPrice(){
        return $this->price;
    }

    // duration_weeks
    public function setDuration_weeks($duration_weeks){
        $this->duration_weeks = $duration_weeks;
    }
    public function getDuration_weeks(){
        return $this->duration_weeks;
    }

    // level
    public function setLevel($level){
        $this->level = $level;
    }
    public function getLevel(){
        return $this->level;
    }

    // image
    public function setImage($image){
        $this->image = $image;
    }
    public function getImage(){
        return $this->image;
    }

    // created_at
    public function setCreated_at($created_at){
        $this->created_at = $created_at;
    }
    public function getCreated_at(){
        return $this->created_at;
    }

    // updated_at
    public function setUpdated_at($updated_at){
        $this->updated_at = $updated_at;
    }
    public function getUpdated_at(){
        return $this->updated_at;
    }
    public function countAll() {
        // Giả sử tên bảng của bạn là 'courses'
        $query = "SELECT COUNT(*) as total FROM courses";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }
    public function getAllCourses() {
        $query = "SELECT c.id, c.title, c.description, c.price, c.image, c.created_at,
                         u.fullname as instructor_name, 
                         cat.name as category_name
                  FROM courses c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchCourses($keyword) {
        // Tìm trong Title HOẶC Description
        // Kết hợp bảng users và categories để lấy tên hiển thị đẹp
        $query = "SELECT 
                    c.id, c.title, c.description, c.price, c.image, c.created_at,
                    u.fullname as instructor_name, 
                    cat.name as category_name
                  FROM courses c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.title LIKE :keyword OR c.description LIKE :keyword
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        
        // Thêm dấu % để tìm kiếm chuỗi con
        $searchTerm = "%" . $keyword . "%";
        
        $stmt->bindParam(':keyword', $searchTerm);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getFeaturedCourses($limit = 8) {
        // Query kết hợp bảng users và categories để lấy tên giảng viên và danh mục
        $query = "SELECT 
                    c.id, 
                    c.title, 
                    c.price, 
                    c.image, 
                    c.level,
                    c.duration_weeks,
                    u.fullname as instructor_name, 
                    cat.name as category_name
                  FROM 
                    courses c
                  LEFT JOIN 
                    users u ON c.instructor_id = u.id
                  LEFT JOIN 
                    categories cat ON c.category_id = cat.id
                  ORDER BY 
                    c.created_at DESC 
                  LIMIT :limit";

        $stmt = $this->conn->prepare($query);

        // Rất quan trọng: Với LIMIT trong PDO, phải tham số hóa kiểu INT
        // Nếu không có PDO::PARAM_INT, một số phiên bản MySQL sẽ báo lỗi cú pháp
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //
    public function getById($id) {
        $query = "SELECT 
                    c.*, 
                    u.fullname as instructor_name, 
                    cat.name as category_name
                  FROM 
                    courses c
                  LEFT JOIN 
                    users u ON c.instructor_id = u.id
                  LEFT JOIN 
                    categories cat ON c.category_id = cat.id
                  WHERE 
                    c.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        // Gán tham số
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        // Trả về một dòng duy nhất
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // lấy về các khóa học bởi giảng viên
    public function getCoursesByInstructorId($instructorId) {
        $query = "SELECT c.*, cat.name as category_name 
                FROM courses c
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.instructor_id = :instructorId
                ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':instructorId', $instructorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // tạo khóa học mới
    public function create($data) {
        $query = "INSERT INTO courses (title, description, price, category_id, instructor_id, level, duration_weeks, image) 
                VALUES (:title, :description, :price, :category_id, :instructor_id, :level, :duration_weeks, :image)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':category_id' => $data['category_id'],
            ':instructor_id' => $data['instructor_id'],
            ':level' => $data['level'],
            ':duration_weeks' => $data['duration_weeks'],
            ':image' => $data['image'] ?? null
        ]);
    }
    // cập nhật khóa học
    public function update($id, $data) {
        // Xây dựng câu query linh hoạt để có thể cập nhật cả ảnh hoặc không
        $setClauses = [];
        foreach ($data as $key => $value) {
            // Chỉ thêm vào setClauses những cột cần cập nhật
            if ($key != 'id' && $key != 'instructor_id') {
                $setClauses[] = "$key = :$key";
            }
        }
        
        $query = "UPDATE courses SET " . implode(', ', $setClauses) . ", updated_at = NOW() WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Gán tham số
        foreach ($data as $key => $value) {
            if ($key != 'id' && $key != 'instructor_id') {
                $stmt->bindValue(":$key", $value);
            }
        }
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    // xóa khóa học
    public function delete($id) {
        $query = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
