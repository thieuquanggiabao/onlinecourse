<?php
class Enrollments{
    private $id;
    private $course_id;
    private $student_id;
    private $enrolled_date;
    private $status;
    private $progress;
    private $conn;
    private $table = 'enrollments';
    public function HamTao($id, $course_id, $student_id, $enrolled_date, $status, $progress){
        $this->id = $id;
        $this->course_id = $course_id;
        $this->student_id = $student_id;
        $this->enrolled_date = $enrolled_date;
        $this->status = $status;
        $this->progress = $progress;
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

    // course_id
    public function setCourse_id($course_id){
        $this->course_id = $course_id;
    }
    public function getCourse_id(){
        return $this->course_id;
    }

    // student_id
    public function setStudent_id($student_id){
        $this->student_id = $student_id;
    }
    public function getStudent_id(){
        return $this->student_id;
    }

    // enrolled_date
    public function setEnrolled_date($enrolled_date){
        $this->enrolled_date = $enrolled_date;
    }
    public function getEnrolled_date(){
        return $this->enrolled_date;
    }

    // status
    public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }

    // progress
    public function setProgress($progress){
        $this->progress = $progress;
    }
    public function getProgress(){
        return $this->progress;
    }
    public function isEnrolled($course_id, $student_id) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE course_id = :course_id AND student_id = :student_id 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':student_id', $student_id);

        $stmt->execute();

        // Nếu rowCount > 0 nghĩa là tìm thấy bản ghi -> Đã đăng ký
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
    public function enrollStudent($course_id, $student_id) {
        // Trước tiên kiểm tra xem đã đăng ký chưa để tránh trùng lặp
        if ($this->isEnrolled($course_id, $student_id)) {
            return false; 
        }

        $query = "INSERT INTO " . $this->table . " 
                  (course_id, student_id, enrolled_date, status, progress) 
                  VALUES (:course_id, :student_id, NOW(), 'active', 0)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':student_id', $student_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
