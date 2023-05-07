<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        //
        $data = [
            'username' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'email' => 'admin@perpus.com',
            'role' => 'ADMIN',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('user')->insert($data);
    }
}
