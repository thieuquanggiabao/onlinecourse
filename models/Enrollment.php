<?php
class Enrollments{
    private $id;
    private $course_id;
    private $student_id;
    private $enrolled_date;
    private $status;
    private $progress;

    public function HamTao($id, $course_id, $student_id, $enrolled_date, $status, $progress){
        $this->id = $id;
        $this->course_id = $course_id;
        $this->student_id = $student_id;
        $this->enrolled_date = $enrolled_date;
        $this->status = $status;
        $this->progress = $progress;
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
}
?>
