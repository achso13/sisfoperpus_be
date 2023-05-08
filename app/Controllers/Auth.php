<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

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
            $response = [
                'status' => "error",
                'message' => 'Username atau password salah'];
            return $this->respond($response, 401);
        } 

        $token = generateToken($user);
        $response = [
            'status' => "success",
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
            ]
        ];
        return $this->respond($response, 200);
    }
}
