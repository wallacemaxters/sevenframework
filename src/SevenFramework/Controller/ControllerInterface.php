<?php

namespace WallaceMaxters\SevenFramework\Controller;

use WallaceMaxters\SevenFramework\Http\{Request, Response};
use WallaceMaxters\SevenFramework\View\View;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
interface ControllerInterface
{
	public function setRequest(Request $request);

	public function getRequest(): Request;

	public function render(string $name, array $data = []): View;


}