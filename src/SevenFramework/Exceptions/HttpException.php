<?php

namespace WallaceMaxters\SevenFramework\Exceptions;

class HttpException extends \Exception
{
	public function getFormatedMessage()
	{
		return '<pre style="color:#800">' . parent::getMessage() . '</pre>';
	}
}