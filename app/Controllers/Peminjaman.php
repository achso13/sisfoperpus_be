<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use CodeIgniter\API\ResponseTrait;

class Peminjaman extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();

        $data = $peminjamanModel->findAll();
        $total = $peminjamanModel->countAllResults();

        return $this->respond([
            'status' => 'success',
            'message' => 'Peminjaman berhasil ditemukan',
            'data' => [
                'total' => $total,
                'peminjaman' => $data
            ]
        ], 200);
    }

    public function show($id)
    {
        $peminjamanModel = new PeminjamanModel();

        $data = $peminjamanModel->find($id);

        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => 'Peminjaman berhasil ditemukan',
                'data' => $data
            ], 200);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Peminjaman tidak ditemukan',
                'error' => null
            ], 404);
        }
    }

    public function create()
    {
        $peminjamanModel = new PeminjamanModel();

        $data = [
            'id_buku' => $this->request->getVar('id_buku'),
            'id_anggota' => $this->request->getVar('id_anggota'),
        ];

        $rules = [
            'id_buku' => 'required|is_fk_value_exists[user]|is_unique[buku.id_buku.id_buku.id_buku]',
            'id_anggota' => 'required|is_fk_value_exists[user]|is_unique[anggota.id_anggota.id_anggota.id_anggota]',
        ];

        if ($this->validate($rules)) {
            if ($peminjamanModel->save($data)) {
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Peminjaman berhasil ditambahkan',
                    'data' => $data
                ], 200);
            }
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Peminjaman gagal ditambahkan',
                'error' => $this->validator->getErrors()
            ], 422);
        }
    }

    public function update($id)
    {
        $peminjamanModel = new PeminjamanModel();

        $peminjaman = $peminjamanModel->find($id);
        if (!$peminjaman) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Peminjaman tidak ditemukan',
                'error' => null
            ], 404);
        }

        $data = [
            'id_buku' => $this->request->getVar('id_buku'),
            'id_anggota' => $this->request->getVar('id_anggota'),
        ];

        $rules = [
            'id_buku' => 'required|is_fk_value_exists[user]|is_unique[buku.id_buku.id_buku.id_buku]',
            'id_anggota' => 'required|is_fk_value_exists[user]|is_unique[anggota.id_anggota.id_anggota.id_anggota]',
        ];

        if ($this->validate($rules)) {
            if ($peminjamanModel->update($id, $data)) {
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Peminjaman berhasil diupdate',
                    'data' => $data
                ], 200);
            }
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Peminjaman gagal diupdate',
                'error' => $this->validator->getErrors()
            ], 422);
        }
    }

    public function delete($id)
    {
        $peminjamanModel = new PeminjamanModel();

        if (!$peminjamanModel->find($id)) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Peminjaman tidak ditemukan',
                'error' => null
            ], 404);
        }

        if ($peminjamanModel->delete($id)) {
            return $this->respond([
                'status' => 'success',
                'message' => 'Peminjaman berhasil dihapus',
                'data' => [
                    'id' => $id,
                ]
            ], 200);
        }
    }
}