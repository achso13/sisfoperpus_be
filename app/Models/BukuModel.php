<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bukus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $protectFields    = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
