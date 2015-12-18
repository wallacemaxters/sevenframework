<?php

include_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\SevenFramework\Http\Response;


$request = new Response();

$h = $request->getHeader();

// Testando headers
$h['X_CLIENT'] = 'Wallace de Souza';

$h['X_POWERED_BY'] = 'WallaceMaxters\\SevenFramework';

$h->setContentType('text/html');

$request->setStatusCode(404);

$text = sprintf('<h1>The response is %s</h1>', $request->getStatusCode())
		. print_r($h, true);

$request->setContent($text);

$request->send();


$x = new stdClass;

$x->func = function () { return 'teste'; };


echo ($x->func)();