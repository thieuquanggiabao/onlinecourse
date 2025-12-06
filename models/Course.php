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
}
?>
