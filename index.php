<?php

error_reporting(-1);

include_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\SevenFramework\Routing\Route;
use WallaceMaxters\SevenFramework\Routing\Collection;
use WallaceMaxters\SevenFramework\Routing\Router;
use WallaceMaxters\SevenFramework\Routing\Dispatcher;
use WallaceMaxters\SevenFramework\Http\Request;
use WallaceMaxters\SevenFramework\View\View;
use WallaceMaxters\SevenFramework\Application\Application;
use WallaceMaxters\SevenFramework\Http\JsonResponse;
use WallaceMaxters\SevenFramework\Http\Response;
use WallaceMaxters\SevenFramework\Http\Redirector;


class BasicController extends \WallaceMaxters\SevenFramework\Controller\Controller
{
	public function getPage()
	{
		$request = $this->getRequest();

		$redirector = new Redirector($request);

		return $redirector->back();
	}
}

$router = new Router;

$router->addRoute(['*'], '/', function (string $name = '') : string
{
	$request = $this->getRequest();

	$upload = $request->getFiles();

	if ($upload->has('file')) {

		var_dump($file = $upload->get('file'));

		foreach($upload->get('file') as $file) {

			print_r($file);
		}
	}

	return $this->render('templates/index', ['nome' => $name]);
	
});

$router->get('/page', 'BasicController::getPage')->setName('basic.page');

$router->dispatchToRoute(new Request);

