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

    public function findByEmail($email){
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data){
            return new User(
                $data['id'],
                $data['name'],
                $data['email'],
                $data['password']
            );
        }
        return null;
    }
}