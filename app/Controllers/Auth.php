<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Auth extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        $userModel = new \App\Models\UserModel();
         
        $data = [
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password')
        ];

        $user = $userModel->where('username', $data['username'])->first();

        if(!$user || !password_verify($data['password'], $user['password'])){
            return $this->fail('Username atau password salah', 401);
        } 

        $token = generateToken($user);
        return $this->respond([
            'message' => 'Login berhasil',
            'token' => $token
        ], 200);
    }
}
