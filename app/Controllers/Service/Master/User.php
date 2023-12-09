<?php

namespace App\Controllers\Service\Master;

use App\Models\UserModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class User extends ResourceController
{
    use ResponseTrait;

    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    
    public function index()
    {
        $user = $this->user->findAll();
        if(!$user)
        {
            $response = [
                'message'   => 'Data tidak ditemukan',
                'count'     => count($user),
                'data'      => []
            ];

            return $this->respond($response);
        }

        $response = [
            'message'   => 'Data ditemukan',
            'count'     => count($user),
            'data'      => $user
        ];

        return $this->respond($response);
       
    }

  
    public function show($id = null)
    {
        $id_user = $this->request->getGet('id_user');
        if ($id_user === null) return $this->fail('Parameter id_user is required', 400);
    
        $user = $this->user->where('user_id', $id ?? $id_user)->findAll();
    
        // Check if user data is found
        if (empty($user)) {
            return $this->failNotFound('Data tidak ditemukan');
        }
    
        $response = [
            'message' => 'Data ditemukan',
            'count'   => count($user),
            'data'    => $user
        ];
    
        return $this->respond($response);
    }
    
 
    public function new()
    {
        //
    }

    public function create()
    {
        //
    }

   
    public function edit($id = null)
    {
        //
    }

  
    public function update($id = null)
    {
        //
    }

  
    public function delete($id = null)
    {
        //
    }
}