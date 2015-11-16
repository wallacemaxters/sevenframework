<?php

error_reporting(-1);

include_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\SevenFramework\Routing\Route;
use WallaceMaxters\SevenFramework\Routing\Collection;
use WallaceMaxters\SevenFramework\Routing\Router;
use WallaceMaxters\SevenFramework\Routing\Dispatcher;
use WallaceMaxters\SevenFramework\Http\Request;
use WallaceMaxters\SevenFramework\View\View;

// Teste callable action
$r = new Route('teste/{num}', function (int $num = 0)
{
	$nome = mb_strtoupper($this->getQuery('nome'));

	$view = View::create('templates/index', ['nome' => $nome]);

	$view->getData()->offsetSet('nome', "Eu sou o número #{$num}");

	return $view;
});


$r->setFilters('maior_de_idade');

$request = new Request;

$collection = new Collection();

$collection->add($r);

$router = new Router($collection);

try {
	
	$router->dispatchToRoute($request)->send();

} catch (Exception $e) {

}



 