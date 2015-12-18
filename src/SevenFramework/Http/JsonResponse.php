<?php

namespace WallaceMaxters\SevenFramework\Http;

use WallaceMaxters\SevenFramework\TraitHelpers\CreateObjectTrait;

/**
 * @todo Resolver conflitos com o método static::create
 * */

class JsonResponse extends Response
{
	
	public function __construct($data, $statusCode = 200)
	{
		parent::__construct(json_encode($data), $statusCode);

		$header = new Header;

		$header->setContentType('application/json');

		$this->setHeader($header);
	}

}