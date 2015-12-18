<?php

include_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\SevenFramework\View\View;


//$view = new View('templates/index', ['nome' => 'wallace']);

$view = View::create('templates/index', ['nome' => 'wallace']);
 
echo $view->render();

