<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Buku extends ResourceController
{
    protected $modelName = 'App\Models\BukuModel';
    protected $format    = 'json';

    public function index()
    {
        $data = $this->model->findAll();

        return $this->respond([
            'status' => "success",
            'message' => 'Buku berhasil ditemukan',
            'data' => [
                'total' => count($data),
                'buku' => $data
            ]
        ], 200);
    }

    public function show($id = null)
    {
        $data = $this->model->getWhere(['id' => $id])->getResult();

        if ($data) {
            return $this->respond([
                'status' => "success",
                'messages' => 'Buku berhasil ditemukan',
                'data' => [
                    'buku' => $data
                ] 
            ], 200);
        } else {
            return $this->respond([
                'status' => 'error',
                'messages' => 'Buku tidak ditemukan',
                'error' => null
            ], 404);
        }
    }

    public function create()
    {
        $data = [
            'id_kategori' => $this->request->getVar('id_kategori'),
            'nama_buku' => $this->request->getVar('nama_buku'),
        ];

        $rules = [
            'id_kategori' => 'required|is_not_unique[kategori.id]',
            'nama_buku' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => 'error',
                'messages' => 'Buku gagal ditambahkan',
                'error' => $this->validator->getErrors()
            ], 422);
        } else {
            $this->model->insert($data);

            return $this->respondCreated([
                'status' => 'success',
                'messages' => 'Buku berhasil ditambahkan',
                'data' => [
                    'buku' => $data
                ]
            ], 200);
        }
    }

    public function update($id = null)
    {
        if ($this->model->find($id) == null) {
            return $this->respond([
                'status' => 'error',
                'messages' => 'Buku tidak ditemukan',
                'error' => null
            ], 404);
        }

        $data = [
            'id_kategori' => $this->request->getVar('id_kategori'),
            'nama_buku' => $this->request->getVar('nama_buku'),
        ];

        $rules = [
            'id_kategori' => 'required|is_not_unique[kategori.id]',
            'nama_buku' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => 'error',
                'messages' => 'Buku gagal diupdate',
                'error' => $this->validator->getErrors()
            ], 422);
        } else {
            $this->model->update($id, $data);

            return $this->respondUpdated([
                'status' => 'success',
                'messages' => 'Buku berhasil diupdate',
                'data' => [
                    'buku' => $data
                ]
            ], 200);
        }
    }

    public function delete($id = null)
    {
        $data = $this->model->find($id);

        if ($data) {
            $this->model->delete($id);
            return $this->respondDeleted([
                'status' => 200,
                'messages' => 'Buku berhasil dihapus',
                'data' => [
                    'buku' => $data
                ]
            ], 200);
        } else {
            return $this->respond([
                'status' => 'error',
                'messages' => 'Buku tidak ditemukan',
                'error' => null
            ], 404);
        }
    }
}
