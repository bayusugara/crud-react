<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;

class Users extends ResourceController
{
    use ResponseTrait;
    // get all product
    public function index()
    {
        $model = new UsersModel();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    // get single product
    public function show($id = null)
    {
        $model = new UsersModel();
        $data = $model->find($id);
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    // create a product
    public function create()
    {
        $model = new UsersModel();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'umur' => $this->request->getPost('umur'),
            'nohp' => $this->request->getPost('nohp')
        ];
        $data = json_decode(file_get_contents("php://input"));
        //$data = $this->request->getPost();
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];

        return $this->respondCreated($response, 201);
    }

    // update product
    public function update($id = null)
    {
        $model = new UsersModel();
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'nama' => $json->nama,
                'alamat' => $json->alamat,
                'umur' => $json->umur,
                'nohp' => $json->nohp
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'nama' => $input['nama'],
                'alamat' => $input['alamat'],
                'umur' => $input['umur'],
                'nohp' => $input['nohp']
            ];
        }
        // Insert to Database
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Updated'
            ]
        ];
        return $this->respond($response);
    }

    // delete product
    public function delete($id = null)
    {
        $model = new UsersModel();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
