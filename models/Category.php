<?php
class Categories{
    private $id;
    private $name;
    private $description;
    private $created_at;
    private $conn;
    public function HamTao($id, $name, $description, $created_at){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->created_at = $created_at;
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

    // name
    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }

    // description
    public function setDescription($description){
        $this->description = $description;
    }
    public function getDescription(){
        return $this->description;
    }

    // created_at
    public function setCreated_at($created_at){
        $this->created_at = $created_at;
    }
    public function getCreated_at(){
        return $this->created_at;
    }
    public function getAll() {
        // Query lấy tất cả cột từ bảng categories
        $query = "SELECT * FROM categories ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        // Trả về mảng kết quả
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($name, $description) {
        $query = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu cơ bản
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
