<?php
class Users{
    private $id;
    private $username;
    private $email;
    private $password;
    private $fullname;
    private $role;
    private $created_at;
    public function HamTao ($id, $username, $email, $password, $fullname, $role, $created_at){
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password =$password;
        $this->fullname =$fullname;
        $this->role= $role;
        $this->created_at = $created_at;
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
}
?>