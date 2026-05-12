<?php
class User {
    private int $id ;
    private string $name;
    private string $email;
    private string $password;

    public function __construct($id,$name,$email,$password){
    
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = password;
    }
        public function getId(){ return $this->id; }
        public function getName(){ return $this->name;}
        public function getEmail(){ return $this->email;}
        public function getPssword(){ return $this->password;}

}






 ?>