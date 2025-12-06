<?php
class Categories{
    private $id;
    private $name;
    private $description;
    private $created_at;

    public function HamTao($id, $name, $description, $created_at){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->created_at = $created_at;
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
}
?>
