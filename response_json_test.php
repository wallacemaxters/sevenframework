<?php

include_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\SevenFramework\Http\JsonResponse;


$json = JsonResponse::create(['nome' => 'wallace']);


$json->send();

