<?php
require_once 'user.php';

class UserRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function create(User $user){
        $sql = "INSERT INTO users(name,email,password) VALUES(?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            password_hash($user->getPassword(),PASSWORD_DEFAULT),
        ]);
    }

}