<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    use ResponseTrait;

    public function register()
    {
        $rules = [
            'username' => 'required|min_length[5]|max_length[20]|is_unique[user.username]',
            'password' => 'required|min_length[8]|max_length[255]',
            'email' => 'required|valid_email|is_unique[user.email]',
            'role' => 'required|in_list[ANGGOTA,ADMIN]'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();

            $userData = [
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'email' => $this->request->getVar('email'),
                'role' => $this->request->getVar('role')
            ];

            $userModel->save($userData);

            return $this->respond([
                'status' => 'success',
                'message' => 'User berhasil ditambahkan',
                'data' => [
                    'user_id' => $userModel->getInsertID()
                ]

            ], 200);

        } else {
            $response = [
                'status' => 'failed',
                'message' => 'User gagal ditambahkan',
                'error' => $this->validator->getErrors()
            ];

            return $this->respond($response, 400);
        }
    }
}
