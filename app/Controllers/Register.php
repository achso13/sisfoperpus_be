<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class Register extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $rules = [
            'username' => 'required|min_length[5]|max_length[20]|is_unique[user.username]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
            'email' => 'required|valid_email|is_unique[user.email]',
            'role' => 'required|in_list[ANGGOTA,ADMIN]'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();

            $userData = [
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                'email' => $this->request->getVar('email'),
                'role' => $this->request->getVar('role')
            ];

            $userModel->save($userData);

            return $this->respond([
                'status' => 200,
                'message' => 'User berhasil ditambahkan'
            ], 200);
        } else {
            $response = [
                'status' => 400,
                'error' => $this->validator->getErrors()
            ];

            return $this->respond($response, 400);
        }
    }
}
