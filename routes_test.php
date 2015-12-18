<?php

error_reporting(-1);

include_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\SevenFramework\Routing\Route;
use WallaceMaxters\SevenFramework\Routing\Collection;
use WallaceMaxters\SevenFramework\Routing\Router;
use WallaceMaxters\SevenFramework\Routing\Dispatcher;
use WallaceMaxters\SevenFramework\Http\Request;
use WallaceMaxters\SevenFramework\View\View;


class Ctrl {

	public function teste()
	{
		return View::create('templates/index', ['nome' => 'wallace']);
	}
}


// Teste callable action
$r = new Route('teste/{num}', function (int $num)
{
	$nome = mb_strtoupper($this->getQuery('nome'));

	$view = View::create('templates/index', ['nome' => $nome]);

	$view->getData()->offsetSet('title', 'Título da página');

	return $view;
});

$request = new Request;

Dispatcher::create($request, $r)->call();

