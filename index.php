<form target="meu_iframe">
  <input type="text" name="nome" />
  <input type="submit" />
</form>

<iframe name="meu_iframe">
<?php


print_r($_GET);


// include_once __DIR__ . '/vendor/autoload.php';


// use WallaceMaxters\SevenFramework\Routing\Route;
// use WallaceMaxters\SevenFramework\Routing\Collection as RouteCollection;


// #Route Test

// $route = (new Route('home/{str}/{num}', function () {

// }))->setMethod('POST');


// $rc = new RouteCollection;

// $rc->add($route);

// print_r($rc->find('home/teste/3'));
