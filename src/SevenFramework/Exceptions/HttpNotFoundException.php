<?php

namespace WallaceMaxters\SevenFramework\Exceptions;

class HttpNotFoundException extends \Exception
{
	public function getFormatedMessage()
	{
		return '<pre style="color:#800">' . parent::getMessage() . '</pre>';
	}
}