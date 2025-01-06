<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services; // Tambahkan ini untuk mengakses Services dengan benar

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        $arr = explode(' ', $authHeader);

        // Validasi header Authorization
        if (count($arr) !== 2 || $arr[0] !== 'Bearer') {
            return Services::response()
                ->setJSON(['error' => 'Token not provided'])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }

        try {
            // Decode token JWT
            $decoded = JWT::decode($arr[1], new Key('itGDlDTd9TFgyaNwsY8NntPu0OdisipJk/4BCKMUEUY72tUGh51O5/bhnNCA7J/X/y4uLaz7neeWU4BpvF0IiQ==', 'HS256'));

            // Menyimpan data user yang terdekripsi ke request (opsional)
            $request->decodedUserData = (array) $decoded;
        } catch (\Exception $e) {
            return Services::response()
                ->setJSON(['error' => 'Invalid token: ' . $e->getMessage()])
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan setelah permintaan diproses
    }
}