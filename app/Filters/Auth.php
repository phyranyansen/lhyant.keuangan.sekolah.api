<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class Auth implements FilterInterface
{
    
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = getenv('TOKEN_SECRET');
        $header = $request->getServer('REDIRECT_HTTP_AUTHORIZATION');
        if(!$header) {
            return Services::response()
                ->setJSON(['message' => 'Token Unauthorized'])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        $token = explode('Bearer ', $header)[1];
        $currentLoginToken = session()->get('token'); 

        try {
            if($token != $currentLoginToken) return Services::response()
            ->setJSON(['message' => 'Invalid Token'])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            
          JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Throwable $th) {
            return Services::response()
            ->setJSON(['message' => 'Invalid Token', 'detail' => $th])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}