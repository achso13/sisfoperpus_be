<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Kategori extends ResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format = 'json';

    public function index()
    {
        $data = $this->model->findAll();
        
        return $this->respond([
            'status' => 'success',
            'message' => 'data berhasil ditemukan',
            'data' => [
                'total' => count($this->model->findAll()),
                'kategori' => $data,
            ]
        ], 200);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if ($data) {
            return $this->respond([
                'status' => 'success',
                'message' => 'kategori berhasil ditemukan',
                'data' => [
                    'kategori' => $data
                ]
            ], 200);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'kategori tidak ditemukan',
                'error' => null
            ], 404);
        }
    }

    public function create()
    {
        $data = [
            'kategori' => $this->request->getVar('kategori'),
        ];

        $rules = [
            'kategori' => 'required|is_unique[kategori.kategori]'
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Kategori gagal ditambahkan',
                'error' => $this->validator->getErrors()
            ], 422);
        } else {
            $this->model->insert($data);
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'data berhasil ditambahkan',
                'data' => [
                    'kategori' => [
                        'id' => $this->model->insertID(),
                        'nama_kategori' => $this->request->getVar('kategori'),
                    ]
                ]
            ], 200);
        }
    }


    public function update($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->respond([
                'status' => 'error',
                'message' => 'kategori tidak ditemukan',
                'error' => null
            ], 404);
        }

        $data = [
            'kategori' => $this->request->getVar('kategori'),
        ];

        $rules = [
            'kategori' => 'required|is_unique[kategori.kategori]'
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Kategori gagal ditambahkan',
                'error' => $this->validator->getErrors()
            ], 422);
        } else {
            $this->model->update($id, $data);
            return $this->respondUpdated([
                'status' => 'success',
                'message' => 'data berhasil diupdate',
                'data' => [
                    'kategori' => [
                        'id' => $id,
                        'nama_kategori' => $this->request->getVar('kategori'),
                    ]
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
                'status' => 'success',
                'data' => [
                    'id' => $id,
                    'nama_kategori' => $data['kategori'],
                ]
            ], 200);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'kategori tidak ditemukan',
                'error' => null
            ], 404);
        }
    }

    public function getBukuByKategori($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->respond([
                'status' => 'error',
                'message' => 'kategori tidak ditemukan',
                'error' => null
            ], 404);
        }

        $bukuModel = new \App\Models\BukuModel();
        $data = $this->model->find($id);
        
        if ($data) {
            $buku = $bukuModel->where('id_kategori', $id)->findAll();
            if (count($buku) > 0) {
                return $this->respond([
                    'status' => 'success',
                    'data' => [
                        'total' => count($buku),
                        'buku' => $buku
                    ]
                ], 200);
            } else {
                return $this->respond([
                    'status' => 'success',
                    'data' => [
                        'total' => count($buku),
                        'buku' => 'belum ada buku pada kategori ini'
                    ]
                ], 200);
            }
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'kategori tidak ditemukan',
                'error' => null
            ], 404);
        }
    }
}
