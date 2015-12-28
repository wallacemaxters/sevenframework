<?php

namespace WallaceMaxters\SevenFramework\Http;

use WallaceMaxters\SevenFramework\Http\Exceptions\HttpException;

class Redirector extends Response
{

	protected $request;

	public function __construct()
	{
		$this->setStatusCode(302);
	}

	public function to(string $location)
	{
		$this->getHeader()->set('Location', $location);

		return $this;
	}
}