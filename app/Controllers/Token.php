<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token extends BaseController
{


    use ResponseTrait;

    public function index($user)
    {
        $key = getenv('TOKEN_SECRET');
    
        // Waktu expired 1 jam
        $expiration = time() +  3600;
        $expirationDateTime = new \DateTime('@' . $expiration);
        $expirationDateTime->setTimezone(new \DateTimeZone('Asia/Jakarta'));
        $expirationString = $expirationDateTime->format('Y-m-d\TH:i:s.u\Z');
    
        //random code for refresh
        $refreshToken = bin2hex(random_bytes(32));

        $payload = [
            'tokenExpTime'   => $expirationString,
            'refreshToken'   => $refreshToken, 
            'uid'            => $user['user_id'],
            'email'          => $user['user_email']
        ];
    
        $jwt = JWT::encode($payload, $key, 'HS256');
        $response = [
            'token'          => $jwt,
            'tokenExpTime'   => $expirationString,
            'refreshToken'   => $refreshToken, 
            'user_id'        => $user['user_id']
        ];

        session()->set($response);
    
        return $response;
    }

    

    public function refreshToken()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) return $this->failUnauthorized('Token Authorization');
       
    
        $token = explode(' ', $header)[1];
        try {
           
        $decoded = JWT::decode($token, new Key($key, 'HS256'));
              
            //Cek token apakah masih valid atau sudah tidak valid lagi
          
            if (time() <= strtotime($decoded->tokenExpTime)) {
                $user = $this->user->find($decoded->uid);
                if (!$user) return $this->failNotFound('User not found');
                
                $jwt = $this->generateToken($user);

                return $this->respond($jwt);
            } else {
                $debug = [
                    'now'   => time(),
                    'expTime' => strtotime($decoded->tokenExpTime)
                ];
                print_r($debug);
                return $this->failUnauthorized('Token is still valid');
            }
            
        } catch (\Throwable $th) {
            return $this->fail('Invalid Token!');
        }
      
    }

    // protected function generateToken($user)
    // {
      
    // }
    
}