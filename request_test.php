<?php


include_once __DIR__ . '/vendor/autoload.php';


use WallaceMaxters\SevenFramework\Http\Request;
use WallaceMaxters\SevenFramework\Http\Header;


$r = new Request;

$r->setHeader(new Header);

print_r($r);

var_dump($r->getMethod());

var_dump($r->getQuery('test', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY));

var_dump($r->getQuery('nome'));

