<?php
class Material{
    private $id;
    private $lesson_id;
    private $filename;
    private $file_path;
    private $file_type;
    private $uploaded_at;

    public function HamTao($id, $lesson_id, $filename, $file_path, $file_type, $uploaded_at){
        $this->id = $id;
        $this->lesson_id = $lesson_id;
        $this->filename = $filename;
        $this->file_path = $file_path;
        $this->file_type = $file_type;
        $this->uploaded_at = $uploaded_at;
    }

    // id
    public function setID($id){
        $this->id = $id;
    }
    public function getID(){
        return $this->id;
    }

    // lesson_id
    public function setLesson_id($lesson_id){
        $this->lesson_id = $lesson_id;
    }
    public function getLesson_id(){
        return $this->lesson_id;
    }

    // filename
    public function setFilename($filename){
        $this->filename = $filename;
    }
    public function getFilename(){
        return $this->filename;
    }

    // file_path
    public function setFile_path($file_path){
        $this->file_path = $file_path;
    }
    public function getFile_path(){
        return $this->file_path;
    }

    // file_type
    public function setFile_type($file_type){
        $this->file_type = $file_type;
    }
    public function getFile_type(){
        return $this->file_type;
    }

    // uploaded_at
    public function setUploaded_at($uploaded_at){
        $this->uploaded_at = $uploaded_at;
    }
    public function getUploaded_at(){
        return $this->uploaded_at;
    }
}
?>
