<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'role' => [
                'type' => 'enum',
                'constraint' => '"ANGGOTA", "ADMIN"'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
       ]);

       $this->forge->addKey('id', true);
       $this->forge->createTable('user');
    }

    public function down()
    {
        //
        $this->forge->dropTable('user');
    }
}
