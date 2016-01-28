<?php

namespace WallaceMaxters\SevenFramework\Http\Exceptions;

class HttpException extends \RuntimeException
{

	protected $statusCode;

	public function __construct(string $message, int $statusCode = 500)
	{

		if ($message == '') {

			$message = Response::REASON_PHRASES[$statusCode];
		}

		parent::__construct($message);

		$this->statusCode = $statusCode;
	}

	public function getStatusCode() : int
	{
		return $this->statusCode;
	}
}