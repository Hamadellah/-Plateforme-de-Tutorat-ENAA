<?php

namespace Services;

use App\Repositories\UserRepository; 

class UserService {
    private $repo; 

    public function __construct($repo) {
        $this->repo = $repo;
    }
    public function login($email, $password) {
        $user = $this->repo->getUserByEmail($email);
        
        if (!$user) {
            return false;
        }
        if ($password === $user['password']) {
            return $user;
        }
        return false;
    }
}