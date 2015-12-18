<?php

error_reporting(-1);

include_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\SevenFramework\Routing\Route;
use WallaceMaxters\SevenFramework\Routing\Collection;
use WallaceMaxters\SevenFramework\Routing\Router;
use WallaceMaxters\SevenFramework\Routing\Dispatcher;
use WallaceMaxters\SevenFramework\Http\Request;
use WallaceMaxters\SevenFramework\View\View;
use WallaceMaxters\SevenFramework\Http\HttpKernel;
use WallaceMaxters\SevenFramework\Application\Application;
use WallaceMaxters\SevenFramework\Http\JsonResponse;
use WallaceMaxters\SevenFramework\Http\Response;


$router = new Router;

$request = new Request;

$router->addRoute(['*'], '/', function () use($request)
{
	return Response::json([
		'teste'               => 'testando',
		$request->getMethod() => $_POST
	]);
});

$router->dispatchToRoute($request)->send();
