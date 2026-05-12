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


}






 ?>