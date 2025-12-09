<?php
class Users{
    private $id;
    private $username;
    private $email;
    private $password;
    private $fullname;
    private $role;
    private $created_at;
    private $conn;
    public function HamTao ($id, $username, $email, $password, $fullname, $role, $created_at){
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password =$password;
        $this->fullname =$fullname;
        $this->role= $role;
        $this->created_at = $created_at;
    }
    public function __construct($db) {
        $this->conn = $db;
    }
    //id
    public function setID($id){
        $this->id = $id;
    }
    public function getID(){
        return $this->id;
    }
    //username
    public function setUserName($username){
        $this->username = $username;
    }
    public function getUserName(){
        return $this->username;
    }
    //email
    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }
    //password
    public function setPassword($password){
        $this->password = $password;
    }
    public function getPassword(){
        return $this->password;
    }
    //fullname
    public function setFullname($fullname){
        $this->fullname = $fullname;
    }
    public function getFullname(){
        return $this->fullname;
    }
    //role
    public function setRole($role){
        $this->role = $role;
    }
    public function getRole(){
        return $this->role;
    }
    //created_at
    public function setCreated_at($created_at){
        $this->created_at = $created_at;
    }
    public function getCreated_at(){
        return $this->created_at;
    }
    public function countAll() {
        // Giả sử tên bảng của bạn là 'users'
        $query = "SELECT COUNT(*) as total FROM users";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }
    public function getAllUsers() {
        // Chỉ chọn các cột cần thiết, KHÔNG chọn password
        $query = "SELECT id, username, email, fullname, role, created_at 
                  FROM users 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        // Trả về mảng chứa tất cả các dòng kết quả
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUserByEmail($email) {
        // Query tìm user theo email
        // LIMIT 1 để đảm bảo chỉ lấy 1 bản ghi đầu tiên tìm thấy
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        
        // Gán giá trị tham số, làm sạch cơ bản để an toàn hơn
        // (Dù PDO đã chống SQL Injection, nhưng filter vẫn tốt)
        $email = htmlspecialchars(strip_tags($email));
        $stmt->bindParam(':email', $email);
        
        $stmt->execute();
        
        // Trả về kết quả dòng đầu tiên tìm được
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data) {
        // Câu lệnh SQL Insert
        $query = "INSERT INTO users (username, email, password, fullname, role) 
                  VALUES (:username, :email, :password, :fullname, :role)";
        
        // Chuẩn bị statement
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu (Tùy chọn, nhưng nên làm để tránh XSS khi hiển thị lại tên)
        $username = htmlspecialchars(strip_tags($data['username']));
        $email    = htmlspecialchars(strip_tags($data['email']));
        $fullname = htmlspecialchars(strip_tags($data['fullname']));
        
        // Lưu ý: Password nên được mã hóa Ở CONTROLLER trước khi truyền vào đây
        // hoặc mã hóa ngay tại đây nếu bạn muốn. 
        // Trong mẫu AuthController trước đó, tôi đã mã hóa ở Controller rồi.
        
        // Gán dữ liệu vào tham số (Bind params)
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $data['password']); // Mật khẩu đã hash
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':role', $data['role']);
        
        // Thực thi
        if ($stmt->execute()) {
            return true;
        }
        
        // Nếu có lỗi (ví dụ trùng email/username), có thể log lỗi ra
        // printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
?>