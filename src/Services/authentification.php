<?php
session_start();

class Auth {
    private UserRepository $repo;

    public function __construct(UserRepository $repo){
        $this->repo = $repo;
    }

    public function login($email,$password){
        $user = $this->repo->findByEmail($email);

        if($user && password_verify($password,$user->getPassword())){
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'role' => $user->getRole()
            ];
            return true;
        }
        return false;
    }

    public function check(){
        return isset($_SESSION['user']);
    }
}