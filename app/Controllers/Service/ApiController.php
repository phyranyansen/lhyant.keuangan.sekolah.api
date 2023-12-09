<?php

namespace App\Controllers\Service;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class ApiController extends ResourceController
{
    use ResponseTrait;

    public function sendRespond($status, $message, $data = [])
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        return $this->respond(
            $response,
            $status,
        );
    }
}