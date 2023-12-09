<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends ResourceController
{
    use ResponseTrait;

    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
        //controller -------------------
        $this->token = new Token();
    }

    public function index()
    {
        helper(['form']);
        $rules = [
            'email'     => 'required|valid_email',
            'password'  => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());

        $user = $this->user->where('user_email', $this->request->getVar('email'))->first();

        if (!$user) return $this->failNotFound('Email Tidak Ditemukan');
        $password = $this->request->getVar('password');
        $passwordHash = $user['user_password'];

        if (!sha1($password, $passwordHash)) return $this->fail('Password salah!');
       
        $jwt = $this->token->index($user);

        return $this->respond($jwt);
    }


}