<?php

namespace WallaceMaxters\SevenFramework\Controller;

use WallaceMaxters\SevenFramework\Http\Request;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
interface ControllerInterface
{
	public function setRequest(Request $request);

	public function getRequest(): Request;
}