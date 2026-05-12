<?php
require_once 'User.php';
class UserRepository{
    private PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
} 














?>