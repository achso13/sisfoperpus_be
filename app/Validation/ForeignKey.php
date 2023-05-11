<?php

namespace App\Validation;

class ForeignKey
{
    public function is_fk_value_exists(string $str = null, string $table, array $data, string &$error = null): bool
    {
        $db = \Config\Database::connect($data['DBGroup'] ?? null);
        $row = $db->table($table)->where('id', $str)->get()->getRowArray();

        if (!$row) {
            $error = lang("The value of $str in master table does not exist.");
            return false;
        }

        return true;
    }
}