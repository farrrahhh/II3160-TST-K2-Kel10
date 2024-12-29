<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        $arr = explode(' ', $authHeader);
        if (count($arr) != 2 || $arr[0] != 'Bearer') {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Token not provided');
        }

        try {
            $decoded = JWT::decode($arr[1], new Key('itGDlDTd9TFgyaNwsY8NntPu0OdisipJk/4BCKMUEUY72tUGh51O5/bhnNCA7J/X/y4uLaz7neeWU4BpvF0IiQ==', 'HS256'));
            // Simpan data user yang terdekripsi ke request jika perlu
            $request->setGlobal('decoded_user_data', (array)$decoded);
        } catch (\Exception $e) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Invalid token');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan setelah permintaan diproses
    }
}