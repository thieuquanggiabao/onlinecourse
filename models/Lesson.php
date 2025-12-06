<?php
class Lessons{
    private $id;
    private $course_id;
    private $title;
    private $content;
    private $video_url;
    private $order;
    private $created_at;

    public function HamTao($id, $course_id, $title, $content, $video_url, $order, $created_at){
        $this->id = $id;
        $this->course_id = $course_id;
        $this->title = $title;
        $this->content = $content;
        $this->video_url = $video_url;
        $this->order = $order;
        $this->created_at = $created_at;
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

    // title
    public function setTitle($title){
        $this->title = $title;
    }
    public function getTitle(){
        return $this->title;
    }

    // content
    public function setContent($content){
        $this->content = $content;
    }
    public function getContent(){
        return $this->content;
    }

    // video_url
    public function setVideo_url($video_url){
        $this->video_url = $video_url;
    }
    public function getVideo_url(){
        return $this->video_url;
    }

    // order
    public function setOrder($order){
        $this->order = $order;
    }
    public function getOrder(){
        return $this->order;
    }

    // created_at
    public function setCreated_at($created_at){
        $this->created_at = $created_at;
    }
    public function getCreated_at(){
        return $this->created_at;
    }
}
?>
