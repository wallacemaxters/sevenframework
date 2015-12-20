<?php

namespace WallaceMaxters\SevenFramework\Http;

use WallaceMaxters\SevenFramework\Exceptions\HttpException;

class Redirector extends Response
{
	public function __construct(string $location, int $statusCode = 302)
	{
		
		$this->setStatusCode($setStatusCode);

		$this->getHeader()->set('Location', $location);
	}

	public static function back()
	{	

		$location = $_SERVER['HTTP_REFERER'] ?? null;

		if ($location === null) {

			throw new HttpException('Cannot redirect to empty value');
		}

		return new static($location, $statusCode);
	}
}