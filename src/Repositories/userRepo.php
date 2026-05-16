<?php
require_once __DIR__ . '/../Entities/user.php';

class UserRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function create(User $user){
        $sql = "INSERT INTO users(name,email,password,role) VALUES(?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            password_hash($user->getPassword(),PASSWORD_DEFAULT),
            $user->getRole()
        ]);
    }

    public function findByEmail($email){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data){
            return new User(
                $data['id'],
                $data['name'],
                $data['email'],
                $data['password'],
                $data['role']
            );
        }
        return null;
    }
}