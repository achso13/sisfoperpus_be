<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Peminjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_buku' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_anggota' => [
                'type' => 'INT',
                'unsigned' => true,
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
       $this->forge->addForeignKey('id_buku', 'buku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_anggota', 'anggota', 'id', 'CASCADE', 'CASCADE');
       $this->forge->createTable('peminjaman');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman');
    }
}
