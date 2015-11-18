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
use WallaceMaxters\SevenFramework\Http\JsonResponse;


HttpKernel::create()->routes(function ($router)
{

	$router->get('/', function ()
	{
		return "Página inicial";
	});

	$router->get('/teste', function ()
	{
		return "Meu pequeno teste";
	});

	$router->get('/teste/{num}', function (int $int)
	{
		return "Testando o parâmetro de número #{$int}";
	});

	$router->get('/json', function ()
	{
		return new JsonResponse([
			'framework' => 'SevenFramework - A framework for PHP 7'
		]);
	});

	$router->get('/view', function ()
	{
		return View::create('templates/index', ['nome' => 'SevenFramework']);
	});


	$router->get('{tudo}', function (string $date)
	{
		return new JsonResponse(func_get_args());
	});
})
->run();
 