<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $anggotaModel = new AnggotaModel();

        $data = $anggotaModel->findAll();
        $total = $anggotaModel->countAll();

        return $this->respond([
            'status' => 'success',
            'message' => 'Anggota berhasil ditemukan',
            'data' => [
                "total" => $total,
                "anggota" => $data
            ]
        ], 200);
    }

    public function show($id)
    {
        $anggotaModel = new AnggotaModel();

        $data = $anggotaModel->find($id);

        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => 'Anggota berhasil ditemukan',
                'data' => $data
            ], 200);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan',
                'error' => null
            ], 404);
        }
    }

    public function create()
    {
        $anggotaModel = new AnggotaModel();

        $data = [
            'id_user' => $this->request->getVar('id_user'),
            'nama' => $this->request->getVar('nama'),
        ];

        $rules = [
            'id_user' => 'required|is_fk_value_exists[user]|is_unique[anggota.id_user.id_user.id_user]',
            'nama' => 'required|min_length[3]|max_length[255]',
        ];

        if ($this->validate($rules)) {
            if ($anggotaModel->save($data)) {
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Anggota berhasil ditambahkan',
                    'data' => $data
                ], 200);
            }
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Anggota gagal ditambahkan',
                'error' => $this->validator->getErrors()
            ], 422);
        }
    }

    public function update($id)
    {
        $anggotaModel = new AnggotaModel();

        $anggota = $anggotaModel->find($id);
        if (!$anggota) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan',
                'error' => null
            ], 404);
        }

        $data = [
            'id_user' => $this->request->getVar('id_user'),
            'nama' => $this->request->getVar('nama'),
        ];

        $rules = [
            'id_user' => 'required|is_fk_value_exists[user]|is_unique[anggota.id_user,id_user,' . $data['id_user'] . ']',
            'nama' => 'required|min_length[3]|max_length[255]',
        ];

        if ($this->validate($rules)) {
            if ($anggotaModel->update($id, $data)) {
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Anggota berhasil diupdate',
                    'data' => $data
                ], 200);
            }
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Anggota gagal diupdate',
                'error' => $this->validator->getErrors()
            ], 422);
        }
    }

    public function delete($id)
    {
        $anggotaModel = new AnggotaModel();

        if (!$anggotaModel->find($id)) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan',
                'error' => null
            ], 404);
        }

        if ($anggotaModel->delete($id)) {
            return $this->respond([
                'status' => 'success',
                'message' => 'Anggota berhasil dihapus',
                'data' => [
                    'userId' => $id,
                ]
            ], 200);
        }
    }

    public function peminjaman($id)
    {
        $anggotaModel = new AnggotaModel();
        $peminjamanModel = new PeminjamanModel();

        $data = $anggotaModel->find($id);

        if ($data) {
            $peminjaman = $peminjamanModel->where('id_anggota', $id)->findAll();
            $total = $peminjamanModel->where('id_anggota', $id)->countAllResults();
            return $this->respond([
                'status' => 'success',
                'message' => 'Peminjaman berhasil ditemukan',
                'data' => [
                    'total' => $total,
                    'peminjaman' => $peminjaman
                ]
            ], 200);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Anggota tidak ditemukan',
                'error' => null
            ], 404);
        }
    }
}