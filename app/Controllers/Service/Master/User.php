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
        if (empty($user)) return $this->failNotFound('Data tidak ditemukan');
    
        $response = [
            'count'   => count($user),
            'data'    => $user
        ];
    
        return $this->respond($response);
    }
    

    public function create()
    {
        helper(['form']);
        $rules = [
            'email'        => 'required',
            'password'     => 'required',
            'fullname'     => 'required',
            'user role id' => 'required',
        ];
        
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $userData = [
            'user_email'        => $this->request->getVar('email'),
            'user_password'     => $this->request->getVar('user_password'),
            'user_full_name'    => $this->request->getVar('user_full_name'),
            //'user_image'      => $this->request->getVar('user_image'),
            'user_description'  => $this->request->getVar('user_description'),
            'user_role_role_id' => $this->request->getVar('user_role_role_id'),
        ];
        
        //-------------------------------------------------------------------------------
        $this->user->insert($userData);
        //----------------------------------------------------------------------------------------
        $message = 'User created successfully!';
        $responseData = [
            'message'   => $message,
            'user_data' => $userData,
        ];
        //---------------------------------------------------------------------------------------------------
        return $this->respondCreated($responseData, $message);
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