<?php
class User {
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $role;

    public function __construct($id,$name,$email,$password,$role){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(){ return $this->id; }
    public function getName(){ return $this->name;}
    public function getEmail(){ return $this->email;}
    public function getPassword(){ return $this->password;}
    public function getRole(){ return $this->role;}
}