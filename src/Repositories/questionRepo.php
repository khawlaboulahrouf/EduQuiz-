<?php
require_once 'User.php';
class UserRepository{
    private PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function create(User $user){
        $sql = "INSERT INTO users(name,email,password)
        VALUSE(?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            Password_hash($user->getPassword(),PASSWORD_DEFAULT),
        ]);
    }
    public function findByEmail($email){
        $sql = "SELECT * FROM users  WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch();
    }
} 














?>