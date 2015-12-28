<?php

namespace WallaceMaxters\SevenFramework\Http\Exceptions;

class NotFoundException extends HttpException
{
	public function __construct($message)
	{
		parent::__construct($message, 404);
	}
}