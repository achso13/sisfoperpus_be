<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Kategori extends ResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond([
            'status' => 'success',
            'count' => $this->model->countAll(),
            'data' => $this->model->findAll(),
        ], 200);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if ($data) {
            return $this->respond([
                'status' => 'success',
                'data' => [
                    'kategori' => [
                        'id' => $data['id'],
                        'nama_kategori' => $data['kategori'],
                        'created_at' => $data['created_at'],
                        'updated_at' => $data['updated_at'],
                    ]
                ]
            ], 200);
        } else {
            return $this->respond([
                'status' => 'fail',
                'message' => 'kategori tidak ditemukan',
            ], 400
            );
        }
    }

    public function create()
    {
        $data = [
            'kategori' => $this->request->getVar('kategori'),
        ];

        if (!$this->validate([
            'kategori' => 'required|is_unique[kategori.kategori]'
        ])) {
            return $this->respond([
                'status' => 'fail',
                'message' => 'Kategori gagal ditambahkan',
                'error' => $this->validator->getErrors()
            ], 400);
        }

        $this->model->insert($data);

        return $this->respondCreated([
            'status' => 'success',
            'message' => 'data berhasil ditambahkan',
            'data' => [
                'kategori' => [
                    'id' => $this->model->insertID(),
                    'nama_kategori' => $this->request->getVar('kategori'),
                ] 
            ],
        ]);

    }


    public function update($id = null)
    {
        $data = [
            'kategori' => $this->request->getVar('kategori'),
        ];

        if (!$this->validate([
            'kategori' => 'required|is_unique[kategori.kategori]'
        ])) {
            return $this->respond([
                'status' => 'fail',
                'message' => 'Kategori gagal diubah',
                'error' => $this->validator->getErrors()
            ], 400);
        }

        $this->model->update($id, $data);

        return $this->respondUpdated([
            'status' => 'success',
            'message' => 'data berhasil diubah',
            'data' => [
                'kategori' => [
                    'id' => $id,
                    'nama_kategori' => $this->request->getVar('kategori'),
                ] 
            ],
        ]);

    }

    public function delete($id = null)
    {
        $data = $this->model->find($id);

        if ($data) {
            $this->model->delete($id);
            return $this->respondDeleted([
                'status' => 'success',
                'data' => null,
            ]);
        } else {
            return $this->respond([
                'status' => 'fail',
                'message' => 'kategori tidak ditemukan'
            ], 400
            );
        }
    }

    public function getBukuByKategori($id = null)
    {
        $bukuModel = new \App\Models\BukuModel();
        $data = $this->model->find($id);
        
        if ($data) {
            $buku = $bukuModel->where('id_kategori', $id)->findAll();
            return $this->respond([
                'status' => 'success',
                'count' => count($buku),
                'data' => [
                    'buku' => $buku
                ]
            ], 200);
        } else {
            return $this->respond([
                'status' => 'fail',
                'message' => 'kategori tidak ditemukan',
            ], 400
            );
        }
    }

}
