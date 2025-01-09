<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\Response;
use Config\App;

class Services extends BaseService
{
    public static function curlrequest(array $options = [], $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('curlrequest', $options);
        }

        $config = config(App::class);
        $uri = new URI();
        $response = new Response($config);

        return new CURLRequest($config, $uri, $response, $options);
    }
}