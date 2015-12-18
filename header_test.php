<?php


include_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\SevenFramework\Http\Header;

$h = new Header;

// Teste ContenType
$h->setContentType('text/html', 'ISO-8859-1');

// Teste de Parse de nome de header
$h->set('X_POWERED_BY', 'PHP7');

// Teste de obtenção de nomes, com o parser
var_dump($h->get('x-powered-by'), $h->get('x_powered_by'), $h['x-POWERED_BY']);


// Testando expires com dateTime

$date = new DateTime('+3 days');

$h->setExpiresFromDateTime($date);


print_r($h);

// Teste ArrayAccess
$h['content-length'] = 0;


// Testando __toString
print_r($h->getAsArray());