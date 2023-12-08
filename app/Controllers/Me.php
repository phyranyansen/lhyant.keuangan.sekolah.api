<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Me extends ResourceController
{
   
   
    use ResponseTrait;
    public function index()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Token Authorized');
       
    
        $token = explode(' ', $header)[1];
        try {
           
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
            $response = [
                'id'    => $decoded->uid,
                'email' => $decoded->email
            ];
            
          return $this->respond($response);
        } catch (\Throwable $th) {
            return $this->fail('Invalid Token!');
        }

        
    }
    

}