<?php
class User {
    private int $id ;
    private string $name;
    private string $email;

    public function __construct($id,$name,$email){
    
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
        public function getId(){ return $this->id; }
        public function getName(){ return $this->name;}
        public function getEmail(){ return $this->email;}

}






 ?>