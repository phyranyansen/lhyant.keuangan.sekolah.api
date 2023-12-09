<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
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
        $expiration = time() +  86400;
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
        $token =  $this->request->getVar('token');
        $refreshToken = $this->request->getVar('refreshToken');
        //--------------------------------------
        $currentLoginToken = session()->get('token'); 
        $tokenExpTime      = session()->get('tokenExpTime'); 
        $refresh           = session()->get('refreshToken');
        $uid               = session()->get('user_id');
        
            //Cek token apakah valid atau tidak
            if($token != $currentLoginToken && $refreshToken != $refresh) return Services::response()
            ->setJSON(['message' => ['Invalid Token', 'Invalid refreshToken code']])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

            if($token != $currentLoginToken) return Services::response()
            ->setJSON(['message' => 'Invalid Token'])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

            if($refreshToken != $refresh) return Services::response()
            ->setJSON(['message' => 'Invalid refreshToken code'])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);

            //Cek token apakah masih time valid atau sudah tidak valid lagi
            if (time() <= strtotime($tokenExpTime)) {
                $result = new UserModel();
                $user = $result->find($uid);
                if (!$user) return $this->failNotFound('User not found');
                
                $jwt = $this->index($user);
                return $this->respond($jwt);
            } else {
                return $this->failUnauthorized('Token is still valid');
            }
            
      
      
    }

 
    
}